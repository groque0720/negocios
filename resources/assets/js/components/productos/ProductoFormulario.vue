<template>
	<div class="ancho-100 producto-formulario">
		<div>
			<h1 class="txt-centrar">
				<span v-if="producto.guardar == 0">Nuevo</span><span v-else>Editar</span>
				<span v-if="producto.tipo_id == 1">Producto</span><span v-else>Álbum</span>
			</h1>
		</div>
		<!-- <form action="/productos" enctype="multipart/form-data" method="POST" autocomplete="off"> -->
			<div class="form-body" style="margin-bottom: 60px;">
				<!-- PRODUCTO -->
				<div >
					<!-- muestro si es un producto -->
					<div v-if="producto.tipo_id == 1" class="form-linea flex flex-item-center p-10 m-b-10" style="border: 1px solid #00E185; border-radius: 5px; background: rgba(0, 225, 133, 0.2);" @click="acordeon('producto')">
						<div class="form-columna ancho-100 flex m-0">
							<div class="ancho-80 flex flex-item-center flex-space-between flex-content-start">
								<i class="fas fa-tags m-r-10" style="color:#00E185;"></i>
								<span>Producto</span>
							</div>
							<div class="ancho-20 flex flex-item-center flex-content-end">
								<!-- <i class="fas fa-angle-up"></i> -->
								<i class="fas fa-angle-up m-r-10 arrow-producto" style="color:#00E185;"></i>
							</div>
						</div>
					</div>
					<!-- muestro si es un Album -->
					<div v-else class="form-linea flex flex-item-center p-10 m-b-10" style="border: 1px solid #9361A9; border-radius: 5px; background: rgba(147, 97, 169, 0.2);" @click="acordeon('producto')">
						<div class="form-columna ancho-100 flex m-0">
							<div class="ancho-80 flex flex-item-center flex-space-between flex-content-start">
								<i class="far fa-image m-r-10" style="color:#9361A9;"></i>
								<span>Álbum</span>
							</div>
							<div class="ancho-20 flex flex-item-center flex-content-end">
								<!-- <i class="fas fa-angle-up"></i> -->
								<i class="fas fa-angle-up m-r-10 arrow-producto" style="color:#9361A9;"></i>
							</div>
						</div>
					</div>
					<div class="zona-producto">
						<div class="form-linea">
							<div class="form-columna">
								<!-- <label class="form-label obligatorio" for="">Producto</label> -->
								<input type="text" id="producto_nombre" class="form-input" v-model='producto.producto' placeholder="Título" @keypress.enter.prevent="" @input="evt=>productoNombre(evt)" required autocomplete="off">
							</div>
						</div>
						<div class="form-linea">
							<div class="form-columna">
								<!-- <label class="form-label" for="">Descripción</label> -->
								<textarea class="form-textarea" name="" id="" cols="30" rows="5" v-model='producto.descripcion' placeholder="Descripción"></textarea>
							</div>
						</div>
						<!-- muestro el precio solo si es de tipo producto -->
						<div v-if="producto.tipo_id == 1" class="form-linea flex flex-item-center flex-space-between">
						<!-- <div class="form-linea flex flex-item-center flex-space-between"> -->
							<div class="form-columna ancho-20">
								<label class="form-label" for=""> Precio </label>
							</div>
							<div class="form-columna ancho-35">
								<div class="ancho-100 flex flex-content-end" v-if="!viewActualizarPrecio">
									<div class="ancho-80 flex flex-item-center">
										<span class="m-r-10">$</span>
										<input type="text" ref="valor_precio" class="form-input numero precio txt-derecha" v-model='precio_display' placeholder="$" @focus="evt=>seleccionarPrecio(evt)" @focusout="actulizarPrecio()" @keypress.enter.prevent="actulizarPrecio()">
									</div>
								</div>
							</div>
							<div class="form-columna ancho-35">
								<input type="text" class="form-input" v-model="producto.precio_obs" placeholder="obs. precio">
							</div>
						</div>
					</div>
				</div>

				<!-- PRODUCTOS RELACIONADO SI ES UN ALBUN -->
				<div v-if="producto.tipo_id == 2">
					<!-- muestro solo si es un album, es para seleccionar los productos relaciondos -->
					<div  class="form-linea flex flex-item-center p-10 m-b-10" style="border: 1px solid #00E185; border-radius: 5px; background: rgba(0, 225, 133, 0.2);" @click="acordeon('productos-relacionados')">
						<div class="form-columna ancho-100 flex m-0">
							<div class="ancho-80 flex flex-item-center flex-space-between flex-content-start">
								<i class="fas fa-sitemap m-r-10" style="color:#00E185;"></i>
								<span>Productos Relacionados al Álbum</span>
							</div>
							<div class="ancho-20 flex flex-item-center flex-content-end">
								<!-- <i class="fas fa-angle-up"></i> -->
								<i class="fas fa-angle-up m-r-10 arrow-productos-relacionados" style="color:#00E185;"></i>
							</div>
						</div>
					</div>
					<div class="zona-productos-relacionados" style="margin-bottom: 15px;">
						<div class="flex flex-item-center flex-content-center" style="margin-bottom: 15px;">
							<div class="ancho-60 flex flex-item-center cursor p-10" @click="mostrarFormProductosRelacionados()" style="border: 1px solid #ddd; border-radius: 5px;">
								<div class="ancho-25 txt-centrar"><i class="fas fa-project-diagram m-r-10" style="color:#00E185;"></i></div>
								<div class="ancho-75 txt-centrar"><span>Relacionar Productos</span></div>
							</div>
						</div>
		                <div v-for="(producto, indice) in productos_relacionados" class="lista-linea ancho-100 flex flex-space-between"  :class="'linea_'+indice" @click="lineaActiva(indice)">
		                    <div class="ancho-100 flex flex-item-center">
		                        <div class="ancho-30 m-r-10 flex" style="width: 60px; height: 60px; overflow: hidden; border-radius: 2px; box-shadow: 1px 1px #ddd;">

		                            <img v-if="$root.esImagen(producto.imagen_ppal)" style="object-fit: cover;" v-lazy="'/storage/'+producto.imagen_ppal" alt="" width="100%" >

		                            <LazyVideo v-if="$root.esVideo(producto.imagen_ppal)" :src="'/storage/'+producto.imagen_ppal"  style="object-fit: cover; width: 60px; height: 60px;" class="ancho-100" :attrs="{controls: false, playsinline: true, loop: '2', autoplay: true, muted: true}"/>

		                            <!-- <video v-if="$root.esVideo(producto.imagen_ppal)" style="object-fit: cover; width: 60px; height: 60px;"  autoplay muted loop>
		                                <source :src="'/storage/'+producto.imagen_ppal" type="video/mp4">
		                            </video> -->

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
		                    <div class="ancho-15 zona-acciones flex flex-space-between flex-item-center"  :class="'accion_'+indice" >
		                        <div class="ancho-45 flex flex-content-center">
		                            <a href="#" @click.prevent="eliminarProductoRelacionado(producto, indice)" title="quitar relación">
		                                <i class="fas fa-unlink txt-rojo-claro"></i>
		                            </a>
		                        </div>
		                    </div>
		                </div>
					</div>
				</div>




				<!-- CARACTERISTICAS -->
					<!-- las caracteristicas muestro si es de tipo producto ( valor 1) -->
				<div v-if="producto.tipo_id == 1">
					<div class="form-linea flex flex-item-center p-10 m-b-10" style="border: 1px solid #82C91E; border-radius: 5px; background: rgba(130, 201, 30, 0.2 );" @click="acordeon('caracteristicas')">
						<div class="form-columna ancho-100 flex m-0">
							<div class="ancho-80 flex flex-item-center flex-space-between flex-content-start">
								<i class="fas fa-swatchbook m-r-10" style="color: #82C91E;"></i>
								<span>Características</span>
							</div>
							<div class="ancho-20 flex flex-item-center flex-content-end">
								<i class="fas fa-angle-up m-r-10 arrow-caracteristicas" style="color:#82C91E;"></i>
							</div>
						</div>
					</div>
					<div class="zona-caracteristicas form-linea m-b-10">
						<div class="flex flex-item-center flex-content-center">
							<button style="border: none; padding: 10px; border-radius: 5px; border: 1px solid #ccc;" @click.prevent="mostrarSeleccionarCaracteristicas()">
								<div class="ancho-100 flex flex-item-center cursor">
									<div class="ancho-15 txt-centrar"><i class="fas fa-hand-pointer m-r-10" style="color:#82C91E;"></i></div>
									<div class="ancho-85 txt-centrar"><span>Agregar/Seleccionar</span></div>
								</div>
							</button>
						</div>
						<div class="flex flex-item-center flex-space-between p-10" style="border-bottom: 1px solid #ddd">
							<div class="ancho-60">
							 	<span><b>Características</b></span>
							</div>
							<div class="ancho-30 txt-centrar">
								<span><b>Valor</b></span>
							</div>
							<div class="ancho-10 txt-centrar">

							</div>
						</div>
