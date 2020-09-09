<template>
    <div class="">
        <div class="ancho-100 flex p-10 ">
            <div v-for="(columnas, c) in nro_columnas" class="columna-1 ancho-50 ">
                <div v-for="(producto, f) in productos"  v-if="boleanMostrar(c, f)" class="tarjeta borde-radio-5 m-10 sombra-box">
                    <div class="imagen">
                        <img class="ancho-100 flex" :src="'/storage/'+producto.imagen_ppal" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props:['productos', 'negocio'],
        data(){
            return {
                nro_columnas: 0,
                ancho: 0,
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