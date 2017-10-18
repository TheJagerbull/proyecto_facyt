/* Admin sidebar starts */

$(document).ready(function () {

    $(window).resize(function ()
    {
        if ($(window).width() >= 991) {
            $(".sidey").slideDown(350);
        }
    });

});

$(document).ready(function () {

    $(".has_submenu > a").click(function (e) {
        e.preventDefault();
        var menu_li = $(this).parent("li");
        var menu_ul = $(this).next("ul");

        if (menu_li.hasClass("open")) {
            menu_ul.slideUp(350);
            menu_li.removeClass("open")
        }
        else {
            $(".nav > li > ul").slideUp(350);
            $(".nav > li").removeClass("open");
            menu_ul.slideDown(350);
            menu_li.addClass("open");
        }
    });

});

$(document).ready(function () {
    $(".sidebar-dropdown a").on('click', function (e) {
        e.preventDefault();

        if (!$(this).hasClass("dropy")) {
            // hide any open menus and remove all other classes
            $(".sidey").slideUp(350);
            $(".sidebar-dropdown a").removeClass("dropy");

            // open our new menu and add the dropy class
            $(".sidey").slideDown(350);
            $(this).addClass("dropy");
        }

        else if ($(this).hasClass("dropy")) {
            $(this).removeClass("dropy");
            $(".sidey").slideUp(350);
        }
    });

});



/* Admin sidebar navigation ends */

/* ********************************************************** */

/* ************************************** */

/* ************************************** */

/* ************************************** */

/* Scroll to Top starts */

$(".totop").hide();

$(function () {
    $(window).scroll(function () {
        if ($(this).scrollTop() > 300)
        {
            $('.totop').fadeIn();
        }
        else
        {
            $('.totop').fadeOut();
        }
    });

    $('.totop a').click(function (e) {
        e.preventDefault();
        $('body,html').animate({scrollTop: 0}, 500);
    });

});

/* Scroll to top ends */

/* ************************************** */

/* jQuery Notification (Gritter) starts */

$(document).ready(function () {

    /* Auto notification */

    // setTimeout(function() {
// 
    // var unique_id = $.gritter.add({
    // // (string | mandatory) the heading of the notification
    // title: 'Howdy! User 1',
    // // (string | mandatory) the text inside the notification
    // text: 'Today you got some messages and new members. Please check it out!',
    // // (string | optional) the image to display on the left
    // image: './img/user.jpg',
    // // (bool | optional) if you want it to fade out on its own or just sit there
    // sticky: false,
    // // (int | optional) the time you want it to be alive for before fading out
    // time: '',
    // // (string | optional) the class name you want to apply to that specific message
    // class_name: 'gritter-custom'
    // });
// 
    // // You can have it return a unique id, this can be used to manually remove it later using
    // setTimeout(function () {
    // $.gritter.remove(unique_id, {
    // fade: true,
    // speed: 'slow'
    // });
    // }, 10000);
// 
    // }, 4000);


    /* On click notification. Refer ui.html file */

    /* Regulat notification */
    // $(".notify").click(function (e) {

    //     e.preventDefault();
    //     var unique_id = $.gritter.add({
    //         // (string | mandatory) the heading of the notification
    //         title: 'Howdy! User 2',
    //         // (string | mandatory) the text inside the notification
    //         text: 'Today you got some messages and new members. Please check it out!',
    //         // (string | optional) the image to display on the left
    //         image: './img/user.jpg',
    //         // (bool | optional) if you want it to fade out on its own or just sit there
    //         sticky: false,
    //         // (int | optional) the time you want it to be alive for before fading out
    //         time: '',
    //         // (string | optional) the class name you want to apply to that specific message
    //         class_name: 'gritter-custom'
    //     });

    //     // You can have it return a unique id, this can be used to manually remove it later using
    //     setTimeout(function () {
    //         $.gritter.remove(unique_id, {
    //             fade: true,
    //             speed: 'slow'
    //         });
    //     }, 6000);

    // });

    /* Sticky notification */
    // $(".notify-sticky").click(function (e) {

    //     e.preventDefault();
    //     var unique_id = $.gritter.add({
    //         // (string | mandatory) the heading of the notification
    //         title: 'Howdy! User 3',
    //         // (string | mandatory) the text inside the notification
    //         text: 'Today you got some messages and new members. Please check it out!',
    //         // (string | optional) the image to display on the left
    //         image: './img/user.jpg',
    //         // (bool | optional) if you want it to fade out on its own or just sit there
    //         sticky: false,
    //         // (int | optional) the time you want it to be alive for before fading out
    //         time: '',
    //         // (string | optional) the class name you want to apply to that specific message
    //         class_name: 'gritter-custom'
    //     });

    // });

    /* Without image notification */
    // $(".notify-without-image").click(function (e) {

    //     e.preventDefault();
    //     var unique_id = $.gritter.add({
    //         // (string | mandatory) the heading of the notification
    //         title: 'Howdy! User 4',
    //         // (string | mandatory) the text inside the notification
    //         text: 'Esto es una prueba de notificaciones!',
    //         // (bool | optional) if you want it to fade out on its own or just sit there
    //         sticky: false,
    //         // (int | optional) the time you want it to be alive for before fading out
    //         time: '',
    //         // (string | optional) the class name you want to apply to that specific message
    //         class_name: 'gritter-custom'
    //     });

    // });

    /* Remove notification */

    $(".notify-remove").click(function () {

        $.gritter.removeAll();
        return false;

    });
});

