<template>
  <div class="mt-5 p-4" style="background-color: white;">
    <h1 class="text-center">Top Brands On Offer</h1>
    <h6 class="text-center">The Best Brands with Exclusive Deals!</h6>
    <div class="row">
      <div class="col-lg-3" v-for="(brand,key) in brands" :key="key">
        <v-img
          max-height="150"
          max-width="250"
          :src="brand.image"
        ></v-img>
      </div>
      
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      brands: [],
    };
  },
  methods: {
    async getBrands() {
      const { data } = await axios.get("/api/brand");
      this.brands = data.brands;
    },
  },
  created() {
    this.getBrands();
  },
};
</script>