<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="/favicon.png"/>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Login'))</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">

</head>
<body>
	<div class="ancho-100 flex flex-content-center" id="app">
		<video class="video_fondo" src="{{ Storage::url('login/video05.mp4') }}" autoplay loop muted></video>
        <div style="min-height: 100%;
            min-width: 100%; background: var(--main-ppal-color);opacity: .5; position: fixed; z-index: -1;">
        </div>
		<div class="ancho-90 ancho-m-50 ancho-l-40 ancho-lg-35" style="margin-top: 50px;">
			<form class="form" action="{{ route('acceder') }}" method="POST">
				{{ csrf_field() }}
				<div class="form-head">
					<div class="ancho-100 flex flex-item-center flex-space-between">
						<div class="form-titulo ancho-35 fz-20">
							Tu Negocio
						</div>
						<div class="ancho-30 flex flex-content-center flex-item-center">
							<img style="width: 50px;" src="/logo.png" alt="">
						</div>
						<div class="form-titulo ancho-35 fz-20">
							En Internet
						</div>
					</div>
				</div>
				<div class="form-body">
					<div class="form-linea">
						<div class="form-columna">
							<label for="email" class="form-label">Email</label>
							<input class="form-input" type="email" name="email" placeholder="" required>
						</div>
					</div>
					<div class="form-linea">
						<div class="form-columna">
							<label for="password" class="form-label">Contraseña</label>
                            <div class="flex flex-space-between">
                                <div class="ancho-90">
                                    <input class="form-input" type="password" name="password" id="password" placeholder="" required>
                                </div>
                                <div class="ancho-10 flex flex-item-center">
                                    <i class="fas fa-eye margen-auto cursor fz-18 ver_contraseña" data-id="password" style="color: var(--main-ppal-color);" ></i>
                                    <i class="far fa-eye-slash margen-auto cursor fz-18 ocultar_contraseña ocultar" data-id="password" style="color: var(--main-ppal-color);" ></i>
                                </div>
                            </div>
						</div>
					</div>
				</div>
				<div class="form-foot">
					<div class="form-linea flex flex-space-between flex-item-center">
						<div class="form-columna m-b-0">
                          <a href="{{ route('password.request') }}" class="link fz-12 txt-italic txt-rojo" style="color: var(--main-ppal-color">olvidé mi contraseña</a>
                        </div>
						<div class="form-columna m-b-0">
							<button class="btn form-btn-entrar cursor p-l-20 p-r-20">Entrar</button>
						</div>
					</div>
				</div>
			</form>
			    <a href="{{ route('register') }}" class="link link_registrar margen-auto">
                    <div class="ancho-90 ancho-m-80 ancho-l-70 ancho-lg-60 margen-auto flex flex-space-between p-10" style="margin-top: 30px;">
                         <div class="ancho-30">
                            <img src="{{ Storage::url('login/registrar_mi_negocio.svg')  }}" alt="" class="ancho-100">
                        </div>
                        <div class="ancho-70 flex flex-item-center flex-content-center">
                            <span class="txt-blanco">Quiero registrar mi negocio</span>
                        </div>
                    </div>
                </a>
		</div>
	</div>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
            $(".ver_contraseña").click(function(){
                $("#"+$(this).attr('data-id')).attr('type','text');
                $(this).addClass('ocultar');
                $(".ocultar_contraseña").removeClass('ocultar');
            });
            $(".ocultar_contraseña").click(function(){
                $("#"+$(this).attr('data-id')).attr('type','password');
                $(this).addClass('ocultar');
                $(".ver_contraseña").removeClass('ocultar');
            });
    </script>
	@if ($errors->has('email'))
        <script>
            Swal.fire(
              'Error de Autentificación',
              '{{ $errors->first('email') }}',
              'error'
            )
        </script>
    @endif
    @if ($errors->has('passwords'))
        <script>
            Swal.fire(
              'Error de Autentificación',
              '{{ $errors->first('password') }}',
              'error'
            )
        </script>
    @endif
    <style>
        .link_registrar:hover>div{
            background: var(--main-ppal-color);
            border-radius: 7px;
            border: 1px solid white;
            opacity: .7;
        }
        .ocultar {
            display: none;
        }
    </style>
</body>
</html>