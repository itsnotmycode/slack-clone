<template>
  <div class="text-center">
    <v-dialog
      v-model="dialog"
      width="600"
    >
      <template v-slot:activator="{ on }">
        <v-btn icon v-on="on">
          <v-icon>mdi-plus-circle-outline</v-icon>
        </v-btn>
      </template>

      <v-card>
        <v-card-title primary-title>
          Direct Messages
          <v-spacer></v-spacer>
          <v-btn icon @click="dialog = false">
            <v-icon>mdi-close</v-icon>
          </v-btn>
        </v-card-title>
       <v-container class="px-7">
         <div class="d-flex align-center">
             <v-textarea class="mr-5"
               placeholder="Find or start a conversation"
               outlined auto-grow rows="1"
               hide-details dense v-model="searchName"
             ></v-textarea>
             <v-btn disabled>Go</v-btn>
         </div>
         <v-list v-if="filteredUsers.length">
           <template v-for="user in filteredUsers">
             <v-divider class="ma-0"></v-divider>
             <v-list-item class="py-3" @click="createDirectChannel(user.id, user.name)" :key="user.id">
               <v-list-item-content>
                 <v-list-item-title>
                   {{ user.name }}
                 </v-list-item-title>
               </v-list-item-content>
             </v-list-item>
           </template>
         </v-list>
         <div class="title text-center my-5" v-else>
           No one found matching <strong>{{ searchName }}</strong>
         </div>
       </v-container>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';

export default {
  name: 'popup',
  props: {
    user: {
      default: null,
    },
  },
  data() {
    return {
      dialog: false,
      searchName: '',
    }
  },
  mounted() {
    this.getAllUsers();
  },
  methods: {
    ...mapActions(['getAllUsers', 'createChannel', 'getAllChannels']),
    async createDirectChannel(id, name) {
      await this.createChannel({ user_id: id, channel_name: name, user_channel: true, private: false });
      this.getAllChannels();
      if (this.$route.params.id != this.getChannelId) {
        this.$router.push({ name: 'Chat', params: { id: this.getChannelId } });
      }
      this.dialog = false;
    },
  },
  computed: {
    ...mapGetters(['getUsers', 'currentChannel']),
    filteredUsers() {
      return this.getUsers.filter((user) => {
        return user.name.toLowerCase().indexOf(this.searchName.toLowerCase()) !== -1;
      });
    },
    getChannelId() {
      return this.currentChannel.id;
    },
  },
}
</script>

<style lang="scss" scoped>
  .v-card{
    overflow:hidden;
    .container{
      height:600px;
      overflow-y:scroll;
    }
  }
</style>
