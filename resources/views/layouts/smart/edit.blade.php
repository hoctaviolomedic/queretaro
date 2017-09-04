@extends('layouts.smart.create')

@section('title', currentEntityBaseName() . '@Editar')

@section('form-header')
    {!! Form::open(['method'=>'put', 'url' => companyRoute('update'), 'id' => 'form-model', 'class' => 'col s12 m12']) !!}
@endsection

@section('form-actions')
    <div class="row">
        <div class="right">
            {{ Form::button('Guardar', ['type' =>'submit', 'class'=>'waves-effect waves-light btn orange']) }}
            {{ link_to(companyRoute('index'), 'Cerrar', ['class'=>'waves-effect waves-teal btn-flat teal-text']) }}
        </div>
    </div>
@endsection

@section('form-title')
    {{ HTML::tag('h4','Editar '. str_singular(currentEntityBaseName())) }}
@endsection
