
@section('content-width', 's12 m7 xl8 offset-xl2')

@section('form-content')
{{ Form::setModel($data) }}
<div class="row">
    <div class="input-field col s12 m5">
        {{ Form::text('aplicacion', null, ['id'=>'aplicacion','class'=>'validate']) }}
        {{ Form::label('aplicacion', 'Aplicacion:') }}
        {{ $errors->has('aplicacion') ? HTML::tag('span', $errors->first('aplicacion'), ['class'=>'help-block deep-orange-text']) : '' }}
    </div>
    <div class="input-field col s12 m7">
        {{ Form::hidden('activo', 0) }}
        {{ Form::checkbox('activo', null, old('activo'), ['id'=>'activo']) }}
        {{ Form::label('activo', 'Estatus:') }}
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