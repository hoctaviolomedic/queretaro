function post_to_url(path, params, method) {
    method = method || 'post';

    var form = document.createElement('form');

    //Move the submit function to another variable
    //so that it doesn't get overwritten.
    form._submit_function_ = form.submit;

    form.setAttribute('method', method);
    form.setAttribute('action', path);

    for(var key in params) {
        var hiddenField = document.createElement('input');
        hiddenField.setAttribute('type', 'hidden');
        hiddenField.setAttribute('name', key);
        hiddenField.setAttribute('value', params[key]);

        form.appendChild(hiddenField);
    }

    document.body.appendChild(form);
    form._submit_function_(); //Call the renamed function.
}

let datatable = new DataTable('.smart-table', {
	perPageSelect: [20,30,50],
	perPage: 20,
	columns: [
		{ select: [0], sortable: false },
		//{ select: [2], case_sensitive: true },
	],
	// data: data,
	labels: {
		placeholder: 'Buscar datos ...',
		perPage: 'Mostrar {select} datos por pagina',
		noRows: 'No hay datos que mostrar',
		info: 'Mostrando {start} a {end} de {rows} datos (Pagina {page} de {pages})',
        icon:'<span class="glyphicon glyphicon-search"></span>',
	},
});

datatable.on('datatable.update', function() {
	view.unbind();
	view = rivets.bind(smartView, model);
	view.models.actions.itemsSync({}, view.models);
});

datatable.on('datatable.page', function() {
	view.unbind();
	view = rivets.bind(smartView, model);
	view.models.actions.itemsSync({}, view.models);
});

// FIX Datatable-Materialize
document.addEventListener('DOMContentLoaded', function(event) {
	Array.prototype.forEach.call(document.querySelectorAll('.dataTable-selector .select-dropdown li'), function(item, index){
		item.addEventListener('click', function(e){
			e.preventDefault()
			var evt = document.createEvent('HTMLEvents'); evt.initEvent('change', false, true);
			document.querySelector('select.dataTable-selector').dispatchEvent(evt);
		}, false)
	})
}, false);

//
document.querySelector('select').setAttribute('rv-on-change', 'actions.itemsSync')
//
let smartView = document.querySelector('#smart-view');
//
let model = {
	// Estados de vista
	status: {
		isDownloading: false,
		isAllChecked: false,
	},
	//
	collections: {
		// Entity item
		items: [],
		// Datatable items
		datarows: []
	},
	//
	actions: {
		countItems: function(e, items) {
			return items.length;
		},
		isAllChecked: function() {
			return smartView.querySelectorAll('.single-check:not(:checked)').length == 0;
		},
		checkAll: function(e,rv){
			Array.prototype.forEach.call(smartView.querySelectorAll('.single-check'), function(item, index) {
				item.checked = this.checked;
			}.bind(this))
			rv.actions.itemsSync(e,rv)
		},
		uncheckAll: function(e,rv){
			smartView.querySelector('#check-all').checked = false;
			rv.actions.checkAll(e,rv);
		},
		itemsSync: function(e, rv) {
			rv.collections.datarows = [];
			rv.collections.items = [].slice.call(smartView.querySelectorAll('.single-check:checked')).reduce(function(acc, item){
				rv.collections.datarows.push(item.dataset.datarow);
				acc.push(item.dataset.itemId); return acc;
			}, [])
			rv.status.isAllChecked = rv.actions.isAllChecked();
		},
		showModalDelete(e, rv) {
			e.preventDefault();

			// Abrimos modal
			$('#modal-delete').modal('open');

			let btn = smartView.querySelector('[rv-on-click="actions.itemsDelete"]');

			// Limpiamos data del elemento
			Object.keys(btn.dataset).forEach(function(key) {
				delete btn.dataset[key]
			})

			// Copiamos data a boton de modal
			Object.keys(this.dataset).forEach(function(key) {
				btn.dataset[key] = this.dataset[key];
			}.bind(this))
		},
        showModalMotivoCancelacion(e, rv) {
            e.preventDefault();

            // Abrimos modal
            $('#modal-delete').modal('open');

            let btn = smartView.querySelector('[rv-on-click="actions.itemsCancelacion"]');

            // Limpiamos data del elemento
            Object.keys(btn.dataset).forEach(function(key) {
                delete btn.dataset[key]
            });

            // Copiamos data a boton de modal
            Object.keys(this.dataset).forEach(function(key) {
                btn.dataset[key] = this.dataset[key];
            }.bind(this))
        },
		itemsDelete(e, rv) {
			e.preventDefault();

			let data, datarows;

			switch (this.dataset.deleteType) {
				case 'multiple':
					data =  {ids: rv.collections.items};
					datarows = rv.collections.datarows;
					break;
				case 'single':
					data =  {};
					datarows = [this.dataset.datarow];
					break;
			}

			//
			$.delete(this.dataset.deleteUrl, data, function(response){
				if (response.success) {
					datatable.removeRows(datarows)
				}
			});
		},
		itemsCancelacion(e, rv) {
            e.preventDefault();

            let data, datarows,motivo;
			motivo = $('#motivo_cancelacion').val();
            switch (this.dataset.deleteType) {
                case 'multiple':
                    data =  {ids: rv.collections.items,motivo_cancelacion: motivo};
                    datarows = rv.collections.datarows;
                    break;
                case 'single':
                    data =  {motivo_cancelacion: motivo};
                    datarows = [this.dataset.datarow];
                    break;
            }

            //
            $.delete(this.dataset.deleteUrl, data, function(response){
                if (response.success) {
                    // datatable.removeRows(datarows)
					location.reload();
                }
            });

        },
		itemsExport(e, rv) {
			e.preventDefault();
			//
			rv.status.isDownloading = true;
			post_to_url(this.dataset.exportUrl, {'ids' : rv.collections.items});
			rv.status.isDownloading = false;
		},
	},
}

