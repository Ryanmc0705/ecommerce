<template>
  <v-app>
    <nav-bar pages="Categories"></nav-bar>
    <v-container>
      <h2>{{ getHeader }}</h2>
      <v-divider></v-divider>
      <v-btn
        small
        color="primary"
        @click="
          dialog = true;
          action = 'add';
        "
        class="mb-2 mt-5"
        ><v-icon>mdi-shape-square-plus</v-icon>New Sub-Category</v-btn
      >
      <v-card-title>
        <v-text-field
          v-model="search"
          append-icon="mdi-magnify"
          label="Search Sub-Category"
          single-line
          hide-details
        ></v-text-field>
      </v-card-title>
      <alert-message
        type="success"
        :message="message"
        v-if="category_status"
      ></alert-message>

      <v-data-table :items="categories" :headers="headers" :search="search">
        <template v-slot:item.created_at="{ item }">
          {{ item.created_at | LongFormat }}
        </template>
        <template v-slot:item.action="{ item }">
          <v-btn
            color="success"
            small
            @click="
              dialog = true;
              action = 'update';
              category_id = item.id;
              subcategory.name = item.name;
            "
          >
            <v-icon>mdi-grease-pencil</v-icon>
            Edit
          </v-btn>

          <v-btn color="error" small @click="deleteSubCategory(item.id)">
            <v-icon>mdi-trash-can</v-icon>
            Delete
          </v-btn>
        </template>
      </v-data-table>
      <v-dialog v-model="dialog" max-width="500px">
        <v-card>
          <v-card-title>Add/Edit Sub-Categories</v-card-title>
          <v-container>
            <v-row>
              <v-col cols="12" lg="12" md="12" sm="12">
                <v-text-field
                  type="text"
                  v-model="subcategory.name"
                  label="Name"
                >
                </v-text-field>
                <error-message :errors="errorFor('name')"></error-message>
              </v-col>
            </v-row>
          </v-container>
          <v-card-actions>
            <v-btn color="primary" @click="saveSubCategory"> Save </v-btn>
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
      categories: [],
      subcategory: {
        name: null,
        category_id: null,
      },
      dialog: false,
      category_status: false,
      category_id: null,
      search: null,
      message: null,
      action: null,
      headers: [
        { text: "ID", value: "id" },
        { text: "Category Name", value: "name" },
        { text: "Created At", value: "created_at" },
        { text: "Action", value: "action" },
      ],
    };
  },
  methods: {
    async loadSubCategories() {
      const { data } = await axios.get(
        `/api/subcategory/${this.getCategoryId}`
      );
      this.categories = data.subcategories;
    },
    async saveSubCategory() {
      try {
        this.subcategory.category_id = this.getCategoryId;
        if (this.action == "add") {
          const { data } = await axios.post(
            "/api/subcategory/create",
            this.subcategory
          );
          if (data.message == "success") {
            this.category_status = true;
            this.message = "Sub-Category Added";
            this.dialog = false;
            this.loadSubCategories();
          }
        } else {
          const { data } = await axios.put(
            `/api/subcategory/${this.category_id}`,
            this.subcategory
          );
          if (data.message == "update success") {
            this.category_status = true;
            this.message = "Sub-Category Updated";
            this.dialog = false;
            this.loadSubCategories();
          }
        }
      } catch (error) {
        if (error.response.status == 422) {
          this.errors = error.response.data.errors;
        }
        this.status = error.response.status;
      }
    },

    async deleteSubCategory(subcategory_id) {
      const { data } = await axios.delete(`/api/subcategory/${subcategory_id}`);

      if (data.message == "success") {
        this.category_status = true;
        this.message = "Sub-Category Deleted";
        this.loadSubCategories();
      }
    },
  },

  created() {
    this.loadSubCategories();
  },
  computed: {
    getCategoryId() {
      return this.$route.params.category_id;
    },
    getHeader() {
      return this.$route.params.header_text;
    },
  },
};
</script>

<style>
</style>