<template>
    <div class="container">
        <!-- navbar.vue -->   
        <b-navbar toggleable="md" type="dark" variant="info">
            <b-navbar-brand href="/">Home</b-navbar-brand>
            <b-navbar-brand href="#">Category</b-navbar-brand>
            <b-navbar-brand >
                <router-link :to="{ name: 'Item' }">Items</router-link>
            </b-navbar-brand>
            <b-navbar-brand >
                <router-link :to="{ name: 'Employee' }">Employee</router-link>
            </b-navbar-brand> 
            <b-navbar-brand href="customer">Customer</b-navbar-brand>
            <b-navbar-brand href="supplier">Supplier</b-navbar-brand>
            <b-navbar-brand>
                <router-link :to="{ name: 'ItemTransition' }">Item Transition</router-link>
            </b-navbar-brand>
             
        </b-navbar>
        <!-- navbar.vue --> 
        <div>
            <transition name="fade">
                <router-view></router-view>
            </transition>
        </div>
    </div>
</template>
<style>
    .fade-enter-active, .fade-leave-active {
      transition: opacity .5s
    }
    .fade-enter, .fade-leave-active {
      opacity: 0
    }
</style>
<script>
    export default{
    }
</script>