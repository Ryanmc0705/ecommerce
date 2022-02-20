<template>
  <div>
    <v-app-bar light style="background-color: #1976d2">
      <v-app-bar-nav-icon @click="drawer = true"></v-app-bar-nav-icon>

      <v-toolbar-title class="text-right ml-10">{{ pages }}</v-toolbar-title>
    </v-app-bar>

    <v-navigation-drawer v-model="drawer" absolute fixed>
      <v-list nav dense>
        <v-list-item-group
          v-model="group"
          active-class="deep-blue--text text--accent-4"
        >
          <h2 class="text-center">E-Store 2 Go</h2>
           <v-list-item class="px-2">
        <v-list-item-avatar>
          <v-img src="https://randomuser.me/api/portraits/men/85.jpg"></v-img>
        </v-list-item-avatar>

        <v-list-item-title>{{fullname}}</v-list-item-title>
      
      

        <v-btn
          icon
          @click.stop="drawer = false"
        >
          <v-icon>mdi-chevron-left</v-icon>
        </v-btn>
      </v-list-item>

          <v-divider></v-divider>
          <router-link :to="{ name: 'dashboard' }">
            <v-list-item>
              <v-list-item-icon>
                <v-icon>mdi-desktop-mac-dashboard</v-icon>
              </v-list-item-icon>
              <v-list-item-title class="links">Dashboard</v-list-item-title>
            </v-list-item>
          </router-link>
          <router-link :to="{ name: 'dashboard' }">
            <v-list-item>
              <v-list-item-icon>
                <v-icon>mdi-account</v-icon>
              </v-list-item-icon>
              <v-list-item-title class="links">Users</v-list-item-title>
            </v-list-item>
          </router-link>
          <router-link :to="{ name: 'categories' }">
            <v-list-item>
              <v-list-item-icon>
                <v-icon>mdi-format-list-numbered</v-icon>
              </v-list-item-icon>
              <v-list-item-title class="links">Categories</v-list-item-title>
            </v-list-item>
          </router-link>
          <router-link :to="{ name: 'brands' }">
            <v-list-item>
              <v-list-item-icon>
                <v-icon>mdi-tshirt-crew-outline</v-icon>
              </v-list-item-icon>
              <v-list-item-title class="links">Brands</v-list-item-title>
            </v-list-item>
          </router-link>

          <v-list-group>
            <template v-slot:activator>
              <v-list-item-icon>
                <v-icon>mdi-briefcase</v-icon>
              </v-list-item-icon>
              <v-list-item-title>Products</v-list-item-title>
            </template>

            <v-list-item>
              <v-list-item-content>
                <router-link :to="{ name: 'products' }">
                  <v-list-item-title class="ml-3"
                    >All Products</v-list-item-title
                  >
                </router-link>
              </v-list-item-content>
            </v-list-item>
            <v-list-item>
              <v-list-item-content>
                <router-link :to="{ name: 'newproduct' }">
                  <v-list-item-title class="ml-3"
                    >New Product</v-list-item-title
                  >
                </router-link>
              </v-list-item-content>
            </v-list-item>
          </v-list-group>

          <v-list-item @click="logout">
            <v-list-item-icon>
              <v-icon>mdi-logout</v-icon>
            </v-list-item-icon>
            <v-list-item-title class="links">Log Out</v-list-item-title>
          </v-list-item>
        </v-list-item-group>
      </v-list>
    </v-navigation-drawer>
  </div>
</template>
<script>

import errorValidation from "./../mixins/ErrorValidation";
export default {
  mixins:[errorValidation],
  data: () => ({
    drawer: true,
    group: null,
    mini: true,
  }),
  methods: {
    async logout() {
      await axios.get("/api/user/logout");
      this.$router.push({ name: "login" });
    },
  },
 
  props: { pages: String },
};
</script>
<style scoped>
</style>

