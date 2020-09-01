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
		<div class="ancho-30 flex">
			<div class="margen-auto">
				<img style="width: 45px;" src="/logo.png" alt="">
			</div>
		</div>
		<div class="ancho-30 flex flex-item-center flex-content-end">
			<div class="p-r-10">
				<a href="#" onclick="event.preventDefault();
                             document.getElementById('logout-form').submit();">
					<i class="fas fa-sign-out-alt cursor txt-color-ppal" style=""></i>
				</a>
				<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
			</div>
		</div>
	</div>
</div>