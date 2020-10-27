 <template>
 <div style="position:relative" class="ancho-sx-95 ancho-s-90 ancho-m-70 ancho-l-60 ancho-lg-50">
 	<div class="flex flex-item-center flex-space-between p-10 zona-buscador" :class="{ 'zona-buscador-items': results.length }">
 		<div class="ancho-95">
		   	<input type="text" :placeholder="'Buscar en '+negocio.nombre" class="p-6 form-input-buscador"
		  		v-model="query_"
		  		@input="autoComplete"
		  		@keydown.down="down"
		  		@keydown.up="up"
		  		@click="autoComplete"
		  		v-on:keypress.enter.prevent="seleccionarItem(recorrido)"
		  		>
 		</div>
 		<div class="ancho-5 flex flex-item-center flex-content-center">
 			<div v-if="query_.length">
                <a href="#" @click.prevent="borrarInputBuscar()">
                    <i class="fas fa-times txt-gris"></i>
                </a>
            </div>
 		</div>
 	</div>
	<div class="panel-lista ancho-100 flex flex-direction-column" v-if="results.length && mostrar" >
	   <ul class="lista p-b-10" >
		   	<template v-for="(result, indice) in results">
		   		<template v-if="indice<7">
				    <li class="items" v-bind:id="indice" @click="seleccionarItem(indice)"  v-bind:class="{'active': isActive(indice)}">
				     {{ result }}
				    </li>
		   		</template>
		   	</template>
	   </ul>
	</div>
 </div>
</template>
<script>

 export default{
 	props: ['negocio','query'],
	data(){
		return {
			query_: this.query,
			results: [],
			recorrido:0,
			mostrar:true,
		}
	},
	// mounted(){
	// 	console.log(this.query);
	// },
	methods: {
		autoComplete(){
			self = this;
			this.results = [];
			this.recorrido = -1;
			var query_ = this.query_;
			if(this.query_.length > 0){
				let url = '/'+this.negocio.url+'/items_de_busqueda';
			    axios.get(url,{
			     	params: {
			     		query_: this.query_,
			     		negocio_url: this.negocio.url,
			     	}}).then(res => {
			     		var result = res.data;
			     		this.results = result.filter(function(result){
			     			return self.quitarAcentos(result).toLowerCase().includes(self.quitarAcentos(query_).toLowerCase());
						});
			    });
			}
		},
		quitarAcentos(cadena){
			const acentos = {'á':'a','é':'e','í':'i','ó':'o','ú':'u','Á':'A','É':'E','Í':'I','Ó':'O','Ú':'U'};
			return cadena.split('').map( letra => acentos[letra] || letra).join('').toString();
		},
		seleccionarItem(item){
			// this.query_ = this.results[item];

			var query_ = '';
			query_ = this.query_;
			this.query_ = this.results[item];

			self = this;
			var existe = false;
			if (this.results.length) {
				this.results.forEach(function(item){
					if (item == self.query_) {
						existe = true;
						query_ = item;
					}
				});
			}

			window.location = '/'+this.negocio.url+'/search?q='+query_;

			this.query_ = '';
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
		borrarInputBuscar(){
			// window.location = '/'+this.negocio.url;
			this.results = [];
			this.query_ = '';
		},
		 isActive (index) {
		    return index === this.recorrido
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