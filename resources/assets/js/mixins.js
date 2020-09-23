// var myMixin = {
// 	data(){
// 		return {
// 			cumpa: 'Elias',
// 		}
// 	},
//   methods: {
//     saludo(){
//       console.log('Hola '+this.cumpa+' !');
//     },
//   }
// }

export default {
	data(){
		return {
		}
	},
	mounted(){

	},
  	methods: {
		formatoPrecio(value) {
			//value = value.replace(/^0+/, '');
	        let val = (value/1).toFixed(2).replace('.', ',')
	        return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
	    },
	    truncarTexto(text, max)
		{
		    if (text != null) {
		    	text = String(text);
		    	return text.substr(0,max-1)+(text.length>max?' ...':'');
		    }else{
		    	return '';
		    }
		},
	    esVideo(filename){
            var videos_ext = ['mp4'];
            return videos_ext.includes(this.get_extension(filename));
        },
        esImagen(filename){
            var imagenes_ext = ['jpg', 'jpeg','gif','png'];
            return imagenes_ext.includes(this.get_extension(filename));
        },
        get_extension(filename) {
            return filename.slice((filename.lastIndexOf('.') - 1 >>> 0) + 2);
        },
		diffForHumans(time) {
		    var date = new Date((time || "").replace(/-/g, "/").replace(/[TZ]/g, " ")),
		        diff = (((new Date()).getTime() - date.getTime()) / 1000),
		        day_diff = Math.floor(diff / 86400);

		    if (isNaN(day_diff) || day_diff < 0 ) return;

		    if (day_diff >= 31)  return  ' ' + Math.ceil(day_diff/7) + ' semanas';

		    return day_diff == 0 &&
		    (diff < 60 && "justo ahora" || diff < 120 && " 1 minuto" || diff < 3600 && ' '+Math.floor(diff / 60)  + " minutos" || diff < 7200 && "  1 hora" || diff < 86400 && ' '+Math.floor(diff / 3600) + " horas") ||
		    (day_diff == 1 && "ayer" || day_diff < 7 && ' '+day_diff + " días" || day_diff < 31 && ' '+Math.ceil(day_diff / 7) + " semanas");
		},
		mostarMensaje($estado, titulo ='', subtitulo=''){
                if ($estado == 'ok') {
                    Swal.fire({
                      position: 'top-end',
                      icon: 'success',
                      title: titulo,
                      text: subtitulo,
                      showConfirmButton: false,
                      timer: 1000,
                      width: '180px',
                    })
                }
                if ($estado == 'error') {
                    Swal.fire({
                      position: 'top-end',
                      icon: 'error',
                      title: titulo,
                      text: subtitulo,
                      showConfirmButton: false,
                      timer: 1000,
                      width: '180px',
                    })
                }
            }
  	}
}