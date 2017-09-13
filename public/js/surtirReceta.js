$(document).ready(function () {
    $(':submit').attr('id','surtir');

    $('form').prop('action',    $('#container-fluid').data('url'));
    $('#surtir').on('click',function (e) {
        $('#medicamento_modal').text('');
        var medicamento=[];
        var medicamento_agotado=[];
        var cantidad_alta = '';
        $('#detalle tbody tr').each(function (index) {
            var data = {};
            var id = this.title;
            if($('#cantidad_pedida'+id).val()<$('#cantidadsurtir'+id).val() || !$('#cantidadsurtir'+id).val()){
                cantidad_alta += '<br>'+$('#descripcion'+id).val();
            }
            data.clave_cliente = id;
            data.cantidadsurtir = $('#cantidadsurtir'+id).val();
            data.localidad = $('#id_localidad').val();
            medicamento.push(data);
            $.ajax({
                url: $('#detalle').data('url'),
                type: 'POST',
                data: data,
                async: false,
                success:function (response) {
                    var arreglo = $.parseJSON(response);
                     var cantidad = $('#cantidadsurtir'+id).val();
                     var disponible = arreglo['disponible'];
                    if( parseInt(disponible)< parseInt(cantidad)){//Si ya no está disponible, agregar al arreglo de medicamentos agotados
                        medicamento_agotado.push(arreglo);
                    }
                }
            });
        });

        if(cantidad_alta!=''){
            e.preventDefault();
            $.toaster({
                priority : 'danger',
                title : 'Verifica las cantidades a surtir de los siguientes productos',
                message : cantidad_alta,
                settings:{
                    'donotdismiss':['danger'],
                    'toaster':{
                        'css':{
                            'top':'3em'
                        }
                    }
                }
            });
            return
        }

        if(medicamento_agotado.length>0){
            e.preventDefault();
            for(var i = 0;i<medicamento_agotado.length;i++){
                $('#medicamento_modal').append(medicamento_agotado[i].descripcion+' <b>Quedan: </b>'+medicamento_agotado[i].disponible+'<br>');
            }
            $('#medicamento_modal').append('<br>');
            $('#modal').modal('show');
        }

    });
});