<!-- 						<template v-for="(caracteristica, i) in caracteristicas_activas">
							<div class="flex flex-item-center flex-space-between" v-if="caracteristica.seleccion_confirmacion">
								<div class="ancho-70 p-10" style="border-bottom: 1px solid #ddd" @click="seleccionCaracteristica(i)">
								 	{{ caracteristica.caracteristica }}
								</div>
								<div class="ancho-30">
									<input type="text" class="form-input txt-centrar"
										 :class="['caracteristica_'+i, {'input-ingrese-valor': !caracteristica.valor}]"   @focus="evt=>seleccionCaracteristicaValor(evt)" v-model="caracteristica.valor" placeholder="Ingrese Valor" autocomplete="off">
								</div>
							</div>
						</template> -->
						<draggable v-model="caracteristicas_activas" @start="drag=true" @end="drag=false" @change="mostrarCategorias()">
							<template v-for="(caracteristica, i) in caracteristicas_activas" class="caracteristica-item">
								<div class="flex flex-item-center flex-space-between cursor" v-if="caracteristica.seleccion_confirmacion">
									<div class="ancho-60 p-10" style="border-bottom: 1px solid #ddd" @click="seleccionCaracteristica(i)">
									 	<span class="drag_texto">{{ caracteristica.caracteristica }}</span>
									</div>
									<div class="ancho-30">
										<input type="text" class="form-input txt-centrar drag_texto"
											 :class="['caracteristica_'+i, {'input-ingrese-valor': !caracteristica.valor}]"   @focus="evt=>seleccionCaracteristicaValor(evt)" v-model="caracteristica.valor" placeholder="Ingrese Valor" autocomplete="off">
									</div>
									<div class="ancho-10 flex flex-item-center flex-content-center p-10" style="border-bottom: 1px solid #ddd">
										<div>
											<i class="fas fa-trash-alt fz-14 txt-rojo-claro" @click.prevent="quitarCaracteristica(i)"></i>
										</div>
									</div>
								</div>
							</template>
								<div class="flex flex-item-center flex-space-between cursor">
									<div class="ancho-90 p-5" style="border-bottom: 1px solid #ddd">
									 	<!-- <span class="drag_texto"></span>
									 	<input type="text" class="form-input" placeholder="Ingresar Característica"> -->
									 	<caracteristicas-autocompletar v-bind:caracteristicas="caracteristicas_activas" v-bind:producto="producto"></caracteristicas-autocompletar>
									</div>
									<div class="ancho-10 flex flex-item-center flex-content-center">
										<div>
											<i class="fas fa-plus fz-14 txt-verde"></i>
										</div>
									</div>

