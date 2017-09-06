$(document).ready(function () {

    //Deshabilitar siempre al iniciar
    $('#surtido_numero').prop('disabled',true);
    $('#tiempo').prop('disabled',true);

    $(".unidad").select2();

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
        var campos = '';
        if($('#medicamento').select2('data').length ==0)
            campos += '<br>Medicamento';
        if($('#dosis').val()<1)
            campos += '<br>Dosis';
        if($('#cada').val()<1)
            campos += '<br>Cada cuanto tomar la medicina';
        if($('#por').val()<1 )
            campos += '<br>Duración del tratamiento de la medicina';

        if(campos!=''){
            $.toaster({ priority : 'danger', title : 'Verifica los siguientes campos', message : campos,settings:{'donotdismiss':['danger']}});
            return
        }


        var filas = $('#detalle tr').length;
        var medicamento = $('.medicamento').select2('data');
        var dosis_text = '<b>';
        var dosis_hidden = parseInt($('#dosis').val());
        dosis_text += $('#dosis').val();
        if($('#dosis14').prop('checked') == true){
            dosis_text += ' 1/4 ';
            dosis_hidden += 0.25;
        }else if($('#dosis14').prop('checked') == false){
            dosis_text += ' 1/2 ';
            dosis_hidden += 0.5;
        }
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
            '</tr>')
    })

    $('#medicamento').on('change',function () {
        var medicamento = $('#medicamento').select2('data');
        $('#_dosis').val(medicamento[0].familia);
    })

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
        '<br>Disponibilidad: <b></b>');
}