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

	{{-- <h2 align="center">Cédulas</h2> --}}

	<table>
		<tr>
			<th>
				<img src="{{public_path() }}/img/vaca.jpg" height="100" style="margin: 0px; padding: 0px">
			</th>
			<th style="text-align: right;">
				<div style="font-weight: 400; font-size: 15px">CARNES DE COCLE</div>
				<div style="font-size: 14px">Reporte Cédulas</div>
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
	       <th>FECHA DE VENCIMIENTO</th>
	       {{-- <th>EDAD</th> --}}
		</tr>
	    @foreach($data as $filter)
	  	<tr>
			<td>{{ $filter['id'] }}</td>
			<td>{{ $filter['name'] }}</td>
			<td>{{ $filter['last_name'] }}</td>
			<td>{{ $filter->dnis['number'] }}</td>
			<td>{{ $filter->dnis['expiration'] }}</td>
			{{-- <td>{{ $filter['age'] }}</td> --}}
	  	</tr>
		@endforeach
	</table>
</body>
</html>

