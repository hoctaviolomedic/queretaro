@extends('layouts.dashboard')

@section('title', 'Entradas de Pedidos')

@section('header-top')
<link rel="stylesheet" href="{{asset('css/bootstrap-multiselect.css')}}">
@endsection

@section('header-bottom')
<script src="{{asset('js/moon.min.js')}}"></script>
<script src="{{asset('js/bootstrap-multiselect.js')}}"></script>
<script type="text/javascript">
	$(document).ready(function() {

		$('a[data-toggle="tooltip"]').tooltip({
			animated: 'fade',
			placement: 'bottom',
			html: true
		});

		$('[data-toggle="tooltip"]').tooltip();

		$(".select-two").select2().on('select2:select', function (e) {
			this.dispatchEvent(new CustomEvent('change'));
		});

		$('#resurtido').multiselect({
			includeSelectAllOption: true,
			nonSelectedText: 'Selecciona No. Surtido',
			selectAllText: 'Seleccionar todo',
			onSelectAll: function(e) {
				this.options.onChange();
			},
			onDeselectAll: function() {
				this.options.onChange();
			},
			onChange: function(option, checked) {
				app.set('resurtidos', this.$select.val() == null ? [] : this.$select.val());
			},
			onDropdownHide: function(event) {
				app.$data.getItemsPedido()
			}
		});
	});

	const app = new Moon({
		el: "#app",
		data: {
			id_localidad: 0,
			id_pedido: 0,
			resurtidos: [],
			almacenes: [],
			items: [],
			clone: [],
			toRefresh: false,
		},
		methods: {
			changeSelect: function(e) {
				$.post(this.$el.dataset.endpoint, {action: e.target.dataset.action, id: e.target.value}, function(response){
					app.$data[e.target.dataset.callback](response, e.target, e.target.dataset.target);
				})
			},
			updateSelectPedido: function(response, element, target) {
				this.set('id_localidad', element.value)
				var pedidos = [];
				if (response.success) {
					response.data.forEach(function(item){
						pedidos.push({ id: item.id_pedido, text: item.pedido})
					})
				};
				$(target).empty().append('<option value="0" selected disabled>Escriba la clave o su descripción</option>');
				$(target).select2({ data: pedidos });
			},
			updateChecksSurtido: function(response, element, target) {
				this.set('id_pedido', element.value)
				var surtidos = [];
				if (response.success) {
					response.data.forEach(function(item){
						surtidos.push(new Option('#'+item.label+' - '+item.value, item.value).outerHTML)
					})
				};
				$(target).empty().append(surtidos.join(''));
				$(target).multiselect('rebuild');
			},
			changeSelectAlmacen: function(e) {
				console.log('cambia-almacen',e.target.dataset)
				$.post(this.$el.dataset.endpoint, {
					action: e.target.dataset.action,
					id: e.target.value,
					codigo_barras: e.target.dataset.codigo_barras
				}, function(response){
					app.$data.clone[e.target.dataset.itempos].id_almacen = e.target.value;
					app.$data[e.target.dataset.callback](response, e.target, e.target.dataset.target);
				})
			},
			changeSelectUbicacion: function(e) {
				this.$data.clone[e.target.dataset.itempos].id_ubicacion = e.target.value;
				this.$data.validaSelects();
			},
			updateSelectUbicacion: function(response, element, target) {
				var almacenes = [];
				if (response.success) {
					almacenes.push('<option value="0" selected disabled>Ubicación ...</option>');
					response.data.almacenes.forEach(function(item){
						almacenes.push(new Option('#'+item.label+' - '+item.value, item.value).outerHTML)
					})
				};
				$(target).empty().append(almacenes.join(''));
				this.$data.validaSelects();
			},
			getItemsPedido: function() {
				if (app.$data.resurtidos.length) {
					$.post(this.$el.dataset.endpoint, {
						action: 'listar-pedido',
						id_localidad: this.$data.id_localidad,
						id_pedido: this.$data.id_pedido,
						resurtidos: this.$data.resurtidos,
					}, function(response){
						if (response.success) {
							app.set('almacenes', response.data.almacenes)
							app.set('items', response.data.resurtidos)
							app.set('clone', JSON.parse(JSON.stringify(response.data.resurtidos)))
						}
					})
				}
			},
			getAlmacenOptions: function() {
				var options = [];
				options.push('<option value="0" selected disabled>Ubicación ...</option>');
				this.$data.almacenes.forEach(function(item){
					options.push(new Option(item.almacen, item.id_almacen).outerHTML)
				})
				return options.join('')
			},
			getUbicacionOptions: function() {
				var options = [];
				options.push('<option value="0" selected disabled>Almacén ...</option>');
				return options.join('')
			},
			addOne: function(int) {
				return int + 1;
			},
			getTotalCodigosBarra: function() {
				return this.$data.items.reduce(function(acc, item) {
					return (acc.indexOf(item['codigo_barras']) < 0) ? acc.concat([item['codigo_barras']]) : acc;
				}, []).length;
			},
			getTotalCantidadPendiente: function() {
				return this.$data.items.reduce(function(acc, item) {
					return acc + (item['cantidad']-item['cantidad_entrada'])
				}, 0);
			},
			getTotalCantidadEntrada: function() {
				return this.$data.clone.reduce(function(acc, item) {
					return acc + parseInt(item['cantidad_entrada'] == '' ? 0: item['cantidad_entrada']);
				}, 0);
			},
			someFunc: function(e) {
				this.$data.clone[e.target.dataset.hoho]['cantidad_entrada'] = parseInt(e.target.value)
				this.set('clone', this.get('clone'))
			},
			enviarDatos: function(e) {

				if (!this.$data.validaSelects()) {
					return;
				}
				if (app.$data.resurtidos.length) {
					$.post(this.$el.dataset.endpoint, {
						action: 'insertar-entrada',
						id_localidad: this.$data.id_localidad,
						id_pedido: this.$data.id_pedido,
						entradas: this.$data.clone,
					}, function(response){
						if (response.success) {
							// e.target.disabled = true;

							$.toaster({
								priority : 'success',
								title : 'Exito',//El título del Toaste
								message : 'Datos guardados correctamente.',//String con el mensaje
								settings: {
									'timeout':10000,//Para que dure 10 segundos
									'toaster':{//Especificaciones de diseño
										'css':{
											'top':'5em'//Para que se baje 5 em y funcione bien en el Stand alone
										}
									}
								}
							});

							// alert('Datos guardados correctamente')
							window.open(response.data)

							app.set('resurtidos', [])
							app.set('almacenes', [])
							app.set('items', [])
							app.set('clone', [])

							$("#pedido option[value='"+ this.$data.id_pedido +"']").remove();
							$('#pedido').select2('val', 0);

							$('#resurtido').empty();
							$('#resurtido').multiselect('rebuild');

							$('#codebar-input').val('')

						}
					}.bind(this))
					// this.set('toRefresh', true)
				} else {
					$.toaster({
						priority : 'danger',
						title : 'Error',//El título del Toaste
						message : 'Es necesario llenar formulario.',//String con el mensaje
						settings: {
							'timeout':10000,//Para que dure 10 segundos
							'toaster':{//Especificaciones de diseño
								'css':{
									'top':'5em'//Para que se baje 5 em y funcione bien en el Stand alone
								}
							}
						}
					});
				}
			},
			toRefreshPage: function() {
				parent.window.location.reload()
			},
			codebarKeyDown: function(e) {
				if (!new RegExp('^[a-zA-Z0-9]+$').test(e.key) || e.ctrlKey) {
					e.preventDefault();
				}
			},
			someMethod: function(e) {
				if (app.$data.resurtidos.length) {
					var codes = app.$data.items.reduce(function(acc, item, index) {
						if ( Object.keys(acc).indexOf(item['codigo_barras']) < 0 ) acc[item['codigo_barras']] = index
						return acc;
					}, {});
					var pos = Object.keys(codes).indexOf(e.target.value);
					if ( pos >= 0) {
						var pendiente = (this.$data.items[pos].cantidad - this.$data.items[pos].cantidad_entrada)
						if (this.$data.clone[pos]['cantidad_entrada'] < pendiente) {
							this.$data.clone[pos]['cantidad_entrada']++
						}
					}
					this.set('clone', this.get('clone'))
				}
				document.querySelector('#codebar-input').value = '';
			},
			someMethodTwo: function() {
				if (app.$data.resurtidos.length) {
					var codes = app.$data.items.reduce(function(acc, item, index) {
						if ( Object.keys(acc).indexOf(item['codigo_barras']) < 0 ) acc[item['codigo_barras']] = index
						return acc;
					}, {});
					var pos = Object.keys(codes).indexOf(document.querySelector('#codebar-input').value);
					if ( pos >= 0) {
						var pendiente = (this.$data.items[pos].cantidad - this.$data.items[pos].cantidad_entrada)
						if (this.$data.clone[pos]['cantidad_entrada'] < pendiente) {
							this.$data.clone[pos]['cantidad_entrada']++
						}
					}
					this.set('clone', this.get('clone'))
					document.querySelector('#codebar-input').value = '';
				}
			},
			checkCantidades: function(e) {
				var pendiente = (this.$data.items[e.target.dataset.itempos].cantidad - this.$data.items[e.target.dataset.itempos].cantidad_entrada)
				if (e.target.value > pendiente) {
					document.querySelector('#enviar-datos').disabled = true
					var span = document.createElement('span');
						span.classList.add('text-danger')
						span.textContent = 'El valor debe menor de o igual a '+ pendiente +'.';
					if (!e.target.parentNode.querySelector('span')) {
						e.target.parentNode.classList.add('has-warning')
						e.target.parentNode.append(span)
					}
				} else if (e.target.value < 0) {
					document.querySelector('#enviar-datos').disabled = true
					var span = document.createElement('span');
						span.classList.add('text-danger')
						span.textContent = 'El valor debe mayor de o igual a 0.';
					if (!e.target.parentNode.querySelector('span')) {
						e.target.parentNode.classList.add('has-warning')
						e.target.parentNode.append(span)
					}
				} else {
					e.target.parentNode.classList.remove('has-warning')
					document.querySelector('#enviar-datos').disabled = false
					if (e.target.parentNode.querySelector('span')) {
						e.target.parentNode.querySelector('span').remove()
					}
				}
			},
			validaSelects: function() {
				var r = true
				document.querySelector('table').querySelectorAll('select').forEach(function(item, key){
					console.log('validaSelects',item.value)

					if (item.value == 0) {
						document.querySelector('#enviar-datos').disabled = true
						var span = document.createElement('span');
							span.classList.add('text-danger')
							span.textContent = 'Requerido.';
						if (!item.parentNode.parentNode.querySelector('.text-danger')) {
							item.parentNode.parentNode.classList.add('has-warning')
							item.parentNode.parentNode.append(span)
						}
						r = false;
					} else {
						item.parentNode.parentNode.classList.remove('has-warning')
						document.querySelector('#enviar-datos').disabled = false
						if (item.parentNode.parentNode.querySelector('span.text-danger')) {
							item.parentNode.parentNode.querySelector('span.text-danger').remove()
						}
					}

				})
				return r;
			}
		}
	});

