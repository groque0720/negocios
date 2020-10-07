<template>
    <div v-if="mostrar_validador_" class="lienzo flex flex-direction-column flex-item-center">
        <div class="p-10 flex flex-direction-column" style="border: 1px solid #cecece; border-radius: 10px; width: 320px; background: white; margin-top: 50px;">
            <div class="p-10 flex flex-item-center flex-content-center m-b-10" style="height: 40px;">
                <span class="txt-negrita fz-18">Verificación de seguridad</span>
            </div>
            <div class="m-b-10">
                <div class="flex flex-item-center flex-content-center m-b-10"">
                    <span>Mueve y ordena los simbolos como la imagen</span>
                </div>
                <div class="flex flex-item-center flex-content-center">
                    <img  :src="'/images/mover-letra.png'" width="60%" >
                </div>
            </div>
            <div class="flex" style="position: relative; width: 300px; height: 80px; overflow: hidden;">
                <img :src="'/images/fondoletras03.jpg'" width="300px;" alt="" style="object-fit: cover; opacity: 0.4">
                <div class="ancho-100 flex flex-item-center flex-content-center" style="position: absolute; top: 10px;">
                    <div v-for="(letra, i) in ordenado" >
                        <span class="txt-negrita m-r-10" :style="{color: rand_colores()}" style="font-size:50px; text-shadow: 0px 0px 10px #595858; font-weight: 600;">{{ letra }}</span>
                    </div>
                </div>
                <div v-if="procesando_validacion" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(255,255,255,0.7);">
                </div>
                <div v-if="procesando_validacion || recargando" class="check-confirmacion flex flex-item-center flex-content-center" style="position: absolute; top: 10px; left: 120px;">
                    <input type="checkbox" id="check" disabled="true">
                    <label for="check">
                         <div class="check-icon">
                        </div>
                    </label>
                </div>
            </div>
            <div class="m-t-10 m-b-10">
                <!-- <draggable v-model="desordenado" @start="drag=true" @end="drag=false" @change="mostrar()" class="flex flex-content-center" > -->
                <draggable v-model="desordenado" @start="drag=true" @end="drag=false"  @change="procesar()" :disabled="!enabled" class="flex flex-content-center" >
                    <div v-for="(letra, i) in desordenado" >
                        <div class="p-10 m-5 cursor flex flex-item-center flex-content-center content_letra" :class="'content_letra_'+i" style="width: 35px; hyphens: 30px; border: 1px solid #ccc; border-radius: 5px; box-shadow: 1px 1px 2px #ccc; background: white;">
                            <span class="fz-18 txt-negrita letra" :class="'letra_'+i">{{ letra.letra }}</span>
                        </div>
                    </div>
                </draggable>
            </div>
            <div v-if="enabled" class="flex flex-item-center flex-content-center m-b-10">
                <div class="flex flex-item-center cursor" @click.prevent="buscar_datos_validacion()">
                    <div>
                         <img :src="'/images/reload_78477.png'" style="width: 30px; height: 30px;" alt="recargar letras" >
                    </div>
                    <div class="m-l-10">
                        <span>Recargar Símbolos</span>
                    </div>
                </div>
            </div>
            <div v-if="enabled" class="ancho-100 flex flex-item-center flex-content-center m-t-10">
                <div class="ancho-100 cursor p-5" @click="validar()" style="background-color: #1883ba; border-radius: 6px;
                    border: 1px solid #0016b0;">
                    <center><span class="fz-18 txt-blanco">Verificar y Enviar Formulario</span></center>
                </div>
            </div>
            <input type="hidden" v-model="letras" name="letras">
            <input type="hidden" v-model="token" name="token">
        </div>
    </div>

</template>
<script>
	import draggable from 'vuedraggable'
    export default {
        props:{
            mostrar_validador : {
                type: Boolean,
                default: false
            }
        },
    	components: {
            draggable,
        },
        data(){
            return {
                letras:'',
                token:'',
                mostrar_validador_: this.mostrar_validador,
            	enabled: true,
            	ordenado:[],
            	desordenado:[],
            	procesando_validacion:false,
                recargando: false,
            	colores_letras: ['WHITE','BLACK','RED','MAROON','YELLOW','OLIVE','LIME','GREEN','AQUA','TEAL','BLUE','NAVY','FUCHSIA','PURPLE','INDIANRED','DEEPPINK','CORAL','ORANGE','SEAGREEN','MEDIUMSLATEBLUE','BLUEVIOLET','MEDIUMORCHID'],
            }
        },
        mounted() {
        	// console.log(this.negocio.url);
        	this.buscar_datos_validacion();
        },
        methods: {
            mostrar(){
                this.mostrar_validador_ = true;
            },
        	buscar_datos_validacion(){
                self = this;
                this.recargando = true;
        		var url = '/token_validacion';
				axios.get(url)
                .then(response => {
                	this.ordenado = response.data.ordenado;
                	this.desordenado = response.data.desordenado;
                     this.recargando = false;
                     // console.log(this.ordenado);
                     // console.log(this.desordenado);
                });
        	},
            procesar(){
                self = this;
                self.letras = '';
                self.token = '';
                this.desordenado.forEach(function(letra){
                    self.letras = self.letras+letra.letra;
                    self.token = self.token+letra.token;
                })
                // console.log(self.letras);
            },
        	// mostrar(){
        	// 	self = this;
        	// 	$('.letra').css('color','#444343');
        	// 	$('.content_letra').css('background','white');
        	// 	this.desordenado.forEach(function(letra, posicion){
        	// 		if (letra.letra === self.ordenado[posicion]) {
        	// 			$('.letra_'+posicion).css('color','white');
        	// 			$('.content_letra_'+posicion).css('background','lightgreen');
        	// 			console.log(posicion+' '+letra+' ok');
        	// 		}
        	// 	});
        	// },
        	validar(){
        		this.procesando_validacion = true;
        		self = this;
        		var url = '/token_validacion';
        		let form = {};
    			// form.ordenado = this.ordenado;
    			// form.desordenado = this.desordenado;
                form.letras = this.letras;
                form.token = this.token;
				axios.post(url, form)
                .then(response => {
                	// console.log(response.data);
                	if (response.data != 'exito') {
                		self.procesando_validacion = false;
                	 	Swal.fire(
			              'Volver a Internar',
			              'No se ordenó correctamente los símbolos',
			              'error'
			            );
	                	setTimeout(function(){
	                		self.buscar_datos_validacion();
		                    },
			            100);
                	 }else{

                	 	setTimeout(function(){
                	 		self.enabled = false;
                            $('#check').attr({
                                checked: true,
                            });
		                    },200);

                        setTimeout(function(){
                            $('form').submit();
                        },500);

                	 }

                });
        	},
        	rand_colores(){
        		var cant_colores = this.colores_letras.length;
        		var posicion = Math.floor(Math.random()*(cant_colores - 1) + 1);
        		return this.colores_letras[posicion];
        	}
        }
    }
</script>