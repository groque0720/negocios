<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="/favicon.png"/>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Registro</title>

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
		<div class="ancho-90 ancho-m-50 ancho-l-40 ancho-lg-35" style="margin-top: 15px;">
			<form class="form" action="{{ route('register') }}" method="POST" autocomplete="off">
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
{{--                 <div class="form-head">
                    <div class="ancho-100 flex flex-item-center flex-space-between">
                        <div class="form-titulo ancho-100 fz-20">
                            Registro
                        </div>
                    </div>
                </div> --}}
				<div class="form-body">
                    <div class="form-linea">
                        <div class="form-columna">
                            <label for="name_negocio" class="form-label obligatorio">Nombre de Tú Negocio</label>
                            <input class="form-input" type="text" name="nombre" value="{{ old('nombre') }}" placeholder="" required>
                            {!!  $errors->first('nombre', '<span class=form-error>:message</span>') !!}
                        </div>
                    </div>
                    <div class="form-linea">
                        <div class="form-columna">
                            <label for="name" class="form-label obligatorio">Tú Nombre</label>
                            <input class="form-input" type="text" name="name" value="{{ old('name') }}" placeholder="" required>
                            {!!  $errors->first('name', '<span class=form-error>:message</span>') !!}
                        </div>
                    </div>
					<div class="form-linea">
						<div class="form-columna">
							<label for="mail" class="form-label obligatorio">Tú Email</label>
							<input class="form-input" type="email" name="email" value="{{ old('email') }}" placeholder="" required>
                            {!!  $errors->first('email', '<span class=form-error>:message</span>') !!}
						</div>
					</div>
					<div class="form-linea">
						<div class="form-columna">
							<label for="password" class="form-label obligatorio">Contraseña</label>
                            <div class="flex flex-space-between">
                                <div class="ancho-90">
                                    <input class="form-input" type="password" name="password" id="password" placeholder="" required data-id="password" autocomplete="off">
                                </div>
                                <div class="ancho-10 flex flex-item-center">
                                    <i class="fas fa-eye margen-auto cursor ver_contraseña" data-id="password" style="color: var(--main-ppal-color);" ></i>
                                    <i class="far fa-eye-slash margen-auto cursor ocultar_contraseña ocultar" data-id="password" style="color: var(--main-ppal-color);" ></i>
                                </div>
                            </div>
						</div>
					</div>
                    <div class="form-linea">
                        <div class="form-columna">
                            <label for="password" class="form-label obligatorio">Confirmar Contraseña</label>
                            <div class="flex flex-space-between">
                                <div class="ancho-90">
                                    <input class="form-input" type="password" name="password_confirmation" id="password_confirmation" placeholder="" data-id="password_confirmation" required autocomplete="off">
                                </div>
                                <div class="ancho-10 flex flex-item-center">
                                    <i class="fas fa-eye margen-auto cursor ver_contraseña_confirmacion" data-id="password_confirmation" style="color: var(--main-ppal-color);" ></i>
                                    <i class="far fa-eye-slash margen-auto cursor ocultar_contraseña_confirmacion ocultar" data-id="password_confirmation" style="color: var(--main-ppal-color);" ></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <validador ref="validador" :mostrar_validador="false"></validador>

    			</div>
				<div class="form-foot">
					<div class="form-linea flex flex-space-between flex-item-center">
						<div class="form-columna m-b-0">
                            <span class="obligatorio txt-color-ppal txt-italic" style="font-size: 12px !important;">Campo Obligatorio</span>
                        </div>
						<div class="form-columna m-b-0">
							<button class="btn form-btn-entrar cursor p-l-20 p-r-20"
                             onclick="event.preventDefault(); app.__vue__.$refs.validador.mostrar()">
                                Aceptar</button>
						</div>
					</div>
				</div>
			</form>
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
            $(".ver_contraseña_confirmacion").click(function(){
                $("#"+$(this).attr('data-id')).attr('type','text');
                $(this).addClass('ocultar');
                $(".ocultar_contraseña_confirmacion").removeClass('ocultar');
            });
            $(".ocultar_contraseña_confirmacion").click(function(){
                $("#"+$(this).attr('data-id')).attr('type','password');
                $(this).addClass('ocultar');
                $(".ver_contraseña_confirmacion").removeClass('ocultar');
            });
    </script>


    @if (session('error'))
        <script>
            Swal.fire(
              'Error en la Validación de Seguridad',
              'Por favor ordene correctamente los símbolos / letras',
              'error'
            )
        </script>
    @endif

    @if ($errors->has('nombre'))
        <script>
            Swal.fire(
              'Error de Autentificación',
              '{{ $errors->first('nombre') }}',
              'error'
            )
        </script>
    @endif
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