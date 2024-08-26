@extends('include.master')


@section('title','Inventario - Urzúa & Partners')


@section('page-title','Lista de Existencias')


@section('content')


<div class="row clearfix">

    <create-stock :date="{{ json_encode(date('Y-m-d')) }}" :vendors="{{ $vendor }}" :categorys="{{ $category }}"></create-stock>

</div>


<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    <button id="existencia_nueva" type="button" class="btn bg-teal" data-toggle="modal" data-target="#create-stock">
                        Agregar entrada
                    </button>
                </h2>
            </div>

            <view-stock :vendors="{{ $vendor }}" :categorys="{{ $category }}" :products="{{ $product }}"></view-stock>

        </div>
    </div>
</div>


@endsection

@push('script')

<script type="text/javascript" src="{{ url('public/js/stock.js') }}"></script>
<script>
    // Verificar el valor del atributo "rol" en el localStorage
    if (localStorage.getItem('rol') === 'maestro') {
        // Ocultar el botón si el rol es "maestro"
        document.getElementById('existencia_nueva').style.display = 'none';
    }

    localStorage.removeItem('orders');
</script>

@endpush