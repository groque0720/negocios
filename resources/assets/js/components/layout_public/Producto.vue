<template>
	<div class="ancho-100" >
 		<layout-cabecera v-bind:negocio="negocio"></layout-cabecera>

 		<div class="ancho-100 ancho-m-80 margen-auto no-display-lg no-display-l display-m" style="background: white;" >
	 		<div style="border-radius: 15px; position: relative;" @click="openLightbox(imagen_ppal_index)">
	 			<img style="object-fit: cover;" class="ancho-100" :src="imagen_ppal" alt="" >
	 			<div class="flex flex-item-center flex-content-center"
	 				 style="position: absolute; bottom: 15px; left: 15px; width: 35px; height: 35px; background: rgba(0,0,0,0.5); border-radius: 50%;" >
	 				<i class="fas fa-expand txt-blanco"></i>
	 			</div>
				<div style="position: absolute; top: calc(50% - 50px); left: calc(50% - 50px);" >
	 				<i class="fas fa-search-plus" style="font-size: 100px !important; color: black; opacity: 0.2;"></i>
	 			</div>
	 		</div>
	 		<div class="imagenes ancho-100 p-10">
				<div class="scrolling-wrapper scrollbar" id="style-2">
					<div v-for="(imagen, index) in producto.imagenes" class="card" style="overflow: hidden; position: relative;" @click="openLightbox(index)">
						<img style="object-fit: cover;" :src="'/storage/'+imagen.imagen" alt="">
						<div style="position: absolute; top: calc(50% - 15px); left: calc(50% - 15px);" >
			 				<i class="fas fa-search-plus" style="font-size: 30px !important; color: white; opacity: 0.5;"></i>
			 			</div>
					</div>
				</div>
			</div>


			<div class="ancho-100 p-10 m-b-10">
					<div class="flex flex-item-center flex-content-center m-b-5">
						<span class="fz-30 txt-negrita txt-mayuscula titulo">{{ producto.producto }}</span>
					</div>

					<div class="precio" >
						<!-- <div class="fz-15 txt-negrita txt-mayuscula titulo m-b-5">Precio</div> -->
						<div class="flex flex-wrap txt-negrita fz-25" v-if="producto.precio>0">
							<span class="m-r-10 fz-25">$</span><span class="fz-25">{{ $root.formatoPrecio(producto.precio) }}</span>
						</div>
					</div>

					<div class="descripcion m-b-10">
						<span>{{ producto.descripcion }}</span>
					</div>

					<div class="caracteristicas m-b-10">
						<!-- <div class="fz-15 txt-negrita txt-mayuscula titulo m-b-5">Características</div> -->
						<div v-for="caracteristica in producto.caracteristicas">
							<div class="txt-negrita">{{caracteristica.caracteristica}} : {{ caracteristica.pivot.valor }}</div>
						</div>
					</div>

					<div class="categorias m-b-10">
						<!-- <div class="fz-15 txt-negrita txt-mayuscula titulo m-b-5">Etiquetas</div> -->
						<div class="flex flex-wrap">
							<div v-for="categoria in categorias_lista" class="m-r-10">
								<a href="" class="link"><span class="txt-celeste">#{{ categoria.categoria }} </span></a>
							</div>
						</div>
					</div>
			</div>
		</div>
		<!--   -->
		<div class="flex flex-direction-column ancho-70 p-10 margen-auto sombra-box no-display-m no-display-s no-display-sx m-t-20" style="border-radius: 15px; background: white; box-shadow: 0px 0px 20px 5px #ddd;" >
			<div class="detalle-producto flex flex-space-between ancho-100 m-b-10" style="overflow: hidden;">
				<div class="ancho-100 flex flex-item-center flex-content-center" @click="openLightbox(imagen_ppal_index)">
					<div class="flex cursor-lupa"
						 style="position: relative; max-width: 100%; max-height: 400px; border-radius: 15px; overflow: hidden;" >
						<img style="object-fit: cover;" class="ancho-100" :src="imagen_ppal" alt="" >
						<div class="flex flex-item-center flex-content-center"
			 				 style="position: absolute; bottom: 15px; left: 15px; width: 35px; height: 35px; background: rgba(0,0,0,0.5); border-radius: 50%;">
			 				<i class="fas fa-expand txt-blanco"></i>
			 			</div>
			 			<div class="cursor-lupa" style="position: absolute; top: calc(50% - 50px); left: calc(50% - 50px);" >
			 				<i class="fas fa-search-plus" style="font-size: 100px !important; color: black; opacity: 0.2;"></i>
			 			</div>
					</div>
				</div>
				<div class="ancho-100 p-10 m-b-10 flex flex-direction-column flex-space-between">

					<div class="flex flex-item-center flex-content-center m-b-5">
						<span class="fz-28 txt-negrita txt-mayuscula titulo">{{ producto.producto }}</span>
					</div>

					<div class="precio">
						<!-- <div class="fz-15 txt-negrita txt-mayuscula titulo m-b-5">Precio</div> -->
						<div class="flex flex-wrap txt-negrita fz-25" v-if="producto.precio>0">
							<span class="m-r-10 fz-20">$</span><span class="fz-20">{{ $root.formatoPrecio(producto.precio) }}</span>
						</div>
					</div>

					<div class="descripcion m-b-10">
						<span>{{ producto.descripcion }}</span>
					</div>

					<div class="caracteristicas m-b-10 flex flex-wrap">
						<!-- <div class="fz-15 txt-negrita txt-mayuscula titulo m-b-5">Características</div> -->
						<div v-for="caracteristica in producto.caracteristicas" class="ancho-32 m-b-5">
							<div class="ancho-100 flex  flex-item-center flex-content-star">
								<div class="txt-negrita">{{caracteristica.caracteristica}} :</div>
								<div class="">{{ caracteristica.pivot.valor }}</div>
							</div>
						</div>
					</div>

					<div class="categorias m-b-10">
						<!-- <div class="fz-15 txt-negrita txt-mayuscula titulo m-b-5">Etiquetas</div> -->
						<div class="flex flex-wrap">
							<div v-for="categoria in categorias_lista" class="m-r-10">
								<a href="" class="link"><span class="txt-celeste">#{{ categoria.categoria }} </span></a>
							</div>
						</div>
					</div>
					<!-- productos relacionados -->
					<div class="flex flex-wrap">
						<div class="producto-relacionado ancho-32 flex p-5 m-b-5 cursor" v-if="producto.relacionados"
							 v-for="relacion in producto.relacionados" style="background: white; margin-right: 1%; border-radius: 5px; box-shadow: 0px 0px 5px 2px #ddd;"
							 @click.prevent="irProducto(relacion.codigo, '')">
							 <div class="flex m-r-5" style="width: 50px; height: 50px;">
							 	<img style="object-fit: cover; width: 50px; height: 50px;"  :src="'/storage/'+relacion.imagen_ppal" alt="">
							 </div>
							 <div class="ancho-100 flex flex-direction-column">
								<div class="txt-mayuscula txt-negrita fz-11 p-2">{{ relacion.producto }}</div>
								<div class=""><span class="fz-11" v-if="relacion.precio>0">$ {{ $root.formatoPrecio(relacion.precio) }}</span></div>
							 </div>
						</div>
					</div>

				</div>
			</div>
			<div class="imagenes ancho-100">
				<div class="scrolling-wrapper scrollbar" id="style-2">
					<div v-for="(imagen, index) in producto.imagenes" class="card" style="border-radius: 10px; overflow: hidden; position: relative;" @click="openLightbox(index)">
						<img style="object-fit: cover;" class="ancho-100" :src="'/storage/'+imagen.imagen" alt="">
						<div style="position: absolute; top: calc(50% - 25px); left: calc(50% - 25px);" class="cursor-lupa">
			 				<i class="fas fa-search-plus" style="font-size: 50px !important; color: black; opacity: 0.3;"></i>
			 			</div>
					</div>
				</div>
			</div>
			<div class="consultar_ws">

			</div>
		</div>
		<!-- <vue-gallery-slideshow v-if="viewGaleria" :images="images" :index="index" @close="index = null"></vue-gallery-slideshow> -->
		<LightBox v-if="viewGaleria" ref="lightbox" :media="images" :startAt="imagen_ppal_index" v-on:onClosed="closeLightBox()"></LightBox>

		<div class="m-t-20 p-5" style="background: rgba(0,0,0,0.1);">
			<layout-productos-mismas-categorias  v-bind:negocio="negocio" v-bind:producto="producto" v-bind:categorias="categorias_lista"></layout-productos-mismas-categorias>
		</div>
		<div class="m-t-10">
			<div class="flex flex-item-center flex-content-center m-b-10">
				<span class="fz-18 txt-negrita txt-mayuscula">Otros</span>
			</div>
			<layout-grid-columnas v-bind:negocio="negocio"></layout-grid-columnas>
		</div>
	</div>
