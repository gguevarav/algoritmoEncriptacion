import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from '../views/Home.vue'

import Encriptar from '../views/Encriptar'
import Desencriptar from '../views/Desencriptar'
import ListadoUsuarios from '../views/ListadoUsuarios'

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    name: 'home',
    component: Home
  },
  {
    path: '/encriptar',
    name: 'encriptar',
    component: Encriptar
  },
  {
    path: '/desencriptar',
    name: 'desencriptar',
    component: Desencriptar
  },
  {
    path: '/listadousuarios',
    name: 'listadousuarios',
    component: ListadoUsuarios
  },
  {
    path: '/about',
    name: 'about',
    // route level code-splitting
    // this generates a separate chunk (about.[hash].js) for this route
    // which is lazy-loaded when the route is visited.
    component: () => import(/* webpackChunkName: "about" */ '../views/About.vue')
  }
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

export default router
