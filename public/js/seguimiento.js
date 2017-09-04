$(document).ready(function () {
    descripcion();
    var data_empleado = $('#fk_id_empleado_comentario').data('url');
    $.ajax({
        type: 'GET',
        url: data_empleado,
        success: function (response) {
            $('#fk_id_empleado_comentario').val(response);
        }
    });
});

function descripcion() {
	$('#resolucion').prop('readonly',$('#solucion:checked').val() != 'on');
}