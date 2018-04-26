
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.confirmDelete = function(link) {
    let message = confirm('Are you sure you want to delete the "'+ link.dataset.title +'" item?');
    if( message === true ) {
        return document.getElementById( link.dataset.formName ).submit();
    } else {
        return false;
    }
};

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example-component', require('./components/ExampleComponent.vue'));

const app = new Vue({
    el: '#app'
});
