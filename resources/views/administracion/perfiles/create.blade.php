@extends('layouts.dashboard')

@section('title', 'Crear')

@section('header-top')
	<!--Import Google Icon Font-->
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<!--Import materialize.css-->
	<!--<link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>-->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.99.0/css/materialize.min.css">
	<!--estilo css personal-->
	<link type="text/css" rel="stylesheet" href="css/style.css"  media="screen,projection"/>
	<!--meta para caracteres especiales-->
	<meta charset="UTF-8">
	<!--Let browser know website is optimized for mobile-->
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
@endsection

@section('header-bottom')
	<script src="{{ asset('js/perfiles.js') }}"></script>
@endsection

@section('content')
	<form action="{{ companyRoute("index",['company' => $company]) }}" method="post" class="col s12">
		{{ csrf_field() }}
		{{ method_field('POST') }}
	<div class="row">
		<div class="right">
			<button class="btn orange waves-effect waves-light" name="action">Guardar</button>
			<a href="{{ url()->previous() }}" class="waves-effect waves-teal btn-flat teal-text">Cancelar y salir</a>
		</div>
	</div><!--/row buttons-->

	<!--Dropdown acciones dropdown-->
	<ul id='exportActions' class='dropdown-content'>
		<li><a href="#!">Exportar a Excel</a></li>
		<li><a href="#!">Exportar a PDF</a></li>
	</ul>

	<div class="row">

		<div class="col s12 m5">
			<h5>Perfil</h5>
			<div class="row">
				<div class="input-field col s12 m7">
					<input id="nombre_perfil" name="nombre_perfil" type="text" class="validate">
					<label for="nombre_perfil">Perfil:</label>
				</div>
				<div class="input-field col s12 m5">
					<input id="descripcion" name="descripcion" type="text" class="validate">
					<label for="descripcion">Descripción:</label>
				</div>
			</div>

			<pre>
			<!--{{ print_r($errors)  }}-->
			</pre>

			<div class="row">
				<div class="col s12 m6">
					<label>Usuarios asignados:</label>
					<select name="usuarios[]" multiple>
						<option value="" disabled selected>Selecciona...</option>
						@foreach($users as $user)
							<option value="{{$user->id_usuario}}">{{$user->usuario}}</option>
						@endforeach
					</select>
				</div>
			</div>
		</div>


	</div><!--/row-->
	</form>
	<!--/modales-->
	<div id="ticketHelp" class="modal modal-fixed-footer">
		<div class="modal-content">
			<h4>Modal Header</h4>
			<p>A bunch of text</p>
		</div>
		<div class="modal-footer">
			<a href="#!" class="modal-action modal-close waves-effect waves-blue darken-4 btn-flat">Agree</a>
		</div>
	</div><!--/Modal de ayuda-->

	<!--Import jQuery before materialize.js-->
	<!--Script para hacer los datos ordenarse-->
	<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
	<script type="text/javascript" src="js/materialize.min.js"></script>
	<!--jquery de dateTables creados-->
	<script type="text/javascript" src="js/InitiateComponents.js"></script>
@endsection
