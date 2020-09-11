<template>
    <div class="ancho-100">
        <div class="ancho-100 flex p-10 ">
            <div v-for="(columnas, c) in nro_columnas" class="columna-1 ancho-50 ">
                <template>
                    <div v-for="(imagen, f) in imagenes_infinite"  v-if="boleanMostrar(c, f)" class="tarjeta borde-radio-5 m-10 sombra-box">
                        <div class="imagen">
                            <img style="object-fit: cover;" class="ancho-100 flex" :src="'/storage/'+imagen.imagen" alt="">
                        </div>
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
                imagenes_infinite:[],
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
                let url = '/'+this.negocio.url+'/buscar_imagenes_random?page=' + this.page;
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
            }
        }
    }
</script>