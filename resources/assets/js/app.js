
// app.js
import Vue from 'vue';
import VueRouter from 'vue-router';
Vue.use(VueRouter);
import VueAxios from 'vue-axios';
import axios from 'axios';
Vue.use(VueAxios, axios);
import App from './App.vue';
//import CreateItem from './components/CreateItem.vue';
import Item from './components/Item.vue';
import Category from './components/Category.vue';
import Customer from './components/Customer.vue';
import Supplier from './components/Supplier.vue';
import ItemTransition from './components/ItemTransition.vue';
//import EditItem from './components/EditItem.vue';
const routes = [
    // {
    //   name: 'CreateItem',
    //   path: '/items/create',
    //   component: CreateItem
    // },
    {
        name: 'Item',
        path: '/',
        component: Item
    },
    {
        name: 'ItemTransition',
        path: '/item/item-transition',
        component: ItemTransition
    },
    {
        name: 'Category',
        path: '/category',
        component: Category
    },
    {
          name: 'Customer',
          path: '/customer',
          component: Customer
    },
     {
          name: 'Supplier',
          path: '/supplier',
          component: Supplier
    },
    // {
    //     name: 'EditItem',
    //     path: '/edit/:id',
    //     component: EditItem
    //  }
];
const router = new VueRouter({ mode: 'history', routes: routes});
new Vue(Vue.util.extend({ router }, App)).$mount('#app');
