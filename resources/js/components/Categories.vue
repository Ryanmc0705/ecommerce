<template>
  <v-app>
    <nav-bar pages="Categories"></nav-bar>
    <v-row>
       <v-col cols="12" lg="12" justify="center">
          <v-container justify="center">
      <v-btn
        color="primary"
        @click="
          dialog = true;
          action = 'add';
          category.name = '';
        "
        class="mb-3"
        ><v-icon>mdi-shape-square-plus</v-icon>New Category</v-btn
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
              action = 'update';
              dialog = 'true';
              category.name = item.name;
              category_id = item.id;
            "
          >
            <v-icon>mdi-grease-pencil</v-icon>
            Edit
          </v-btn>
          <v-btn
            color="success"
            small
            :to="{
              name: 'subcategories',
              params: { category_id: item.id, header_text: item.name },
            }"
          >
            <v-icon>mdi-format-list-numbered</v-icon>
            Sub-Categories
          </v-btn>

          <v-btn color="error" small @click="deleteCategory(item.id)">
            <v-icon>mdi-trash-can</v-icon>
            Delete
          </v-btn>
        </template>
      </v-data-table>
      <v-dialog v-model="dialog" max-width="500px">
        <v-card>
          <v-card-title>Add/Edit Categories</v-card-title>
          <v-container>
            <v-row>
              <v-col cols="12" lg="12" md="12" sm="12">
                <v-text-field type="text" v-model="category.name" label="Name">
                </v-text-field>
                <error-message :errors="errorFor('name')"></error-message>
              </v-col>
            </v-row>
          </v-container>
          <v-card-actions>
            <v-btn color="primary" @click="saveCategory"> Save </v-btn>
            <v-btn color="primary" text @click="dialog = false"> Close </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </v-container>
       </v-col>
    </v-row>
  </v-app>
</template>

<script>
import errorValidation from "./../mixins/ErrorValidation";
export default {
  mixins: [errorValidation],
  data() {
    return {
      categories: [],
      action: null,
      search: null,
      category: {
        name: null,
        company_id: this.company_id,
      },
      dialog: false,
      category_id: null,
      category_status: false,
      message: null,
      route: null,
      headers: [
        { text: "ID", value: "id" },
        { text: "Category Name", value: "name" },
        { text: "Sub-Category Count", value: "sub_category_count" },
        { text: "Created At", value: "created_at" },
        { text: "Action", value: "action" },
      ],
    };
  },
  methods: {
    async loadCategories() {
      const { data } = await axios.get(`/api/category/${this.company_id}`);
      this.categories = data.categories;
    },
    async saveCategory() {
      try {
        this.category.company_id = this.company_id;

        if (this.action == "add") {
          const { data } = await axios.post(
            "/api/category/create",
            this.category
          );
          if (data.message == "success") {
            this.category_status = true;
            this.dialog = false;
            this.loadCategories();
            this.category.name = "";
            this.message = "New Category Created";
          }
        } else {
          //alert(this.action);
          const { data } = await axios.put(
            `api/category/${this.category_id}`,
            this.category
          );
          if (data.message == "success") {
            this.category_status = true;
            this.dialog = false;
            this.loadCategories();
            this.category.name = "";
            this.message = "Category Updated";
          }
        }
      } catch (error) {
        if (error.response.status == 422) {
          this.errors = error.response.data.errors;
        }
        this.status = error.response.status;
        console.log(this.errors);
        console.log(this.errorFor("name"));
      }
    },
    async deleteCategory(category_id) {
      const { data } = await axios.delete(`api/category/${category_id}`);
      if (data.message == "success") {
        this.category_status = true;
        this.message = "Category Deleted";
        this.loadCategories();
      }
    },
  },

  created() {
    this.loadCategories();
  },
};
</script>

<style>
</style>