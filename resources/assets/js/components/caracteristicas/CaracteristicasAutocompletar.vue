 <template>
 <div style="position:relative">
  	<input type="text" placeholder="Ingresar caracteristica" class="p-6 form-input" style="border: none; display: block;"
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
			     {{ result.caracteristica }}
			    </li>
		   	</template>
	   </ul>
	</div>
 </div>
</template>
<script>

 export default{
 	props: ['caracteristicas', 'producto'],
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

				this.results = this.caracteristicas.filter(function(caracteristica){
					// console.log(caracteristica.caracteristica);
					return (caracteristica.caracteristica).toLowerCase().includes(query.toLowerCase());
				});

				// console.log(this.results);

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
				this.caracteristicas.forEach(function(caracteristica){
					if (caracteristica.caracteristica == self.results[item].caracteristica) {
						caracteristica.seleccion = true;
						caracteristica.seleccion_confirmacion = true;
						existe = true;
					}
				});
			}

			if (!existe) {
				this.guardarNuevaCaracteristica_(query);
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
		 guardarNuevaCaracteristica_(caracteristica){
            let url = '/producto/agregar_caracteristicas';
            var data = {};
            data.formulario = {};
            data.formulario.caracteristica = caracteristica[0].toUpperCase() + caracteristica.slice(1);
            data.formulario.producto_codigo = this.producto.codigo;
            axios.post(url, data)
            .then( response => {

            	// console.log(response.data);

                var nueva_caracteristica = {
                    id: response.data.id,
                    caracteristica: response.data.caracteristica,
                    seleccion: true,
                    seleccion_confirmacion: true,
                    valor: '',
                    posicion: 99,
                }

                this.caracteristicas.push(nueva_caracteristica);
                // this.caracteristicas_activas.sort(function (a, b) {
                //   if (a.caracteristica > b.caracteristica) {
                //     return 1;
                //   }
                //   if (a.caracteristica < b.caracteristica) {
                //     return -1;
                //   }
                //   // a must be equal to b
                //   return 0;
                // });
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