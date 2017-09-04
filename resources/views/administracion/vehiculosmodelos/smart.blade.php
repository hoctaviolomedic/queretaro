
@section('content-width', 's12 m7 xl8 offset-xl2')

@section('form-content')
{{ Form::setModel($data) }}
<div class="row">
    <div class="input-field col s4">
        {{ Form::text('modelo', null, ['id'=>'modelo','class'=>'validate']) }}
        {{ Form::label('modelo', 'Modelo:') }}
        {{ $errors->has('modelo') ? HTML::tag('span', $errors->first('modelo'), ['class'=>'help-block deep-orange-text']) : '' }}
    </div>
    <div class="input-field col s4">
        {{ Form::select('fk_id_marca', (isset($brands) ? $brands : []), null, ['id'=>'fk_id_marca','class'=>'validate']) }}
        {{ Form::label('fk_id_marca', 'Estado:') }}
        {{ $errors->has('fk_id_marca') ? HTML::tag('span', $errors->first('fk_id_marca'), ['class'=>'help-block deep-orange-text']) : '' }}
    </div>
    <div class="input-field col s4">
        {{ Form::hidden('activo', 0) }}
        {{ Form::checkbox('activo', null, old('activo'), ['id'=>'activo']) }}
        {{ Form::label('activo', '¿Activo?') }}
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