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
		padding: 8px;
		}

		tr:nth-child(even) {background-color: #f2f2f2;}
	</style>
</head>
<body>

	{{-- <h2 align="center">Licencias de Conducir</h2> --}}

	<table>
		<tr>
			<th>
				<img src="{{public_path() }}/img/vaca.jpg" height="100" style="margin: 0px; padding: 0px">
			</th>
			<th style="text-align: right;">
				<div style="font-weight: 400; font-size: 15px">CARNES DE COCLE</div>
				<div style="font-size: 14px">Reporte Licencias de Conducir</div>
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
	       <th>VENCIMIENTO</th>
	       <th>LETRA</th>
		</tr>
	    @foreach($data as $filter)
		  	<tr>
				<td>{{ $filter->employee['id'] }}</td>
				<td>{{ $filter->employee['name'] }}</td>
				<td>{{ $filter->employee['last_name'] }}</td>
				<td>{{ $filter->employee['dni'] }}</td>
				<td>{{ $filter['expiration'] }}</td>
				{{-- AQUI PORQUE SE CAMBIO LA LOGICA EN LICENCIA A LA INVERSA --}}
{{-- 			    @foreach($filter->license as $children)
					<td>{{ $children['expiration'] }}</td> --}}
					@foreach($filter->type_license as $type_license)
						<td>{{ $type_license['name'] }}</td>
					@endforeach
				{{-- @endforeach --}}
		  	</tr>
		@endforeach
	</table>
</body>
</html>

