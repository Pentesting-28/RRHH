<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta charset="utf-8">
	<title>RRHH-REPORTS</title>
	<style>
		* body {
			font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
		}
		table {
		border-collapse: collapse;
		width: 100%;
		font-size: 12px;
		}

		th, td {
		text-align: left;
		padding: 2px;
		}

		tr:nth-child(even) {background-color: #f2f2f2;}
	</style>
</head>
<body>

	{{-- <h2 align="center">Acreedores</h2> --}}

	<table>
		<tr>
			<th>
				<img src="{{public_path() }}/img/vaca.jpg" height="100" style="margin: 0px; padding: 0px">
			</th>
			<th style="text-align: right;">
				<div style="font-weight: 400; font-size: 15px">CARNES DE COCLE</div>
				<div style="font-size: 14px">Reporte Acreedores</div>
			</th>
			<hr>
		</tr>
	</table>

	<table>
		<tr>
		   <th>ID</th>
	       <th>NOMBRE</th>
	       <th>APELLIDO</th>
	       <th>CÉDULA</th>
	       <th>TIPO DE GASTO</th>
	       <th>ACREEDOR</th>
	       <th>CANTIDAD</th>
		</tr>
	    @foreach($data as $filter)
		  	<tr>
		  		{{-- AQUI PORQUE SE CAMBIO LA LOGICA EN CreditorsModule A LA INVERSA --}}
				{{-- <td>{{ $filter['id'] }}</td>
				<td>{{ $filter['name'] }}</td>
				<td>{{ $filter['last_name'] }}</td>
				<td>{{ $filter['dni'] }}</td>
				@foreach($filter->creditors_module as $type_expense )
 			    	<td>{{ $type_expense['type_expense']['name'] }}</td>
 			    	<td>{{ $type_expense['creditor']['name'] }}</td>
 			    	<td>{{ $type_expense['quantity'] }}</td>
 			    @endforeach --}}
 			    <td>{{ $filter->employee['id'] }}</td>
				<td>{{ $filter->employee['name'] }}</td>
				<td>{{ $filter->employee['last_name'] }}</td>
				<td>{{ $filter->employee['dni'] }}</td>
		    	<td>{{ $filter->type_expense['name'] }}</td>
		    	<td>{{ $filter->creditor['name'] }}</td>
		    	<td>{{ $filter['quantity'] }}</td>

		  	</tr>
		@endforeach
		
	</table>
</body>
</html>