</script>

@endsection

@section('content')
<br>
<div class="panel shadow-3 panel-danger">
	<div class="panel-heading">
		<h3 class="panel-title text-center">Entradas pedidos</h3>
	</div>
	<div id="app" class="panel-body" data-endpoint="{{ companyRoute('pedidos-endpoint') }}">
	   <form class="row">
			<div class="col-sm-4">
				<div class="form-group">
					<label for="localidad">*Localidad:</label>
					<select id="localidad" class="select-two form-control" style="width: 100%" data-action="change-localidad" data-callback="updateSelectPedido" data-target="#pedido" m-on:change="changeSelect">
						<option value="0" selected disabled>Escriba la clave o su descripción</option>
						@foreach ($localidades as $localidad)
						<option value="{{$localidad->key}}">{{$localidad->localidad}}</option>
						@endforeach
					</select>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="form-group">
					<label for="pedido">*Pedido:</label>
					<select id="pedido" class="select-two form-control" style="width: 100%" data-action="change-pedido" data-callback="updateChecksSurtido" data-target="#resurtido" m-on:change="changeSelect">
					</select>
				</div>
			</div>
			<div class="col-sm-4 col-xs-6">
				<div class="form-group">
					<label for="resurtido">*Resurtido:</label>
					<select id="resurtido" multiple="multiple"></select>
				</div>
			</div>
		</form>

		<div class="well">
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
						<label for="codebar-input">Código de barras</label>
						<div class="input-group">
							<input id="codebar-input" type="text" class="form-control" placeholder="Buscar..." m-on:keydown="codebarKeyDown" m-on:keyup.enter="someMethod">
							<span class="input-group-btn">
								<button class="btn btn-default btn-check" type="button" m-on:click="someMethodTwo"><span class="glyphicon glyphicon-plus"></span> Aceptar</button>
							</span>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12">
				<div class="table-responsive">
				<table class="table table-hover">
					<thead>
						<tr>
							<th>#</th>
							<th>Codigo de barras</th>
							<th>Descripción</th>
							<th>Cantidad surtida</th>
							<th>Cantidad pendiente</th>
							<th>Cantidad entrada</th>
							<th>Lote</th>
							<th>Caducidad</th>
							<th>Ubicación</th>
						</tr>
					</thead>
					<tbody>
						<tr m-for="item,key in items">
							<th scope="row">@{{addOne(key)}}</th>
							<td>@{{item.codigo_barras}}</td>
							<td>@{{item.name}}</td>
							<td>@{{item.cantidad}}</td>
							<td>@{{item.cantidad - item.cantidad_entrada}}</td>
							<td>
								<input type="number" class="form-control" placeholder="Ej: 6" min="0" max="@{{item.cantidad - item.cantidad_entrada}}" value="0" m-model="clone[key].cantidad_entrada" m-on:change="checkCantidades" data-itempos="@{{key}}" data-dummyoninput="someFunc">
							</td>
							<td>@{{item.no_lote}}</td>
							<td>@{{item.caducidad}}</td>
							<td>
								<div class="input-group">
									<span class="input-group-addon" id="a">A</span>
									<select id="almacen-@{{key}}" class="form-control" data-action="change-almacen" data-codigo_barras="@{{item.codigo_barras}}" data-callback="updateSelectUbicacion" data-target="#ubicacion-@{{key}}" data-itempos="@{{key}}" m-on:change="changeSelectAlmacen" m-html="getAlmacenOptions()"></select>
									<span class="input-group-addon" id="u">U</span>
									<select id="ubicacion-@{{key}}" class="form-control" m-html="getUbicacionOptions()" data-itempos="@{{key}}" m-on:change="changeSelectUbicacion"></select>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
				</div>
				<div class="form-inline form-group">
					<div class="input-group">
						<span class="input-group-addon" id="basic-addon1">Código de barras</span>
						<input type="text" class="form-control" m-literal:value="getTotalCodigosBarra()" readonly>
					</div>
					<div class="input-group">
						<span class="input-group-addon" id="basic-addon1">Cantidad pendiente</span>
						<input type="text" class="form-control" m-literal:value="getTotalCantidadPendiente()" readonly>
					</div>
					<div class="input-group">
						<span class="input-group-addon" id="basic-addon1">Cantidad entrada</span>
						<input type="text" class="form-control" m-literal:value="getTotalCantidadEntrada()" readonly>
					</div>
				</div>
			</div>
		</div>

		<div class="text-right" m-literal:hidden="toRefresh">
			<button id="enviar-datos" type="button" class="btn btn-danger" m-on:click="enviarDatos"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Guardar</button>
		</div>

		<div class="text-right" m-literal:hidden="!toRefresh">
			<button type="button" class="btn btn-danger" m-on:click="toRefreshPage"> Recargar</button>
		</div>



	</div>
</div>

@endsection
