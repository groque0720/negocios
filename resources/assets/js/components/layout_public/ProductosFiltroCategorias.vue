<template>
    <div class="ancho-100 p-t-10 p-b-10">
        <div class="flex flex-item-center flex-content-center m-b-10 m-t-10">
            <span class="fz-18 txt-negrita txt-mayuscula">Filtro Categoria <span class="fz-18 txt-celeste">#{{ categoria }}</span></span>
        </div>
        <div class="ancho-95 margen-auto flex flex-wrap flex-content-center" >
            <!-- :style="{'width':ancho_columna+'%'}"  -->
            <div v-for="imagen in imagenes_infinite" class="flex tarjeta-grid-columnas" :style="{'width':ancho_columna+'%'}" @click.prevent="irProducto(imagen.codigo, '')">
                <div class="ancho-100" style="padding: 5px;" >
                    <div class="ancho-100 flex flex-direction-column" style="padding: 5px; border: 1px solid #ccc; border-radius: 5px; height: 100%; background: white;">
                        <div class="ancho-100" style="height: 200px;">
                             <img v-if="$root.esImagen(imagen.imagen_ppal)" style="object-fit: cover; height: 100%;" class="ancho-100 lazyload cursor-lupa" v-lazy="'/storage/'+imagen.imagen_ppal"  alt="">
                             <LazyVideo v-if="$root.esVideo(imagen.imagen_ppal)" :src="'/storage/'+imagen.imagen_ppal"  style="object-fit: cover; height: 100%;" class="ancho-100" :attrs="{controls: false, playsinline: true, loop: '2', autoplay: true, muted: true}"/>
                        </div>
                        <div class="p-10 flex flex-space-between flex-direction-column" style="height: 100%">
                            <div class="">
                                <center><span class="txt-negrita" style="font-size: 1em;">{{ imagen.producto }}</span></center>
                            </div>
                            <div class="m-t-10">
                                <span class="" style="font-size: 0.9em;">{{ imagen.descripcion }}</span>
                            </div>
                            <div class="flex-item-end flex flex-content-end p-t-10 m-t-10" style="border-top: 1px solid #ccc;">
                                <span v-if="imagen.precio>0" class="txt-negrita" style="font-size: 0.9em;">
                                    <span class="m-r-10">$</span>{{ $root.formatoPrecio(imagen.precio) }} {{ imagen.precio_obs }} </span>
                                <span v-else class="txt-negrita">Consultar Precio</span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <infinite-loading  @infinite="InfiniteHandler">
                <div slot="no-more"></div>
                <!-- <div slot="spinner"></div> -->
                <div slot="no-results"></div>
        </infinite-loading>
    </div>
</template>

<script>
    import VueLazyload from 'vue-lazyload'
    import VueLazyLoadVideo from 'vue-lazyload-video'
    Vue.use(VueLazyload)
    Vue.use(VueLazyLoadVideo)
    export default {
        props:['negocio','categoria'], //va a tener producto_id si viene del detalle de un producto, sino viene de la view principal
        data(){
            return {
                nro_columnas: 0,
                ancho_columna: 0,
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
                    this.nro_columnas = 2;
                }

                if (ancho_usuario > 767 && ancho_usuario <= 979) {
                    this.nro_columnas = 4;
                }

                if (ancho_usuario > 979) {
                    this.nro_columnas = 5;
                }
                this.ancho = window.innerWidth;
                this.ancho_columna = Math.ceil( 100 / this.nro_columnas);
            },
            InfiniteHandler($state){
                // console.log(this.page);
                this.page++;
                let url = '/'+this.negocio.url+'/productos/categorias/filtro/'+this.categoria+'?page=' + this.page;
                axios.get(url)
                .then( response => {
                    let imagenes = response.data.data;
                    if (imagenes.length) {
                        this.imagenes_infinite = this.imagenes_infinite.concat(imagenes);
                        // console.log(this.imagenes_infinite);
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