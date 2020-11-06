<template>
    <div class="ancho-100">
        <layout-cabecera v-bind:negocio="negocio" :query="query"></layout-cabecera>
        <layout-grid-columnas v-if="view_activa == 1" :negocio="negocio"  :mostrarBusqueda="true" :query="query"></layout-grid-columnas>
        <layout-grid-columnas-ordenado v-if="view_activa == 2" v-bind:negocio="negocio"></layout-grid-columnas-ordenado>
        <!-- <layout-grid-albumes v-if="view_activa == 3" v-bind:negocio="negocio"></layout-grid-albumes> -->
    </div>
</template>

<script>
    export default {
        props:['negocio','query'],
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