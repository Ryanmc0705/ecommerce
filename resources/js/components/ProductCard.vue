<template>
  <v-hover v-slot="{ hover }">
    <v-card class="mx-auto" color="grey lighten-4" :max-width="width" max-height="">
      <v-img :aspect-ratio="12 / 9" :src="image">
        <v-expand-transition> </v-expand-transition>
      </v-img>
      <v-card-text class="pt-6" style="position: relative">
        <v-btn absolute color="orange" class="white--text" fab large right top>
          <v-icon>mdi-cart</v-icon>
        </v-btn>
        

        <h6 class="font-weight-light blue--text mb-2">
          <router-link :to="{ name: 'SingleProduct',params:{id:product_id} }">{{ product }}</router-link>
        </h6>
        <h6 class="font-weight-light orange--text">${{sale_price}}</h6>
        <p v-if="sale_percentage != 0"><span style="text-decoration:line-through">{{orig_price}}</span><span>-{{sale_percentage}}%</span></p>
       
          <v-rating
            v-model="rating"
            background-color="white"
            color="yellow accent-4"
            dense
            half-increments
            size="18"
          ></v-rating
          ><span>({{ rating }})</span>
        
      </v-card-text>
    </v-card>
  </v-hover>
</template>

<script>
export default {
  props: {
    width: String,
    product: String,
    price: [Number, String],
    sale_percentage: [Number, String],
    orig_price: [Number, String],
    sale_price: [Number, String],
    image: String,
    category: String,
    product_id:[Number, String]
  },
  data() {
    return {
      rating: 4.3,
    };
  },
};
</script>

<style scoped>
.v-card--reveal {
  align-items: center;
  bottom: 0;
  justify-content: center;
  opacity: 1;
  position: absolute;
  width: 100%;
}
</style>