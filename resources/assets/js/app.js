
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

Vue.component('InfiniteLoading', require('vue-infinite-loading'));

Vue.component('example-component', require('./components/ExampleComponent.vue'));

Vue.component('categorias', require('./components/categorias/Categorias.vue'));
Vue.component('categorias-seleccionar', require('./components/categorias/CategoriasSeleccionar.vue'));
// Vue.component('categorias-autocompletar', require('./components/categorias/CategoriasAutocompletar.vue'));

Vue.component('caracteristicas', require('./components/caracteristicas/Caracteristicas.vue'));
Vue.component('caracteristicas-seleccionar', require('./components/caracteristicas/CaracteristicasSeleccionar.vue'));
Vue.component('productos', require('./components/productos/Productos.vue'));
Vue.component('producto-formulario', require('./components/productos/ProductoFormulario.vue'));

import router from './routes'


const app = new Vue({
    el: '#app',
    router
});

// Vue.filter('toCurrency', function (value) {
//     if (typeof value !== "number") {
//         return value;
//     }
//     var formatter = new Intl.NumberFormat('en-US', {
//         style: 'currency',
//         currency: 'USD',
//         minimumFractionDigits: 0
//     });
//     return formatter.format(value);
// });

require('./script_ppal');