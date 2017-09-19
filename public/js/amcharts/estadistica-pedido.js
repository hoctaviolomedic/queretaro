$('select[name="jurisdiccion"]').on('change', function() {
    // alert($("#id_localidad").data('url'));
    var value = $(this).val();
    // alert(id_localidad);
    if(value) {
        $.ajax({
            type: "POST",
            url: $("#jurisdiccion").data('url'),
            data: 'jurisdiccion='+value,
            dataType: "json",
            success:function(data) {
                datos = $.parseJSON(data);
                $('select[name="localidad"]').empty();
                $.each(datos, function(key, value) {
                    $('select[name="localidad"]').append('<option value="'+ key +'">'+ value +'</option>');
                });
                $('select[name="localidad"]').val(-999);
            }
        });

    }else{
        $('select[name="localidad"]').empty();
    }
});


var chart = AmCharts.makeChart("char-1", {
    "theme": "light",
    "type": "serial",
    "dataProvider": chart1,
    "valueAxes": [{
        //"unit": "%",
        "position": "left",
        "title": "Pedido vs Entregado / Jurisdiccion",
    }],
    "startDuration": 1,
    "graphs": [{
        "balloonText": "Pedido para [[category]]: <b>[[value]] - $[[monto_entregado]]</b>",
        "fillAlphas": 0.9,
        "lineAlpha": 0.2,
        "title": "Pedido",
        "type": "column",
        "valueField": "cantidad_pedida",
        "labelText": "[[value]]",
    }, {
        "balloonText": "Entregado para [[category]]: <b>[[value]] - $[[monto_entregado]]</b>",
        "fillAlphas": 0.9,
        "lineAlpha": 0.2,
        "title": "Entregado",
        "type": "column",
        "clustered":false,
        "columnWidth":0.5,
        "valueField": "cantidad_entregada",
        "labelText": "<br>[[value]]",
    }],
    "legend": {
        "useGraphSettings": true
      },
    "plotAreaFillAlphas": 0.1,
    "categoryField": "jurisdiccion",
    "categoryAxis": {
        "gridPosition": "start",
        "labelRotation": 45,
    },
    "export": {
    	"enabled": true
     }
});