<html>
<body style="font-size: 12px">
<div class="panel">
    <div class="panel-heading" style="background-color: #f4f4f4;">
        <span style="text-align: left"><b>RECETA MÉDICA</b></span>
        <div class="float-right">
            <span>Folio:</span>
            <span id="folio"><b>{{$receta->folio}}</b></span>
        </div>
    </div>
    <div class="panel-body">
        <img src="data:image/png;charset=binary;base64,{{$qr}}" style="float:right;width: 70px;margin-bottom: 0.5em;" />

        <div class="row margin-bottom">
            <div class="width-50 float-left text-center">
                <span>Nombre y clave de la unidad Médica:</span>
                <br><b>Servicios de Salud del Estado de Querétaro</b>
            </div>
            <div class="width-50 float-left text-center">
                <span>Domicilio de la unidad Médica:</span>
                <br><b>Col. C.P. 76156, SANTIAGO DE QUERÉTARO, QUERÉTARO</b>
            </div>
        </div><br>
        <div class="row margin-bottom">
            <div class="width-25 float-left text-center">
                <span>Médico:</span>
                <br><b>{{$receta->medico->getNombreCompletoAttribute()}}</b>
            </div>
            <div class="width-25 float-left text-center">
                <span>No. expediente y de afiliación:</span>
                <br><b>{{$receta->id_afiliacion}},{{$receta->id_dependiente}}</b>
            </div>
            <div class="width-25 float-left text-center">
                <span>R.F.C.:</span>
                <br><b>PUPP200101LUA</b>
            </div>
            <div class="width-25 float-left text-center">
                <span>CÉDULA:</span>
                <br><b>123456789</b>
            </div>
        </div><br>
        <div class="row margin-bottom">
            <div class="width-25 float-left text-center">
                <span>Clave y nombre del servicio:</span>
                <br><b>Farmacia</b>
            </div>
            <div class="width-25 float-left text-center">
                <span>Nombre Paciente:</span>
                <br><b>{{$receta->id_afiliacion != null ? $receta->afiliacion->getFullNameAttribute() : $receta->nombre_paciente_no_afiliado}}</b>
            </div>
            <div class="width-25 float-left text-center">
                <span>Edad:</span>
                <br><b>25 años</b>
            </div>
            <div class="width-25 float-left text-center">
                <span>Fecha y hora de elaboración:</span>
                <br><b>{{$receta->fecha}}</b>
            </div>
        </div><br>
        <div class="row margin-bottom text-center">
            <div class="width-25 float-left">
                <span>Género:</span>
                <br><b>Masculino</b>
            </div>
        </div><br><br>
        <hr style="color: #ccc; margin-top:15px; margin-bottom: 15px;">
        <table>
            <thead>
            <tr>
                <th> </th>
                <th>Medicamento recetado</th>
            </tr>
            </thead>
            <tbody>
            @foreach($detalles as $detalle)
                <tr>
                    <th style="padding: 5px 10px;">{{$detalle->clave_cliente}}</th>
                    <td>
                        <p>{{$detalle->producto->descripcion}}</p>
                        <p>{{$detalle->dosis}}</p>
                        <p>{{isset($detalle->en_caso_presentar)?$detalle->en_caso_presentar:''}}</p>
                        <p>{{isset($detalle->recurrente)?'Recoger '.$detalle->cantidad_pedida.' cada '.$detalle->recurrente/24 .' días':''}}</p>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

    </div><!--/panel-body-->
</div><!--/panel-->

</body>
</html>

<style type="text/css">
    h1,h2,h3,h4,h5,h6,div   {
        margin: 0;
    }
    img {
        margin:0;
        padding: 0;
        float: left;
        border:0
    }
    * {
        font-family: Arial,Helvetica Neue,Helvetica,sans-serif;
    }
    body {
        margin: 0.2em 0.3em;
    }
    table {
        border-spacing: 0;
        border-collapse: collapsed;
    }
    td{
        border: none;
        border-collapse: collapse;
    }
    table>tbody>tr>th{
        border-right: 3px solid #a94442;
        border-collapse: collapse;
    }
    .panel-heading {
        padding: 10px 15px;
        border-bottom: 1px solid #919191;
        border-top-left-radius: 3px;
        border-top-right-radius: 3px;
    }
    .panel {
        margin-bottom: 20px;
        background-color: #fff;
        border: 1px solid #919191;
        border-radius: 4px;
    }
    .panel-body {
        padding: 8px 10px;
    }
    .row {
        margin-right: -15px;
        margin-left: -15px;
        width: 100%;
        display: table;
    }
    .float-left{
        float:left;
    }
    .float-right{
        float: right;
    }
    /*.text-center{
      text-align: center;
    }*/
    .margin-bottom{
        margin-bottom: 2.5em;
    }
    .width-16{
        width: 16.66666667%;
        position: relative;
        min-height: 1px;
        padding-right: 5px;
        padding-left: 5px;
    }
    .width-50{
        width: 47%;
        position: relative;
        min-height: 1px;
        padding-right: 5px;
        padding-left: 5px;
    }
    .width-25{
        width: 21%;
        position: relative;
        min-height: 1px;
        padding-right: 5px;
        padding-left: 5px;
    }
</style>
</body>
</html>