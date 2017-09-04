$(document).ready(function () {
    $('#fk_id_categoria option[value="0"]').prop('disabled',true);
    let data_empleados = $('#empleado_solicitud').data('url');
    $.ajax({
       type:'GET',
       url: data_empleados,
       success: function (response) {
           $('#empleado_solicitud').autocomplete2({
               data: response
           });
       },
    });

    $('#empleado_solicitud').change(function () {
        sucursal();
    });

    activar_empleado();

    $('#fk_id_categoria').on('change', function(){
    	let data = $(this).data('url');
    	let id = $('option:selected', this).val();
        
        $('#fk_id_accion option').remove();
        $('#fk_id_subcategoria option').remove();
        $('#fk_id_subcategoria').prop('disabled',true);
        $('#fk_id_accion').prop('disabled',true);

        $.ajax({
        	url: data.replace('?id', $('option:selected', this).val()),
            dataType: 'json',
            success: function (data) {
                let option = $('<option/>');
                option.val(null);
                option.attr('disabled','disabled');
                option.attr('selected','selected');
                option.text('Selecciona una subcategoría');
                $('#fk_id_subcategoria').append(option);
                $.each(data, function (key, subcategoria) {
                    let option = $('<option/>');
                    option.val(subcategoria.id_subcategoria);
                    option.text(subcategoria.subcategoria);

                    $('#fk_id_subcategoria').append(option);

                });
                if(Object.keys(data).length ==0)
                {$('#fk_id_subcategoria').prop('disabled',true)}
                else{$('#fk_id_subcategoria').prop('disabled',false)}
                $('select').material_select();
            },
            error: function () {
                alert('error');
            }
        });

    });

    $('#fk_id_subcategoria').on('change', function(){
    	let data = $(this).data('url');
        $('#fk_id_accion option').remove();
        $.ajax({
            url: data.replace('?id', $('option:selected', this).val()),
            dataType: 'json',
            success: function (data) {
                let option = $('<option/>');
                option.val(null);
                option.attr('disabled','disabled');
                option.attr('selected','selected');
                option.text('Selecciona una acción');
                $('#fk_id_accion').append(option);
                $.each(data, function (key, accion) {

                    let option = $('<option/>');
                    option.val(accion.id_accion);
                    option.text(accion.accion);

                    $('#fk_id_accion').append(option);
                });
                if(Object.keys(data).length ==0)
                {$('#fk_id_accion').prop('disabled',true)}
                else{$('#fk_id_accion').prop('disabled',false)}
                $('select').material_select();
            },
            error: function () {
                alert('error');
            }
        });
    });
});

function activar_empleado(){
    $('#fk_id_sucursal').prop('disabled',true);//Deshabilitar
    if ($('#otherUser').prop('checked') == true)
        {
            $('#empleado_solicitud').prop('disabled',false);
            removerOpciones('fk_id_sucursal');
            $('select').material_select();
        }
    else
    {
        $('#empleado_solicitud').prop('disabled',true);
        $('#empleado_solicitud').val('');
        $('#nombre_solicitante').val('');
        sucursal();
    }
}

function sucursal()
{
    $('#nombre_solicitante').val($('#empleado_solicitud').val());
    let url = $('#nombre_solicitante').data('url');
    $('#fk_id_sucursal').prop('disabled',true);//Deshabilitar
    if($('#forMe1').prop('checked')==true)//Si es para el usuario activo
    {
        let data_empleado = $('#forMe1').data('url');
        $.ajax({
            type:'GET',
            url: data_empleado,
            success: function (response) {
                // $('#fk_id_sucursal option').remove();//Limpiar
                $('#fk_id_sucursal').prop('disabled',true);//Deshabilitar

                $.ajax({
                    url: url.replace('?id', response),
                    dataType: 'json',
                    success: function (data) {
                        removerOpciones('fk_id_sucursal');
                        let option = $('<option/>');
                        option.val(null);
                        option.attr('disabled','disabled');
                        option.attr('selected','selected');
                        option.text('Selecciona una sucursal');
                        $('#fk_id_sucursal').append(option);
                        $.each(data, function (key, sucursal) {
                            let option = $('<option/>');
                            option.val(sucursal.id_sucursal);
                            option.text(sucursal.nombre_sucursal);
                            $('#fk_id_sucursal').append(option);
                        });
                        if(Object.keys(data).length ==0)
                        {$('#fk_id_sucursal').prop('disabled',true)}
                        else{$('#fk_id_sucursal').prop('disabled',false)}

                        $('select').material_select();
                    },
                    error: function () {
                        alert('error');
                    }
                });
            }
        });
    }else if($('#empleado_solicitud').data('id')>0)//Si es para otra persona
    {
        $.ajax({
            url: url.replace('?id', $('#empleado_solicitud').data('id')),
            dataType: 'json',
            success: function (data) {
                removerOpciones('fk_id_sucursal');
                let option = $('<option/>');
                option.val(null);
                option.attr('disabled','disabled');
                option.attr('selected','selected');
                option.text('Selecciona una sucursal');
                $('#fk_id_sucursal').append(option);
                $.each(data, function (key, sucursal) {
                    let option = $('<option/>');
                    option.val(sucursal.id_sucursal);
                    option.text(sucursal.nombre_sucursal);

                    $('#fk_id_sucursal').append(option);

                });
                if(Object.keys(data).length ==0)
                {$('#fk_id_sucursal').prop('disabled',true)}
                else{$('#fk_id_sucursal').prop('disabled',false)}
                $('select').material_select();
            },
            error: function () {
                alert('error');
            }
        });
    }
}

function removerOpciones(id) {
    document.getElementById(id).options.length = 0;
}