<!-- 									<div class="ancho-30">
										<input type="text" class="form-input txt-centrar drag_texto"
											 :class="['caracteristica_'+i, {'input-ingrese-valor': !caracteristica.valor}]"   @focus="evt=>seleccionCaracteristicaValor(evt)" v-model="caracteristica.valor" placeholder="Ingrese Valor" autocomplete="off">
									</div> -->
								</div>
						</draggable>
					</div>
				</div>
				<!-- CATEGORIAS -->
				<div v-if="producto.tipo_id == 1">
					<div class="form-linea flex flex-item-center p-10 m-b-10" style="border: 1px solid #17A6EC; border-radius: 5px; background: rgba(23, 166, 236, 0.2);" @click="acordeon('categorias')">
						<div class="form-columna ancho-100 flex m-0">
							<div class="ancho-80 flex flex-item-center flex-space-between flex-content-start">
								<i class="fas fa-boxes m-r-10" style="color: #17A6EC;"></i>
								<span>Categorías</span>
							</div>
							<div class="ancho-20 flex flex-item-center flex-content-end">
								<i class="fas fa-angle-up m-r-10 arrow-categorias" style="color:#17A6EC;"></i>
							</div>
						</div>
					</div>

					<div class="zona-categorias form-linea m-b-10">
						<div class="flex flex-item-center flex-content-center">
							<button style="border: none; padding: 10px; border-radius: 5px; border: 1px solid #ccc;" @click.prevent="mostrarSeleccionarCategorias()">
								<div class="ancho-100 flex flex-item-center cursor">
									<div class="ancho-15 txt-centrar"><i class="fas fa-hand-pointer m-r-10" style="color:#17A6EC;"></i></div>
									<div class="ancho-85 txt-centrar"><span>Agregar/Seleccionar</span></div>
								</div>
							</button>
						</div>
						<div class="flex flex-item-center flex-space-between p-10" style="border-bottom: 1px solid #ddd">
							<div class="ancho-100">
							 	<center><span><b>Categorías Seleccionadas</b></span></center>
							</div>
						</div>
						<div class="zona-categorias-item flex flex-content-center" style="flex-flow:row wrap;">
							<draggable v-model="categorias_activas_orden_posicion" @start="drag=true" @end="drag=false" @change="mostrarCategorias()"
							 class="flex flex-content-center" style="flex-flow:row wrap;">
								<template v-for="(categoria, i) in categorias_activas_orden_posicion">
									<div class="flex flex-item-center flex-space-between categoria-item p-5 cursor" v-if="categoria.seleccion_confirmacion" style="min-width: 150px; background: white;">
										<div class="ancho-100 m-r-5 flex flex-content-center">
											<span class="drag_texto">{{ categoria.categoria }}</span>
										</div>
										<div class="flex flex-item-center flex-content-center cursor" style="width: 20px;" @click="quitarCategoria(i)">
											<div class="flex flex-item-center flex-content-center" style="border:1px solid red; border-radius: 50%; width: 20px; height: 20px;">
												<i class="fas fa-times fz-14 txt-rojo-claro"></i>
											</div>
										</div>
									</div>
								</template>

								<div class="flex flex-item-center flex-content-center categoria-item p-r-5 p-l-8 cursor" style="min-width: 200px; background: white;">
									<div class="ancho-100 m-l-5 flex flex-content-center">
										<!-- <input class="" type="text" placeholder="Agregar categoria" style="display: block;"> -->
										<categorias-autocompletar v-bind:categorias="categorias_activas_orden_posicion" v-bind:producto="producto"></categorias-autocompletar>
									</div>
									<div class="flex flex-item-center flex-content-center cursor" style="width: 20px;" @click="quitarCategoria(i)">
										<div class="flex flex-item-center flex-content-center" style="border:1px solid green; border-radius: 50%; width: 20px; height: 20px;">
											<i class="fas fa-plus fz-14 txt-verde"></i>
										</div>
									</div>
								</div>
							</draggable>
						</div>
					</div>
				</div>
				<!-- IMAGENES -->
				<div>
					<div class="form-linea flex flex-item-center p-10 m-b-10" style="border: 1px solid #AF8AC8; border-radius: 5px; background: rgba(167, 119, 200, 0.2);" @click="acordeon('imagenes')">
						<div class="form-columna ancho-100 flex m-0">
							<div class="ancho-80 flex flex-item-center flex-space-between flex-content-start">
								<i class="fas fa-images m-r-10" style="color:#A777C8;"></i>
								<span>Imágenes</span>
							</div>
							<div class="ancho-20 flex flex-item-center flex-content-end">
								<!-- <i class="fas fa-angle-up"></i> -->
								<i class="fas fa-angle-up m-r-10 arrow-imagenes" style="color:#A777C8;"></i>
							</div>
						</div>
					</div>
					<div class="zona-imagenes form-linea m-b-10">
						<draggable v-model="imagenes" @start="drag=true" @end="drag=false" @change="mostrar()"
						 class="flex flex-content-center" style="flex-flow:row wrap;">
							<div v-for="(imagen, i) in imagenes" :key="imagen.id" v-if="!imagen.borrar" class="p-5 m-5" style="border: 1px solid #ddd; border-radius: 5px">
								<div style="position: relative;">
									<div style="border:1px solid #F77D7D; border-radius: 50%; width: 25px; height: 25px; position: absolute; top: -10px; right: -10px; background: white;" class="flex flex-item-center flex-content-center cursor" >
										<a href="" style="display: block;" @click.prevent="eliminarImagen(i)"><i class="fas fa-trash-alt fz-14 txt-rojo-claro" @click.prevent="eliminarImagen(i)"></i></a>

									</div>
									<img v-if="$root.esImagen(imagen.imagen)" style="object-fit: cover" v-lazy="'/storage/'+imagen.imagen" alt="" width="90" height="90">

									<LazyVideo v-if="$root.esVideo(imagen.imagen)" width="90" height="90" :src="'/storage/'+imagen.imagen"  style="object-fit: cover; width: 90px; height: 90px;"  :attrs="{controls: false, playsinline: true, loop: '2', autoplay: true, muted: true}"/>
								</div>
							</div>
