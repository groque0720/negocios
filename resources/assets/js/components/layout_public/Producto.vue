<template>
	<div class="ancho-100  p-10">
<!-- 		<layout-public v-bind:negocio="negocio"></layout-public> -->
		<div class="flex flex-direction-column ancho-95 ancho-m-95 ancho-l-90 ancho-lg-70 p-10 margen-auto sombra-box" style="border: 1px solid #ccc; border-radius: 15px;" >
			<div class="detalle-producto flex flex-space-between ancho-100 m-b-10" style="overflow: hidden;">
				<div class="ancho-45 flex">
					<div class="flex cursor-lupa" style="max-width: 100%; max-height: 400px; border-radius: 15px; overflow: hidden;" >
						<!-- <img style="object-fit: cover;" class="ancho-100" :src="'/storage/'+producto.imagen_ppal" alt="" @click="openLightbox(0)"> -->
						 <img style="object-fit: cover;" class="ancho-100" :src="imagen_ppal" alt="" @click="openLightbox(imagen_ppal_index)">
					</div>
				</div>
				<div class="ancho-45 flex flex-direction-column flex-content-start" style="height: 100%">
					<div class="titulo">
						<h1>{{ producto.producto }}</h1>
					</div>
					<div class="descripcion">
						<h1>{{ producto.descripcion }}</h1>
					</div>
					<div class="aracteristicas">
						<h1>{{ producto.descripcion }}</h1>
					</div>
				</div>
			</div>
			<div class="imagenes ancho-100">
				<div class="scrolling-wrapper scrollbar" id="style-2">
					<div v-for="(imagen, index) in producto.imagenes" class="card" style="border-radius: 10px; overflow: hidden;" @click="openLightbox(index)">
						<img style="object-fit: cover;" class="ancho-100" :src="'/storage/'+imagen.imagen" alt="">
					</div>
				</div>
			</div>
		</div>
		<!-- <vue-gallery-slideshow v-if="viewGaleria" :images="images" :index="index" @close="index = null"></vue-gallery-slideshow> -->
		<LightBox v-if="viewGaleria" ref="lightbox" :media="images" v-on:onClosed="closeLightBox()"></LightBox>
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
            	imagen_ppal_index:0
            }
        },
        mounted() {

        	self = this;
        	var img = [];
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
        	// this.$refs.lightbox.showThumbs = false;
        },
        methods: {
        	openLightbox (index) {
        		this.viewGaleria = true;
				self = this;
                setTimeout(function(){
					self.$refs.lightbox.showImage(index);
                    },
                100);

		    },
		    closeLightBox(){
		    	this.viewGaleria = true;
		    }
        },

    }
</script>
<style>
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

</style>