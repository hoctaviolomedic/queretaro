
@section('content-width', 's12 m7 xl8 offset-xl2')
@section('form-content')
{{ Form::setModel($data) }}


@if (Route::currentRouteNamed(currentRouteName('create')))

    {{--<input type="hidden" name="id_requerimiento" value="3">--}}
    <input type="hidden" name="fecha_captura" value="{{date('Y-m-d h:i:s')}}">
    <input type="hidden" name="id_usuario_captura" value="2">
    <input type="hidden" name="tipo_producto" value="2">
    <input type="hidden" name="inventario" value="0">


            <div class="panel-heading">
                <h3 class="panel-title text-center">Captura de Requisiciones Hospitalarias - SP DF</h3>
            </div>
            <div class="panel-body">

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            {{--{{dd($localidades)}}--}}
                            {{ Form::label('id_localidad', 'Localidad:') }}
                            {!! Form::select('id_localidad',$localidades , null, ['placeholder' => 'Seleccionar una localidad...','id'=>'id_localidad','class'=>'js-data-example-ajax1 form-control','style'=>'100%','data-url'=>companyRoute('getAreas')]) !!}
                            {{ $errors->has('id_localidad') ? HTML::tag('span', $errors->first('id_localidad'), ['class'=>'help-block deep-orange-text']) : '' }}
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            {{ Form::label('id_usuario_surtido', 'Solicitante:') }}
                            {{ Form::select('id_usuario_surtido',[], null, ['id'=>'id_usuario_surtido','class'=>'js-data-example-ajax1 form-control','style'=>'100%','data-url'=>companyRoute('getAreas')]) }}
                            {{ $errors->has('id_usuario_surtido') ? HTML::tag('span', $errors->first('id_usuario_surtido'), ['class'=>'help-block deep-orange-text']) : '' }}
                        </div>
                    </div>
                    <div class="col-sm-2 col-xs-6">
                        <label>*Estatus:</label>
                        <select class="form-control" name="estatus">
                            <option value="1">Surtido</option>
                            <option value="2">No surtido</option>
                            <option value="3">Parcialmente surtido</option>
                            <option value="4">Cancelado</option>
                        </select>
                    </div>
                    <div class="col-sm-2 col-xs-6">
                        <div class="form-group">
                            <label for="fecha">*Fecha:</label>
                            <div id="datetimepicker3" class="input-group">
                                <input type="text" class="form-control" name="fecha_requerimiento" data-format="yyyy-MM-dd">
                                <span class="input-group-btn add-on">
                                <button data-date-icon="icon-calendar" class="btn btn-check" type="button"><span class="glyphicon glyphicon-calendar"></span></button>
                              </span>
                            </div><!-- /input-group -->
                        </div>
                    </div>
                </div><!--/row-->

                <div class="divider"></div>

                <div class="row">
                    <div class="col-sm-3 col-xs-8">
                        <div class="form-group">
                            {{ Form::label('id_area', 'Área:') }}
                            {{ Form::select('id_area',[], null, ['class'=>'js-data-example-ajax1 form-control','style'=>'100%','data-url'=>companyRoute('getAreas')]) }}
                            {{--{{Form::select('medicamento',[],null,['id'=>'medicamento','class' => 'medicamento form-control','data-url'=>companyRoute('getMedicamentos')])}}--}}
                            {{ $errors->has('id_area') ? HTML::tag('span', $errors->first('id_area'), ['class'=>'help-block deep-orange-text']) : '' }}
                        </div>
                    </div>
                    <div class="col-sm-7 col-xs-12">
                        {{ Form::label('producto', 'Producto:') }}
                        {{ Form::select('producto', [], null, ['id'=>'producto','class'=>'js-data-example-ajax1 form-control','style'=>'100%']) }}
                        {{ $errors->has('producto') ? HTML::tag('span', $errors->first('producto'), ['class'=>'help-block deep-orange-text']) : '' }}
                    </div>
                    <div class="col-sm-2 col-xs-4">
                        <div class="form-group">
                            <label for="cantidad">*Cantidad:</label>
                            <input type="number" class="form-control" id="cantidad" placeholder="Ej: 6">
                        </div>
                    </div>
                    <div class="col-sm-12 text-center">
                        <button type="button" class="btn btn-default" onclick="agregarProducto()"><span class="glyphicon glyphicon-plus" aria-hidden="true" ></span> Agregar</button>
                    </div>
                </div><!--/row-->

                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-hover table-striped">
                            <thead>
                            <tr>
                                <th>Área</th>
                                <th>Producto</th>
                                <th>cantidad</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody id="lista_productos">

                            {{--<tr>--}}
                                {{--<th scope="row">1</th>--}}
                                {{--<td>123456</td>--}}
                                {{--<td>PARACETAMOL 500MG</td>--}}
                                {{--<td>12</td>--}}
                                {{--<td>12</td>--}}
                                {{--<td>--}}
                                    {{--<div class="input-group">--}}
                                        {{--<input type="number" class="form-control" placeholder="Ej: 6">--}}
                                        {{--<span class="input-group-btn">--}}
                                            {{--<button class="btn btn-default btn-check" type="button">Aceptar</button>--}}
                                            {{--</span>--}}
                                    {{--</div><!-- /input-group -->--}}
                                {{--</td>--}}
                            {{--</tr>--}}

                            </tbody>
                        </table>
                    </div>
                </div>
            </div><!--/panel-body-->

@endif