/* Notification ends */

///////por luigi: tiempo del servidor a uso horario -4:00
//#currentTime es el area del header donde se muestra la hora
$(document).ready(function () {
    $.ajax({//consulto el tiempo en el servidor
        url: base_url + "template/template/get_serverTime",//direccion de la funcion que captura el tiempo en servidor
        type: 'POST',
        success: function(data) {
            var serverTime = new Date($.parseJSON(data)+450);//asigno la captura a la varitable serverTime
            // console.log('server = '+serverTime.toUTCString());
            function startInterval(){//funcion de induccion para iniciar el hilo
                setInterval('updateTime();', 1000);//ejecucion de un hilo para la funcion de actualizar tiempo, cada 1 segundo o 1000 milesimas de segundos
            }
            window.updateTime = function(){//funcion de ejecucion de hilo para actualizar el tiempo
                var clock = $('#currentTime');//capturo el elemento de la interfaz en una variable
                var aux = serverTime.getTime();//asigno el valor de milesimas entero de segundos del tiempo del servidor
                aux+=1000;//le sumo 1 segundo
                serverTime.setTime(aux);//lo actualizo en tiempo de servidor
                var rightNow = serverTime;//lo asigno a una variable para convertirlo a tiempo humano
                var hourAux = rightNow.getUTCHours();
                if(rightNow.getUTCHours() < 4)
                {
                    hourAux +=20;
                }
                else
                {
                    hourAux -=4;
                }
                var hours = hourAux;
                hours = hours % 12;
                // var hourAux = ((rightNow.getUTCHours() < 4 ? rightNow.getUTCHours()+=12 : rightNow.getUTCHours())-4);
                // var hours = ((rightNow.getUTCHours() < 4 ? rightNow.getUTCHours()+=12 : rightNow.getUTCHours())-4) % 12;//convierto a horas de UTC, y le resto el tiempo correspondiente del uso horario de "La Asuncion GMT -4:00", mientras lo mantengo en un margen menor a 12
                var minutes = rightNow.getUTCMinutes();//variable auxiliar para los minutos
                var seconds = rightNow.getUTCSeconds();//variable auxiliar para los segundos
                var ampm = hourAux >= 12 ? 'pm' : 'am';//variable que determina si las 12 horas estan por arriba, o por abajo del medio dia
                hours = hours ? hours : 12;//determino si las horas marcan 00 y escribe 12, de lo contrario la hora correspondiente
                hours = hours < 10 ? '0'+hours : hours;
                minutes = minutes < 10 ? '0'+minutes : minutes;//relleno con un '0' a la izquierda si los minutos estan debajo de 10
                seconds = seconds <10 ? '0'+seconds : seconds;//relleno con un '0' a la izquierda si los segundos estan debajo de 10
                var humanTime = hours + ':' + minutes + ':' + seconds + ' ' + ampm;//crea la variable auxiliar del string de la hora actualizada en formato leible
                // console.log(humanTime);
                clock.html(humanTime);//escribo el string en la interfaz
            },
            startInterval();
        }
    });
});
///////por luigi: para actualizar la session de carrito en momentos de ser enviado durante la session
$(document).ready(function() {
        //setInterval('update();', (60000*3));
        var uri = location.pathname;
        // var codeigniterPath = uri.slice(uri.lastIndexOf('index.php/')+10);
        var codeigniterPath = uri.slice(uri.lastIndexOf('edu.ve/')+7);
        if(codeigniterPath != 'solicitud/generar')
        {
            setInterval(function() {
                $.ajax({ url: base_url + "template/template/update_cart_session",
                    type: 'POST',
                    data: 'uri='+codeigniterPath,
                    success: function(data){
                        var response = $.parseJSON(data);
                        // console.log(response.cart);
                        if(response.cart==='empty')
                        {
                            var head = $('#cartContent .dropdown-head');
                            var body = $('#cartContent .dropdown-body');
                            var foot = $('#cartContent .dropdown-foot');
                            head.html('<span class="dropdown-title"><a class="btn-block no-hover-effect" href="<?php echo base_url() ?>solicitud/generar">Agregar artículos <i class="fa fa-plus color fa-fw"></i></a></span>');
                            body.html('<div id="cart" class="alert alert-info well-xs" style="margin-bottom: 0px !important;"><i>Debe generar una solicitud, para mostrar articulos agregados</i></div>');
                            if(response.permit)
                            {
                                foot.html('<a href="<?php echo base_url() ?>solicitudes/usuario">Ver solicitudes</a>');
                            }
                        }
                    },
                });
            }, (60000));
        }
        
});
///////por luigi: para agregar articulos en cualquier momento, desde el header (incompleto)
$(document).ready(function() {
    $("#call-modal").click(function(){
        console.log("booh!");
        $("#multPurpModal").modal(
            backdrop=false
            );
        var mhead = $("#multPurpModal .modal-header");
        var mbody = $("#multPurpModal .modal-body");
        var mfoot = $("#multPurpModal .modal-footer");
        mhead.html('<h3>Agregar artículos <i class="fa fa-plus color fa-fw"></i></h3>');

        $("#multPurpModal").modal('show');
    });
});
//Funcion dinamica para construir modal a travez de parametros Por: Luigi Palacios; Mod. Juan Parra para mostrar el footer
function buildModal(id, title, content, footer, size, height)
{ 
  var Modal = $('<div class="modal modal-message modal-info fade" id="'+id+'" tabindex="-1" role="dialog"/>');
  if(typeof(size) === "undefined" || size === '')
  {
    var modalDialog= $('<div class="modal-dialog" role="document"/>');
  }
  else
  {
    var modalDialog= $('<div class="modal-dialog modal-'+size+'"/>');
  }
  // var modalDialog= $('<div class="modal-dialog modal-lg"/>');
  // var modalDialog= $('<div class="modal-dialog modal-sm"/>');
  Modal.append(modalDialog);
  var modalContent= $('<div class="modal-content" />');
  modalDialog.append(modalContent);
  var modalHeader= $('<div class="modal-header" />');
  var modalTitle= $('<h4 class="modal-title"/>');
  var closeButton=$('<button class="close" data-dismiss="modal" aria-hidden="true"/>');
  closeButton.html('&times;');
  /*<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>*/
  modalTitle.append(title);
  modalHeader.append(modalTitle);
  if(typeof(height) === "undefined" || height=== '')
  {
    var modalBody = $('<div class="modal-body"/>');
  }
  else
  {
    var modalBody = $('<div class="modal-body" style="height: '+height+'px"/>');
  }

  var modalFooter= $('<div class="modal-footer" />');
  modalContent.append(modalHeader);
  modalContent.append(modalBody);
  modalContent.append(modalFooter);
  modalBody.empty();
  modalBody.append(content);
  if(footer !== '')
  {
    modalFooter.append(footer);
  }
  Modal.modal('show');
  Modal.on('hidden.bs.modal', function(){
    Modal.remove();
  });
  return(Modal);
}

