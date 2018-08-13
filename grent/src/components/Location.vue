<template>
  <div class="location" v-if="location">
    <div class="header pt-3" v-bind:style="{ 'background': 'url(http://localhost:80' + this.location.field_image + ') no-repeat center center', 
    'background-size': 'cover' }">
    <div style="position:absolute; z-index: 1000;">
      <a href="/locations" class="ml-3" style="color: rgb(255,255,255, 0.7)">
        <i class="fas fa-chevron-left fa-lg"></i>
      </a>
    </div>
      <div class="overlay">
      </div>
      <div class="container header-title align-text-bottom">
        <div class="row">
          <div class="col-xl-8 text-left text-light">
            <h1 class="text-uppercase align-text-bottom">{{this.location.name}}</h1>
          </div>
        </div>
      </div>
    </div>
      <section id="info" class="mt-3 h-100">
        <div class="container">
          <div class="row text-left">
            <div class="col">
              <h5 class="font-weight-bold">Wagens</h5>
            </div>
          </div>
          <div class="row">
            <div class="col-12 text-left">
              <div v-if="location.vehicles.length > 0" class="list-group list-group-flush">
                <router-link v-for="vehicle in location.vehicles" :key="vehicle.id" class="list-group-item list-group-item-action flex-column align-items-start"
                    :to="{ name: 'Vehicle', params: { id: vehicle.id }}">
                  <div class="list-group-image" v-bind:style="{ 'background': 'url(http://localhost:80' + vehicle.field_model[0].field_image + ') no-repeat center center', 
                  'background-size': 'cover' }">
                  </div>
                  <p class="font-weight-bold mb-0">{{vehicle.field_model[0].field_manufacturer}} {{vehicle.field_model[0].name}}</p>
                  <p class="mb-1">{{vehicle.license_plate}}</p>
                  <span>{{vehicle.field_engine_size}}</span>
                  <div class="float-right">
                    <small class="font-weight-bold text-right">{{vehicle.field_model[0].field_daily_hire_rate}}</small>
                    <small class="text-secondary">/ uur</small>
                  </div>
                </router-link>
              </div>
              <div v-else>
                <div class="alert alert-light">
                  Geen wagens beschikbaar in dit station
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
  </div>
</template>

<script>
const axios = require('axios')
export default {
  name: 'location',
  data () {
    return {
      location: null
    }
  },
  created () {
    axios({
      method: 'GET',
      url: 'http://localhost:80/mobility/locations/' + this.$route.params.id + '?_format=json',
      withCredentials: true
    })
      .then(response => {
        this.location = response.data[0]
        this.location.vehicles.forEach(vehicle => {
          axios({
            method: 'GET',
            url: 'http://localhost:80/mobility/models/' + vehicle.field_model + '?_format=json',
            withCredentials: true
          })
            .then(function (response) {
              vehicle.field_model = response.data
              this.$forceUpdate()
            }.bind(this))
        })
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
  min-height: 100%;
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
  background-size: cover;
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
</style>
