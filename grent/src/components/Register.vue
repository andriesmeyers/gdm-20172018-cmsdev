<template>
  <div class="register">
      <div class="container">
          <div class="row mt-2">
              <div class="col-12">
                  <h1>Registreer</h1>
              </div>
          </div>
          <div class="row">
              <div class="col-12">
                    <form @submit="submitForm" action="/user/register" method="POST">
                        <p v-if="errors.length">
                            <b>Gelieve alles correct in te vullen:</b>
                            <ul>
                                <li v-for="error in errors">{{ error }}</li>
                            </ul>
                        </p>
                        <div class="form-group">
                            <label for="formEmailInput">E-mailadres</label>
                            <input v-model="email" type="email" class="form-control" id="formEmailInput" placeholder="Geef je e-mailadres in" required>
                        </div>
                        <div class="form-group">
                            <label for="inputName">Naam</label>
                            <input v-model="name" type="text" class="form-control" id="inputName" placeholder="Geef je naam in" required>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword">Wachtwoord</label>
                            <input v-model="password" type="password" class="form-control" id="inputPassword" placeholder="Geef je wachtwoord in" required>
                        </div>
                        <div class="form-group">
                            <label for="inputConfirmPassword">Bevestig uw wachtwoord</label>
                            <input v-model="confirmPassword" type="password" class="form-control" id="inputConfirmPassword" placeholder="Geef je wachtwoord nogmaals in" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Registreer</button>
                    </form>
              </div>
          </div>
      </div>
  </div>
</template>

<script>
const axios = require('axios')
export default {
  name: 'register',
  data: function () {
    return { errors: [],
      email: null,
      name: null,
      password: null,
      confirmPassword: null
    }
  },
  methods: {
    valRegisterForm: function () {
      if (this.name && this.password && this.password && this.confirmPassword) return true
      this.errors = []
      if (!this.name) this.errors.push('Gelieve een naam in te vullen.')
      if (!this.password) this.errors.push('Gelieve een wachtwoord in te vullen.')
      if (!this.confirmPassword) this.errors.push('Gelieve je wachtwoord te bevestigen.')
      if (this.confirmPassword !== this.password) this.errors.push('Wachtwoord komt niet overeen')
    },
    submitForm: function (e) {
      e.preventDefault()
      this.valRegisterForm()
      axios({
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        url: 'http://localhost:80/user/register?_format=json',
        data: {
          name: {
            'value': this.name
          },
          mail: {
            'value': this.email
          },
          pass: {
            'value': this.password
          }
        }
      })
        .then(this.$router.push({name: 'Home'}))
        .catch(error => this.errors.push(error))
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style>
h1,
h2 {
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
  color: #35495e;
}

.header {
  background: url("../assets/header.jpeg") no-repeat center center;
  position: relative;
  background-color: #343a40;
  -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;
  padding-top: 8rem;
  padding-bottom: 8rem;
}
.overlay {
  position: absolute;
  background-color: #212529;
  height: 100%;
  width: 100%;
  top: 0;
  left: 0;
  opacity: 0.3;
}
</style>
