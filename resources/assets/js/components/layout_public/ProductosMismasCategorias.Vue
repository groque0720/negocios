<template>
    <div class="">
        <div v-if="productos.length > 0" class="m-10 flex flex-item-center flex-content-center">
            <span class="fz-18 txt-negrita txt-mayuscula">Similares</span>
        </div>

        <div class="ancho-95 margen-auto  flex productos-similares producto-scrollbar" id="style-2" style="overflow: auto;">
            <div class="ancho-100 flex p-5" style="flex-wrap: nowrap;">
                <div v-for="(producto, filas) in productos"  class="cursor-lupa m-b-10" style="width: 156px; margin-right: 10px; border: 3px solid white; border-radius: 10px; background: white; box-shadow: 0 0 1px 1px #bbb;" @click.prevent="irProducto(producto.codigo, '')">
                        <div class="flex" style="width: 150px; height: 150px; border-radius: 10px 10px 0 0; overflow: hidden;">
                            <img style="object-fit: cover;" class="ancho-100" :src="'/storage/'+producto.imagen_ppal" alt="">
                        </div>
                        <div class="p-5 p-l-10 ancho-100" style="overflow: hidden;">
                            <span class="txt-negrita" style="font-size: 1em;">{{ $root.truncarTexto(producto.producto,28) }}</span>
                        </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props:['negocio', 'producto','categorias'],
        data(){
            return {
                productos:[],
                nro_columnas: 0,
                ancho: 0,
            }
        },
        mounted() {
            // console.log(this.categorias);
            this.buscarProductosCategorias();
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
            },
            buscarProductosCategorias(){
                let url = '/'+this.negocio.url+'/productos/mismas_categorias/';
                axios.get(url, {
                        params: {
                            negocio_id: this.negocio.id,
                            producto_id : this.producto.id,
                            categorias: this.categorias
                        }})
                .then( response => {
                    console.log( response.data );
                    this.productos = response.data;
                });
            },
            irProducto(producto_codigo, id){
                //console.log(id);
                window.location = '/'+this.negocio.url+'/producto/'+producto_codigo+'/'+id;
            }
        }
    }
</script>
<!-- <style scoped>
    .producto-misma-categoria-tarjeta  {
        transition: all .3s;
        filter: brightness(90%);
    }
    .producto-misma-categoria-tarjeta:hover {
        transform: scale(1.03);
        filter: brightness(100%);
    }
</style> -->