@extends('layouts.dashboard')

@section('header-top')
	<style>
        #piepacientes .amcharts-chart-div, #piepacientes .amcharts-chart-div svg,
        #piemedicos .amcharts-chart-div, #piemedicos .amcharts-chart-div svg {
            height: 90vh !important;
        }
        .divider {
            border-bottom: 2px solid #FFAA00;
            box-shadow: 1px 1px 2px #DCB;
        }
    </style>
@endsection

@section('header-bottom')
    <!--Plugins para los charts-->
    {{ HTML::script(asset('js/amcharts/amcharts.js')) }}
    {{ HTML::script(asset('js/amcharts/serial.js')) }}
    {{ HTML::script(asset('js/amcharts/export.min.js')) }}
    {{ HTML::script(asset('js/amcharts/themes/light.js')) }}

    <script type="text/javascript">
		$(document).ready(function() {
        	$(".js-example-basic-single").select2({       
            	"language": { //para cambiar el idioma a espa�ol
                "noResults": function(){
                	return "No se encontraron resultados";
                }
            	},
                escapeMarkup: function (markup) {
                    return markup;
            	}
          	});
    
            $('#datetimepicker1').datetimepicker({
              pickTime: false,
            });
            
            $('#datetimepicker2').datetimepicker({
              pickTime: false,
              useCurrent: false,
            });
            
            $("#datetimepicker1").on("dp.change", function (e) {
              $('#datetimepicker2').data("DateTimePicker").minDate(e.date);
            });
            
            $("#datetimepicker2").on("dp.change", function (e) {
              $('#datetimepicker1').data("DateTimePicker").maxDate(e.date);
            });

            var chart = AmCharts.makeChart( "pieproductos", {
                "type": "serial",
                "theme": "light",
                "dataProvider": {!! !empty($productos) ? $productos->toJson() : '[]' !!} ,
                "valueAxes": [ {
                    "gridColor": "#FFFFFF",
                    "gridAlpha": 0.2,
                    "dashLength": 0
                  } ],
                  "gridAboveGraphs": true,
                  "startDuration": 1,
                  "depth3D": 20,
              	  "angle": 30,
                  "graphs": [ {
                	"fillColorsField": "color",
                    "balloonText": "[[producto]]: <b>[[cantidad]]</b>",
                    "fillAlphas": 0.8,
                    "lineAlpha": 0.2,
                    "type": "column",
                    "valueField": "cantidad",
                    "labelText": "[[value]]",
                  } ],
                  "chartCursor": {
                    "categoryBalloonEnabled": false,
                    "cursorAlpha": 0,
                    "zoomable": false
                  },
                  "categoryField": "clave",
                  "categoryAxis": {
                    "gridPosition": "start",
                    "gridAlpha": 0,
                    "tickPosition": "start",
                    "tickLength": 20
                  },
                  "export": {
                	"enabled": true
                  }
            });

            var chart = AmCharts.makeChart( "pierecetas", {
                "type": "serial",
                "theme": "light",
                "dataProvider": {!! !empty($recetas) ? $recetas->toJson() : '[]' !!} ,
                "valueAxes": [ {
                    "gridColor": "#FFFFFF",
                    "gridAlpha": 0.2,
                    "dashLength": 0
                  } ],
                  "gridAboveGraphs": true,
                  "startDuration": 1,
                  "depth3D": 30,
              	  "angle": 20,
                  "graphs": [ {
                	"fillColorsField": "color",
                    "balloonText": "[[producto]]: <b>[[cantidad]]</b>",
                    "fillAlphas": 0.8,
                    "lineAlpha": 0.2,
                    "type": "column",
                    "valueField": "cantidad",
                    "labelText": "[[value]]",
                  } ],
                  "chartCursor": {
                    "categoryBalloonEnabled": false,
                    "cursorAlpha": 0,
                    "zoomable": false
                  },
                  "categoryField": "folio",
                  "categoryAxis": {
                    "gridPosition": "start",
                    "gridAlpha": 0,
                    "tickPosition": "start",
                    "tickLength": 20
                  },
                  "export": {
                	"enabled": true
                  }
            });
            
            var chart = AmCharts.makeChart( "piepacientes", {
                "type": "serial",
                "theme": "light",
                "rotate": true,
                "dataProvider": {!! !empty($pacientes) ? $pacientes->toJson() : '[]' !!} ,
                "valueAxes": [ {
                    "gridColor": "#FFFFFF",
                    "gridAlpha": 0.2,
                    "dashLength": 0
                  } ],
                  "gridAboveGraphs": true,
                  "startDuration": 1,
                  "depth3D": 30,
              	  "angle": 20,
              	  
                  "graphs": [ {
                	"fillColorsField": "color",
                    "balloonText": "[[producto]]: <b>[[cantidad]]</b>",
                    "fillAlphas": 0.8,
                    "lineAlpha": 0.2,
                    "type": "column",
                    "valueField": "cantidad",
                    "labelText": "[[value]]",
                  } ],
                  "chartCursor": {
                    "categoryBalloonEnabled": false,
                    "cursorAlpha": 0,
                    "zoomable": false
                  },
                  "categoryField": "clave",
                  "categoryAxis": {
                    "gridPosition": "start",
                    "gridAlpha": 0,
                    "tickPosition": "start",
                    "tickLength": 15,
                  },
                  "export": {
                	"enabled": true
                  }
            });

            var chart = AmCharts.makeChart( "piemedicos", {
                "type": "serial",
                "theme": "light",
                "rotate": true,
                "dataProvider": {!! !empty($medicos) ? $medicos->toJson() : '[]' !!} ,
                "valueAxes": [ {
                    "gridColor": "#FFFFFF",
                    "gridAlpha": 0.2,
                    "dashLength": 0
                  } ],
                  "gridAboveGraphs": true,
                  "startDuration": 1,
                  "depth3D": 20,
              	  "angle": 30,
                  "graphs": [ {
                	"fillColorsField": "color",
                    "balloonText": "[[producto]]: <b>[[cantidad]]</b>",
                    "fillAlphas": 0.8,
                    "lineAlpha": 0.2,
                    "type": "column",
                    "valueField": "cantidad",
                    "labelText": "[[value]]",
                  } ],
                  "chartCursor": {
                    "categoryBalloonEnabled": false,
                    "cursorAlpha": 0,
                    "zoomable": false
                  },
                  "categoryField": "clave",
                  "categoryAxis": {
                    "gridPosition": "start",
                    "gridAlpha": 0,
                    "tickPosition": "start",
                    "tickLength": 20
                  },
                  "export": {
                	"enabled": true
                  }
            });
        });
    </script>
