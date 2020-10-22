<template>
    <div class="ancho-100" style="margin-bottom: 15px;">
        <div class="ancho-100 flex p-10 ">
            <div v-for="(columnas, c) in nro_columnas" class="ancho-100 ">
                <template>
                    <div v-for="(album, f) in albumes_infinite"  v-if="boleanMostrar(c, f)" class="tarjeta borde-radio-5 m-10 sombra-box cursor" style="position: relative;">

                        <div class="ancho-100 flex flex-item-center flex-space-between" style="height: 200px;">
                            <div class="ancho-50 imagen flex" style="height: 200px; overflow: hidden;">
                                <img style="object-fit: cover;" class="ancho-100" :src="'/storage/'+album.imagen_ppal" alt="">
                            </div>
                            <div class="ancho-50 flex flex-direction-column flex-space-between p-10" style="height: 100%;">
                                <div class="ancho-100 flex flex-item-center" style="min-height: 15px;" >
                                    <span class="txt-negrita">{{ album.producto}}</span>
                                </div>
                                <div class="ancho-100 flex p-r-10 m-b-5" style="height: 85px; overflow: hidden;">
                                    <center><span>{{ $root.truncarTexto(album.descripcion, 110) }}</span></center>
                                </div>
                                <div class="flex flex-no-wrap" id="style-1" style="overflow: hidden;">
                                    <div v-if="i<=2" v-for="(imagen, i) in album.imagenes" class="flex m-r-10" style="flex: 0 0 auto; width: 55px; height: 55px; overflow: hidden; border-radius: 2px; padding-bottom: 5px;">
                                        <img style="object-fit: cover; width: 100%;"  :src="'/storage/'+imagen.imagen" alt="">
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- <div class="display-none imagen-titulo flex flex-item-center p-l-5 p-t-5">
                            <div class="flex flex-item-center p-r-10 p-l-10" style="height: 30px; background: white; border-radius: 30px;">

                            </div>
                        </div>
                        <div class="imagen flex">
                            <img style="object-fit: cover;" class="ancho-100" :src="'/storage/'+album.imagen_ppal" alt="">
                        </div> -->
                    </div>
                    <infinite-loading @infinite="InfiniteHandler">
                        <div slot="no-more"></div>
                        <div slot="spinner"></div>
                        <div slot="no-results"></div>
                    </infinite-loading>
                </template>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props:['negocio'],
        data(){
            return {
                nro_columnas: 0,
                ancho: 0,
                page: 0,
                albumes_infinite:[],
            }
        },
        mounted() {
            this.ancho = window.innerWidth;
            window.addEventListener('resize', this.handleResize);
            this.handleResize();
        },
        methods: {
            handleResize() {

                var ancho_usuario = window.innerWidth;

                // if (ancho_usuario <= 480) {
                //     this.nro_columnas = 2;
                // }

                // if (ancho_usuario > 480 && ancho_usuario <= 767) {
                if (ancho_usuario <= 767) {
                    this.nro_columnas = 1;
                }

                if (ancho_usuario > 767 && ancho_usuario <= 979) {
                    this.nro_columnas = 2;
                }

                if (ancho_usuario > 979) {
                    this.nro_columnas = 3;
                }

                this.ancho = window.innerWidth;

            },
            InfiniteHandler($state){
                this.page++;
                let url = '/'+this.negocio.url+'/buscar_albumes?page=' + this.page;
                axios.get(url)
                .then( response => {
                    let imagenes = response.data.data;
                    if (imagenes.length) {
                        this.albumes_infinite = this.albumes_infinite.concat(imagenes);
                        // console.log(this.albumes_infinite);
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
            }
        }
    }
</script>
<style scoped>
    img {
       cursor: zoom-in;
    }
    .tarjeta  {
        transition: all .2s;
        filter: brightness(100%);
    }
    .tarjeta:hover {
        transform: scale(1.01);
        filter: brightness(90%);
    }
    .tarjeta:hover .imagen-titulo {
        display: block !important;
    }
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
    .scrollbar {
        height: 100%;
        padding: 0px !important;
    }
</style>