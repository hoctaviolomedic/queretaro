@extends('layouts.dashboard')

@section('title', '@Agregar')

@section('header-top')
<link rel="stylesheet" href="{{asset('css/bootstrap-multiselect.css')}}">
@endsection

@section('header-bottom')
<script src="{{asset('js/bootstrap-multiselect.js')}}"></script>
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
        $(".js-data-example-ajax").select2({
            ajax: {
                url: "https://api.github.com/search/repositories",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
            q: params.term, // search term
            page: params.page
        };
    },
    processResults: function (data, params) {
            // parse the results into the format expected by Select2
            // since we are using custom formatting functions we do not need to
            // alter the remote JSON data, except to indicate that infinite
            // scrolling can be used
            params.page = params.page || 1;

            return {
                results: data.items,
                pagination: {
                    more: (params.page * 30) < data.total_count
                }
            };
        },
        cache: true
    },
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
        $('#example-getting-started').multiselect({
            enableClickableOptGroups: true
        });
    });
</script>

@endsection

@section('content')
<br>
<div class="panel shadow-3 panel-danger">
    <div class="panel-heading">
        <h3 class="panel-title text-center">Entradas pedidos</h3>
    </div>
    <div class="panel-body">

        <form class="row">
            <div class="col-sm-4">
                <div class="form-group">
                    <label for="localidad">*Localidad:</label>
                    <select id="localidad" class="js-data-example-ajax form-control" style="width: 100%">
                        <option value="3620194" selected="selected">Escriba la clave o su descripción</option>
                    </select>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label for="pedido">*Pedido:</label>
                    <select id="pedido" class="js-data-example-ajax form-control" style="width: 100%">
                        <option value="3620194" selected="selected">Escriba la clave o su descripción</option>
                    </select>
                </div>
            </div>
            <div class="col-sm-4 col-xs-6">
                <div class="form-group">
                    <label for="surtidor">*Surtidor:</label>
                    <select id="example-getting-started" multiple="multiple" selectedClass>
                        <option value="cheese">Cheese</option>
                        <option value="tomatoes">Tomatoes</option>
                        <option value="mozarella">Mozzarella</option>
                        <option value="mushrooms">Mushrooms</option>
                        <option value="pepperoni">Pepperoni</option>
                        <option value="onions">Onions</option>
                    </select>
                </div>
            </div>
        </form><!--/row-->

        <div class="well">
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="pedido">Código de barras</label>
                        <div class="input-group">
                            <input id="pedido" type="number" class="form-control" placeholder="Buscar...">
                            <span class="input-group-btn">
                                <button class="btn btn-default btn-check" type="button"><span class="glyphicon glyphicon-plus"></span> Aceptar</button>
                            </span>
                        </div><!-- /input-group -->
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Codigo de barras</th>
                            <th>Descripción</th>
                            <th>Cantidad surtida</th>
                            <th>Cantidad pendiente</th>
                            <th>Cantidad entrada</th>
                            <th>Lote</th>
                            <th>Caducidad</th>
                            <th>Ubicación</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">1</th>
                            <td>7501034651044</td>
                            <td>ACIDO DOCOSAHEXAEINOCO (DHA)</td>
                            <td>1</td>
                            <td>10</td>
                            <td>
                                <div class="input-group">
                                    <input type="number" class="form-control" placeholder="Ej: 6">
                                </div><!-- /input-group -->
                            </td>
                            <td>S3887</td>
                            <td>2016-11-30</td>
                            <td>
                                <div class="input-group">
                                    <span class="input-group-addon" id="a">A</span>
                                    <select class="form-control">
                                        <option>Selecciona...</option>
                                        <option>Pastilla</option>
                                        <option>Tableta</option>
                                        <option>Unidad</option>
                                        <option>Capsula</option>
                                    </select>
                                    <span class="input-group-addon" id="u">U</span>
                                    <select class="form-control">
                                        <option>Selecciona...</option>
                                        <option>Pastilla</option>
                                        <option>Tableta</option>
                                        <option>Unidad</option>
                                        <option>Capsula</option>
                                    </select>
                                </div>
                            </td>
                            <td>
                                <a href="#" data-toggle="tooltip" data-placement="top" title="Agregar comentarios u observaciones" class="text-danger btn btn-check">
                                    <span class="glyphicon glyphicon-comment" aria-hidden="true"></span>
                                </a>
                                <a href="#" data-toggle="tooltip" data-placement="top" title="Agregar" class="text-danger btn btn-check">
                                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                                </a>
                                <a href="#" data-toggle="tooltip" data-placement="top" title="Eliminar" class="text-danger btn btn-check">
                                    <span class="glyphicon glyphicon-minus" aria-hidden="true"></span>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="form-inline form-group">
                    <div class="input-group">
                        <span class="input-group-addon" id="basic-addon1">Código de barras</span>
                        <input type="text" class="form-control" placeholder="Username" aria-describedby="basic-addon1">
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon" id="basic-addon1">Cantidad pendiente</span>
                        <input type="text" class="form-control" placeholder="Username" aria-describedby="basic-addon1">
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon" id="basic-addon1">Cantidad entrada</span>
                        <input type="text" class="form-control" placeholder="Username" aria-describedby="basic-addon1">
                    </div>
                </div>
            </div>
        </div>

        <div class="text-right">
            <button type="submit" class="btn btn-danger"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Guardar</button>
            <button type="submit" class="btn btn-default">Cancelar y regresar</button>
        </div>


    </div>
</div>
@endsection