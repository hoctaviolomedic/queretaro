
@section('content-width', 's12 m12')

@section('fieldset', '')

@section('header-bottom')
	@parent
	<script type="text/javascript" src="{{ asset('js/seguimiento.js') }}"></script>
@endsection

@section('form-title')
    {{ HTML::tag('h4', 'Datos de la '. str_singular(currentEntityBaseName())) }}
@endsection

@section('form-header')
@if(Route::currentRouteNamed(currentRouteName('show')))
    {!! Form::open(['method'=>'put', 'url' => companyRoute('update'), 'id' => 'form-model', 'class' => 'col s12 m12']) !!}
@endif
@endsection

@section('form-actions')
@if(Route::currentRouteNamed(currentRouteName('show')))
	<div class="row">
		<div class="right">
			{{ link_to(companyRoute('index'), 'Cerrar', ['class'=>'waves-effect waves-teal btn']) }}
		</div>
	</div>
@endif
@endsection

@section('form-content')
	@if(!Route::currentRouteNamed(currentRouteName('index')) && !Route::currentRouteNamed(currentRouteName('export')))
        <div class="row">
        	<div class="col s12 m6 ">
        		<h5 class="grey-text text-darken-2">{{ (isset($data->empleado) ? $data->empleado->nombre.' '.$data->empleado->apellido_paterno.' '.$data->empleado->apellido_materno : '') }}</h5>
        	</div>
        	<div class="col s6 m3">
        		<h5 class="{{isset($data->prioridad->color) ? $data->prioridad->color.'-text': ''}} text-darken-2 facturas-line">
        			Prioridad {{isset($data->prioridad->prioridad) ? $data->prioridad->prioridad : ''}} 
        			<i class="material-icons">{{isset($data->prioridad->icono) ? $data->prioridad->icono : ''}}</i><br>
        			<span class="green-text">Estatus. Abierto</span>
        		</h5>
        	</div>
        	<div class="col s6 m3">
        		<h5 class="grey-text text-darken-2 facturas-line">Ticket No. {{isset($data->id_solicitud) ? $data->id_solicitud : ''}}<br>
        			<span><i class="tiny material-icons">today</i> {{isset($data->fecha_hora_creacion) ? $data->fecha_hora_creacion : ''}}</span>
        		</h5>
        	</div>
        </div>
        
    	<div class="col s12 m6">
        	<h5>Datos del ticket</h5>
        	<div class="row card-panel teal lighten-5">	
        		<div class="row">
        			<p><b>Asunto:</b> {{isset($data->asunto) ? $data->asunto : ''}}.</p>
        			<p><b>Descripción:</b></p>
        			<p>{{isset($data->descripcion) ? $data->descripcion : ''}}</p>
        		</div>
        	</div>
    		@if(isset($attachments) && count($attachments) > 0)
    		<ul class="collapsible collapsible-accordion no-padding row">
                <li>
                    <a class="collapsible-header">Archivos Adjuntos <i class="material-icons right">arrow_drop_down</i></a>
                    <div class="collapsible-body">
                        <ul>
                            @foreach($attachments as $archivo_adjunto)
                            <li><a href="{{companyAction('descargarArchivosAdjuntos', ['id' => $archivo_adjunto->id_archivo_adjunto])}}">
                            	<i class="material-icons">attachment</i>{{$archivo_adjunto->nombre_archivo}}
                            </a></li>
                            @endforeach
                        </ul>
                    </div>
                </li>
            </ul>
    		@endif
        	
        </div>
    
    	
        @if( $data->fk_id_empleado_tecnico == Auth::id() || $data->fk_id_empleado_tecnico == null) {{--Si es el técnico asignado--}}
        	{{ Form::setModel($data) }}
            <div class="col s12 m6">
            	<div class="row">
            		<div class="col s12 m12 l6">
                		{{ Form::label('fk_id_impacto', '* Impacto') }}
            			{{ Form::select('fk_id_impacto', (isset($impacts) ? $impacts : []), ['id'=>'fk_id_impacto','class'=>'validate','readonly'=>$data->resolucion === null]) }}
                		{{ $errors->has('fk_id_impacto') ? HTML::tag('span', $errors->first('fk_id_impacto'), ['class'=>'help-block deep-orange-text']) : '' }}
            		</div>
            		<div class="col s12 m12 l6">
                		{{ Form::label('fk_id_urgencia', '* Urgencia') }}
            			{{ Form::select('fk_id_urgencia', (isset($urgencies) ? $urgencies : []), ['id'=>'fk_id_urgencia','class'=>'validate','readonly'=>$data->resolucion === null]) }}
                		{{ $errors->has('fk_id_urgencia') ? HTML::tag('span', $errors->first('fk_id_urgencia'), ['class'=>'help-block deep-orange-text']) : '' }}
            		</div>
            	</div>
            	
            	<div class="row">
            		<div class="col s12 m12 l6">
                		{{ Form::label('fk_id_empleado_tecnico', '* Tecnico Asignado') }}
            			{{ Form::select('fk_id_empleado_tecnico', (isset($employees) ? $employees : []), ['id'=>'fk_id_empleado_tecnico','class'=>'validate','readonly'=>$data->resolucion === null]) }}
                		{{ $errors->has('fk_id_empleado_tecnico') ? HTML::tag('span', $errors->first('fk_id_empleado_tecnico'), ['class'=>'help-block deep-orange-text']) : '' }}
            		</div>
            		<div class="col s12 m12 l6">
                		{{ Form::label('fk_id_categoria', '* Categoria') }}
            			{{ Form::select('fk_id_categoria', (isset($categorys) ? $categorys : []), ['id'=>'fk_id_categoria','class'=>'validate','readonly'=>$data->resolucion === null]) }}
                		{{ $errors->has('fk_id_categoria') ? HTML::tag('span', $errors->first('fk_id_categoria'), ['class'=>'help-block deep-orange-text']) : '' }}
            		</div>
            	</div>
            	
            	<div class="row">
            		<div class="col s12 m12 l6">
                		{{ Form::label('fk_id_subcategoria', '* Subcategoria') }}
            			{{ Form::select('fk_id_subcategoria', (isset($subcategorys) ? $subcategorys : []), ['id'=>'fk_id_subcategoria','class'=>'validate']) }}
                		{{ $errors->has('fk_id_subcategoria') ? HTML::tag('span', $errors->first('fk_id_subcategoria'), ['class'=>'help-block deep-orange-text']) : '' }}
            		</div>
            		<div class="col s12 m12 l6">
                		{{ Form::label('fk_id_accion', '* Accion') }}
            			{{ Form::select('fk_id_accion', (isset($acctions) ? $acctions : []), ['id'=>'fk_id_accion','class'=>'validate']) }}
                		{{ $errors->has('fk_id_accion') ? HTML::tag('span', $errors->first('fk_id_accion'), ['class'=>'help-block deep-orange-text']) : '' }}
            		</div>
            	</div>
            </div>
            <div class="row">
            	<div class="row">
            		{{ Form::checkbox('solucion', null, old('solucion'), ['id'=>'solucion','onclick'=>"descripcion()"]) }}
            		{{ Form::label('solucion', '¿Solucionado?') }}
            		{{ $errors->has('solucion') ?  HTML::tag('span', $errors->first('solucion'), ['class'=>'help-block deep-orange-text']) : '' }}
            		{{ Form::hidden('solucion', 0) }}
            	</div>	
            	<div class="row">
            		{{ Form::label('resolucion', 'Descripción de resolución:') }}
            		{{ Form::textarea('resolucion', null, ['class'=>'validate materialize-textarea','id'=>'resolucion','readonly'=>'true']) }}
                </div>
            	<div class="row">
                	<div class="col s12 right-align">
            			{{ Form::button('Guardar', ['type' =>'submit', 'class'=>'waves-effect waves-light btn orange']) }}
                	</div>
            	</div>
        	</div>
        	
        	
        	
        @elseif($employee_department != 18 || $data->fk_id_empleado_tecnico != Auth::id()) {{--Si no es el técnico asignado y no pertenece a sistemas, no podrá editar los valores--}}
        	<div class="col s12 m6">
        		{{ HTML::tag('h5', 'Datos adicionales del ticket') }}
        		<div class="row">
            		<div class="col s12 m12 l6">
                		{{ Form::label('fk_id_impacto', '* Impacto') }}
                		{{ HTML::tag('h6', $data->impacto->impacto) }}
            		</div>
            		<div class="col s12 m12 l6">
                		{{ Form::label('fk_id_urgencia', '* Urgencia') }}
            			{{ HTML::tag('h6', $data->urgencia->urgencia) }}
            		</div>
            	</div>
        	
        		<div class="row">
            		<div class="col s12 m12 l6">
                		{{ Form::label('fk_id_empleado_tecnico', '* Tecnico Asignado') }}
                		{{ HTML::tag('h6', $data->a_tecnico) }}
            		</div>
            		<div class="col s12 m12 l6">
                		{{ Form::label('fk_id_categoria', '* Categoria') }}
                		{{ HTML::tag('h6', $data->a_categoria) }}
            		</div>
            	</div>
            	
            	<div class="row">
            		<div class="col s12 m12 l6">
                		{{ Form::label('fk_id_subcategoria', '* Subcategoria') }}
                		{{ HTML::tag('h6', $data->subcategoria->subcategoria) }}
            		</div>
            		<div class="col s12 m12 l6">
                		{{ Form::label('fk_id_accion', '* Accion') }}
                		{{ HTML::tag('h6', $data->accion->accion) }}
            		</div>
            	</div>
            </div>
            <div class="row">
            	<div class="row">
            		{{ Form::label('resolucion', 'Descripción de resolución:') }}
            		{{ HTML::tag('h6', isset($data->resolucion) ? $data->resolucion : '') }}
                </div>
        	</div>
        @endif
        
    @endif
