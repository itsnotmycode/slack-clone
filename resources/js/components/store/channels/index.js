import axios from 'axios';

export default {
  state: {
    channels: [],
    currentChannel: null,
  },

  actions: {
    async getAllChannels(ctx, query) {
      axios.get('/channels')
        .then((res) => {
          ctx.commit('updateChannels', res.data);
        });
    },
    async createChannel(ctx, query) {
      await axios.post('/channels/create', { params: query })
        .then((res) => {
          ctx.commit('updateCurrentChannel', res.data);
        });
    },
  },

  mutations: {
    updateChannels(state, payload) {
      state.channels = payload;
    },
    updateCurrentChannel(state, payload) {
      console.log(payload);
      state.currentChannel = payload;
    },
  },

  getters: {
    allChannels(state) {
      return state.channels;
    },
    directChannels(state) {
      return state.channels.filter((channel) => channel.user_channel);
    },
    groupChannels(state) {
      return state.channels.filter((channel) => !channel.user_channel);
    },
    currentChannel(state) {
      return state.currentChannel;
    },
  },
};
