
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import store from './vuex/store';
import App from './components/App.vue'

Vue.component('example', require('./components/Example.vue'));
Vue.component('counter', require('./components/Counter.vue'));
Vue.component('dragger', require('./components/Dragger.vue'));
Vue.component('dropzone', require('./components/Dropzone.vue'));

const app = new Vue({
    el: '#app',
    store,
    render: h => h(App)
});
