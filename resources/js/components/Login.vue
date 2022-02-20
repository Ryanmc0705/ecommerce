<template>
  <v-app>
    <v-row justify="center">
      <v-col cols="12" lg="4" sm="12" md="12">
        <v-card class="mt-5" flat elevation="2" >
          <v-toolbar dark color="primary">
            <v-toolbar-title>Enter your Credentials</v-toolbar-title>
          </v-toolbar>
          <v-main class="pa-5">
            <alert-message
              type="error"
              message="Invalid Username or Password"
              v-if="!login_status"
            ></alert-message>
            <v-row>
              <v-col cols="12" lg="12">
                <v-text-field
                  label="Email Address"
                  v-model="login_fields.email"
                  type="email"
                ></v-text-field>
              </v-col>
            </v-row>
            <v-row>
              <v-col cols="12" lg="12">
                <v-text-field
                  label="Password"
                  v-model="login_fields.password"
                  type="password"
                ></v-text-field>
              </v-col>
            </v-row>
            <v-row>
              <v-col cols="12" lg="12">
                <v-btn color="primary" @click="login" >Log In</v-btn>
                <router-link :to="{name:'home'}">Go to Home Page</router-link>
              </v-col>
            </v-row>
          </v-main>
        </v-card>
      </v-col>
    </v-row>
  </v-app>
</template>

<script>

import ErrorValidation from "./../mixins/ErrorValidation";
export default {
  
  mixins: [ErrorValidation],
  data() {
    return {
      login_fields: {
        email: null,
        password: null,
        
      },
      login_status: true,
    };
  },
  methods: {
    async login() {
      try {
        const { data } = await axios.post(
          "api/user/login",
          this.login_fields
        );
        if (data.message == "Login Success") {
          this.login_status = true;
          this.$store.commit("setstorageData",{company_id:data.user.company_id,
                                               user_id:data.user.id,
                                               fullname:data.user.firstname+" "+data.user.lastname,
                                               email:data.user.email});
          await this.$router.push("/dashboard");
        }
      } catch (error) {
          this.login_status = false; 
      }
    },
  },
};
</script>

