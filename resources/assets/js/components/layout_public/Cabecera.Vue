<template>
    <div class="ancho-100">
        <div class="ancho-100 flex" style="background: rgba(255,255,255,0.9); position: fixed; z-index: 1; top:0; left: 0; box-shadow: 0px 1px 3px 1px #7BABFB;">
            <div class="ancho-100 flex flex-item-center flex-space-between" style="height: 55px; padding: 10px;">
                <div class="flex flex-item-center cursor" @click.prevent="irHomeNegocio()">
                    <img style="max-width: 60px; max-height: 40px; margin-left: 15px;" :src="'/storage/'+negocio.logo" :alt="negocio.nombre">
                    <span class="m-l-10" style="font-size: 1.2em;">{{ negocio.nombre }}</span>
                </div>
                <div class="flex flex-item-center flex-content-end">
                    <div class="flex flex-item-center">
                        <layout-redes-sociales v-bind:negocio="negocio"></layout-redes-sociales>
                    </div>
                    <div class="flex flex-item-center flex-content-center m-r-10 m-l-10" style="border-left: 1px solid #ccc; width: 50px;">
                        <a href="/acceder" title="login">
                              <i class="flex margen-auto fas fa-user txt-celeste"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props:['negocio'],
        data(){
            return {
            }
        },
        mounted() {
        },
        methods: {
            irHomeNegocio(){
                window.location = '/'+this.negocio.url;
            }
        }
    }
</script>