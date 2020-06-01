import axios from 'axios';

export default {
  state: {
    channels: [],
  },

  actions: {
    async getAllChannels(ctx, query) {
      axios.get('/channels')
        .then((res) => {
          ctx.commit('updateChannels', res.data);
        });
    },
  },

  mutations: {
    updateChannels(state, payload) {
      state.channels = payload;
    },
  },

  getters: {
    allChannels(state) {
      return state.channels;
    },
  },
};
