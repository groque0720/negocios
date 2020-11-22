<template>
    <div class="ancho-100">
        <div v-if="mostrarBusqueda">
            <div class="ancho-95 flex flex-item-center flex-content-center margen-auto p-5"  style="padding-top: 15px; padding-bottom: 15px;">
                <layout-busqueda-autocompletar :negocio="negocio" :query="query"></layout-busqueda-autocompletar>
            </div>
            <div class="ancho-95 flex flex-item-center flex-content-center margen-auto p-5 m-b-10" v-if="query.length">
                <span class="txt-italic">Resultado de Productos "<span class="txt-negrita">{{ query }}</span>"</span>
            </div>
        </div>
        <div class="ancho-95 flex margen-auto" v-if="query">
            <layout-grid-columnas-ordenado  v-bind:negocio="negocio" :query="query"></layout-grid-columnas-ordenado>
        </div>
        <div class="ancho-95 flex margen-auto m-b-10 m-t-10" v-if="query">
            <div class="ancho-100 flex flex-item-center flex-content-center ">
                <span class="fz-18 txt-negrita txt-mayuscula">Todos los albumes</span>
            </div>
        </div>
        <div class="ancho-95 flex margen-auto" v-if="query">
            <layout-grid-columnas-ordenado  v-bind:negocio="negocio" :query="query" v-bind:secundario="true"></layout-grid-columnas-ordenado>
        </div>
        <div class="ancho-95 flex margen-auto m-b-10 m-t-10" v-if="query">
            <div class="ancho-100 flex flex-item-center flex-content-center ">
                <span class="fz-18 txt-negrita txt-mayuscula">Otros</span>
            </div>
        </div>
        <div class="ancho-95 flex margen-auto">
            <div v-for="(columnas, c) in nro_columnas" class="ancho-50" >
                <template>
                    <div v-for="(imagen, f) in imagenes_infinite"  v-if="boleanMostrar(c, f)" class="tarjeta-grid-columnas borde-radio-5 m-10 sombra-box cursor" style="position: relative; margin-bottom: 15px; background: white;" @click.prevent="irProducto(imagen.producto_codigo, imagen.id)">
                        <div class="imagen flex ancho-100 ">
                           <img v-if="$root.esImagen(imagen.imagen)" style="object-fit: cover; min-height: 150px;" class="ancho-100 lazyload cursor-lupa" v-lazy="'/storage/'+imagen.imagen"  alt="">
                            <LazyVideo v-if="$root.esVideo(imagen.imagen)" :src="'/storage/'+imagen.imagen"  style="object-fit: cover; min-height: 150px;" class="ancho-100" :attrs="{controls: false, playsinline: true, loop: '2', autoplay: true, muted: true}"/>
                        </div>
                        <div class="p-5 p-l-10 ancho-100" style="overflow: hidden;">
                            <center><span class="txt-negrita" style="font-size: 1em;">{{ imagen.producto }}</span></center>
                        </div>
                    </div>
                    <template>
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
        props:['negocio','mostrarBusqueda','query'], //va a tener producto_id si viene del detalle de un producto, sino viene de la view principal
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
                // console.log(this.page);
                this.page++;

                var query = this.query
                // query.replace('%26','&');

                // console.log(query);
                // if (this.query == '') {
                    // let url = '/'+this.negocio.url+'/buscar_imagenes_random/?q='+encodeURIComponent(query)+'&page=' + this.page;
                    let url = '/'+this.negocio.url+'/buscar_imagenes_random/?page=' + this.page;
                // }else{
                //     let url = '/'+this.negocio.url+'/buscar_imagenes_random/?page=' + this.page;
                // }
                // let url = '/'+this.negocio.url+'/buscar_imagenes_random/?page=' + this.page;
                axios.get(url)
                .then( response => {
                    // console.log(response.data);
                    let imagenes = response.data.data;
                    // console.log(response.data.total);
                    if (imagenes.length) {
                        this.imagenes_infinite = this.imagenes_infinite.concat(imagenes);
                        this.productos = this.productos_infinite;
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
<!-- <style scoped>
    .tarjeta-grid-columnas  {
        transition: all .3s;
        filter: brightness(90%);
    }
    .tarjeta-grid-columnas:hover {
        transform: scale(1.03);
        filter: brightness(100%);
    }
    .tarjeta-grid-columnas:hover .imagen-titulo {
        display: block !important;
    }
/*    .tarjeta-grid-columnas:hover img{
        transform: scale(1.1);
    }*/
    .tarjeta-grid-columnas:hover .imagen-acciones-grid-columnas {
        display: block !important;
    }
    .tarjeta-grid-columnas .imagen-titulo {
        position: absolute;
        top: 0;
        left: 0;
/*        height: 40px;
        background: red;
        background: linear-gradient(to top, rgba(255,255,255,0), rgba(255,255,255,1));*/
        padding: 5px;
    }
    .imagen-acciones-grid-columnas {
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
</style> -->