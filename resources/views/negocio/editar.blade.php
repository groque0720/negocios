@extends('layouts.app')

@section('title', $negocio->nombre)

@section('contenido')
    <div class="margen-auto ancho-100">
        <form class="form" action="{{ route('negocio.guardar') }}" method="POST" autocomplete="off" enctype="multipart/form-data">
            <input name="_method" type="hidden" value="PUT">
            {{ csrf_field() }}
            <div class="form-head p-10">
                <div class="form-titulo flex">
                    <div class="ancho-100 txt-centrar">
                        <i class="fas fa-store" style="color: #fff; margin-right: 10px;"></i>
                        <span class="txt-blanco">Datos del Negocio</span>
                    </div>
                </div>
            </div>
            <div class="form-body">
                <div class="form-linea">
                    <div class="form-columna">
                        <label for="name_negocio" class="form-label">Nombre</label>
                        <input class="form-input" type="text" name="nombre" value="{{ $negocio->nombre }}" placeholder="" disabled>
                    </div>
                </div>
                <div class="form-linea">
                    <div class="form-columna">
                        <label for="name_negocio" class="form-label">Email</label>
                        <input class="form-input" type="email" name="email" value="{{ $negocio->email or old('email') }}" placeholder="">
                        {!!  $errors->first('email', '<span class=form-error>:message</span>') !!}
                    </div>
                </div>
                <div class="form-linea">
                    <div class="form-columna">
                        <label for="name_negocio" class="form-label">Teléfono</label>
                        <input class="form-input" type="text" name="telefono" value="{{ $negocio->telefono or old('telefono') }}" placeholder="">
                        {!!  $errors->first('telefono', '<span class=form-error>:message</span>') !!}
                    </div>
                </div>
                <div class="form-linea">
                    <div class="form-columna">
                        <label for="name_negocio" class="form-label">Celular</label>
                        <input class="form-input" type="text" name="celular" value="{{ $negocio->celular or old('celular') }}" placeholder="">
                        {!!  $errors->first('celular', '<span class=form-error>:message</span>') !!}
                    </div>
                </div>
                <div class="form-linea">
                    <div class="form-columna">
                        <label for="name_negocio" class="form-label">Dirección</label>
                        <input class="form-input" type="text" name="direccion" value="{{ $negocio->direccion or old('direccion') }}" placeholder="">
                        {!!  $errors->first('direccion', '<span class=form-error>:message</span>') !!}
                    </div>
                </div>
                <div class="form-linea">
                    <div class="form-columna flex flex-space-between flex-item-center p-5" style="height: 60px;">
                        <div class="ancho-50">
                            <label for="name_negocio" class="form-label txt-centrar">Logo</label>
                            <p id="texto" class="txt-italic">Click o Arrastrar para cambiar la imagen</p>
                        </div>
                        <div class="ancho-50" >
                            <div id="div_file" class="flex flex-item-center flex-content-center">
                                <img id='output' class="m-0" width="65px" height="65px;" style="border-radius: 50%;" src="{{ Storage::url($negocio->logo) }}" alt="">
                                {{-- <input type="file" > --}}
                                <input type='file' name="logo" id="file" accept='image/*' onchange='openFile(event)' title=" " value="{{ $negocio->logo }}">
                                {!!  $errors->first('logo', '<span class=form-error>:message</span>') !!}
                             </div>
                        </div>
                    </div>
                </div>
{{--                 <div class="form-linea">
                    <div class="form-columna">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1290.6086659510704!2d-59.16404169946042!3d-37.34724673035331!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMzfCsDIwJzUwLjEiUyA1OcKwMDknNDguMiJX!5e1!3m2!1ses!2sar!4v1599430208427!5m2!1ses!2sar" width="600" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
                    </div>
                </div> --}}
            </div>
            <div class="form-foot p-t-10">
                <div class="form-linea flex flex-space-between flex-item-center">
                    <div class="form-columna m-b-0">
                        <button class="btn form-btn-cancelar cursor p-l-20 p-r-20">Cancelar</button>
                    </div>
                    <div class="form-columna m-b-0">
                        <button class="btn form-btn-entrar cursor p-l-20 p-r-20">Guardar</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('estilos')
<style>
    iframe {
        width: 100% !important;
    }
    p#texto{
        text-align: center;
        /*color:white;*/
        cursor: pointer;
        font-size: 12px !important;
        color: var(--main-ppal-color);
    }
    div#div_file{
        position:relative;
        cursor: pointer;
        /*margin:50px;*/
        padding:5px;
        /*width:150px;*/
/*        background-color: #2499e3;
        -webkit-border-radius:5px;
        -webkit-box-shadow:0px 3px 0px #1a71a9;*/
    }

    input#file{
        border:1px solid black;
        cursor: pointer;
        position:absolute;
        top:0px;
        left:0px;
        right:0px;
        bottom:0px;
        width:100%;
        height:100%;
        opacity: 0;
    }
</style>
@endsection

@section('script')
<script>
  var openFile = function(event) {
    var input = event.target;

    var reader = new FileReader();
    reader.onload = function(){
      var dataURL = reader.result;
      var output = document.getElementById('output');
      output.src = dataURL;
    };
     reader.readAsDataURL(input.files[0]);
  };

</script>
@stop