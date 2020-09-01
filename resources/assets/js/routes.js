import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)

export default new Router({
	routes:[
		{
			path: '/productos/edit',
			name: 'productos.edit',
			component: require('./components/productos/ProductoFormulario'),
		},
		// {
		// 	path: '*',
		// 	name: 'productos.edit',
		// 	component: require('./views/404'),
		// },
	],
	mode:'history'
})