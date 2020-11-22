<template>
    <div class="productos-productos">
    	<div v-if="tipo_id == 1" class="ancho-100 zona-agregar-btn flex flex-space-between flex-item-center p-15" style="margin: 10px auto 10px auto; border: 1px solid #FFAC1E; border-radius: 10px; background: #FBEACD;">
            <div class="ancho-10 flex flex-item-center flex-content-center">
                <i class="fas fa-donate" style="color:#FFAC1E;"></i>
            </div>
            <div class="ancho-80 flex flex-item-center flex-content-center">
                <span>Lista de Precio</span>
            </div>
            <div class="ancho-10 flex flex-item-center flex-content-center">
            	<a href="#" @click.prevent="mostrarConfiguracionPrecio=true">
            		<i class="fas fa-cog"></i>
            	</a>
            </div>
        </div>
    	<div class="p-15" v-if="mostrarConfiguracionPrecio" style="position: relative;">
    		<form action="" class="p-15 borde-radio-5" style="border: 1px solid #FFAC1E; ">
    			<div class="form-linea flex flex-space-between flex-item-center flex-wrap">
    				<div class="form-columna" style="width: 150px;">
    					<label for="" class="form-label txt-negrita">Opción de Corrección</label>
    					<select class="form-select ancho-100 fz-12" v-model="opcionCorreccion">
    						<option value="1">Aumento</option>
    						<option value="2">Descuento</option>
    					</select>
    				</div>
    				<div class="form-columna" style="width: 150px;">
    					<label for="" class="form-label txt-negrita">Opción de Cálculo</label>
    					<select class="form-select ancho-100 fz-12" v-model="opcionCalculo">
    						<option value="1">Porcentaje</option>
    						<option value="2">Cifra Fija</option>
    					</select>
    				</div>
    				<div class="form-columna" style="width: 150px;">
    					<label for="" class="form-label txt-negrita obligatorio" v-text="'Valor '+ (opcionCalculo==1 ? 'Porcentaje' : 'Cifra Fija')"></label>
    					<div class="flex flex-space-between flex-item-center">
    						<span class="m-r-5" v-text="(opcionCalculo==1 ? '% ' : '$ ')"></span>
    						<input type="text" class="form-input txt-derecha valorCorreccion" @keyup="event=>actulizarPrecio(event)" placeholder="Ingrese Valor">
    					</div>
    					<span class='form-error' v-if="error_valor">(*) Valor obligatorio</span>
    				</div>

    				<div class="form-columna" style="width: 150px;">
    					<label for="" class="form-label txt-negrita">Opción Redondeo</label>
    					<select class="form-select ancho-100 fz-12" v-model="opcionRedondeo">
    						<option value="0">No Redondear</option>
    						<option value="1">Redondear Arriba</option>
    						<option value="2">Redondear Abajo</option>
    					</select>
    				</div>
    				<div class="form-columna">
    					<button class="p-5" @click.prevent="ejecutarConfirmacion()">
	    					<div class="flex flex-space-between flex-item-center">
	    						<i class="fas fa-cog"></i>
	    						<span class="m-l-10">Ejecutar</span>
	    					</div>
    					</button>
    				</div>
    			</div>
    		</form>
    		<div style="position: absolute; top: 5px; right: 5px;" @click.prevent="mostrarConfiguracionPrecio=false">
				<i class="far fa-times-circle txt-rojo cursor" style="background: white; border-radius: 50%"></i>
			</div>
    	</div>

    	<div class="flex flex-content-center flex-item-center" v-if="!mostrarListaProducto">
    		<img width="100px" height="100px" v-lazy="'/images/Preloader_8.gif'" alt="">
    	</div>

        <div class="m-b-10" v-if="mostrarListaProducto">
            <div class="zona-busqueda flex ancho-100">
                <div class="ancho-10 flex flex-item-center flex-content-center" style="border: 1px solid #">
                    <a href=""><i class="fas fa-search txt-gris"></i></a>
                </div>
                <div class="ancho-80 flex flex-item-center flex-content-center">
                    <input class="input-busqueda" ref="input_busqueda" type="text" @focusout="mostrarBtnBorrar = false" @focus="mostrarBtnBorrar = true"  v-model="query" @input="evt=>buscarProductos(evt)" placeholder="Buscar Producto">
                </div>
                <div class="ancho-10 flex flex-item-center flex-content-center">
                    <div v-if="mostrarBtnBorrar || query.length">
                        <i class="fas fa-times txt-gris" @click.prevent="borrarInputBuscar()"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="zona-lista ancho-100" style="margin-bottom: 60px;" v-if="mostrarListaProducto">
            <template>
                <div v-for="(producto, indice) in productos" class="lista-linea ancho-100"
                 :class="[ 'linea_'+indice, {'fondo-celeste-claro-1': (indice==linea_sel) } ]">
                    <div class="ancho-100 flex flex-space-between cursor" @click="editarPrecio(indice)">
                        <div class="ancho-30 m-r-10 flex" style="width: 60px; height: 60px; overflow: hidden; border-radius: 2px; box-shadow: 1px 1px #ddd;">
                            <img v-if="$root.esImagen(producto.imagen_ppal)" style="object-fit: cover;" :src="'/storage/'+producto.imagen_ppal" alt="" width="100%" >
                            <video v-if="$root.esVideo(producto.imagen_ppal)" style="object-fit: cover; max-height: 350px;" class="ancho-100" autoplay muted loop>
                                <source :src="'/storage/'+producto.imagen_ppal" type="video/mp4">
                            </video>
                        </div>
                        <div class="ancho-70 flex flex-direction-column flex-space-between" style="height: 100%;">
                            <div>
                                <span style="font-weight: bold;">{{ producto.producto }}</span>
                            </div>
                            <div>
                                <span style="color:#7C7979; font-size: 12px;">{{ $root.truncarTexto(producto.descripcion, 50) }}</span>
                            </div>
                        </div>
                        <div class="ancho-30 flex flex-item-center flex-content-end cursor">
                            <span class="fz-14" v-if="indice!=indice_sel" @click="editarPrecio(indice)">$ {{ $root.formatoPrecio(producto.precio)  }} {{ producto.precio_obs }}</span>
                        </div>
                    </div>
                    <div class="flex flex-content-end" style="border-top: 1px solid #ccc;" v-if="indice==indice_sel">
	                    <div class="ancho-s-100 ancho-m-80 ancho-l-70 ancho-lg-60 flex flex-space-between m-t-10"  >
	                        <div class="ancho-70 m-r-10 flex flex-space-between">
	                        	<div class="ancho-40">
	                        		<input type="text"  :class="'input_precio_'+indice" class="ancho-40 form-input precio txt-derecha m-r-10" name="" v-model="precio_display" @input="event=>actulizarPrecio(event)" @keyup="event=>actulizarPrecio(event)" @keypress.enter.prevent="confirmarPrecio(indice)">
	                        	</div>
	                            <div class="ancho-55">
	                            	<input type="text" class="ancho-60 form-input" :class="'input_precio_obs_'+indice" v-model="precio_obs_display" @keypress.enter.prevent="confirmarPrecio(indice)" placeholder="obs. precio">
	                            </div>
	                        </div>
	                        <div class="ancho-30 flex flex-space-between flex-item-center m-l-10">
	                            <div class="ancho-50 flex flex-content-center">
		                            <a href="#" @click.prevent="confirmarPrecio(indice)" title="Confirmar">
		                                <i class="far fa-check-circle txt-verde fz-22"></i>
		                            </a>
	                            </div>
	                            <div class="ancho-50 flex flex-content-center">
									<a href="#" @click.prevent="cancelarPrecio()" title="Cancelar">
		                                <i class="far fa-times-circle txt-rojo-claro fz-22"></i>
		                            </a>
	                            </div>
	                        </div>
	                    </div>
                    </div>

                </div>
                <infinite-loading @infinite="InfiniteHandler">
                    <div slot="no-more"></div>
                    <div slot="spinner">Cargando...</div>
                    <div slot="no-results">Click en agregar</div>
                </infinite-loading>
            </template>
        </div>
        <div class="form-lienzo flex flex-content-center flex-item-start" v-if="mostrarFormularioConfirmacion">
        	<div class="p-15">
	        	<form action="" style="background: white;">
	        		<div class="form-head p-15">
	        			<div class="form-titulo">
	        				Configuración de Actualización de Precios
	        			</div>
	        		</div>
	        		<div class="form-body p-10" >
	        			<div class="form-linea">
	        				<p><span><b>ACLARACION 1:</b></span> los precio de todos los productos serán actualizados.</p><br>
	        				<p><span><b>ACLARACION 2:</b></span> los precio con valores en 0,00 (cero) no se actulizarán.</p><br>
	        				<p><span><b>CONFIRMA</b></span> la siguiente configuración en la actulización de precios</p>
	        			</div>
	        			<hr class="m-t-10">
	        			<div class="form-linea m-t-10 p-10 flex">
	        				<label class="form-label fz-14 ancho-50"><b>Opción de Corrección:</b></label>
	        				<span class="m-l-10">{{ opcionCorreccion == 1 ? 'Aumento' : 'Descuento'  }}</span>
	        			</div>
	        			<div class="form-linea p-10 flex">
	        				<label class="form-label fz-14 ancho-50"><b>Opción de Cálculo:</b></label>
	        				<span class="m-l-10">{{ opcionCalculo == 1 ? 'Porcentaje' : 'Cifra Fija'  }}</span>
	        			</div>
	        			<div class="form-linea p-10 flex">
	        				<label class="form-label fz-14 ancho-50"><b>Valor de Corrección:</b></label>
	        				<span class="m-l-10">{{ opcionCalculo == 2 ? '$' : ''  }} {{ valor_correccion }} {{ opcionCalculo == 1 ? '%' : ''  }}</span>
	        			</div>
	        			<div class="form-linea p-10 flex">
	        				<label class="form-label fz-14 ancho-50"><b>Opción de Redondeo:</b></label>
	        				<span class="m-l-10" v-if="opcionRedondeo == 0">No Redondear</span>
	        				<span class="m-l-10" v-else>{{ opcionRedondeo == 1 ? 'Redondear Arriba' : 'Redondear Abajo'  }}</span>
	        			</div>
	        		</div>
	        		<div class="form-foot">
			            <div class="form-linea flex flex-space-between flex-item-center ancho-100" >
			                <div class="form-columna m-b-0">
			                    <button class="btn form-btn-cancelar cursor p-l-20 p-r-20" @click.prevent="mostrarFormularioConfirmacion=false">Cancelar</button>
			                </div>
			                <div class="form-columna m-b-0">
			                    <button class="btn form-btn-entrar cursor p-l-20 p-r-20" @click.prevent="ejecutarCorrecionPrecios()">Actualizar</button>
			                </div>
			            </div>
	        		</div>
	        	</form>
        	</div>

