@extends('include.master')

@section('title','Inventario - Urzúa & Partners')

@section('page-title','Solicitudes de material')

@section('content')


<div class="row clearfix">

    <create-invoice :categorys="{{ $category }}" :customers="{{ $customer }}"></create-invoice>

</div>


<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
            
                <h2 style="visibility: hidden;">
                    <button type="button" class="btn bg-teal" data-toggle="modal" data-target="#create-stock">
                        Nueva solicitud de de material
                    </button>
                </h2>
            </div>

            <view-invoice :categorys="{{ $category }}" :customers="{{ $customer }}"></view-invoice>

        </div>
    </div>
</div>




@endsection

@push('script')

<script type="text/javascript" src="{{ url('public/js/invoice.js') }}"></script>

@endpush