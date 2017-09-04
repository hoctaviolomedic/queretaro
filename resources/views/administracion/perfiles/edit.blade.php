@extends('layouts.dashboard')

@section('title', 'Editar')

@section('header-top')
@endsection

@section('header-bottom')
	<script src="{{ asset('js/perfiles.js') }}"></script>
@endsection

@section('content')
<div class="col s12 xl8 offset-xl2">
	<p class="left-align">
		<a href="{{ url()->previous() }}" class="waves-effect waves-light btn">Regresar</a> <br>
	</p>
	<div class="divider"></div>
</div>
<div class="col s12 xl8 offset-xl2">
	<h4>Editar {{ trans_choice('messages.'.$entity, 0) }}</h4>
</div>

<div class="col s12 xl8 offset-xl2">
	<div class="row">
		<form action="{{ companyRoute("update", ['id' => $data->id_perfil,'company' => $company]) }}" method="post" class="col s12">
			{{ csrf_field() }}
			{{ method_field('PUT') }}
			<div class="row">
				<div class="right">
					<button class="btn orange waves-effect waves-light" name="action">Guardar Cambios</button>
					<button class="waves-effect waves-teal btn-flat teal-text">Cancelar</button>
				</div>
			</div><!--/row buttons-->

			<!--Dropdown acciones dropdown-->
			<ul id='exportActions' class='dropdown-content'>
				<li><a href="#!">Exportar a Excel</a></li>
				<li><a href="#!">Exportar a PDF</a></li>
			</ul>

			<div class="row">

				<div class="col s12 m5">
					<h5>Perfil</h5>
					<div class="row">
						<div class="input-field col s12 m7">
							<input id="nombre_perfil" name="nombre_perfil" type="text" class="validate" value="{{$data->nombre_perfil}}">
							<label for="nombre_perfil">Perfil:</label>
						</div>
						<div class="input-field col s12 m5">
							<input id="descripcion" name="descripcion" type="text" class="validate" value="{{$data->descripcion}}">
							<label for="descripcion">Descripción:</label>
						</div>
					</div>

					<div class="row">
						<div class="col s12 m6">
							<label>Usuarios asignados:</label>
							<select multiple>
								<option value="" disabled>Selecciona...</option>
								{{--For usuarios--}}
								@foreach($users as $user)
										<option value="{{$user->id_usuario}}" {{in_array($user->id_usuario,$data->usuarios->pluck('id_usuario')->toArray()) ? 'selected' : ''}}>{{$user->usuario}}</option>
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
													{{--<input type="checkbox" id="{{$empresa->id_empresa}}{{$module->id_modulo}}" />--}}
													{{--<label for="{{$empresa->id_empresa}}{{$module->id_modulo}}" class="parent_checkbox">{{$module->nombre}}</label>--}}
												{{--</div>--}}
												{{--<div class="collapsible-body grey lighten-3">--}}
													{{--<ul class="collection">--}}
														{{--<li class="collection-item">--}}
															{{--<input type="checkbox" id="check1{{$empresa->id_empresa}}{{$module->id_modulo}}" class="fac1_child" checked="checked" />--}}
															{{--<label for="check1{{$empresa->id_empresa}}{{$module->id_modulo}}">Crear</label>--}}
														{{--</li>--}}
														{{--<li class="collection-item">--}}
															{{--<input type="checkbox" id="check2{{$empresa->id_empresa}}{{$module->id_modulo}}" class="fac1_child" checked="checked"/>--}}
															{{--<label for="check2{{$empresa->id_empresa}}{{$module->id_modulo}}">Editar</label>--}}
														{{--</li>--}}
														{{--<li class="collection-item">--}}
															{{--<input type="checkbox" id="check3{{$empresa->id_empresa}}{{$module->id_modulo}}" class="fac1_child" checked="checked" />--}}
															{{--<label for="check3{{$empresa->id_empresa}}{{$module->id_modulo}}">Borrar</label>--}}
														{{--</li>--}}
														{{--<li class="collection-item">--}}
															{{--<input type="checkbox" id="check4{{$empresa->id_empresa}}{{$module->id_modulo}}" class="fac1_child" checked="checked" />--}}
															{{--<label for="check4{{$empresa->id_empresa}}{{$module->id_modulo}}">Ver</label>--}}
														{{--</li>--}}
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

			<!--/modales-->
			<div id="ticketHelp" class="modal modal-fixed-footer">
				<div class="modal-content">
					<h4>Modal Header</h4>
					<p>A bunch of text</p>
				</div>
				<div class="modal-footer">
					<a href="#!" class="modal-action modal-close waves-effect waves-blue darken-4 btn-flat">Agree</a>
				</div>
			</div><!--/Modal de ayuda-->

			<!--Import jQuery before materialize.js-->
			<!--Script para hacer los datos ordenarse-->
			<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
			<script type="text/javascript" src="js/materialize.min.js"></script>
			<!--jquery de dateTables creados-->
			<script type="text/javascript" src="js/InitiateComponents.js"></script>
		</form>
	</div>
</div>
@endsection
