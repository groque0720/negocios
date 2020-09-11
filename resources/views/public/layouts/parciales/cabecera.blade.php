<div class="ancho-100 flex" style="border-bottom: 1px solid #ccc; position: fixed; background: white; z-index: 1;">
	<div class="menu-lateral menu-lateral-oculto" style="width: 250px; height: 100vh; position: fixed;">
		@include('layouts.parciales.menu-lateral')
	</div>
	<div class="ancho-100 flex flex-space-between" style="height: 65px; padding: 10px;">
		<div class="ancho-30 flex flex-item-center">
			<div class="p-l-10">
				<a href="" class="mostrar-menu-lateral">
					<i class="fas fa-bars fz-22 cursor txt-color-ppal"></i>
				</a>
			</div>
		</div>
		<div class="ancho-30 flex flex-item-center">
			<div class="margen-auto flex flex-item-center">
				<img style="max-width: 60px; max-height: 40px;" src="{{ Storage::url($negocio->logo) }}" alt="{{ $negocio->nombre }}">
				<span class="txt-italic m-l-10" style="font-size: 1.2em;">{{ $negocio->nombre }}</span>
			</div>
		</div>
		<div class="ancho-30 flex flex-item-center flex-content-end">
			<div class="p-r-10">
			</div>
		</div>
	</div>
</div>