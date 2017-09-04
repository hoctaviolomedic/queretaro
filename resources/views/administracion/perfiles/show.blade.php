@extends('layouts.dashboard')

@section('title', 'Ver')

@section('header-top')
@endsection

@section('header-bottom')
	<script src="{{ asset('js/perfiles.js') }}"></script>
@endsection

@section('content')
<div class="col s12 xl8 offset-xl2">
	<div class="row">
		<div class="col s6">
			<p class="left-align">
				<a href="{{ companyRoute("index",['company'=> $company]) }}" class="waves-effect waves-light btn">Regresar</a> <br>
			</p>
		</div>
		<div class="col s6">
			<p class="right-align">
				<a href="{{ companyRoute("edit",['id' => $data->id_perfil, 'company'=> $company]) }}" class="waves-effect waves-light btn"><i class="material-icons right">mode_edit</i>Editar</a>
			</p>
		</div>
	</div>
	<div class="divider"></div>
</div>

<div class="row">

	<div class="col s12 m5">
		<h5>Perfil</h5>
		<div class="row">
			<div class="input-field col s12 m7">
				<input id="nombre_perfil" name="nombre_perfil" type="text" class="validate" readonly value="{{$data->nombre_perfil}}">
				<label for="nombre_perfil">Perfil:</label>
			</div>
			<div class="input-field col s12 m5">
				<input id="descripcion" name="descripcion" type="text" class="validate" readonly value="{{$data->descripcion}}">
				<label for="descripcion">Descripción:</label>
			</div>
		</div>

		<div class="row">
			<div class="col s12 m6">
				<label>Usuarios asignados:</label>
				<select multiple>
					<option disabled selected>Selecciona...</option>
					{{--For usuarios--}}
							{{--if--}}
						@foreach($users as $user)
						<option value="{{$user->id_usuario}}" {{in_array($user->id_usuario,$data->usuarios->pluck('id_usuario')->toArray()) ? 'selected' : ''}}>{{$user->usuario}}</option>
							{{--end if--}}
						@endforeach
					{{--end for usuarios--}}
				</select>
			</div>
		</div>
	</div>

	{{--<div class="col s12 m7">--}}
		{{--<h5>Empresas</h5>--}}
		{{--<div class="card teal">--}}
			{{--<div class="card-content white-text">--}}
				{{--<p>Recueda que cada empresa tiene sus permisos diferentes.</p>--}}
			{{--</div>--}}
			{{--<div class="card-tabs">--}}
				{{--<ul class="tabs tabs-fixed-width tabs-transparent">--}}
					{{--For para empresas--}}
					{{--@foreach($empresas as $empresa)--}}
						{{--<li class="tab"><a class="active" href="#e_{{$empresa->nombre_comercial}}">{{$empresa->nombre_comercial}}</a></li>--}}
					{{--@endforeach--}}
					{{--end for--}}
				{{--</ul>--}}
			{{--</div>--}}
			{{--<div class="card-content teal lighten-5">--}}
				{{--for para empresas--}}
				{{--@foreach($empresas as $empresa)--}}
					{{--<div id="e_{{$empresa->nombre_comercial}}">--}}
						{{--@foreach($empresa->modulos as $module)--}}
							{{--<ul class="collapsible" data-collapsible="accordion">--}}
								{{--<li>--}}
									{{--for para modulos--}}
									{{--in_array($user->id_usuario,$data->usuarios->pluck('id_usuario')->toArray())--}}
									{{--<div class="collapsible-header">--}}
										{{--<input type="checkbox" id="{{$empresa->id_empresa}}{{$module->id_modulo}}" disabled />--}}
										{{--<label for="{{$empresa->id_empresa}}{{$module->id_modulo}}" class="parent_checkbox">{{$module->nombre}}</label>--}}
									{{--</div>--}}
									{{--<div class="collapsible-body grey lighten-3">--}}
										{{--<ul class="collection">--}}
											{{--for para cantidad de acciones--}}

											{{--<li class="collection-item">--}}
												{{--<input type="checkbox" id="check1{{$empresa->id_empresa}}{{$module->id_modulo}}" class="fac1_child" checked="checked"  disabled/>--}}
												{{--<label for="check1{{$empresa->id_empresa}}{{$module->id_modulo}}">Crear</label>--}}
											{{--</li>--}}
											{{--<li class="collection-item">--}}
												{{--<input type="checkbox" id="check2{{$empresa->id_empresa}}{{$module->id_modulo}}" class="fac1_child" checked="checked" disabled/>--}}
												{{--<label for="check2{{$empresa->id_empresa}}{{$module->id_modulo}}">Editar</label>--}}
											{{--</li>--}}
											{{--<li class="collection-item">--}}
												{{--<input type="checkbox" id="check3{{$empresa->id_empresa}}{{$module->id_modulo}}" class="fac1_child" checked="checked" disabled/>--}}
												{{--<label for="check3{{$empresa->id_empresa}}{{$module->id_modulo}}">Borrar</label>--}}
											{{--</li>--}}
											{{--<li class="collection-item">--}}
												{{--<input type="checkbox" id="check4{{$empresa->id_empresa}}{{$module->id_modulo}}" class="fac1_child" checked="checked" disabled />--}}
												{{--<label for="check4{{$empresa->id_empresa}}{{$module->id_modulo}}">Ver</label>--}}
											{{--</li>--}}
											{{--end of--}}
										{{--</ul>--}}
									{{--</div>--}}
									{{--end for modulos--}}
								{{--</li>--}}
							{{--</ul>--}}
						{{--@endforeach--}}
					{{--</div><!--/aquí termina el contenido de un tab-->--}}
				{{--@endforeach--}}
				{{--end for empresas--}}
			{{--</div>--}}
		{{--</div>--}}
	{{--</div><!--/col-s12 m4-->--}}
</div><!--/row-->
@endsection
