@extends('include.master')


@section('title','Inventario - Urzúa & Partners')


@section('page-title','Reporte de solicitudes')


@section('content')


<div class="row clearfix">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="card">
			<div class="header">
				<h2>
					
					Reporte de solicitudes
					
				</h2>

				<h2 class="pull-right">
					
					<a href="{{ url('print-report') }}?type={{ $type }}&start_date={{ $start_date }}&end_date={{ $end_date }}&category_id={{ $category_id }}&product_id={{ $product_id }}&stock_id={{ $stock_id }}&vendor_id={{ $vendor_id }}&user_id={{ $user_id }}" target="_blank" type="button" class="btn bg-teal btn-circle waves-effect waves-circle waves-float">
                        <i class="material-icons">download</i>
                    </a>
				</h2>
			</div>

			<div class="body">

				<div class="table-responsive">
					<table class="table table-bordered">
						<thead>
							<tr>
								<td colspan="11" style="border: none !important;">
									<h3 style="text-align: center;">Urzúa & Partners</h3>
									<img src="../../../images/tallerlogo.png" alt="Logo" style="width: 120px; max-height: 50px; margin-right: 10px; margin-top: -10%">
								</td>
							</tr>	

							<!-- <tr style="border: none !important;">
								<td colspan="8" style="border: none !important;">
									<p style="text-align: center;">{{ $company->address }} <br>
										 {{ $company->address2 }}</p></td>

							</tr> -->
							
							<!-- <tr style="border: none !important;">
								<td colspan="8" style="border: none !important;">
									<p style="text-align: center;">{{ $company->address2 }} <br>
										 {{ $company->phone }}</p></td>

							</tr>  -->

							<tr style="border: none !important;">
								<td colspan="8" style="border: none !important;"><p style="text-align: center;font-weight: bold;">Reporte de solicitudes desde: {{ date('j M Y',strtotime($start_date)) }} al {{ date('j M Y',strtotime($end_date)) }}</p></td>

							</tr>
						</thead>

						<tbody>
							<!-- INFO A MOSTRAR EN EL PDF -->
							 <!-- <th>ID</th> -->
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection