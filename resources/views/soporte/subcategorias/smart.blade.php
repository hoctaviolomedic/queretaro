
@section('content-width', 's12 ml2')

@section('header-bottom')
	@parent
@endsection

@section('form-content')
{{ Form::setModel($data) }}
<div class="row">
	<div class="input-field col s6">
		{{ Form::text('subcategoria', null, ['id'=>'subcategoria','class'=>'validate']) }}
		{{ Form::label('subcategoria', '* subcategoria') }}
		{{ $errors->has('subcategoria') ? HTML::tag('span', $errors->first('subcategoria'), ['class'=>'help-block deep-orange-text']) : '' }}
	</div>
	<div class="input-field col s4">
		{{ Form::select('fk_id_categoria', (isset($categorys) ? $categorys : []), ['id'=>'fk_id_categoria','class'=>'validate']) }}
		{{ Form::label('fk_id_categoria', '* Categoria') }}
		{{ $errors->has('fk_id_categoria') ? HTML::tag('span', $errors->first('fk_id_categoria'), ['class'=>'help-block deep-orange-text']) : '' }}
	</div>
	<div class="input-field col s2">
		{{ Form::hidden('activo', 0) }}
		{{ Form::checkbox('activo', null, old('activo'), ['id'=>'activo']) }}
		{{ Form::label('activo', '¿Activo?') }}
		{{ $errors->has('activo') ?  HTML::tag('span', $errors->first('activo'), ['class'=>'help-block deep-orange-text']) : '' }}
	</div>
</div>
@endsection

@section('form-utils')
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