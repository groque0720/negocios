<template>
    <div>
        <div>
            <div class="zona-busqueda flex ancho-100">
                <div class="ancho-10 flex flex-item-center flex-content-center" style="border: 1px solid #">
                    <a href=""><i class="fas fa-search txt-gris"></i></a>
                </div>
                <div class="ancho-80 flex flex-item-center flex-content-center">
                    <input class="input-busqueda" type="text" @focusout="mostrarBtnBorrar = false" @focus="mostrarBtnBorrar = true"  v-model="query" @input="evt=>buscarCaracteristicas(evt)">
                </div>
                <div class="ancho-10 flex flex-item-center flex-content-center">
                    <div v-if="mostrarBtnBorrar || query.length">
                        <a href="#" @click.prevent="borrarInputBuscar()">
                            <i class="fas fa-times txt-gris"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
<!--         <caracteristicas-autocompletar></caracteristicas-autocompletar> -->
        <a href="#" class="link zona-agregar flex" @click.prevent="clickNuevo()">
            <div class="ancho-100 zona-agregar-btn flex flex-space-between flex-item-center p-15" style="margin: 10px auto 10px auto; border: 1px solid #82C91E; border-radius: 10px; background: rgba(130, 201, 30, 0.2 )">
                <div class="ancho-10 flex flex-item-center flex-content-center">
                    <i class="fas fa-swatchbook" style="color: #82C91E;"></i>
                </div>
                <div class="ancho-90 flex flex-item-center flex-content-center">
                    <span>Agregar una nueva caracteristica</span>
                </div>
            </div>
        </a>
        <template v-if="mostrarFormulario">
            <div class="form-lienzo flex flex-item-start flex-content-center" >
                <form class="form ancho-80" autocomplete="off">
                    <div class="form-head p-10">
                        <div class="form-titulo">
                            {{ formulario.titulo }}
                        </div>
                    </div>
                    <div class="form-body">
                        <div class="form-linea">
                            <div class="form-columna">
                                <label for="email" class="form-label">Caracteristica</label>
                                <input class="form-input" ref="caracteristica_nombre" type="email" name="email" placeholder="" v-model="formulario.caracteristica" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-foot p-t-10">
                        <div class="form-linea flex flex-space-between flex-item-center" >
                            <div class="form-columna m-b-0">
                                <button class="btn form-btn-cancelar cursor p-l-20 p-r-20" @click.prevent="ocultarFormulario()">Cancelar</button>
                            </div>
                            <div class="form-columna m-b-0">
                                <button class="btn form-btn-entrar cursor p-l-20 p-r-20" @click.prevent="guardarFormulario()">Guardar</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </template>
        <div class="zona-lista ancho-100">
            <template >
                <div v-for="(caracteristica, indice) in caracteristicas" class="lista-linea ancho-100 flex flex-space-between" @click="mostrarAcciones(indice)">
                    <div class="ancho-70 flex flex-item-center">
                       <span>{{ caracteristica.caracteristica }}</span>
                    </div>
                    <div class="ancho-30 zona-acciones flex flex-space-between flex-item-center"  :class="'accion_'+indice" style="width: 0px; overflow: hidden;">
                        <div class="ancho-45 flex flex-content-center">
                            <a href="#" @click.prevent="clickEditar(caracteristica)">
                                <i class="fas fa-edit txt-celeste"></i>
                            </a>
                        </div>
                        <div class="ancho-45 flex flex-content-center">
                            <a href="#" @click.prevent="clickEliminar(caracteristica)">
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
                caracteristicas:[],
                caracteristicas_infinite:[],
                page:0,
                // ABM
                mostrarFormulario: false,
                accion:'',
                formulario: {
                    titulo: '',
                    caracteristica_id: '',
                    caracteristica: '',
                }
            }
        },
        mounted() {
            var self_caracteristicas = this
            $(window).on('popstate', function() {
                self_caracteristicas.mostrarFormulario = false;
            });
        },
        methods: {
            borrarInputBuscar(){
                this.query = '';
                self = this;
                setTimeout(function(){
                    self.caracteristicas = self.caracteristicas_infinite;
                    },
                100);
            },
            InfiniteHandler($state){
                this.page++;
                console.log(this.page)
                let url = '/caracteristicas/buscar?page=' + this.page;
                axios.get(url)
                .then( response => {
                    let caracteristicas = response.data.data;
                    if (caracteristicas.length) {
                        this.caracteristicas_infinite = this.caracteristicas.concat(caracteristicas);
                        this.caracteristicas = this.caracteristicas_infinite;
                        $state.loaded();
                    }else{
                        $state.complete();
                    }
                });
            },
            buscarCaracteristicas(evt) {
                this.query = evt.target.value;
                if(this.query.length >= 2){
                    axios.get('/caracteristicas/caracteristicas_buscar_autocompletar',{
                        params: {
                            query: this.query
                        }}).then(res => {
                        console.log(res.data);
                        this.caracteristicas = res.data;
                    });
                }else{
                    this.caracteristicas = this.caracteristicas_infinite;
                }
            },
            clickNuevo(){
                this.limpiarFormulario();
                history.pushState('', 'Caracteristica', '/caracteristicas');
                this.formulario.titulo = 'Agregar Caracteristica';
                this.mostrarFormulario = true;
                this.accion = 'A';
                self = this;
                setTimeout(function(){
                    self.$refs.caracteristica_nombre.focus();
                    },
                50);
            },
            clickEditar(caracteristica){
                this.formulario.titulo = 'Editar Caracteristica';
                this.formulario.caracteristica_id = caracteristica.id;
                this.formulario.caracteristica = caracteristica.caracteristica;
                this.mostrarFormulario = true;
                this.accion = 'M';
                self = this;
                setTimeout(function(){
                    self.$refs.caracteristica_nombre.focus();
                    },
                50);
            },
            clickEliminar(caracteristica){
                this.formulario.caracteristica_id = caracteristica.id;
                this.formulario.caracteristica = caracteristica.caracteristica;
                this.accion = 'B';
                Swal.fire({
                  title: 'Eliminar '+caracteristica.caracteristica+' ?',
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

                data.formulario = this.formulario;
                data.page = this.page;
                data.ultimacaracteristica = '';
                if (this.caracteristicas.length) {
                    data.ultimacaracteristica = this.caracteristicas[this.caracteristicas.length-1].caracteristica;
                }
                let url = 'caracteristicas/accion';
                axios.post(url, data)
                .then( response => {
                    console.log(response.data);
                    this.caracteristicas = response.data.caracteristicas;
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
                history.go(-1)
            },
            limpiarFormulario(){
                this.formulario.titulo = '';
                this.formulario.caracteristica = '';
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
        padding: 10px;
        border-bottom: 1px solid #ccc;
    }
    .lista-linea:first-child {
        border-top: 1px solid #ccc;
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
        z-index: 999;
    }
</style> -->