<template>
    <div class="ancho-100">
        <layout-cabecera v-bind:negocio="negocio"></layout-cabecera>
<!--         <div class="ancho-100 flex flex-item-center flex-space-between flex-content-end">
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
        <layout-grid-columnas v-if="view_activa == 1" v-bind:negocio="negocio"></layout-grid-columnas>
        <layout-grid-albumes v-if="view_activa == 2" v-bind:negocio="negocio"></layout-grid-albumes>
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
<style scoped>
    .view_activa {
        color: #555 !important;
    }
</style>