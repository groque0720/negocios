 <template>
 <div style="position:relative">
  	<input type="text" placeholder="Ingresar Red Social" class="p-6 form-input" style="border: none; display: block;"
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
			     {{ result.red_social }}
			    </li>
		   	</template>
	   </ul>
	</div>
 </div>
</template>
<script>

 export default{
 	props: ['redes'],
	data(){
		return {
			query: '',
			results: [],
			recorrido:'',
		}
	},
	methods: {
		autoComplete(){
			console.log(this.redes);
			self = this;
			this.results = [];
			this.recorrido = 0;
			var query = this.query;
			if(this.query.length > 0){
				this.results = this.redes.filter(function(red_social){
					return (red_social.red_social).toLowerCase().includes(query.toLowerCase());
				});
			}
		},
		seleccionarItem(item){
			// alert(this.results[item].detalle);
			var query = this.query;
			self = this;
			var existe = false;
			if (this.results.length) {
				this.redes.forEach(function(red_social){
					if (red_social.red_social == self.results[item].red_social) {
						red_social.seleccion = true;
						red_social.seleccion_confirmacion = true;
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

            })
        },
	}
 }
</script>

