<template>
  <div class="myvehicles" v-if="rentals">
    <div class="header pt-3">
      <div class="overlay">
      </div>
      <div class="container header-title align-text-bottom">
        <div class="row">
          <div class="col-xl-8 text-left text-light">
            <h1 class="text-uppercase align-text-bottom">Mijn voertuigen</h1>
          </div>
        </div>
      </div>
    </div>
      <section id="info" class="mt-3 h-100">
        <div class="container">
          <div class="row">
            <div class="col-12 text-left">
              <div v-if="rentals.length > 0" class="list-group list-group-flush">
                <div v-for="rental in rentals" :key="rental.id" class="list-group-item list-group-item-action flex-column align-items-start">
                  <div class="list-group-image" v-bind:style="{ 'background': 'url(http://localhost:80' + rental.vehicle[0].field_model[0].field_image + ') no-repeat center center', 
                  'background-size': 'cover' }">
                  </div>
                  <p class="font-weight-bold mb-0">{{rental.vehicle[0].field_model[0].field_manufacturer}} {{rental.vehicle[0].field_model[0].name}}</p>
                  <p class="mb-1">{{rental.vehicle[0].license_plate}}</p>
                  <router-link tag="div" title="Wagen inleveren" class="vertical-middle" style="right: 10px;" :to="{ name: 'ReturnCar', params: { vehicleId: rental.vehicle[0].id, rentalId: rental.id  }}">
                    <i class="fas fa-sign-out-alt fa-2x"></i>
                  </router-link>
                </div>
              </div>
              <div v-else>
                <div class="alert alert-light">
                  Geen voertuigen gehuurd
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
  name: 'myvehicles',
  data () {
    return {
      rentals: null,
      modelLoaded: false
    }
  },
  created () {
    axios({
      method: 'GET',
      url: 'http://localhost:80/mobility/myvehicles/' + this.$parent.auth.uid + '?_format=json',
      withCredentials: true
    })
      .then(function (response) {
        this.rentals = response.data
        this.rentals.forEach(rental => {
          rental.vehicle = JSON.parse(rental.vehicle)
          axios({
            method: 'GET',
            url: 'http://localhost:80/mobility/models/' + rental.vehicle[0].field_model + '?_format=json',
            withCredentials: true
          })
            .then(function (response) {
              rental.vehicle[0].field_model = response.data
              this.$forceUpdate()
              this.modelLoaded = true
            }.bind(this))
        })
        this.$forceUpdate()
      }.bind(this))
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
  display: flex !important;
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
<style scoped>
.header{
  background: url('../assets/myvehicles.jpeg') no-repeat center center;
  position: relative;
  background-color: #343a40;
  -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;
  height: 250px;
  padding-top: 4rem;
  padding-bottom: 1rem;
}
</style>
