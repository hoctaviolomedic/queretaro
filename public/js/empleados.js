function activar_infonavit() {

    var on = $('#infonavit_activo:checked').val();
    if ($('#infonavit_activo:checked').val() == 'on')
    {$('#numero_infonavit').prop('disabled',false);}
    else
    {$('#numero_infonavit').prop('disabled',true);}
}