import Index from "./Index";
import Vue from "vue";   
import Vuetify from 'vuetify';
import 'vuetify/dist/vuetify.min.css';
import '@mdi/font/css/materialdesignicons.css';
import VueRouter from 'vue-router'
import router from "./routes";
import axios from "axios";
import AlertMessage from "./usables/AlertMessage";
import ErrorMessage from "./usables/ErrorMessage";
import NavBar from "./layouts/NavBar";
import storeDefinition from "./store/storeDefinition";
import Vuex from "vuex";
import moment from "moment";
import RichTextEditor from 'rich-text-editor-vuetify';
import HomeNav from "./layouts/HomeNav";
import FooterLayout from "./layouts/FooterLayout";
import ProductCard from "./components/ProductCard";

axios.defaults.withCredentials = true;
window.Vue = require('vue');
Vue.use(Vuetify);
Vue.component("alert-message",AlertMessage);
Vue.component("error-message",ErrorMessage);
Vue.component("nav-bar",NavBar);
Vue.component("home-nav",HomeNav);
Vue.component("footer-layout",FooterLayout);
Vue.component("product-card",ProductCard);
Vue.use(VueRouter);
Vue.use(Vuex);
Vue.use(RichTextEditor);

const store = new Vuex.Store(storeDefinition);
Vue.filter("LongFormat",value=>moment(value).format("LL"));
require('./bootstrap');


const app = new Vue({
    el: '#app',
    store,
    components:{
        index:Index,
        
    },
    router,
    vuetify: new Vuetify(),  

});
