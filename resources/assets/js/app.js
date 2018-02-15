
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import router from './routes.js'

require('./bootstrap');

window.Vue = require('vue');

import VueRouter from 'vue-router'
// notif toastr
import VueToastr from '@deveodk/vue-toastr'
import '@deveodk/vue-toastr/dist/@deveodk/vue-toastr.css'
import Datepicker from 'vuejs-datepicker'
import VueSweetalert2 from 'vue-sweetalert2'
import VueNumeric from 'vue-numeric'

Vue.use(VueNumeric)
Vue.use(VueSweetalert2)
Vue.use(VueRouter)
Vue.use(VueToastr)
Vue.use(require('vue-moment'));

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example', require('./components/Example.vue'));

const app = new Vue({
    el: '#app',
    router,
    VueToastr,	
    components: {
        Datepicker,
        VueNumeric
    },
    methods: {
    	// formatHarga: function(value, nol) {
	    //     let val = (value/1).toFixed(nol).replace('.', ',')
	    //     return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
	    // }
    },

});
