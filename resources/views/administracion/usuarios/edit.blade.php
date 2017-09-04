@extends('layouts.dashboard')

@section('title', 'Editar')

@section('header-top')
@endsection

@section('header-bottom')
	<script src="{{ asset('solicitudes') }}"></script>
@endsection

@section('content')
	<div class="col s12 xl8 offset-xl2">
		<p class="left-align">
			<a href="{{ url()->previous() }}" class="waves-effect waves-light btn">Regresar</a> <br>
		</p>
		<div class="divider"></div>
	</div>
	<div class="col s12 xl8 offset-xl2">
		<h4>Editar {{ trans_choice('messages.'.$entity, 0) }}</h4>
	</div>

	<div class="col s12 xl8 offset-xl2">
		<div class="row">
			<form action="{{ companyRoute("update", ['company'=> $company, 'id' => $data->id_usuario]) }}" method="post" class="col s12">
				{{ csrf_field() }}
				{{ method_field('PUT') }}
				<div class="row">
					<div class="input-field col s12">
						<input type="text" name="nombre_corto" id="nombre_corto" class="validate" value="{{ $data->nombre_corto }}">
						<label for="nombre_corto">Nombre Corto</label>
						@if ($errors->has('nombre_corto'))
							<span class="help-block">
							<strong>{{ $errors->first('nombre_corto') }}</strong>
						</span>
						@endif
					</div>
				</div>
				<div class="row">
					<div class="input-field col s6">
						<input type="text" name="usuario" id="usuario" class="validate" value="{{ $data->usuario }}">
						<label for="usuario">Usuario</label>
						@if ($errors->has('usuario'))
							<span class="help-block">
							<strong>{{ $errors->first('usuario') }}</strong>
						</span>
						@endif
					</div>
					<!--
					<div class="input-field col s6">
						<input type="password" name="password" id="password" class="validate" value="{{ $data->password }}">
						<label for="password">Password</label>
						@if ($errors->has('password'))
							<span class="help-block">
							<strong>{{ $errors->first('password') }}</strong>
						</span>
						@endif
					</div>-->
				</div>
				<div class="row">
					<div class="col s12">
						<p>
							<input type="hidden" name="activo" value="0">
							<input type="checkbox" id="activo" name="activo" {{$data->activo ? 'checked':''}}/>
							<label for="activo">¿Activo?</label>
						</p>
						@if ($errors->has('activo'))
							<span class="help-block">
							<strong>{{ $errors->first('activo') }}</strong>
						</span>
						@endif
					</div>
				</div>
				<div class="row">
					<div class="col s12">
						<button class="waves-effect waves-light btn right">Guardar {{ trans_choice('messages.'.$entity, 0) }}</button>
					</div>
				</div>
			</form>
		</div>
	</div>
@endsection
