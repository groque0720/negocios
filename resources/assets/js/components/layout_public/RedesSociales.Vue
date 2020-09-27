<template>
	<div class="flex flex-item-center p-r-10">
		<div v-for="red in redes_sociales" class="m-l-10 ">
			<a :href="red.pivot.url" target="_blank" :title="red.red_social">
				<img style="width: 30px; height: 30px;" :src="/images/+red.icono" alt="">
			</a>
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
                	 console.log(response.data);
                });
        	}
        }
    }
</script>