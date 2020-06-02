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
      console.log(query);
      axios.post('/channels/messages', { message: query.message, channel_id: query.channel_id })
        .then((res) => console.log(res))
        .catch((err) => console.log(err));
    },
  },

  mutations: {
    updateMessage(state, payload) {
      state.messages = payload;
    },
    addMessage(state, message) {
      state.messages.push(message);
    },
  },

  getters: {
    getMessages(state) {
      return state.messages;
    },
  },
};
