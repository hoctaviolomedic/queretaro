/**
 * Created by ihernandezt on 05/09/2017.
 */
$cont_producto = 0;
function agregarProducto() {
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
    // $('#email_list').append('<tr id="' + id_mail + '"> <td>' + email + '</td><td>' + company_email + '</td> <td><a href="#" class="waves-effect waves-light btn btn-flat no-padding" onclick="eliminarFila(\'' + id_mail + '\')"><i class="material-icons">delete</i></a></td>     <input type="hidden" value="' + company_id + '" name="correo_empresa[' + cont_email + '][id_empresa]"><input type="hidden" value="' + email + '" name="correo_empresa[' + cont_email + '][correo]"></tr>');
    // cont_email++;
    // $('#email').val('');
    $cont_producto++;
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

                // data = $.parseJSON(data);
                console.info(data.producto);
                // alert(data);
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