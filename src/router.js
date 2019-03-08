import Vue from 'vue';
import VueRouter from 'vue-router';
import store from './store';

import Explore from './pages/Explore.vue';
import Register from './pages/Register.vue';
import Login from './pages/Login.vue';
import Account from './pages/Account.vue';
import Create from './pages/Create.vue';
import Product from './pages/Product.vue';

Vue.use(VueRouter);

const routes = [
    {path: '/', component: Explore},
    {path: '/register', component: Register},
    {path: '/login', component: Login},
    {path: '/create', component: Create},
    // {
    //     path: '/create', component: Create, beforeEnter(to, from, next) {
    //         if(store.state.user.token){
    //             next()
    //         }else{
    //             next('/login')
    //         }
    //     }
    // },
    {path: '/account', component: Account},
    {path: '/product/:id', component: Product},
];

export default new VueRouter({
    routes: routes,
    mode: 'history',
    linkExactActiveClass: 'text-dark'
})