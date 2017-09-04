
@section('content-width', 's12 m7 xl8 offset-xl2')

@section('form-content')
{{ Form::setModel($data) }}
<div class="row">
	<div class="input-field col s12">
		{{ Form::text('razon_social', null, ['id'=>'razon_social','class'=>'validate']) }}
		{{ Form::label('razon_social', '* Razón Social') }}
		{{ $errors->has('razon_social') ? HTML::tag('span', $errors->first('razon_social'), ['class'=>'help-block deep-orange-text']) : '' }}
	</div>
</div>
<div class="row">
	<div class="input-field col s6">
		{{ Form::text('banco', null, ['id'=>'banco','class'=>'validate']) }}
		{{ Form::label('banco', '* Banco') }}
		{{ $errors->has('banco') ? HTML::tag('span', $errors->first('banco'), ['class'=>'help-block deep-orange-text']) : '' }}
	</div>
	<div class="input-field col s6">
		<a href="#modal-1" class="prefix"><i class="material-icons">info</i></a>
		{{ Form::text('rfc', null, ['id'=>'rfc','class'=>'validate']) }}
		{{ Form::label('rfc', 'Rfc') }}
		{{ $errors->has('rfc') ? HTML::tag('span', $errors->first('rfc'), ['class'=>'help-block deep-orange-text']) : '' }}
	</div>
</div>
<div class="row">
	<div class="input-field col s12">
		{{ Form::hidden('nacional', 0) }}
		{{ Form::checkbox('nacional', null, old('nacional'), ['id'=>'nacional']) }}
		{{ Form::label('nacional', '¿Banco nacional?') }}
		{{ $errors->has('nacional') ?  HTML::tag('span', $errors->first('nacional'), ['class'=>'help-block deep-orange-text']) : '' }}
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