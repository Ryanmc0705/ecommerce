<template>
  <div class="row">
        <div class="col-lg-12">
            
          <v-sheet class="mx-auto" elevation="1">
            <h1 class="text-center">Featured Products</h1>
            <v-slide-group
              v-model="model"
              class="pa-5"
              center-active
              show-arrows
            
            >
              <v-slide-item
                v-for="(product,key) in products"
                :key="key"
                >
                 <product-card width="200" class="ml-4 mr-5" :product="product.name" :price="product.price" :image="product.product__image[0].image_path"  :category="product.category.name" :product_id="product.id" ></product-card>
              </v-slide-item>
            </v-slide-group>
          </v-sheet>
        </div>
      </div>
</template>

<script>

export default {
  props:["products"],
  data(){
      return{
          model: null,
      }
  }
};
</script>

<style>

</style>