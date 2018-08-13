<template>
  <div class="returncar flex-box" v-if="vehicle">
    <div class="header pt-3 h-100" v-bind:style="{ 'background': 'url(http://localhost:80' + this.vehicle.field_model[0].field_image + ') no-repeat center center', 
    'background-size': 'cover' }">
    <div style="position:absolute; z-index: 1000;">
      <a href="/user/vehicles" class="ml-3" style="color: rgb(255,255,255, 0.7)">
        <i class="fas fa-chevron-left fa-lg"></i>
      </a>
    </div>
      <div class="overlay">
      </div>
      <div class="container header-title align-text-bottom">
        <div class="row">
          <div class="col-xl-8 text-left text-light">
            <h1 class="text-uppercase align-text-bottom">{{this.vehicle.field_model[0].field_manufacturer}} {{this.vehicle.field_model[0].name}}</h1>
          </div>
        </div>
      </div>
    </div>
    <section id="info" class="pt-4">
      <div class="container">
        <div class="row text-left">
          <div class="col">
            <h4 class="font-weight-bold mb-2">{{this.vehicle.license_plate}}</h4>
          </div>
        </div>
        <hr>
      </div>
    </section>
    <section id="unlock-form" class="flex-box p-2">
        <h3 v-if="!isReturned" class="mb-0">Auto inleveren</h3>
        <h3 v-else>Auto vergrendeld en ingeleverd!</h3>
        <div class="flex-box-content flex-box-center">
          <form v-if="!isReturned" action="/" method="POST" @submit.prevent="submitForm">
            <button type="submit" id="completed-task" class="fa-button text-success">
              <i class="fas fa-parking fa-5x"></i>
            </button>
          </form>
          <div v-else class="text-success">
            <i class="fas fa-check fa-5x"></i>
          </div>
        </div>
    </section>
    <section id="pricing" class="bg-light p-3">
      <div class="flex-box-content flex-box-center">
        <p>Gelieve te controleren dat u <b>geen persoonlijke bezittingen</b> heeft achtergelaten in de wagen. 
            Na inlevering zal deze vergrendeld worden en heeft u geen toegang meer tot het voertuig. </p>
      </div>
    </section>
  </div>
</template>

<script>
const axios = require('axios')
const moment = require('moment')
export default {
  name: 'returncar',
  data () {
    return {
      vehicle: null,
      isReturned: false,
      locationsLength: 0
    }
  },
  beforeCreate () {
    axios({
      method: 'GET',
      url: 'http://localhost:80/mobility/vehicles/' + this.$route.params.vehicleId + '?_format=json',
      withCredentials: true
    })
      .then(response => {
        this.vehicle = response.data[0]
        axios({
          method: 'GET',
          url: 'http://localhost:80/mobility/models/' + this.vehicle.field_model + '?_format=json',
          withCredentials: true
        })
          .then(function (response) {
            this.vehicle.field_model = response.data
            this.modelLoaded = true
            this.$forceUpdate()
          }.bind(this))
      })
  },
  methods: {
    submitForm: function () {
      this.returnVehicle(this.vehicle.id)
    },
    returnVehicle: function (vehicleId) {
      console.log('test')
      axios.get('http://localhost:80/mobility/locations?_format=json').then(function (response) {
        this.locationsLength = response.data.length
        axios({
          method: 'PATCH',
          url: 'http://localhost:80/mobility/vehicle_rental/' + this.$route.params.rentalId + '?_format=json',
          withCredentials: true,
          headers: {'X-CSRF-Token': this.$parent.auth.token},
          data: {
            'field_to': {
              'value': moment().format('Y-MM-DDTH:mm:ss')
            }
          }
        }).then(function (response) {
          console.log(vehicleId)
          axios({
            method: 'PATCH',
            url: 'http://localhost:80/mobility/vehicle/' + vehicleId + '?_format=json',
            withCredentials: true,
            headers: {'X-CSRF-Token': this.$parent.auth.token},
            data: {
              'field_is_available': {
                'value': true
              },
              'field_location': {
                'target_id': Math.floor(Math.random() * this.locationsLength) + 1
              }
            }
          })
            .then(function () {
              this.isReturned = true
            }.bind(this))
        }.bind(this))
      }.bind(this))
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style>
h1, h2 {
  font-weight: normal;
}

ul {
  list-style-type: none;
  padding: 0;
}

li {
  display: inline-block;
  margin: 0 10px;
}
main{
  height: 100% !important;
}
nav{
  display: none !important;
}
.header{
  position: relative;
  background-color: #343a40;
  -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover !important;
  height: 200px;
  padding-top: 4rem;
  padding-bottom: 1rem;
}
.header-title{
  position: absolute;
  bottom: 0;
}
.overlay{
  position: absolute;
  background-color: #212529;
  height: 100%;
  width: 100%;
  top: 0;
  left: 0;
  opacity: .3;
}
.rent-button{
  padding: 5px;
  position: relative;
  width: 100%;
  height: 40px;
  bottom: 0;
}
</style>
<style scoped>
nav{
  display: none !important;
}
</style>