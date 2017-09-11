@section('content-width', 's12 m7 xl8 offset-xl2')
@section('form-content')
    {{ Form::setModel($data) }}
    <div class="container-fluid">
    <div class="panel-body">
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group">
                {{Form::label('unidad','*Unidad')}}
                {{Form::select('unidad',isset($localidades)?$localidades:[],null,['id'=>'unidad','class' => 'unidad form-control'])}}
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                {{Form::label('medico','*Médico')}}
                {{Form::select('medico',isset($medicos)?$medicos:[],null,['id'=>'medico','class' => 'medico form-control'])}}
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                {{Form::label('programa','*Programa')}}
                {{Form::select('programa',isset($programas)?$programas:[],null,['id'=>'programa','class' => 'programa form-control'])}}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-2">
            <div class="form-group">
                {{Form::label('tipo-servicio','*Tipo de servicio')}}
                <div class="input-group-btn form-group" role="group" aria-label="tipo_servicio" data-toggle="buttons">
                    <label class="btn btn-check btn-default active">
                        <input type="radio" name="tipo_servicio" checked="checked" autocomplete="off" value="afiliado" class="btn btn-default">Afiliado
                    </label>
                    <label class="btn btn-check btn-default">
                        <input type="radio" name="tipo_servicio" autocomplete="off" value="externo" class="btn btn-default">Externo
                    </label>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                {{Form::label('paciente','*Afiliación/Paciente')}}
                {{Form::select('paciente',[],null,['id'=>'paciente','class' => 'paciente form-control','data-url'=>companyRoute('getAfiliados')])}}
                {{Form::text('paciente_externo',null,['id'=>'paciente_externo','class'=>'form-control','style'=>'display:none'])}}
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                {{Form::label('diagnostico','*Diagnóstico')}}
                {{Form::select('diagnostico',[],null,['id'=>'diagnostico','class' => 'diagnostico form-control','data-url'=>companyRoute('getDiagnosticos')])}}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4 col-xs-3">
            <div class="form-group">
                <label for="peso">Peso:</label>
                <div class="input-group">
                    {{Form::text('peso',null,['id'=>'peso','class' =>'form-control', 'placeholder' => 'Ej:70','aria-describedby'=>'peso-addon'])}}
                    <span class="input-group-addon" id="peso-addon">Kg</span>
                </div>
            </div>
        </div>
        <div class="col-sm-4 col-xs-4">
            <div class="form-group">
                <label for="altura">Altura:</label>
                <div class="input-group">
                    {{Form::text('altura',null,['id'=>'altura','class' =>'form-control', 'placeholder' => 'Ej: 1.70','aria-describedby'=>'altura-addon'])}}
                    <span class="input-group-addon" id="altura-addon">Mts</span>
                </div>
            </div>
        </div>
        <div class="col-sm-4 col-xs-4">
            <div class="form-group">
                <label for="presion">Presión:</label>
                <div class="input-group">
                    {{Form::text('presion1',null,['id'=>'presion1','class' =>'form-control', 'placeholder' => 'Ej: 120','aria-describedby'=>'presion-addon'])}}
                    <span class="input-group-addon" id="presion-addon">/</span>
                    {{Form::text('presion2',null,['id'=>'presion2','class' =>'form-control', 'placeholder' => 'Ej: 80','aria-describedby'=>'presion-addon'])}}
                </div>
            </div>
        </div>
    </div><!--/row-->

    <div class="well">

        <div class="form-group">
            <div class="row">
                <div class="col-sm-12">
                    <div class="input-group">
                        {{Form::label('medicamento','*Medicamento')}}
                        {{Form::select('medicamento',[],null,['id'=>'medicamento','class' => 'medicamento form-control','data-url'=>companyRoute('getMedicamentos')])}}
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4 border-right">
                <h4>*Dosis:</h4>
                <div class="input-group my-group">
                    <div class="input-group-btn" role="group" aria-label="dosis" data-toggle="buttons">
                        <label class="btn btn-check btn-default">
                            <input type="checkbox" name="dosis14" id="dosis14" autocomplete="off" class="btn btn-default dosis_checkbox">1/4
                        </label>
                        <label class="btn btn-check btn-default">
                            <input type="checkbox" name="dosis12" id="dosis12" autocomplete="off"  class="btn btn-default dosis_checkbox">1/2
                        </label>
                    </div>
                    {{Form::number('dosis',null,['id'=>'dosis','class'=>'form-control','placeholder'=>'Ej. 6','min'=>'1'])}}
                    {{Form::text('_dosis',null,['id'=>'_dosis','class' => '_dosis form-control','disabled'])}}
                </div>
            </div>
            <div class="col-sm-4 border-right">
                <h4>Cada:</h4>
                <div class="input-group my-group">
                    {{Form::number('cada',null,['id'=>'cada','class'=>'form-control','placeholder'=>'Ej. 6','min'=>'1'])}}
                    {{Form::select('_cada',['Hora(s)','Día(s)','Semana(s)','Mes(es)'],null,['id'=>'_cada','class' => '_cada form-control'])}}
                </div>
            </div>
            <div class="col-sm-4">
                <h4>Por:</h4>
                <div class="input-group my-group">
                    {{Form::number('por',null,['id'=>'por','class'=>'form-control','placeholder'=>'Ej. 6','min'=>'1'])}}
                    {{Form::select('_por',['Día(s)','Semana(s)','Mes(es)'],null,['id'=>'_por','class' => '_por form-control'])}}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <h4>En caso de presentar:</h4>
                {{Form::textarea('nota_medicamento',null,['class' => 'form-control','rows'=>'1','id'=>'nota_medicamento'])}}
            </div>
            <div class="col-sm-6 border-right">
                <h4>¿Surtido recurrente?</h4>
                <div class="input-group my-group">
                    <div class="input-group-btn" role="group" aria-label="surtido" data-toggle="buttons">
                        <label class="btn btn-check btn-default">
                            <input type="checkbox" name="surtido_recurrente" id="surtido_recurrente" autocomplete="off" class="btn btn-default checkbox_surtido">Recurrente
                        </label>
                    </div>
                    {{Form::number('surtido_numero',null,['id'=>'surtido_numero','placeholder'=>'Ej: 6','class'=>'form-control','disabled'])}}
                    {{Form::select('surtido_tiempo',['1'=>'Día(s)','7'=>'Semana(s)','30'=>'Mes(es)'],null,['id'=>'surtido_tiempo','class'=>'form-control','disabled'])}}
                </div>
            </div>
            <div class="text-center col-sm-12">
                <br>
                {{--<p id="resumen"><b>1 Pastilla(s)</b> cada <b>8 Hora(s)</b> por <b>5 Día(s)</b></p>--}}
                <button type="button" id="agregar" class="btn btn-default"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Agregar</button>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <table class="table table-hover" id="detalle" data-url="{{companyRoute('verifyStock')}}">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Medicamento recetado</th>
                    </tr>
                    </thead>
                    <tbody class="medicine_detail">
                    </tbody>
                </table>
            </div>
        </div>
    </div><!--/well-->
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                {{Form::label('observacion','Observaciones adicionales:')}}
                {{Form::textarea('observacion',null,['class' => 'form-control','rows'=>'1','id'=>'observacion'])}}
            </div>
        </div>
    </div><!--/row-->
</div><!--/panel-body-->
    </div>

@endsection
@section('header-bottom')
    @parent
    <script type="text/javascript" src="{{asset('js/recetas.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/toaster.js')}}"></script>
@endsection

{{-- DONT DELETE --}}
@if (Route::currentRouteNamed(currentRouteName('index')))
    @include('layouts.smart.index')
@endif

@if (Route::currentRouteNamed(currentRouteName('create')))
    @include('layouts.smart.create')
@endif

@if (Route::currentRouteNamed(currentRouteName('edit')))
    @include('layouts.smart.edit')
@endif

@if (Route::currentRouteNamed(currentRouteName('show')))
    @include('layouts.smart.show')
@endif

@if (Route::currentRouteNamed(currentRouteName('export')))
    @include('layouts.smart.export')
@endif