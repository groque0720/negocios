 <template>
 <div style="position:relative">
  	<input type="text" placeholder="Ingresar Código" class="form-input" id="codigo_presupuesto"
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
	data(){
		return {
			query: '',
			results: [],
			recorrido:'',
		}
	},
	methods: {
		autoComplete(){
			this.results = [];
			this.recorrido = 0;
			if(this.query.length > 2){
			    axios.get('/categorias/categorias_buscar_autocompletar',{
			     	params: {
			     		query: this.query
			     	}}).then(res => {
			     	// console.log(res.data);
			      	this.results = res.data;
			    });
			}
		},
		seleccionarItem(item){
			// alert(this.results[item].detalle);
			this.query = this.results[item].categoria;
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