</template>
<script>
	import LightBox from 'vue-image-lightbox'
	import VueLazyLoad from 'vue-lazyload'
	Vue.use(VueLazyLoad)
    export default {
        props:['negocio', 'producto','imagen_id'],
		components: {
			VueLazyLoad,
		    LightBox,
		  },
        data(){
            return {
            	viewGaleria: false,
            	images:[],
            	index:0,
            	imagen_ppal:'',
            	imagen_ppal_index:0,
            	categorias_lista:this.producto.categorias,
            }
        },
        mounted() {

	       	// configuracion boton atras
        	    var self_galeria = this;
	            $(window).on('popstate', function() {
	            	// remuevo clase que me quita el scroll del body
	            	$('body').removeClass('vue-lb-open');

	                self_galeria.viewGaleria  = false;
	                self_galeria.$refs.lightbox.closeLightBox();
	            });

	        // cargo las imagenes en el componente de la galeria
        	self = this;
        	// var img = [];
        	var img_ = {};
        	this.producto.imagenes.forEach(function(imagen, index){
        		// busco la foto que selecciono en el grid pincipal para que sea la imagen principal de la pagina
        		if (imagen.id == self.imagen_id) {
        			self.imagen_ppal = '/storage/'+imagen.imagen;
        			self.imagen_ppal_index = index;
        		}
        		var img_ = {};
        		img_.thumb = '/storage/'+imagen.imagen;
        		img_.src = '/storage/'+imagen.imagen;
        		self.images.push(img_);
        	});

        	// uso una variable 'categorias_lista' para que liste las categorias,
        	// pero en los albumes no tiene categorias, sino hay que listar las
        	// categorias de los productos relacionados
        	this.categorias_lista = this.producto.categorias;

        	// preparo las categorias del los albumes que tiene productos relacionados
        	if (this.producto.tipo_id == 2) {

        		this.producto.relacionados.forEach(function(relacionado){
        			relacionado.categorias.forEach(function(categoria){
        				self.categorias_lista.push(categoria);
        			})
        		})
        		let hash = {};
        		// con la siguiente funcion quito los duplicados de las categorias.
        		self.categorias_lista = self.categorias_lista.filter(o => hash[o.id] ? false : hash[o.id] = true);
        	}
        },
        methods: {
        	openLightbox (index) {
        		this.viewGaleria = true;
				self = this;
				history.pushState('', 'Galeria', 'galeria');
                setTimeout(function(){
					self.$refs.lightbox.showImage(index);
                    },
                150);

		    },
		    closeLightBox(){
		    	// this.viewGaleria = true;
		    	history.go(-1)
		    },
		    irProducto(producto_codigo, id){
                //console.log(id);
                window.location = '/'+this.negocio.url+'/producto/'+producto_codigo+'/'+id;
            }
        },

    }
