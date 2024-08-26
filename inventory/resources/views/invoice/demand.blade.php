@extends('include.master')

@section('title','Inventario - Urzúa & Partners')

@section('page-title','Solicitudes de material')

@section('content')


<div class="row clearfix">

    <create-invoice :categorys="{{ $category }}"></create-invoice>

</div>

<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    <button id="solicitud_nueva" type="button" class="btn bg-teal" data-toggle="modal" data-target="#create-stock">
                        Nueva solicitud de material
                    </button>
                </h2>
            </div>

            <view-invoice :categorys="{{ $category }}"></view-invoice>

        </div>
    </div>
</div>

@endsection

@push('script')

<script type="text/javascript" src="{{ url('public/js/demand.js') }}"></script>
<script>
    // Verificar el valor del atributo "rol" en el localStorage
    if (localStorage.getItem('rol') === 'administrador') {
        // Ocultar el botón si el rol es "maestro"
        document.getElementById('solicitud_nueva').style.display = 'none';
    }else if (localStorage.getItem('rol') === 'encargado') {
        // Ocultar el botón si el rol es "maestro"
        document.getElementById('solicitud_nueva').style.display = 'none';
    }else if (localStorage.getItem('rol') === 'jefetaller') {
        // Ocultar el botón si el rol es "maestro"
        document.getElementById('solicitud_nueva').style.display = 'none';
    }
</script>

@endpush