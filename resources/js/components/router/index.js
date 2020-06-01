import Vue from 'vue';
import Router from 'vue-router';


import Home from '../containers/Home.vue';
import Main from '../containers/Main.vue';
import Chat from '../containers/Chat.vue';

Vue.use(Router);

export default new Router({
  mode: 'history',
  base: '/dashboard',

  routes: [
    {
      path: '/',
      name: 'Home',
      component: Home,
      children: [
        {
          path: '/main',
          name: 'Main',
          component: Main,
        },
        {
          path: '/chat/:id',
          name: 'Chat',
          props: true,
          component: Chat,
        },
      ],
    },
  ],
});
