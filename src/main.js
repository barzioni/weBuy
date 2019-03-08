import Vue from 'vue';
import App from './App.vue';
import router from './router'
import store from './store';
import './global';
//TODO: https://github.com/asika32764/vue2-animate

Vue.config.productionTip = false;

new Vue({
    router,
    store,
    render: h => h(App)
}).$mount('#app');

