
@section('content-width', 's12 m7 xl8 offset-xl2')

@section('form-content')
{{ Form::setModel($data) }}
<div class="row">
	<div class="input-field col s12 m5">
		{{ Form::text('clave_diagnostico', null, ['id'=>'clave_diagnostico','class'=>'validate']) }}
		{{ Form::label('clave_diagnostico', 'Calve:') }}
		{{ $errors->has('clave_diagnostico') ? HTML::tag('span', $errors->first('clave_diagnostico'), ['class'=>'help-block deep-orange-text']) : '' }}
	</div>
	<div class="input-field col s12 m7">
		{{ Form::text('diagnostico', null, ['id'=>'diagnostico','class'=>'validate']) }}
		{{ Form::label('diagnostico', 'Diagnostico:') }}
		{{ $errors->has('diagnostico') ? HTML::tag('span', $errors->first('diagnostico'), ['class'=>'help-block deep-orange-text']) : '' }}
	</div>
</div>
<div class="row">
	<div class="input-field col s12 m5">
		{{ Form::text('medicamento_sugerido', null, ['id'=>'medicamento_sugerido','class'=>'validate']) }}
		{{ Form::label('medicamento_sugerido', 'Medicamento Sugerido:') }}
		{{ $errors->has('medicamento_sugerido') ? HTML::tag('span', $errors->first('medicamento_sugerido'), ['class'=>'help-block deep-orange-text']) : '' }}
	</div>
	<div class="input-field col s12 l6 xl3">
		{{ Form::hidden('estatus', 0) }}
		{{ Form::checkbox('estatus', null, old('estatus'), ['id'=>'estatus']) }}
		{{ Form::label('estatus', 'Estatus') }}
		{{ $errors->has('estatus') ?  HTML::tag('span', $errors->first('estatus'), ['class'=>'help-block deep-orange-text']) : '' }}
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