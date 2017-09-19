$(document).ready(function () {

    if(parseInt($('#estatus').val())==2 || parseInt($('#estatus').val())==4){
        $(':submit').attr('disabled','true');
    }

    $(':submit').attr('id','surtir');

    $('.number-only').keypress(function(e) {
        if (isNaN(this.value + "" + String.fromCharCode(e.charCode)) && e.charCode != 0) return false;
    })
        .on("cut copy paste", function(e) {
            e.preventDefault();
        });

    $('form').prop('action',    $('#container-fluid').data('url'));
    $('#surtir').on('click',function (e) {
        $('#medicamento_modal').text('');
        var medicamento=[];
        var medicamento_agotado=[];
        var cantidad_alta = '';
        var cantidad = 0;
        var cantidadsurtida = 0;
        $('#detalle tbody tr').each(function (index) {
            var data = {};
            var id = this.id;
            cantidad = parseInt($('#cantidadsurtir'+id).val());
            cantidadsurtida = parseInt($('#cantidad_surtida'+id).val());
            if($('#cantidad_pedida'+id).val()<cantidad || cantidad < 0 || cantidadsurtida+cantidad > $('#cantidad_pedida'+id).val() * parseInt($('#veces_surtir'+id).val()) || isNaN(cantidad)){
                cantidad_alta += '<br>'+$('#descripcion'+id).val()+'<br>';
            }
            data.clave_cliente = this.title;
            data.cantidadsurtir = cantidad;
            data.localidad = $('#id_localidad').val();
            data.detalle = id;
            medicamento.push(data);
            $.ajax({
                url: $('#detalle').data('url'),
                type: 'POST',
                data: data,
                async: false,
                success:function (response) {
                    var arreglo = $.parseJSON(response);
                     var cantidad = $('#cantidadsurtir'+id).val();
                    if(arreglo.length>0){
                        var disponible = arreglo[0].disponible;
                        var dias_pasados = arreglo[0].dias_pasados;
                        var recurrente = arreglo[0].recurrente;
                        if( parseInt(disponible)< parseInt(cantidad) || parseInt(dias_pasados)>parseInt(recurrente)){//Si ya no está disponible, agregar al arreglo de medicamentos agotados
                            medicamento_agotado.push(arreglo);
                        }
                     }else{
                         arreglo={};
                         arreglo.disponible = 0;
                         arreglo.descripcion = $('#descripcion'+id).val();
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
                            'top':'5em'
                        }
                    }
                }
            });
            return
        }

        if(medicamento_agotado.length>0){
            e.preventDefault();
            for(var i = 0;i<medicamento_agotado.length;i++){
                $('#medicamento_modal').append(medicamento_agotado[i][0].descripcion+' <b>Quedan: </b>' + medicamento_agotado[i][0].disponible +
                    '<b> Tiempo transcurrido: </b>' + medicamento_agotado[i][0].dias_pasados+'<br>');
            }
            $('#medicamento_modal').append('<br>');
            $('#modal').modal('show');
        }
    });
});

function escaparID(myid){
    return "#" + myid.replace( /(:|\.|\[|\]|,|=|@)/g, "\\$1" );
}