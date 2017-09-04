@extends('layouts.dashboard')

@section('title', 'Sucursales')

@section('header-top')
	<!--dataTable.css-->
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css">
	<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.3.1/css/buttons.dataTables.min.css">
@endsection

@section('header-bottom')
	<script src="//cdn.datatables.net/1.10.15/js/jquery.dataTables.js"></script>
	<script src="{{ asset('js/sucursales.js') }}"></script>
	<!-- <script src="https://cdn.datatables.net/v/dt/jszip-2.5.0/pdfmake-0.1.18/dt-1.10.12/b-1.2.2/b-colvis-1.2.2/b-html5-1.2.2/b-print-1.2.2/cr-1.3.2/r-2.1.0/datatables.min.js"></script> -->
@endsection

@section('content')
<div class="col s12 xl8 offset-xl2">
	<p class="right-align">
		<a href="{{ companyRoute('create') }}" class="waves-effect waves-light btn orange">Nuevo</a>
		<a href="{{ companyRoute('index') }}" class="waves-effect waves-light btn"><i class="material-icons">cached</i></a>
	</p>
</div>
@if (session('success'))
<div class="col s12 xl8 offset-xl2">
	<div class="alert alert-success">
		{{ session('success') }}
	</div>
</div>
@endif
<div class="col s12 xl8 offset-xl2">
	<table class="striped responsive-table highlight">
		<thead>
			<tr>
				<th>Sucursal</th>
				<th>Localidad</th>
				<th>Tipo de Sucursal</th>
				<th>Supervisor</th>
				<th>Activo</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
		@foreach ($data as $sucursal)
		<tr>
			<td>{{ $sucursal->nombre_sucursal}}</td>
			<td>{{ $sucursal->fk_id_localidad }}</td>
			<td>{{ $sucursal->fk_id_tipo_sucursal }}</td>
			<td>{{ $sucursal->fk_id_supervisor}}</td>
			<td><p>
					<input type="checkbox" id="activo" name="activo" disabled checked="{{ $sucursal->activo}}">
					<label for="activo"></label>
				</p>
			</td>
			<td class="width-auto">
				<a href="{{ companyRoute('show', ['id' => $sucursal->id_sucursal]) }}" class="waves-effect waves-light btn btn-flat no-padding"><i class="material-icons">visibility</i></a>
				<a href="{{ companyRoute('edit', ['id' => $sucursal->id_sucursal]) }}" class="waves-effect waves-light btn btn-flat no-padding"><i class="material-icons">mode_edit</i></a>
				<a href="#" class="waves-effect waves-light btn btn-flat no-padding" onclick="event.preventDefault(); document.getElementById('delete-form{{$sucursal->id_sucursal}}').submit();"><i class="material-icons">delete</i></a>
				<form id="delete-form{{$sucursal->id_sucursal}}" action="{{ companyRoute('destroy', ['id' => $sucursal->id_sucursal]) }}" method="POST" style="display: none;">
					{{ csrf_field() }}
					{{ method_field('DELETE') }}
				</form>
			</td>
		</tr>
		@endforeach
		</tbody>
	</table>
</div>
@endsection
