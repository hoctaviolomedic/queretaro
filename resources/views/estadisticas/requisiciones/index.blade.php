@extends('layouts.dashboard')

@section('header-top')
	@parent
	<style>
        .amcharts-chart-div, .amcharts-chart-div svg {
            height: 44vh !important;
        }
        .divider {
            border-bottom: 3px solid #FFAA00;
            box-shadow: 1px 1px 2px #DCB;
        }
    </style>
@endsection

@section('header-bottom')
    <!--Plugins para los charts-->
    {{ HTML::script(asset('js/amcharts/amcharts.js')) }}
    {{ HTML::script(asset('js/amcharts/serial.js')) }}
    {{ HTML::script(asset('js/amcharts/pie.js')) }}
    {{ HTML::script(asset('js/amcharts/export.min.js')) }}
    {{ HTML::script(asset('js/amcharts/themes/light.js')) }}
    {{ HTML::script(asset('js/amcharts/plugins/animate/animate.min.js')) }}
    
    <!-- Data for Charts-->
    <script>
    	var chart1 = {!! !empty($char1) ? $char1->toJson() : '[]' !!};
    	var chart2 = {!! !empty($char01) ? $char01->toJson() : '[]' !!};
    	var chart3 = {!! !empty($char2) ? $char2->toJson() : '[]' !!};
    	var chart4 = {!! !empty($char3) ? $char3->toJson() : '[]' !!};
    	var chart5 = {!! !empty($char02) ? $char02->toJson() : '[]' !!};
    </script>
    <!-- Code Charts-->
    {{ HTML::script(asset('js/estadistica-requisiciones.js')) }}
    
@endsection

@section('content')