<!-- 							<div id="div_file" class="flex flex-item-center flex-content-center m-5" style="border: 1px solid #ddd; border-radius: 5px; width: 95px; height: 95px;">
								<input id="file" type="file" @change="obtenerImagen" multiple style="display: block;">
								<i class="fas fa-plus txt-gris"></i>
							</div> -->
						</draggable>
						<div id="div_file" class="flex flex-item-center flex-content-center m-5" style="border: 1px solid #ccc; border-radius: 5px; width: 80%; margin: auto; height: 45px;">
								<input id="file" type="file" @change="obtenerImagen" multiple style="display: block;">
								<i class="fas fa-upload" style="color: #A777C8;"></i><span class="m-l-10">Subir Imagen/Videos</span>
						</div>
					</div>
					<!-- lienzo ccarga imagenes subiendoImagenes-->
					<div v-if="subiendoImagenes" class="flex flex-item-center flex-content-center" style="width: 100%; height: 100vh; position: fixed; background: rgba(0,0,0,0.5); z-index: 99; top: 0; left: 0;">
							<div class="box-upload flex flex-item-center flex-space-between " style="width: 300px; height: 150px; background: white; border-radius: 10px;">
								<div class="ancho-50 flex flex-direction-column flex-space-between">
									<div class="ancho-100 flex flex-item-center flex-content-center m-b-10">
										<span class="txt-centrar">Subiendo Imagenes/Videos </span>
									</div>
									<div class="ancho-100 flex flex-item-center flex-content-center m-b-10">
										<span class="fz-20">{{ uploadImagen.nro_imagen }} / {{ uploadImagen.max_nro }}</span>
									</div>
									<div class="ancho-80 margen-auto progress-bar" id="progressBar" style="height: 20px; border: 1px solid darkblue; overflow: hidden; position: relative;">
										<div class="progress-bar-fill flex flex-item-center" style="height: 20px;background: lightblue; transition: width 0.25s; " :style="{width: percentCompleted+'%'}">
											<div style="position: absolute; left: 40%;">
												<span class="progress-bar-text">{{ percentCompleted }} %</span>
											</div>
										</div>
									</div>
								</div>
								<div class="ancho-50 flex flex-item-center flex-content-center">
									<img width="100px" height="100px" v-lazy="'/images/Preloader_1.gif'" alt="">
								</div>
							</div>
					</div>
				</div>
			</div>
			<!-- botonera (se mostara una u otra dependiendo de la vista) -->
				<!-- Botonera 01 -->
            <div class="form-foot p-t-10 flex flex-item-center flex-content-center display-sx display-s no-display-m no-display-l no-display-lg" style="position: fixed; bottom: 0px; left: 0px; background: white;">
            	<div class="ancho-95 ancho-sx-95 ancho-s-90 ancho-m-80 ancho-l-70 ancho-lg-60 flex flex-content-center" >
		            <div class="form-linea flex flex-space-between flex-item-center ancho-100" >
		                <div class="form-columna m-b-0">
		                    <button class="btn form-btn-cancelar cursor p-l-20 p-r-20" @click.prevent="cancelar()">Cancelar</button>
		                </div>
		                <div class="form-columna m-b-0">
		                    <button class="btn form-btn-entrar cursor p-l-20 p-r-20" @click.prevent="guardarFormulario()">Guardar</button>
		                </div>
		            </div>
            	</div>
        	</div>
        		<!-- Botonera 02 -->
			<div class="no-display-s display-m display-l display-lg " style="position: fixed; bottom: 50px; right: 10px; background: white;">
				<div class="flex flex-direction-column">
	                <button class="btn form-btn-entrar cursor p-l-20 p-r-20 m-b-10" @click.prevent="guardarFormulario()">Guardar</button>
	                <button class="btn form-btn-cancelar cursor p-l-20 p-r-20" @click.prevent="cancelar()">Cancelar</button>
				</div>
        	</div>
		<!-- </form> -->

		<!-- seleccion Lienzo -->
			<caracteristicas-seleccionar ref="formCaracteristicas" v-bind:caracteristicas="caracteristicas_activas" v-bind:producto="producto"></caracteristicas-seleccionar>

		<categorias-seleccionar ref="formCategorias" v-bind:categorias="categorias_activas" v-bind:producto="producto"></categorias-seleccionar>
		<productos-seleccionar ref="formProductosRelacionados" v-bind:productos_relacionados="productos_relacionados" v-bind:producto="producto"></productos-seleccionar>
	</div>
