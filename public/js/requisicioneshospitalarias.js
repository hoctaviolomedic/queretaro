/**
 * Created by ihernandezt on 05/09/2017.
 */
$cont_producto = 0;
function agregarProducto() {
    var length_max = $('#cantidad').attr('maxlength');
    var length_cantidad = $('#cantidad').val().length;


    if( parseInt($('#id_area').val()) > 0 && parseInt($('#producto').val()) > 0 && parseInt($('#cantidad').val()) > 0 )
    {
        if(length_cantidad > length_max)
        {
            $.toaster({
                priority : 'danger',
                css:{
                    'top': '3em'
                },
                title : 'Error!',
                message : '<br>Se esta excediendo en la cantidad maxima de producto permitida.',
                settings:{
                    'timeout':8000,
                    'toaster':{
                        'css':{
                            'top':'3em'
                        }
                    }
                }
            });

        }
        else
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
    }
    else
    {
    	$.toaster({
            priority : 'danger',
            css:{
                'top': '3em'
            },
            title : 'Error!',
            message : '<br>Uno o varios de los campos de Area, producto o cantidad estan vacios.',
            settings:{
            	'timeout':8000,
            	'toaster':{
                    'css':{
                        'top':'3em'
                    }
                }
            }
        });
    }
    var filas = $('#detalle tr').length;
    $('#guardar').prop('disabled',(filas<=1));

}

function eliminarFila(fila)
{
    $('#'+fila).remove();
    
    var filas = $('#detalle tr').length;
    $('#guardar').prop('disabled',(filas<=1));
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

                $('select[name="id_area"]').empty().append('<option value="0" selected disabled>Selecciona un Area...</option>');
                $('select[name="id_solicitante"]').empty().append('<option value="0" selected disabled>Selecciona un Solicitante...</option>');
                $('select[name="producto"]').empty().append('<option value="0" selected disabled>Selecciona un Producto...</option>');
                
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

        $('#id_area option[value="0"]');
        $('#producto option[value="0"]');
        $('#cantidad option[value="0"]');

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

// $('#cantidad').change(function() {
//
//
// });
