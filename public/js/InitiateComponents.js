$(document).ready(function(){
  $(".button-collapse").sideNav();// Inicia sideNav para navegaciÃ³n izquierdo
  $('.tooltipped').tooltip({delay: 50}); // Iniciamos tooltips
  $('.chips-initial').material_chip({  //iniciamos chips
    data: [{
      tag: 'Maria Luisa',
    }],
  });
  $('#atendio.chips-initial').material_chip({  //iniciamos chips para el ID: #atendio (nuevaCompra_nuevo.html)
    data: [{
      tag: 'Escribe y teclea Enter para crear',
    }],
  });
  $('#checklistCliente.chips-initial').material_chip({  //iniciamos chips para el ID: #checklistCliente (nuevaCompra_nuevo.html)
    data: [{
      tag: 'Escribe y teclea Enter para crear',
    }],
  });
  $('select').material_select(); //iniciamos el select
  $(".help-collapse").sideNav({ // Inicia sideNav para navegaciÃ³n derecho de ayuda
    edge:'right', //para que lo muestre a la derecha
    }
  );
  $('.modal').modal(); //Iniciamos modales
  $('.dropdown-button').dropdown({ //iniciamos el dropdown
    inDuration: 300,
    outDuration: 225,
    //hover: true, // Se activa al hacer hover
    click: true, // se activa al hacer clic
    belowOrigin: true, // Se mostrarÃ¡ hacia abajo del elemento
    alignment: 'right' // Alineado a la derecha
    }
  );
  $('.timepicker').pickatime({
    default: 'now', // Set default time
    fromnow: 0,       // set default time to * milliseconds from now (using with default = 'now')
    twelvehour: false, // Use AM/PM or 24-hour format
    //Lineas para cambiar el idioma
    donetext: 'ACEPTAR', // text for done-button
    cleartext: 'LIMPIAR', // text for clear-button
    canceltext: 'CANCELAR', // Text for cancel-button
    autoclose: false, // automatic close timepicker
    ampmclickable: true, // make AM PM clickable
    aftershow: function(){} //Function for after opening timepicker
  });
  $('#fecha_nacimiento.datepicker').pickadate({
      //Cambiamos idiomas a espaÃ±ol
      labelMonthNext: 'Siguiente mes',
      labelMonthPrev: 'Regresar mes',
      labelMonthSelect: 'Selecciona el mes',
      labelYearSelect: 'Selecciona el aÃ±o',
      monthsFull: [ 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre' ],
      monthsShort: [ 'Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic' ],
      weekdaysFull: [ 'Domingo', 'Lunes', 'Martes', 'MiÃ©rcoles', 'Jueves', 'Viernes', 'SÃ¡bado' ],
      weekdaysShort: [ 'Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab' ],
      weekdaysLetter: [ 'D', 'L', 'M', 'M', 'J', 'V', 'S' ],
      today: 'Hoy',
      clear: 'Limpiar',
      close: 'Aceptar',
      selectMonths: true, // Creates a dropdown to control month
      selectYears: 100, // Creates a dropdown of 15 years to control year
      min: new Date(1960,1,1),
      max: true,
      format: 'yyyy/mm/dd'
  });
  $('.datepicker').pickadate({
    //Cambiamos idiomas a espaÃ±ol
    labelMonthNext: 'Siguiente mes',
    labelMonthPrev: 'Regresar mes',
    labelMonthSelect: 'Selecciona el mes',
    labelYearSelect: 'Selecciona el aÃ±o',
    monthsFull: [ 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre' ],
    monthsShort: [ 'Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic' ],
    weekdaysFull: [ 'Domingo', 'Lunes', 'Martes', 'MiÃ©rcoles', 'Jueves', 'Viernes', 'SÃ¡bado' ],
    weekdaysShort: [ 'Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab' ],
    weekdaysLetter: [ 'D', 'L', 'M', 'M', 'J', 'V', 'S' ],
    today: 'Hoy',
    clear: 'Limpiar',
    close: 'Aceptar',
    selectMonths: true, // Creates a dropdown to control month
    selectYears: 15 // Creates a dropdown of 15 years to control year
  });
  $('input.autocomplete').autocomplete({ //Iniciamos el autocomplete
    data: { //agregamos data de ejemplo, el null es para decir que no llevarÃ¡ una imagen o Ã­cono a un lado del nombre...
      "Apple": null,
      "Microsoft": null,
      "Google": null,
    },
    limit: 5, // The max amount of results that can be shown at once. Default: Infinity.
    onAutocomplete: function(val) {
    // Callback function when value is autcompleted.
    },
    minLength: 1, // The minimum length of the input for the autocomplete to start. Default: 1.
  });
  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': document.querySelector('[name="csrf-token"]').content
    }
  });
  // Extendemos metodos jQuery ajax
  jQuery.each( [ "put", "delete" ], function( i, method ) {
    jQuery[ method ] = function( url, data, callback, type ) {
      if ( jQuery.isFunction( data ) ) {
        type = type || callback;
        callback = data;
        data = {};
      }

      return jQuery.ajax({
        url: url,
        type: 'post',
        dataType: type,
        data: $.extend(data, {'_method': method}),
        success: callback
      });
    };
  });
}); //aquÃ­ termina el function