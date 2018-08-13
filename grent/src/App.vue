<template>
  <div id="app">
    <nav class="navbar navbar-light navbar-expand-md bg-light fixed-top">
        <div class="container">
          <router-link to="/">
            <img src="./assets/logo.png" height="30" alt="">
          </router-link>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarsExampleDefault">
            <ul class="navbar-nav ml-auto">
              <router-link v-if="isAuthorized" class="nav-item" tag="li" :to="{ name: 'Locations'}">
                <a class="nav-link">Wagen huren</a>
              </router-link>
              <router-link v-if="isAuthorized" class="nav-item" tag="li" to="user/vehicles">
                <a class="nav-link">Wagen inleveren</a>
              </router-link>
              <li v-if="isAuthorized" class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="authDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{auth.name}}</a>
                <div class="dropdown-menu" aria-labelledby="authDropdown">
                  <router-link class="nav-item" tag="li" to="Logout">
                    <a class="nav-link">Afmelden</a>
                  </router-link>                  
                </div>
              </li>
              <router-link v-if="!isAuthorized" class="nav-item" tag="li" to="Login">
                <a class="nav-link">Aanmelden</a>
              </router-link>
              <router-link v-if="!isAuthorized" class="nav-item" tag="li" to="Register">
                <a class="nav-link">Register</a>
              </router-link>
            </ul>
          </div>
        </div>
      </nav>
    <main>
      <router-view></router-view>
    </main>
    <!-- Footer -->
<footer class="page-footer font-small blue mt-0 pt-4">

    <!-- Footer Links -->
    <div class="container-fluid text-center text-md-left">

      <!-- Grid row -->
      <div class="row">

        <!-- Grid column -->
        <div class="col-md-6 mt-md-0 mt-3">

          <!-- Content -->
          <h5 class="text-uppercase">Over Grent</h5>
          <p>Grent is een project in opdracht van de Arteveldehogeschool</p>

        </div>
        <!-- Grid column -->

        <hr class="clearfix w-100 d-md-none pb-3">

          <!-- Grid column -->
          <div class="col-md-3 mb-md-0 mb-3">

            <!-- Links -->
            <h5 class="text-uppercase">Social Media</h5>

            <ul class="list-unstyled">
              <li>
                <a href="#!"><i class="fab fa-facebook-square"></i></a>
              </li>
              <li>
                <a href="#!"><i class="fab fa-twitter"></i></a>
              </li>
              <li>
                <a href="#!"><i class="fab fa-instagram"></i></a>
              </li>
              <li>
                <a href="#!"><i class="fab fa-google-plus"></i></a>
              </li>
            </ul>

          </div>
          <!-- Grid column -->

      </div>
      <!-- Grid row -->

    </div>
    <!-- Footer Links -->

    <!-- Copyright -->
    <div class="footer-copyright text-center py-3">© 2018 Arteveldehogeschool
      <br>
      <a href="https://www.gdm.gent"> www.gdm.gent.com</a>
    </div>
    <!-- Copyright -->

  </footer>
  <!-- Footer -->
  </div>
</template>
<script>
require('../node_modules/bootstrap/dist/js/bootstrap.min.js')
export default {
  name: 'app',
  data () {
    return {
      isAuthorized: false,
      auth: null
    }
  },
  created () {
    if (localStorage.getItem('auth')) {
      this.isAuthorized = true
      this.auth = JSON.parse(localStorage.getItem('auth'))
    }
  }
}
</script>

<style lang="css">
@import '../node_modules/bootstrap/dist/css/bootstrap.min.css';
@import url('https://fonts.googleapis.com/css?family=Lato:300,400,700|Source+Sans+Pro:300,400,700');
@import url('https://use.fontawesome.com/releases/v5.2.0/css/all.css');
@import '../src/styles/app.css';
</style>

<style>
body {
  margin: 0;
}

#app {
  font-family: 'Avenir', Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  color: #2c3e50;
  display: flex;
  flex-direction: column;
}

main {
  text-align: center;
  flex: 1 0 auto;
}

header {
  margin: 0;
  height: 56px;
  padding: 0 16px 0 24px;
  background-color: #35495E;
  color: #ffffff;
}

header span {
  display: block;
  position: relative;
  font-size: 20px;
  line-height: 1;
  letter-spacing: .02em;
  font-weight: 400;
  box-sizing: border-box;
  padding-top: 16px;
}
</style>
