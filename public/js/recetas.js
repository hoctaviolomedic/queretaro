$(document).ready(function () {
    //Deshabilitar siempre al iniciar
    $('#surtido_numero').prop('disabled',true);
    $('#tiempo').prop('disabled',true);
    $(':submit').attr('id','guardar');
    $(':submit').attr('type','button');


    $(".unidad").select2();
    $('.medico').select2();
    $('.programa').select2();
    $('.area').select2();

    initPaciente();

    $(".diagnostico").select2({
        placeholder: 'Escriba el diagnÃ³stico del paciente',
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

    medicamento();

    $('input[name=tipo_servicio]').change(function () {
        if(this.value == 'afiliado') {
            $('#nombre_paciente_no_afiliado').val('');
            $('#nombre_paciente_no_afiliado').prop('style','display:none');
            $('#id_dependiente').prop('style','display:block');
            initPaciente();
        }else if(this.value == 'externo'){
            $('#nombre_paciente_no_afiliado').prop('style','display:block');
            $('#id_dependiente').select2('destroy');
            $('#id_dependiente').prop('style','display:none');
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
        if($('#medicamento').select2('data').length ==0){
            campos += '<br><br>Medicamento: Â¿Seleccionaste un medicamento?';
        }
        if(!parseInt($('#dosis').val())>0)
            campos += '<br><br>Necesito que me indiques la <b>dosis</b> del medicamento';
        if(!parseInt($('#cada').val())>0)
            campos += '<br><br>Necesito que me indiques <b>cada</b> cuando tomarÃ¡ el medicamento';
        if(!parseInt($('#por').val())>0 )
            campos += '<br><br>Necesito que me indiques <b>la duraciÃ³n</b> del medicamento';

        if(campos!=''){
            $.toaster({
                priority : 'danger',
                title : 'Verifica los siguientes campos',
                message : campos,
                settings:{
                    'timeout':10000,
                    'toaster':{
                        'css':{
                            'top':'3em'
                        }
                    }
                }
            });
            return
        }
        var filas = $('#detalle tr').length;
        var dosis_text = '<b>';
        var dosis_hidden = parseInt($('#dosis').val());
        dosis_text += $('#dosis').val()+' ';
        if($('#dosis14').prop('checked') == true){
            dosis_text += '1/4 ';
            dosis_hidden += 0.25;
        }else if($('#dosis12').prop('checked') == true){
            dosis_text += '1/2 ';
            dosis_hidden += 0.5;
        }

        var cantidad_final = 1;
        var recurrencia_text = '';
        var recurrencia_hidden = 0;
        var veces_surtir = 0;
        if($('#surtido_recurrente').prop('checked') == true){
            var cantidad_medicamento_necesaria = (($('#surtido_tiempo option:selected').val()*$('#surtido_numero').val())/($('#_cada option:selected').val()*$('#cada').val()))*dosis_hidden;
            if (medicamento[0].cantidad_presentacion > 1) {
                while (medicamento[0].cantidad_presentacion * cantidad_final < cantidad_medicamento_necesaria) {
                    cantidad_final++;
                }
                if (cantidad_final > medicamento[0].tope_receta) {
                    $.toaster({
                        priority: 'danger',
                        title: 'Medicamento',
                        message: 'AsegÃºrate que la cantidad entregable no sea mayor al tope de entrega',
                        settings: {
                            'timeout':10000,
                            'toaster':{
                                'css':{
                                    'top':'3em'
                                }
                            }
                        }
                    });
                    return
                }
            }else {
                $.toaster({
                    priority: 'danger',
                    css:{
                        'top': '3em'
                    },
                    title: 'Medicamento',
                    message: 'Este medicamento no cuenta con la informaciÃ³n necesaria. Te recomendamos seleccionar otro.',
                    settings: {
                        'timeout':10000,
                        'toaster':{
                            'css':{
                                'top':'3em'
                            }
                        }
                    }
                });
                return
            }

            var _duracion = '<b>'+$('#por').val();
            _duracion += ' '+$('#_por option:selected').text()+'</b>';

            recurrencia_text += 'Recoger '+cantidad_final+'<b> caja(s)</b> cada <b>'+$('#surtido_numero').val()+' '+$('#surtido_tiempo option:selected').text()+'</b> durante '+_duracion;
            recurrencia_hidden += $('#surtido_numero').val()*$('#surtido_tiempo option:selected').val();
            if(($('#surtido_tiempo option:selected').val()*$('#surtido_numero').val())>=$('#_por option:selected').val()*$('#por').val() || !($('#surtido_numero').val()>0)){
                $.toaster({
                    priority: 'danger',
                    title: 'Medicamento',
                    message: 'Verifica el tiempo de recurrencia y el de la duraciÃ³n del tratamiento',
                    settings: {
                        'timeout':10000,
                        'toaster':{
                            'css':{
                                'top':'3em'
                            }
                        }
                    }
                });
                return
            }
            veces_surtir = parseInt($('#por').val())*(parseInt($('#_por option:selected').val())/24);
            veces_surtir = veces_surtir/(recurrencia_hidden/24);

        }else {//Si no es recurrente
            var cantidad_medicamento_necesaria = (($('#_por option:selected').val()*$('#por').val())/($('#_cada option:selected').val()*($('#cada').val())))*dosis_hidden;
            if (medicamento[0].cantidad_presentacion > 1) {
                while (medicamento[0].cantidad_presentacion * cantidad_final < cantidad_medicamento_necesaria) {
                    cantidad_final++;
                }
                if (cantidad_final > medicamento[0].tope_receta) {
                    $.toaster({
                        priority: 'danger',
                        css:{
                          'top': '3em'
                        },
                        title: 'Medicamento',
                        message: 'AsegÃºrate que la cantidad entregable no sea mayor al tope de entrega',
                        settings: {
                            'timeout':10000,
                            'toaster':{
                                'css':{
                                    'top':'3em'
                                }
                            }
                        }
                    });
                    return
                }
            } else {
                $.toaster({
                    priority: 'danger',
                    css:{
                        'top': '3em'
                    },
                    title: 'Medicamento',
                    message: 'Este medicamento no cuenta con la informaciÃ³n necesaria. Te recomendamos seleccionar otro.',
                    settings: {
                        'timeout':10000,
                        'toaster':{
                            'css':{
                                'top':'3em'
                            }
                        }
                    }
                });
                return
            }
        }

        if(veces_surtir<1 || veces_surtir == null)
            veces_surtir=1;
        dosis_hidden += ' '+medicamento[0].familia;
        dosis_text += medicamento[0].familia+'</b>';

        var tiempo_text = '<b>'+$('#cada').val();
        tiempo_text += ' '+$('#_cada option:selected').text()+'</b>';
        var tiempo_hidden = $('#cada').val()+' '+$('#_cada option:selected').text();

        var duracion_text = '<b>'+$('#por').val();
        duracion_text += ' '+$('#_por option:selected').text()+'</b>';
        var duracion_hidden = $('#por').val()+' '+ $('#_por option:selected').text();

        var nota_medicamento = $('#nota_medicamento').val();
        $('.medicine_detail').append('' +
            '<tr id="'+medicamento[0].id+'">' +
                '<th scope="row">'+medicamento[0].id+'</th>' +
                '<td>' +
                    '<p><input id="_detalle['+medicamento[0].id+'][clave_cliente]" name="_detalle['+medicamento[0].id+'][clave_cliente]" type="hidden" value="'+medicamento[0].id+'"/>'+medicamento[0].text+'</p>' +
                    '<p><input id="_detalle['+medicamento[0].id+'][dosis]" name="_detalle['+medicamento[0].id+'][dosis]" type="hidden" value="'+dosis_hidden+' cada '+tiempo_hidden+' por '+duracion_hidden+'" />'+dosis_text+' cada '+tiempo_text+' por '+duracion_text+'</p>' +
                    '<p><input id="_detalle['+medicamento[0].id+'][cantidad_pedida]" name="_detalle['+medicamento[0].id+'][cantidad_pedida]" type="hidden" value="'+cantidad_final+'" />Recoger hoy: '+cantidad_final+'</p>' +
                    '<p><input id="_detalle['+medicamento[0].id+'][en_caso_presentar]" name="_detalle['+medicamento[0].id+'][en_caso_presentar]" type="hidden" value="'+nota_medicamento+'" />'+nota_medicamento+'</p>' +
                    '<p><input id="_detalle['+medicamento[0].id+'][por]" name="_detalle['+medicamento[0].id+'][por]" type="hidden" value="'+$('#por').val()*$('#_por option:selected').val()+'"/><input id="_detalle['+medicamento[0].id+'][recurrente]" name="_detalle['+medicamento[0].id+'][recurrente]" type="hidden" value="'+recurrencia_hidden+'"/>'+recurrencia_text+'</p>' +
                    '<input id="_detalle['+medicamento[0].id+'][id_cuadro]" name="_detalle['+medicamento[0].id+'][id_cuadro]" type="hidden" value="'+medicamento[0].id_cuadro+'"/>'+
                    '<input id="_detalle['+medicamento[0].id+'][veces_surtir]" name="_detalle['+medicamento[0].id+'][veces_surtir]" type="hidden" value="'+Math.ceil(veces_surtir)+'"/>'+
                '</td>' +
                '<td>' +
                    '<a onclick="eliminarFila(this)" data-toggle="tooltip" data-placement="top" title="Borrar" class="text-danger" id="'+filas+'"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a> ' +
                '</td>'+
            '</tr>');
        $('#guardar').prop('disabled',filas=0);
        $.toaster({
            priority : 'success',
            css:{
                'top': '3em'
            },
            title : 'Â¡Ã‰xito!',
            message : '<br>Medicamento agregado exitosamente',
            settings:{
                'toaster':{
                    'css':{
                        'top':'3em'
                    }
                }
            }
            });
    });

    $('#medicamento').on('change',function () {
        var medicamento = $('#medicamento').select2('data');
        $('#_dosis').val(medicamento[0].familia);
    });

    $('.unidad').on('change',function () {
        $('.medicine_detail').empty();
        $('.medicamento').select2('destroy');
        $('.medicamento').empty();
        medicamento();
    });

    //ValidaciÃ³n de medicamentos
    $('#guardar').on('click',function (e) {
        $('#medicamento_modal').text('');
        var medicamento = [];
        var medicamento_agotado = [];
        $('#detalle tbody tr').each(function (index) {
            var data = {};
            var id = this.id;
            data.clave_cliente = id;
            data.dosis = $('#dosis'+id).val();
            data.en_caso_presentar = $('#indicaciones'+id).val();

            if($('#recurrencia'+id).val()>0){
                data.recurrente = $('#recurrencia'+id).val()/24;//Se divide entre 24 para convertirlo a dÃ­as
            }else{
                data.recurrente = 0;
            }
            data.cantidad_pedida = $('#cantidad'+id).val();//Cantidad que se va a dar cada vez que se surta
            data.localidad = $('.unidad').val();
            medicamento.push(data);
            // validaciÃ³n; si los medicamentos siguen disponibles, valid = true
            $.ajax({
                url: $('#detalle').data('url'),
                type: 'GET',
                data: data,
                async: false,
                success:function (response) {
                    var arreglo = $.parseJSON(response);
                    if(arreglo['disponible']<$('#cantidad'+id).val()){//Si ya no estÃ¡ disponible, agregar al arreglo de medicamentos agotados
                        medicamento_agotado.push(arreglo);
                    }
                }
            });
        });
        if(medicamento_agotado.length>0){
            e.preventDefault();//Evita que se envÃ­e el formulario si se agotÃ³ un medicamento
            for(var i = 0;i<medicamento_agotado.length;i++){
                $('#medicamento_modal').append(medicamento_agotado[i].descripcion+'<br>');
            }
            $('#medicamento_modal').append('Â¿AÃºn asÃ­ deseas agregarlos a la receta?');
            $('#modal').modal('show');
        }else{//Si no se agotÃ³ ningÃºn medicamento
            $('form').submit();
        }
    });

    $('#aceptar').on('click',function () {//En caso de que un medicamento se agotara y aÃºn asÃ­ se desee surtir
        $('form').submit();
    });

    $('#id_dependiente').on('change',function () {
        $('#id_afiliacion').val($('#id_dependiente').select2('data')[0].afiliacion);
    })

    if($('#surtir')){
        $('.btn').prop('disabled',false);
    }
    $('#guardar').prop('disabled',true);
});

function initPaciente() {
    $(".paciente").select2({
        placeholder: 'Escriba el nÃºmero de afiliaciÃ³n o el nombre del paciente',
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
    return $('<span>'+medicine.text+'</span><br>PresentaciÃ³n: <b>'+medicine.familia+'</b> Cantidad en la presentaciÃ³n: <b>'+medicine.cantidad_presentacion+'</b>' +
        '<br>Disponibilidad: <b>'+medicine.disponible+'</b> MÃ¡ximo para recetar: <b>'+medicine.tope_receta+'</b>');
}

function eliminarFila(a) {
    $(a).closest('tr').remove();
    if($('#detalle tr').length-1<1)
        $('#guardar').prop('disabled',true);
}

function medicamento() {
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
}