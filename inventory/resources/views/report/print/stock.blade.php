<!DOCTYPE html>
<html>
<head>
	<title>Reporte de Stock</title>
	<link href="{{ url('plugins/bootstrap/css/bootstrap.css') }}" rel="stylesheet">
	<link rel="icon" href="{{ url('../images/titulologo.png') }}" type="image/x-icon">
</head>
<body>
   <div class="container">
   	 <div class="row">
   	 	<table class="table table-bordered table-condensed">
			<thead>
				<tr>
					<td colspan="11" style="border: none !important;">
						<h3 style="text-align: center;">Urzúa & Partners</h3>
							<img src="../../../../images/tallerlogo.png" alt="Logo" style="width: 120px; max-height: 50px; margin-right: 10px; margin-top: -8%">
					</td>
				</tr>		
				<tr style="border: none !important;">
					<td colspan="11" style="border: none !important;"><p style="text-align: center;font-weight: bold;">Reporte de Existencias desde {{ date('j M Y',strtotime($start_date)) }} al {{ date('j M Y',strtotime($end_date)) }}</p></td>
				</tr>
				<tr>
					<!-- INFO A MOSTRAR EN EL PDF -->
					<!--<th>ID</th> -->
				</tr>
			</thead>
			<tbody>					
			</tbody>
		</table>
   	 </div>
   </div>
   <script type="text/javascript">
   	 window.print();
   </script>
</body>
</html>