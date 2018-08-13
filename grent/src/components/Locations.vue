<template>
  <div class="locations">
    <div class="header">
      <div class="overlay">
      </div>
      <div class="container">
        <div class="row">
          <div class="col-xl-8 text-left text-light">
            <h1 class="mb-5 text-uppercase">{{msg}}</h1>
          </div>
        </div>
      </div>
    </div>
    <section class="pl-2 pr-2 mt-3 h-100" id="info">
      <div class="container">
        <div class="row text-left">
          <div class="col">
            <h5 class="font-weight-bold">Locaties</h5>
          </div>
        </div>
        <div class="row">
          <div class="col-12 text-left">
            <div class="list-group list-group-flush">
              <router-link v-for="location in locations" :key="location.id" class="list-group-item list-group-item-action flex-column align-items-start" 
              :to="{ name: 'Location', params: { id: location.id }}">
                <div class="d-flex w-100 justify-content-between">
                  <h5 class="mb-1">{{location.name}}</h5>
                  <small>{{location.distance}} km</small>
                </div>
              </router-link>
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
  name: 'locations',
  data () {
    return {
      locations: null,
      msg: '6 stations verspreid over Gent'
    }
  },
  beforeCreate () {
    axios.get('http://localhost:80/mobility/locations?_format=json').then((response) => {
      this.locations = response.data
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(this.Userlocation)
      }
    })
  },
  methods: {
    Userlocation: function (position) {
      this.nearestLocation(position.coords.latitude, position.coords.longitude)
      this.locations.sort(function (a, b) {
        return a.distance - b.distance
      })
    },
    nearestLocation: function (latitude, longitude) {
      for (var index = 0; index < this.locations.length; ++index) {
        var dif = this.pythagorasEquirectangular(latitude, longitude, this.locations[index].field_latitude, this.locations[index].field_longtitude)
        this.locations[index].distance = dif.toFixed(2)
      }
    },
    pythagorasEquirectangular: function (lat1, lon1, lat2, lon2) {
      lat1 = this.deg2Rad(lat1)
      lat2 = this.deg2Rad(lat2)
      lon1 = this.deg2Rad(lon1)
      lon2 = this.deg2Rad(lon2)
      var R = 6371
      var x = (lon2 - lon1) * Math.cos((lat1 + lat2) / 2)
      var y = (lat2 - lat1)
      var d = Math.sqrt(x * x + y * y) * R
      return d
    },
    deg2Rad: function (deg) {
      return deg * Math.PI / 180
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

a {
  color: #35495E;
}
.header{
  background: url('../assets/parking.png') no-repeat center center;
  position: relative;
  background-color: #343a40;
  -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;
  padding-top: 8rem;
  padding-bottom: 8rem;
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
