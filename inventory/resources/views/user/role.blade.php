@extends('include.master')


@section('title','Inventario')


@section('page-title','Gestión de roles')


@section('content')


        <div class="row clearfix">
        	
        	<create-role></create-role>

        </div>


        <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                        </div>

                        <view-role></view-role>

                    </div>
                </div>
            </div>

@endsection

@push('script')

<script type="text/javascript" src="{{ url('public/js/role.js') }}"></script>

@endpush