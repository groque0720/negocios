
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
Vue.component('productos-seleccionar', require('./components/productos/ProductosSeleccionar.vue'));

Vue.component('layout-columnas', require('./components/layout_public/LayoutColumnas.vue'));

import router from './routes'
import myMixin from './mixins'

const app = new Vue({
    el: '#app',
    router,
    mixins: [myMixin]
});

// in main =.js
// -> Vue.prototype.$appName = 'My App'
////in components
 // -> console.log(this.$appName)

require('./script_ppal');