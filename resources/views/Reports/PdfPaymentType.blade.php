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
		padding: 1px;
		}

		tr:nth-child(even) {background-color: #f2f2f2;}
	</style>
</head>
<body>

	{{-- <h2 align="center">Tipo de cobro</h2> --}}

	<table>
		<tr>
			<th>
				<img src="{{public_path() }}/img/vaca.jpg" height="100" style="margin: 0px; padding: 0px">
			</th>
			<th style="text-align: right;">
				<div style="font-weight: 400; font-size: 15px">CARNES DE COCLE</div>
				<div style="font-size: 14px">Reporte Tipo de cobro</div>
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
	       <th>POSICIÓN</th>
	       <th>MÉTODO DE PAGO</th>
	       <th>BANCO</th>
	       <th>NUMERO DE CUENTA</th>
		</tr>
	    @foreach($data as $filter)
		  	<tr>
				<td>{{ $filter['id'] }}</td>
				<td>{{ $filter['name'] }}</td>
				<td>{{ $filter['last_name'] }}</td>
				<td>{{ $filter['dni'] }}</td>
				<td>{{ $filter->occupation_data['department_type']['name'] }}</td>
				<td>{{ $filter->occupation_data['position']['name'] }}</td>
				<td>{{ $filter->occupation_data['payment_method']['name'] }}</td>
				<td>{{ $filter->occupation_data['bank']['name'] }}</td>
				<td>
				    @php
				    	$sizeof = strlen($filter->occupation_data['account_number']);
				    @endphp
				    @if($accountProtection == 1)
						@if (strcmp($filter->occupation_data['payment_method']['name'],'ACH') === 0)
						    @for ($i = 0; $i < $sizeof; $i++)
						    	{{ '*' }}
						    @endfor
						@else
							{{ $filter->occupation_data['account_number'] }}
						@endif
					@else
						{{ $filter->occupation_data['account_number'] }}
					@endif

				</td>
{{-- • Numero de cuenta * Si es ACH (Tener la opción de ocultar esta columna en PDF) --}}
		  	</tr>
		@endforeach
	</table>
</body>
</html>

