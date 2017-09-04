@extends('layouts.dashboard')

@section('title', currentEntityBaseName() . '@Agregar')

@section('form-header')
	{!! Form::open(['url' => companyRoute('index'), 'id' => 'form-model', 'class' => 'col-sm-12']) !!}
@endsection

@section('form-actions')
<div class="text-right">
	{{ Form::button('<span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Guardar', ['type' =>'submit', 'class'=>'btn btn-danger']) }}
	{{ link_to(companyRoute('index'), 'Cerrar', ['class'=>'btn btn-default']) }}
</div>
@endsection

@section('form-title', 'Agregar '. str_singular(currentEntityBaseName()))

@section('content')
<br>
<div class="panel shadow-3 panel-danger">
	<div class="panel-heading">
		<h3 class="panel-title text-center">@yield('form-title')</h3>
	</div>
	<div class="panel-body">
		<div class="row">
			<div class="@yield('content-width')">
				@yield('form-header')
				<fieldset @yield('fieldset')>
					@yield('form-content')
				</fieldset>
				@yield('form-actions')
				{!! Form::close() !!}
				@yield('form-utils')
			</div>
		</div>
	</div>
</div>
@endsection
