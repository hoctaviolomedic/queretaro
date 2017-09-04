 $(document).on("ready",function(){
	medDataTable();
	devDataTable();
	rolDataTable();
});
$("#rebootTable").on("click",function(){ //reinicia los datos de la tabla
	rolDataTable();
});
var medDataTable = function(){ //creamos la variable para tabla de medicamento caduco
	var table = $("#medTable").DataTable({ //Damos de alta la tabla con el ID...
		'ajax':'https://api.myjson.com/bins/1e0rfj', //datos a mostrar en la tabla (tomada de internet :v)
		columns:[ //valores a mostrar en la tabla
		{"data":"0"},
		{"data":"1"},
		{"data":"2"},
		{"data":"3"},
		{"data":"4"},
		],
		language: espLanguage, //agregamos variable de idioma español
		sDom: 't' + 'ip', //Usamos DOM para indicar que solo muestre la tabla, información de datos y paginación (http://legacy.datatables.net/usage/options#sDom)
	});
}
var devDataTable = function(){ //creamos la variable para tabla de Devoluciones
	var table = $('#devTable').DataTable({
		'ajax':'https://api.myjson.com/bins/u965b',
		columns:[
		{"data":"0"},
		{"data":"1"},
		{"data":"2"},
		{"data":"3"},
		{"data":"4"},
		],
		language: espLanguage,
		sDom: 't' + 'ip',
	});
}
var rolDataTable = function(){ //creamos la variable para la tabla de usuarios
	var table = $("#rolTable").DataTable({ //Damos de alta la tabla con el ID...
		destroy:true, //propiedad para eliminar un usuario y que no salga la ventana de error
		'ajax':'https://api.myjson.com/bins/1us28', //datos a mostrar en la tabla (tomada de internet :v)
		columns:[ //valores a mostrar en la tabla
		{"data":"0"},
		{"data":"1"},
		{"data":"2"},
		{"data":"3"},
		{"data":"4"},
		{"data":"5"},
		{"data":"6"},
		{"defaultContent":"<a href='#' class='editar btn btn-flat'><i class='material-icons'>mode_edit</i></a>  <a class='eliminar btn btn-flat' href='#' ><i class='material-icons'>delete</i></a>"}, //para la columna de acciones
		],
		//scrollY:  '500px', //sentencia para indicar scroll dentro de la tabla
		fixedHeader: {
		header: true,
		//footer: true, //Footer fixed
		},
		/*columnDefs: [ { //damos de alta la función del checkbox
			orderable: false, //con esto decimos que la ordenación será nula
			className: 'select-checkbox', //tpo de elemento
			targets:   0, //donde estará ubicado el checkbox
		} ],
		select: {
			style: 'multi', //aquí le decimos que queremos que sea multiselector
			selector:'td:first-child', //ubicación del selector
		},*/
		language: espLanguage, //agregamos variable de idioma español
		//dom:"Bfrtip", //damos de alta los botones en la posición default
		dom:"<'row'<'col s12 m6 l8'f><'col s12 m6 l4'B>>" + //posición de botones y filtro
			"<'row'<'col s12'tr>>" + //posición de la tabla
			"<'row'<'col s5'i><'col s7'p>>", //posición de la paginación y el resultado de las tablas
		buttons:[  //botones por default en la documentación, estos se agregan en la parte superior izquierda
			'copy', 'csv', 'excel', 'pdf', 'print'
		]
	});
	obtainData("#rolTable tbody", table); //agregamos la variable para obtener los datos
	eliminateData("#rolTable tbody", table); //agregamos la variable para obtener y poder eliminar datos
}
var obtainData = function(tbody,table){ //creamos la variable con las funciones dirigidas a tbody y table
	$(tbody).on("click","a.editar",function(){ //creamos la función que permita que al dar clic en el botón editar...
		var data = table.row( $(this).parents("tr") ).data(); //en la función obtenemos los datos de la fila y lo integramos como parámetro de row
		console.log( data ); //para verificar en la consola que me muestre la info
	});
}
var eliminateData = function(tbody,table){ //creamos la variable con las funciones dirigidas a tbody y table
	$(tbody).on("click","a.eliminar",function(){ //creamos la función que permita que al dar clic en el botón eliminar...
		var data = table.row( $(this).parents("tr") ).data(); //en la función obtenemos los datos de la fila y lo integramos como parámetro de row
		console.log( data ); //para verificar en la consola que me muestre la info
	});
}
var espLanguage = { //variable de idioma español
	"sProcessing":     "Procesando...",
	"sLengthMenu":     "Mostrar _MENU_ registros",
	"sZeroRecords":    "No se encontraron resultados",
	"sEmptyTable":     "Ningún dato disponible en esta tabla",
	"sInfo":           "Mostrando _START_ al _END_ de _TOTAL_",
	"sInfoEmpty":      "Al parecer no hay coincidencias con la búsqueda",
	"sInfoFiltered":   "(filtrado: _MAX_ registros)",
	"sInfoPostFix":    "",
	"sSearch":         "Buscar:",
	"sUrl":            "",
	"sInfoThousands":  ",",
	"sLoadingRecords": "Cargando...",
	"oPaginate": {
		"sFirst":    "Primero",
		"sLast":     "Último",
		"sNext":     "Siguiente",
		"sPrevious": "Anterior"
	},
	"oAria": {
		"sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
		"sSortDescending": ": Activar para ordenar la columna de manera descendente"
	}
}