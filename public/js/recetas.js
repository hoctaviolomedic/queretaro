$(document).ready(function () {

    //Deshabilitar siempre al iniciar
    $('#surtido_numero').prop('disabled',true);
    $('#tiempo').prop('disabled',true);
    $(':submit').prop('disabled',true);

    $(".unidad").select2();
    $('.medico').select2();
    $('.programa').select2();

    initPaciente();

    $(".diagnostico").select2({
        placeholder: 'Escriba el diagnóstico del paciente',
        ajax: {
            type: 'POST',
            url: $(".diagnostico").data('url'),
            dataType: 'json',
            data: function(params) {
                return {
                    diagnostico: $.trim(params.term) // search term
                };
            },
            processResults: function(data) {
                return {
                    results: data
                };
            },
            cache: true
        },
        escapeMarkup: function(markup) {
            return markup;
        },
        minimumInputLength: 3,
        language: {
            "noResults": function() {
                return "No se encontraron resultados";
            }
        },
        escapeMarkup: function(markup) {
            return markup;
        }
    });

    $(".medicamento").select2({
        placeholder: 'Escriba el medicamento',
        ajax: {
            type: 'POST',
            url: $(".medicamento").data('url'),
            dataType: 'json',
            data: function(params) {
                return {
                    medicamento: $.trim(params.term), // search term
                    localidad: $('.unidad').val()
                };
            },
            processResults: function(data) {
                return {
                    results: data
                };
            },
            cache: true
        },
        escapeMarkup: function(markup) {
            return markup;
        },
        minimumInputLength: 3,
        language: {
            "noResults": function() {
                return "No se encontraron resultados";
            }
        },
        escapeMarkup: function(markup) {
            return markup;
        },
        templateResult: formatMedicine,
    });

    $('input[name=tipo_servicio]').change(function () {
        if(this.value == 'afiliado') {
            $('#paciente_externo').prop('style','display:none');
            $('#paciente').prop('style','display:block');
            initPaciente();
        }else if(this.value == 'externo'){
            $('#paciente_externo').prop('style','display:block');
            $('#paciente').select2('destroy');
            $('#paciente').prop('style','display:none');
        }
    });

    $('.dosis_checkbox').on('change',function(){
        if(this.id == 'dosis14'){
            $('#dosis12').prop('checked',false);
            $('#dosis12').parent().removeClass('active');
        }
        if(this.id == 'dosis12'){
            $('#dosis14').prop('checked',false);
            $('#dosis14').parent().removeClass('active');
        }
    });

    $('.checkbox_surtido').on('change',function () {
        if($('.checkbox_surtido').prop('checked') == true){
            $('#surtido_numero').prop('disabled',false);
            $('#surtido_tiempo').prop('disabled',false);
        }else if($('.checkbox_surtido').prop('checked') == false){
            $('#surtido_numero').prop('disabled',true);
            $('#surtido_numero').val('');
            $('#surtido_tiempo').prop('disabled',true);
        }
    });

    $('#agregar').click(function () {
        var medicamento = $('.medicamento').select2('data');
        var campos = '';
        if($('#medicamento').select2('data').length ==0)
            campos += '<br>Medicamento: ¿Seleccionaste un medicamento?';
        if(parseInt($('#dosis').val()) < 1 || parseInt(medicamento[0].tope_receta) < parseInt($('#dosis').val()) || parseInt(medicamento[0].disponible) < parseInt($('#dosis').val())){
            campos += '<br><br>Dosis: verifica que el valor sea mayor a 0 o que el valor no exceda la cantidad máxima permitida por receta o que no rebase las cantidades disponibles.';
        }
        if($('#cada').val()<1)
            campos += '<br><br>Cada cuanto tomar la medicina';
        if($('#por').val()<1 )
            campos += '<br><br>Duración del tratamiento de la medicina';

        if(campos!=''){
            $.toaster({ priority : 'danger', title : 'Verifica los siguientes campos', message : campos,settings:{'donotdismiss':['danger']}});
            return
        }

        var filas = $('#detalle tr').length;
        var dosis_text = '<b>';
        var dosis_hidden = parseInt($('#dosis').val());
        dosis_text += $('#dosis').val();
        if($('#dosis14').prop('checked') == true){
            dosis_text += ' 1/4 ';
            dosis_hidden += 0.25;
        }else if($('#dosis12').prop('checked') == true){
            dosis_text += ' 1/2 ';
            dosis_hidden += 0.5;
        }
        dosis_hidden += ' '+medicamento[0].familia;
        dosis_text += medicamento[0].familia+'</b>';

        var tiempo_text = '<b>'+$('#cada').val();
        tiempo_text += ' '+$('#_cada option:selected').text()+'</b>';
        var tiempo_hidden = $('#cada').val()+' '+$('#_cada option:selected').text();

        var duracion_text = '<b>'+$('#por').val();
        duracion_text += ' '+$('#_por option:selected').text()+'</b>';
        var duracion_hidden = $('#por').val()+' '+ $('#_por option:selected').text();

        var recurrencia_text = '';
        var recurrencia_hidden = '';
        if($('#surtido_recurrente').prop('checked') == true){
            recurrencia_text += 'Recoger cada <b>'+$('#surtido_numero').val()+' '+$('#surtido_tiempo option:selected').text()+'</b>';
            recurrencia_hidden += $('#surtido_numero').val()+' '+$('#surtido_tiempo option:selected').text();
        }

        var nota_medicamento = $('#nota_medicamento').val();
        $('.medicine_detail').append('' +
            '<tr id="'+filas+'">' +
                '<th scope="row">'+filas+'</th>' +
                '<td>' +
                    '<p><input name="medicamento" type="hidden" value="'+medicamento[0].id+'"/>'+medicamento[0].text+'</p>' +
                    '<p><input name="dosis" type="hidden" value="'+dosis_hidden+'" disabled/>'+dosis_text+' cada '+tiempo_text+' por '+duracion_text+'</p>' +
                    '<input name="tiempo" type="hidden" value="'+tiempo_hidden+'" disabled/>' +
                    '<input name="duracion" type="hidden" value="'+duracion_hidden+'" disabled/>' +
                    '<p><input name="indicaciones" type="hidden" value="'+nota_medicamento+'" disabled/>'+nota_medicamento+'</p>' +
                    '<p><input name="recurrencia" type="hidden" value="'+recurrencia_hidden+'" disabled/>'+recurrencia_text+'</p>' +
                '</td>' +
                '<td>' +
                    '<a onclick="eliminarFila(this)" data-toggle="tooltip" data-placement="top" title="Borrar" class="text-danger" id="'+filas+'"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a> ' +
                '</td>'+
            '</tr>');
        if(filas>0){
            $(':submit').prop('disabled',false);
        }
        $.toaster({ priority : 'success', title : '¡Éxito!', message : '<br>Medicamento agregado exitosamente'});
    });

    $('#medicamento').on('change',function () {
        var medicamento = $('#medicamento').select2('data');
        $('#_dosis').val(medicamento[0].familia);
    });

    //Validación de medicamentos
    $('form').on('submit',function (e) {
       var valid = true;


       //validación; si los medicamentos siguen disponibles, valid = true
        $.ajax({

        });

        if(!valid){
            e.preventDefault();//Evita que se envíe el formulario si hay un error
        }
    });

});

function initPaciente() {
    $(".paciente").select2({
        placeholder: 'Escriba el número de afiliación o el nombre del paciente',
        ajax: {
            type: 'POST',
            url: $(".paciente").data('url'),
            dataType: 'json',
            data: function(params) {
                return {
                    membership: $.trim(params.term) // search term
                };
            },
            processResults: function(data) {
                return {
                    results: data
                };
            },
            cache: true
        },
        escapeMarkup: function(markup) {
            return markup;
        },
        minimumInputLength: 1,
        language: {
            "noResults": function() {
                return "No se encontraron resultados";
            }
        },
        escapeMarkup: function(markup) {
            return markup;
        }
    });
}

function formatMedicine(medicine) {
    if(!medicine.id){return medicine.text;}
    return $('<span>'+medicine.text+'</span><br>Presentación: <b>'+medicine.familia+'</b> Cantidad en la presentación: <b>'+medicine.cantidad_presentacion+'</b>' +
        '<br>Disponibilidad: <b>'+medicine.disponible+'</b> Máximo para recetar: <b>'+medicine.tope_receta+'</b>');
}

function eliminarFila(a) {
    $(a).closest('tr').remove();
    if($('#detalle tr').length-1<1)
        $(':submit').prop('disabled',true);


}