<template>
	<div class="flex flex-item-center p-r-10">

        <div class="flex flex-item-center" v-if="redes_sociales.length>0">
            <div class="no-display-s">
                <span style="font-size: 1.2em;">Seguinos</span>
            </div>
            <div class="flex">
        		<div v-for="red in redes_sociales" class="m-l-15">
                    <template v-if="red.id != 5">
                        <a :href="red.pivot.url" target="_blank" :title="red.red_social" class="flex flex-item-center">
                            <img style="width: 30px; height: 30px;" :src="/images/+red.icono" alt="">
                        </a>
                    </template>
                    <template v-if="red.id == 5">
                        <a :href="'https://wa.me/'+negocio.celular+'?text=Visite%20https://'+negocio.url+'.vidriera.online%20y%20quisiera%20consultarte%20por:%20%20'" target="_blank" :title="red.red_social" class="flex flex-item-center">
                            <img style="width: 30px; height: 30px;" :src="/images/+red.icono" alt="">
                        </a>
                    </template>
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
            	redes_sociales:[],
            }
        },
        mounted() {
        	// console.log(this.negocio.url);
        	this.buscar_redes(this.negocio.url);
        },
        methods: {
        	buscar_redes(url_negocio){
        		var url = '/'+url_negocio+'/redes_sociales';
				axios.get(url)
                .then(response => {
                	this.redes_sociales = response.data;
                	 // console.log(response.data);
                });
        	}
        }
    }
</script>