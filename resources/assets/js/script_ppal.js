require('./parciales/menu');

$(document).ready(function(){ //Hacia arriba
  irArriba();
});

function irArriba(){
  $('.ir-arriba').click(function(){ $('body,html').animate({ scrollTop:'0px' },1000); });
  $(window).scroll(function(){
    if($(this).scrollTop() > 0){ $('.ir-arriba').slideDown(600); }else{ $('.ir-arriba').slideUp(600); }
  });
  $('.ir-abajo').click(function(){ $('body,html').animate({ scrollTop:'1000px' },1000); });
}

	// este script da formato al ingresar un numero a los formularios - Ejemplo: 12.365,56
$(".numero").on({
	    "focus": function (event) {
	        $(event.target).select();
	    },
	    "keyup": function (event) {
	        $(event.target).val(function (index, value ) {
	            return value.replace(/\D/g, "")
	                        .replace(/([0-9])([0-9]{2})$/, '$1,$2')
	                        .replace(/\B(?=(\d{3})+(?!\d)\.?)/g, ".");
	        });
	    }
	});

function formatoPrecio(value) {
	// //value = value.replace(/^0+/, '');
 //    let val = (value/1).toFixed(2).replace('.', ',')
 //    return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")

 	alert('hola');
}