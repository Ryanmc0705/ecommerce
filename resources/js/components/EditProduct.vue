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
                <v-text-field small solo v-model="name">
                  <template #label>
                    <span class="red--text"><strong>* </strong></span>Product
                    Name
                  </template>
                </v-text-field>
              </v-col>
              <v-col rows="12" lg="4">
                <v-text-field solo v-model="product_code">
                  <template #label>
                    <span class="red--text"><strong>* </strong></span>Code
                  </template>
                </v-text-field>
              </v-col>
              <v-col rows="12" lg="4">
                <v-text-field label="Selling Price" solo v-model="price">
                  <template #label>
                    <span class="red--text"><strong>* </strong></span>Selling
                    Price
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
                <v-text-field
                  label="Sale Percentage"
                  v-model="sale_percentage"
                  type="number"
                  solo
                >
                </v-text-field>
              </v-col>
              <v-col rows="12" lg="4">
                <v-text-field
                  label="Sale until"
                  type="date"
                  solo
                  v-model="sale_until"
                ></v-text-field>
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
                <v-btn color="primary" class="mt-3" @click="saveDetails"
                  ><v-icon>mdi-check</v-icon>Save Details</v-btn
                >
              </v-col>
            </v-row>
            <v-row>
              <v-col cols="12" lg="6">
                <label for="">Current Images</label
                ><span style="color: red"
                  >(Double Click the image to delete)</span
                >
                <alert-message
                  type="success"
                  :message="deleteMessage"
                  v-if="deleteStatus"
                ></alert-message>
                <v-row class="mt-2">
                  <v-col
                    cols="12"
                    lg="6"
                    v-for="(image, keys) in product_images"
                    :key="keys"
                  >
                    <v-img
                      max-height="150"
                      max-width="250"
                      :src="image.image_path"
                      @dblclick="deleteImage(image.id)"
                    ></v-img>
                  </v-col>
                </v-row>
              </v-col>
              <v-col cols="12" lg="6">
                <label for="">Upload New Images</label>
                <vue-dropzone
                  ref="myVueDropzone"
                  id="dropzone"
                  :options="dropzoneOptions"
                  @vdropzone-complete="afterUploadComplete"
                  @vdropzone-sending="updateProductImage"
                  :headers="{ 'X-CSRF-TOKEN': token }"
                ></vue-dropzone>
              </v-col>
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
      product_images: [],
      subcategories: [],
      product_details: [],
      selectedCategory: null,
      selectedBrand: null,
      selectedSub: null,
      sendSuccess: false,
      deleteMessage: null,
      deleteStatus: false,
      name: "",
      message: null,
      message_type: null,
      product_code: null,
      price: null,
      sale_percentage:null,
      sale_until:null,
      stocks: null,
      category_id: null,
      sub_category_id: null,
      brand_id: null,
      product_id: null,
      description: null,
      token: null,
      dropzoneOptions: {
        url: "/api/productimage",
        thumbnailWidth: 150,
        maxFilesize: 2,
        parallelUploads: 4,
        maxFiles: 3,
        autoProcessQueue: true,
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
      this.getProduct();
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
    async saveDetails() {
      try {
        this.category_id = this.selectedCategory;
        this.sub_category_id = this.selectedSub;
        this.brand_id = this.selectedBrand;
        const update_fields = {
          name: this.name,
          product_code: this.product_code,
          category_id: this.category_id,
          sub_category_id: this.sub_category_id,
          brand_id: this.brand_id,
          description: this.description,
          price: this.price,
          stocks: this.stocks,
          sale_percentage:this.sale_percentage,
          sale_until:this.sale_until
        };
        const { data } = await axios.put(
          `/api/product/${this.product_id}`,
          update_fields
        );
        //alert(data.message);
        if (data.message == "updated") {
          this.sendSuccess = "true";
          this.message = "Product Updated";
          this.message_type = "success";
        } else {
          this.sendSuccess = "false";
          solo;
        }
      } catch (error) {
        false;
      }
    },
    async saveImage() {
      this.bus.$on("testEmit", () => alert(this.name));
    },
    async deleteImage(image_id) {
      //alert(image_id);
      const { data } = await axios.delete(`/api/productimage/${image_id}`);
      if (data.message == "delete") {
        this.deleteMessage = "Image Deleted";
        this.deleteStatus = true;
      }
    },
    async updateProductImage(files, xhr, formData) {
      formData.append("product_id", this.product_id);
      formData.append("name", this.name);
      this.getProduct();
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
    async getProduct() {
      this.product_id = this.$route.params.product_id;
      const { data } = await axios.get(`/api/singleproduct/${this.product_id}`);
      this.product_details = data.product;

      this.name = this.product_details[0].name;
      this.product_code = this.product_details[0].product_code;
      this.price = this.product_details[0].price;
      this.sale_percentage = this.product_details[0].sale_percentage;
      this.sale_until = this.product_details[0].sale_until;
      this.stocks = this.product_details[0].stocks;
      this.selectedCategory = this.product_details[0].category_id;
      this.selectedSub = this.product_details[0].sub_category_id;
      this.selectedBrand = this.product_details[0].brand_id;
      this.description = this.product_details[0].description;
      this.product_images = this.product_details[0].product__image;
    },
  },
  watch: {
    selectedCategory: function (val) {
      this.getSub(val);
    },
  },
  mounted() {
    this.getCategories();
    //this.getProduct();
  },
};
</script>

<style>
</style>