@if (Route::currentRouteNamed(currentRouteName('show')))

    {{--<input type="hidden" name="id_requerimiento" value="3">--}}
    <input type="hidden" name="fecha_captura" value="{{date('Y-m-d h:i:s')}}">
    <input type="hidden" name="id_usuario_captura" value="2">
    <input type="hidden" name="tipo_producto" value="2">
    <input type="hidden" name="inventario" value="0">


    {{--<div class="panel-heading">--}}
        {{--<h3 class="panel-title text-center">Captura de Requisiciones Hospitalarias - SP DF</h3>--}}
    {{--</div>--}}
    <div class="panel-body">

        <div class="row">
            <div class="col-sm-4">
                <div class="form-group">
                    {{ Form::label('id_localidad', 'Localidad:') }}
                    {{ Form::select('id_localidad', $localidades, null, ['id'=>'id_localidad','class'=>'js-data-example-ajax1 form-control','style'=>'100%']) }}
                    {{--{{ $errors->has('id_localidad') ? HTML::tag('span', $errors->first('id_localidad'), ['class'=>'help-block deep-orange-text']) : '' }}--}}
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    {{ Form::label('id_usuario_surtido', 'Solicitante:') }}
                    {{ Form::select('id_usuario_surtido', $solicitante, null, ['id'=>'id_usuario_surtido','class'=>'js-data-example-ajax1 form-control','style'=>'100%']) }}
                    {{ $errors->has('id_usuario_surtido') ? HTML::tag('span', $errors->first('id_usuario_surtido'), ['class'=>'help-block deep-orange-text']) : '' }}
                </div>
            </div>
            <div class="col-sm-2 col-xs-6">
                <label>*Estatus:</label>
                <select class="form-control" name="estatus">
                    <option value="1">Surtido</option>
                    <option value="2">No surtido</option>
                    <option value="3">Parcialmente surtido</option>
                    <option value="4">Cancelado</option>
                </select>
            </div>
            <div class="col-sm-2 col-xs-6">
                <div class="form-group">
                    <label for="fecha">*Fecha:</label>
                    <div id="datetimepicker3" class="input-group">
                        <input type="text" class="form-control" name="fecha_requerimiento" value="{{$datos_requerimiento->fecha_requerimiento}}" data-format="yyyy-MM-dd">
                        <span class="input-group-btn add-on">
                                <button data-date-icon="icon-calendar" class="btn btn-check" type="button"><span class="glyphicon glyphicon-calendar"></span></button>
                              </span>
                    </div><!-- /input-group -->
                </div>
            </div>
        </div><!--/row-->

        <div class="divider"></div>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-hover table-striped">
                    <thead>
                    <tr>
                        <th>Área</th>
                        <th>Producto</th>
                        <th>cantidad</th>

                    </tr>
                    </thead>
                    <tbody id="lista_productos">
                        @foreach($detalle_requerimiento as $detalle)
                            <tr>
                                <td>{{$detalle->area}}</td>
                                <td>{{$detalle->descripcion}}</td>
                                <td>{{$detalle->cantidad_pedida}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div><!--/panel-body-->
@endif

@endsection

{{-- DONT DELETE --}}
@if (Route::currentRouteNamed(currentRouteName('index')))
    @include('layouts.smart.index')
@endif

@if (Route::currentRouteNamed(currentRouteName('create')))
    @include('layouts.smart.create')
    <script type="text/javascript">
        $(document).ready(function() {
            $('a[data-toggle="tooltip"]').tooltip({
                animated: 'fade',
                placement: 'bottom',
                html: true
            });
            $(".js-example-basic-single").select2({
                "language": { //para cambiar el idioma a español
                    "noResults": function(){
                        return "No se encontraron resultados";
                    }
                },
                escapeMarkup: function (markup) {
                    return markup;
                }
            });
            $('[data-toggle="tooltip"]').tooltip();
            $(".js-data-example-ajax1").select2({
                {{--ajax: {--}}
                    {{--data: {{$id_localidad->toJson()}},--}}
                    {{--//url: "https://api.github.com/search/repositories",--}}
{{--//                    data:  [{id:0,text:'ME'}, {id:1,text:'bug'}--}}
{{--//                        ,{id:2,text:'duplicate'},{id:3,text:'invalid'}--}}
{{--//                        ,{id:4,text:'wontfix'}],--}}
{{--//                    dataType: 'json',--}}
                    {{--delay: 250,--}}
                    {{--data: function (params) {--}}
                        {{--return {--}}
                            {{--q: params.term, // search term--}}
                            {{--page: params.page--}}
                        {{--};--}}
                    {{--},--}}
{{--//                    processResults: function (data, params) {--}}
{{--//                        // parse the results into the format expected by Select2--}}
{{--//                        // since we are using custom formatting functions we do not need to--}}
{{--//                        // alter the remote JSON data, except to indicate that infinite--}}
{{--//                        // scrolling can be used--}}
{{--//                        params.page = params.page || 1;--}}
{{--//--}}
{{--//                        return {--}}
{{--//                            results: data.items,--}}
{{--//                            pagination: {--}}
{{--//                                more: (params.page * 30) < data.total_count--}}
{{--//                            }--}}
{{--//                        };--}}
{{--//                    },--}}
                    {{--cache: true--}}
                {{--},--}}
                escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
                minimumInputLength: 1,
                language: {
                    "noResults": function(){
                        return "No se encontraron resultados";
                    }
                },
                escapeMarkup: function (markup) {
                    return markup;
                }
            });
            $('#datetimepicker3').datetimepicker({
                pickTime: false,
                //pick12HourFormat: true,
                //language: 'en'
            });
        });
    </script>
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

{{ HTML::script(asset('js/requisicioneshospitalarias.js')) }}