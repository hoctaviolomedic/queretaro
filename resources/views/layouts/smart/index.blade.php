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
<div class="row">
	{{ HTML::tag('h4', currentEntityBaseName(),['class'=>'col s12 m12']) }}
	<div class="col s12">
		<section id="smart-view" class="row" data-primary-key="{{ currentEntity()->getKeyName() }}" data-columns="{{ json_encode(array_keys($fields)) }}" data-item-show-or-delete-url="{{ companyRoute('show', ['id' => '#ID#']) }}" data-item-update-url="{{ companyRoute('edit', ['id' => '#ID#']) }}">
			<div class="col s3">
				<table class="bordered striped highlight" hidden>
					<tr><td>isDownloading</td><td rv-text="status.isDownloading"></td></tr>
					<tr><td>isAllChecked</td><td rv-text="status.isAllChecked"></td></tr>
					<tr><td>items</td><td rv-text="collections.items"></td></tr>
					<tr><td>datarows</td><td rv-text="collections.datarows"></td></tr>
				</table>
			</div>
			<div class="col s12 m12">
				<div class="row" rv-hide="actions.countItems | call < collections.items">
					<div class="right">
						<a href="{{ companyRoute('create') }}" class="btn orange waves-effect waves-light">Crear</a>
						<button class="btn waves-effect waves-light dropdown-button" data-activates="export-all">
							<span rv-hide="status.isDownloading">
								<i class="material-icons left">file_download</i>Exportar
							</span>
							<div rv-show="status.isDownloading" class="preloader-wrapper small active" style="display: none;">
								<div class="spinner-layer spinner-blue-only">
									<div class="circle-clipper left">
										<div class="circle"></div>
									</div>
									<div class="gap-patch">
										<div class="circle"></div>
									</div>
									<div class="circle-clipper right">
										<div class="circle"></div>
									</div>
								</div>
							</div>
						</button>
						<ul id="export-all" class="dropdown-content">
							<li><a href="#" class="teal-text" rv-on-click="actions.itemsExport" data-export-url="{{companyRoute('export', ['type' => 'XLSX'])}}">Libro Excel</a></li>
							<li><a href="#" class="teal-text" rv-on-click="actions.itemsExport" data-export-url="{{companyRoute('export', ['type' => 'PDF'])}}">Archivo Pdf</a></li>
							<li class="divider"></li>
							<li><a href="#" class="blue-grey-text" rv-on-click="actions.itemsExport" data-export-url="{{companyRoute('export', ['type' => 'XLS'])}}">Excel 97-2003</a></li>
							<li><a href="#" class="blue-grey-text" rv-on-click="actions.itemsExport" data-export-url="{{companyRoute('export', ['type' => 'CSV'])}}">CSV</a></li>
							<li><a href="#" class="blue-grey-text" rv-on-click="actions.itemsExport" data-export-url="{{companyRoute('export', ['type' => 'TXT'])}}">TXT</a></li>
						</ul>
					</div>
				</div>
				<div class="row" rv-show="actions.countItems | call < collections.items" style="display: none;">
					<div class="right">
						<button class="btn waves-effect waves-light" rv-on-click="actions.uncheckAll"><i class="material-icons left">select_all</i>Deseleccionar (<span rv-text="actions.countItems | call < collections.items"></span>)</button>
						@can('delete', currentEntity())
						<button class="btn waves-effect waves-light" rv-on-click="actions.showModalDelete" data-delete-type="multiple" data-delete-url="{{companyRoute('destroyMultiple')}}"><i class="material-icons left">delete</i>Eliminar (<span rv-text="actions.countItems | call < collections.items"></span>)</button>
						@endcan
						<button class="btn waves-effect waves-light dropdown-button" data-activates="export-custom">
							<span rv-hide="status.isDownloading">
								<i class="material-icons left">file_download</i>Exportar (<span rv-text="actions.countItems | call < collections.items"></span>)
							</span>
							<div rv-show="status.isDownloading" class="preloader-wrapper small active">
								<div class="spinner-layer spinner-blue-only">
									<div class="circle-clipper left">
										<div class="circle"></div>
									</div>
									<div class="gap-patch">
										<div class="circle"></div>
									</div>
									<div class="circle-clipper right">
										<div class="circle"></div>
									</div>
								</div>
							</div>
						</button>
						<ul id="export-custom" class="dropdown-content">
							<li><a href="#" class="teal-text" rv-on-click="actions.itemsExport" data-export-url="{{companyRoute('export', ['type' => 'XLSX'])}}">Libro Excel</a></li>
							<li><a href="#" class="teal-text" rv-on-click="actions.itemsExport" data-export-url="{{companyRoute('export', ['type' => 'PDF'])}}">Archivo Pdf</a></li>
							<li class="divider"></li>
							<li><a href="#" class="blue-grey-text" rv-on-click="actions.itemsExport" data-export-url="{{companyRoute('export', ['type' => 'XLS'])}}">Excel 97-2003</a></li>
							<li><a href="#" class="blue-grey-text" rv-on-click="actions.itemsExport" data-export-url="{{companyRoute('export', ['type' => 'CSV'])}}">CSV</a></li>
							<li><a href="#" class="blue-grey-text" rv-on-click="actions.itemsExport" data-export-url="{{companyRoute('export', ['type' => 'TXT'])}}">TXT</a></li>
						</ul>
					</div>
				</div>
			</div>
			<div class="col s12 ml2">
				<table class="smart-table striped responsive-table highlight">
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
			<a class="waves-effect waves-light btn btn-flat no-padding" data-item-id="#ID#" rv-get-show-url><i class="material-icons">visibility</i></a>
			@can('update', currentEntity())
			<a class="waves-effect waves-light btn btn-flat no-padding" data-item-id="#ID#" rv-get-edit-url><i class="material-icons">mode_edit</i></a>
			@endcan
			@can('delete', currentEntity())
			<a href="#" class="waves-effect waves-light btn btn-flat no-padding" rv-on-click="actions.showModalDelete" rv-get-datarow rv-get-delete-url data-item-id="#ID#" data-delete-type="single"><i class="material-icons">delete</i></a>
			@endcan
		</div>
	</div>
</div>
@endsection