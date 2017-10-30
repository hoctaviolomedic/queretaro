<html>
<head>
    <style type="text/css">
        * {
            font-family: Arial,Helvetica Neue,Helvetica,sans-serif;
            font-size: 11px;
            margin: 0px;
            padding: 0px;
        }
        body {
            padding: 2em 1.4em;
        }
        img {
            margin-top:12px;
            padding:0px;
            border:0px;
        }
        table {
            border-spacing: 0;
            border-collapse: collapsed;
        }
        td, th{
            border: none;
            border-collapse: collapse;
            padding: 2px;
        }
        table thead{
            border-bottom: 2px solid #ccc;
            border-collapse: collapse;
        }
        table tfoot{
            border-top: 2px solid #ccc;
            border-collapse: collapse;
        }
        .panel {
            padding:0px;
            margin:0px;
            background-color: #fff;
            border: 1px solid #919191;
            border-radius: 4px;
        }
        .panel-heading {
            padding: 10px;
            #border-bottom: 1px solid #919191;
            border-top-left-radius: 3px;
            border-top-right-radius: 3px;
        }
        .panel-body {
            padding: 10px 12px;
        }
        .panel-foot {
            padding: 10px;
            border-top: 1px solid #919191;
            border-bottom-left-radius: 3px;
            border-bottom-right-radius: 3px;
        }
        .row {
            position: relative !important;
            margin:0;
            margin-right: -5px;
            margin-left: -5px;
            width: 100%;
            overflow: hidden !important;
            display: block;
        }
        .col-12, .col-11, .col-10, .col-9, .col-8, .col-7, .col-6, .col-5, .col-4, .col-3, .col-2, .col-1 {
            position: relative !important;
            overflow: hidden !important;
            display: inline-block;
            min-height: 1px;
            padding: 6px 2px;
        }
        .col-12 {width: 100%;}
        .col-11 {width: 88.33%;}
        .col-10 {width: 80.3%;}
        .col-9  {width: 72.27%;}
        .col-8  {width: 64.24%;}
        .col-7  {width: 56.21%;}
        .col-6  {width: 48.18%;}
        .col-5  {width: 40.15%;}
        .col-4  {width: 32.12%;}
        .col-3  {width: 24.09%;}
        .col-2  {width: 16.06%;}
        .col-1  {width: 8.03%;}
        .float-left{
            float:left;
        }
        .float-right{
            float: right;
        }
        .text-left{
            text-align: left !important;
        }
        .text-right{
            text-align: right !important;
        }
        .text-center{
            text-align: center !important;
        }
        .text-justify{
            text-align: justify;
        }
        .mt-3{
            margin-top: 3em;
        }
        .mt-1{
            margin-top: 1em;
        }
        .fx-10 {
            font-size: 10px;
        }
    </style>
</head>
<body>
<div class="row">
    <div class="panel-heading text-center" style="background-color: #f4f4f4;">
        <span style="text-align: left"><b>SURTIDO DE RECETA MEDICA</b></span>
    </div>
    <div class="panel-body">
        <div class="text-center">
        
            <div class="row">
                <div>Folio Surtido: <b>{{$data->id_surtido_receta}}</b></div>
                <div><img src="data:image/png;charset=binary;base64,{{$barcode}}" style="width: 98px;" /></div>
                <div><img src="data:image/png;charset=binary;base64,{{$qr}}" style="width: 72px;" /></div>
        	</div>
            <div class="row mt-1">
                <div>Unidad Medica:</div>
                <div><b>{{$data->receta->localidad->localidad}}</b></div>
            </div>
            <div class="row mt-1">
                <div>Surtido Por:</div>
                <div><b>{{$data->surtido_por}}</b></div>
            </div>
            <div class="row mt-1">
                <div>Fecha Hora de Surtido:</div>
                <div><b>{{$data->fecha_surtido}}</b></div>
            </div>
        
            <div class="row mt-1">
                <div>Area:</div>
                <div><b>{{$data->receta->area->area ?? ''}}</b></div>
            </div>
            <div class="row mt-1">
            	<div>Programa:</div>
                <div><b>{{$data->receta->programa->nombre_programa ?? ''}}</b></div>
        	</div>
        	<div class="row mt-1">
                <div>Fecha Receta:</div>
                <div><b>{{$data->receta->fecha}}</b></div>
            </div>
        	<div class="row mt-1">
                <div>Folio Receta:</div>
                <div><b>{{$data->receta->folio}}</b></div>
            </div>
        
            <div class="row mt-1">
                <div>Paciente:</div>
                <div><b>{{$data->receta->nombre_completo_paciente}}</b></div>
            </div>
            <div class="row mt-1">
                <div>Cedula - Nombre Medico:</div>
                <div><b>{{$data->receta->medico->cedula}} - {{$data->receta->medico->nombre_completo}}</b></div>
            </div>
            <div class="row mt-1">
                <div>Diagnostico:</div>
                <div><b>{{substr($data->receta->diagnostico->diagnostico,0,80)}}</b></div>
            </div>
        </div>
        
        @if(isset($data->detalles) && !empty($data->detalles->toArray()))
        <table class="mt-3">
        	<thead>
        		<tr>
            		<th colspan="2" class="text-center">PRODUCTOS SURTIDOS</th>
                </tr>
        	</thead>
            <tbody class="medicine_detail">
            <?php $total = 0; ?>
                @foreach($data->detalles as $detalle)
                	<tr>
                		<th>Clave</th>
                        <td class="text-center">{{$detalle->recetadetalle->clave_cliente ?? null}}</td>
                    </tr>
                    <tr>
                    	<th>Descripcion</th>
                        <td class="text-center fx-10">{{substr($detalle->recetadetalle->producto->descripcion,0,100) ?? null}}</td>
                    </tr>
                    <tr>
                    	<th>Cantidad Recetada</th>
                        <td class="text-right">{{$detalle->recetadetalle->cantidad_pedida ?? null}}</td>
                    </tr>
                    <tr>    
                        <th>Cantidad Surtida</th>
                        <td class="text-right">{{$detalle->cantidad_surtida ?? null}}</td>
                    </tr>
                    <tr>
                        <th>Precio Unitario</th>
                        <td class="text-right">$ {{$detalle->precio_unitario ?? null}}</td>
                    </tr>
                    <tr >
                        <th style="border-bottom:1px dashed #ccc;">Importe</th>
                        <td style="border-bottom:1px dashed #ccc;" class="text-right">$ {{$importe = (($detalle->precio_unitario ?? 0) * ($detalle->cantidad_surtida ?? 0))}}</td>
                    </tr>
                    <?php $total = $total+$importe; ?>
                @endforeach
            </tbody>
            <tfoot>
            	<tr>
                    <th>TOTAL:</th>
                    <th class="text-right">$ {{$total}}</th>
                </tr>
            </tfoot>
        </table>
        @endif

		@if($data->cancelado)
		<div class="text-center mt-3">
            <div class="row mt-1">
                <div>Fecha Cancelacion:</div>
                <div><b>{{$data->fecha_cancelado}}</b></div>
            </div>
            <div class="row mt-1">
                <div>Motivo Cancelacion:</div>
                <div><b>{{$data->motivo_cancelado}}</b></div>
            </div>
            <div class="row mt-1">
            	<div>Fecha Impresion:</div>
            	<div><b>{{now()}}</b></div>
        	</div>
        </div>
        @endif
        
    </div><!--/panel-body-->
</div><!--/panel-->

</body>
</html>
</body>
</html>
