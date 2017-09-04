
@section('content-width', 's12 m7 xl8 offset-xl2')

@section('form-content')
{{ Form::setModel($data) }}
<div class="row">
	<div class="input-field col s12 m12 l6">
		{{ Form::text('area', null, ['id'=>'area','class'=>'validate']) }}
		{{ Form::label('area', '* Area') }}
		{{ $errors->has('area') ? HTML::tag('span', $errors->first('area'), ['class'=>'help-block deep-orange-text']) : '' }}
	</div>
	<div class="input-field col s12 m8 l4">
		{{ Form::text('clave_area', null, ['id'=>'clave_area','class'=>'validate']) }}
		{{ Form::label('clave_area', '* Clave') }}
		{{ $errors->has('clave_area') ? HTML::tag('span', $errors->first('clave_area'), ['class'=>'help-block deep-orange-text']) : '' }}
	</div>
	<div class="input-field col s12 m4 l2">
		{{ Form::hidden('activo', 0) }}
		{{ Form::checkbox('activo', null, old('activo'), ['id'=>'activo']) }}
		{{ Form::label('activo', '¿Activo?') }}
	</div>
</div>
@endsection

@section('form-utils')
	<div id="modal-1" class="modal bottom-sheet">
		<div class="modal-content">
			<h5 class="teal-text"><i class="material-icons">announcement</i></span> RFC:</h5>
			<ul class="collection">
            	<li class="collection-item">
                	<i class="material-icons teal-text">info</i>
                	<span class="title">Publico General: XAXX010101000.</span>
                </li>
                <li class="collection-item">
                	<i class="material-icons teal-text">info</i>
                  	<span class="title">Extranjero: XEXX010101000.</span>
                </li>
            </ul>
			<br>
		</div>
		
	</div>
@stop

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