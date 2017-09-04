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
		<form action="{{ companyRoute('update') }}" method="post" class="col s12">
			{{ csrf_field() }}
			{{ method_field('PUT') }}
			<div class="row">
				<div class="input-field col s6">
					<input type="text" name="nombre_sucursal" id="nombre_sucursal" class="validate" value="{{$data->nombre_sucursal}}">
					<label for="nombre_sucursal">Sucursal</label>
					@if ($errors->has('nombre_sucursal'))
						<span class="help-block">
							<strong>{{ $errors->first('nombre_sucursal') }}</strong>
						</span>
					@endif
				</div>
				<div class="input-field col s6">
					<select name="fk_id_supervisor" id="fk_id_supervisor" value="{{$data->fk_id_supervisor}}"></select>
					<label for="fk_id_supervisor">Supervisor</label>
				</div>
			</div>
			<div class="row">
				<div class="input-field col s6">
					<input type="text" name="latitud" id="latitud" class="validate" value="{{$data->latitud}}">
					<label for="latitud">Latitud</label>
				</div>
				<div class="input-field col s6">
					<input type="text" id="longitud" name="longitud" class="validate" value="{{$data->longitud}}">
					<label for="longitud">Longitud</label>
				</div>
			</div>
			<div class="row">
				<div class="input-field col s6">
					<select name="fk_id_tipo_sucursal" id="fk_id_tipo_sucursal" value="{{$data->fk_id_tipo_sucursal}}"></select>
					<label for="fk_id_tipo_sucursal">Tipo Sucursal</label>
				</div>
				<div class="input-field col s6">
					<input type="text" name="registro_sanitario" id="registro_sanitario" class="validate" value="{{$data->registro_sanitario}}">
					<label for="registro_sanitario">Registro Sanitario</label>
				</div>
			</div>
			<div class="row">
				<div class="input-field col s4">
					<select name="fk_id_cliente" id="fk_id_cliente" value="{{$data->fk_id_cliente}}"></select>
					<label for="fk_id_cliente">Cliente</label>
				</div>
				<div class="input-field col s4">
					<select name="fk_id_localidad" id="fk_id_localidad" value="{{$data->fk_id_localidad}}"></select>
					<label for="fk_id_localidad">Localidad</label>
				</div>
				<div class="input-field col s4">
					<p>
						<input type="checkbox" id="embarque" name="embarque" checked="{{$data->embarque}}"/>
						<label for="embarque">Embarque</label>
					</p>
				</div>
			</div>
			<div class="row">
				<div class="input-field col s4">
					<select name="fk_id_municipio" id="fk_id_municipio" value="{{$data->fk_id_municipio}}"></select>
					<label for="fk_id_municipio">Municipio</label>
				</div>
				<div class="input-field col s4">
					<select name="fk_id_estado" id="fk_id_estado" value="{{$data->fk_id_estado}}"></select>
					<label for="fk_id_estado">Estado</label>
				</div>
				<div class="input-field col s4">
					<select name="fk_id_pais" id="fk_id_pais" value="{{$data->fk_id_estado}}"></select>
					<label for="fk_id_pais">País</label>
				</div>
			</div>
			<div class="row">
				<div class="input-field col s6">
					<input type="text" name="calle" id="calle" class="validate" value="{{$data->calle}}">
					<label for="calle">Calle</label>
				</div>
				<div class="input-field col s3">
					<input type="text" name="no_exterior" id="no_exterior" class="validate" value="{{$data->no_exterior}}">
					<label for="no_exterior">Número exterior</label>
				</div>
				<div class="input-field col s3">
					<input type="text" name="no_interior" id="no_interior" class="validate" value="{{$data->no_interior}}">
					<label for="no_interior">Número Interior</label>
				</div>
			</div>
			<div class="row">
				<div class="input-field col s4">
					<input type="text" name="telefono1" id="telefono1" class="validate" value="{{$data->telefono1}}">
					<label for="telefono1">Teléfono 1</label>
				</div>
				<div class="input-field col s4">
					<input type="text" name="telefono2" id="telefono2" class="validate" value="{{$data->telefono2}}">
					<label for="telefono2">Teléfono 2</label>
				</div>
				<div class="input-field col s4">
					<input type="text" name="clave_presupuestal" id="clave_presupuestal" class="validate" value="{{$data->clave_presupuestal}}">
					<label for="clave_presupuestal">Clave Presupuestal</label>
				</div>
			</div>
			<div class="col 1 xl9 offset-xl0">
				<h6>Datos militares</h6>(si aplica)
			</div>
			<div class="row">
				<div class="input-field col s4">
					<input type="text" name="tipo_batallon" id="tipo_batallon" class="validate" value="{{$data->tipo_batallon}}">
					<label for="tipo_batallon">Tipo de batallón</label>
				</div>
				<div class="input-field col s4">
					<input type="text" name="region" id="region" class="validate" value="{{$data->region}}">
					<label for="region">Región</label>
				</div>
				<div class="input-field col s4">
					<input type="text" name="zona_militar" id="zona_militar" class="validate" value="{{$data->zona_militar}}">
					<label for="zona_militar">Zona Militar</label>
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
