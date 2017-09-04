
@section('content-width', 's12 m7 xl8 offset-xl2')

@section('form-content')
{{ Form::setModel($data) }}
<div class="row">
    <div class="input-field col s12 m5">
        {{ Form::text('descripcion', null, ['id'=>'descripcion','class'=>'validate']) }}
        {{ Form::label('descripcion', 'Familia:') }}
        {{ $errors->has('descripcion') ? HTML::tag('span', $errors->first('descripcion'), ['class'=>'help-block deep-orange-text']) : '' }}
    </div>
    <div class="input-field col s12 m4">
        {{ Form::text('nomenclatura', null, ['id'=>'nomenclatura','class'=>'validate']) }}
        {{ Form::label('nomenclatura', 'Nomenclatura:') }}
        {{ $errors->has('nomenclatura') ? HTML::tag('span', $errors->first('nomenclatura'), ['class'=>'help-block deep-orange-text']) : '' }}
    </div>
    <div class="input-field col s12 m5">
        {{ Form::text('tipo', null, ['id'=>'tipo','class'=>'validate']) }}
        {{ Form::label('tipo', 'Tipo:') }}
        {{ $errors->has('tipo') ? HTML::tag('span', $errors->first('tipo'), ['class'=>'help-block deep-orange-text']) : '' }}
    </div>
    <div class="input-field col s12 m4">
        {{ Form::text('tipo_presentacion', null, ['id'=>'tipo_presentacion','class'=>'validate']) }}
        {{ Form::label('tipo_presentacion', 'Presentacion:') }}
        {{ $errors->has('tipo_presentacion') ? HTML::tag('span', $errors->first('tipo_presentacion'), ['class'=>'help-block deep-orange-text']) : '' }}
    </div>
    <div class="input-field col s12 m3">
        {{ Form::hidden('activo', 0) }}
        {{ Form::checkbox('activo', null, old('activo'), ['id'=>'activo']) }}
        {{ Form::label('activo', 'Activo:') }}
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