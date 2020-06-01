<template>
  <v-app app>
    <v-navigation-drawer color="#3f0e40" app dark permanent>
      <v-container>
        <v-list>
          <v-list-item>
            <v-list-item-title>
              <strong>Channels</strong>
            </v-list-item-title>
            <v-list-item-action>
              <v-btn icon>
                <v-icon>mdi-plus-circle-outline</v-icon>
              </v-btn>
            </v-list-item-action>
          </v-list-item>
          <v-list-item class="link" v-for="channel in groupChannels" :key="channel.id"
                       router :to="{path: '/chat/' + channel.id}"
          >
            <v-list-item-content>
              <v-list-item-title>
                {{ channel.name }}
              </v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </v-list>
        <v-list>
          <v-list-item>
            <v-list-item-title>
              <v-tooltip top open-delay="500" color="black" content-class="c-tooltip">
                <template v-slot:activator="{ on }">
                  <strong v-on="on">Direct Messages</strong>
                </template>
                <span>Open a direct message</span>
              </v-tooltip>
            </v-list-item-title>
            <v-list-item-action>
              <v-tooltip top open-delay="500" color="black" content-class="c-tooltip">
                <template v-slot:activator="{ on }">
                  <div v-on="on">
                    <popup :user="user"></popup>
                  </div>
                </template>
                <span>Open a direct message</span>
              </v-tooltip>
            </v-list-item-action>
          </v-list-item>
          <v-list-item class="link" v-for="channel in directChannels" :key="channel.id"
                       router :to="{path: '/chat/' + channel.id}"
          >
            <v-list-item-content>
              <v-list-item-title>
                {{ channel.name }}
              </v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </v-list>
      </v-container>
    </v-navigation-drawer>
    <v-app-bar app>
      <v-toolbar-title>Chat</v-toolbar-title>
      <v-spacer></v-spacer>
      <v-btn icon href="/logout">
        <v-icon >mdi-location-exit</v-icon>
      </v-btn>
    </v-app-bar>
    <v-content>
      <v-container fluid style="min-height: calc(100vh - 62px);">
        <router-view></router-view>
      </v-container>
    </v-content>
  </v-app>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';
import popup from './Popup.vue';

export default {
  name: 'Home',
  data() {
    return {
      user: [],
      activeChat: '',
    };
  },
  components: { popup },
  async mounted() {
    this.getAllChannels();
    this.user = JSON.parse(window.user);
  },
  methods: {
    ...mapActions(['getAllChannels']),
    makeChatActive(name) {
      this.activeChat = name;
    },
  },
  computed: {
    ...mapGetters(['allChannels', 'directChannels', 'groupChannels']),
  },
};
</script>

<style scoped>
  .c-tooltip:after{
    content: '';
    border: 1px solid black;
    position: absolute;
    top: 32px;
    border: 8px solid transparent;
    border-top: 8px solid black;
    left: calc( 50% - 8px );
  }
  .v-list-item__title{
    cursor: pointer;
  }
</style>
