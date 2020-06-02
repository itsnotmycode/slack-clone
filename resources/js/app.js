import Vue from 'vue';
import VueRouter from 'vue-router';
import router from './components/router';
import { store } from './components/store';
import vuetify from './components/plugins/vuetify';


require('./bootstrap');
require('./components/bootstrap');

Vue.use(VueRouter);

Vue.component(
  'passport-clients',
  require('./components/passport/Clients.vue').default,
);

Vue.component(
  'passport-authorized-clients',
  require('./components/passport/AuthorizedClients.vue').default,
);

Vue.component(
  'passport-personal-access-tokens',
  require('./components/passport/PersonalAccessTokens.vue').default,
);

new Vue({
  router,
  store,
  vuetify,
  el: '#app',
});
