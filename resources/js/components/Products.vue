<template>
  <v-app>
    <nav-bar pages="Brands"></nav-bar>
    <v-container>
      <h2>All Products</h2>
      <v-divider></v-divider>
      <v-btn
        color="primary"
        class="mt-4"
        ><v-icon>mdi-shape-square-plus</v-icon>New Product</v-btn
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
      <alert-message class="mt-2 mb-2" type="success" :message="message" v-if="delete_status"></alert-message>
      <v-data-table :headers="headers" :items="products" :search="search">
         <template v-slot:item.product__image="{item}">
           
            <v-img
               
                max-height="50"
                max-width="60"
                :src="item.product__image[0].image_path"
              ></v-img>
         </template>
         <template v-slot:item.category="{item}">
            {{item.category.name}}
         </template>
         <template v-slot:item.brand="{item}">
            {{item.brand.name}}
         </template>
          <template v-slot:item.featured="{item}">
              <v-checkbox v-if="item.featured == 1" input-value="true" @click="updateFeatured(item.id,0)"
              ></v-checkbox>
              <v-checkbox v-else @click="updateFeatured(item.id,1)"
              ></v-checkbox>
            
         </template>
         <template v-slot:item.action="{item}">
            <v-btn color="success" small :to="{name:'editproduct',params:{product_id:item.id}}"><v-icon>mdi-grease-pencil</v-icon>Edit</v-btn>
            <v-btn color="error" small @click="inactiveProduct(item.id)"><v-icon>mdi-trash-can</v-icon>Delete</v-btn>
         </template>
      </v-data-table>
    
    </v-container>
  </v-app>
</template>

<script>
import errorValidation from "./../mixins/ErrorValidation";
export default {
  mixins: [errorValidation],
  data() {
    return {
      products: [],
      action: null,
      search: null,
      message:null,
      delete_status:false,
      name: null,
      headers: [
        { text: "", value: "product__image" },
        { text: "Product Name", value: "name" },
        { text: "Code", value: "product_code" },
        { text: "Categories", value: "category" },
        { text: "Brand", value: "brand" },
        { text: "Remaining Stocks", value: "stocks" },
        { text: "Selling Price", value: "price" },
        { text: "Featured", value: "featured" },
        { text: "Action", value: "action" }
      ],
      
    };
  },
  methods: {
    
    async loadProducts(){
        const {data} = await axios.get(`api/product/company/${this.company_id}`);
        this.products = data.products;
    },
    async inactiveProduct(product_id)
    {
       const {data} = await axios.delete(`api/product/${product_id}`);
       if(data.message == "delete success"){
         this.delete_status = true;
         this.message = "Product Deleted";
         this.loadProducts();
       }
        
    },
    async updateFeatured(product_id,featured){
        const {data} = await axios.put(`/api/product/featured/${product_id}`,{featured:featured});
        console.log(data.message);
    }
  },
  created(){
      this.loadProducts();
  }
};
</script>

<style>
</style>