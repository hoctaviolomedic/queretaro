@extends('layouts.smart.create')

@section('title', currentEntityBaseName() . '@Ver')

@section('fieldset', 'disabled')

@section('form-header')
    {!! Form::open(['url' => '#', 'id' => 'form-model', 'class' => 'col s12 m12']) !!}
@endsection

@section('form-actions')
    <div class="row">
        <div class="right">
            {{ link_to(companyRoute('index'), 'Cerrar', ['class'=>'waves-effect waves-light btn orange']) }}
            @can('update', currentEntity())
            {{ link_to(companyRoute('edit'), 'Editar', ['class'=>'waves-effect waves-teal btn-flat teal-text']) }}
            @endcan
            @can('create', currentEntity())
            {{ link_to(companyRoute('create'), 'Nuevo', ['class'=>'waves-effect waves-teal btn-flat teal-text']) }}
            @endcan
        </div>
    </div>
@endsection

@section('form-title')
    {{ HTML::tag('h4', 'Datos del '. str_singular(currentEntityBaseName())) }}
@endsection
