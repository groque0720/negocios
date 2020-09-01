$('.mostrar-menu-lateral').click(function(e){
	e.preventDefault();
	$('.menu-lateral').removeClass('menu-lateral-ocultar');
	$('.menu-lateral-lienzo').removeClass('menu-lateral-lienzo-oculto');
	$('.menu-lateral').addClass('menu-lateral-mostrar');
});

$('.menu-lateral-ocultar, .menu-lateral-lienzo').click(function(e){
	e.preventDefault();
	$('.menu-lateral').addClass('menu-lateral-ocultar');
	$('.menu-lateral-lienzo').addClass('menu-lateral-lienzo-oculto');
	$('.menu-lateral').removeClass('menu-lateral-mostrar');
})
