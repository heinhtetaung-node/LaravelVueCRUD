
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

// require('./bootstrap');

// window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// Vue.component('example-component', require('./components/ExampleComponent.vue'));

// const app = new Vue({
//     el: '#app'
// });

/******************************************************************/

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
import ItemTransition from './components/ItemTransition.vue';
//import EditItem from './components/EditItem.vue';

/*
*import bootstrap-vue
*/
import BootstrapVue from 'bootstrap-vue';
Vue.use(BootstrapVue);

import Employee from './components/Employee.vue';

import Register from './components/Register.vue';

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
  // {
  //     name: 'EditItem',
  //     path: '/edit/:id',
  //     component: EditItem
  //  }
    {
        name: 'Employee',
        path:'/employees',
        component: Employee
    },
    // {
    //     name: 'EditItem',
    //     path: '/edit/:id',
    //     component: EditItem
    //  }
    {       
        name: 'Register',
        path: '/register',
        component: Register
    },

];
const router = new VueRouter({ mode: 'history', routes: routes});
new Vue(Vue.util.extend({ router }, App)).$mount('#app');









