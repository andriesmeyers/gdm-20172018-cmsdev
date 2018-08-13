<template>
  <div class="rentcar flex-box" v-if="vehicle">
    <div class="header pt-3 h-100" v-bind:style="{ 'background': 'url(http://localhost:80' + this.vehicle.field_model[0].field_image + ') no-repeat center center', 
    'background-size': 'cover' }">
    <div style="position:absolute; z-index: 1000;">
      <a @click="$router.go(-1)" class="ml-3" style="color: rgb(255,255,255, 0.7)">
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
            <p class="text-secondary mb-0">{{this.vehicle.field_location}}
              <span class="text-success"><i class="fas fa-check"></i> Beschikbaar</span>
            </p>
          </div>
        </div>
        <hr>
      </div>
    </section>
    <section id="unlock-form" class="flex-box">
      <h3 v-if="!isRented" class="mb-0">Auto ontgrendelen</h3>
      <h3 v-else>Auto ontgrendeld!</h3>
      <div class="flex-box-content flex-box-center">
        <form v-if="!isRented" action="/" method="POST" @submit.prevent="submitForm">
          <button type="submit" id="completed-task" class="fa-button text-success">
            <i class="fas fa-lock fa-5x"></i>
          </button>
        </form>
        <div v-else class="text-success">
          <i class="fas fa-lock-open fa-5x"></i>
        </div>
      </div>
    </section>
    <section id="pricing" class="bg-light p-3">
      <div class="flex-box-content flex-box-center">
        <p>Door de wagen te ontgrendelen accepteert u de <a href="/termsandconditions">Algemene voorwaarden</a> 
        en zal u het bedrag van <b>{{this.vehicle.field_model[0].field_daily_hire_rate}}</b> / 24 uur van uw saldo gehaald worden.</p>
      </div>
    </section>
  </div>
</template>

<script>
const axios = require('axios')
export default {
  name: 'rentcar',
  data () {
    return {
      vehicle: null,
      isRented: false
    }
  },
  beforeCreate () {
    axios({
      method: 'GET',
      url: 'http://localhost:80/mobility/vehicles/' + this.$route.params.id + '?_format=json',
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
      this.rentVehicle(this.vehicle.id)
    },
    rentVehicle: function (vehicleId) {
      axios({
        method: 'POST',
        url: 'http://localhost:80/entity/vehicle_rental',
        withCredentials: true,
        headers: {'X-CSRF-Token': this.$parent.auth.token},
        data: {
          'field_customer': {
            'target_id': this.$parent.auth.uid
          },
          'field_vehicle': {
            'value': vehicleId
          }
        }
      }).then(function (response) {
        axios({
          method: 'PATCH',
          url: 'http://localhost:80/mobility/vehicle/' + vehicleId + '?_format=json',
          withCredentials: true,
          headers: {'X-CSRF-Token': this.$parent.auth.token},
          data: {
            'field_is_available': {
              'value': false
            }
          }
        }).then(function (response) {
          this.isRented = true
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
