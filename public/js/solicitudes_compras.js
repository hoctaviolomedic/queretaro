var a=[];
//Inicializar los datepicker para las fechas necesarias
$('.datepicker').pickadate({
    //Cambiamos idiomas a español
    labelMonthNext: 'Siguiente mes',
    labelMonthPrev: 'Regresar mes',
    labelMonthSelect: 'Selecciona el mes',
    labelYearSelect: 'Selecciona el año',
    monthsFull: [ 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre' ],
    monthsShort: [ 'Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic' ],
    weekdaysFull: [ 'Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado' ],
    weekdaysShort: [ 'Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab' ],
    weekdaysLetter: [ 'D', 'L', 'M', 'M', 'J', 'V', 'S' ],
    today: 'Hoy',
    clear: 'Limpiar',
    close: 'Aceptar',
    selectMonths: true, // Creates a dropdown to control month
    selectYears: 3, // Creates a dropdown of 3 years to control year
    min: true,
    format: 'yyyy/mm/dd'
});
$(document).ready( function () {
    $('#fk_id_solicitante').val(getIdempleado());

    $(':submit').attr('onclick','eliminarDetalle()');

    if(window.location.href.toString().indexOf('crear')>-1 || window.location.href.toString().indexOf('editar') >-1)
    {
        $('#fk_id_sucursal').prop('disabled',true);
        sucursal();//Cargar las sucursales del usuario
    }

    let data_empleados = $('#solicitante').data('url');
    $.ajax({//Carga todos los empleados
       type:'GET',
       url: data_empleados,
       success: function (response) {
           $('#solicitante').autocomplete2({
               data: response,
           });
       },
    });
    $('#solicitante').change(function () {
        $('#fk_id_solicitante').val('');
        sucursal();//Caga los nuevos datos de la sucursal
    });

    //Inicializar tabla
    window.dataTable = new DataTable('#productos', {
        fixedHeight: true,
        fixedColumns: true,
        searchable: false,
        perPageSelect: false
    });

    //Para obtener todos los skus
    let data_sku =$('#fk_id_sku').data('url');
    $.ajax({
       type:'GET',
        url: data_sku,
        success: function (response) {
            $('#fk_id_sku').autocomplete2({
               data: response,
            });
        }
    });
    $('#fk_id_sku').on('change',function () {
        codigosbarras();//Caga los nuevos datos del producto
    });

    let data_proveedores = $('#fk_id_proveedor').data('url');
    $.ajax({//Carga todos los empleados
        type:'GET',
        url: data_proveedores,
        success: function (response) {
            $('#fk_id_proveedores').autocomplete2({
                data: response,
            });
        },
    });

    let data_proyectos = $('#fk_id_proyecto').data('url');
    $.ajax({//Carga todos los proyectos
        type:'GET',
        url: data_proyectos,
        success: function (response) {
            $('#fk_id_proyecto').autocomplete2({
                data: response,
            });
        },
    });

    total_producto();//Obtiene el porcentaje del valor por defecto
});

function validateCantidad(element) {
    var valid = /[^0-9]/g.test(element.value),
        val = element.value;
    if(valid)
    {
        element.value = val.substring(0, val.length - 1);
    }
}

function validatePrecioUnitario(element) {
    var valid = /^\d{0,10}(\.\d{0,2})?$/g.test(element.value),
        val = element.value;
    if(!valid)
    {
        element.value = val.substring(0, val.length - 1);
    }
}

function getIdempleado()
{
    var data_empleado = $('#solicitante').data('url2');

    var objempleado = $.ajax({
        url: data_empleado,
        dataType: 'json',
        type: 'get',
        contentType: 'application/json',
        processData: false,
        success: function( data){
            return data;
        },
        error: function(){
            return '0';
        }
    });

    return JSON.stringify(objempleado.readyState);
}

function sucursal()
{
        let data_empleado = $('#fk_id_solicitante').data('url');
        $('#fk_id_sucursal').prop('disabled',true);//Deshabilitar

        if($('#fk_id_solicitante').val()=='' || $('#fk_id_solicitante').val()==null)
            {
                var _url = data_empleado.replace('?id', $('#solicitante').data('id'));
                $('#fk_id_solicitante').val($('#solicitante').data('id'));
            }
        else
            {var _url = data_empleado.replace('?id', $('#fk_id_solicitante').val());}

        $.ajax({
            async:false,
            url: _url,
            dataType: 'json',
            success: function (data) {
                removerOpciones('fk_id_sucursal');
                let option = $('<option/>');
                option.val(0);
                option.attr('disabled','disabled');
                option.attr('selected','selected');
                option.text('Selecciona una sucursal');
                $('#fk_id_sucursal').append(option);
                $.each(data, function (key, sucursal) {
                    let option = $('<option/>');
                    option.val(sucursal.id_sucursal);
                    option.text(sucursal.nombre_sucursal);
                    if(window.location.href.toString().indexOf('editar') > -1)
                    {
                        if($('#sucursal_defecto').val() == sucursal.id_sucursal)
                        {
                            option.prop('selected',true);
                        }
                    }
                    $('#fk_id_sucursal').append(option);

                });
                if(Object.keys(data).length ==0)
                {$('#fk_id_sucursal').prop('disabled',true)}
                else{$('#fk_id_sucursal').prop('disabled',false)}

                $('#fk_id_sucursal').material_select();
            },
        });
}

function codigosbarras()
{
    if($('#fk_id_sku').data('id') != null) {
        let data_codigo = $('#fk_id_codigo_barras').data('url');
        $('#fk_id_codigo_barras').prop('disabled', true);//Deshabilitar

        var _url = data_codigo.replace('?id', $('#fk_id_sku').data('id'))

        $.ajax({
            url: _url,
            dataType: 'json',
            success: function (data) {
                removerOpciones('fk_id_codigo_barras');
                let option = $('<option/>');
                option.val(1);
                option.attr('disabled', 'disabled');
                option.attr('selected', 'selected');
                option.text('Selecciona un código de barras');
                $('#fk_id_codigo_barras').append(option);
                $.each(data, function (key, codigo) {
                    let option = $('<option/>');
                    option.val(codigo.id_codigo_barras);
                    option.text(codigo.descripcion);
                    $('#fk_id_codigo_barras').append(option);
                });
                if (Object.keys(data).length == 0) {
                    $('#fk_id_codigo_barras').prop('disabled', true)
                }
                else {
                    $('#fk_id_codigo_barras').prop('disabled', false)
                }

                $('#fk_id_codigo_barras').material_select();
            },
        });
    }
}

function total_producto() {
    let data_impuesto = $('#fk_id_impuesto').data('url');
    let impuesto;
    var total = $.ajax({
        dataType: 'json',
        type: 'GET',
        url: data_impuesto.replace('?id', $('#fk_id_impuesto').val()),
        contentType: 'application/json',
        processData: false,
        success: function (data) {
            impuesto = data;
            let precio_unitario = $('#precio_unitario').val();
            let cantidad = $('#cantidad').val();

            //Calcular valores
            let subtotal = cantidad*precio_unitario;
            let impuesto_producto = (subtotal*impuesto)/100;
            return subtotal + impuesto_producto;
        }
    });

    return JSON.stringify(total.readyState);
}
function total_producto_row(id_detalle,tipo) {

    let url = $('#productos').data('porcentaje');
    let id_impuesto;
    if(tipo == 'old')
        {id_impuesto = $('#fk_id_impuesto'+id_detalle).val();}
    else
        {id_impuesto = $('#_fk_id_impuesto'+id_detalle).val();}
    $.ajax({
        type: 'GET',
        url: url.replace('?id', id_impuesto),
        success: function (impuesto) {
            let precio_unitario;
            let cantidad;
            if(tipo == 'old')
            {
                precio_unitario = $('#precio_unitario'+id_detalle).val();
                cantidad = $('#cantidad'+id_detalle).val();
            }else
            {
                precio_unitario = $('#_precio_unitario'+id_detalle).val();
                cantidad = $('#_cantidad'+id_detalle).val();
            }
            //Calcular valores
            let subtotal = cantidad*precio_unitario;
            let impuesto_producto = (subtotal*impuesto)/100;

            if(tipo == 'old')
                {$('#total'+id_detalle).val(subtotal + impuesto_producto);}
            else
                {$('#_total'+id_detalle).val(subtotal + impuesto_producto);}

        }
    });
}

function agregarProducto() {

    var mensaje = '';
    var row_id = dataTable.rows.length;

    if($('#fk_id_sku').data('id') == null || $('#fk_id_sku').data('id') < 1)
        {mensaje = mensaje+"SKU <br/>";}
    if($('#fk_id_codigo_barras option:selected').html()==null || $('#fk_id_codigo_barras option:selected').html()=='')
        {mensaje = mensaje+"Código de barras <br/>";}
    if($('#cantidad').val() == null || $('#cantidad').val() == '' || isNaN($('#cantidad').val()))
        {mensaje = mensaje + "Cantidad ";}
    if(isNaN($('#precio_unitario').val()) | !($('#precio_unitario').val() > 0))
        {mensaje = mensaje+"Precio unitario <br/>";}
    if($('#fk_id_proyecto').data('id') == null || $('#fk_id_proyecto').data('id') < 1)
        {mensaje = mensaje+"Proyecto <br/>";}
    if($('#fecha_necesario').val() == '' || $('#fecha_necesario').val() == null)
        {mensaje = mensaje+"Fecha <br/>";}

    if(mensaje == '' || mensaje == null) {

        //Para obtener las opciones del select de proyectos en el detalle de la solicitud
        let proyectos = '';
        let data_proyectos = $('#fk_id_proyecto').data('url');
        $.ajax({
            async:false,
            url: data_proyectos,
            dataType: 'json',
            success: function (data) {
                $.each(data, function (key, proyecto) {
                    //Este if es para verificar la opción seleccionada por defecto
                    if(proyecto.id == $('#fk_id_proyecto').data('id'))
                        {proyectos += '<option value="'+proyecto.id+'" selected>'+proyecto.text+'</option>';}
                    else
                        {proyectos += '<option value="'+proyecto.id+'">'+proyecto.text+'</option>';}
                });
            },
        });
    //Para obtener las opciones del select de impuestos en el detalle de la solicitud
        let impuestos = '';
        let data_impuestos = $('#productos').data('impuestos');
        $.ajax({
            async:false,
            url: data_impuestos,
            dataType: 'json',
            success: function (data) {
                $.each(data, function (key, impuesto) {
                    //Este if es para verificar la opción seleccionada por defecto
                    if(impuesto.id_impuesto == $('#fk_id_impuesto option:selected').val())
                        {impuestos += '<option value="'+impuesto.id_impuesto+'" selected>'+impuesto.impuesto+'</option>';}
                    else
                        {impuestos += '<option value="'+impuesto.id_impuesto+'">'+impuesto.impuesto+'</option>';}
                });
            },
        });

        let total = total_producto();
        //Para que se borren todos los selects
        $('select').material_select('destroy');

        dataTable.import({
            type: "csv",
            data:
            $('<input type="hidden" name="_detalles['+row_id+'][fk_id_sku]" value="' + $('#fk_id_sku').data('id') + '" />')[0].outerHTML + $('#fk_id_sku').val() + ","+
            $('<input type="hidden" name="_detalles['+row_id+'][fk_id_codigo_barras]" value="' + $('#fk_id_codigo_barras').val() + '" />')[0].outerHTML + $('#fk_id_codigo_barras option:selected').html() + ","+
            $('<input type="hidden" name="_detalles['+row_id+'][fk_id_proveedor]" />')[0].outerHTML+$('#fk_id_proveedor').val()+ "," +
            $('<input type="hidden" name="_detalles['+row_id+'][fecha_necesario]" value="'+ $('#fecha_necesario').val()+'"/>')[0].outerHTML +  $('#fecha_necesario').val() + "," +
            $('<select name="_detalles['+row_id+'][fk_id_proyecto]" id="fk_id_proyecto'+row_id+'">'+proyectos+'</select>')[0].outerHTML + ","+
            $('<input type="text" name="_detalles['+row_id+'][cantidad]" onkeyup="validateCantidad(this)" onkeypress="total_producto_row('+row_id+')" id="_cantidad'+row_id+'" value="'+ $('#cantidad').val()+'" class="validate cantidad"/>')[0].outerHTML + "," +
            $('<input type="hidden" name="_detalles['+row_id+'][fk_id_unidad_medida]" value="' + $('#fk_id_unidad_medida').val() + '" />')[0].outerHTML + $('#fk_id_unidad_medida option:selected').html() + ","+
            $('<select name="_detalles['+row_id+'][fk_id_impuesto]" onchange="total_producto_row('+row_id+')" id="_fk_id_impuesto'+row_id+'">'+impuestos+'</select>')[0].outerHTML + ","+
            $('<input type="text" name="_detalles['+row_id+'][precio_unitario]" onkeyup="validatePrecioUnitario(this)" onkeypress="total_producto_row('+row_id+')" id="_precio_unitario'+row_id+'" value="'+ $('#precio_unitario').val()+'" class="precio_unitario"/>')[0].outerHTML + "," +
            $('<input type="text" name="_detalles['+row_id+'][total]" readonly id="_total'+row_id+'" value="'+ total+'" class="precio_unitario"/>')[0].outerHTML + "," +
            '<button class="btn-flat teal lighten-5 halfway-fab waves-effect waves-light" ' +
            'type="button" data-delay="50" onclick="borrarFila(this)">' +
            '<i class="material-icons">delete</i></button>'
        });
        $('select').material_select();//Para regenerar los selects y evitar que desaparezcan después los del detalle
        Materialize.toast('<span><i class="material-icons">done</i> ¡Detalle agregado con éxito!</span>', 3000,'green rounded');
        limpiarFormulario();//Limpiar el formulario de algunos de los valores

    }else {
        Materialize.toast('<span><i class="material-icons">priority_high</i>Verifica los siguientes campos: <br/>'+mensaje+'</span>', 10000,'red rounded');
    }
}

function limpiarFormulario() {
    $('#fk_id_proveedor').val('');
    $('#cantidad').val('1');
    $('#precio_unitario').val('0');
}

function borrarFila(el) {
    console.log( $(el).parents('tr').data('datarow') );
    dataTable.removeRows([$(el).parents('tr').data('datarow')]);
}
function borrarFila_edit(el) {
    a.push(el.id);
    dataTable.removeRows([$(el).parents('tr').data('datarow')]);
}

function removerOpciones(id) {
    document.getElementById(id).options.length = 0;
}

function eliminarDetalle() {

    let url = $('#productos').data('delete');
    $.delete(url, {ids: a} );
}