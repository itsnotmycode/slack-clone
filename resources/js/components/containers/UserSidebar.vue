<template>
  <v-card class="card">
    <v-icon class="mt-5 ml-3 mr-auto"
            @click="$emit('closeSidebar')"
    >
      mdi-close
    </v-icon>
    <v-img class="mt-3"
      :src="avatar"
      max-height="350px"
    ></v-img>
    <v-row class="fix-height">
      <v-col class="ml-3">
        <v-dialog
          v-model="dialog"
          width="800"
        >
          <template v-slot:activator="{ on }">
            <v-btn
              color="green lighten-2"
              dark
              v-on="on"
            >
              Edit Profile
            </v-btn>
          </template>

          <v-card>
            <v-card-title
              class="headline lighten-2"
              primary-title
            >
              Edit Profile
            </v-card-title>

            <v-card-text>
              <v-form ref="form">
                <v-row>
                <v-col cols="8">
                  <input class="hidden-file-input"
                    :name="newInputAvatar"
                    type="file"
                    ref="fileInput"
                    @change="fileSelected"
                  />
                  <v-card-title>
                    <v-text-field
                      label="Username"
                      type="text"
                      v-model="newUserInfo.name"
                      :rules="inputNameRules"
                    >
                    </v-text-field>
                  </v-card-title>
                  <v-card-title>
                    <v-text-field
                      label="Email"
                      type="email"
                      v-model="newUserInfo.email"
                      :rules="inputEmailRules"
                    >
                    </v-text-field>
                  </v-card-title>
                </v-col>
                <v-col cols="4">
                  <v-img class="mt-3"
                     :src="newAvatar"
                     height="150px"
                  ></v-img>
                  <v-btn class="ml-3 mt-3"
                    @click="$refs.fileInput.click()"
                  >
                    Upload an image
                  </v-btn>
                  <v-btn class="ml-3"
                    text
                    @click="removeImage"
                  >
                    Remove image
                  </v-btn>
                </v-col>
                </v-row>
              </v-form>
            </v-card-text>

            <v-divider></v-divider>

            <v-card-actions>
              <v-spacer></v-spacer>
                <v-btn
                  color="primary"
                  text
                  @click="submit"
                >
                  Update User Info
                </v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>
      </v-col>
    </v-row>
    <hr>
    <div>
      <v-card-title>{{ user.name }}</v-card-title>
      <v-card-title>{{ user.email }}</v-card-title>
    </div>
  </v-card>
</template>
<script>
import { mapGetters, mapActions } from 'vuex';

export default {
  data() {
    return {
      user: {},
      newUserInfo: {},
      newInputAvatar: '',
      showChangeUserInfo: false,
      dialog: false,
      inputNameRules: [
        (v) => v.length > 0 || 'Enter valid Username',
      ],
      inputEmailRules: [
        (v) => (v.length > 0 && /\S+@\S+\.\S+/.test(v)) || 'Enter valid email address',
      ],
    };
  },
  mounted() {
    this.user = this.getCurrentUser;
    this.newUserInfo = { ...this.user };
    this.newInputAvatar = this.newUserInfo.avatar;
  },
  methods: {
    ...mapActions(['updateUserInfo']),
    submit() {
      // TODO: add validation before submitting new user info
      if (this.$refs.form.validate()) {
        this.dialog = !this.dialog;
        this.updateUserInfo(this.newUserInfo);
      }
    },
    fileSelected(e) {
      this.newUserInfo.avatar = e.target.files[0];
      const image = e.target.files[0];
      const reader = new FileReader();
      reader.readAsDataURL(image);
      reader.onload = (file) => {
        this.newInputAvatar = file.target.result;
      };
    },
    removeImage() {
      this.newUserInfo.avatar = '';
      this.newInputAvatar = '';
    },
  },
  computed: {
    ...mapGetters(['getCurrentUser']),
    avatar() {
      let avatarUrl = '';
      if (this.user.avatar !== undefined && this.user.avatar !== '') {
        avatarUrl = `${window.location.origin}/storage/${this.user.avatar}`;
      } else {
        avatarUrl = `${window.location.origin}/storage/avatars/noImg.jpg`;
      }
      return avatarUrl;
    },
    newAvatar() {
      let avatarUrl = '';
      if (this.newInputAvatar !== undefined && this.newInputAvatar !== '') {
        avatarUrl = this.newInputAvatar;
      } else {
        avatarUrl = `${window.location.origin}/storage/avatars/noImg.jpg`;
      }
      return avatarUrl;
    },
  },
};
</script>
<style scoped>
  .card {
    height: auto;
    min-height: 100%;
  }
  .hidden-file-input {
    display: none;
  }
  .fix-height {
    max-height: 50px;
  }
</style>
