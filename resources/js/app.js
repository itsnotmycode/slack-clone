import Vue from 'vue';
import VueRouter from 'vue-router';
import router from './components/router';
import { store } from './components/store';
import vuetify from './components/plugins/vuetify';


require('./bootstrap');
require('./components/bootstrap');

Vue.use(VueRouter);

new Vue({
  router,
  store,
  vuetify,
  el: '#app',
});
