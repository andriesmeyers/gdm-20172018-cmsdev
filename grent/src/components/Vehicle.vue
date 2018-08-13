<template>
  <div class="vehicle flex-box" v-if="vehicle">
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
              <span v-if="vehicle.field_is_available == 'true'" class="text-success"><i class="fas fa-check"></i>Beschikbaar</span>
              <span v-else class="text-danger"><i class="fas fa-times"></i> Niet beschikbaar</span>
            </p>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-12 text-left">
            <h5 class="font-weight-bold">Kenmerken</h5>
            <p><b>Motor:</b> {{this.vehicle.field_engine_size}}</p>
            <p><b>Type:</b> {{this.vehicle.field_vehicle_type}}</p>
            <p><b>Kilometerstand:</b> {{this.vehicle.field_mileage}}</p>
            <p><b>Bouwjaar:</b> {{this.vehicle.field_model[0].field_bouwjaar}}</p>
          </div>
        </div>
      </div>
    </section>
    <section id="pricing" class="bg-light pt-2 h-100 flex-box">
      <div class="flex-box-content flex-box-center">
        <h3><b>{{this.vehicle.field_model[0].field_daily_hire_rate}}</b> / dag</h3>
      </div>
      <router-link v-if="vehicle.field_is_available == 'true'" class="rent-button bg-success text-white" tag="div"
          :to="{ name: 'RentCar', params: { id: vehicle.id }}">
          <h5>Huur wagen</h5>
      </router-link>
    </section>
  </div>
</template>

<script>
const axios = require('axios')
export default {
  name: 'vehicle',
  data () {
    return {
      vehicle: null,
      modelLoaded: false
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
