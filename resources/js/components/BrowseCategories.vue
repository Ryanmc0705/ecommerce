<template>
  
    <div class="card">
      <div class="card-header">Browse Categories</div>
      <v-list>
        <v-list-group dark
          v-for="(item,key) in items" :key="key"
          no-action
        >
          <template v-slot:activator>
            <v-list-item-content>
              <v-list-item-title v-text="item.name"></v-list-item-title>
            </v-list-item-content>
          
          </template>
          

          <v-list-item v-for="sub_item in item.sub_category" :key="sub_item.name">
            <v-list-item-content>
              <v-list-item-title v-text="sub_item.name"></v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </v-list-group>
      </v-list>
    </div>
  
</template>

<script>
export default {
  data(){
    return{
      items:[]
    }
  },
  methods:{
    async getCategoriesandSub(){
      const{data} = await axios.get("/api/category/show/hompage");
      this.items = data.categories; 
    }
  },
  created(){
    this.getCategoriesandSub();
  }
};
</script>