<div class="container-fluid">
	<div class="panel shadow-3 panel-danger">
    	<div class="panel-heading">
    		<h3 class="panel-title text-center">Estad&#237;sticas de Requisiciones Hospitalarias</h3>
    	</div>
    	<div class="panel-body">
    		{!! Form::open(['url' => companyRoute('index'), 'id' => 'form-model', 'class' => 'row']) !!}
    			<div class="col-md-4 col-sm-6 col-xs-12">
    				<div class="form-group">
                        {{ Form::label('jurisdiccion', 'Jurisdiccion:') }}
                        {{ Form::select('jurisdiccion', $jurisdicciones, null, ['id'=>'jurisdiccion','class'=>'form-control','data-url'=>companyRoute('getlocalidades')]) }}
                        {{ $errors->has('jurisdiccion') ? HTML::tag('span', $errors->first('jurisdiccion'), ['class'=>'help-block deep-orange-text']) : '' }}
                    </div>
        		</div>
        		<div class="col-md-4 col-sm-6 col-xs-12">
    				<div class="form-group">
                        {{ Form::label('localidad', 'Centro Salud:') }}
                        {{ Form::select('localidad', $localidades, null, ['id'=>'localidad','class'=>'form-control']) }}
                        {{ $errors->has('localidad') ? HTML::tag('span', $errors->first('localidad'), ['class'=>'help-block deep-orange-text']) : '' }}
                    </div>
        		</div>
                <div class="col-md-2 col-sm-6 col-xs-12">
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
                <div class="col-md-2 col-sm-6 col-xs-12">
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
    
    		@if(!empty($char01))
    		<div class="divider"></div>
			
            <div class="row">
            	<h3 class="text-danger text-center">Requisicion vs Entregado</h3>
            	<div class="col-lg-6 col-md-12">
                  	<div class="form-group">
                    	<div class="charts">
                    		<div id="char-1" class="chart"></div>
                    	</div>
                  	</div>
                </div>
                <div class="col-lg-6 col-md-12">
                  	<div class="form-group">
                    	<div class="charts">
                    		<div id="char-01" class="chart"></div>
                    	</div>
                  	</div>
                </div>
                <div class="col-lg-12 col-md-12 border-right table-responsive">
                
                	<table class="table table-striped table-hover">
                		@if(isset($char01[0]))
                        <thead>
                        	<tr>
                                @foreach($char01[0] as $col=>$value)
                                <th>{{str_replace('_',' ',$col)}}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                                @foreach($char01 as $row)
                                <tr>
                                    @foreach($row as $col=>$value)
                                    	@if(strstr($col,'monto'))
                                        <th>${{number_format($value,2,'.',',')}}</th>
                                        @elseif(strstr($col,'cantidad'))
                                        <th>{{number_format($value,0,'.',',')}}</th>
                                        @else
                                        <th>{{$value}}</th>
                                        @endif
                                    @endforeach
                                </tr>
                                @endforeach
                        </tbody>
                        @endif
                	</table>
                	
                </div>
    		</div>
    		@endif
    		
    		@if(!empty($char02))
            <div class="divider"></div>
            
    		<div class="row">
            	<div class="col-lg-6 col-md-12">
                	<h4>Productos Area:</h4>
                	@if(!empty($char02))
            		<div class="row">
                      	<div class="form-group">
                        	<div class="charts">
                        		<div id="char-02" class="chart"></div>
                        	</div>
                      	</div>
                    </div>
                  	@endif
                </div>
                <div class="col-lg-6 col-md-12 table-responsive">
                	@if(!empty($char02))
                	<table class="table table-striped table-hover row">
                		@if(isset($char02[0]))
                        <thead>
                        	<tr>
                                @foreach($char02[0] as $col=>$value)
                                @if($col != 'color')
                                <th>{{$col}}</th>
                                @endif
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($char02 as $row)
                            <tr>
                                @foreach($row as $col=>$value)
                                    @if($col != 'color')
                                    	@if($col == 'cantidad_pedida')
                                        <th class="text-right">{{number_format($value,0,'.',',')}}</th>
                                        @elseif($col == 'monto')
                                        <th class="text-right">${{number_format($value,2,'.',',')}}</th>
                                        @else
                                        <th>{{$value}}</th>
                                        @endif
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
    		@endif
    		
    		@if(!empty($char2))
            <div class="divider"></div>
            
            <div class="row">
            	<h3 class="text-danger text-center">Top 10 productos con mayor consumo por pieza</h3>
                <div class="col-lg-6 col-md-12 border-right table-responsive">
                	<table class="table table-striped table-hover">
                		@if(isset($char2[0]))
                        <thead>
                        	<tr>
                                @foreach($char2[0] as $col=>$value)
                                @if($col != 'color')
                                <th>{{str_replace('_',' ',$col)}}</th>
                                @endif
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                                @foreach($char2 as $row)
                                <tr>
                                    @foreach($row as $col=>$value)
                                    @if($col != 'color')
                                    	@if($col == 'cantidad_pedida')
                                        <th class="text-right">{{number_format($value,0,'.',',')}}</th>
                                        @elseif($col == 'monto')
                                        <th class="text-right">${{number_format($value,2,'.',',')}}</th>
                                        @else
                                        <th>{{$value}}</th>
                                        @endif
                                    @endif
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
                    		<div id="char-2" class="chart"></div>
                    	</div>
                  	</div>
                </div>
    		</div>
    		@endif
    
          	@if(!empty($char3))
          	<div class="divider"></div>
    		
            <div class="row">
            	<h3 class="text-danger text-center">Top 10 productos con mayor consumo por monto</h3>
            	<div class="col-lg-6 col-md-12">
                  	<div class="form-group">
                    	<div class="charts">
                    		<div id="char-3" class="chart"></div>
                    	</div>
                  	</div>
                </div>
                <div class="col-lg-6 col-md-12 border-right table-responsive">
                	<table class="table table-striped table-hover">
                		@if(isset($char3[0]))
                        <thead>
                        	<tr>
                                @foreach($char3[0] as $col=>$value)
                                @if($col != 'color')
                                <th>{{str_replace('_',' ',$col)}}</th>
                                @endif
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                                @foreach($char3 as $row)
                                <tr>
                                    @foreach($row as $col=>$value)
                                    @if($col != 'color')
                                        @if($col == 'monto')
                                        <th class="text-right">${{number_format($value,2,'.',',')}}</th>
                                        @elseif($col == 'cantidad')
                                        <th class="text-right">{{number_format($value,0,'.',',')}}</th>
                                        @else
                                        <th>{{$value}}</th>
                                        @endif
                                    @endif
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
