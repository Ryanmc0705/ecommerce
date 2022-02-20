<template>
  <v-app>
    <home-nav></home-nav>
    <div class="container mt-5">
      <div class="row">
        <div class="col-lg-3">
          <BrowseCategories />
        </div>
        <div class="col-lg-9">
          <div class="row">
            <div class="col-lg-10">
              <v-text-field
                label="Product Name"
                prepend-inner-icon="mdi-shopping-search"
                solo
              ></v-text-field>
            </div>
            <div class="col-lg-2">
              <v-btn color="success" large> Search </v-btn>
            </div>
          </div>
          <product-carousel></product-carousel>
        </div>
      </div>
      
      <product-slider :products="featured_products"></product-slider>
      <div class="row">
          <div class="col-lg-4">
              <product-carousel></product-carousel>
              
          </div>
          <div class="col-lg-8">
             <h2 class="text-underline">Flash Sale</h2>
             
              <div class="row">
                
                <div class="col-lg-4">
                  <product-card width="500"></product-card>
                </div>
                 <div class="col-lg-4">
                  <product-card width="500"></product-card>
                </div>
                 <div class="col-lg-4">
                  <product-card width="500"></product-card>
                </div>

                 <div class="col-lg-4">
                  <product-card width="500"></product-card>
                </div>
                 <div class="col-lg-4">
                  <product-card width="500"></product-card>
                </div>
                 <div class="col-lg-4">
                  <product-card width="500"></product-card>
                </div>
                
                
              </div>
          </div>
      </div>
      <brands-grid></brands-grid>
      <div class="row mt-5">
          <random-products v-on:newPage="addPage" :products="current_items"></random-products>
      </div>
      
       
    </div>

  <footer-layout></footer-layout>
  </v-app>
</template>

<script>
import BrowseCategories from "./../components/BrowseCategories.vue";
import ProductCarousel from "./../components/ProductCarousel";
import ProductSlider from "./../components/ProductSlider";
import BrandsGrid from "./../components/BrandsGrid";
import RandomProducts from "./../components/RandomProducts";

export default {
  components: {
    BrowseCategories: BrowseCategories,
    ProductCarousel: ProductCarousel,
    ProductSlider:ProductSlider,
    BrandsGrid:BrandsGrid,
    RandomProducts:RandomProducts
  },
  data(){
      return{
          model: null,
          current_items:{},
          item:[],
          new_items:{},
          featured_products:[],
          page:1
      }
  },
  methods:{
    async getRandomProducts(){
        const{data} = await axios.get(`/api/homeproduct/${this.page}`);
        this.new_items = data.homeProducts;
        if(this.page <= 1){
          this.current_items = this.new_items;
        }else{
             
            this.current_items = {...this.current_items,...data.homeProducts};
    
        }
         //console.log(data.data);
    },
    async getFeatured(){
      const {data} = await axios.get("/api/product/show/featured");
      this.featured_products = data.featured_products;
    },
    addPage(){
       this.page = this.page + 1;
       this.getRandomProducts();
    }
  },
  created(){
    this.getRandomProducts();
    this.getFeatured();
  }
  
};
</script>

<style>
</style>