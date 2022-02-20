<template>
  <v-app>
    <nav-bar pages="New Product"></nav-bar>
    <v-container>
      <h2>New Product</h2>
      <v-divider></v-divider>

      <v-row justify="center" class="mt-3">
        <v-col cols="12" lg="12">
          <v-card elevation="2" class="px-5 py-5">
            <alert-message
              :type="message_type"
              :message="message"
              v-if="sendSuccess"
            ></alert-message>
            <v-row>
              <v-col rows="12" lg="4">
                <v-text-field
                  small
                  
                  solo
                  v-model="name"
                >
                  <template #label>
                    <span class="red--text"><strong>* </strong></span>Product Name
                  </template>
                </v-text-field>
              </v-col>
              <v-col rows="12" lg="4">
                <v-text-field
                 
                  solo
                  v-model="product_code"
                >
                <template #label>
                    <span class="red--text"><strong>* </strong></span>Code
                  </template>
                </v-text-field>
              </v-col>
              <v-col rows="12" lg="4">
                <v-text-field label="Selling Price" solo v-model="price" type="text">
                  <template #label>
                    <span class="red--text"><strong>* </strong></span>Selling Price
                  </template>
                </v-text-field>
              </v-col>
            </v-row>
            <v-row>
              <v-col rows="12" lg="4">
                <v-text-field solo v-model="stocks">
                   <template #label>
                    <span class="red--text"><strong>* </strong></span>Stocks
                  </template>
                </v-text-field>
              </v-col>
              <v-col rows="12" lg="4">
                <v-autocomplete
                  label="Categories"
                  solo
                  :items="categories"
                  item-value="id"
                  item-text="name"
                  v-model="selectedCategory"
                >
                   
                </v-autocomplete>
              </v-col>
              <v-col rows="12" lg="4">
                <v-select
                  label="Sub-Category"
                  :items="subcategories"
                  item-value="id"
                  item-text="name"
                  v-model="selectedSub"
                  solo
                ></v-select>
              </v-col>
            </v-row>
            <v-row>
              <v-col rows="12" lg="4">
                <v-select
                  label="Brands"
                  solo
                  :items="brands"
                  item-value="id"
                  item-text="name"
                  v-model="selectedBrand"
                ></v-select>
              </v-col>
              <v-col rows="12" lg="4">
                <v-text-field label="Sale Percentage" v-model="sale_percentage" type="number" solo>
                </v-text-field>
              </v-col>
              <v-col rows="12" lg="4">
                <v-text-field label="Sale until" type="date" solo v-model="sale_until"></v-text-field>
              </v-col>
            </v-row>
            <v-row>
              <v-col rows="12" lg="12">
                <label for="">Product Description</label>
                <editor
                  v-model="description"
                  api-key="no-api-key"
                  :init="{
                    height: 300,
                    menubar: false,
                    plugins: [
                      'advlist autolink lists link image charmap print preview anchor',
                      'searchreplace visualblocks code fullscreen',
                      'insertdatetime media table paste code help wordcount',
                    ],
                    toolbar:
                      'undo redo | formatselect | bold italic backcolor | \
           alignleft aligncenter alignright alignjustify | \
           bullist numlist outdent indent | removeformat | help',
                  }"
                />
              </v-col>
            </v-row>
            <v-row>
              <v-col cols="12" lg="12">
                <label for="">Product Images</label>
                <vue-dropzone
                  ref="myVueDropzone"
                  id="dropzone"
                  :options="dropzoneOptions"
                  @vdropzone-complete="afterUploadComplete"
                  @vdropzone-sending-multiple="saveProduct"
                  :headers="{ 'X-CSRF-TOKEN': token }"
                ></vue-dropzone>
              </v-col>
              <v-btn color="primary" @click="saveImage"
                ><v-icon>mdi-check</v-icon>Save Product</v-btn
              >
            </v-row>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
  </v-app>
</template>

<script>
import Editor from "@tinymce/tinymce-vue";
import vue2Dropzone from "vue2-dropzone";
import "vue2-dropzone/dist/vue2Dropzone.min.css";
import errorValidation from "./../mixins/ErrorValidation";
export default {
  mixins: [errorValidation],
  data() {
    return {
      text: "",
      categories: [],
      brands: [],
      subcategories: [],
      selectedCategory: null,
      selectedBrand: null,
      selectedSub: null,
      sendSuccess: false,
      name: "",
      message:null,
      message_type:null,
      product_code: null,
      price: null,
      stocks: null,
      category_id: null,
      sub_category_id: null,
      brand_id: null,
      sale_until:null,
      sale_percentage:0,
      description: null,
      token: null,
      dropzoneOptions: {
        url: "/api/product",
        thumbnailWidth: 150,
        maxFilesize: 2,
        parallelUploads: 4,
        maxFiles: 3,
        uploadMultiple: true,
        autoProcessQueue: false,
        headers: {
          "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')[
            "content"
          ],
        },
        addRemoveLinks: true,
      },
    };
  },
  components: {
    editor: Editor,
    vueDropzone: vue2Dropzone,
  },
  methods: {
    onUpdate(text) {
      this.text = text;
    },
    async getCategories() {
      const { data } = await axios.get(`/api/category/${this.company_id}`);
      this.categories = data.categories;
      this.selectedCategory = this.categories[0].id;
      this.getBrands();
    },
    async getBrands() {
      const { data } = await axios.get(`/api/brand/${this.company_id}`);
      this.brands = data.brands;
      this.selectedBrand = this.brands[0].id;
    },
    async getSub(cat_id) {
      const { data } = await axios.get(`/api/subcategory/${cat_id}`);
      this.subcategories = data.subcategories;
      this.selectedSub = this.subcategories[0].id;
    },
    async saveProduct(files, xhr, formData) {
      this.category_id = this.selectedCategory;
      this.sub_category_id = this.selectedSub;
      this.brand_id = this.selectedBrand;
      formData.append("name", this.name);
      formData.append("user_id", this.user_id);
      formData.append("company_id", this.company_id);
      formData.append("product_code", this.product_code);
      formData.append("price", this.price);
      formData.append("stocks", this.stocks);
      formData.append("category_id", this.category_id);
      formData.append("sub_category_id", this.sub_category_id);
      formData.append("brand_id", this.brand_id);
      formData.append("description", this.description);
      formData.append("sale_until", this.sale_until);
      formData.append("sale_percentage", this.sale_percentage);
    },
    async saveImage() {
      try {
        await this.$refs.myVueDropzone.processQueue();
      } catch (error) {
        if (error.response.status == 422) {
          this.errors = error.response.data.errors;
        }
        this.status = error.response.status;
      }
      //this.bus.$on('testEmit', () => alert(this.name));
    },
    afterUploadComplete: async function (response) {
      if (response.status == "success") {
        console.log("upload successful");
        this.sendSuccess = true;
        this.message = "Product Uploaded";
        this.message_type = "success";
      } else {
        console.log("upload failed");
      }
    },
  },
  watch: {
    selectedCategory: function (val) {
      this.getSub(val);
    },
  },
  created() {
    this.getCategories();

    this.token = document.querySelector('meta[name="csrf-token"]');
  },
};
</script>

<style>
</style>