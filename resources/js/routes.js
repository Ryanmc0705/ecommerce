import VueRouter from "vue-router";
import Registration from "./components/Registration";
import Login from "./components/Login";
import Brands from "./components/Brands";
import DashBoard from "./components/DashBoard";
import Categories from "./components/Categories";
import SubCategories from "./components/SubCategories";
import Products from "./components/Products";
import NewProduct from "./components/NewProduct";
import EditProduct from "./components/EditProduct";
import HomePage from "./views/HomePage";
import SingleProduct from "./components/SingleProduct";
const routes = [
  {
    path: "/registration",
    component: Registration,
    name: "Registration"
  },
  {
    path: "/",
    component: Login,
    name: "login"
  },
  {
    path: "/dashboard",
    component: DashBoard,
    name: "dashboard"
  },
  {
    path: "/categories",
    component: Categories,
    name: "categories"
  },
  {
    path: "/subcategories/:category_id/:header_text",
    component: SubCategories,
    name: "subcategories"
  },
  {
    path: "/Brands",
    component: Brands,
    name: "brands"
  },
  {
    path: "/products",
    component: Products,
    name: "products"
  },
  {
    path: "/newproduct",
    component: NewProduct,
    name: "newproduct"
  },
  {
    path: "/editproduct/:product_id",
    component: EditProduct,
    name: "editproduct"
  },
  {
    path: "/home",
    component: HomePage,
    name: "home"
  },
  {
    path: "/product/:id",
    component: SingleProduct,
    name: "SingleProduct"
  }

];
const router = new VueRouter({
  routes,
  mode: "history"
});
export default router;