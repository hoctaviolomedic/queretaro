
@section('content-width', 's12 m7 xl8 offset-xl2')

@section('form-content')
{{ Form::setModel($data) }}
<div class="row">
	<div class="input-field col s4">
		{{ Form::text('correo', null, ['id'=>'correo','class'=>'validate']) }}
		{{ Form::label('correo', 'Correo:') }}
		{{ $errors->has('correo') ? HTML::tag('span', $errors->first('correo'), ['class'=>'help-block deep-orange-text']) : '' }}
	</div>
	<div class="input-field col s4">
		{{ Form::select('fk_id_empresa', (isset($companies) ? $companies : []), null, ['id'=>'fk_id_empresa','class'=>'validate']) }}
		{{ Form::label('fk_id_empresa', 'Empresa:') }}
		{{ $errors->has('fk_id_empresa') ? HTML::tag('span', $errors->first('fk_id_empresa'), ['class'=>'help-block deep-orange-text']) : '' }}
	</div>
	<div class="input-field col s4">
		{{ Form::select('fk_id_usuario', (isset($users) ? $users : []), null, ['id'=>'fk_id_usuario','class'=>'validate']) }}
		{{ Form::label('fk_id_usuario', 'Usuario:') }}
		{{ $errors->has('fk_id_usuario') ? HTML::tag('span', $errors->first('fk_id_usuario'), ['class'=>'help-block deep-orange-text']) : '' }}
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