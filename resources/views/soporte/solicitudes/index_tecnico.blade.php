@extends('layouts.dashboard')

@section('title', 'ImpuestosController')

@section('header-top')
	<!--dataTable.css-->
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css">
	<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.3.1/css/buttons.dataTables.min.css">
@endsection

@section('header-bottom')
	<script src="//cdn.datatables.net/1.10.15/js/jquery.dataTables.js"></script>
	<script src="{{ asset('js/modulos.js') }}"></script>
	<script src="{{ asset('js/ticket.js') }}"></script>
	<!-- <script src="https://cdn.datatables.net/v/dt/jszip-2.5.0/pdfmake-0.1.18/dt-1.10.12/b-1.2.2/b-colvis-1.2.2/b-html5-1.2.2/b-print-1.2.2/cr-1.3.2/r-2.1.0/datatables.min.js"></script> -->
@endsection

@section('content')
<div class="col s12 xl8 offset-xl2">
	<p class="right">
		<a href="{{ companyAction('index') }}" class="waves-effect waves-light btn"><i class="material-icons">cached</i></a>
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
				<th>Asunto</th>
				<th>Descripcion</th>
				<th>Estado de la solicitud</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
		@foreach ($data as $row)
		<tr>
			<td>{{ $row->asunto}}</td>
			<td>{{$row->descripcion}}</td>
			<td>{{$row->estatusTickets->estatus}}</td>
			<td class="width-auto">
				<a href="{{ companyAction('show', ['id' => $row->id_solicitud]) }}" class="waves-effect waves-light btn btn-flat no-padding"><i class="material-icons">mode_comment</i></a>
			</td>
		</tr>
		@endforeach
		</tbody>
	</table>
</div>
@endsection
