/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');


let moment = require('moment');


const swal = (window.swal = require("sweetalert2"));



/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))


Vue.component('chat-app', require('./components/ChatApp.vue').default);
Vue.component('notification-app', require('./components/Notification.vue').default);
Vue.component('comment-board', require('./components/CommentBoard.vue').default);
Vue.component('favorite-circle', require('./components/FavoriteCircle.vue').default);
Vue.component('favorite-button', require('./components/FavoriteButton.vue').default);
Vue.component('my-favorite', require('./components/MyFavorite.vue').default);
Vue.component('auto-search', require('./components/AutoSearch.vue').default);
Vue.component('product-item', require('./components/ProductItem.vue').default);
Vue.component('user-profile', require('./components/UserProfile.vue').default);
Vue.component('cart-item', require('./components/CartItem.vue').default);


import VueChatScroll from 'vue-chat-scroll'

Vue.use(VueChatScroll);


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
