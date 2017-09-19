$('select[name="jurisdiccion"]').on('change', function() {
    var value = $(this).val();
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

$('#datetimepicker1').datetimepicker({
    pickTime: false,
});

$('#datetimepicker2').datetimepicker({
    pickTime: false,
});

$("#datetimepicker1").on("dp.change", function (e) {
	var date = new Date(e.date.valueOf());
	$('#datetimepicker2').data("DateTimePicker").setMinDate(date);
});

var chart = AmCharts.makeChart("char-1", {
    "theme": "light",
    "type": "serial",
    "dataProvider": chart1,
    "valueAxes": [{
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

var chart = AmCharts.makeChart( "char-01", {
	"theme": "light",
    "type": "serial",
    "dataProvider": chart2,
    "valueAxes": [{
        "position": "left",
        "title": "Pedido vs Entregado / Centro Salud",
    }],
    "startDuration": 1,
    "graphs": [{
        "balloonText": "Pedido para [[category]]: <b>[[value]] - $[[monto_pedido]]</b>",
        "fillAlphas": 0.9,
        "lineAlpha": 0.2,
        "title": "Pedido",
        "type": "column",
        "valueField": "cantidad_pedida",
        "labelText": "[[value]]",
        "fillColors": "#EFD216",
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
        "fillColors": "#76BEDF",
    }],
    "legend": {
        "useGraphSettings": true
      },
    "plotAreaFillAlphas": 0.1,
    "categoryField": "centro_salud",
    "categoryAxis": {
        "gridPosition": "start",
    	"labelRotation": 25,
    },
    "export": {
    	"enabled": true
     }
});

var chart = AmCharts.makeChart( "char-02", {
    "type": "pie",
    "theme": "light",
    "innerRadius": 80,
    "dataProvider": chart5,
    "valueField": "cantidad",
    "titleField": "medico",
    "outlineAlpha": 0.4,
	    "depth3D": 15,
	  	"angle": 50,
	  	"pullOutRadius": 60,
	  	"marginTop": 20,
	  	"labelText": "[[percents]]%",
	    "balloonText": "[[medico]] : <b>[[value]]</b> ([[percents]]%)</span>",
    "balloon":{
    	"fixedPosition":false
    },
    "export": {
    	"enabled": true
    }
});

var chart = AmCharts.makeChart("char-2", {
    "theme": "light",
    "type": "serial",
    "startDuration": 2,
    "dataProvider": chart3,
    "valueAxes": [{
        "position": "left",
        "axisAlpha":0,
        "gridAlpha":0
    }],
    "graphs": [{
        "balloonText": "[[category]]: [[producto]] <b>[[value]]</b>",
        "colorField": "color",
        "fillAlphas": 0.85,
        "lineAlpha": 0.1,
        "type": "column",
        "topRadius":1,
        "valueField": "cantidad_pedida",
        "labelText": "[[value]]",
    }],
    "depth3D": 40,
	"angle": 30,
    "chartCursor": {
        "categoryBalloonEnabled": false,
        "cursorAlpha": 0,
        "zoomable": false
    },
    "categoryField": "clave_cliente",
    "categoryAxis": {
        "gridPosition": "start",
        "labelRotation": 45,
        "axisAlpha":0,
        "gridAlpha":0

    },
    "export": {
    	"enabled": true
     }
});

var chart = AmCharts.makeChart("char-3", {
    "theme": "light",
    "type": "serial",
	"startDuration": 2,
    "dataProvider": chart4,
    "graphs": [{
        "balloonText": "[[category]]: <b>[[value]]</b>",
        "fillColorsField": "color",
        "fillAlphas": 0.59,
        "lineAlpha": 0.1,
        "type": "column",
        "valueField": "monto",
        "labelText": "$ [[value]]",
    }],
    "depth3D": 20,
	"angle": 30,
    "chartCursor": {
        "categoryBalloonEnabled": false,
        "cursorAlpha": 0,
        "zoomable": false
    },
    "categoryField": "clave_cliente",
    "categoryAxis": {
        "gridPosition": "start",
        "labelRotation": 30
    },
    "export": {
    	"enabled": true
     }
});