</script>
<style>

	.titulo {
		/*font-family: 'Archivo Black', sans-serif*/
	}

	.scrolling-wrapper {
		display: flex;
	  	flex-wrap: nowrap;
	  	overflow-x: auto;
	  	-webkit-overflow-scrolling: touch;
	  	height: 100% !important;
	  	padding-bottom: 0px !important;
	}

	.scrolling-wrapper::-webkit-scrollbar {
		/*display: none;*/
		height: 10px;
	}
	.card {
	flex: 0 0 auto;
	margin-right: 10px;
	}
	.card img {
		width: 150px;
		height: 150px;
		cursor: zoom-in;
	}

	@media  (min-width: 980px) and  (max-width: 1200px){
		.card img {
			width: 130px !important;
			height: 130px !important;
		}
	}

	@media (min-width: 768px) and (max-width: 979px) {
		.card img {
			width: 110px !important;
			height: 110px !important;
		}
	}
	@media (min-width: 480px) and (max-width: 767px) {
		.card img {
			width: 90px !important;
			height: 90px !important;
		}
		.scrolling-wrapper::-webkit-scrollbar  {
			display: none;
		}
	}
	@media (max-width: 479px) {
		.card img {
			width: 70px !important;
			height: 70px !important;
		}
		.scrolling-wrapper::-webkit-scrollbar  {
			display: none;
		}
	}
	.producto-relacionado:hover {
		/*background: #eee !important;*/
		box-shadow: 0px 0px 3px 5px #ddd;
	}
	.vue-lb-footer-count {
		display: none !important;
	}
	.vue-lb-figure {
		display: flex !important;
		justify-content: center !important;
		align-items: flex-center !important;
	}
	.vue-lb-modal-image {
/*		width: 120% !important;
		max-width: 150% !important;
		margin-left: -25%;
		height: auto;
		max-height: 85vh !important;*/
		transform: scale(1.25);
	}

</style>