</template>
<script>
	import draggable from 'vuedraggable'
	import VueLazyload from 'vue-lazyload'
    import VueLazyLoadVideo from 'vue-lazyload-video'
    Vue.use(VueLazyload)
    Vue.use(VueLazyLoadVideo)
	export default{
		props:['producto', 'negocio'],
		components: {
            draggable,
        },
		data(){
			return {
				precio_display:'',
				valor_precio: '',
				viewActualizarPrecio: false,
				percentCompleted : 0,
				// viewSeleccionarCaracteristicas: false,
				// viewSeleccionarCategorias:false,
				productos_relacionados:[],
				caracteristicas_activas:[],
				categorias_activas:[],
				categorias_activas_orden_posicion:[],
				imagenes:[],
				activarObligatorios:false,
				subiendoImagenes:false,
				uploadImagen:{
					nro_imagen: 0,
					max_nro:0,
				}
			}
		},
		created(){
		},
		mounted(){
			//this.acordeon('producto');
			// this.acordeon('caracteristicas');
			// this.acordeon('categorias');
			// this.acordeon('productos-relacionados');
			// this.acordeon('imagenes');
			this.precio_display = this.$root.formatoPrecio(this.producto.precio);
			this.buscarCaracteristicas();
			this.buscarCategorias();
			this.buscarImagenes(this.producto.id);
			if (this.producto.tipo_id == 2) {
				this.buscarProductosRelacionados();
			}
		},
		methods:{
			buscarProductosRelacionados(){
				let url = '/producto/'+this.producto.id+'/productos_relacionados';
				axios.get(url)
                .then(response => {
                	// console.log(response.data);
                	this.productos_relacionados = response.data;
                });
			},
			guardarFormulario(){

				if (this.imagenes.length == 0) {
					// this.$root.mostarMensaje('error','Producto sin imagen','Carge com minimo una imagen');
					Swal.fire({
                      // icon: 'error',
                      title: 'Producto sin imagen',
                      text: 'Suba como mínimo una imagen',
                      imageUrl: '/images/sin_imagen.png',
                    })
				}else{
					var url_back = (this.producto.tipo_id == 1 ? '/productos' : '/albumes' )
					if (this.producto.producto != '') {
						self = this;
						let url = '/producto/guardar';
						let form = {};
						form.producto = this.producto;
						form.caracteristicas = this.caracteristicas_activas;
						form.categorias = this.categorias_activas_orden_posicion;
						form.imagenes = this.imagenes;
						axios.post(url, form)
						.then(response => {
							// console.log(response.data);
							self.mostarMensaje(response.data);
							location.href = url_back;
						})
					}else{
						this.activarObligatorios = true;
						$("#producto_nombre").focus();
						$("#producto_nombre").addClass('input-obligatorio');
					}
				}
			},
			productoNombre(evt){
				if (this.activarObligatorios) {
					var query = evt ? evt.target.value : '';
					if (query.length > 0) {
						$("#producto_nombre").removeClass('input-obligatorio');
					}else{
						$("#producto_nombre").addClass('input-obligatorio');
					}
				}
			},
			mostrarCategorias(){
				// console.log(this.categorias_activas);
				// console.log(this.categorias_activas_orden_posicion);
			},
			mostrar(){
				// console.log(this.imagenes);
			},
			acordeon(zona){
				$(".arrow-"+zona).toggleClass( "rotate" );
				$( ".zona-"+zona ).animate({
				    height: "toggle"
				  }, 500);
			},
			buscarImagenes(id){
				let url = '/producto/'+id+'/imagenes';
				axios.get(url)
                .then(response => {
                	this.imagenes = response.data;
                });
			},
			obtenerImagen(e){
				let files = e.target.files;
				let url = "/producto/imagenes/guardar";
				this.cargarImagenes(files, 1, files.length);
			},
			cargarImagenes(files, nro_imagen, max_nro){
				this.uploadImagen.nro_imagen = nro_imagen;
				this.uploadImagen.max_nro = max_nro;
				var self_cargar_imagenes = this;
				self_cargar_imagenes.percentCompleted = 0;

				let url = "/producto/imagenes/guardar";
				if (nro_imagen <= max_nro) {
					this.subiendoImagenes = true;
					let formData = new FormData();
					formData.append('file', files[nro_imagen-1]);
					formData.append('negocio_url', this.negocio.url);
					formData.append('producto_id', this.producto.id);

					axios.post(url, formData, { headers: {'Content-Type': 'multipart/form-data'},
												onUploadProgress: function(progressEvent) {
      												self_cargar_imagenes.percentCompleted = Math.round((progressEvent.loaded * 100) / progressEvent.total);
    												}
    											})
					.then(response => {
						this.buscarImagenes(this.producto.id);
						var i = nro_imagen + 1;
						this.cargarImagenes(files, i, max_nro);
					})
					.catch(function(){
						self_cargar_imagenes.mostarMensaje('error','Upload', 'Ocurrio un error al subir los archivos');
						self_cargar_imagenes.subiendoImagenes = false;
					})
				}else{
					this.subiendoImagenes = false;
				}
			},
			lineaActiva(indice){
                $('.lista-linea').removeClass('lista-linea-activa');
                $('.linea_'+indice).addClass('lista-linea-activa');
                // $('.zona-acciones').width(0);
                // setTimeout(function(){
                //     $('.accion_'+indice).width('30%');
                //     },
                // 50);
			},
			eliminarProductoRelacionado(producto, i){
				self = this;
				Swal.fire({
					  title: self.productos_relacionados[i].producto,
					  text: "Quitar relación de este producto?",
					  imageUrl: '/storage/'+self.productos_relacionados[i].imagen_ppal,
					  imageWidth: 400,
  					  // imageHeight: 200,
					  showCancelButton: true,
					  confirmButtonColor: '#FF6E97',
					  cancelButtonColor: '#ccc',
					  cancelButtonText: 'Cancelar',
					  confirmButtonText: 'Si, Eliminar!'
					}).then((result) => {
					  if (result.value) {
					  	//self.productos_relacionados.splice(i,1);
					    let url = '/producto/producto_relacionado_eliminar/';
						axios.get(url, {
                        params: {
                            'album_id': self.producto.id,
                            'producto_id': self.productos_relacionados[i].id
                        }})
		                .then(response => {
		                	// console.log(response.data);
		                	// this.imagenes = response.data;
		                	self.productos_relacionados.splice(i,1);
		                	this.$root.mostarMensaje('ok','','Se ha eliminado correctamente');
		                });
					  }
					})
			},
			eliminarImagen(i){
				self = this;
				Swal.fire({
					  title: 'Eliminar Imagen?',
					  //text: "You won't be able to revert this!",
					  imageUrl: '/storage/'+self.imagenes[i].imagen,
					  imageWidth: 400,
  					  // imageHeight: 200,
					  showCancelButton: true,
					  confirmButtonColor: '#FF6E97',
					  cancelButtonColor: '#ccc',
					  cancelButtonText: 'Cancelar',
					  confirmButtonText: 'Si, Eliminar!'
					}).then((result) => {
					  if (result.value) {
					    self.imagenes[i].borrar = 1;
					    let url = '/producto/'+self.imagenes[i].id+'/imagenes/borrar';
						axios.get(url)
		                .then(response => {
		                	//console.log(response.data);
		                	// this.imagenes = response.data;
		                	this.$root.mostarMensaje('ok','','Se ha eliminado correctamente');
		                });
					  }
					})
			},
			buscarCaracteristicas(){
				let url = '/producto/caracteristicas_activas';
                axios.get(url, {
                        params: {
                            producto_codigo: this.producto.codigo
                        }})
                .then( response => {
                	// console.log(response.data);
                	this.caracteristicas_activas = response.data;
                	this.caracteristicas_activas.sort(function(a, b){
                		  if (a.posicion > b.posicion) {
						    return 1;
						  }
						  if (a.posicion < b.posicion) {
						    return -1;
						  }
						  // a must be equal to b
						  return 0;
                	});
                	// console.log(this.caracteristicas_activas);
                });
			},
			buscarCategorias(){
				let url = '/producto/categorias_activas';
                axios.get(url, {
                        params: {
                            producto_codigo: this.producto.codigo
                        }})
                .then( response => {
                	// console.log(response.data);
                	this.categorias_activas = response.data;
                	this.categorias_activas_orden_posicion = response.data;
                	this.categorias_activas_orden_posicion.sort(function(a, b){
                		  if (a.posicion > b.posicion) {
						    return 1;
						  }
						  if (a.posicion < b.posicion) {
						    return -1;
						  }
						  // a must be equal to b
						  return 0;
                	});
                	// console.log(this.categorias_activas);
                });
			},
			seleccionarPrecio(evt){
				$(evt.target).focus(function(event) {
					this.select();
				});
			},
			actulizarPrecio(){

				this.viewActualizarPrecio = false;


				var precio = $(".precio").val();
				var precio_aux = '';
				var cant_puntos = 0;

				precio = precio.replace(/^0+/, '');
				precio = precio.replace('.','').replace(',','.');

				for (var i = precio.length; i >= 0; i--) {
					if (precio.charAt(i) == '.' && cant_puntos < 1){
						cant_puntos++;
						precio_aux = precio.charAt(i)+precio_aux;
					}
					if (precio.charAt(i) != '.' && cant_puntos <= 1){
						precio_aux = precio.charAt(i)+precio_aux;
					}
				}

				// this.precio_display = precio.replace(/^0+/, '');

				//precio = precio.replace(/^0+/, '');
				this.producto.precio = precio_aux;
				// this.producto.precio = precio.replace('.','').replace(',','.');
				// console.log(this.producto.precio);
			},
			// formatoPrecio(value) {
			// 	//value = value.replace(/^0+/, '');
		 //        let val = (value/1).toFixed(2).replace('.', ',')
		 //        return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
		 //    },
		    seleccionCaracteristica(index){
		    	$('.caracteristica_'+index).focus();
		    },
		    seleccionCaracteristicaValor(evt){
				$(evt.target).focus(function(event) {
					this.select();
				});
			},
			mostrarSeleccionarCategorias(){
				// console.log(this.categorias_activas);
				this.$refs.formCategorias.mostrar();
			},
			mostrarSeleccionarCaracteristicas(){
				this.$refs.formCaracteristicas.mostrar();
			},
			mostrarFormProductosRelacionados(){
				this.$refs.formProductosRelacionados.mostrar();
			},
			quitarCategoria(i){
				this.categorias_activas[i].seleccion_confirmacion = false;
			},
			quitarCaracteristica(i){
				this.caracteristicas_activas[i].seleccion_confirmacion = false;
			},
			cancelar(){
				// console.log(this.producto.guardar);
				var url_back = (this.producto.tipo_id == 1 ? '/productos' : '/albumes' )
				if (this.producto.guardar == 0) {
					let url = "/productos/"+this.producto.id+"/eliminar";
					axios.get(url)
	                .then( response => {
	                	// console.log(response.data);
	                	// this.caracteristicas_activas = response.data;
	                	 location.href=url_back ;
	                });
				}else{
					location.href=url_back ;
				}
			},
			mostarMensaje($estado, titulo ='', subtitulo=''){
                if ($estado == 'ok') {
                    Swal.fire({
                      position: 'top-end',
                      icon: 'success',
                      title: '',
                      showConfirmButton: false,
                      timer: 1000,
                      width: '180px',
                    })
                }
                if ($estado == 'error') {
                    Swal.fire({
                      position: 'top-end',
                      icon: 'error',
                      title: '',
                      showConfirmButton: false,
                      timer: 1000,
                      width: '180px',
                    })
                }
            }
		},
		// computed: {
		// 	mostrarSeleccionarCategorias(){
		// 		this.$refs.formCategorias.mostrar();
		// 		history.pushState('', 'Title of page', '/create/team');
		// 	}
		// }
	}
