@extends('layouts.dashboard')

@section('title', 'Ver')

@section('header-top')
@endsection

@section('header-bottom')
	<script src="{{ asset('js/modulos.js') }}"></script>
@endsection

@section('content')
<div class="col s12 xl8 offset-xl2">
	<div class="row">
		<div class="col s6">
			<p class="left-align">
				<a href="{{ companyRoute('index') }}" class="waves-effect waves-light btn">Regresar</a> <br>
			</p>
		</div>
		<div class="col s6">
			<p class="right-align">
				<a href="{{ companyRoute('edit', ['id' => $data->id_modulo]) }}" class="waves-effect waves-light btn"><i class="material-icons right">mode_edit</i>Editar</a>
			</p>
		</div>
	</div>
</div>
<div class="col s12 xl8 offset-xl2">
	<div class="row">
		<div class="input-field col s12 m5">
			<input type="text" name="nombre" id="nombre" class="validate"  readonly value="{{ $data->nombre }}">
			<label for="nombre">Nombre:</label>
			@if ($errors->has('nombre'))
				<span class="help-block">
					<strong>{{ $errors->first('nombre') }}</strong>
				</span>
			@endif
		</div>
		<div class="input-field col s12 m7">
			<input type="text" name="descripcion" id="descripcion" class="validate"  readonly value="{{ $data->descripcion }}">
			<label for="descripcion">Descripcion:</label>
			@if ($errors->has('descripcion'))
				<span class="help-block">
					<strong>{{ $errors->first('descripcion') }}</strong>
				</span>
			@endif
		</div>
	</div>
	<div class="row">
		<div class="input-field col s12 m4">
			<input type="text" name="url" id="url" class="validate"  readonly value="{{ $data->url }}">
			<label for="url">URL:</label>
			@if ($errors->has('url'))
				<span class="help-block">
					<strong>{{ $errors->first('url') }}</strong>
				</span>
			@endif
		</div>
		<div class="input-field col s12 m4">
			<select name="icono" disabled >
				<option disabled selected>Icono ...</option>
				<option value="icono-1" {{ $data->icono == 'icono-1' ? 'selected' : '' }}>Option 1</option>
				<option value="icono-2" {{ $data->icono == 'icono-2' ? 'selected' : '' }}>Option 2</option>
				<option value="icono-3" {{ $data->icono == 'icono-3' ? 'selected' : '' }}>Option 3</option>
			</select>
			@if ($errors->has('icono'))
				<span class="help-block">
					<strong>{{ $errors->first('icono') }}</strong>
				</span>
			@endif
		</div>
		<div class="input-field col s12 m4">
			<select name="empresas[]" multiple disabled>
				<option disabled selected>Empresas ...</option>
				@foreach ($empresas as $empresa)
				<option value="{{$empresa->id_empresa}}" {{ in_array( $empresa->id_empresa , $data->empresas->pluck('id_empresa')->toArray() ) ? 'selected' :'' }} >{{$empresa->nombre_comercial}}</option>
				@endforeach
			</select>
			@if ($errors->has('empresas'))
				<span class="help-block">
					<strong>{{ $errors->first('empresas') }}</strong>
				</span>
			@endif
		</div>
	</div>
	<div class="row">
		<div class="input-field col s12 l6 xl3">
			<p>
				<input type="checkbox" id="accion_menu" name="accion_menu" disabled {{$data->accion_menu ? 'checked' : ''}} />
				<label for="accion_menu">Acción Menu</label>
				@if ($errors->has('accion_menu'))
					<span class="help-block">
						<strong>{{ $errors->first('accion_menu') }}</strong>
					</span>
				@endif
			</p>
		</div>
		<div class="input-field col s12 l6 xl3">
			<p>
				<input type="checkbox" id="accion_barra" name="accion_barra" disabled {{$data->accion_barra ? 'checked' : ''}} />
				<label for="accion_barra">Acción Barra</label>
				@if ($errors->has('accion_barra'))
					<span class="help-block">
						<strong>{{ $errors->first('accion_barra') }}</strong>
					</span>
				@endif
			</p>
		</div>
		<div class="input-field col s12 l6 xl3">
			<p>
				<input type="checkbox" id="accion_tabla" name="accion_tabla" disabled {{$data->accion_tabla ? 'checked' : ''}} />
				<label for="accion_tabla">Acción Tabla</label>
				@if ($errors->has('accion_tabla'))
					<span class="help-block">
						<strong>{{ $errors->first('accion_tabla') }}</strong>
					</span>
				@endif
			</p>
		</div>
		<div class="input-field col s12 l6 xl3">
			<p>
				<input type="checkbox" id="modulo_seguro" name="modulo_seguro" disabled {{$data->modulo_seguro ? 'checked' : ''}} />
				<label for="modulo_seguro">Modo seguro</label>
				@if ($errors->has('modulo_seguro'))
					<span class="help-block">
						<strong>{{ $errors->first('modulo_seguro') }}</strong>
					</span>
				@endif
			</p>
		</div>
	</div>
</div>

@endsection
