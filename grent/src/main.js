// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import App from './App'
import router from './router'
import RouterMiddleware, {createMiddleware} from 'vue-router-middleware'

Vue.config.productionTip = false
createMiddleware('require-auth', (args, to, from, next) => {
  if (localStorage.getItem('auth')) {
    next()
  } else {
    next('/Login')
  }
})
Vue.use(RouterMiddleware, {router})
/* eslint-disable no-new */
new Vue({
  el: '#app',
  router,
  template: '<App/>',
  components: { App }
})
