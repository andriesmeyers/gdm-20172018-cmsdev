<template>
  <div class="logout">
      <div class="container">
      </div>
  </div>
</template><script>
export default {
  name: 'logout',
  mounted () {
    localStorage.clear()
    this.$router.push({name: 'Home'})
    this.$router.go(this.$router.currentRoute)
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
