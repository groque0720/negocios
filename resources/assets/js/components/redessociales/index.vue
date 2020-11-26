<template>
	<div>
        <div class="ancho-100 zona-agregar-btn flex flex-space-between flex-item-center p-15" style="margin: 10px auto 10px auto; border: 1px solid #5F66ED; border-radius: 10px; background: rgba(130, 201, 30, 0.2 )">
            <div class="ancho-10 flex flex-item-center flex-content-center">
                <i class="fas fa-users"style="color: #5F66ED; "></i>
            </div>
            <div class="ancho-90 flex flex-item-center flex-content-center">
                <span>Configuración de Redes Sociales</span>
            </div>
        </div>
		<template>
		  <div class="">
		    <div class="p-10" style="border: 1px solid #5F66ED; border-radius: 10px;">
		      	<div class="flex flex-item-center flex-content-center p-10" >
					<h3>Redes Sociales Seleccionadas</h3>
				</div>
		      	<draggable class="" :list="redes_select" group="people" @change="log">
					<div  class="flex flex-item-center flex-wrap p-10 cursor"
						  v-for="(red, index) in redes_select"
						  :key="red.red_social">
						<div class="m-r-10">
							<img width="25" height="25" :src="'/images/'+red.icono" alt="">
						</div>
						<div class="m-r-10" style="width: 150px;">
							{{ red.red_social }}
						</div>
						<div class="ancho-100 p-l-20">
							<div class="flex flex-item-center flex-space-between p-l-10">
								<input v-if="red.id!=5" class="form-input" :class="'red_social_'+index" type="text" v-model="red.pivot.url" :placeholder="'Pegar su link de '+red.red_social">
								<input v-if="red.id==5" class="form-input" :class="'red_social_'+index" type="text" v-model="red.pivot.url" :placeholder="'numero formato (ej. 54 + característica + número)'">
							</div>
							<span class='form-error' v-if="errores[index]">(*) Valor obligatorio</span>
						</div>
					</div>
					<div class="flex flex-item-center flex-content-center m-t-10">
		      			<i class="txt-gris">Arrastre aquí la red social para activarla</i>
		      		</div>
		      	</draggable>

		    </div>
	        <!-- <div class="flex flex-item-center flex-content-center p-5 m-10">
	        	<i><span class="fz-12">Desliza hacia arriba las redes sociales seleccionadas</span></i>
	        </div> -->
		    <div class="p-10 m-t-15" style="border: 1px solid #ddd;">
<!-- 				<div class="flex flex-item-center flex-content-center p-10" >
					<h3>Redes Sociales Disponibles</h3>
				</div> -->
			      <draggable  :list="redes_disponibles" group="people" @change="log">
			        <div
			          class="flex flex-item-center p-10 cursor" style="border-bottom: 1px solid #ccc"
			          v-for="(red, index) in redes_disponibles"
			          :key="red.red_social">
			          	<div class="m-r-10">
			        		<img width="25" height="25" :src="'/images/'+red.icono" alt="" style="filter: grayscale(0.9) blur(0.5px);">
			        	</div>
			        	<div class="m-r-10" style="width: 150px;">
			        		{{ red.red_social }}
			        	</div>
			        </div>
			      </draggable>
		    </div>

