@extends('include.master')

@section('title','Inventario - Urzúa & Partners')

@section('page-title','Lista de productos')

@section('content')

<div class="row clearfix">
    <create-product :categorys="{{ json_encode($category) }}" :units="{{ json_encode($unit) }}"></create-product>
</div>

<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    <button type="button" class="btn bg-teal" data-toggle="modal" data-target="#create-product">
                        Producto nuevo
                    </button>
                </h2>
            </div>

            <view-product :categorys="{{ json_encode($category) }}" :units="{{ json_encode($unit) }}"></view-product>

        </div>
    </div>
</div>

@endsection

@push('script')

<script type="text/javascript" src="{{ url('public/js/product.js') }}"></script>

@endpush