</script>
<!-- <style scoped>
	.producto-formulario i{
        -webkit-transition: all 500ms ease-in-out;
        -moz-transition: all 500ms ease-in-out;
        -o-transition: all 500ms ease-in-out;
        -ms-transition: all 500ms ease-in-out;
	}
	.producto-formulario .rotate{
		transform: rotate(180deg);
		z-index: -0;
	}
	.producto-formulario .categoria-item {
		min-width: 25%;
		max-width: 40%;
		margin: 5px;
		padding: 5pxs;
		border: 1px solid #17A6EC;
		border-radius: 20px;
	}
	.producto-formulario .input-ingrese-valor {
		background: #EDD1D1 !important;
	}
	.producto-formulario  div#div_file{
        position:relative;
        cursor: pointer;
        /*margin:50px;*/
        padding:5px;
        /*width:150px;*/
/*        background-color: #2499e3;
        -webkit-border-radius:5px;
        -webkit-box-shadow:0px 3px 0px #1a71a9;*/
    }

    .producto-formulario .lista-linea {
        padding: 5px;
        border-bottom: 1px solid #ccc;
    }
    .producto-formulario .lista-linea.linea_0 {
        border-top: 1px solid #ccc !important;
    }

    .producto-formulario .lista-linea-activa {
        background: #ECECEC;
    }

    .producto-formulario input#file{
        border:1px solid black;
        cursor: pointer;
        position:absolute;
        top:0px;
        left:0px;
        right:0px;
        bottom:0px;
        width:100%;
        height:100%;
        opacity: 0;
    }

</style> -->