
@section('content-width', 's12 m7 xl8 offset-xl2')

@section('form-content')
{{ Form::setModel($data) }}

<div class="row">
	<div class="input-field col s3">
		{{ Form::text('numero_cuenta', null, ['id'=>'numero_cuenta','class'=>'validate']) }}
		{{ Form::label('numero_cuenta', 'Número de cuenta:') }}
		{{ $errors->has('numero_cuenta') ? HTML::tag('span', $errors->first('numero_cuenta'), ['class'=>'help-block deep-orange-text']) : '' }}
	</div>
	<div class="input-field col s3">
		{{ Form::select('fk_id_banco', ($bancos ?? []), null, ['id'=>'fk_id_banco', 'class'=>'validate']) }}
		{{ Form::label('fk_id_banco', 'Banco:') }}
		{{ $errors->has('fk_id_banco') ? HTML::tag('span', $errors->first('fk_id_banco'), ['class'=>'help-block deep-orange-text']) : '' }}
	</div>
	<div class="input-field col s3">
		{{ Form::select('fk_id_sat_moneda', ($monedas ?? []), null, ['id'=>'fk_id_sat_moneda', 'class'=>'validate']) }}
		{{ Form::label('fk_id_sat_moneda', 'Moneda:') }}
		{{ $errors->has('fk_id_sat_moneda') ? HTML::tag('span', $errors->first('fk_id_sat_moneda'), ['class'=>'help-block deep-orange-text']) : '' }}
	</div>
	<div class="input-field col s3">
		{{ Form::select('fk_id_empresa', ($companies ?? []), null, ['id'=>'fk_id_empresa', 'class'=>'validate']) }}
		{{ Form::label('fk_id_empresa', 'Empresa:') }}
		{{ $errors->has('fk_id_empresa') ? HTML::tag('span', $errors->first('fk_id_empresa'), ['class'=>'help-block deep-orange-text']) : '' }}
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