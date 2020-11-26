<div style="overflow-y: auto; background: white;">
	<div class="menu-lateral-lienzo menu-lateral-lienzo-oculto ancho-100 screen-vh position-fixed"
		 style="position: fixed; background: rgba(250,250,250,0.85); z-index: -1">
		<div class="flex flex-item-center flex-content-center"
			 style="margin-left: 250px; height: 50px; width: 50px;">
			<div>
				<a href="#" class="menu-lateral-ocultar"><i class="fas fa-times txt-color-ppal"></i></a></div>
		</div>
	</div>
	<div class="ancho-100" style="height: 100vh; border-right: 1px solid #ccc; background: #fff;">
		<a href="{{ route('negocio.editar') }}" class="link item-menu-lateral">
			<div class="flex flex-space-between flex-item-center"
				 style="height: 55px; border-bottom: 1px solid #ccc;">
				<div class="ancho-20 flex flex-item-center flex-content-center">
					<i class="fas fa-store" style="color: #00D0D0; "></i></div>
				<div class="ancho-80">
					<span class="txt-color-ppal">Datos del Negocio</span></div>
			</div>
		</a>
		<a href="{{ route('redes_sociales.index') }}" class="link item-menu-lateral">
			<div class="flex flex-space-between flex-item-center"
				 style="height: 55px; border-bottom: 1px solid #ccc;">
				<div class="ancho-20 flex flex-item-center flex-content-center">
					<i class="fas fa-users"style="color: #5F66ED; "></i></div>
				<div class="ancho-80">
					<span class="txt-color-ppal">Redes Sociales</span></div>
			</div>
		</a>
		<a href="{{ route('productos.index') }}" class="link item-menu-lateral">
			<div class="flex flex-space-between flex-item-center"
				 style="height: 55px; border-bottom: 1px solid #ccc;">
				<div class="ancho-20 flex flex-item-center flex-content-center">
					<i class="fas fa-tags" style="color:#00E185;"></i>
				</div>
				<div class="ancho-80">
					<span class="txt-color-ppal">Productos</span>
				</div>
			</div>
		</a>
		<a href="{{ route('productos.albumes') }}" class="link item-menu-lateral">
			<div class="flex flex-space-between flex-item-center"
				 style="height: 55px; border-bottom: 1px solid #ccc;">
				<div class="ancho-20 flex flex-item-center flex-content-center">
					<i class="far fa-image" style="color:#9361A9;"></i>
				</div>
				<div class="ancho-80">
					<span class="txt-color-ppal">Álbumes</span>
				</div>
			</div>
		</a>
		<a href="{{ route('url_negocio.index', $negocio->url) }}" class="link item-menu-lateral" target="_blank">
			<div class="flex flex-space-between flex-item-center"
				 style="height: 55px; border-bottom: 1px solid #ccc;">
				<div class="ancho-20 flex flex-item-center flex-content-center">
					<i class="fas fa-binoculars" style="color: #ACD358"></i></div>
				<div class="ancho-80">
					<span class="txt-color-ppal">Ver mi página principal</span></div>
			</div>
		</a>
		<a href="{{ route('lista_precio.index') }}" class="link item-menu-lateral">
			<div class="flex flex-space-between flex-item-center"
				 style="height: 55px; border-bottom: 1px solid #ccc;">
				<div class="ancho-20 flex flex-item-center flex-content-center">
					<i class="fas fa-donate" style="color:#FFAC1E;"></i></div>
				<div class="ancho-80">
					<span class="txt-color-ppal">Lista de Precios</span></div>
			</div>
		</a>
		<a href="{{ route('caracteristicas.index') }}" class="link item-menu-lateral">
			<div class="flex flex-space-between flex-item-center"
				 style="height: 55px; border-bottom: 1px solid #ccc;">
				<div class="ancho-20 flex flex-item-center flex-content-center">
					<i class="fas fa-swatchbook" style="color: #82C91E;"></i>
				</div>
				<div class="ancho-80">
					<span class="txt-color-ppal">Características</span></div>
			</div>
		</a>
		<a href="{{ route('categorias.index') }}" class="link item-menu-lateral">
			<div class="flex flex-space-between flex-item-center"
				 style="height: 55px; border-bottom: 1px solid #ccc;">
				<div class="ancho-20 flex flex-item-center flex-content-center">
					<i class="fas fa-boxes" style="color: #17A6EC;"></i></div>
				<div class="ancho-80">
					<span class="txt-color-ppal">Categorias</span></div>
			</div>
		</a>
	</div>
</div>

@section('estilos')
	<style scoped>
		.item-menu-lateral:hover div{
			background: var(--main-ppal-color);
		}
		.item-menu-lateral:hover span  {
			color: white;
		}
		.item-menu-lateral:hover i  {
			color: white;
		}
	</style>
@endsection
