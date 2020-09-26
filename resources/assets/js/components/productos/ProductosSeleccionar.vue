<template>
	<div v-if="view" class="productos-productos-seleccionar" style="height: 100vh; width: 100%; background: rgba(0,0,0,0.5); position: fixed; top: 0; left: 0; z-index: 1;">
		<div class="flex flex-content-center">
			<div class="ancho-90 p-10" style="background: white; margin-top: 20px; border-radius: 5px;">
				<form  class="form" action="">
					<div class="form-head" style="background: white;">
						<div class="flex flex-space-between">
							<div class="ancho-100 flex flex-item-center flex-space-between flex-content-start">
								<i class="fas fa-sitemap m-r-10" style="color: #00E185;"></i>
								<span>Relacionar Producto al álbum <span class="txt-italic">"{{ producto.producto }}"</span></span>
							</div>
							<!-- <div class="ancho-30 flex flex-item-center flex-space-between p-10 borde-radio-3" @click="nuevaCaracteristica()" style="border: 1px solid #ddd;">
								<i class="fas fa-plus m-r-10 arrow-caracteristicas" style="color:#00E185;"></i>
								<span>Agregar</span>
							</div> -->
						</div>
                        <div class="flex flex-item-center flex-content-center">
                            <span class="txt-italic fz-12 txt-gris">{{ productos_relacionados.length }} Productos Relacionados</span>
                        </div>
					</div>

					<div class="form-body" style="height: 70vh;">
                        <div class="ancho-100 flex flex-content-center m-b-5">
                            <div class="zona-busqueda flex ancho-90 m-b-10">
                                <div class="ancho-10 flex flex-item-center flex-content-center" style="border: 1px solid #">
                                    <a href=""><i class="fas fa-search txt-gris"></i></a>
                                </div>
                                <div class="ancho-80 flex flex-item-center flex-content-center">
                                    <!-- <input class="input-busqueda" ref="input_busqueda " type="text" @focusout="mostrarBtnBorrar = false" @focus="mostrarBtnBorrar = true"  v-model="query" @input="evt=>filtrarCaracteristicas(evt)" placeholder="Buscar Producto"> -->
                                    <input class="input-busqueda" ref="input_busqueda" type="text" @focusout="mostrarBtnBorrar = false" @focus="mostrarBtnBorrar = true"  v-model="query" @input="evt=>buscarProductos(evt)" placeholder="Buscar Producto">
                                </div>
                                <div class="ancho-10 flex flex-item-center flex-content-center">
                                    <div v-if="mostrarBtnBorrar || query.length">
                                        <a href="#" @click.prevent="borrarInputBuscar()">
                                            <i class="fas fa-times txt-gris"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div v-for="(producto, indice) in productos_relacionados_busqueda" class="lista-linea ancho-100 flex flex-space-between" @click="lineaActiva(indice)" :class="'linea_'+indice">
                            <div class="ancho-100 flex flex-item-center">
                                <div class="ancho-30 m-r-10 flex" style="width: 60px; height: 60px; overflow: hidden; border-radius: 2px; box-shadow: 1px 1px #ddd;">
                                    <img v-if="$root.esImagen(producto.imagen_ppal)" style="object-fit: cover;" :src="'/storage/'+producto.imagen_ppal" alt="" width="100%" >
                                    <video v-if="$root.esVideo(producto.imagen_ppal)" style="object-fit: cover; width: 100%" class="ancho-100" autoplay muted loop>
                                    <source :src="'/storage/'+producto.imagen_ppal" type="video/mp4">
                                </video>
                                </div>
                                <div class="ancho-70 flex flex-space-between flex-direction-column" style="height: 100%;">
                                    <div>
                                        <span style="font-weight: bold;">{{ producto.producto }}</span>
                                    </div>
                                    <div>
                                        <span style="color:#7C7979; font-size: 12px;">{{ $root.truncarTexto(producto.descripcion, 50) }}</span>
                                    </div>
                                    <div  class="flex flex-content-end">
                                    <!-- muestro el precio solo si es de tipo producto (valor 1) -->
                                        <span v-if="producto.tipo_id == 1" class="fz-12">${{ $root.formatoPrecio(producto.precio)  }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="ancho-15 zona-acciones flex flex-content-center flex-item-center"  :class="'accion_'+indice" >
                                <div v-if="!boleanRelacion(producto.id)" class="ancho-45 flex flex-content-center">
                                    <a href="#" @click.prevent="relacionarProducto(producto, indice)" title="quitar relación">
                                        <i class="fas fa-link txt-gris"></i>
                                    </a>
                                </div>
                                <div v-else class="ancho-45 flex flex-content-center">
                                    <a href="#" @click.prevent="relacionarProducto(producto, indice)" title="quitar relación">
                                        <i class="fas fa-link txt-verde"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
					</div>
				    <div class="form-foot p-t-10">
			            <div class="form-linea flex flex-space-between flex-item-center" >
			                <div class="form-columna m-b-0">
			                    <button class="btn form-btn-cancelar cursor p-l-20 p-r-20" @click.prevent="cancelar()">Cancelar</button>
			                </div>
			                <div class="form-columna m-b-0">
			                    <button class="btn form-btn-entrar cursor p-l-20 p-r-20" @click.prevent="guardar()">Aceptar</button>
			                </div>
			            </div>
		        	</div>
				</form>
			</div>
		</div>
	</div>
</template>
<script>

    export default {
    	props:['productos_relacionados', 'producto'], //producto - productos_relacionados
        data(){
        	return {
                query:'',
        		view: false,
                mostrarBtnBorrar:false,
                productos_relacionados_busqueda:[],
        		// formulario:{
        		// 	titulo:'Nueva Característica',
          //           producto_id:'',
        		// 	caracteristica:'',
        		// }
        	}
        },
        mounted() {

        },
        methods:{
            boleanRelacion(id){
                if (this.productos_relacionados.find(item => item.id == id)) {
                    return true;
                }
            },
        	mostrar() {
                this.productos_relacionados_busqueda = [];
        		this.view = true;
        	},
            borrarInputBuscar(){
                this.query = '';
                self = this;
                setTimeout(function(){
                    self.productos_relacionados_busqueda = [];
                    self.$refs.input_busqueda.focus();
                    },
                100);
            },
            buscarProductos(evt) {
                this.query = evt.target.value;
                if(this.query.length >= 2){
                    axios.get('/productos/productos_buscar_autocompletar',{
                        params: {
                            query: this.query,
                            tipo_id: 1,
                        }}).then(res => {
                        this.productos_relacionados_busqueda = res.data;
                     });
                }else{
                    this.productos_relacionados_busqueda = [];
                }
            },
            relacionarProducto(producto, indice){

                if (this.productos_relacionados.find(item => item.id == producto.id)) {
                    this.$root.mostarMensaje('ok','','Este producto ya esta relacionado');
                }else{
                    let url ='/producto/producto_relacionar';
                    var formData = {};
                        formData.relacionar_producto_id = producto.id;
                        formData.album_id = this.producto.id; // es un producto que esta vestido de album -> es tipo_id = 2
                    axios.post(url,formData).then(res => {
                            this.productos_relacionados.push(producto);
                            this.$root.mostarMensaje('ok','','Relación correcta');
                            // this.productos_relacionados_busqueda = [];
                         });
                }
            },
            lineaActiva(indice){
                $('.lista-linea').removeClass('lista-linea-activa');
                $('.linea_'+indice).addClass('lista-linea-activa');
            },
        	cancelar() {
                this.query='';
                this.productos_relacionados_busqueda = [];
        		self = this;
                setTimeout(function(){
                    self.view = false;
                    },
                50);
        	},
        	guardar(){
                this.query='';
        		this.view = false;
        	},
            ocultarFormulario(){
                this.mostrarFormulario = false;
            }
        }
    }
</script>
<!-- <style scoped>
    .productos-productos-seleccionar .lista-linea {
        padding: 5px;
        border-bottom: 1px solid #ccc;
    }
    .productos-productos-seleccionar .lista-linea.linea_0 {
        border-top: 1px solid #ccc !important;
    }
    .productos-productos-seleccionar .lista-linea-activa {
        background: #ECECEC;
    }
</style> -->