@endsection

@section('form-utils')
    @if(!Route::currentRouteNamed(currentRouteName('index')) && !Route::currentRouteNamed(currentRouteName('export')))
        @if(Auth::id() == $data->fk_id_tecnico_asignado || Auth::id() == $data->fk_id_empleado_solicitud)
        	<ul class="collection with-header" style="padding:10px; border:none;">{{--Conversacion--}}
        		<a href="#modal-1" class="prefix btn-large blue right">Responder</a>
        		<li class="collection-header"><h4>Conversación.</h4></li>
        		
        		<span style='display:none'>{{ $i = 0 }}</span> 
        		
        		@foreach($conversations as $seguimiento)
        		<span style='display:none'>{{ $i++ }}</span>
        		<li class="collection-item avatar lighten-5 {{$i % 2 != 0 ? 'teal' : ''}}">
        			<i class="material-icons circle {{$seguimiento->fk_id_empleado_comentario == $data->fk_id_empleado_tecnico ? 'brown' : ''}}">person</i>
        			<div class="title {{$seguimiento->fk_id_empleado_comentario == $data->fk_id_empleado_tecnico ? 'brown-text' : ''}}">
            			<span class="col s12 m7">
            				<b>{{ $seguimiento->empleado->nombre.' '.$seguimiento->empleado->apellido_paterno.' '.$seguimiento->empleado->apellido_materno}}</b>
            			</span>
            			<span class='col s12 m5 right-align'><i class="material-icons tiny">event</i>{{ $seguimiento->fecha_hora}}</span>
            		</div>
        			<p><b>{{$seguimiento->asunto}}</b></p>
        			<p>{{$seguimiento->comentario}}</p>
        			
        			@if(count($seguimiento->archivo_adjunto) > 0)
        			<div class="row">
        			<ul class="collapsible collapsible-accordion no-padding col s12 m8 l6 xl4">
                        <li>
                            <a class="collapsible-header">Archivos Adjuntos <i class="material-icons right">arrow_drop_down</i></a>
                            <div class="collapsible-body">
                                <ul>
                                    @foreach($seguimiento->archivo_adjunto as $archivo_adjunto)
                                    <li><a href="{{companyAction('descargarArchivosAdjuntos', ['id' => $archivo_adjunto->id_archivo_adjunto])}}">
                                    	<i class="material-icons">attachment</i>{{$archivo_adjunto->nombre_archivo}}
                                    </a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </li>
                    </ul>
                    </div>
        			@endif
        		</li>
        		@endforeach
        		<a href="#modal-1" class="prefix btn-large blue right">Responder</a>
        		
        		<div id="modal-1" class="modal bottom-sheet">
            		<li class="collection-item avatar row">
            		<i class="material-icons circle">person</i>
            		<span class="title"><b>{{$data->empleado->nombre.' '.$data->empleado->apellido_paterno.' '.$data->empleado->apellido_materno}}</b></span>
            		
            		{!! Form::open(['url' => companyAction('Soporte\SeguimientoSolicitudesController@index'), 'id' => 'form-model', 'class' => 'col s12 m18','enctype'=>'multipart/form-data']) !!}
            			{{ Form::hidden('fk_id_solicitud', $data->id_solicitud,['id'=>'fk_id_solicitud']) }}
            			{{ Form::hidden('fk_id_empleado_comentario', Null,['id'=>'fk_id_empleado_comentario','data-url'=>companyAction('RecursosHumanos\EmpleadosController@obtenerEmpleado')]) }}
                		<div class="input-field col s12 m12 l6 xl4">
                			{{ Form::text('asunto', '', ['class'=>'validate']) }}
                    		{{ Form::label('asunto', 'Asunto') }}
                    		{{ $errors->has('asunto') ? HTML::tag('span', $errors->first('asunto'), ['class'=>'help-block deep-orange-text']) : '' }}
        				</div>
                		
                		<div class="file-field input-field col s12 m12 l6 xl8">
                			<div class="btn">
                				<span><i class="material-icons">attach_file</i> Archivos</span>
                				{{ Form::file('archivo[]', ['id'=>'archivo','multiple']) }}
                			</div>
                			<div class="file-path-wrapper">
                				<input class="file-path validate" type="text" placeholder="Anexa uno o más archivos">
                			</div>
                		</div>
                		
                		<div class="input-field col s12">
                			{{ Form::textarea('comentario', null, ['class'=>'validate materialize-textarea']) }}
                    		{{ Form::label('comentario', 'Comentario') }}
                    		{{ $errors->has('comentario') ? HTML::tag('span', $errors->first('comentario'), ['class'=>'help-block deep-orange-text']) : '' }}
                		</div>
                		<div class="file-field input-field col s12">
                			<button class="btn waves-effect waves-light right blue darken-1">Enviar</button>
                		</div>
            		{!! Form::close() !!}
            		</li>
        		</div>
        	</ul>
        @endif
    @endif
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