
@section('content-width', 's12 m7 xl8 offset-xl2')

@section('form-content')
{{ Form::setModel($data) }}
<div class="row">
	<div class="input-field col s6">
		{{ Form::text('sustancia_activa', null, ['id'=>'sustancia_activa','class'=>'validate']) }}
		{{ Form::label('sustancia_activa', 'Sustancia Activa:') }}
		{{ $errors->has('sustancia_activa') ? HTML::tag('span', $errors->first('sustancia_activa'), ['class'=>'help-block deep-orange-text']) : '' }}
	</div>
	<div class="input-field col s6">
		{{ Form::hidden('opcion_gramaje', 0) }}
		{{ Form::checkbox('opcion_gramaje', null, old('opcion_gramaje'), ['id'=>'opcion_gramaje']) }}
		{{ Form::label('opcion_gramaje', '¿Gramaje?') }}
		{{ $errors->has('opcion_gramaje') ?  HTML::tag('span', $errors->first('opcion_gramaje'), ['class'=>'help-block deep-orange-text']) : '' }}
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