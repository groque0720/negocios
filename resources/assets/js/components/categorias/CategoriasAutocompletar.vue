 <template>
 <div style="position:relative">
  	<input type="text" placeholder="Ingresar categoria" class="p-6 form-input" style="border: none; display: block;"
  		v-model="query"
  		@input="autoComplete"
  		@keydown.down="down"
  		@keydown.up="up"
  		v-on:keypress.enter.prevent="seleccionarItem(recorrido)"
  		>
	<div class="panel-lista ancho-100" v-if="results.length" >
	   <ul class="lista">
		   	<template v-for="(result, indice) in results">
			    <li class="items" v-bind:id="indice" @click="seleccionarItem(indice)"  v-bind:class="{'active': isActive(indice)}">
			     {{ result.categoria }}
			    </li>
		   	</template>
	   </ul>
	</div>
 </div>
</template>
<script>

 export default{
 	props: ['categorias', 'producto'],
	data(){
		return {
			query: '',
			results: [],
			recorrido:'',
		}
	},
	methods: {
		autoComplete(){
			self = this;
			this.results = [];
			this.recorrido = 0;
			var query = this.query;
			if(this.query.length > 0){

				this.results = this.categorias.filter(function(categoria){
					console.log(categoria.categoria);
					return (categoria.categoria).toLowerCase().includes(query.toLowerCase());
				});

				// console.log(this.results);
				// this.categorias.forEach(function(categoria){
				// 	// console.log(categoria.categoria+' '+self.query.toLowerCase());

				// 	if (categoria.categoria.toLowerCase() == self.query.toLowerCase()) {
				// 		self.results.push(categoria);
				// 	}
				// });
			    // axios.get('/categorias/categorias_buscar_autocompletar',{
			    //  	params: {
			    //  		query: this.query
			    //  	}}).then(res => {
			    //  	// console.log(res.data);
			    //   	this.results = res.data;
			    // });
			}
		},
		seleccionarItem(item){
			// alert(this.results[item].detalle);
			var query = this.query;
			self = this;
			var existe = false;
			if (this.results.length) {
				this.categorias.forEach(function(categoria){
					if (categoria.categoria == self.results[item].categoria) {
						categoria.seleccion = true;
						categoria.seleccion_confirmacion = true;
						existe = true;
					}
				});
			}

			if (!existe) {
				this.guardarNuevacategoria_(query);
			}
			this.query = '';
			this.results = [];
		},
		down(){
			if(this.recorrido < this.results.length - 1){
 	           this.recorrido++;
			}
		},
		up(){
			if(this.recorrido > 0){
            	this.recorrido--;
			}
		},
		 isActive (index) {
		    return index === this.recorrido
		 },
		 guardarNuevacategoria_(categoria){
            let url = '/producto/agregar_categorias';
            var data = {};
            data.formulario = {};
            data.formulario.categoria = categoria[0].toUpperCase() + categoria.slice(1);
            data.formulario.producto_codigo = this.producto.codigo;
            axios.post(url, data)
            .then( response => {

            	console.log(response.data);
                var nueva_categoria = {
                    id: response.data.id,
                    categoria: response.data.categoria,
                    seleccion: true,
                    seleccion_confirmacion: true,
                    posicion: 99,
                }
                this.categorias.push(nueva_categoria);
                this.categorias_view = this.ordenarCategorias();
                this.query = '';
                this.categorias.sort(function (a, b) {
                  if (a.posicion > b.posicion) {
                    return 1;
                  }
                  if (a.posicion < b.posicion) {
                    return -1;
                  }
                  // a must be equal to b
                  return 0;
                });
                // this.ocultarFormulario();
                // Swal.fire({
                //   position: 'top-end',
                //   icon: 'success',
                //   title: '',
                //   showConfirmButton: false,
                //   timer: 1000,
                //   width: '180px',
                // })
            })
        },
	}
 }
</script>

<!-- <style>
	.panel-lista {
		position: absolute !important;
		border: 1px solid #E5E2E2;
		z-index: 10000000;
		background: white;
		overflow-y: auto;
		max-height: 200px;
		width: 100%;
		box-shadow: 0px 1px 3px #080808;
	}
	.items {
		list-style: none;
		padding: 5px;
		font-size: 12px;
		cursor: pointer;
	}
	.items:hover {
		background: var(--main-ppal-color);
		color: white;
	}
	.active {
		background: var(--main-ppal-color);
		color: white;
	}

</style> -->