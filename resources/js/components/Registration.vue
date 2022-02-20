<template>
  <v-app>
    <v-row justify="center">
      <v-col cols="12" lg="6" sm="12" md="12">
        <v-card class="" flat elevation="2">
          <v-toolbar dark color="primary">
            <v-toolbar-title>Register your Store</v-toolbar-title>
          </v-toolbar>
          <v-main class="pa-5">
            <alert-message type="success" message="Registration Succesful" v-if="register_status" ></alert-message>
              <v-row>
            <v-col cols="12" lg="6">
              <v-text-field label="First Name" type="text" v-model="register_fields.firstname" required></v-text-field>
              <error-message :errors="errorFor('firstname')"></error-message>
            </v-col>
            <v-col cols="12" lg="6">
              <v-text-field label="Last Name" type="text" v-model="register_fields.lastname"></v-text-field>
              <error-message :errors="errorFor('lastname')"></error-message>
            </v-col>
          </v-row>
          <v-row>
            <v-col cols="12" lg="6">
              <v-text-field label="Company Name" type="text" v-model="register_fields.company_name"></v-text-field>
              <error-message :errors="errorFor('company_name')"></error-message>
            </v-col>
            <v-col cols="12" lg="6">
              <v-text-field label="Contact Number" type="text" v-model="register_fields.contact_number"></v-text-field>
              <error-message :errors="errorFor('contact_number')"></error-message>
            </v-col>
          </v-row>

          <v-row>
            <v-col cols="12" lg="12">
              <v-text-field label="Address" type="text" v-model="register_fields.address" ></v-text-field>
              <error-message :errors="errorFor('address')"></error-message>
            </v-col>
          </v-row>
          <v-row>
            <v-col cols="12" lg="12">
              <v-text-field label="Email Address" type="email" v-model="register_fields.email"></v-text-field>
              <error-message :errors="errorFor('email')"></error-message>
            </v-col>
          </v-row>
          <v-row>
            <v-col cols="12" lg="12">
              <v-text-field label="Password" type="password" v-model="register_fields.password"></v-text-field>
              <error-message :errors="errorFor('password')"></error-message>
            </v-col>
          </v-row>
          <v-row>
            <v-col cols="12" lg="12">
              <v-text-field
                label="Confirm Password"
                type="password"
                v-model="register_fields.password_confirmation"
              ></v-text-field>
            </v-col>
          </v-row>
          <v-row>
            <v-col cols="12" lg="12">
              <v-btn color="primary" @click="save"><v-icon>mdi-check</v-icon> Register</v-btn>
            </v-col>
          </v-row>
          </v-main>
          
        </v-card>
      </v-col>
    </v-row>
  </v-app>
</template>

<script>

import ErrorValidation from "./../mixins/ErrorValidation"
export default {
  mixins:[ErrorValidation],
  data(){
    return{
      register_fields:{
        firstname:null,
        lastname:null,
        contact_number:null,
        company_name:null,
        address:null,
        email:null,
        password:null,
        password_confirmation:null,
        type:"admin"
      },
      register_status:false
    }
  },
  methods:{
    async save(){
      try{
        const {data} = await axios.post("api/user/create",this.register_fields);
        if(data.message == "success"){
          this.register_status = true;
          //this.$route.push("/login");
        }
          
      }catch(error){
        if(error.response.status == 422){
         
          this.errors = error.response.data.errors;
        }
         this.status = error.response.status;
         
      }
     
      
    }
  }

};
</script>

