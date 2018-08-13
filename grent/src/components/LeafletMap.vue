<template>
  <div class="map">
    <l-map style="height: 90%" :zoom="zoom" :center="center">
      <l-tile-layer :url="url" :attribution="attribution"></l-tile-layer>
      <l-marker v-for="location in locations" :key="location.id"
        :lat-lng="{lng: location.field_longtitude, lat: location.field_latitude}">
      </l-marker>
    </l-map>
  </div>
</template>
<style lang="css">
@import '../../node_modules/leaflet/dist/leaflet.css';
</style>
<script>
import L from 'leaflet'
import { LMap, LTileLayer, LMarker } from 'vue2-leaflet'

delete L.Icon.Default.prototype._getIconUrl

L.Icon.Default.mergeOptions({
  iconRetinaUrl: require('leaflet/dist/images/marker-icon-2x.png'),
  iconUrl: require('leaflet/dist/images/marker-icon.png'),
  shadowUrl: require('leaflet/dist/images/marker-shadow.png'),
  className: 'map-icon'
})
const axios = require('axios')

export default {
  name: 'leafletmap',
  components: {
    LMap,
    LTileLayer,
    LMarker
  },
  mounted () {
    axios.get('http://localhost:80/mobility/locations?_format=json').then((response) => {
      this.locations = response.data
    })
  },
  data () {
    return {
      zoom: 13,
      geojson: null,
      url: 'https://api.tiles.mapbox.com/v4/mapbox.light/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoibWJvdWNoYXVkIiwiYSI6ImNpdTA5bWw1azAyZDIyeXBqOWkxOGJ1dnkifQ.qha33VjEDTqcHQbibgHw3w',
      attribution: '',
      center: L.latLng(51.042059, 3.718131),
      locations: null
    }
  }
}
</script>
