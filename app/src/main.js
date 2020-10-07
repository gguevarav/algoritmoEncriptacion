import Vue from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import vuetify from './plugins/vuetify'

import NavigationBar from './components/NavigationBar';
import AppBar from './components/AppBar';

Vue.component('NavigationBar', NavigationBar);
Vue.component('AppBar', AppBar);


Vue.config.productionTip = false

new Vue({
  router,
  store,
  vuetify,
  render: h => h(App)
}).$mount('#app')