@endsection

@section('content')
<div class="container-fluid">
	<div class="panel shadow-3 panel-danger">
    	<div class="panel-heading">
    		<h3 class="panel-title text-center">Estad&#237;sticas de Consumo</h3>
    	</div>
    	<div class="panel-body">
    		{!! Form::open(['url' => companyRoute('index'), 'id' => 'form-model', 'class' => 'row']) !!}
    			<div class="col-md-6 col-sm-12 col-xs-12">
    				<div class="form-group">
                        {{ Form::label('localidades', 'Localidad:') }}
                        {{ Form::select('localidades', $localidades, null, ['id'=>'localidades','class'=>'js-data-example-ajax1 form-control','style'=>'100%']) }}
                        {{ $errors->has('localidades') ? HTML::tag('span', $errors->first('localidades'), ['class'=>'help-block deep-orange-text']) : '' }}
                    </div>
        		</div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                	<div class="form-group">
                        {{ Form::label('datetimepicker1', '* Fecha inicio:') }}
                        <div class='input-group date' id='datetimepicker1'>
                        	{{Form::text('datetimepicker1',null,['class'=>'form-control','data-format'=>'yyyy-MM-dd'])}}
                        	<span class="input-group-btn add-on">
                            	<button data-date-icon="icon-calendar" class="btn btn-default btn-check" type="button"><span class="glyphicon glyphicon-calendar"></span></button>
                            </span>
                        </div>
                	</div>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                	<div class="form-group">
                        {{ Form::label('datetimepicker2', '* Fecha final:') }}
                        <div class='input-group date' id='datetimepicker2'>
                        	{{Form::text('datetimepicker2',null,['class'=>'form-control','data-format'=>'yyyy-MM-dd'])}}
                        	<span class="input-group-btn add-on">
                            	<button data-date-icon="icon-calendar" class="btn btn-default btn-check" type="button"><span class="glyphicon glyphicon-calendar"></span></button>
                            </span>
                        </div>
                	</div>
                </div>
                <div class="text-center">
                	<button type="submit" class="btn btn-danger">Aceptar</button>
                    <!--<button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Imprimir</button>-->
                </div>
    		{!! Form::close() !!}
    
    		<div class="divider"></div>
    
            <div class="row">
            	<div class="col-lg-6 col-md-12 table-responsive">
                    <h4>Consumo general por productos:</h4>
            		@if(!empty($productos))
            		<div class="row">
                      	<div class="form-group">
                        	<div class="charts">
                        		<div id="pieproductos" class="chart"></div>
                        	</div>
                      	</div>
                    </div>
                  	<table class="table table-striped table-hover row">
                		@if(isset($productos[0]))
                        <thead>
                        	<tr>
                                @foreach($productos[0] as $col=>$value)
                                @if($col != 'color')
                                <th>{{$col}}</th>
                                @endif
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($productos as $row)
                            <tr>
                                @foreach($row as $col=>$value)
                                @if($col != 'color')
                                <th>{{$value}}</th>
                                @endif
                                @endforeach
                            </tr>
                            @endforeach
                        </tbody>
                        @endif
                	</table>
                	@endif
                </div>
                <div class="col-lg-6 col-md-12 border-right table-responsive">
                    <h4>Productos por Receta:</h4>
                	@if(!empty($recetas))
                	<div class="row">
                      	<div class="form-group">
                        	<div class="charts">
                        		<div id="pierecetas" class="chart"></div>
                        	</div>
                      	</div>
                    </div>
                    <table class="table table-striped table-hover row">
                		@if(isset($recetas[0]))
                        <thead>
                        	<tr>
                                @foreach($recetas[0] as $col=>$value)
                                @if($col != 'color')
                                <th>{{$col}}</th>
                                @endif
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recetas as $row)
                            <tr>
                                @foreach($row as $col=>$value)
                                @if($col != 'color')
                                <th>{{$value}}</th>
                                @endif
                                @endforeach
                            </tr>
                            @endforeach
                        </tbody>
                        @endif
                	</table>
                	@endif
                </div>
    		</div>
    
            <div class="divider"></div>
            
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
              <li role="presentation" class="active"><a href="#paciente" aria-controls="paciente" role="tab" data-toggle="tab">Paciente</a></li>
              <li role="presentation"><a href="#medico" aria-controls="medico" role="tab" data-toggle="tab">Médico</a></li>
            </ul>
        
            <!-- Tab panes -->
            <div class="tab-content">
        		<div role="tabpanel" class="tab-pane fade in active" id="paciente">
              		<div class="row">
                    	<div class="col-lg-6 col-md-12">
                        	<h4>Productos por paciente:</h4>
                        	@if(!empty($pacientes))
                    		<div class="row">
                            	<div class="charts">
                            		<div id="piepacientes" class="chart chartpaciente"></div>
                            	</div>
                            </div>
                            @endif
                        </div>
                        <div class="col-lg-6 col-md-12 table-responsive">
                        	@if(!empty($pacientes))
                        	<table class="table table-striped table-hover row">
                        		@if(isset($pacientes[0]))
                                <thead>
                                	<tr>
                                        @foreach($pacientes[0] as $col=>$value)
                                        @if($col != 'color')
                                        <th>{{$col}}</th>
                                        @endif
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pacientes as $row)
                                    <tr>
                                        @foreach($row as $col=>$value)
                                		@if($col != 'color')
                                        <th>{{$value}}</th>
                                        @endif
                                        @endforeach
                                    </tr>
                                    @endforeach
                                </tbody>
                                @endif
                        	</table>
                        	@endif
                        </div>
                    </div>
                </div>
        		<div role="tabpanel" class="tab-pane fade in" id="medico">
                	<div class="row">
                    	<div class="col-lg-6 col-md-12">
                        	<h4>Productos por médico:</h4>
                        	@if(!empty($medicos))
                    		<div class="row">
                              	<div class="form-group">
                                	<div class="charts">
                                		<div id="piemedicos" class="chart"></div>
                                	</div>
                              	</div>
                            </div>
                          	@endif
                        </div>
                        <div class="col-lg-6 col-md-12 table-responsive">
                        	@if(!empty($medicos))
                        	<table class="table table-striped table-hover row">
                        		@if(isset($medicos[0]))
                                <thead>
                                	<tr>
                                        @foreach($medicos[0] as $col=>$value)
                                        @if($col != 'color')
                                        <th>{{$col}}</th>
                                        @endif
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($medicos as $row)
                                    <tr>
                                        @foreach($row as $col=>$value)
                                		@if($col != 'color')
                                        <th>{{$value}}</th>
                                        @endif
                                        @endforeach
                                    </tr>
                                    @endforeach
                                </tbody>
                                @endif
                        	</table>
                        	@endif
                        </div>
                    </div>
        		</div>
        	</div><!--/fin del tab-->

    	</div><!--/panel-body-->
	</div><!--/panel-->
</div>
@endsection
