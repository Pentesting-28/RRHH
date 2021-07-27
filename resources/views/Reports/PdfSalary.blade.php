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

	{{-- <h2 align="center">Salarios</h2> --}}

	<table>
		<tr>
			<th>
				<img src="{{public_path() }}/img/vaca.jpg" height="100" style="margin: 0px; padding: 0px">
			</th>
			<th style="text-align: right;">
				<div style="font-weight: 400; font-size: 15px">CARNES DE COCLE</div>
				<div style="font-size: 14px">Reporte Salarios</div>
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
	       <th>DEPARTAMENTO</th>
	       <th>POSICIONES</th>
	       <th>TIPOS DE SALARIOS</th>
	       <th>SALARIO</th>
		</tr>
	    @foreach($data as $filter)
		  	<tr>
				<td>{{ $filter['id'] }}</td>
				<td>{{ $filter['name'] }}</td>
				<td>{{ $filter['last_name'] }}</td>
				<td>{{ $filter['dni'] }}</td>
				<td>{{ $filter->occupation_data['department_type']['name'] }}</td>
				<td>{{ $filter->occupation_data['position']['name'] }}</td>
				@foreach($filter->salary as $salary)
					<td>{{ $salary['salary_type']['name'] }}</td>
					<td>{{ $salary['salary'] }}</td>
				@endforeach
		  	</tr>
		@endforeach
	</table>
</body>
</html>

