<template>
    <div class="ancho-100">
        <div class="ancho-100 flex" style="background: rgba(255,255,255,0.9); position: fixed; z-index: 1; top:0; left: 0; box-shadow: 0px 1px 1px 1px #eee;">
            <div class="ancho-100 flex flex-item-center flex-space-between" style="height: 55px; padding: 10px;">
                <div class="ancho-80 flex flex-item-center">
                    <img style="max-width: 60px; max-height: 40px; margin-left: 15px;" :src="'/storage/'+negocio.logo" :alt="negocio.nombre">
                    <span class="m-l-10" style="font-size: 1.2em;">{{ negocio.nombre }}</span>
                </div>
                <div class="flex flex-item-center ancho-s-">
                    <div class="no-display-s">
                        <span style="font-size: 1.2em;">Seguinos</span>
                    </div>
                    <div>
                       <layout-redes-sociales v-bind:negocio="negocio"></layout-redes-sociales>
                    </div>
                </div>
<!--                 <div class="ancho-30 ancho-m-20 ancho-l-15 ancho-lg-10  flex flex-item-center flex-space-between flex-content-end" style="margin-left: 15px; margin-right: 15px;">
                        <div class="p-l-10 m-l-5">
                            <a href="" @click.prevent="viewSelect(1)" title="Popurri">
                                <i class="fas fa-th txt-gris view_icon view_icon_1"></i>
                            </a>
                        </div>
                        <div class="p-l-10 m-l-5">
                            <a href=""  @click.prevent="viewSelect(2)" title="Álbumes">
                                <i class="fas fa-th-large txt-gris view_icon view_icon_2"></i>
                            </a>
                        </div>
                        <div class="p-l-10 p-r-10 m-l-5">
                            <a href="" @click.prevent="viewSelect(3)" title="Productos">
                                <i class="fas fa-th-list txt-gris view_icon view_icon_3"></i>
                            </a>
                        </div>
                </div> -->
            </div>
        </div>

<!--         <div class="ancho-100 flex flex-item-center flex-space-between">
            <div class="ancho-50 flex flex-item-center p-l-10">

            </div>
            <div class="ancho-50 flex flex-item-center flex-content-end p-r-10">

            </div>
        </div> -->
        <!-- <layout-grid-columnas v-if="view_activa == 1" v-bind:negocio="negocio"></layout-grid-columnas>
        <layout-grid-albumes v-if="view_activa == 2" v-bind:negocio="negocio"></layout-grid-albumes> -->

<!-- PARTE INFERIOR  -->
<!--         <div style="background: rgba(255,255,255,0.9); position: fixed; bottom: 0px; left: 0px; width: 100%; height: 50px; padding-bottom: 10px; z-index: 99;">
            <div class="flex flex-space-between ancho-100">
                <a href="" class="ancho-50 link">
                    <div class="ancho-100 flex flex-item-center flex-content-center flex-direction-column p-10">
                        <div class="flex flex-item-center flex-content-center">
                           <i class="fas fa-store"></i>
                        </div>
                        <div>
                            Nosotros
                        </div>
                    </div>
                </a>
                <a href="" class="ancho-50 link">
                    <div class="ancho-100 flex flex-item-center flex-content-center flex-direction-column p-10">
                        <div class="flex flex-item-center flex-content-center">
                            <i class="fab fa-weixin fz-20"></i>
                        </div>
                        <div>
                            Redes
                        </div>
                    </div>
                </a>
                <a href="" class="ancho-50 link">
                    <div class="ancho-100 flex flex-item-center flex-content-center flex-direction-column p-10">
                        <div class="flex flex-item-center flex-content-center">
                            <i class="fas fa-at"></i>
                        </div>
                        <div>
                            Contacto
                        </div>
                    </div>
                </a>
            </div>
        </div> -->
    </div>
</template>

<script>
    export default {
        props:['negocio'],
        data(){
            return {
                view_activa: 1,
            }
        },
        mounted() {
            this.viewSelect(this.view_activa);
        },
        methods: {
            viewSelect(view){
                $('.view_icon').removeClass('view_activa');
                $('.view_icon_'+view).addClass('view_activa');
                this.view_activa = view;
            }
        }
    }
</script>