<template>
  <div class="c-wrap">
    <div class="c-chat" ref="chat">
      <v-card outlined v-for="ch in showCurrentMessages" :key="ch.id">
        <v-card-title>{{ ch.user.name }}</v-card-title>
        <v-card-text>{{ ch.message }}</v-card-text>
      </v-card>
    </div>
    <div class="c-form">
      <v-textarea v-on:keyup.enter="send" tile v-model="messageToSend"
                    absolute placeholder="Enter your message"
                    outlined auto-grow
                    autofocus
      >
      </v-textarea>
    </div>
  </div>
</template>

<script>
import { mapActions, mapGetters, mapMutations } from 'vuex';

export default {
  name: 'Chat',
  props: ['id'],
  components: {},
  data() {
    return {
      messageToSend: '',
    };
  },
  async mounted() {
    this.getAllMessages();
    this.getAllChannels();
    let channels = this.getChannels;
    channels.forEach((channel) => {
      window.Echo.private(`channel.${channel.id}`)
        .listen('WebsocketDemoEvent', (e) => {
          this.addMessage(e.message);
          this.scrollToBottom();
        });
    });
  },
  methods: {
    ...mapActions(['getAllMessages', 'sendMessage', 'getAllChannels']),
    ...mapMutations(['addMessage']),
    send() {
      this.sendMessage({ message: this.messageToSend, channel_id: this.id });
      this.messageToSend = '';
    },
    scrollToBottom() {
      setTimeout(() => {
        this.$refs.chat.scrollTop = this.$refs.chat.scrollHeight - this.$refs.chat.clientHeight;
      }, 50);
    },
  },
  computed: {
    ...mapGetters(['getMessages', 'allChannels']),
    showCurrentMessages() {
      if (this.getMessages.length) {
        return this.getMessages.filter((message) => message.channel_id === Number(this.id));
      } else {
        return [];
      }
    },
    getChannels() {
      return this.allChannels;
    },
  },
  listen: {

  },
};
</script>

<style scoped>
  .c-wrap {
    height: calc(100vh - 82px);
    position: relative;
    overflow: hidden;
  }
  .c-form {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height:130px;
  }
  .c-chat {
    overflow-y: auto;
    position: absolute;
    top: 0;
    bottom: 130px;
    left: 0;
    right: 0;
  }
</style>
