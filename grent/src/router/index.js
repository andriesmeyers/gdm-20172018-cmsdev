import Vue from 'vue'
import Router from 'vue-router'
import Home from '@/components/Home'
import Register from '@/components/Register'
import Login from '@/components/Login'
import Logout from '@/components/Logout'
import Location from '@/components/Location'
import Locations from '@/components/Locations'
import Vehicle from '@/components/Vehicle'
import RentCar from '@/components/RentCar'
import ReturnCar from '@/components/ReturnCar'
import MyVehicles from '@/components/MyVehicles'
import { middleware } from 'vue-router-middleware'

Vue.use(Router)

export default new Router({
  mode: 'history',
  routes: [
    {
      path: '/',
      name: 'Home',
      component: Home
    },
    {
      path: '/register',
      name: 'Register',
      component: Register
    },
    {
      path: '/login',
      name: 'Login',
      component: Login
    },
    ...middleware('require-auth', [
      {
        path: '/logout',
        name: 'Logout',
        component: Logout
      },
      {
        path: '/locations',
        name: 'Locations',
        component: Locations
      },
      {
        path: '/locations/:id',
        name: 'Location',
        component: Location
      },
      {
        path: '/vehicles/:id',
        name: 'Vehicle',
        component: Vehicle
      },
      {
        path: '/vehicles/rent/:id',
        name: 'RentCar',
        component: RentCar
      },
      {
        path: '/user/vehicles',
        name: 'MyVehicles',
        component: MyVehicles
      },
      {
        path: '/user/vehicles/return/:vehicleId/:rentalId',
        name: 'ReturnCar',
        component: ReturnCar
      }
    ])
  ],
  scrollBehavior () {
    return {x: 0, y: 0}
  }
})
