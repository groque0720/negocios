<template>
	<div v-if="view" style="height: 100vh; width: 100%; background: rgba(0,0,0,0.5); position: fixed; top: 0; left: 0; z-index: 1;">
		<div class="flex flex-content-center">
			<div class="ancho-sx-100 ancho-s-95 ancho-m-75 ancho-l-60 ancho-lg-50 p-10" style="background: white; margin-top: 20px; border-radius: 5px;">
				<form  class="form" action="">
					<div class="form-head" style="background: white;">
						<div class="flex flex-space-between">
							<div class="ancho-70 flex flex-item-center flex-space-between flex-content-start">
								<i class="fas fa-boxes m-r-10" style="color: #17A6EC;"></i>
								<span>Seleccionar Categorías</span>
							</div>
							<div class="flex flex-item-center flex-space-between p-10 borde-radio-3 cursor" @click="nuevacategoria()" style="border: 1px solid #ddd; width: 150px;">
                                <div class="ancho-30">
                                    <i class="fas fa-plus m-r-10 arrow-categorias" style="color:#17A6EC;"></i>
                                </div>
                                <div class="ancho-70 flex flex-content-center">
                                    <span>Agregar</span>
                                </div>
							</div>
						</div>
					</div>
					<div class="form-body" style="height: 70vh;">
                        <div class="ancho-100 flex flex-content-center">
                            <div class="zona-busqueda flex ancho-90 m-b-5">
                                <div class="ancho-10 flex flex-item-center flex-content-center" style="border: 1px solid #">
                                    <a href=""><i class="fas fa-search txt-gris"></i></a>
                                </div>
                                <div class="ancho-80 flex flex-item-center flex-content-center">
                                    <input class="input-busqueda" ref="input_busqueda" type="text" @focusout="mostrarBtnBorrar = false" @focus="mostrarBtnBorrar = true"  v-model="query" @input="evt=>filtrarCategorias(evt)">
                                </div>
                                <div class="ancho-10 flex flex-item-center flex-content-center">

                                </div>
                            </div>
                        </div>
						<template v-for="(categoria, index) in categorias_view">
							<div class="flex flex-item-center p-10" style="border-bottom: 1px solid #ddd; height: 40px;">
								<div class="ancho-80" @click="seleccionarItem(index)">
									<span :class="{ 'no-seleccionado': !categoria.seleccion }">{{ categoria.categoria }}</span>
								</div>
								<div class="ancho-20 flex flex-item-center flex-content-end">
									<label class="switch">
										<input type="checkbox" @click="" :checked="categoria.seleccion" v-model="categoria.seleccion">
										<span class="slider round"></span>
									</label>
								</div>
							</div>
						</template>
					</div>
				    <div class="form-foot p-t-10">
			            <div class="form-linea flex flex-space-between flex-item-center" >
			                <div class="form-columna m-b-0">
			                    <button class="btn form-btn-cancelar cursor p-l-20 p-r-20" @click.prevent="cancelar()">Cancelar</button>
			                </div>
			                <div class="form-columna m-b-0">
			                    <button class="btn form-btn-entrar cursor p-l-20 p-r-20" @click.prevent="guardar()">Aceptar</button>
			                </div>
			            </div>
		        	</div>
				</form>
			</div>
		</div>
		<template v-if="mostrarFormulario">
            <div class="form-lienzo flex flex-item-start flex-content-center" style="z-index: 1000; position: fixed; top: 0; width: 100%; height: 100vh; background: rgba(0,0,0,0.3);">
                <form class="form ancho-sx-100 ancho-s-90 ancho-m-70 ancho-l-55 ancho-lg-45" autocomplete="off" style="margin-top: 50px;">
                    <div class="form-head p-10">
                        <div class="form-titulo">
                            {{ formulario.titulo }}
                        </div>
                    </div>
                    <div class="form-body">
                        <div class="form-linea">
                            <div class="form-columna">
                                <input class="form-input" ref="categoria_nombre" type="email" name="email" placeholder="Ingrese Categoria" v-model="formulario.categoria" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-foot p-t-10">
                        <div class="form-linea flex flex-space-between flex-item-center" >
                            <div class="form-columna m-b-0">
                                <button class="btn form-btn-cancelar cursor p-l-20 p-r-20" @click.prevent="ocultarFormulario()">Cancelar</button>
                            </div>
                            <div class="form-columna m-b-0">
                                <button class="btn form-btn-entrar cursor p-l-20 p-r-20" @click.prevent="guardarNuevacategoria()">Guardar</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </template>
	</div>
