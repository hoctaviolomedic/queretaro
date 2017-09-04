
@section('content-width', 's12 m7 xl8 offset-xl2')

@section('form-content')
{{ Form::setModel($data) }}

<div class="row">
	<div class="input-field col s6">
		<input type="text" name="nombre_sucursal" id="nombre_sucursal" class="validate">
		<label for="nombre_sucursal">Sucursal</label>
		@if ($errors->has('nombre_sucursal'))
			<span class="help-block">
				<strong>{{ $errors->first('nombre_sucursal') }}</strong>
			</span>
		@endif
	</div>
	<div class="input-field col s6">
		<select name="fk_id_supervisor" id="fk_id_supervisor"></select>
		<label for="fk_id_supervisor">Supervisor</label>
	</div>
</div>
<div class="row">
	<div class="input-field col s6">
		<input type="text" name="latitud" id="latitud" class="validate">
		<label for="latitud">Latitud</label>
		@if ($errors->has('latitud'))
			<span class="help-block">
				<strong>{{ $errors->first('latitud') }}</strong>
			</span>
		@endif
	</div>
	<div class="input-field col s6">
			<input type="text" id="longitud" name="longitud" class="validate"/>
			<label for="longitud">Longitud</label>
		@if ($errors->has('longitud'))
			<span class="help-block">
				<strong>{{ $errors->first('longitud') }}</strong>
			</span>
		@endif
	</div>
</div>
<div class="row">
	<div class="input-field col s6">
		<select name="fk_id_tipo_sucursal" id="fk_id_tipo_sucursal"></select>
		<label for="fk_id_tipo_sucursal">Tipo Sucursal</label>
	</div>
	<div class="input-field col s6">
		<input type="text" name="registro_sanitario" id="registro_sanitario" class="validate">
		<label for="registro_sanitario">Registro Sanitario</label>
		@if ($errors->has('registro_sanitario'))
			<span class="help-block">
				<strong>{{ $errors->first('registro_sanitario') }}</strong>
			</span>
		@endif
	</div>
</div>
<div class="row">
	<div class="input-field col s4">
		<select name="fk_id_cliente" id="fk_id_cliente"></select>
		<label for="fk_id_cliente">Cliente</label>
	</div>
	<div class="input-field col s4">
		<select name="fk_id_localidad" id="fk_id_localidad"></select>
		<label for="fk_id_localidad">Localidad</label>
	</div>
	<div class="input-field col s4">
		<p>
			<input type="checkbox" id="embarque" name="embarque" />
			<label for="embarque">Embarque</label>
		</p>
	</div>
</div>
<div class="row">
	<div class="input-field col s4">
		<select name="fk_id_municipio" id="fk_id_municipio"></select>
		<label for="fk_id_municipio">Municipio</label>
	</div>
	<div class="input-field col s4">
		<select name="fk_id_estado" id="fk_id_estado"></select>
		<label for="fk_id_estado">Estado</label>
	</div>
	<div class="input-field col s4">
		<select name="fk_id_pais" id="fk_id_pais"></select>
		<label for="fk_id_pais">País</label>
	</div>
</div>
<div class="row">
	<div class="input-field col s6">
		<input type="text" name="calle" id="calle" class="validate">
		<label for="calle">Calle</label>
		@if ($errors->has('calle'))
			<span class="help-block">
				<strong>{{ $errors->first('calle') }}</strong>
			</span>
		@endif
	</div>
	<div class="input-field col s3">
		<input type="text" name="no_exterior" id="no_exterior" class="validate">
		<label for="no_exterior">Número exterior</label>
		@if ($errors->has('no_exterior'))
			<span class="help-block">
				<strong>{{ $errors->first('no_exterior') }}</strong>
			</span>
		@endif
	</div>
	<div class="input-field col s3">
		<input type="text" name="no_interior" id="no_interior" class="validate">
		<label for="no_interior">Número Interior</label>
		@if ($errors->has('no_interior'))
			<span class="help-block">
				<strong>{{ $errors->first('no_interior') }}</strong>
			</span>
		@endif
	</div>
</div>
<div class="row">
	<div class="input-field col s4">
		<input type="text" name="telefono1" id="telefono1" class="validate">
		<label for="telefono1">Teléfono 1</label>
		@if ($errors->has('telefono1'))
			<span class="help-block">
				<strong>{{ $errors->first('telefono1') }}</strong>
			</span>
		@endif
	</div>
	<div class="input-field col s4">
		<input type="text" name="telefono2" id="telefono2" class="validate">
		<label for="telefono2">Teléfono 2</label>
		@if ($errors->has('telefono2'))
			<span class="help-block">
				<strong>{{ $errors->first('telefono2') }}</strong>
			</span>
		@endif
	</div>
	<div class="input-field col s4">
		<input type="text" name="clave_presupuestal" id="clave_presupuestal" class="validate">
		<label for="clave_presupuestal">Clave Presupuestal</label>
		@if ($errors->has('clave_presupuestal'))
			<span class="help-block">
				<strong>{{ $errors->first('clave_presupuestal') }}</strong>
			</span>
		@endif
	</div>
</div>
<div class="col 1 xl9 offset-xl0">
	<h6>Datos militares</h6>(si aplica)
</div>
<div class="row">
	<div class="input-field col s4">
		<input type="text" name="tipo_batallon" id="tipo_batallon" class="validate">
		<label for="tipo_batallon">Tipo de batallón</label>
		@if ($errors->has('tipo_batallon'))
			<span class="help-block">
				<strong>{{ $errors->first('tipo_batallon') }}</strong>
			</span>
		@endif
	</div>
	<div class="input-field col s4">
		<input type="text" name="region" id="region" class="validate">
		<label for="region">Región</label>
		@if ($errors->has('region'))
			<span class="help-block">
				<strong>{{ $errors->first('region') }}</strong>
			</span>
		@endif
	</div>
	<div class="input-field col s4">
		<input type="text" name="zona_militar" id="zona_militar" class="validate">
		<label for="zona_militar">Zona Militar</label>
		@if ($errors->has('zona_militar'))
			<span class="help-block">
				<strong>{{ $errors->first('zona_militar') }}</strong>
			</span>
		@endif
	</div>
</div>


<div class="row">
	<div class="input-field col s6">
		{{ Form::text('nombre', null, ['id'=>'nombre','class'=>'validate']) }}
		{{ Form::label('nombre', 'Parentesco:') }}
		{{ $errors->has('nombre') ? HTML::tag('span', $errors->first('nombre'), ['class'=>'help-block deep-orange-text']) : '' }}
	</div>
	<div class="input-field col s6">
		{{ Form::hidden('activo', 0) }}
		{{ Form::checkbox('activo', null, old('activo'), ['id'=>'activo']) }}
		{{ Form::label('activo', '¿Activo?') }}
		{{ $errors->has('activo') ?  HTML::tag('span', $errors->first('activo'), ['class'=>'help-block deep-orange-text']) : '' }}
	</div>
</div>
@endsection

{{-- DONT DELETE --}}
@if (Route::currentRouteNamed(currentRouteName('index')))
	@include('layouts.smart.index')
@endif

@if (Route::currentRouteNamed(currentRouteName('create')))
	@include('layouts.smart.create')
@endif

@if (Route::currentRouteNamed(currentRouteName('edit')))
	@include('layouts.smart.edit')
@endif

@if (Route::currentRouteNamed(currentRouteName('show')))
	@include('layouts.smart.show')
@endif

@if (Route::currentRouteNamed(currentRouteName('export')))
	@include('layouts.smart.export')
@endif