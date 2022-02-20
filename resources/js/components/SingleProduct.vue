<template>
  <v-app>
    <home-nav></home-nav>
    <v-banner>
      <div class="container" color="#4f4f4f">
        <h2>Product Page</h2>
      </div>
    </v-banner>
    <div class="container">
      <v-card elevation="2" class="p-4">
        <div class="row">
          <div class="col-md-5">
            <div class="row">
              <div class="col-md-12">
                    <inner-image-zoom hasSpacer="true" class="thumbnail" :srcSet="thumbnail" :src="thumbnail" :zoomSrc="thumbnail" zoomScale="2" zoomType="hover" />
              </div>
            </div>
            <div class="row">
              <div
                class="col-md-3"
                v-for="(image, keys) in product.product__image"
                :key="keys"
              >
                <v-card elevation="1">
                  <v-img max-height="200" :src="image.image_path" @click="thumbnail = image.image_path"></v-img>
                </v-card>
              </div>
            </div>
          </div>
          <div class="col-md-7">
            <div class="row">
              <div class="col-md-12">
                <div class="p-4">
                  <h3>{{ product.name }}</h3>

                  <v-rating
                    v-model="rating"
                    background-color="orange lighten-3"
                    color="orange"
                    medium
                  ></v-rating>
                  <p class="mt-2">
                    {{ product.description }}
                  </p>
                  <p>
                    Brand:<strong>{{ product.brand.name }}</strong>
                  </p>
                  <p>Category:<strong>Shoes</strong></p>
                  <h4>
                    Current Price:<strong class="green--text">{{
                      product.price
                    }}</strong>
                  </h4>
                  <v-divider> </v-divider>
                  <div class="row">
                    <div class="col-md-3">
                      <v-text-field
                        hide-details
                        solo
                        type="number"
                        label="quantity"
                        height="10"
                      />
                    </div>
                    <div class="col-md-4">
                      <v-btn color="default">
                        <v-icon>mdi-cart</v-icon>
                        Add to Cart
                      </v-btn>
                    </div>
                    <div class="col-md-4">
                      <v-btn color="primary"> Buy Now </v-btn>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </v-card>
      <v-card elevation="2" class="p-2 mt-3">
        <div class="row">
          <div class="col-md-12">
            <v-tabs v-model="tab" align-with-title>
              <v-tabs-slider color="yellow"></v-tabs-slider>

              <v-tab>Description</v-tab>
              <v-tab>Information</v-tab>
              <v-tab>Reviews</v-tab>
            </v-tabs>
            <v-tabs-items v-model="tab">
              <v-tab-item>
                <v-card flat>
                  <div class="container">test</div>
                </v-card>
              </v-tab-item>
              <v-tab-item>
                <v-card flat>
                  <v-card-text>Information</v-card-text>
                </v-card>
              </v-tab-item>
            </v-tabs-items>
          </div>
        </div>
      </v-card>
    </div>
    <!--  -->
  </v-app>
</template>

<script>
import 'vue-inner-image-zoom/lib/vue-inner-image-zoom.css';
import InnerImageZoom from 'vue-inner-image-zoom';
export default {
  data() {
    return {
      rating: 3,
      tab: null,
      thumbnail: null,
      product: [],
      width:500,
      height:600,
    };
  },
  components:{
    'inner-image-zoom': InnerImageZoom
  },

  methods: {
    async getProductDetail() {
      const { data } = await axios.get(
        `/api/product/details/display/${this.$route.params.id}`
      );
      this.product = data.product[0];
      this.thumbnail = this.product.product__image[0].image_path;
      //console.log(this.product);
    },
  },
  created() {
    //alert(this.$route.params.id);
    this.getProductDetail();
  },
};
</script>

<style scoped>
body {
  background-color: white;
}
.v-text-field .v-input__control .v-input__slot {
  min-height: 0 !important;
  display: flex !important;
  align-items: center !important;
}
.thumbNail{
  width: 100%;
  height: 500px;
}
</style>