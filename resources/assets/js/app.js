
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

require('vue-image-lightbox/dist/vue-image-lightbox.min.css');

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
Vue.component('categorias-autocompletar', require('./components/categorias/CategoriasAutocompletar.vue'));

Vue.component('caracteristicas', require('./components/caracteristicas/Caracteristicas.vue'));
Vue.component('caracteristicas-seleccionar', require('./components/caracteristicas/CaracteristicasSeleccionar.vue'));
Vue.component('caracteristicas-autocompletar', require('./components/caracteristicas/CaracteristicasAutocompletar.vue'));

Vue.component('productos', require('./components/productos/Productos.vue'));
Vue.component('producto-formulario', require('./components/productos/ProductoFormulario.vue'));
Vue.component('productos-seleccionar', require('./components/productos/ProductosSeleccionar.vue'));

Vue.component('layout-public', require('./components/layout_public/Layout.vue'));
Vue.component('layout-busqueda-autocompletar', require('./components/layout_public/BusquedaAutocompletar.vue'));
Vue.component('layout-cabecera', require('./components/layout_public/Cabecera.vue'));
Vue.component('layout-redes-sociales', require('./components/layout_public/RedesSociales.vue'));
Vue.component('layout-grid-columnas', require('./components/layout_public/GridColumnas.vue'));
Vue.component('layout-grid-columnas-ordenado', require('./components/layout_public/GridColumnasOrdenado.vue'));
// Vue.component('layout-grid-albumes', require('./components/layout_public/GridAlbumes.vue'));
Vue.component('layout-producto', require('./components/layout_public/Producto.vue'));
Vue.component('layout-productos-mismas-categorias', require('./components/layout_public/ProductosMismasCategorias.vue'));
Vue.component('layout-albumes-mismas-categorias', require('./components/layout_public/AlbumesMismasCategorias.vue'));
Vue.component('layout-productos-filtro-categorias', require('./components/layout_public/ProductosFiltroCategorias.vue'));

Vue.component('redes-sociales', require('./components/redessociales/index.vue'));

Vue.component('validador', require('./components/validador/ValidadorForm.vue'));

// import router from './routes'
import myMixin from './mixins';

const app = new Vue({
    el: '#app',
    // router,
    mixins: [myMixin]
});

// in main =.js
// -> Vue.prototype.$appName = 'My App'
////in components
 // -> console.log(this.$appName)

require('./script_ppal');