<!--         	<div class="ancho-s-80 ancho-m-60 ancho-l-40 ancho-lg-30" style="background: white;">
        		holo
        	</div> -->
        </div>
    </div>
</template>

<script>
    export default {
        props:['tipo_id', 'negocio'],
        data(){
            return {
                // busqueda
                mostrarBtnBorrar:false,
                query:'',
                // lista
                productos:[],
                productos_infinite:[],
                page:0,
                // ABM
                mostrarConfiguracionPrecio:false,
                opcionCalculo:1,
                opcionCorreccion:1,
                opcionRedondeo:1,
                mostrarFormularioConfirmacion: false,
                error_valor:false,

                mostrarListaProducto: true,
                accion:'',
                precio_display:'',
                precio_obs_display:'',
                indice_sel: -1,
                linea_sel:-1,
                formulario: {
                    titulo: '',
                    producto_id: '',
                    producto: '',
                }
            }
        },
        mounted() {
        },
        methods: {
            borrarInputBuscar(){
                this.query = '';
                self = this;
                setTimeout(function(){
                    self.productos = self.productos_infinite;
                    self.$refs.input_busqueda.focus();
                    },
                100);
            },
            InfiniteHandler($state){
                this.page++;
                // console.log(this.page)
                let url = '/productos/'+this.tipo_id+'/buscar?page=' + this.page;
                axios.get(url)
                .then( response => {
                    let productos = response.data.data;
                    if (productos.length) {
                        this.productos_infinite = this.productos.concat(productos);
                        this.productos = this.productos_infinite;
                        $state.loaded();
                    }else{
                        $state.complete();
                    }
                });
            },
           	editarPrecio(indice){
           		this.indice_sel = indice;
           		this.linea_sel = indice;
           		this.precio_display = this.$root.formatoPrecio(this.productos[indice].precio);
           		this.precio_obs_display = this.productos[indice].precio_obs;
				setTimeout(function(){
                    $('.input_precio_'+indice).select();
                    $('.precio').addClass('numero');
                    },
                50);
            },
            actulizarPrecio(event){
            	$(event.target).val(function (index, value ) {
		            return value.replace(/\D/g, "")
		                        .replace(/([0-9])([0-9]{2})$/, '$1,$2')
		                        .replace(/\B(?=(\d{3})+(?!\d)\.?)/g, ".");
		        });
			},
			ejecutarConfirmacion(){
				this.valor_correccion = $('.valorCorreccion').val();
				var valor = $('.valorCorreccion').val();
				if (valor!='') {
					this.mostrarFormularioConfirmacion = true;
				}else{
					this.error_valor = true;
					$('.valorCorreccion').focus();
				}

			},
			ejecutarCorrecionPrecios(){

				this.mostrarListaProducto = false;
				this.mostrarFormularioConfirmacion = false;

				var valor = $('.valorCorreccion').val();
				valor = valor.replace(/^0+/, '');
				valor = valor.replace('.','').replace(',','.');

				let url = '/precio_lista/correccion_precio';
                axios.get(url, {
                        params: {
                           	correccion : this.opcionCorreccion,
							calculo : this.opcionCalculo,
							valor : valor,
							redondeo : this.opcionRedondeo,
                        }})
                .then( response => {
                	if (response.data == 'ok') {
                		location.reload();
                	}
                });

			},
			confirmarPrecio(indice){

				var precio = $('.input_precio_'+indice).val();
				precio = precio.replace(/^0+/, '');
				precio = precio.replace('.','').replace(',','.');

				var precio_aux = '';
				var cant_puntos = 0;

				for (var i = precio.length; i >= 0; i--) {
					if (precio.charAt(i) == '.' && cant_puntos < 1){
						cant_puntos++;
						precio_aux = precio.charAt(i)+precio_aux;
					}
					if (precio.charAt(i) != '.' && cant_puntos <= 1){
						precio_aux = precio.charAt(i)+precio_aux;
					}
				}

				precio = precio_aux;

				var precio_obs = $('.input_precio_obs_'+indice).val();

				let url = '/precio_lista/editar_precio';
                axios.get(url, {
                        params: {
                            producto_id: this.productos[indice].id,
                            precio: precio,
                            precio_obs: precio_obs,
                        }})
                .then( response => {
                	if (response.data = 'ok') {
	                	this.productos[indice].precio = precio;
						this.productos[indice].precio_obs = $('.input_precio_obs_'+indice).val();
						this.indice_sel = -1;
						this.mostarMensaje('ok','');
                	}else{
                		this.mostarMensaje('error','');
                	}
                });
			},
			cancelarPrecio(){
				this.indice_sel = -1;
			},
            buscarProductos(evt) {
                this.query = evt.target.value;
                if(this.query.length >= 2){
                    axios.get('/productos/productos_buscar_autocompletar',{
                        params: {
                            query: this.query,
                            tipo_id: this.tipo_id,
                        }}).then(res => {
                        this.productos = res.data;
                     });
                }else{
                    this.productos = this.productos_infinite;
                }
            },
            mostarMensaje($estado, msg = ''){
                if ($estado == 'ok') {
                    Swal.fire({
                      position: 'top-end',
                      icon: 'success',
                      // title: msg,
                      text: msg,
                      showConfirmButton: false,
                      timer: 1000,
                      width: '180px',
                    })
                }
                if ($estado == 'error') {
                    Swal.fire({
                      position: 'top-end',
                      icon: 'error',
                      text: msg,
                      showConfirmButton: false,
                      timer: 1000,
                      width: '180px',
                    })
                }
            }
        }
    }
</script>
