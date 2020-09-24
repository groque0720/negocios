<template>
    <div class="ancho-100">
        <div class="ancho-95 flex margen-auto">
            <div v-for="(columnas, c) in nro_columnas" class="ancho-50" >
                <template>
                    <div v-for="(imagen, f) in imagenes_infinite"  v-if="boleanMostrar(c, f)" class="tarjeta borde-radio-5 m-10 sombra-box cursor" style="position: relative; margin-bottom: 15px;" @click.prevent="irProducto(imagen.producto_codigo, imagen.id)">
                        <!-- <div class="display-none imagen-titulo flex flex-item-center p-l-5 p-t-5">
                            <div class="flex flex-item-center p-r-10 p-l-10" style="height: 30px; background: white; border-radius: 30px;">
                                <span class="txt-negrita">{{ $root.truncarTexto(imagen.producto, 30) }}</span>
                            </div>
                        </div> -->
                        <div class="imagen flex ancho-100 ">
                           <!--  <img v-if="$root.esImagen(imagen.imagen)" loading="lazy" style="object-fit: cover; min-height: 150px;" class="ancho-100" :src="'/storage/'+imagen.imagen" alt=""> -->
                           <img v-if="$root.esImagen(imagen.imagen)" style="object-fit: cover; min-height: 150px;" class="ancho-100 lazyload" v-lazy="'/storage/'+imagen.imagen"  alt="">
                            <!-- <video v-if="$root.esVideo(imagen.imagen)" style="object-fit: cover; min-height: 150px;" class="ancho-100" loop muted autoplay>
                                <source :src="'/storage/'+imagen.imagen" type="video/mp4">
                            </video> -->
                            <LazyVideo v-if="$root.esVideo(imagen.imagen)" :src="'/storage/'+imagen.imagen"  style="object-fit: cover; min-height: 150px;" class="ancho-100" :attrs="{controls: false, playsinline: true, loop: true, autoplay: true, muted: true}"/>
                        </div>
                        <div class="p-5 p-l-10 ancho-100" style="overflow: hidden;">
                            <span class="txt-negrita" style="font-size: 1em;">{{ imagen.producto }}</span>
                        </div>
                        <!-- acciones en la parte inferior de la imagen cuanod pase el mouse -->
                        <!-- <div class="imagen-acciones ancho-100 display-none">
                            <div class="flex flex-item-center flex-content-end p-r-5 p-b-5">
                                <div class="flex flex-item-center flex-content-center"
                                     style="width: 30px; height: 30px; border-radius: 50%; background: white;">
                                     <a href="" title=""><i class="fas fa-ellipsis-h"></i></a>
                                </div>
                            </div>
                        </div> -->
                    </div>
                    <template v-if="c==1">
                        <infinite-loading  @infinite="InfiniteHandler">
                                <div slot="no-more"></div>
                                <!-- <div slot="spinner"></div> -->
                                <div slot="no-results"></div>
                        </infinite-loading>
                    </template>
                </template>
            </div>
        </div>
    </div>
</template>

<script>
    import VueLazyload from 'vue-lazyload'
    import VueLazyLoadVideo from 'vue-lazyload-video'
    Vue.use(VueLazyload)
    Vue.use(VueLazyLoadVideo)
    export default {
        props:['negocio'], //va a tener producto_id si viene del detalle de un producto, sino viene de la view principal
        data(){
            return {
                nro_columnas: 0,
                ancho: 0,
                page: 0,
                imagenes_infinite:[],
            }
        },
        mounted() {
            this.producto_id_view = this.producto_id != null ? this.producto_id : '';
            this.ancho = window.innerWidth;
            window.addEventListener('resize', this.handleResize);
            this.handleResize();
        },
        methods: {
            handleResize() {


                var ancho_usuario = window.innerWidth;

                if (ancho_usuario <= 480) {
                    this.nro_columnas = 2;
                }

                if (ancho_usuario > 480 && ancho_usuario <= 767) {
                    this.nro_columnas = 3;
                }

                if (ancho_usuario > 767 && ancho_usuario <= 979) {
                    this.nro_columnas = 4;
                }

                if (ancho_usuario > 979) {
                    this.nro_columnas = 5;
                }

                this.ancho = window.innerWidth;

            },
            InfiniteHandler($state){
                console.log(this.page);
                this.page++;
                let url = '/'+this.negocio.url+'/buscar_imagenes_random/?page=' + this.page;
                axios.get(url)
                .then( response => {
                    let imagenes = response.data.data;
                    if (imagenes.length) {
                        this.imagenes_infinite = this.imagenes_infinite.concat(imagenes);
                        // this.productos = this.productos_infinite;
                        $state.loaded();
                    }else{
                        $state.complete();
                    }
                });
            },
            boleanMostrar(c, f){
                var columna = c+1;
                var nro_imagen = f+1;

                var fila = Math.ceil( nro_imagen / this.nro_columnas)-1;
                var valor = nro_imagen - (fila * this.nro_columnas);

                if (columna == valor) {
                    return true;
                }else{
                    return false;
                }
            },
            irProducto(producto_codigo, id){
                //console.log(id);
                window.location = '/'+this.negocio.url+'/producto/'+producto_codigo+'/'+id;
            }
        }
    }
</script>
<style scoped>
    img {
       cursor: zoom-in;
    }
    .tarjeta  {
        transition: all .3s;
        filter: brightness(90%);
    }
    .tarjeta:hover {
        transform: scale(1.03);
        filter: brightness(100%);
    }
    .tarjeta:hover .imagen-titulo {
        display: block !important;
    }
/*    .tarjeta:hover img{
        transform: scale(1.1);
    }*/
    .tarjeta:hover .imagen-acciones {
        display: block !important;
    }
    .imagen-titulo {
        position: absolute;
        top: 0;
        left: 0;
/*        height: 40px;
        background: red;
        background: linear-gradient(to top, rgba(255,255,255,0), rgba(255,255,255,1));*/
        padding: 5px;
    }
    .imagen-acciones {
        position: absolute;
        bottom: 0;
        left: 0;
    }
    .lazyload{
        /*background-color:#E5E5E5 !important;*/
        background-image:url(/images/load/64x64.gif);
        background-repeat:no-repeat;
        background-position:center;
    }
</style>