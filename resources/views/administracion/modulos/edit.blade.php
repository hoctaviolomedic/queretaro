@extends('layouts.dashboard')

@section('title', 'Editar')

@section('header-top')
@endsection

@section('header-bottom')
	<script src="{{ asset('js/modulos.js') }}"></script>
@endsection

@section('content')
<form action="{{ companyRoute('update') }}" method="post" class="col s12">
	{{ csrf_field() }}
	{{ method_field('PUT') }}
	<div class="col s12">
		<div class="row">
			<div class="right">
				<button type="submit" class="waves-effect btn orange">Guardar y salir</button>
				<a href="#" class="waves-effect btn">Segunda opcion</a>
				<a href="{{ url()->previous() }}" class="waves-effect waves-teal btn-flat teal-text">Cancelar y salir</a>
			</div>
		</div>
	</div>
	<div class="col s12 xl8 offset-xl2">
		<h5>Editar {{ trans_choice('messages.'.$entity, 0) }}</h5>
		<div class="row">
			<div class="input-field col s12 m5">
				<input type="text" name="nombre" id="nombre" class="validate" value="{{ $data->nombre }}">
				<label for="nombre">Nombre:</label>
				@if ($errors->has('nombre'))
					<span class="help-block">
						<strong>{{ $errors->first('nombre') }}</strong>
					</span>
				@endif
			</div>
			<div class="input-field col s12 m7">
				<input type="text" name="descripcion" id="descripcion" class="validate" value="{{ $data->descripcion }}">
				<label for="descripcion">Descripcion:</label>
				@if ($errors->has('descripcion'))
					<span class="help-block">
						<strong>{{ $errors->first('descripcion') }}</strong>
					</span>
				@endif
			</div>
		</div>
		<div class="row">
			<div class="input-field col s12 m3">
				<input type="text" name="url" id="url" class="validate" value="{{ $data->url }}">
				<label for="url">URL:</label>
				@if ($errors->has('url'))
					<span class="help-block">
						<strong>{{ $errors->first('url') }}</strong>
					</span>
				@endif
			</div>
			<div class="input-field col s12 m3">
				<select name="icono">
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
			<div class="input-field col s12 m3">
				<select name="modulos[]" multiple>
					<option disabled selected>modulos ...</option>
					@foreach ($modulos as $modulo)
					<option value="{{$modulo->id_modulo}}" {{ in_array( $modulo->id_modulo , $data->modulos->pluck('id_modulo')->toArray() ) ? 'selected' :'' }} >{{$modulo->nombre}}</option>
					@endforeach
				</select>
				@if ($errors->has('modulos'))
					<span class="help-block">
						<strong>{{ $errors->first('modulos') }}</strong>
					</span>
				@endif
			</div>
			<div class="input-field col s12 m3">
				<select name="empresas[]" multiple>
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
					<input type="checkbox" id="accion_menu" name="accion_menu" {{$data->accion_menu ? 'checked' : ''}} />
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
					<input type="checkbox" id="accion_barra" name="accion_barra" {{$data->accion_barra ? 'checked' : ''}} />
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
					<input type="checkbox" id="accion_tabla" name="accion_tabla" {{$data->accion_tabla ? 'checked' : ''}} />
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
					<input type="checkbox" id="modulo_seguro" name="modulo_seguro" {{$data->modulo_seguro ? 'checked' : ''}} />
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
</form>
@endsection
