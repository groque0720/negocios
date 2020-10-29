 <template>
 <div style="position:relative" class="ancho-sx-95 ancho-s-90 ancho-m-70 ancho-l-60 ancho-lg-50">
 	<div class="flex flex-item-center flex-space-between p-10 zona-buscador" :class="{ 'zona-buscador-items': items_filter.length }">
 		<div class="ancho-100">
		   	<input type="search" :placeholder="'Buscar en '+negocio.nombre" class="p-6 form-input-buscador"
		  		v-model="query_"
		  		@input="evt=>autoComplete(evt)"
		  		@keydown.down="down"
		  		@keydown.up="up"
		  		@click="evt=>autoComplete(evt)"
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
	<div class="panel-lista ancho-100 flex flex-direction-column" v-if="items_filter.length && mostrar" >
	   <ul class="lista p-b-10" >
		   	<template v-for="(item, indice) in items_filter">
		   		<template v-if="indice<7">
				    <li class="items" v-bind:id="indice" @click="seleccionarItem(indice)"  v-bind:class="{'active': isActive(indice)}">
				     {{ item }}
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
			items_filter:[],
			items_total: [],
			recorrido:0,
			mostrar:true,
			valor_input:'',
		}
	},
	mounted(){
		this.buscar_items();
	},
	methods: {
		buscar_items(){
			let url = '/'+this.negocio.url+'/items_de_busqueda';
		    axios.get(url,{
		     	params: {
		     		query_: this.query_,
		     		negocio_url: this.negocio.url,
		     	}}).then(res => {
		     		this.items_total = res.data;
		     		// console.log(this.items_total);
		   //   		this.results = result.filter(function(result){
		   //   			return self.quitarAcentos(result).toLowerCase().includes(self.quitarAcentos(query_).toLowerCase());
					// });
		    });
		},
		autoComplete(evt){
			self = this;
			// this.results = [];
			this.recorrido = -1;
			var query_ = evt.target.value;
			this.valor_input = evt.target.value;

			if(query_.length > 0){
				this.items_filter = this.items_total.filter(function(item){
	     			return self.quitarAcentos(item).toLowerCase().includes(self.quitarAcentos(query_).toLowerCase());
				});
			}else{
				this.items_filter = [];
			}

			// if(this.query_.length > 0){
			// 	let url = '/'+this.negocio.url+'/items_de_busqueda';
			//     axios.get(url,{
			//      	params: {
			//      		query_: this.query_,
			//      		negocio_url: this.negocio.url,
			//      	}}).then(res => {
			//      		var result = res.data;
			//      		this.results = result.filter(function(result){
			//      			return self.quitarAcentos(result).toLowerCase().includes(self.quitarAcentos(query_).toLowerCase());
			// 			});
			//     });
			// }
		},
		quitarAcentos(cadena){
			const acentos = {'á':'a','é':'e','í':'i','ó':'o','ú':'u','Á':'A','É':'E','Í':'I','Ó':'O','Ú':'U'};
			return cadena.split('').map( letra => acentos[letra] || letra).join('').toString();
		},
		seleccionarItem(item){
			var query_ = '';
			var existe = false;
			self = this;
			query_ = this.query_;
			this.query_ = this.items_filter[item];
			if (this.items_total) {
				this.items_total.forEach(function(item_total){
					if (item_total == self.query_) {
						existe = true;
						query_ = item_total;
					}
				});
			}
			window.location = '/'+this.negocio.url+'/search?q='+encodeURIComponent(query_);
		},
		down(){
			if(this.recorrido < this.items_filter.length - 1){
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
			this.items_filter = [];
			this.query_ = '';
			$(".form-input-buscador").focus();
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