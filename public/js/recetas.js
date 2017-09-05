$(document).ready(function () {

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
        }
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