/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';


require('./bootstrap');

window.Vue = require('vue');

import VueRouter from 'vue-router'
Vue.use(VueRouter)

Vue.component('admin-component', require('./components/adminDashboard.vue').default);
Vue.component('admin-menu',require('./components/adminDashboardMenu.vue').default)

const routes = [
		{path: '/',component: require('./components/adminDashboard.vue').default},
       	{path: '/admindashboard/products', component: require('./components/productsComponent.vue').default},
      	{path: '/admindashboard/users', component:  require('./components/usersComponent.vue').default},
	  ]
const router = new VueRouter({
           routes // it is an array defined in above code
	})

const app = new Vue({
    el: '#app',
    router,
});

