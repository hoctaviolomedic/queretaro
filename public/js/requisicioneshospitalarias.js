/**
 * Created by ihernandezt on 05/09/2017.
 */
$cont_producto = 0;
function agregarProducto() {

    if($('#id_area').val() != '' && $('#producto').val() != '' && $('#cantidad').val() != '')
    {
        var id_area =  $('#id_area').val();
        var area_nombre =  $('#id_area option:selected').text();
        var producto_clave = $('#producto').val();
        var producto_nombre = $('#producto option:selected').text();
        var cantidad = $('#cantidad').val();
        var id_renglon = $cont_producto+'_'+producto_clave;
        // var company_id = $('#company_email option:selected').val();



        $('#lista_productos').append('<tr id="' + id_renglon + '"> ' +
            '<td>' + area_nombre + '</td>' +
            '<td>' + producto_nombre + '</td>' +
            '<td>'+ cantidad +'</td> ' +
            '<td>' + '<a href="#" data-toggle="tooltip" data-placement="top" title="Borrar" class="text-danger"><span class="glyphicon glyphicon-trash" aria-hidden="true"  onclick="eliminarFila(\'' + id_renglon + '\')"></span> </a></td>  ' +
            '</tr>' +
            '<input type="hidden" value="'+id_area+'" name="producto_requisicion['+$cont_producto+'][id_area]">' +
            '<input type="hidden" value="'+producto_clave+'" name="producto_requisicion['+$cont_producto+'][producto_clave]">' +
            '<input type="hidden" value="'+cantidad+'" name="producto_requisicion['+$cont_producto+'][cantidad]">'
        );

        $cont_producto++;
    }
    else
    {
        alert('Uno o varios de los campos de área, producto o cantidad están vacíos.');
    }

}

function eliminarFila(fila)
{
    $('#'+fila).remove();
}

$('select[name="id_localidad"]').on('change', function() {
    // alert($("#id_localidad").data('url'));
    var id_localidad = $(this).val();
    // alert(id_localidad);
    if(id_localidad) {
        $.ajax({
            type: "POST",
            url: $("#id_localidad").data('url'),
            data: 'id_localidad='+id_localidad,
            dataType: "json",
            success:function(data) {

                console.info(data.producto);
                data_areas = $.parseJSON(data.areas);
                data_usuario = $.parseJSON(data.usuario);
                data_producto = $.parseJSON(data.producto);

                $('select[name="id_area"]').empty();
                $('select[name="id_usuario_surtido"]').empty();
                $('select[name="producto"]').empty();

                $.each(data_areas, function(key, value) {
                    $('select[name="id_area"]').append('<option value="'+ key +'">'+ value +'</option>');
                });
                $.each(data_usuario, function(key, value) {
                    $('select[name="id_solicitante"]').append('<option value="'+ key +'">'+ value +'</option>');
                });
                $.each(data_producto, function(key, value) {
                    $('select[name="producto"]').append('<option value="'+ key +'">'+ value +'</option>');
                });
            }
        });

    }else{
        $('select[name="id_area"]').empty();
        $('select[name="id_usuario_surtido"]').empty();
        $('select[name="producto"]').empty();
    }
});

function surtirRequisicion()
{

    var validado = 0;

    for( var i=0 ; i < $('#lista_productos tr').length; i++)
    {
        if((parseInt($("#renglon_"+i).val())+ parseInt(detalle_requisicion[i].cantidad_surtida)) > detalle_requisicion[i].cantidad_pedida)
        {
            validado++;
        }
    }

    if(validado == 0)
    {
        return true;
    }
    else
    {
        alert('Se esta excediendo la cantdad de producto solicitada.');
        return false;
    }

}

//
// $( ".surtir_requisicion" ).submit(function() {
//     //data_areas = $.parseJSON(detalle_requisicion);
//
//     //alert(JSON.stringify(detalle_requisicion));
// });