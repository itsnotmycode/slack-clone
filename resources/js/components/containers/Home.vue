<template>
  <v-app app>
    <v-navigation-drawer app>
      <v-container>
        <div class="mb-3 relative">
            <v-avatar style="cursor: pointer;" color="black" @click="dropdown()">
              <span class="white--text headline">{{ this.user.name && this.user.name[0] }}</span>
            </v-avatar>
          <span class="black--text">{{ this.user.email && this.user.email }}</span>
          <v-card v-if="this.activeDropdown" :elevation="16"
                  class="dropdown"
                  v-on-clickaway="hideInfo"
          >
            <v-list-item-group>
              <v-list-item @click="userInfo('show')"
              >
                <v-list-item-content>
                  <v-list-item-title>
                    User Profile Page
                  </v-list-item-title>
                </v-list-item-content>
              </v-list-item>
            </v-list-item-group>
          </v-card>
        </div>
        <v-list-item-group>
          <v-list-item class="link" v-for="channel in allChannels" :key="channel.id"
                       router :to="{path: '/chat/' + channel.id}"
          >
            <v-list-item-content>
              <v-list-item-title>
                {{ channel.name }}
              </v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </v-list-item-group>
      </v-container>
    </v-navigation-drawer>
    <v-app-bar app>
      <v-toolbar-title>Chat</v-toolbar-title>
      <v-spacer></v-spacer>
      <v-btn icon>
        <v-icon>mdi-magnify</v-icon>
      </v-btn>
    </v-app-bar>
    <v-content>
      <v-container fluid style="min-height: calc(100vh - 62px);">
        <router-view></router-view>
      </v-container>
    </v-content>
    <div v-if="showUserInfo" class='sidebar-info'>
      <user-sidebar @closeSidebar="userInfo('hide')"></user-sidebar>
    </div>
  </v-app>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';
import { mixin as clickaway } from 'vue-clickaway';
import UserSidebar from './UserSidebar.vue';

export default {
  name: 'Home',
  mixins: [clickaway],
  data() {
    return {
      activeDropdown: false,
      activeChat: '',
      showUserInfo: false,
    };
  },
  components: { UserSidebar },
  mounted() {
    this.getUser();
    this.getAllChannels();
  },
  methods: {
    ...mapActions(['getAllChannels', 'getUser']),
    makeChatActive(name) {
      this.activeChat = name;
    },
    dropdown() {
      this.activeDropdown = !this.activeDropdown;
    },
    userInfo(status) {
      switch (status) {
        case 'show':
          this.showUserInfo = true;
          this.activeDropdown = false;
          break;
        case 'hide':
          this.showUserInfo = false;
          this.activeDropdown = false;
          break;
        default:
          this.showUserInfo = false;
          this.activeDropdown = false;
          break;
      }
    },
    hideInfo() {
      this.userInfo('hide');
    },
  },
  computed: {
    ...mapGetters(['allChannels', 'getCurrentUser']),
    user() {
      return this.getCurrentUser;
    },
  },
};
</script>

<style scoped>
  .dropdown {
    position: absolute;
    z-index: 1;
  }
  .sidebar-info {
    margin-left: calc(100% - 392px);
    width: 392px;
    height: 100vh;
    position: absolute;
    z-index: 6;
  }
</style>
