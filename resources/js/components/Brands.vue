<template>
  <v-app>
    <nav-bar pages="Brands"></nav-bar>
    <v-container>
      <h2>Brands</h2>
      <v-divider></v-divider>
      <v-btn
        color="primary"
        @click="
          dialog = true;
          action = 'add';
          
        "
        class="mt-4"
        ><v-icon>mdi-shape-square-plus</v-icon>New Brand</v-btn
      >

      <v-card-title>
        <v-text-field
          v-model="search"
          append-icon="mdi-magnify"
          label="Search"
          single-line
          hide-details
        ></v-text-field>
      </v-card-title>
      <alert-message
        type="success"
        :message="message"
        v-if="brand_status"
      ></alert-message>
      <v-data-table :headers="headers" :items="brands">
          <template v-slot:item.image="{item}">
              <v-img
               
                max-height="50"
                max-width="60"
                :src="item.image"
                ></v-img>
          </template>
          <template v-slot:item.created_at="{item}">
              {{item.created_at|LongFormat}}
          </template>
          <template v-slot:item.action="{item}">
               <v-btn color="error" small @click="deleteCategory(item.id)">
            <v-icon>mdi-trash-can</v-icon>
            Delete
          </v-btn>
          </template>
      </v-data-table>
      <v-dialog v-model="dialog" max-width="500px">
        <v-card>
          <v-card-title>Add/Edit Brand</v-card-title>
          <v-container>
            <form @submit="formSubmit" enctype="multipart/form-data">
              <v-row>
                <v-col cols="12" lg="12" md="12" sm="12">
                  <v-text-field
                    prepend-icon="mdi-tshirt-v-outline"
                    type="text"
                    v-model="name"
                    label="Brand Name"
                  >
                  </v-text-field>
                  <error-message :errors="errorFor('name')"></error-message>
                </v-col>
              </v-row>
              <v-row>
                <v-col cols="12" lg="12" md="12" sm="12">
                  
                  <input
                    type="file"
                    class="form-control"
                    name="photo"
                    v-on:change="onChange"
                  />
                  <error-message :errors="errorFor('name')"></error-message>
                </v-col>
              </v-row>
            </form>
          </v-container>
          <v-card-actions>
            <v-btn color="primary" @click="formSubmit">Save</v-btn>
            <v-btn color="primary" text @click="dialog = false"> Close </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </v-container>
  </v-app>
</template>

<script>
import errorValidation from "./../mixins/ErrorValidation";
export default {
  mixins: [errorValidation],
  data() {
    return {
      brands: [],
      action: null,
      search: null,
      name: null,
      dialog: false,
      category_id: null,
      brand_status: false,
      message: null,
      file: "",
      headers: [
        { text: "", value: "image" },
        { text: "Brand Name", value: "name" },
        { text: "Created At", value: "created_at" },
        { text: "Action", value: "action" },
      ],
      
    };
  },
  methods: {
    onChange(e) {
        
        this.file = e.target.files[0];
    },
    formSubmit() {
    
      let existingObj = this;

      let data = new FormData();

      data.append("image", this.file);
      data.append("name", this.name);
      data.append("company_id", this.company_id);

      axios
        .post("/api/brand  ", data)
        .then((response) => {
          this.brand_status = true;
          this.message = "New Brand Saved";
        })
        .catch((error) => {
          if (error.response.status == 422) {
            this.errors = error.response.data.errors;
          }
          this.status = error.response.status;
        });
    },
    async loadBrands(){
        const {data} = await axios.get(`api/brand/${this.company_id}`);
        this.brands = data.brands;
    }
  },
  created(){
      this.loadBrands();
  }
};
</script>

<style>
</style>