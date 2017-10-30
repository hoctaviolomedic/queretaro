@if(Route::currentRouteNamed(currentRouteName('index')))
	@section('title', 'SURTIDO DE RECETAS')
@endif

@section('content-width', 's12 m7 xl8 offset-xl2')
@section('form-content')
@if(!Route::currentRouteNamed(currentRouteName('index')))
    {{ Form::setModel($data) }}
    <div class="container-fluid">
        <div class="panel-body">
        	@if(isset($data->id_surtido_receta))
            <div class="panel shadow-3 panel-default">
                <div class="panel-heading"><h2 class="panel-title text-center"><b>FOLIO SURTIDO: <span class="text-danger">{{$data->id_surtido_receta ?? null}}</span></b></h2></div>
                <div class="panel-body">
            @endif
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            {{Form::label('id_localidad','* Unidad Medica')}}
                            {{Form::select('id_localidad', $localidades ?? [], $data->receta->id_localidad ?? null, ['id'=>'id_localidad','class' => 'form-control','style'=>'width:100%','data-url'=>companyRoute('getrecetas')])}}
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            {{Form::label('id_receta','* Receta')}}
                            {{Form::select('id_receta', $recetas ?? [], $data->id_receta ?? null, ['id'=>'id_receta','class' => 'form-control','style'=>'width:100%','data-url'=>companyRoute('getrecetadetalle')])}}
                        </div>
                    </div>
                    
                    @if(!Route::currentRouteNamed(currentRouteName('create')))
                    <div class="col-sm-2">
                        <div class="form-group">
                            {{Form::label('id_usuario_creacion','* Surtido Por')}}
                            {{Form::select('id_usuario_creacion', $usuarios ?? [], $data->id_usuario_creacion ?? null, ['id'=>'id_usuario_creacion','class' => 'form-control','style'=>'width:100%','disabled'=>true])}}
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            {{Form::label('fecha_surtido','* Fecha Surtido')}}
                            {{Form::text('fecha_surtido', $data->fecha_surtido ?? null, ['id'=>'fecha_surtido','class' => 'form-control','disabled'=>true])}}
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            {{Form::label('cancelado','* Estatus')}}
                            {{Form::select('cancelado', [0=>'Surtido',1=>'Cancelado'], $data->cancelado ?? 0, ['id'=>'cancelado','class' => 'form-control','disabled'=>true,'style'=>'width:100%'])}}
                        </div>
                    </div>
                    @endif
                    
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            {{Form::label('observaciones','Observaciones adicionales:')}}
                            {{Form::textarea('observaciones',isset($data->observaciones)?$data->observaciones:null,['class' => 'form-control','style'=>'resize:vertical','rows'=>'4','id'=>'observaciones'])}}
                        </div>
                    </div>
                </div>
    		@if(isset($data->id_surtido_receta))
        		</div>
            </div>
        	@endif
            
            @if(!Route::currentRouteNamed(currentRouteName('create')))
            <div class="panel shadow-3 panel-default">
                <div class="panel-heading"><h3 class="panel-title text-center">FOLIO RECETA: <b class="text-danger">{{$data->receta->folio ?? null}}</b></h3></div>
                <div class="panel-body">
            		<div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                {{Form::label('id_area','Area')}}
                                {{Form::select('id_area', $areas ?? [], $data->receta->id_area ?? null, ['id'=>'id_area','class' => 'form-control','style'=>'width:100%'])}}
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                {{Form::label('id_medico','* Medico')}}
                                {{Form::select('id_medico',$medicos ?? [], $data->receta->id_medico ?? null, ['id'=>'id_medico','class' => 'form-control','style'=>'width:100%'])}}
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                {{Form::label('id_programa','*Programa')}}
                                {{Form::select('id_programa', $programas ?? [], $data->receta->id_programa ?? null, ['id'=>'id_programa','class' => 'form-control','style'=>'width:100%'])}}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2 col-sm-12">
                            <div class="form-group">
                                {{Form::label('tipo-servicio','*Tipo de servicio')}}
                                <div class="input-group-btn" role="group" aria-label="tipo_servicio" data-toggle="buttons">
                                    <label class="btn btn-check btn-default {{!empty($data->receta->id_afiliacion) ? 'active' : ''}}">
                                        <input type="radio" name="tipo_servicio" checked="checked" autocomplete="off" value="afiliado" class="btn btn-default">Afiliado
                                    </label>
                                    <label class="btn btn-check btn-default {{empty($data->receta->id_afiliacion) ? 'active' : ''}}">
                                        <input type="radio" name="tipo_servicio" autocomplete="off" value="externo" class="btn btn-default">Externo
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                {{Form::label('id_dependiente','* Afiliacion/Paciente')}}
                                @if(empty($data->receta->id_afiliacion))
                                	{{Form::text('nombre_paciente',$data->receta->nombre_paciente_no_afiliado ?? null, ['id'=>'nombre_paciente','class' =>'form-control'])}}
                                @else
                                    @if(empty($data->receta->id_dependiente))
                                    	{{Form::select('id_afiliacion',$afiliaciones ?? [], $data->receta->id_afiliacion ?? null ,['id'=>'id_afiliacion','class' => 'form-control','style'=>'width:100%'])}}
                                    @else
                                        {{Form::select('id_dependiente',$dependientes ?? [], $data->receta->id_dependiente ?? null ,['id'=>'id_dependiente','class' => 'form-control','style'=>'width:100%'])}}
                                    @endif
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                {{Form::label('id_diagnostico','* Diagnostico')}}
                				{{Form::select('id_diagnostico',$diagnosticos ?? [], $data->receta->id_diagnostico, ['id'=>'id_diagnostico','class' => 'form-control','style'=>'width:100%'])}}
                            </div>
                        </div>
                    </div>
				</div>
            </div>
            @endif
        
            <div class="panel shadow-3 panel-default">
                <div class="panel-heading"><h3 class="panel-title text-center">PRODUCTOS SURTIDOS</h3></div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-12 table-responsive">
                            <table class="table table-hover" id="detalle" >
                                <thead>
                                    <tr>
                                        <th>Clave Producto</th>
                                        <th>Descripcion Producto</th>
                                        <th>Cantidad Recetada</th>
                                        @if(Route::currentRouteNamed(currentRouteName('create')))
                                        	<th>Cantidad Surtida</th>
                                        	<th>Cantidad Disponible</th>
                                        @endif
                                        <th>Cantidad {{ Route::currentRouteNamed(currentRouteName('create')) ? 'a Surtir' : 'Surtida' }}</th>
                                        <th>Precio Unitario</th>
                                        <th style="min-height: 300px !important;">Importe</th>
                                    </tr>
                                </thead>
                                <tbody class="medicine_detail">
                                <?php $total = 0; ?>
                                @if(isset($data->detalles))
                                    @foreach($data->detalles as $detalle)
                                    	<tr> 
                                            <td>{{$detalle->recetadetalle->clave_cliente ?? null}}</td>
                                            <td>{{$detalle->recetadetalle->producto->descripcion ?? null}}</td>
                                            <td class="text-center">{{$detalle->recetadetalle->cantidad_pedida ?? null}}</td>
                                            @if(Route::currentRouteNamed(currentRouteName('create')))
                                            	<td class="text-center">{{$detalle->cantidad_surtida ?? null}}</td>
                                            	<td class="text-center">{{$detalle->cantidad_disponible ?? null}}</td>
                                            @endif
                                            <td class="text-center">{{$detalle->cantidad_surtida ?? null}}</td>
                                            <td class="text-right">{{$detalle->precio_unitario ?? null}}</td>
                                            <td class="text-right">{{$importe = (($detalle->precio_unitario ?? 0) * ($detalle->cantidad_surtida ?? 0))}}</td>
                                        </tr>
                                        <?php $total = $total+$importe; ?>
                                    @endforeach
                                @endif
                                </tbody>
                                <tfoot>
                                	<tr>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        @if(Route::currentRouteNamed(currentRouteName('create')))
                                        	<th></th>
                                        	<th></th>
                                        @endif
                                        <th></th>
                                        <th class="text-right">TOTAL:</th>
                                        <th class="text-right" id="total">$ {{$total}}</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
            	</div>
            </div><!--/panel-->
            
            @if(!Route::currentRouteNamed(currentRouteName('create')) && $data->cancelado)
            <div class="panel shadow-3 panel-default">
                <div class="panel-heading"><h3 class="panel-title text-center">INFORMACION DE CANCELACION DE SURTIDO</h3></div>
                <div class="panel-body">
                    <div class="row">
                    	<div class="col-sm-2">
                            <div class="form-group">
                                {{Form::label('id_usuario_cancelado','Cancelado Por:')}}
                                {{Form::select('id_usuario_cancelado', $usuarios ?? [], $data->id_usuario_cancelado ?? null, ['id'=>'id_usuario_cancelado','class' => 'form-control','style'=>'width:100%','disabled'=>true])}}
                            </div>
                             <div class="form-group">
                                {{Form::label('fecha_cancelado','Fecha Cancelacion:')}}
                                {{Form::text('fecha_cancelado', $data->fecha_cancelado ?? null, ['class'=>'form-control','id'=>'fecha_cancelado','disabled'=>true])}}
                            </div>
                        </div>
                    	<div class="col-sm-10">
                            <div class="form-group">
                                {{Form::label('motivo_cancelado','Motivo Cancelacion:')}}
                                {{Form::textarea('motivo_cancelado', $data->motivo_cancelado ?? null, ['class'=>'form-control','style'=>'resize:vertical','rows'=>'5','id'=>'motivo_cancelado','disabled'=>!Route::currentRouteNamed(currentRouteName('edit'))])}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            
            @if(Route::currentRouteNamed(currentRouteName('show')))
                <div class="row">
                    <div class="col-sm-12 text-center">
                        <a href="{{companyAction('imprimir',['id'=>$data->id_surtido_receta])}}" role="button" class="btn btn-default gotUndisable"><span class="glyphicon glyphicon-print"></span> Imprimir</a>
                    </div>
                </div><!--/row-->
            @endif
    	</div><!--/panel-body-->
    </div>
@endif
@endsection

@section('header-bottom')
	@parent
    @if(Route::currentRouteNamed(currentRouteName('create')))
        <script type="text/javascript">
            $(document).ready(function () {
            	/*window.dataTable = new DataTable('#detalle', {
                	header: true,
                    fixedHeight: true,
                    fixedColumns: false,
                    searchable: false,
                    perPageSelect: false,
                    //labels:{ info: "Mostrando del registro {start} al {end} de {rows}" },
                });*/
                
                $('#id_localidad').select2();
                $('#id_receta').select2();

                $('#id_localidad').on('change', function() {
                    $.ajax({
                        type: "GET",
                        url: $(this).data('url'),
                        data: 'id_localidad='+$(this).val(),
                        dataType: "json",
                        success:function(data) {
                            $('#id_receta').empty();
                            $.each(data, function(key, value) {
                                $('#id_receta').append('<option value="'+ key +'">'+ value +'</option>');
                            });
                            $('#id_receta').val('');
                        }
                    });
                });

                $('#id_receta').on('change', function() {
                	if (!$(this).is(":empty")) {
                		$('#detalle tbody tr').remove();

                		$.ajax({
                            type: "GET",
                            url: $('#id_receta').data('url'),
                            data: 'id_receta='+$(this).val(),
                            dataType: "json",
                            success:function(data) {
                            	$.each(data, function(key,values) {
                                	$('#detalle tbody').append('<tr>'+
										'<td>'+
											'<input type="hidden" name="detalle['+key+'][id_receta_detalle]" value="'+values.id_receta_detalle+'">'+
											'<input type="hidden" name="detalle['+key+'][precio_unitario]" value="'+values.precio+'" class="precio">'+
											'<input type="hidden" name="detalle['+key+'][importe]" value="'+values.precio+'" class="importe">'+
											values.clave_cliente+'</td>'+
										'<td>'+values.descripcion+'</td>'+
										'<td>'+values.cantidad_pedida+'</td>'+
										'<td>'+values.cantidad_surtida+'</td>'+
										'<td>'+values.disponible+'</td>'+
										'<td><input type="number" onchange="calculatotal(this)" name="detalle['+key+'][cantidad_surtida]" min="0" max="'+(values.cantidad_pedida - values.cantidad_surtida)+'" class="form-control cantidad"></td>'+
										'<td class="text-right">$ '+parseFloat(values.precio, 10).toFixed(2)+'</td>'+
										'<td class="text-right total">$ '+parseFloat(0, 10).toFixed(2)+'</td>'+
                                	'</tr>');
                            	})
                            }
                        });
                    }
                });


                $('#id_localidad').trigger("change");
            });
            function calculatotal(el) {
				var cantidad = $(el).val();
                var precio = $(el).parent().parent().find('.precio').val();

                $(el).parent().parent().find('.importe').val(cantidad*precio);
                $(el).parent().parent().find('.total').html('$ '+parseFloat((cantidad*precio), 10).toFixed(2));

				var total = 0;
				$('.importe').each(function (i) {
					total += $('.precio')[i].value * $('.cantidad')[i].value;
				});
				
                $('#total').html('$ '+parseFloat(total, 10).toFixed(2));
            };
        </script>
    @endif
@endsection

{{-- DONT DELETE --}}
@if(Route::currentRouteNamed(currentRouteName('index')))
	@include('layouts.smart.index')
@endif

@if(Route::currentRouteNamed(currentRouteName('create')))
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