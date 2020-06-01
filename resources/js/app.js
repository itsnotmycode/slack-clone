import Vue from 'vue';
import VueRouter from 'vue-router';
import Vuetify from 'vuetify';
import router from './components/router';
import { store } from './components/store';

require('./bootstrap');
require('./components/bootstrap');

Vue.use(VueRouter);
Vue.use(Vuetify);

new Vue({
  router,
  store,
  vuetify: new Vuetify(),
  el: '#app',
});