</template>
<script>

    export default {
    	props:['categorias', 'producto'], //producto - categorias
        data(){
        	return {
        		view: false,
                query:'',
                mostrarBtnBorrar:false,
        		mostrarFormulario: false,
                categorias_view:[],
        		formulario:{
        			titulo:'Nueva Categoria',
                    producto_id:'',
        			categoria:'',
        		}
        	}
        },
        mounted() {
            var self_categorias = this;
            $(window).on('popstate', function() {
                self_categorias.view = false;
                // self.cancelar();
            });
        },
        methods:{
        	mostrar() {
                history.pushState('', 'Categorías', this.producto.codigo);
        		this.view = true;
                this.categorias_view = this.ordenarCategorias();
        		this.categorias_view.forEach(function(item, posicion){
                    // item.posicion = posicion;
                    if (item.seleccion_confirmacion) {
                        item.seleccion = true;
                    }else{
                        item.seleccion = false;
                    }
        		});
        	},
            ordenarCategorias(){
                return this.categorias.sort(function(a, b){
                          if ( (a.categoria).toLowerCase() > (b.categoria).toLowerCase() ) {
                            return 1;
                          }
                          if ( (a.categoria).toLowerCase()  < (b.categoria).toLowerCase() ) {
                            return -1;
                          }
                          // a must be equal to b
                          return 0;
                    });
            },
            ordenarCategoriasPosicion(){
                return this.categorias.sort(function(a, b){
                          if ( a.posicion > b.posicion ) {
                            return 1;
                          }
                          if ( a.posicion  < b.posicion ) {
                            return -1;
                          }
                          // a must be equal to b
                          return 0;
                    });
            },
            filtrarCategorias(evt = ''){
                var query = evt ? evt.target.value : '';
                var categorias_filtro = this.categorias.filter(function(registro){
                    // var categoria =
                    return registro.categoria.toLowerCase().includes(query.toLowerCase());
                });

                //var categorias_filtro = this.categorias.filter(categoria => categoria.categoria.length > 6);

                this.categorias_view = categorias_filtro;
                // console.log(categorias_filtro);
            },
            borrarInputBuscar(){
                this.query = '';
                this.filtrarCategorias();
                self = this;
                setTimeout(function(){
                    self.$refs.input_busqueda.focus();
                    },
                50);
            },
            seleccionarItem(i){
                this.categorias[i].seleccion = !this.categorias[i].seleccion;
            },
        	nuevacategoria(){
        		this.mostrarFormulario = true;
                this.formulario.categoria = '';
        		self = this;
                setTimeout(function(){
                    self.$refs.categoria_nombre.focus();
                    },
                50);
        	},
        	cancelar() {
        		this.categorias.forEach(function(item){
        			if (item.seleccion_confirmacion) {
        				item.seleccion = true;
        			}else{
        				item.seleccion = false;
        			}
        		});
                this.query='';
        		self = this;
                setTimeout(function(){
                    self.view = false;
                    history.go(-1)
                    },
                50);

        	},
        	guardar(){
        		this.categorias.forEach(function(item){
        			if (item.seleccion) {
        				item.seleccion_confirmacion = true;
        			}else{
        				item.seleccion_confirmacion = false;
        			}
        		});
                this.categorias_view = this.ordenarCategoriasPosicion();
                this.query = '';
        		this.view = false;
                history.go(-1);
        	},
            guardarNuevacategoria(){
                this.formulario.producto_codigo = this.producto.codigo;
                let url = '/producto/agregar_categorias';
                var data = {};
                data.formulario = this.formulario;
                axios.post(url, data)
                .then( response => {
                    var nueva_categoria = {
                        id: response.data.id,
                        categoria: response.data.categoria,
                        seleccion: false,
                        seleccion_confirmacion: false,
                        posicion: 99,
                    }
                    this.categorias.push(nueva_categoria);
                    this.categorias_view = this.ordenarCategorias();
                    this.query = '';
                    this.categorias.sort(function (a, b) {
                      if (a.posicion > b.posicion) {
                        return 1;
                      }
                      if (a.posicion < b.posicion) {
                        return -1;
                      }
                      // a must be equal to b
                      return 0;
                    });
                    this.ocultarFormulario();
                    Swal.fire({
                      position: 'top-end',
                      icon: 'success',
                      title: '',
                      showConfirmButton: false,
                      timer: 1000,
                      width: '180px',
                    })
                })
            },
            ocultarFormulario(){
                this.mostrarFormulario = false;
            }
        }
    }
</script>
