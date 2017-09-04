@extends('layouts.dashboard')

@section('header-bottom2')
<!--CDN chartsJS, esta versión viene con http://momentjs.com/ incluído-->
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.bundle.min.js"></script>
	<script src="{{ asset('js/dataChart.js') }}"></script>
@endsection

@section('content')
<div class="center">
<h2>¡Bienvenido!</h2>
<h6>Tenemos algunos elementos que necesitan de tu atención:</h6>
</div>
<div class="col s12 m8">
<ul class="collapsible popout" data-collapsible="expandable">
	<li>
		<div class="collapsible-header active"><i class="material-icons blue-text">info</i>El siguiente medicamento esta a punto de caducar:</div>
		<div class="collapsible-body">
			<a href="#!" class="waves-effect waves-light btn orange right">Notificar a Compras y PNC</a>
			<table id="medTable" class="display highlight" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th></th>
						<th>Nombre</th>
						<th class="red-text">Fecha de vencimiento</th>
						<th>Precio</th>
						<th>Estatus</th>
					</tr>
				</thead>
			</table>
		</div>
	</li>
	<li><!--/here the table ends-->
		<div class="collapsible-header"><i class="material-icons blue-text">info</i>Se detectó medicamento en proceso de desviación:</div>
		<div class="collapsible-body">
			<a href="#!" class="waves-effect waves-light btn orange right">Notificar a Compras y PNC</a>
			<table id="devTable" class="display highlight" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th></th>
						<th>Nombre</th>
						<th>Desviados</th>
						<th>Fecha</th>
						<th>Razón</th>
					</tr>
				</thead>
			</table>
		</div>
	</li>
	<li>
		<div class="collapsible-header"><i class="material-icons blue-text">info</i>El proyecto IPEJAL encontró los siguientes problemas:</div>
		<div class="collapsible-body">
			<ul class="collection">
				<li class="collection-item"><div>82 Medicamentos en proceso de <b>devolución</b><a href="#!" class="secondary-content"><i class="material-icons">send</i></a></div></li>
				<li class="collection-item"><div>Levantó un <b>ticket</b> con el asuto: No pude registrar el medicamento<a href="#!" class="secondary-content"><i class="material-icons">send</i></a></div></li>
			</ul>
		</div>
	</li>
</ul>
</div><!--/col collapsibles-->
<div class="col s12 m4">
<div class="card">
	<div class="card-content">
		<span class="card-title grey-text text-darken-4">Gastos proyectos</span>
		<canvas id="myChart" width="auto" height="auto"></canvas>
	</div>
</div>
</div><!--/col aditional info-->
@endsection
