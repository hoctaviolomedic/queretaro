
@section('content-width', 's12 m7 xl8 offset-xl2')

@section('header-bottom')
    @parent
    <script type="text/javascript" src="{{asset('js/surtirReceta.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/toaster.js')}}"></script>
@endsection
    @section('title', currentEntityBaseName() . '@Surtir')

    @section('form-title', 'Surtir
     '. str_singular(currentEntityBaseName()))

    @section('form-content')
        {{ Form::setModel($receta) }}
        <div class="container-fluid" id="container-fluid"  data-url="{{companyRoute('surtir',['id'=>$receta->id_receta])}}">
            <div class="panel-body">
                <div class="row text-center">
                    <div class="form-group">
                        <label for="folio">Receta:</label>
                        <label>{{$receta->id_receta}}</label>
                        <label for="folio">Folio:</label>
                        <label>{{$receta->folio}}</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="localidad">Localidad:</label>
                            <br><label>{{$receta->localidad->localidad}}</label>
                            <input type="hidden" name="id_localidad" id="id_localidad" value="{{$receta->id_localidad}}">
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="solicitante">Paciente:</label>
                            <br><label>{{!empty($receta->id_dependiente) && !empty($receta->id_afiliacion)?
                            $receta->afiliacion->where('id_dependiente',$receta->id_dependiente)->where('id_afiliacion',$receta->id_afiliacion)->first()->getFullNameAttribute():
                            $receta->nombre_paciente_no_afiliado}}</label>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="solicitante">Médico:</label>
                            <br><label>{{$receta->medico->first()->getNombreCompletoAttribute()}}</label>
                        </div>
                    </div>
                    <div class="col-sm-1 col-xs-6">
                        <label>*Estatus:</label>
                        {{--@if($receta->detalles()->whereRaw('(recurrente > 0 OR cantidad_surtida < cantidad_pedida)')->get() == null)--}}
                            <br><label>{{$receta->estatus->estatus_receta}}</label>
                        {{--@else--}}
                            {{--<br><label>Surtido</label>--}}
                        {{--@endif--}}
                    </div>
                    <div class="col-sm-2 col-xs-6">
                        <div class="form-group">
                            <label for="fecha">Fecha Expedición:</label>
                            <br><label>{{$receta->fecha}}</label>
                            </div><!-- /input-group -->
                        </div>
                    </div>
                </div>

                <div class="divider"></div>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-hover table-striped table-responsive" id="detalle" data-url="{{companyRoute('verifyStockSurtir')}}">
                            <thead>
                            <tr>
                                <th>Clave Producto</th>
                                <th>Descripción</th>
                                <th>Última vez surtido</th>
                                <th>Próxima vez surtido</th>
                                <th>Cantidad por surtir</th>
                                <th>Cantidad surtida</th>
                                <th>Cantidad a surtir</th>
                                <th>Veces por surtir</th>
                                <th>Veces surtidas</th>
                            </tr>
                            </thead>
                            <tbody>
{{--                            {{ dump($receta->detalles()->whereRaw('(recurrente > 0 OR cantidad_surtida < cantidad_pedida)')->toSql()) }}--}}
                            {{--//Por cada receta que sea recurrente--}}
                            @foreach($receta->detalles()->whereRaw('(recurrente > 0 OR cantidad_surtida < cantidad_pedida)')->get() as $detalle)
                                <tr id="{{$detalle->id_receta_detalle}}" title="{{$detalle->clave_cliente}}">
                                    <td>
                                        {{$detalle->clave_cliente}}
                                        <input type="hidden" name="detalle[{{$detalle->id_receta_detalle}}][id_receta_detalle]" value="{{$detalle->id_receta_detalle}}">
                                        <input type="hidden" name="detalle[{{$detalle->id_receta_detalle}}][clave_cliente]" value="{{$detalle->clave_cliente}}">
                                    </td>
                                    <td>{{$detalle->producto->descripcion}}<input type="hidden" id="descripcion{{$detalle->id_receta_detalle}}" value="{{$detalle->producto->descripcion}}"></td>
                                    <td>{{empty($detalle->fecha_surtido)?'Nunca':$detalle->fecha_surtido}}</td>
                                    <td>{{empty($detalle->fecha_surtido)?DB::select("select date 'now()' + integer '" . $detalle->recurrente . "' as diferencia")[0]->diferencia:DB::select("select date '" . $detalle->fecha_surtido . "' + integer '" . $detalle->recurrente . "' as diferencia")[0]->diferencia}}</td>
                                    <td>{{$detalle->cantidad_pedida}}<input type="hidden" id="cantidad_pedida{{$detalle->id_receta_detalle}}" value="{{$detalle->cantidad_pedida}}"></td>
                                    <td>
                                        {{$detalle->cantidad_surtida}}
                                        <input type="hidden" id="cantidad_surtida{{$detalle->id_receta_detalle}}" value="{{$detalle->cantidad_surtida}}">
                                    </td>
                                    <td>
                                        @if($detalle->veces_surtir > $detalle->veces_surtidas)
                                            <input type="number" class="form-control number-only" min="0" placeholder="Ej: 6" id="cantidadsurtir{{$detalle->id_receta_detalle}}" name="detalle[{{$detalle->id_receta_detalle}}][cantidadsurtir]">
                                        @else
                                            <input type="hidden" id="cantidadsurtir{{$detalle->id_receta_detalle}}" name="detalle[{{$detalle->id_receta_detalle}}][cantidadsurtir]" value="0">
                                            <label>Producto entregado en su totalidad</label>
                                        @endif
                                    </td>
                                    <td>
                                        {{$detalle->veces_surtir}}
                                        <input type="hidden" id="veces_surtir{{$detalle->id_receta_detalle}}" value="{{$detalle->veces_surtir}}">
                                    </td>
                                    <td>{{empty($detalle->veces_surtidas)?0:$detalle->veces_surtidas}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div><!--/panel-body-->
        </div>

        <div class="modal fade" tabindex="-1" role="dialog" id="modal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Medicamento(s) agotado(s) o insuficiente(s)</h4>
                    </div>
                    <div class="modal-body">
                        <p id="medicamento_modal"></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="candelar" class="btn btn-default" data-dismiss="modal">De acuerdo</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    @endsection

    @include('layouts.smart.create')