<!-- 		    <rawDisplayer class="col-3" :value="redes" title="List 1" />

		    <rawDisplayer class="col-3" :value="redes_negocio" title="List 2" /> -->
		</div>
		</template>

        <div class="form-foot p-t-10 flex flex-item-center flex-content-center display-sx display-s no-display-m no-display-l no-display-lg" style="position: fixed; bottom: 0px; left: 0px; background: white;">
        	<div class="ancho-95 ancho-sx-95 ancho-s-90 ancho-m-80 ancho-l-70 ancho-lg-60 flex flex-content-center" >
	            <div class="form-linea flex flex-space-between flex-item-center ancho-100" >
	                <div class="form-columna m-b-0">
	                    <button class="btn form-btn-cancelar cursor p-l-20 p-r-20" @click.prevent="cancelarRedes()">Cancelar</button>
	                </div>
	                <div class="form-columna m-b-0">
	                    <button class="btn form-btn-entrar cursor p-l-20 p-r-20" @click.prevent="guardarRedes()">Guardar</button>
	                </div>
	            </div>
        	</div>
    	</div>
		<div class="no-display-s display-m display-l display-lg " style="position: fixed; bottom: 50px; right: 10px; background: white;">
			<div class="flex flex-direction-column">
                <button class="btn form-btn-entrar cursor p-l-20 p-r-20 m-b-10" @click.prevent="guardarRedes()">Guardar</button>
                <button class="btn form-btn-cancelar cursor p-l-20 p-r-20" @click.prevent="cancelarRedes()">Cancelar</button>
			</div>
    	</div>

<!-- 		<div>
			<template v-for="red in redes">
				<div class="flex flex-item-center">
					<div class="m-r-10">
						<img style="width: 25px; height: 25px;" :src="'/images/'+red.icono" alt="">
					</div>
					<div class="ancho-100">
						{{ red.red_social }}
					</div>
				</div>
			</template>
		</div> -->
	</div>
</template>
<script>
import draggable from 'vuedraggable'
    export default {
    	  name: "two-lists",
		  display: "Two Lists",
		  order: 1,
		  components: {
		    draggable
		  },
        props:['negocio', 'redes', 'redes_negocio'],
        data(){
            return {
            	redes_select:[],
            	redes_disponibles:[],
            	errores:[],
            }
        },
        mounted() {
        	// this.redes_disponibles = this.redes;
        	// this.redes_select = this.redes_negocio;
        	this.inicioRedes();

        },
          methods: {

          	inicioRedes(){

          		self = this;
          		this.redes_select = this.redes_negocio.slice();

	        	this.redes.forEach(function(red){

	        		var iguales = self.redes_negocio.filter(function(red_negocio) {
	        			return red_negocio.red_social == red.red_social;
	        		});

	        		if (iguales.length == 0) {
	        			self.redes_disponibles.push(red);
	        		}
	        	})

	        	this.redes_disponibles.forEach(function(red){
	        		red.pivot = { 'url' : ''};
	        	});
          	},
          	guardarRedes(){

          		this.errores = [];
          		self = this;
          		var cont_errores = 0;

          		this.redes_select.forEach(function(red, index){
          			if (red.pivot.url == '') {
          				self.errores.push(1)
          				if (cont_errores == 0) {
          					$('.red_social_'+index).focus();
          					cont_errores++;
          				}
          			}else{
          				self.errores.push(0)
          			}
          		})

          		if (cont_errores == 0) {
	          		let url = "/redes_sociales/guardar";
	          		var data = {};
	                data.redes = this.redes_select;
	          		axios.post(url, data)
		          		.then(response => {
		          			this.$root.mostarMensaje('ok','','Se ha guardado correctamente');
						})
				}

		    	// console.log(this.redes_select);
		    },
		    cancelarRedes(){
		    	this.redes_select = [];
		    	this.redes_disponibles = [];
		    	this.inicioRedes();
		    },
		    // add: function() {
		    // 	console.log('algo');
		    //   this.list.push({ name: "Juan" });
		    // },
		    // replace: function() {
		    // 	console.log('repmplace');
		    //   this.list = [{ name: "Edgard" }];
		    // },
		    // clone: function(el) {
		    // 	console.log('clone');
		    //   return {
		    //     name: el.name + " cloned"
		    //   };
		    // },
		    log: function(evt) {
		    	// console.log(evt.added);
		    	// var newIndex = evt.added.newIndex;
		    	// var newRed = evt.added.element.red_social;
		    	// console.log(newRed);
		    	// console.log(this.redes_select);
		     //  window.console.log(evt);
		    }

		 }
    }
</script>