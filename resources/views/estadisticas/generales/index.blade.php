@extends('layouts.dashboard')

@section('header-top')
@endsection

@section('header-bottom')
    <!--Plugins para los charts-->
    {{ HTML::script(asset('js/amcharts/amcharts.js')) }}
    {{ HTML::script(asset('js/amcharts/pie.js')) }}
    {{ HTML::script(asset('js/amcharts/export.min.js')) }}
    {{ HTML::script(asset('js/amcharts/themes/light.js')) }}
    
    <script type="text/javascript">
		$(document).ready(function() {
        	$(".js-example-basic-single").select2({       
            	"language": { //para cambiar el idioma a español
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

            var chart = AmCharts.makeChart( "piepadecimientos", {
                "type": "pie",
                "theme": "light",
                "dataProvider": {!! !empty($padecimientos) ? $padecimientos->toJson() : '[]' !!} ,
                "valueField": "total",
                "titleField": "nombre",
                "outlineAlpha": 0.4,
          	    "depth3D": 15,
          	  	"angle": 50,
          	  	"pullOutRadius": 60,
          	  	"marginTop": 20,
          	  	"labelText": "[[clave]] : [[percents]]%",
          	    "balloonText": "<b>[[clave]] :</b> [[nombre]]<br><span style='font-size:14px'><b>[[value]]</b> ([[percents]]%)</span>",
                "balloon":{
                	"fixedPosition":false
                },
                "export": {
                	"enabled": true
                }
            });

            var chart = AmCharts.makeChart( "piepacientes", {
                "type": "pie",
                "theme": "light",
                "dataProvider": {!! !empty($pacientes) ? $pacientes->toJson() : '[]' !!} ,
                "valueField": "total",
                "titleField": "nombre",
                "outlineAlpha": 0.4,
                "depth3D": 15,
                "innerRadius": "40%",
                "pullOutRadius": 20,
                "labelText": "[[percents]]%",
          	    "balloonText": "[[nombre]]<br><span style='font-size:14px'><b>[[value]]</b> ([[percents]]%)</span>",
                "balloon":{
                	"fixedPosition":true
                },
                "angle": 30,
                "export": {
                	"enabled": true
                }
            });

            var chart = AmCharts.makeChart( "piemedicos", {
                "type": "pie",
                "theme": "light",
                "dataProvider": {!! !empty($medicos) ? $medicos->toJson() : '[]' !!} ,
                "valueField": "total",
                "titleField": "nombre",
                "startEffect": "elastic",
                "outlineAlpha": 0.4,
          	    "depth3D": 20,
          	  	"angle": 50,
          	  	"pullOutRadius": 20,
          	  	"labelText": "[[cedula]] : [[percents]]%",
          	    "balloonText": "<b>[[cedula]] :</b>[[nombre]]<br><span style='font-size:14px'><b>[[value]]</b> ([[percents]]%)</span>",
                "balloon":{
                	"fixedPosition":true,
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
    		<h3 class="panel-title text-center">Estad&#237;sticas Generales</h3>
    	</div>
    	<div class="panel-body">
    		{!! Form::open(['url' => companyRoute('index'), 'id' => 'form-model', 'class' => 'row']) !!}
    			<div class="col-md-6 col-sm-12 col-xs-12">
    				<div class="form-group">
                        {{ Form::label('localidades', 'Localidad:') }}
                        {{ Form::select('localidades', $localidades, null, ['id'=>'localidades','class'=>'form-control']) }}
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
    
    		@if(!empty($padecimientos))
    		<div class="divider"></div>
			
            <div class="row">
            	<div class="col-lg-6 col-md-12">
                	<h4>Padecimientos:</h4>
                  	<div class="form-group">
                    	<div class="charts">
                    		<div id="piepadecimientos" class="chart"></div>
                    	</div>
                  	</div>
                </div>
                <div class="col-lg-6 col-md-12 border-right table-responsive">
                	<table class="table table-striped table-hover">
                		@if(isset($padecimientos[0]))
                        <thead>
                        	<tr>
                                @foreach($padecimientos[0] as $col=>$value)
                                <th>{{$col}}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                                @foreach($padecimientos as $row)
                                <tr>
                                    @foreach($row as $value)
                                    <th>{{$value}}</th>
                                    @endforeach
                                </tr>
                                @endforeach
                        </tbody>
                        @endif
                	</table>
                </div>
    		</div>
    		@endif
    
    		@if(!empty($pacientes))
            <div class="divider"></div>
            
            <div class="row">
                <div class="col-lg-6 col-md-12 border-right table-responsive">
                	<h4>Pacientes:</h4>
                	<table class="table table-striped table-hover">
                		@if(isset($pacientes[0]))
                        <thead>
                        	<tr>
                                @foreach($pacientes[0] as $col=>$value)
                                <th>{{$col}}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                                @foreach($pacientes as $row)
                                <tr>
                                    @foreach($row as $value)
                                    <th>{{$value}}</th>
                                    @endforeach
                                </tr>
                                @endforeach
                        </tbody>
                        @endif
                	</table>
                </div>
                <div class="col-lg-6 col-md-12">
                  	<div class="charts">
                    	<div class="charts">
                    		<div id="piepacientes" class="chart"></div>
                    	</div>
                  	</div>
                </div>
    		</div>
    		@endif
    
          	@if(!empty($medicos))
          	<div class="divider"></div>
    		
            <div class="row">
            	<div class="col-lg-6 col-md-12">
                	<h4>Medicos:</h4>
                  	<div class="form-group">
                    	<div class="charts">
                    		<div id="piemedicos" class="chart"></div>
                    	</div>
                  	</div>
                </div>
                <div class="col-lg-6 col-md-12 border-right table-responsive">
                	<table class="table table-striped table-hover">
                		@if(isset($medicos[0]))
                        <thead>
                        	<tr>
                                @foreach($medicos[0] as $col=>$value)
                                <th>{{$col}}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                                @foreach($medicos as $row)
                                <tr>
                                    @foreach($row as $value)
                                    <th>{{$value}}</th>
                                    @endforeach
                                </tr>
                                @endforeach
                        </tbody>
                        @endif
                	</table>
                </div>
    		</div>
    		@endif

    	</div><!--/panel-body-->
	</div><!--/panel-->
</div>
@endsection