// function buildDataTable(id, columns, url, columnAttr, dbTable, inputs)
var genericTable;
function buildDataTable(config)
{
    // console.log("--variables--");
    // console.log(config);
    //se construye la tabla
    // <div class="table-responsive">
    // <div class="col-lg-12 col-md-12 col-sm-12">
    // console.log(tablediv);
    var tablerep = $('#'+config.id);
    tablerep.attr('style', 'width:100%');
    console.log(tablerep);
    //se le agrega atributos a la tabla (una ID y una clase)
    // tablerep.attr('id', config.id);
    // tablerep.attr('class', "table table-hover table-striped table-bordered table-condensed");
    //selecciona la cabezera de la tabla
    // var tableHeader = $('#'+config.id+' > thead tr');
    var tableHead = $('#'+config.id+' > thead tr');
    //se define la fila de la cabezera
    // var tableHead =  $('<tr/>');
    //se define el cuerpo de la tabla
    // var tableBody = $('<tbody/>');
    // var tableFoot = $('<tfoot/>');
    var columnas = [];//variable para las columnas de la tabla de la base de datos
    var nombres = [];//variable para los nombres en la interfaz, que corresponde con cada columna de la tabla en la base de datos, que se muestra al usuario
    //se construye el header de la tabla.
    tableHead.html('');
    for (var i = 0; i < config.columns.length; i++)//para construir el header de la tabla para DataTable
    {
        columnas[i] = config.columns[i].value;
        // nombres[i] = columns[i].name;
        //define cada columna en la cabezera
        tableHead.append('<th>'+config.columns[i].name+'</th>');
    }
    //se apartan las columnas de la tabla de la bd y las columnas de la tabla de la bd
    // console.log("columnas: ");
    // console.log(columnas);
    // console.log("tabla: ");
    // console.log(config.dbTable);
    //se ensambla toda la tabla de html, en jquery
    // tableHeader.append(tableHead);
    // tablerep.append(tableHeader);
    // tablerep.append(tableBody);
    // tablerep.append(tableFoot);
    //se inicializa las variable de atributos para la DataTable
    cols = [];//las columnas en la base de datos
    notSearchable =[];//las columnas que NO seran tomadas en cuentas cuando se consulta en el buscador del DataTable
    notSortable =[];//las columnas que NO seran ordenables DataTable
    notVisible =[];//las columnas que NO seran visibles en la DataTable
    numberOfColumns = columnas.length;//cantidad de columnas involucradas en el recorrido de las variables a re-definir para el DataTable
    for (var i = 0; i < columnas.length; i++)//aqui construlle las columnas de la datatable junto con sus atributos de busqueda, ordenamiento y/o visibilidad en interfaz
    {//cada "i" corresponde con cada columna, y atributo de columnAttr
        // console.log(columnas[i]);
        cols.push({'sName':columnas[i]});//columnas a consultar en bd
        //variable para el pdf
        // pdfcols.push({'sName':columnas[i], 'column':nombres[i]});
        // console.log(dtOpciones[columnas[i]].bSearchable);
        if(!config.columnAttr[columnas[i]].bSearchable)
        {
            notSearchable.push(i);
        }
        if(!config.columnAttr[columnas[i]].bSortable)
        {
            notSortable.push(i);
        }
        if(!config.columnAttr[columnas[i]].bVisible)
        {
            notVisible.push(i);
        }
        // acols.push(dtOpciones[columnas[i]]);//opciones de las columnas en bd
    }
    // console.log(cols);
    // console.log(notSearchable);
    // console.log(notSortable);
    // console.log(notVisible);
    // console.log(tablerep.length);
    console.log($('#'+config.id+' tbody tr').length);
    // var genericTable = $('#'+config.id);
    // if($('#'+config.id+' tbody tr').length <= 1)
    // if(!$.fn.DataTable.isDataTable('#'+config.id))
    if(!$.fn.DataTable.isDataTable(genericTable))
    {
        genericTable = tablerep.DataTable({
            "oLanguage":{
                "sProcessing":"Procesando...",
                "sLengthMenu":"Mostrar _MENU_ registros",
                "sZeroRecords":"No se encontraron resultados",
                "sInfo":"Muestra desde _START_ hasta _END_ de _TOTAL_ registros",
                "sInfoEmpty":"Muestra desde 0 hasta 0 de 0 registros",
                "sInfoFiltered":"(filtrado de _MAX_ registros en total)",
                "sInfoPostFix":"",
                "sLoadingRecords":"Cargando...",
                "sEmptyTable":"No se encontraron datos",
                "sSearch":"Buscar:",
                "sUrl":"",
                "oPaginate":{
                    "sNext":"Siguiente",
                    "sPrevious":"Anterior",
                    "sLast":'<i class="glyphicon glyphicon-step-forward" title="Último"  ></i>',
                    "sFirst":'<i class="glyphicon glyphicon-step-backward" title="Primero"  ></i>'
                    }
                },
            "bProcessing":true,
            "lengthChange":true,
            // "sDom": '<"top"lp<"clear">>rt<"bottom"ip<"clear">>',
            "info":false,
            "altEditor":true,
            "buttons": [
                {
                    extend:'selected',
                    text: 'Justificar',
                    name: 'justificacion'
                }
            ],
            "stateSave":true,//trae problemas con la columna no visible
            "bServerSide":true,
            "pagingType":"full_numbers",
            "sServerMethod":"GET",
            "sAjaxSource":config.url || "tablas",
            "bDeferRender":true,
            "fnServerData": function (sSource, aoData, fnCallback, oSettings){
                aoData.push({"name":"columnas", "value": columnas}, {"name":"tablas", "value": config.dbTable}, {"name": "joins", "value": config.dbCommonJoins}, {"name":"ambiguos", "value": config.dbAbiguous});//para pasar datos a la funcion que construye la tabla
                if(config.inputs)
                {
                    // console.log("true");
                    // console.log(config.inputs);
                    for (var i = config.inputs.length - 1; i >= 0; i--) {//incompleto(recorre los IDs de los inputs que se usaran para la datatable)
                        aoData.push({"name":config.inputs[i], "value": $("#"+config.inputs[i]).val()});
                    }
                    // aoData.push({"name":""})
                }
                oSettings.JqXHR = $.ajax({
                    "dataType": "json",
                    "type": "GET",
                    "url": sSource,
                    "data": aoData,
                    "success": fnCallback
                });
            },
            // "drawCallback": function ( settings ){
            //     if(flag == true)//pendiente por mejorar...(está sin uso)
            //     {
            //         var api = this.api();
            //         var rows = api.rows( {page:'current'} ).nodes();
            //         var last=null;
            //         var hiddenColumn = numberOfColumns -1;
            //         var colspan = numberOfColumns -1;
            //         api.column( hiddenColumn, {page:'current'} ).data().each( function ( group, i )
            //         {
            //                 if ( last !== group )
            //                 {
            //                         $(rows).eq( i ).before(
            //                                 '<tr class="group"><td colspan="'+colspan+'" style="cursor: pointer !important;">'+group+'</td></tr>'
            //                         );

            //                         last = group;
            //                 }
            //         });
            //     }
            // },
            "iDisplayLength":10,
            "aLengthMenu":[[10,25,50,-1],[10,25,50,"ALL"]],
            "aaSorting":[[0,"desc"]],
            // "orderFixed": [notVisible[0], 'asc'],
            "columns": cols,
            "aoColumnDefs": [
                    {"searchable": false, "targets": notSearchable},
                    {"orderable": false, "targets": notSortable},
                    {"visible": false, "targets": notVisible},
                    {"orderData": [notVisible[0], 0], "targets": notVisible}
            ]
        });
        console.log(genericTable);
        genericTable.draw();
    }
    else
    {
        console.log("else");
        console.log($('#'+config.id));
        console.log($("#"+config.id).length);
        // $('#'+config.id).ajax.reload();
        genericTable.draw();
    }
    // console.log("before return!");
    // tablediv.append(tablerep);
    // return(tablediv);
}

