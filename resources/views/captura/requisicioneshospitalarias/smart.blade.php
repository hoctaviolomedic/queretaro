
@section('content-width', 's12 m7 xl8 offset-xl2')
@section('form-content')
{{ Form::setModel($data) }}


@if (Route::currentRouteNamed(currentRouteName('create')))
    <div class="container-fluid">
        <br>
        <div class="panel shadow-3 panel-danger">
            <div class="panel-heading">
                <h3 class="panel-title text-center">Captura de Requisiciones Hospitalarias - SP DF</h3>
            </div>
            <div class="panel-body">

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            {{ Form::label('localidades', 'Localidad:') }}
                            {{ Form::select('localidades', $localidades, null, ['id'=>'localidades','class'=>'js-data-example-ajax1 form-control','style'=>'100%']) }}
                            {{ $errors->has('localidades') ? HTML::tag('span', $errors->first('localidades'), ['class'=>'help-block deep-orange-text']) : '' }}
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            {{ Form::label('solicitante', 'Solicitante:') }}
                            {{ Form::select('solicitante', $solicitante, null, ['id'=>'solicitante','class'=>'js-data-example-ajax1 form-control','style'=>'100%']) }}
                            {{ $errors->has('solicitante') ? HTML::tag('span', $errors->first('solicitante'), ['class'=>'help-block deep-orange-text']) : '' }}
                        </div>
                    </div>
                    <div class="col-sm-2 col-xs-6">
                        <label>*Estatus:</label>
                        <select class="form-control">
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
                                <input type="text" class="form-control" data-format="yyyy-MM-dd">
                                <span class="input-group-btn add-on">
                                <button data-date-icon="icon-calendar" class="btn btn-check" type="button"><span class="glyphicon glyphicon-calendar"></span></button>
                              </span>
                            </div><!-- /input-group -->
                        </div>
                    </div>
                </div><!--/row-->

                <div class="divider"></div>

                <div class="row">
                    <div class="col-sm-7 col-xs-12">
                        {{ Form::label('producto', 'Producto:') }}
                        {{ Form::select('producto', $productos, null, ['class'=>'js-data-example-ajax1 form-control','style'=>'100%']) }}
                        {{ $errors->has('producto') ? HTML::tag('span', $errors->first('producto'), ['class'=>'help-block deep-orange-text']) : '' }}
                    </div>
                    <div class="col-sm-3 col-xs-8">
                        <div class="form-group">
                            {{ Form::label('area', 'Área:') }}
                            {{ Form::select('area', $areas, null, ['class'=>'js-data-example-ajax1 form-control','style'=>'100%']) }}
                            {{ $errors->has('area') ? HTML::tag('span', $errors->first('area'), ['class'=>'help-block deep-orange-text']) : '' }}
                        </div>
                    </div>
                    <div class="col-sm-2 col-xs-4">
                        <div class="form-group">
                            <label for="cantidad">*Cantidad:</label>
                            <input type="number" class="form-control" id="cantidad" placeholder="Ej: 6">
                        </div>
                    </div>
                    <div class="col-sm-12 text-center">
                        <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Aceptar</button>
                    </div>
                </div><!--/row-->

                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-hover table-striped">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Clave</th>
                                <th>Descripción</th>
                                <th>Cantidad</th>
                                <th>Cantidad surtida</th>
                                <th>Cantidad a surtir</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>123456</td>
                                <td>PARACETAMOL 500MG</td>
                                <td>12</td>
                                <td>12</td>
                                <td>
                                    <div class="input-group">
                                        <input type="number" class="form-control" placeholder="Ej: 6">
                                        <span class="input-group-btn">
                          <button class="btn btn-default btn-check" type="button">Aceptar</button>
                        </span>
                                    </div><!-- /input-group -->
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">2</th>
                                <td>123456</td>
                                <td>DEXAMETASONA / LIDOCAÍNA / VITAMINA B1 / VITAMINA B12 / VITAMINA B6 4 MG / 30 MG / 100 MG / 5 MG / 100 MG</td>
                                <td>14</td>
                                <td>12</td>
                                <td>
                                    <div class="input-group">
                                        <input type="number" class="form-control" placeholder="Ej: 6">
                                        <span class="input-group-btn">
                          <button class="btn btn-default btn-check" type="button">Aceptar</button>
                        </span>
                                    </div><!-- /input-group -->
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">3</th>
                                <td>123456</td>
                                <td>FORMULA DE PROTEÍNA PARCIALMENTE HIDROLIZADA DE SUERO CONTIENE ACIDO GRASO OMEGA 3 DHA Y PREBIOTICOS GOS / NUCLEOTIDOSEL ACIDO GRASO OMEGA 6 AA 400 G / </td>
                                <td>14</td>
                                <td>12</td>
                                <td>
                                    <div class="input-group">
                                        <input type="number" class="form-control" placeholder="Ej: 6">
                                        <span class="input-group-btn">
                          <button class="btn btn-default btn-check" type="button">Aceptar</button>
                        </span>
                                    </div><!-- /input-group -->
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="text-right">
                    <button type="submit" class="btn btn-danger"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Guardar</button>
                    <button type="submit" class="btn btn-default">Cancelar y regresar</button>
                </div>

            </div><!--/panel-body-->
        </div><!--/panel-->
    </div>
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
                    {{--data: {{$localidades->toJson()}},--}}
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