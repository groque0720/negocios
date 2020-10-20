<template>
 <div style="position:relative">
  	<input v-bind:name="name_input" type="text" v-bind:placeholder="placeholder"
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
			     {{ result.nombre }}
			    </li>
		   	</template>
	   </ul>
	</div>
 </div>
</template>

<script>
 export default{
 	props: ['data'],
	data(){
		return {
			query: '',
			results: [],
			recorrido:'',
			name_input: '',
			url: '',
			placeholder :''
		}
	},
	mounted(){
		console.log(this.data);
		this.name_input = this.data.name_input;
		this.url = this.data.url;
		this.placeholder = this.data.placeholder;
		this.data.selected != '' ? this.query = this.data.selected : '';
	},
	methods: {
		autoComplete(){
			this.results = [];
			this.recorrido = 0;
			if(this.query.length > 2){
			    axios.get(this.url,{
			     	params: {
			     		buscar_texto: this.query
			     	}}).then(res => {
			      	this.sortArrays(res.data);
			    });
			}
		},
		seleccionarItem(item){
			this.query = this.results[item].nombre;
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
		 sortArrays(arrays) {
	            this.results = _.orderBy(arrays,
	            						['nombre'],
	            						['asc']);
	        }
	}
 }
</script>

<style>
	.panel-lista {
		position: absolute !important;
		border: 1px solid #E5E2E2;
		z-index: 10000000;
		background: white;
		overflow-y: auto;
		max-height: 200px;
		width: 100%;
		box-shadow: 0px 1px 3px #DA2F2F;
	}
	.items {
		list-style: none;
		padding: 5px;
		font-size: 12px;
		cursor: pointer;
	}
	.items:hover {
		background: #E8EAF2;
	}
	.active {
		background: #E8EAF2;
	}

</style>