require('./bootstrap');

import Vue from 'vue';
import VueRouter from 'vue-router'
Vue.use(VueRouter)

import axios from 'axios';
axios.defaults.baseURL = process.env.MIX_VUE_APP_API_URL;

import { BootstrapVue } from 'bootstrap-vue'
Vue.use(BootstrapVue)
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
Vue.use(VueSweetalert2);

//Main pages
import App from './App.vue'
import EmployeeList from "./views/employee/List.vue";
import EmployeeAdd from "./views/employee/Add.vue";
import EmployeeEdit from "./views/employee/Edit.vue";

const router = new VueRouter({
    mode: 'history',
    base: '/employee',
    routes: [
        {
            path: '/',
            name: 'EmployeeList',
            component: EmployeeList
        },
        {
            path: '/create',
            name: 'EmployeeAdd',
            component: EmployeeAdd
        },
        {
            path: '/edit/:id',
            name: 'EmployeeEdit',
            component: EmployeeEdit
        }
    ]
})

const app = new Vue({
    el: '#app',
    router,
    components: { App }
});
