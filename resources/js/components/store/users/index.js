import axios from 'axios';

export default {
  state: {
    users: [],
  },

  actions: {
    getAllUsers(ctx) {
      axios.get('/users')
        .then((res) => {
          ctx.commit('updateUsers', res.data);
        });
    },
  },

  mutations: {
    updateUsers(state, payload) {
      state.users = payload;
    },
  },

  getters: {
    getUsers(state) {
      return state.users;
    },
  },
};
