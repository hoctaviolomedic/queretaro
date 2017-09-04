
@section('content-width', 's12 m7 xl8 offset-xl2')

@section('form-content')
{{ Form::setModel($data) }}
<div class="row">
	<div class="input-field col s6">
		{{ Form::text('devolucion_motivo', null, ['id'=>'devolucion_motivo','class'=>'validate']) }}
		{{ Form::label('devolucion_motivo', 'Motivo de devolución:') }}
		{{ $errors->has('devolucion_motivo') ? HTML::tag('span', $errors->first('devolucion_motivo'), ['class'=>'help-block deep-orange-text']) : '' }}
	</div>
	<div class="input-field col s6">
		{{ Form::radio('solicitante_devolucion', false, ['id'=>'localidad']) }}
		{{ Form::label('localidad', 'Localidad') }}
		<br>
		{{ Form::radio('solicitante_devolucion', true, ['id'=>'proveedor']) }}
		{{ Form::label('proveedor', 'Proveedor') }}
		{{ $errors->has('devolucion_motivo') ? HTML::tag('span', $errors->first('devolucion_motivo'), ['class'=>'help-block deep-orange-text']) : '' }}
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