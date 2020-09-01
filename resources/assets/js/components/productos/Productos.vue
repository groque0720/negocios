<template>
    <div>
        <div>
            <div class="zona-busqueda flex ancho-100">
                <div class="ancho-10 flex flex-item-center flex-content-center" style="border: 1px solid #">
                    <a href=""><i class="fas fa-search txt-gris"></i></a>
                </div>
                <div class="ancho-80 flex flex-item-center flex-content-center">
                    <input class="input-busqueda" type="text" @focusout="mostrarBtnBorrar = false" @focus="mostrarBtnBorrar = true"  v-model="query" @input="evt=>buscarProductos(evt)">

                </div>
                <div class="ancho-10 flex flex-item-center flex-content-center">
                    <div v-if="mostrarBtnBorrar || query.length">
                        <i class="fas fa-times txt-gris" @click.prevent="borrarInputBuscar()"></i>
                    </div>
                </div>
            </div>
        </div>
<!--         <productos-autocompletar></productos-autocompletar> -->
        <a :href="'/productos/create'" class="link zona-agregar flex">
            <div class="ancho-100 zona-agregar-btn flex flex-space-between flex-item-center p-15" style="margin: 10px auto 10px auto; border: 1px solid #ccc; border-radius: 10px;">
                <div class="ancho-10 flex flex-item-center flex-content-center">
                    <i class="fas fa-tags" style="color:#00E185;"></i>
                </div>
                <div class="ancho-90 flex flex-item-center flex-content-center">
                    <span>Agregar un nuevo producto</span>
                </div>
            </div>
        </a>
        <div class="zona-lista ancho-100">
            <template >
                <div v-for="(producto, indice) in productos" class="lista-linea ancho-100 flex flex-space-between" @click="mostrarAcciones(indice)" :class="'linea_'+indice">
                    <div class="ancho-100 flex flex-item-center">
                        <div class="ancho-30 m-r-10" style="width: 80px; max-height: 80px;">
                            <!-- <img src="https://scontent.faep1-1.fna.fbcdn.net/v/t1.0-9/116743484_3215521671849756_1224515636589086667_n.jpg?_nc_cat=105&_nc_sid=110474&_nc_ohc=UTnGxVEE_KQAX9Z5pGH&_nc_ht=scontent.faep1-1.fna&oh=d796e13736c762d0f0a229d7247b4328&oe=5F4F5704" alt="" width="100%"> -->
                            <!-- {{ producto.imagen_ppal }} -->
                            <img :src="'/storage/'+producto.imagen_ppal" alt="" width="100%" >
                        </div>
                        <div class="ancho-70">
                            <span>{{ producto.producto }}</span>
                        </div>
                    </div>
                    <div class="ancho-30 zona-acciones flex flex-space-between flex-item-center"  :class="'accion_'+indice" style="width: 0px; overflow: hidden;">
                        <div class="ancho-45 flex flex-content-center">
                            <!-- <a :href="'/producto/edit/'+producto.id" @click.prevent="clickEditar(producto)"> -->
                            <a :href="'/productos/edit/'+producto.codigo">
                                <i class="fas fa-edit txt-celeste"></i>
                            </a>
                        </div>
                        <div class="ancho-45 flex flex-content-center">
                            <a href="#" @click.prevent="clickEliminar(producto)">
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
                    },
                100);
            },
            InfiniteHandler($state){
                this.page++;
                console.log(this.page)
                let url = '/productos/buscar?page=' + this.page;
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
                            query: this.query
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
            clickEliminar(producto){
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
                    this.guardarFormulario()
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
                    console.log(response.data);
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
                    $('.accion_'+indice).width('30%');
                    },
                50);
            },
            mostarMensaje($estado){
                if ($estado == 'ok') {
                    Swal.fire({
                      position: 'top-end',
                      icon: 'success',
                      title: '',
                      showConfirmButton: false,
                      timer: 1000,
                      width: '180px',
                    })
                }
                if ($estado == 'error') {
                    Swal.fire({
                      position: 'top-end',
                      icon: 'error',
                      title: '',
                      showConfirmButton: false,
                      timer: 1000,
                      width: '180px',
                    })
                }
            }
        }
    }
</script>
<style scoped>
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
        padding: 10px;
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
        color: white;
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
</style>