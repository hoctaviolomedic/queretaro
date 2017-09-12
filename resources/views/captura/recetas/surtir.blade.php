
@section('content-width', 's12 m7 xl8 offset-xl2')

@section('header-bottom')
    @parent
    <script type="text/javascript" src="{{asset('js/recetas.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/toaster.js')}}"></script>
@endsection
    @section('title', currentEntityBaseName() . '@Surtir')

    @section('form-title', 'Surtir
     '. str_singular(currentEntityBaseName()))

    @section('form-content')
        {{ Form::setModel($receta) }}
        <div class="container-fluid">
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="localidad">Localidad:</label>
                            <br><label>{{$receta->localidad->localidad}}</label>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="solicitante">Paciente:</label>
                            <br><label>{{!empty($receta->id_afiliacion)?
                            $receta->afiliacion->where('id_dependiente',$receta->id_dependiente)->first()->getFullNameAttribute():
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
                        <br><label>{{$receta->estatus->estatus_receta}}</label>
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
                        <table class="table table-hover table-striped">
                            <thead>
                            <tr>
                                <th>Clave Producto</th>
                                <th>Descripción</th>
                                <th>Última vez surtido</th>
                                <th>Próxima vez surtido</th>
                                <th>Cantidad por surtir</th>
                                <th>Cantidad surtida</th>
                                <th>Cantidad a surtir</th>
                            </tr>
                            </thead>
                            <tbody>
{{--                            {{ dump($receta->detalles()->whereRaw('(recurrente > 0 OR cantidad_surtida < cantidad_pedida)')->toSql()) }}--}}
                            {{--//Por cada receta que sea recurrente--}}
                            @foreach($receta->detalles()->whereRaw('(recurrente > 0 OR cantidad_surtida < cantidad_pedida)')->get() as $detalle)
                                <tr>
                                    <td>{{$detalle->clave_cliente}}</td>
                                    <td>{{$detalle->producto->descripcion}}</td>
                                    <td>{{empty($detalle->fecha_surtido)?'Nunca':$detalle->fecha_surtido}}</td>
                                    <td>{{empty($detalle->fecha_surtido)?'Nunca':$detalle->fecha_surtido}}</td>
                                    <td>{{$detalle->cantidad_pedida}}</td>
                                    <td>{{$detalle->cantidad_surtida}}</td>
                                    <td>
                                        <input type="number" class="form-control" placeholder="Ej: 6">
                                    </td>
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
                        <h4 class="modal-title">Medicamento(s) agotado</h4>
                    </div>
                    <div class="modal-body">
                        <p id="medicamento_modal"></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="candelar" class="btn btn-default" data-dismiss="modal">No</button>
                        <button type="button" id="aceptar" class="btn btn-danger">Sí</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    @endsection

    @include('layouts.smart.create')
