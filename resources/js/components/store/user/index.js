import axios from 'axios';

export default {
  state: {
    user_id: window.user_id,
    user: {},
  },

  actions: {
    getUser(ctx) {
      axios.get('/user/get', { params: { id: ctx.state.user_id } })
        .then((res) => {
          ctx.commit('setUser', res.data[0]);
        });
    },
    updateUserInfo(ctx, query) {
      ctx.commit('updateUser', query);
    },
  },

  mutations: {
    setUser(state, payload) {
      state.user = payload;
    },
    updateUser(state, payload) {
      const formData = new FormData();
      formData.append('avatar', payload.avatar);
      formData.append('name', payload.name);
      formData.append('email', payload.email);
      formData.append('id', payload.id);
      axios.post('/user/update', formData,
        {
          headers: {
            'Content-Type': 'multipart/form-data',
          },
        })
        .then((res) => res);
      state.user = {
        avatar: payload.avatar,
        name: payload.name,
        email: payload.email,
      };
    },
  },

  getters: {
    getCurrentUser(state) {
      return state.user;
    },
  },
};
