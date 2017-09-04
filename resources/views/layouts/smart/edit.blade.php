@extends('layouts.smart.create')

@section('title', currentEntityBaseName() . '@Editar')

@section('form-header')
    {!! Form::open(['method'=>'put', 'url' => companyRoute('update'), 'id' => 'form-model', 'class' => 'col-sm-12']) !!}
@endsection

@section('form-actions')
<div class="text-right">
    {{ Form::button('<span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Guardar', ['type' =>'submit', 'class'=>'btn btn-danger']) }}
    {{ link_to(companyRoute('index'), 'Cerrar', ['class'=>'btn btn-default']) }}
</div>
@endsection

@section('form-title', 'Editar '. str_singular(currentEntityBaseName()))