function buildEdiTable(config)
{
    if(!$.fn.DataTable.isDataTable($('#'+config.id)))
    {
        var tableHead = $('#'+config.id+' > thead tr');
        var columnas = [];
        tableHead.html('');
        for (var i = 0; i < config.columns.length; i++)//para construir el header de la tabla para DataTable
        {
            columnas[i] = config.columns[i].id;
            // nombres[i] = columns[i].name;
            //define cada columna en la cabezera
            tableHead.append('<th>'+config.columns[i].title+'</th>');
        }

        var tablerep = $('#'+config.id);
        tablerep.attr('style', 'width:100%');
        var columnDefs = config.columns;
        tablerep.DataTable({
            "language": {
                "url": base_url+"assets/js/lenguaje_datatable/spanish.json"
            },
            "aoColumns": columnDefs,
            "bProcessing": true,
            "stateSave": true,
            "bDeferRender": true,
            "altEditor": true,      // Enable altEditor ****
            "buttons": 
            [
                {
                    extend: 'selected', // Bind to Selected row
                    text: config.buttonName || 'Editar',
                    className: 'btn btn-info',
                    name: 'edit'        // DO NOT change name
                }
            ],
            "select": 'single',     // enable single row selection
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "pagingType": "full_numbers", //se usa para la paginacion completa de la tabla
            "sDom": '<"row"<"col-sm-2"f><"col-sm-8"><"col-sm-2"B>>rt<"row"<"col-sm-2"l><"col-sm-10"p>>', //para mostrar las opciones donde p=paginacion,l=campos a mostrar,i=informacion
            "order": [[1, "asc"]], //para establecer la columna a ordenar por defecto y el orden en que se quiere 
            "columnDefs": [{"className": "dt-center","targets": [-1,-2,-3]}],//para centrar el texto en una columna
            "ajax": {
                "url": config.url,
                "type": "GET",
                "data":
                {
                    "columnas": columnas,
                    "tablas": config.dbTable,
                    "joins": config.dbCommonJoins,
                    "ambiguos": config.dbAbiguous
                }
            }
        });
    }
}

