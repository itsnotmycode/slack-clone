<template>
  <div class="c-wrap">
    <div class="c-chat">
      <v-card outlined v-for="ch in showCurrentMessages" :key="ch.id">
        <v-card-title>{{ ch.user.name }}</v-card-title>
        <v-card-text>{{ ch.message }}</v-card-text>
      </v-card>
    </div>
    <div class="c-form">
      <v-textarea flat solo v-on:keyup.enter="send" tile v-model="messageToSend"
                    absolute label="Enter your message"
                    clearable clear-icon="X"
      >
      </v-textarea>
    </div>
  </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';

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
  },
  methods: {
    ...mapActions(['getAllMessages', 'sendMessage']),
    send() {
      this.sendMessage({ message: this.messageToSend, channel_id: this.id });
      this.messageToSend = '';
    },
  },
  computed: {
    ...mapGetters(['getMessages']),
    showCurrentMessages() {
      if (this.getMessages.length) {
        return this.getMessages.filter((message) => message.channel_id === Number(this.id));
      }
      return [];
    },
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
    bottom: -25px;
    left: 0;
    right: 0;
  }
  .c-chat {
    overflow-y: auto;
    height: 70%;
  }
</style>
