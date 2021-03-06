@extends('layouts.smart.create')

@section('title', currentEntityBaseName() . '@Ver')

@section('fieldset', 'disabled')

@section('form-header')
    {!! Form::open(['url' => '#', 'id' => 'form-model', 'class' => 'col-sm-12']) !!}
@endsection

@section('form-actions')
<div class="text-right">
    {{ link_to(companyRoute('index'), 'Cerrar', ['id'=>'cerrar','class'=>'btn btn-default']) }}
    @can('update', currentEntity())
    {{ link_to(companyRoute('edit'), 'Editar', ['id'=>'editar','class'=>'btn btn-default']) }}
    @endcan
    @can('create', currentEntity())
    {{ link_to(companyRoute('create'), 'Nuevo', ['id'=>'nuevo','class'=>'btn btn-danger']) }}
    @endcan
</div>
@endsection

@section('form-title', 'Datos del '. str_singular(currentEntityBaseName()))
