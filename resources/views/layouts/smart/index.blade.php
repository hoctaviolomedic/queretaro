@extends('layouts.dashboard')

@section('title', currentEntityBaseName())

@section('header-top')
	<!--dataTable.css-->
	<link rel="stylesheet" href="{{ asset('vendor/vanilla-datatables/vanilla-dataTables.css') }}">
@endsection

@section('header-bottom')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/rivets/0.9.6/rivets.bundled.min.js"></script>
    <script src="{{ asset('vendor/vanilla-datatables/vanilla-dataTables.js') }}"></script>
    <script src="{{ asset('js/smartindex.js') }}"></script>
    @if (session('message'))
    <script type="text/javascript">
    	Materialize.toast('<span><i class="material-icons">priority_high</i>{{session('message.text')}}</span>', 4000, '{{session('message.type')}}' );
    </script>
    @endif
@endsection

@section('content')
<br>
<div class="panel shadow-3 panel-danger">
	<div class="panel-heading">
		{{ HTML::tag('h3', currentEntityBaseName(),['class'=>'panel-title text-center']) }}
	</div>
	<div class="panel-body">


<div class="row">
	<div class="col-sm-12">
		<section id="smart-view" class="row" data-primary-key="{{ currentEntity()->getKeyName() }}" data-columns="{{ json_encode(array_keys($fields)) }}" data-item-show-or-delete-url="{{ companyRoute('show', ['id' => '#ID#']) }}" data-item-update-url="{{ companyRoute('edit', ['id' => '#ID#']) }}">
			<div class="col-sm-3">
				<table class="bordered striped highlight" hidden>
					<tr><td>isDownloading</td><td rv-text="status.isDownloading"></td></tr>
					<tr><td>isAllChecked</td><td rv-text="status.isAllChecked"></td></tr>
					<tr><td>items</td><td rv-text="collections.items"></td></tr>
					<tr><td>datarows</td><td rv-text="collections.datarows"></td></tr>
				</table>
			</div>
			<div class="col-sm-12" rv-hide="actions.countItems | call < collections.items">
				<div class="text-right">
					<a href="{{ companyRoute('create') }}" class="btn btn-danger">Crear</a>
					<div style="display: inline-block; position: relative;">
						<button class="btn btn-default" type="button" id="export-all" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
							Exportar
							<span class="caret"></span>
						</button>
						<ul class="dropdown-menu dropdown-menu-right" aria-labelledby="export-all">
							<li><a href="#" rv-on-click="actions.itemsExport" data-export-url="{{companyRoute('export', ['type' => 'XLSX'])}}">Libro Excel</a></li>
							<li><a href="#" rv-on-click="actions.itemsExport" data-export-url="{{companyRoute('export', ['type' => 'PDF'])}}">Archivo Pdf</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="#" rv-on-click="actions.itemsExport" data-export-url="{{companyRoute('export', ['type' => 'XLS'])}}">Excel 97-2003</a></li>
							<li><a href="#" rv-on-click="actions.itemsExport" data-export-url="{{companyRoute('export', ['type' => 'CSV'])}}">CSV</a></li>
							<li><a href="#" rv-on-click="actions.itemsExport" data-export-url="{{companyRoute('export', ['type' => 'TXT'])}}">TXT</a></li>
						</ul>
					</div>
				</div>
			</div>
			<div class="col-sm-12" rv-show="actions.countItems | call < collections.items" style="display: none;">
				<div class="text-right">
					<button class="btn btn-default" rv-on-click="actions.uncheckAll"><i class="glyphicon glyphicon-remove"></i> Deseleccionar (<span rv-text="actions.countItems | call < collections.items"></span>)</button>
					@can('delete', currentEntity())
					<button class="btn btn-default" rv-on-click="actions.showModalDelete" data-delete-type="multiple" data-delete-url="{{companyRoute('destroyMultiple')}}"><i class="glyphicon glyphicon-trash"></i> Eliminar (<span rv-text="actions.countItems | call < collections.items"></span>)</button>
					@endcan
					<div style="display: inline-block; position: relative;">
						<button class="btn btn-default" type="button" id="export-custom" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
							Exportar (<span rv-text="actions.countItems | call < collections.items"></span>)
							<span class="caret"></span>
						</button>
						<ul class="dropdown-menu dropdown-menu-right" aria-labelledby="export-custom">
							<li><a href="#" rv-on-click="actions.itemsExport" data-export-url="{{companyRoute('export', ['type' => 'XLSX'])}}">Libro Excel</a></li>
							<li><a href="#" rv-on-click="actions.itemsExport" data-export-url="{{companyRoute('export', ['type' => 'PDF'])}}">Archivo Pdf</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="#" rv-on-click="actions.itemsExport" data-export-url="{{companyRoute('export', ['type' => 'XLS'])}}">Excel 97-2003</a></li>
							<li><a href="#" rv-on-click="actions.itemsExport" data-export-url="{{companyRoute('export', ['type' => 'CSV'])}}">CSV</a></li>
							<li><a href="#" rv-on-click="actions.itemsExport" data-export-url="{{companyRoute('export', ['type' => 'TXT'])}}">TXT</a></li>
						</ul>
					</div>

				</div>
			</div>
			<div class="col-sm-12">
				<table class="smart-table table table-striped responsive-table table-hover">
					<thead>
						<tr>
							<th class="width-auto"><input type="checkbox" id="check-all" rv-on-click="actions.checkAll" rv-checked="status.isAllChecked"><label for="check-all"></label></th>
							@foreach ($fields as $label)
							<th> {{ $label }} </th>
							@endforeach
							<th></th>
						</tr>
					</thead>
					<tbody>
					@foreach ($data as $row)
					<tr>
						<td class="width-auto">
							<input type="checkbox" id="check-{{$row->getKey()}}" class="single-check" data-item-id="{{$row->getKey()}}" rv-on-click="actions.itemsSync" rv-get-datarow  name="check-{{$row->getKey()}}">
							<label for="check-{{$row->getKey()}}"></label>
						</td>
						@foreach ($fields as $field => $label)
						<td>{{ object_get($row, $field) }}</td>
						@endforeach
						<td class="width-auto">
							<span rv-get-item-id data-item-id="{{$row->getKey()}}"></span>
						</td>
					</tr>
					@endforeach
					</tbody>
				</table>
			</div>
			<!-- Modal Structure -->
			<div id="modal-delete" class="modal">
				<div class="modal-content">
					<h5>¿Estas seguro?</h5>
					<p>Una vez eliminado no podrás recuperarlo.</p>
				</div>
				<div class="modal-footer">
					<button class="modal-action modal-close waves-effect waves-light btn orange" rv-on-click="actions.itemsDelete">Aceptar</button>
					<button class="modal-action modal-close waves-effect waves-teal btn-flat teal-text">Cancelar</button>
				</div>
			</div>
		</section>
		<div class="smart-actions" hidden>
			<a class="text-danger btn btn-check" data-item-id="#ID#" rv-get-show-url><i class="glyphicon glyphicon-eye-open"></i></a>
			@can('update', currentEntity())
			<a class="text-danger btn btn-check" data-item-id="#ID#" rv-get-edit-url><i class="glyphicon glyphicon-pencil"></i></a>
			@endcan
			@can('delete', currentEntity())
			<a href="#" class="text-danger btn btn-check" rv-on-click="actions.showModalDelete" rv-get-datarow rv-get-delete-url data-item-id="#ID#" data-delete-type="single"><i class="glyphicon glyphicon-trash"></i></a>
			@endcan
		</div>
	</div>
</div>


	</div>
</div>

@endsection