<template>
    <div class="productos-productos">
        <div>
            <div class="zona-busqueda flex ancho-100">
                <div class="ancho-10 flex flex-item-center flex-content-center" style="border: 1px solid #">
                    <a href=""><i class="fas fa-search txt-gris"></i></a>
                </div>
                <div class="ancho-80 flex flex-item-center flex-content-center">
                    <input class="input-busqueda" ref="input_busqueda" type="text" @focusout="mostrarBtnBorrar = false" @focus="mostrarBtnBorrar = true"  v-model="query" @input="evt=>buscarProductos(evt)">

                </div>
                <div class="ancho-10 flex flex-item-center flex-content-center">
                    <div v-if="mostrarBtnBorrar || query.length">
                        <i class="fas fa-times txt-gris" @click.prevent="borrarInputBuscar()"></i>
                    </div>
                </div>
            </div>
        </div>
<!--         <productos-autocompletar></productos-autocompletar> -->
        <a :href="'/productos/create/'+tipo_id" class="link zona-agregar flex">
            <!-- titulo -->
            <div v-if="tipo_id == 1"class="ancho-100 zona-agregar-btn flex flex-space-between flex-item-center p-15" style="margin: 10px auto 10px auto; border: 1px solid #00E185; border-radius: 10px; background: #E2F9F0;">
                <div class="ancho-10 flex flex-item-center flex-content-center">
                    <i class="fas fa-tags" style="color:#00E185;"></i>
                </div>
                <div class="ancho-90 flex flex-item-center flex-content-center">
                    <span>Agregar un nuevo Producto</span>
                </div>
            </div>
            <div v-if="tipo_id == 2"class="ancho-100 zona-agregar-btn flex flex-space-between flex-item-center p-15" style="margin: 10px auto 10px auto; border: 1px solid #9361A9; border-radius: 10px; background: rgb(147, 97, 169, 0.1);">
                <div class="ancho-10 flex flex-item-center flex-content-center">
                    <i class="far fa-images" style="color:#9361A9;"></i>
                </div>
                <div class="ancho-90 flex flex-item-center flex-content-center">
                    <span>Agregar un nuevo Álbum</span>
                </div>
            </div>
        </a>
        <div class="zona-lista ancho-100" style="margin-bottom: 60px;">
            <template >
                <div v-for="(producto, indice) in productos" class="lista-linea ancho-100 flex flex-space-between" @click="mostrarAcciones(indice)" :class="'linea_'+indice">
                    <div class="ancho-100 flex flex-item-center">
                        <div class="ancho-30 m-r-10 flex cursor" style="width: 60px; height: 60px; overflow: hidden; border-radius: 2px; box-shadow: 1px 1px #ddd;" @click.prevent="irAlProducto(producto.codigo)">

                            <img v-if="$root.esImagen(producto.imagen_ppal)" style="object-fit: cover;" :src="'/storage/'+producto.imagen_ppal" alt="" width="100%" >
                            <video v-if="$root.esVideo(producto.imagen_ppal)" style="object-fit: cover; max-height: 350px;" class="ancho-100" autoplay muted loop>
                                <source :src="'/storage/'+producto.imagen_ppal" type="video/mp4">
                            </video>

                        </div>
                        <div class="ancho-100 flex flex-space-between flex-direction-column" style="height: 100%;">
                            <div >
                                <span style="font-weight: bold;">{{ producto.producto }}</span>
                            </div>
                            <div>
                                <span style="color:#7C7979; font-size: 12px;">{{ $root.truncarTexto(producto.descripcion, 50) }}</span>
                            </div>
                            <div  class="flex flex-content-end">
                            <!-- muestro el precio solo si es de tipo producto (valor 1) -->
                                <!-- <span v-if="producto.tipo_id == 1" class="fz-12">${{ $root.formatoPrecio(producto.precio)  }}</span> -->
                                <span class="fz-12"><span class="m-r-5">$</span>{{ $root.formatoPrecio(producto.precio)  }} {{ producto.precio_obs }}</span>
                            </div>
                            <!-- Muestro la fecha de creacion del album (valor 2) -->
                            <div v-if="producto.tipo_id == 2">
                                <span  class="fz-12">{{ $root.diffForHumans(producto.created_at) }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="ancho-30 zona-acciones flex flex-space-between flex-item-center"  :class="'accion_'+indice" style="width: 0px; overflow: hidden;">
                        <div class="ancho-45 flex flex-content-center">
                            <!-- <a :href="'/producto/edit/'+producto.id" @click.prevent="clickEditar(producto)"> -->
                            <a :href="'/'+negocio.url+'/producto/'+producto.codigo" target="_blank" title="Ver en la web">
                                <i class="fas fa-binoculars" style="color: #ACD358"></i>
                            </a>
                        </div>
                        <div class="ancho-45 flex flex-content-center">
                            <!-- <a :href="'/producto/edit/'+producto.id" @click.prevent="clickEditar(producto)"> -->
                            <a href="#" @click.prevent="irAlProducto(producto.codigo)" title="Editar">
                                <i class="fas fa-edit txt-celeste"></i>
                            </a>
                        </div>
                        <div class="ancho-45 flex flex-content-center">
                            <a href="#" @click.prevent="clickEliminar(producto, indice)" title="Eliminar">
                                <i class="fas fa-trash-alt txt-rojo-claro"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <infinite-loading @infinite="InfiniteHandler">
                    <div slot="no-more"></div>
                    <div slot="spinner">Cargando...</div>
                    <div slot="no-results">Click en agregar</div>
                </infinite-loading>
            </template>
        </div>
    </div>
</template>

<script>
    export default {
        props:['tipo_id', 'negocio'],
        data(){
            return {
                // busqueda
                mostrarBtnBorrar:false,
                query:'',
                // lista
                mostrarInfinite: true,
                productos:[],
                productos_infinite:[],
                page:0,
                // ABM
                mostrarFormulario: false,
                accion:'',
                formulario: {
                    titulo: '',
                    producto_id: '',
                    producto: '',
                }
            }
        },
        mounted() {
        },
        methods: {
            borrarInputBuscar(){
                this.query = '';
                self = this;
                setTimeout(function(){
                    self.productos = self.productos_infinite;
                    self.$refs.input_busqueda.focus();
                    },
                100);
            },
            // irAlProductoWeb(codigo){
            //     window.location.href = this.negocio.url+'/producto/'+codigo;
            // },
            irAlProducto(codigo){
                location.href = '/productos/edit/'+codigo;
            },
            InfiniteHandler($state){
                this.page++;
                // console.log(this.page)
                let url = '/productos/'+this.tipo_id+'/buscar?page=' + this.page;
                axios.get(url)
                .then( response => {
                    let productos = response.data.data;
                    if (productos.length) {
                        this.productos_infinite = this.productos.concat(productos);
                        this.productos = this.productos_infinite;
                        $state.loaded();
                    }else{
                        $state.complete();
                    }
                });
            },
            buscarProductos(evt) {
                this.query = evt.target.value;
                if(this.query.length >= 2){
                    axios.get('/productos/productos_buscar_autocompletar',{
                        params: {
                            query: this.query,
                            tipo_id: this.tipo_id,
                        }}).then(res => {
                        this.productos = res.data;
                     });
                }else{
                    this.productos = this.productos_infinite;
                }
            },
            clickNuevo(){
                this.formulario.titulo = 'Agregar Categoría';
                this.mostrarFormulario = true;
                this.accion = 'A';
                self = this;
                setTimeout(function(){
                    self.$refs.producto_nombre.focus();
                    },
                50);
            },
            clickEditar(producto){
                this.formulario.titulo = 'Editar Categoría';
                this.formulario.producto_id = producto.id;
                this.formulario.producto = producto.producto;
                this.mostrarFormulario = true;
                this.accion = 'M';
                self = this;
                setTimeout(function(){
                    self.$refs.producto_nombre.focus();
                    },
                50);
            },
            clickEliminar(producto, indice){
                self = this;
                this.formulario.producto_id = producto.id;
                this.formulario.producto = producto.producto;
                this.accion = 'B';
                Swal.fire({
                  title: 'Eliminar '+producto.producto+' ?',
                  text: '',
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  cancelButtonText: 'Cancelar',
                  confirmButtonText: 'Eliminar'
                }).then((result) => {
                  if (result.value) {
                    let url = "/productos/"+producto.id+"/eliminar";
                    axios.get(url)
                    .then( response => {
                        self.mostarMensaje(response.data, 'Eliminado');
                        self.productos.splice(indice,1);
                    });
                  }
                })
            },
            guardarFormulario(){
                var data = {};
                data.accion = this.accion;
                data.formulario = this.formulario;
                data.page = this.page;
                data.ultimaproducto = '';
                if (this.productos.length) {
                    data.ultimaproducto = this.productos[this.productos.length-1].producto;
                }
                let url = 'productos/accion';
                axios.post(url, data)
                .then( response => {
                    // console.log(response.data);
                    this.productos = response.data.productos;
                    this.ocultarFormulario();
                    this.mostarMensaje(response.data.msg);
                        // Swal.fire(
                        //   'Good job!',
                        //   'You clicked the button!',
                        //   'success'
                        // )
                });

            },
            ocultarFormulario(){
                this.limpiarFormulario();
                this.mostrarFormulario = false;
            },
            limpiarFormulario(){
                this.formulario.titulo = '';
                this.formulario.producto = '';
                this.query = '';
            },
            mostrarAcciones(indice){
                $('.lista-linea').removeClass('lista-linea-activa');
                $('.linea_'+indice).addClass('lista-linea-activa');
                $('.zona-acciones').width(0);
                setTimeout(function(){
                    $('.accion_'+indice).width('200px');
                    },
                50);
            },
            mostarMensaje($estado, msg = ''){
                if ($estado == 'ok') {
                    Swal.fire({
                      position: 'top-end',
                      icon: 'success',
                      // title: msg,
                      text: msg,
                      showConfirmButton: false,
                      timer: 200,
                      width: '180px',
                    })
                }
                if ($estado == 'error') {
                    Swal.fire({
                      position: 'top-end',
                      icon: 'error',
                      text: msg,
                      showConfirmButton: false,
                      timer: 200,
                      width: '180px',
                    })
                }
            }
        }
    }
</script>
<!-- <style scoped>
    .zona-busqueda {
        border: 1px solid #ccc;
        border-radius: 35px;
        height: 40px;
        padding-left: 7px;
        padding-right: 7px;
    }
    .zona-busqueda:focus-within {
        border: 1px solid var(--main-ppal-color);
    }
    .input-busqueda {
        width: 100%;
        padding: 10px;
        box-sizing: border-box;
        border: 0px;
    }
    .input-busqueda:focus {
        outline:none !important;
        outline-width: 0 !important;
        box-shadow: none;
        -moz-box-shadow: none;
        -webkit-box-shadow: none;
    }
    .lista-linea {
        padding: 5px;
        border-bottom: 1px solid #ccc;
    }
    .lista-linea:first-child {
        border-top: 1px solid #ccc;
    }
    .lista-linea-activa {
        background: #ECECEC;
    }
    .zona-agregar:hover .zona-agregar-btn{
        background: var(--main-ppal-color);
    }
    .zona-agregar:hover span, .zona-agregar:hover i{
        color:  var(--main-ppal-color);
    }
    .zona-acciones{
        transition: 0.3s;
    }
    .form-lienzo{
        height: 100vh;
        width: 100%;
        background: rgba(0,0,0,0.2);
        position: fixed;
        left: 0;
        top: 0;
        padding-top: 40px;
    }
</style> -->