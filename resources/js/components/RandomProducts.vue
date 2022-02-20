<template>
  <div class="mt-5 container card">
    <h1 class="text-center">Just for You</h1>

    <div class="row">
      <div class="col-lg-3" v-for="(product,key) in products" :key="key">
        <product-card width="300" class="ml-4 mr-5" :product="product.name" :price="product.price" :image="product.product_image[0].image_path"  :category="product.category.name" 
          :sale_percentage="product.sale_percentage" :sale_price="product.sale_price" :orig_price="product.orig_price" :product_id="product.id"
        ></product-card>
      </div>
      
    </div>
    <div class="text-xs-center">
      <v-btn class="mt-5" outlined color="primary" style = "margin: 0 auto; display: block;" @click="newPage" >
        Load More
      </v-btn>
    </div>
  </div>
</template>
<script>
export default {
  methods:{
    newPage(){
      this.$emit("newPage");
    }
  },
  props:["products"]

}
</script>