rivets.binders['get-datarow'] = {
	bind: function(el) {
		el.dataset['datarow'] = $(el).parents('tr').data('datarow');
	},
};

rivets.binders['get-item-id'] = {
	bind: function(el) {
		if (el.innerHTML == '') {
			el.outerHTML = document.querySelector('.smart-actions').innerHTML.replace(/#ID#/g, el.dataset.itemId);
		}
	},
};

rivets.binders['get-item-id-and-estatus'] = {
    bind: function(el) {
        if (el.innerHTML == '') {
            el.outerHTML = document.querySelector('.smart-actions').innerHTML.replace(/#ID#/g, el.dataset.itemId).replace(/#ESTATUS#/g, el.dataset.itemEstatus);
        }
    },
};
rivets.binders['hide-delete'] = {
	bind: function (el) {
		if(el.dataset.itemEstatus != 1)
		{
			$(el).hide();
		}
    }
}

rivets.binders['get-show-url'] = {
	bind: function(el) {
		el.href = smartView.dataset.itemShowOrDeleteUrl.replace('#ID#', el.dataset.itemId);
	},
};

rivets.binders['get-edit-url'] = {
	bind: function(el) {
		el.href = smartView.dataset.itemUpdateUrl.replace('#ID#', el.dataset.itemId);
	},
};

rivets.binders['get-delete-url'] = {
	bind: function(el) {
		el.dataset.deleteUrl = smartView.dataset.itemShowOrDeleteUrl.replace('#ID#', el.dataset.itemId);
	},
};

let view = rivets.bind(smartView, model);

if (datatable.hasRows) {
	datatable.setMessage('Obteniendo elementos ...');
	getItems(1);
} else {
	datatable.setMessage('Sin elementos.');
}

/* */
function getItems($page) {

	let primary = smartView.dataset.primaryKey;
	let columns = JSON.parse(smartView.dataset.columns);

	$.getJSON(smartView.dataset.itemShowOrDeleteUrl.replace('#ID#', '') + '?page=' + $page, function(response){
		let collection = [];
		$.each(response.data, function(index, item){
			let id = item[primary];
			let estatus = item['fk_id_estatus'];
			let collection_item = {};
			collection_item['input'] = '<input type="checkbox" id="check-'+id+'" class="single-check" data-item-id="'+id+'" rv-on-click="actions.itemsSync" rv-get-datarow name="check-'+id+'"><label for="check-'+id+'"></label>';
			$.each(columns, function(index, column){
				try {
					collection_item[column] = (new Function('str', 'return eval("this." + str);')).call(item, column)
				}
				catch(err) {
					id = '';
					collection_item[column] = "";
				}
			})
			if(id !== "undefined" & id !== '') {
				collection_item['actions'] = document.querySelector('.smart-actions').innerHTML.replace(/#ID#/g, id);
				collection.push(collection_item);
			}
		})

		datatable.import({
			type: 'json',
			data: JSON.stringify(collection)
		});

		if (response.next_page_url) {
			datatable.setMessage('Elementos restantes ... ' + (response.total - response.to) );
			getItems(response.current_page + 1)
		}
	})
}
