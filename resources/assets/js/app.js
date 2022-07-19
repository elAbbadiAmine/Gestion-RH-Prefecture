/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
import Vue from 'vue';
window.Vue = require('vue');
import moment from 'moment';
import {
    Button,
    HasError,
    AlertError,
    AlertErrors,
    AlertSuccess
} from 'vform/src/components/bootstrap5'
// 'vform/src/components/bootstrap4'
// 'vform/src/components/tailwind'
import { Form } from 'vform';

Vue.component(Button.name, Button)
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)
Vue.component(AlertErrors.name, AlertErrors)
Vue.component(AlertSuccess.name, AlertSuccess)

Vue.use(require('vue-moment'));

import swal from 'sweetalert2'
window.swal = swal;

const toast = swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
});

window.toast = toast;


window.Form = Form;
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)



import VueRouter from 'vue-router'
Vue.use(VueRouter)

import VueProgressBar from 'vue-progressbar'
Vue.use(VueProgressBar, {
    color: 'rgb(143, 255, 199)',
    failedColor: 'red',
    height: '3px'
})

let routes = [
    {
        path: '/users',
        components: require('./components/Users.vue')
    },
    {
        path: '/profile',
        components: require('./components/Profile.vue')
    },
    {
        path: '/Division',
        components: require('./components/Divisions.vue')
    },
    {
        path: '/Service/:id?',
        components: require('./components/Service.vue')
    },
    {
        path: '/Demande_conge',
        components: require('./components/Demande_conge.vue')
    },
    {
        path: '/Demande_document_RH',
        components: require('./components/Demande_doc_RH.vue')
    },
    {
        path: '/Depot_Demande_conge',
        components: require('./components/Depot_Demande_conge.vue')
    },
    {
        path: '/Depot_Demande_document_RH',
        components: require('./components/Depot_Demande_doc_RH.vue')
    },
    {
        path: '/Demande_conge_chef',
        components: require('./components/Demande_conge_chef.vue')
    },
    {
        path: '/Demande_document_RH_chef',
        components: require('./components/Demande_document_RH_chef.vue')
    },
    {
        path: '/Demande_conge_all',
        components: require('./components/Demande_conge_all.vue')
    },
    {
        path: '/Demande_document_RH_all',
        components: require('./components/Demande_document_RH_all.vue')
    },
    {
        path: '*',
        components: require('./components/Dashboard.vue')
    },
]

const router = new VueRouter({
    mode: 'hash',
    routes: routes // short for routes: routes
})



Vue.filter('upText', function(text) {
    return text.charAt(0).toUpperCase() + text.slice(1)
});

Vue.filter('myDate', function(created) {
    return moment(created).format('MMMM Do YYYY');
});


window.Fire = new Vue();

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


Vue.component(
    'passport-clients',
    require('./components/passport/Clients.vue').default
);

Vue.component(
    'passport-authorized-clients',
    require('./components/passport/AuthorizedClients.vue').default
);

Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue').default
);



Vue.component('example-component', require('./components/ExampleComponent.vue').default);

const app = new Vue({
    el: '#app',
    router,
    data: {
        search: ''
    },
    methods: {
        searchit: _.debounce(() => {
            Fire.$emit('searching');
        }, 1000),

        printme() {
            window.print();
        }
    }
});