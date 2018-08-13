<template>
  <div class="home h-100">
    <div class="header">
      <div class="overlay">
      </div>
      <div class="container">
        <div class="row">
          <div class="col-xl-8 text-left text-light">
            <h1 class="mb-5 text-uppercase">Dé nieuwe manier om je te verplaatsen in Gent</h1>
          </div>
          <div class="col-md-10 col-lg-8 col-xl-7 mx-auto">
            <button type="submit" class="btn btn-block btn-lg btn-success rounded-0">Registreer nu</button>
          </div>
        </div>
      </div>
    </div>
    <div class="mt-3">
        <section class="pl-2 pr-2" id="info">
          <div class="container">
            <div class="row text-left">
              <h1>{{ msg }}</h1>
            </div>
            <div class="row p-2">
              <div class="col-1 p-1 step-icon">
                1
              </div>
            </div>
            <div class="row text-left">
              <div class="col-12">
                <h4>Ga naar het dichtsbijzijnde station</h4>
                <p class="text-secondary text-left">
                  Selecteer uit 6 verschillende stations verdeeld over Gent.
                </p>
              </div>
            </div>
            <div class="row p-2">
              <div class="col-1 p-1 step-icon">
                2
              </div>
            </div>
            <div class="row text-left">
              <div class="col-12">
                <h4>Kies je wagen</h4>
                <p class="text-secondary text-left">
                  Kies uit meer dan 30 milieuvriendelijke wagens
                </p>
              </div>
            </div>
            <div class="row p-2">
              <div class="col-1 p-1 step-icon">
                3
              </div>
            </div>
            <div class="row text-left">
              <div class="col-12">
                <h4>Start je reis</h4>
                <p class="text-secondary text-left">
                  Open de wagen met de mobiele applicatie, maak je trip en parkeer nadien in één van de stations in Gent.
                </p>
              </div>
            </div>
            <div class="row p-2">
              <div class="col-1 p-1 step-icon">
                4
              </div>
            </div>
            <div class="row text-left">
              <div class="col-12">
                <h4>Betaal per minuut</h4>
                <p class="text-secondary text-left">
                  Beëindig de reis en betaal per minuut. Zorgeloos en geen benzinekosten!
                </p>
              </div>
            </div>
          </div>
        </section>
        <section class="mt-2 pt-2 text-left bg-light">
          <div class="container">
            <h1 class="text-left font-weight-bold">
              8 stations verspreid over Gent
            </h1>
            <h6>
              Grent beschikt over <b>meer dan 35 wagens</b> beschikbaar in onze stations
            </h6>
            <LeafletMap></LeafletMap>
          </div>
        </section>
    </div>
  </div>
</template>

<script>
import LeafletMap from '../components/LeafletMap'

export default {
  name: 'home',
  components: {
    LeafletMap
  },
  data () {
    return {
      msg: 'Jouw keuze, jouw vrijheid'
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
  background: url('../assets/header.jpeg') no-repeat center center;
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
