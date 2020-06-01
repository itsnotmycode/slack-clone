import axios from 'axios';

export default {
  state: {
    messages: [],
  },

  actions: {
    getAllMessages(ctx) {
      axios.get('/channels/messages')
        .then((res) => {
          ctx.commit('updateMessage', res.data);
        });
    },
    sendMessage(ctx, query) {
      axios.post('/channels/messages', { params: query })
        .then((res) => console.log(res))
        .catch((err) => console.log(err));
    },
  },

  mutations: {
    updateMessage(state, payload) {
      state.messages = payload;
    },
  },

  getters: {
    getMessages(state) {
      return state.messages;
    },
  },
};
