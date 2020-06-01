import Vue from 'vue';
import Vuex from 'vuex';

import channels from './channels';
import chat from './message';
import user from './user';

Vue.use(Vuex);

export const store = new Vuex.Store({
  modules: {
    channels, chat, user,
  },
});
