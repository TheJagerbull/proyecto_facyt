
$(document).ready(function () {

    // $("#find_usr").hide();//modulo de alm_solicitudes vista de administrador_lista.php
    var availableTags = [
        "ActionScript",
        "AppleScript",
        "Asp",
        "BASIC",
        "C",
        "C++",
        "Clojure",
        "COBOL",
        "ColdFusion",
        "Erlang",
        "Fortran",
        "Groovy",
        "Haskell",
        "Java",
        "JavaScript",
        "Lisp",
        "Perl",
        "PHP",
        "Python",
        "Ruby",
        "Scala",
        "Scheme"
    ];

    $("#spinner").spinner();

    var min = 2;

////autocompletado de usuarios
    $("#autocomplete").autocomplete({
        minLenght: min,
        source: function (request, response) {
            $.ajax({
                request: $('#ACquery'),
                blah: console.log(request),
                url: base_url + "user/usuario/ajax_likeUsers",
                type: 'POST',
                dataType: "json",
                data: $('#ACquery').serialize(),
                success: function (data) {
                    // console.log("hello");
                    response($.map(data, function (item) {
                        return {
                            label: item.title,
                            value: [item.nombre, item.apellido, item.id_usuario]

                        };
                    }));
                }
            });
        }
    });
////autocompletado de articulos 1
    $("#autocompleteArt").autocomplete({
        minLenght: min,
        source: function (request, response) {
            $.ajax({
                request: $('#ACquery2'),
                // blah: console.log(request),
                url: base_url + "alm_articulos/alm_articulos/ajax_likeArticulos",
                type: 'POST',
                dataType: "json",
                data: $('#ACquery2').serialize(),
                success: function (data) {
                    response($.map(data, function (item) {
                        return {
                            label: item.title,
                            value: [item.descripcion]

                        }
                    }));
                }
            })
        }
    });

////autocompletado y formulario de articulos de Administrador sin redireccionamiento de vista
    $("#autocompleteAdminArt").autocomplete({
        minLenght: min,
        source: function (request, response) {
            $.ajax({
                request: $('#ACqueryAdmin'),
                // blah: console.log(request),
                url: base_url + "inventario/articulo/autocompletar",
                type: 'POST',
                dataType: "json",
                data: $('#ACqueryAdmin').serialize(),
                success: function (data) {
                    response($.map(data, function (item) {
                        return {
                            label: item.title,
                            value: [item.descripcion+" Codigo: "+item.cod_articulo]
                        }
                    }));
                }
            })
        }
    });
    $(function()
    {
        $('#error').hide();
        $("#autocompleteAdminArt").on('autocompleteselect', function(event, ui){
            $("input#autocompleteAdminArt").val(ui.item.value);
            //validar y formulario
            $('#error').hide();
            var articulo = $("input#autocompleteAdminArt").val();
            if (articulo == "")
            {
                $("#error").html("Debe escribir alguna descripci&oacute;n &oacute; c&oacute;digo de art&iacute;culo");
                $("#error").show();
                $("input#autocompleteAdminArt").focus();
                return false;
            }
            var aux = articulo.split(" Codigo: ");
            if(aux[1]==undefined)
            {
                // console.log("faaak");
                var dataString = 'descripcion=' + aux[0];
            }
            else
            {
                var dataString = 'descripcion=' + aux[0] + ' codigo=' + aux[1];
            }
            // var dataString = 'articulo='+ articulo;
            console.log(dataString);
            //alert (dataString);return false;
            $.ajax({
            type: "POST",
            url: base_url + "inventario/add/articulo",
            data: dataString,
            success: function(data) {
                $('#resultado').html(data),
                $('html, body').animate({
                    scrollTop: $("#resultado").offset().top
                }, 2000);
            }
            });
            return false;
        });
        $('#ACqueryAdmin').on('submit', function(){
            var dataString = $("input#autocompleteAdminArt").val();
            console.log(dataString);
            $.ajax({
            type: "POST",
            url: base_url + "inventario/add/articulo",
            data: dataString,
            success: function(data) {
                $('#resultado').html(data),
                $('html, body').animate({
                    scrollTop: $("#resultado").offset().top
                }, 2000);
            }
            });
            return false;
        });
        
    });

//// FIN DE autocompletado y formulario de articulos de Administrador sin redireccionamiento de vista

////autocompletado de mant_solicitudes
    $("#autocompleteMant").autocomplete({
        minLenght: min,
        source: function (request, response) {
            $.ajax({
                // request: $('#ACquery'),
                // blah: console.log(request),
                url: base_url + "mnt_solicitudes/mnt_solicitudes/ajax_likeSols",
                type: 'POST',
                dataType: "json",
                data: $('#ACquery3').serialize(),
                success: function (data) {
                    // console.log("hello");
                    response($.map(data, function (item) {
                        return {
                            label: item.title,
                            value: [item.id_orden, item.dependen, item.descripcion, item.cuadrilla]

                        }
                    }));
                }
            })
        }
    });


//Autocompletado para cuadrillas
    $("#autocomplete_cuadrilla").autocomplete({
        minLenght: min,
        source: function (request, response) {
            $.ajax({
                url: base_url + "mnt_cuadrilla/cuadrilla/ajax_likeSols",
                type: 'POST',
                dataType: "json",
                data: $('#ACquery4').serialize(),
                success: function (data) {
                    response($.map(data, function (item) {
                        return {
                            label: item.title,
                            value: [item.id, item.cuadrilla]
                        }
                    }));
                }
            })
        }
    });

//    $(".js-single-responsive").select2({
//        placeholder: "--SELECCIONE--",
//        allowClear: true
//    });
    $(".select2, .select2-multiple").select2({//Esto es para iniciar el select2 como clase, ejemplo en la clase del select:
//         theme: "bootstrap",
//         language: "es",
        placeholder: "--SELECCIONE--", // <input select = "nombre select" class =" Le agregas clase de boostrap y luego la terminas con clase2 para activarlo" 
        allowClear: true
       });

//permite llenar el select oficina cuando tomas la dependencia en modulos mnt_solicitudes

    $("#dependencia_select").change(function () {//Evalua el cambio en el valor del select
        $("#dependencia_select option:selected").each(function () { //en esta parte toma el valor del campo seleccionado
            var departamento = $('#dependencia_select').val();  //este valor se le asigna a una variable
            $.post(base_url + "mnt_solicitudes/orden/select_oficina", { //se le envia la data por post al controlador respectivo
                departamento: departamento  //variable a enviar
            }, function (data) { //aqui se evalua lo que retorna el post para procesarlo dependiendo de lo que se necesite
                $("#oficina_select").html(data); //aqui regreso las opciones del select dependiente 
            });
        });
    });

    $("#dependencia_agregar").change(function () {
        $("#dependencia_agregar option:selected").each(function () {
            var departamento = $('#dependencia_agregar').val();
            $.post(base_url + "mnt_ubicaciones/mnt_ubicaciones/mostrar_ubicaciones", {
                departamento: departamento
            }, function (data) {
                $("#ubica").html(data);
                $('#ubicaciones').DataTable({
                    "language": {
                        "url": base_url+"assets/js/lenguaje_datatable/spanish.json"
                    },
//                   "ordering": false,
                    searching: false
//                    "bLengthChange": false,
//                    "iDisplayLength": 3
                });
            });
        });
    });
    
    $("#nombre_contacto").change(function () {
        $("#nombre_contacto option:selected").each(function () {
            var nombre = $('#nombre_contacto').val();
            $.post(base_url + "mnt_solicitudes/orden/retorna_tele", {
                nombre: nombre
            }, function (data) {
                $("#telefono_contacto").val(data);
            });
        });
    });
// $(document).ready(function(){
//   $(this.target).find("#buscar").autocomplete({
//   		source: base_url+"user/usuario//autocomplete",
//         selectFirst: true
//   });
//  });
    // jQuery methods go here...
    //   $("#swSearch").autocomplete({
    // 	minLength: 1,
    // 		source: function(req, add){
    // 		$.ajax({
    // 			url: base_url+"user/usuario/jq_buscar_usuario", //Controller where search is performed
    // 			dataType: 'json',
    // 			type: 'POST',
    // 			data: req,
    // 			success: function(data){
    // 				if(data.response =='true'){
    // 				   add(data.message);
    // 				}
    // 			}
    // 		});
    // 		}
    // });
});
//PARA LIMITAR LA CANTIDAD DE CARACTERES EN UN CAMPO AL USUARIO,para poder usar debes usar los atributos:
//onKeyDown=" contador(this.form.asunto,this.form.resto,25);" onKeyUp="contador(this.form.asunto,this.form.resto,25);"
//donde contador es el nombre de la funcion, this.form.(NOMBRE DEL INPUT A LIMITAR),this.form.(NOMBRE DONDE MUESTRA EL LIMITE),25(Esto es la cantidad a limitar, puede ser N)
//esto se usa para generar orden de trabajo en mnt_solicitudes, puedes ver el codigo en la vista nueva_orden_autor
function contador(campo, cuentacampo, limite) {

    if (campo.value.length > limite)
        campo.value = campo.value.substring(0, limite);
    else
        $var2 = cuentacampo;
    $var = campo.value.length++;
    $(cuentacampo).text($var + "/" + limite); //en caso de usar con etiquetas
    //cuentacampo.value= ($var+ "/" +limite) ; //en caso de usar con inputs
}



function mostrar(num_sol, select, txt, div, band) {//se usa para mostrar en el modal asignar cuadrilla la informacion que necesito
    var id = select.value;
    var uri,uri2;
    if (band === 1){
        uri = base_url + "tic_cuadrilla/seleccionar";
        uri2 = base_url + "tic_cuadrilla/mostrar";
    }else{
        uri = base_url + "mnt_cuadrilla/seleccionar";
        uri2= base_url + "mnt_cuadrilla/mostrar";
    }
    $.post(uri, {
        id: id
    }, function (data) {
        $(txt).html(data);
        $(txt).select2({placeholder: "--SELECCIONE--"});
    });

    $.post(uri2, {
        id: id,
        sol: num_sol.value
    }, function (data) {
        $(div).html(data);
        $('#miembro' + num_sol.value).DataTable({
            "language": {
                "url": base_url+"assets/js/lenguaje_datatable/spanish.json"
            },
             responsive: true,
//             "ordering": false,
//            searching: false,
             'sDom': 'tp',
            "bLengthChange": false,
            "iDisplayLength": 5
        });
    });
    $('.modal .btn-primary').prop('disabled', false);
    $('.modal').on('hidden.bs.modal', function () {
        $(this).find('form')[0].reset(); //para borrar todos los datos que tenga los input, textareas, select.
        $(txt).html("");
        $(div).empty();//para vaciar el div donde se guarda la tabla para evitar errores
        $(txt).select2('val', $(txt).find(':selected').val());
        $(select.id).select2('val', $(select.id).find(':selected').val());//borra la opcion seleccionada
    });

}

function cuad_asignada(select,etiqueta, sol, id_cuadrilla, div, check,check2,band) {
    var id = id_cuadrilla;
    var solicitud = sol;
    var uri,uri2,uri3;
    if (band === 1){
        uri  = base_url + "tic_cuadrilla/responsable";
        uri2 = base_url + "tic_cuadrilla/seleccionar";
        uri3 = base_url + "tic_cuadrilla/miembros";
    }else{
        uri = base_url + "mnt_cuadrilla/responsable";
        uri2= base_url + "mnt_cuadrilla/seleccionar";
        uri3= base_url + "mnt_cuadrilla/miembros";
    }
    $.post(uri, {
        id: id
    }, function (data) {
        $(etiqueta).text(data);
    });
    $.post(uri2, {
        sol: solicitud,
        id: id
    }, function (data) {
        $(select).html(data);
         $(select).select2({placeholder: "--SELECCIONE--",allowClear: true});
    });
    $.post(uri3, {
        id: id,
        solicitud: solicitud
    }, function (data) {
        $(div).html(data);
        $('a[data-toggle="tab"]').on( 'shown.bs.tab', function (e) {
        $.fn.dataTable.tables( {visible: true, api: true} ).columns.adjust();
    } );
//      $('table.table'+solicitud).DataTable( {
////        ajax:           '../ajax/data/arrays.txt',
//        scrollY:        200,
//        scrollCollapse: true,
//        paging:         false
//    } );
        $('#cuad_assigned' + solicitud).DataTable({
            "language": {
                "url": base_url+"assets/js/lenguaje_datatable/spanish.json"
            },
//            scrollY:        200,
             scrollCollapse: true,
             'sDom': 'tp',
             responsive: true,
            "bLengthChange": false,
            "iDisplayLength": 5
        });
        $('#ayu_assigned'+ solicitud).DataTable({
            "language": {
                "url": base_url+"assets/js/lenguaje_datatable/spanish.json"
            },
//            scrollY:        200,
             scrollCollapse: true,
             responsive: true,
            'sDom': 'tp',
            "bLengthChange": false,
            "iDisplayLength": 5        
        });
//       if (document.getElementById(solicitud)){
//            document.getElementById(solicitud).disabled = true;
//        }
        $('.modal .btn-primary').prop('disabled', true);// para deshabilitar el boton de guardar cambios con la finalidad de usar el checkbox...
        $(check).change(function () {//se verifica con el id del checkbox para habilitar el boton de guardar en el modal
            $('.modal .btn-primary').prop('disabled', !this.checked);
        });
          $(check2).change(function () {//se verifica con el id del checkbox para habilitar el boton de guardar en el modal
          $('.modal .btn-primary').prop('disabled', !this.checked);
           $(select).prop('disabled', !this.checked);
        });
        $('.modal').on('hidden.bs.modal', function () {
            $(select).prop('disabled', 'disabled');
            $(this).find('form')[0].reset(); //para borrar todos los datos que tenga los input, textareas, select.
            $(div).empty();//para vaciar el div donde se guarda la tabla para evitar errores
            $('.modal .btn-primary').prop('disabled', false);
        });

    });
}

function ayudantes(check,select,estatus,sol, div1, div2,band) {
    var id = sol;
    var table1;
    var table;
    var ayu = 'ayu';
    var uri,uri2,uri3;
    if (band === 1){
        uri  = base_url + "tic/ayudantes/seleccionar";
        uri2 = base_url + "tic/ayudantes/sin_asignar";
        uri3 = base_url + "tic/ayudantes/asignados";
    }else{
        uri = base_url + "mnt/ayudantes/seleccionar";
        uri2= base_url + "mnt/ayudantes/sin_asignar";
        uri3= base_url + "mnt/ayudantes/asignados";
    }
    blah: console.log(id);
    $('a[data-toggle="tab"]').on( 'shown.bs.tab', function (e) {
    $.fn.dataTable.tables( {visible: true, api: true} ).columns.adjust();
     } );
    $.post(uri, {
        sol: sol,
        id: ayu
    }, function (data) {
        $(select).html(data);
        $(select).select2({placeholder: "--SELECCIONE--",allowClear: true});
    }); 
    $.post(uri2, {
        id: id
    }, function (data) {
        $(div1).html(data);
         
        // console.log('#ayudantes'+sol);
        table1 = $('#ayudisp' + sol).DataTable({
             responsive: true,
            "bLengthChange": false,
//            "sPaginationType": "numbers",
            "iDisplayLength": 4,
            "oLanguage": { 
                "sProcessing": "Procesando...",
                "sLengthMenu": "Mostrar _MENU_ registros",
                "sZeroRecords": "No se encontraron resultados",
                "sInfo": "Muestra desde _START_ hasta _END_ de _TOTAL_ registros",
                "sInfoEmpty": "Muestra desde 0 hasta 0 de 0 registros",
                "sInfoFiltered": "(filtrado de _MAX_ registros en total)",
                "sInfoPostFix": "",
                "sLoadingRecords": "Cargando...",
                "sEmptyTable": "No se encontraron datos",
                "sSearch": "Buscar:",
                "sUrl": "",  
                "oPaginate": 
                {
                    "sNext": '<i class="glyphicon glyphicon-menu-right" ></i>',
                    "sPrevious": '<i class="glyphicon glyphicon-menu-left" ></i>'
//                  "sLast": '<i class="glyphicon glyphicon-step-forward" ></i>',
//                  "sFirst": '<i class="glyphicon glyphicon-step-backward" ></i>'
                }
            }
        });
//        table1.columns.adjust();
    });
    $.post(uri3, {
        id: id,
        estatus: estatus
    }, function (data) {
        $(div2).html(data);
        table = $('#ayudasig' + sol).DataTable({
             responsive: true,
        "oLanguage": {
                "sLengthMenu": "Mostrar _MENU_ registros",
                "sProcessing": "Procesando...",
                "sZeroRecords": "No se encontraron resultados",
                "sInfo": "Muestra desde _START_ hasta _END_ de _TOTAL_ registros",
                "sInfoEmpty": "Muestra desde 0 hasta 0 de 0 registros",
                "sInfoFiltered": "(filtrado de _MAX_ registros en total)",
                "sInfoPostFix": "",
                "sLoadingRecords": "Cargando...",
                "sEmptyTable": "No se encontraron datos",
                "sSearch": "Buscar:",
                "sUrl": "",
        "oPaginate": 
                {
                     "sNext": '<i class="glyphicon glyphicon-menu-right" ></i>',
                    "sPrevious": '<i class="glyphicon glyphicon-menu-left" ></i>'
//                    "sLast": '&laquo',
//                    "sFirst": '&lt'
                }
            },
            "bLengthChange": false,
            "iDisplayLength": 4
        });
//        table.columns.adjust();
    });
    $(check).change(function () {//se verifica con el id del checkbox para habilitar el boton de guardar en el modal
        $(select).prop('disabled', !this.checked);
    });
    $('.modal .btn-primary').prop('disabled', false);
    $('.modal').on('hidden.bs.modal', function () {
//            $(select).prop('disabled', 'disabled');
            $(this).find('form')[0].reset(); //para borrar todos los datos que tenga los input, textareas, select.
            $(div1).empty();//para vaciar el div donde se guarda la tabla para evitar errores   
            $(div2).empty();//para vaciar el div donde se guarda la tabla para evitar errores 
    });
}

function mostrar_respon(select){
     $.post(base_url + "mnt_solicitudes/mnt_buscar_responsable", 
        function (data) {
        $(select).html(data);
    });
}

function mostrar_tipo_orden(select){
     $.post(base_url + "mnt_solicitudes/mnt_buscar_tipo_orden", 
        function (data) {
        $(select).html(data);
    });
}

function status_change_repor(select1,select2,select3,id_estatus,fecha1,fecha2){
    var estatus = id_estatus.val();
    $.post(base_url + "mnt_solicitudes/mnt_buscar_trabajador", {
         estatus: estatus,
         fecha1: fecha1.val(),
         fecha2: fecha2.val()
    }, function (data) {
        if ((data === '<option></option>') || data === ""){
            $('#openModal').prop('disabled',true);
            $(select1).select2('val', '');
            $(select1).prop('disabled',true);
            $('#sms').show();
        }else{
            $('#openModal').prop('disabled',false);
            $(select1).prop('disabled',false);
            $(select1).html(data);
            $('#sms').hide();
        }
    });
    $.post(base_url + "mnt_solicitudes/mnt_buscar_responsable", {
        estatus: estatus,
        fecha1: fecha1.val(),
        fecha2: fecha2.val()
    }, function (data) {
        if ((data === '<option></option>') || data === ""){
            $('#openModal2').prop('disabled',true);
            $(select2).select2('val', '');
            $(select2).prop('disabled',true);
            $('#sms2').show();
        }else{
            $('#openModal2').prop('disabled',false);
            $(select2).prop('disabled',false);
            $(select2).html(data);
            $('#sms2').hide();
        }
        $(select2).html(data);
//        $(select2).select2({placeholder: "--SELECCIONE--",allowClear: true});
    });
    $.post(base_url + "mnt_solicitudes/mnt_buscar_tipo_orden", {
        estatus: estatus,
        fecha1: fecha1.val(),
        fecha2: fecha2.val()
    }, function (data) {
        if ((data === '<option></option>') || data === ""){
            $('#openModal3').prop('disabled',true);
            $(select3).select2('val', '');
            $(select3).prop('disabled',true);
            $('#sms3').show();
        }else{
            $('#openModal3').prop('disabled',false);
            $(select3).prop('disabled',false);
            $(select3).html(data);
            $('#sms3').hide();
        }
        $(select3).html(data);
//        $(select3).select2({placeholder: "--SELECCIONE--",allowClear: true});
    }); 
    
}

function show_resp_worker(select,opt,div,fecha1,fecha2,estatus) {
//    console.log(opt);
//    console.log(select.val());
//     var nombre;
//      $.post(base_url + "mnt_ayudante/mnt_ayudante/ayu_name", {
//                id_trabajador: select.val()
//             },function (data1) {
//                nombre = data1;
//             });
    if (opt === 'trabajador'){
        moment.locale('es');
        // Falta crear la funcion que devuelve los datos del la solicitud, que son Fecha, id_orden, Asun y dependencia
        $.post(base_url + "mnt_solicitudes/mnt_trabajador", {
            id_trabajador: select.val(),
            fecha1: fecha1.val(),
            fecha2: fecha2.val(),
            estatus: estatus.val()
        }, function (data) {
            $(div).html(data);
            var asig = $('#asignacion').DataTable({
//               buttons: [
//            {
//                extend: 'print',
//                text: '<i class="glyphicon glyphicon-print"></i>',
//                titleAttr: 'Imprimir',
//                title: "Reporte por trabajador",
//                message: "Desde: "+moment(fecha1.val()).format('Do MMM YYYY')+ ' '+"Hasta: "+moment(fecha2.val()).format('Do MMM YYYY')+ '<br>'+"Trabajador: "+nombre,
//                customize: function ( win ) {
//                    $(win.document.body)
//                        .css( 'font-size', '10pt' )
////                        .prepend(
////                            '<img src="http://localhost/proyecto_facyt/assets/img/FACYT4.png"  style="position:absolute; top:0; left:0;" />'
////                        );
// 
//                    $(win.document.body).find( 'table' )
//                        .addClass( 'compact' )
//                        .css( 'font-size', 'inherit' );
//                }
//            }
//        ],
           
                "oLanguage": {
                    "sProcessing": "Procesando...",
                    "sLengthMenu": "Mostrar _MENU_ registros",
                    "sZeroRecords": "No se encontraron resultados",
                    "sInfo": "Muestra desde _START_ hasta _END_ de _TOTAL_ registros",
                    "sInfoEmpty": "Muestra desde 0 hasta 0 de 0 registros",
                    "sInfoFiltered": "(filtrado de _MAX_ registros en total)",
                    "sInfoPostFix": "",
                    "sLoadingRecords": "Cargando...",
                    "sEmptyTable": "No se encontraron datos",
                    "sSearch": "Buscar:",
                    "sUrl": "",  
                "oPaginate": 
                {
                     "sNext": '<i class="glyphicon glyphicon-menu-right" ></i>',
                    "sPrevious": '<i class="glyphicon glyphicon-menu-left" ></i>'
//                    "sLast": '&laquo',
//                    "sFirst": '&lt'
                }
                },
                 "sDom": '<"top"l<"clear">>rt<"bottom"ip<"clear">>',
                 searching: false,
                  scroller:       true,
                "bLengthChange": false,
                "iDisplayLength": 5
            });
//            asig.buttons().container()
//            .appendTo( '#asignacion_wrapper .col-sm-6:eq(0)' );
        });
    }
    if (opt === 'responsable'){
        moment.locale('es');
//        console.log('hola');
         $.post(base_url + "mnt_solicitudes/mnt_responsable", {
            id_trabajador: select.val(),
            fecha1: fecha1.val(),
            fecha2: fecha2.val(),
            estatus: estatus.val()
        }, function (data) {
            $(div).html(data);
            var asig = $('#res').DataTable({
           
                "oLanguage": {
                    "sProcessing": "Procesando...",
                    "sLengthMenu": "Mostrar _MENU_ registros",
                    "sZeroRecords": "No se encontraron resultados",
                    "sInfo": "Muestra desde _START_ hasta _END_ de _TOTAL_ registros",
                    "sInfoEmpty": "Muestra desde 0 hasta 0 de 0 registros",
                    "sInfoFiltered": "(filtrado de _MAX_ registros en total)",
                    "sInfoPostFix": "",
                    "sLoadingRecords": "Cargando...",
                    "sEmptyTable": "No se encontraron datos",
                    "sSearch": "Buscar:",
                    "sUrl": "",  
                "oPaginate": 
                {
                     "sNext": '<i class="glyphicon glyphicon-menu-right" ></i>',
                    "sPrevious": '<i class="glyphicon glyphicon-menu-left" ></i>'
//                    "sLast": '&laquo',
//                    "sFirst": '&lt'
                }
                },
                 "sDom": '<"top"l<"clear">>rt<"bottom"ip<"clear">>',
                 searching: false,
                  scroller:       true,
                "bLengthChange": false,
                "iDisplayLength": 5
            });
        });
    }
    if (opt === 'tipo_orden'){
        moment.locale('es');
//        console.log('hola');
         $.post(base_url + "mnt_solicitudes/mnt_tipo_orden", {
            id_cuad: select.val(),
            fecha1: fecha1.val(),
            fecha2: fecha2.val(),
            estatus: estatus.val()
        }, function (data) {
            $(div).html(data);
            var asig = $('#tipo').DataTable({
           
                "oLanguage": { 
                    "sProcessing": "Procesando...",
                    "sLengthMenu": "Mostrar _MENU_ registros",
                    "sZeroRecords": "No se encontraron resultados",
                    "sInfo": "Muestra desde _START_ hasta _END_ de _TOTAL_ registros",
                    "sInfoEmpty": "Muestra desde 0 hasta 0 de 0 registros",
                    "sInfoFiltered": "(filtrado de _MAX_ registros en total)",
                    "sInfoPostFix": "",
                    "sLoadingRecords": "Cargando...",
                    "sEmptyTable": "No se encontraron datos",
                    "sSearch": "Buscar:",
                    "sUrl": "",  
                "oPaginate": 
                {
                     "sNext": '<i class="glyphicon glyphicon-menu-right" ></i>',
                    "sPrevious": '<i class="glyphicon glyphicon-menu-left" ></i>'
//                    "sLast": '&laquo',
//                    "sFirst": '&lt'
                }
                },
                 "sDom": '<"top"l<"clear">>rt<"bottom"ip<"clear">>',
                 searching: false,
                  scroller:       true,
                "bLengthChange": false,
                "iDisplayLength": 5
            });
        });
    }
}

//function ayudantes_tmp(sol, div1, div2) {
//    var id = sol;
//    var table;
//    $.post(base_url + "mnt_ayudante/mnt_ayudante/mostrar_assigned_2", {
//        id: id
//    }, function (data) {
//        $(div2).html(data);
//         table = $('#ayudasig' + sol).DataTable({
//            "bLengthChange": false,
//            "iDisplayLength": 4
//        });
//       table.columns.adjust();
//    });
//     
//    $('.modal .btn-primary').prop('disabled', false);
//
//}
$(document).on("click", ".open-Modal", function () {
    var dato = $(this).data('id');
    var dato2 = $(this).data('tipo_sol');
    var dato3 = $(this).data('asunto');
    $(".modal-body #data").text(dato);
    $(".modal-body #num_sol").val(dato);
    $(".modal-body #tipo").text(dato2);
    $(".modal-body #asunto").text(dato3);

});

function listar_cargo(select, div, cuadrilla,band) {//se usa para mostrar los ayudantes al seleccionar un responsable para crear la cuadrilla
    var nombre = select.value;
    var cuad = cuadrilla.value;
    var uri;
    if(band !== 1){
        uri = 'mnt_cuadrilla/cuadrilla/listar_ayudantes';
    }else{
        uri = 'tic_cuadrilla/tic_cuadrilla/listar_ayudantes';
    }
    $.post(base_url + uri, {
        nombre: nombre,
        cuad: cuad
    }, function (data) {
        $(cuadrilla).attr('disabled', 'disabled');
        $(div).html(data);
        var table = $('#cargos').DataTable({
            "language": {
                "url": base_url+"assets/js/lenguaje_datatable/spanish.json"
            },
             responsive: true,
//             "ordering": false,
//            searching: false,
            "pagingType": "full_numbers",
            "bLengthChange": false,
            "iDisplayLength": 5
        });
//        table.columns.adjust();
        $("#file-3").fileinput({
            url: (base_url + 'tic_cuadrilla/crear'),
            showUpload: false,
            language: 'es',
            showCaption: false,
            browseClass: "btn btn-primary btn-sm",
            allowedFileExtensions: ['png','jpg','gif'],
            maxImageWidth: 512,
            maxImageHeight: 512
        });
        $('button[type="reset"]').click(function (event) {
            // Make sure we reset the native form first
            event.preventDefault();
            $(this).closest('form').get(0).reset();
            $(div).empty();//para vaciar el div donde se guarda la tabla para evitar errores
            $(cuadrilla).removeAttr('disabled');
            $("#cuadrilla").focus();
            // And then update select2 to match
            $('#id_trabajador_responsable').select2('val', $('#id_trabajador_responsable').find(':selected').val());
        });
    });
};

function listmiemb_cuadrilla(select, div,cuadrilla) {//se usa para mostrar los ayudantes al seleccionar un responsable para crear la cuadrilla
    var nombre = select.value;
    var cuad = cuadrilla.value;
     //blah: console.log(nombre);
    $.post(base_url + "mnt_miembros_cuadrilla/mnt_miembros_cuadrilla/list_miembros", {
        nombre: nombre,
        cuad: cuad
    }, function (data) {
       // $(cuadrilla).attr('disabled', 'disabled');
        $(div).html(data);
//        $('#trabajadores2').DataTable({
////             "ordering": false,
////            searching: false,
//            "bLengthChange": false,
//            "iDisplayLength": 3
//        });
        $("#file-3").fileinput({
            url: (base_url + 'mnt_cuadrilla/cuadrilla/crear_cuadrilla'),
            showUpload: false,
            language: 'es',
            showCaption: false,
            browseClass: "btn btn-primary btn-sm",
            allowedFileExtensions: ['png'],
            maxImageWidth: 512,
            maxImageHeight: 512
        });
        $('button[type="reset"]').click(function (event) {
            // Make sure we reset the native form first
            event.preventDefault();
            $(this).closest('form').get(0).reset();
            $(div).empty();//para vaciar el div donde se guarda la tabla para evitar errores
           // $(cuadrilla).removeAttr('disabled');
           // $("#cuadrilla").focus();
            // And then update select2 to match
            $('#id_trabajador').select2('val', $('#id_trabajador').find(':selected').val());
        });
    });
};

function validacion() {//para validar crear/editar orden de mantenimiento 
    if ($('#nombre_contacto').val().trim() === '') {
        swal({
            title: "Error",
            text: "Debes seleccionar una persona de contacto",
            type: "error"
//            timer: 3000
        });
        return false;
    }
//    if ($("#telefono_contacto").val().length < 1) {
//        $('#telefono_contacto').focus();
//        swal({
//            title: "Error",
//            text: "El número de teléfono de contacto es obligatorio",
//            type: "error"
////            timer: 3000
//        });
//        return false;
//    }
    if (isNaN($("#telefono_contacto").val())) {
        $('#telefono_contacto').focus();
        swal({
            title: "Error",
            text: "El teléfono de contacto solo debe contener números",
            type: "error"
        });
        return false;
    }
//    if ($("#telefono_contacto").val().length < 6) {
//        $('#telefono_contacto').focus();
//        swal({
//            title: "Error",
//            text: "El teléfono de contacto tener mínimo 6 caracteres",
//            type: "error"
////            timer: 3000
//        });
//        return false;
//    }
    if ($('#id_tipo').val().trim() === '') {
        swal({
            title: "Error",
            text: "Debes seleccionar el tipo de solicitud",
            type: "error"
//            timer: 3000
        });
        return false;
    }
    var $campo = $('#asunto').val().trim();
    //Se verifica que el valor del campo este vacio
    //Se eliminan espacios en blanco con trim()
    if ($campo === '') {
        $('#asunto').focus();
        swal({
            title: "Error",
            text: "Debe escribir el título de la solicitud",
            type: "error"
//            timer: 3000
        });
        return false;
    } else if ($campo.length <= 5) {
        $('#asunto').focus();
        swal({
            title: "Error",
            text: "Escriba correctamente el título de la solicitud",
            type: "error"
//            timer: 3000
        });
        return false;
    }
    var $descrip = $('#descripcion_general').val().trim();
    if ($descrip === '') {
        $('#descripcion_general').focus();
        swal({
            title: "Error",
            text: "Debe dar detalles de la solicitud",
            type: "error"
//            timer: 3000
        });
        return false;
    } else if ($descrip.length <= 10) {
        $('#descripcion_general').focus();
        swal({
            title: "Error",
            text: "Pocos detalles de la solicitud...",
            type: "error"
//            timer: 3000
        });
        return false;
    }
    if ($('#dependencia_select').val().trim() === '') {
        swal({
            title: "Error",
            text: "Debes seleccionar una dependencia",
            type: "error"
//            timer: 3000
        });
        return false;
    }
         if ($('#otro').is(':checked')) {
        var $oficina = $('#oficina_txt').val().trim();
        if ($oficina === '') {
            $('#oficina_txt').focus();
            swal({
                title: "Error",
                text: "Debe agregar la nueva ubicación",
                type: "error"
//            timer: 3000
            });
            return false;
        } else if ($oficina.length <= 3) {
            $('#oficia_txt').focus();
            swal({
                title: "Error",
                text: "Debe escribir correctamente la nueva ubicación",
                type: "error"
//            timer: 3000
            });
            return false;
        }
    }
};

function validacion_dep() {//para validar crear/editar orden de mantenimiento en
    if ($('#nombre_contacto').val().trim() === '') {
        swal({
            title: "Error",
            text: "Debes seleccionar una persona de contacto",
            type: "error"
//            timer: 3000
        });
        return false;
    }
//    if ($("#telefono_contacto").val().length < 1) {
//        $('#telefono_contacto').focus();
//        swal({
//            title: "Error",
//            text: "El número de teléfono de contacto es obligatorio",
//            type: "error"
////            timer: 3000
//        });
//        return false;
//    }
    if (isNaN($("#telefono_contacto").val())) {
        $('#telefono_contacto').focus();
        swal({
            title: "Error",
            text: "El teléfono de contacto solo debe contener números",
            type: "error"
        });
        return false;
    }
//    if ($("#telefono_contacto").val().length < 6) {
//        $('#telefono_contacto').focus();
//        swal({
//            title: "Error",
//            text: "El teléfono de contacto tener mínimo 6 caracteres",
//            type: "error"
////            timer: 3000
//        });
//        return false;
//    }
    if ($('#id_tipo').val().trim() === '') {
        swal({
            title: "Error",
            text: "Debes seleccionar el tipo de solicitud",
            type: "error"
//            timer: 3000
        });
        return false;
    }
    var $campo = $('#asunto').val().trim();
    //Se verifica que el valor del campo este vacio
    //Se eliminan espacios en blanco con trim()
    if ($campo === '') {
        $('#asunto').focus();
        swal({
            title: "Error",
            text: "Debe escribir el título de la solicitud",
            type: "error"
//            timer: 3000
        });
        return false;
    } else if ($campo.length <= 5) {
        $('#asunto').focus();
        swal({
            title: "Error",
            text: "Escriba correctamente el título de la solicitud",
            type: "error"
//            timer: 3000
        });
        return false;
    }
    var $descrip = $('#descripcion_general').val().trim();
    if ($descrip === '') {
        $('#descripcion_general').focus();
        swal({
            title: "Error",
            text: "Debe dar detalles de la solicitud",
            type: "error"
//            timer: 3000
        });
        return false;
    } else if ($descrip.length <= 10) {
        $('#descripcion_general').focus();
        swal({
            title: "Error",
            text: "Pocos detalles de la solicitud...",
            type: "error"
//            timer: 3000
        });
        return false;
    }

         if ($('#otro').is(':checked')) {
        var $ubicacion = $('#observac').val().trim();
        if ($ubicacion === '') {
            $('#observac').focus();
            swal({
                title: "Error",
                text: "Debe escribir la ubicación",
                type: "error"
//            timer: 3000
            });
            return false;
        } else if ($ubicacion.length <= 3) {
            $('#observac').focus();
            swal({
                title: "Error",
                text: "Debe escribir correctamente la nueva ubicación",
                type: "error"
//            timer: 3000
            });
            return false;
        }
    } else {
        if ($('#oficina_select').val().trim() === '') {
            swal({
                title: "Error",
                text: "Debes seleccionar una ubicación",
                type: "error"
//            timer: 3000
            });
            return false;
        }

    }
};

function valida_cuadrilla(){
     var $cuad = $('#cuadrilla').val().trim();
    if ($cuad === '') {
        $('#cuadrilla').focus();
        swal({
            title: "Error",
            text: "Debe escribir el nombre de la cuadrilla",
            type: "error"
//            timer: 3000
        });
        return false;
    }else if ($cuad.length <= 4) {
        $('#cuadrilla').focus();
        swal({
            title: "Error",
            text: "Debe escribir correctamente el nombre de la cuadrilla",
            type: "error"
//            timer: 3000
        });
        return false;
     }
    if ($('#id_trabajador_responsable').val().trim() === '') {
        swal({
            title: "Error",
            text: "Debe seleccionar un responsable para la cuadrilla",
            type: "error"
//            timer: 3000
        });
        return false;
    }
    var $img = $('#file-3').val().trim();
           if ($img === '') {
        swal({
            title: "Error",
            text: "Debe agregar una icono que represente a la cuadrilla",
            type: "error"
//            timer: 3000
        });
        return false;
    }
    var $nomb = $('#nombre_img').val().trim();
    if ($nomb === '') {
        $('#nombre_img').focus();
        swal({
            title: "Error",
            text: "Debe escribir el nombre del icono",
            type: "error"
//            timer: 3000
        });
        return false;
    }else if ($nomb.length >= 12) {
        $('#nombre_img').focus();
        swal({
            title: "Error",
            text: "El nombre no puede exceder de 11 carácteres",
            type: "error"
//            timer: 3000
        });
        return false;
     }
};

function vali_ubicacion(){
   var $ofi = $('#oficina_txt').val().trim();
    if ($ofi === '') {
        $('#oficina_txt').focus();
        swal({
            title: "Error",
            text: "Debe escribir el nombre de la nueva ubicación",
            type: "error"
//            timer: 3000
        });
        return false;
    }else if ($ofi.length <= 3) {
        $('#oficina_txt').focus();
        swal({
            title: "Error",
            text: "Debe escribir correctamente el nombre de la nueva ubicación",
            type: "error"
//            timer: 3000
        });
        return false;
     }


};

//por jcparra: Esta funcion permite crear un checkbx padre para que los hijos sean seleccionados por clase
//para llamarla tienes que usar (father = checkbox que hace la funcion de seleccionar todo)
// y el hijo es el nombre de la clase lo cual debes incluir en el checkbox_hijo de esta manera:
//  <input type="checkbox" class="son"> y puedes usar cualquier nombre o id. y para usar la funcion es de esta forma:
// <script type="text/javascript">
//    $(document).ready(function() {
//        all_check($('#father'),'son');
//   </script>
function all_check(father,son){ 
        $(father).on('click',function(){
        if(this.checked){
            $('.'+son).each(function(){
                this.checked = true;
            });
        }else{
             $('.'+son).each(function(){
                this.checked = false;
            });
        }
        });
        $('.'+son).on('click',function(){
            if($('.'+son+':checked').length === $('.'+son).length){
                $(father).prop('checked',true);
            }else{
                $(father).prop('checked',false);
            }
        });
}

///////por luigi: tiempo del servidor a uso horario -4:00 y
///////mensajes de alerta para solicitudes aprobadas
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
function buildModal(id, title, content, footer, size, height,form)
{
  var Modal = $('<div class="modal modal-message modal-info fade" id="'+id+'" />');
  if(size === '')
  {
    var modalDialog= $('<div class="modal-dialog"/>');
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
  if(height ==='')
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
  if(form !==''){
    modalContent.append(form);
  }
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
  // return(Modal);
}
///////por luigi: mensajes de alerta para solicitudes aprobadas
// $(document).ready(function () {

//     /* Auto notification */
//     setTimeout(function() {
//         $.ajax({
//                 // url: base_url + "index.php/alm_solicitudes/alm_solicitudes/check_aprovedDepSol",
//                 url: base_url + "index.php/template/template/check_alerts",
//                 type: 'POST',
//                 success: function (data) {
// //                        console.log(data);
//                         var response = $.parseJSON(data);
//                         //response es una variable traida del json en el controlador linea:19 del archivo: modules/template/controllers/template.php.
//                         //se utiliza para que de acuerdo con el objeto que trae, llama a la alerta correspondiente para avisar sobre el asunto que requiera atencion.
//                         //para desreferenciar y consultar los atributos del objeto que trae response, es a travez del nombre que recibio el "key" del arreglo en template.php
//                         //y la casilla numerica; en caso de ser varias, se debe hacer un loop, que recorra la primera referencia, ejemplo: response[key del array][numero de 0 a n].AtributoDeLaTablaSql
//                         //ejemplos para ejecucion.
// //                        console.log('arreglo del response= '+response);
// //                        console.log('objeto "key" del array= '+response['depSol']);
// //                        comento la linea 943 porque causa conflicto con las notificaciones
// //                        console.log('valor del atributo de la consulta de sql= '+ response['depSol'][0].nr_solicitud);
//                         var temp_id = [];//una variable de tipo arreglo, para los gritters que se desvaneceran solos
//                         for (val in response)
//                         {   
//                             switch(true)
//                             {
//                                 case val==='depSol' && response[val]!=0:
//                                     temp_id[1] = $.gritter.add({
//                                         // (string | mandatory) the heading of the notification
//                                         title: 'Solicitudes',
//                                         // (string | mandatory) the text inside the notification
//                                         text: 'Disculpe, usted posee solicitudes aprobadas en su departamento',
//                                         // (string | optional) the image to display on the left
//                                         // image: base_url+'/assets/img/alm/Art_check.png',
//                                         image: base_url+'/assets/img/alm/item_list_c_verde.png',
//                                         // (bool | optional) if you want it to fade out on its own or just sit there
//                                         sticky: true,
//                                         // (int | optional) the time you want it to be alive for before fading out
//                                         time: '',
//                                         // (string | optional) the class name you want to apply to that specific message
//                                         class_name: 'gritter-custom'
//                                     });
//                                 break;
// //                                case val==='sol' && response[val]!=0:
// //                                    var unique_id = $.gritter.add({
// //                                        // (string | mandatory) the heading of the notification
// //                                        title: 'Solicitudes',
// //                                        // (string | mandatory) the text inside the notification
// //                                        text: 'Disculpe, su solicitud ya ha sido aprobada',
// //                                        // (string | optional) the image to display on the left
// //                                        // image: base_url+'/assets/img/alm/Art_check.png',
// //                                        image: base_url+'/assets/img/alm/item_list_c_verde.png',
// //                                        // (bool | optional) if you want it to fade out on its own or just sit there
// //                                        sticky: true,
// //                                        // (int | optional) the time you want it to be alive for before fading out
// //                                        time: '',
// //                                        // (string | optional) the class name you want to apply to that specific message
// //                                        class_name: 'gritter-custom',
// //
// //                                        before_close: function(e){
// //                                            swal({
// //                                                title: "Recuerde",
// //                                                text: "Debe retirar los articulos en almacen para que no vuelva a aparecer este mensaje",
// //                                                type: "warning"
// //                                            });
// //                                            return false;
// //                                        }
// //                                    });
//                                     // You can have it return a unique id, this can be used to manually remove it later using
//                                     // setTimeout(function () {
//                                     //     $.gritter.remove(unique_id, {
//                                     //     fade: true,
//                                     //     speed: 'slow'
//                                     //     });
//                                     // }, 10000);
// //                                break;
//                                 case val==='calificar' && response[val]!=0:
//                                     var unique_id = $.gritter.add({
//                                         // (string | mandatory) the heading of the notification
//                                         title: 'Calificación',
//                                         // (string | mandatory) the text inside the notification
//                                         text: 'Disculpe, debe calificar las solicitudes de mantenimiento cerradas.',
//                                         // (string | optional) the image to display on the left
//                                         // image: base_url+'/assets/img/alm/Art_check.png',
//                                         image: base_url+'/assets/img/mnt/star1.png',
//                                         // (bool | optional) if you want it to fade out on its own or just sit there
//                                         sticky: true,
//                                         // (int | optional) the time you want it to be alive for before fading out
//                                         time: '',
//                                         // (string | optional) the class name you want to apply to that specific message
//                                         class_name: 'gritter-custom',

//                                         before_close: function(e){
//                                             swal({
//                                                 title: "Recuerde",
//                                                 text: "Debe calificar las solicitudes cerradas para que no vuelva a aparecer este mensaje.",
//                                                 type: "warning"
//                                             });
//                                             return false;
//                                         }
//                                     });
//                                 break;
//                                 default:

// //                                console.log("nope");
//                                 break;
//                             }
//                         };

//                         // You can have it return a unique id, this can be used to manually remove it later using
//                         setTimeout(function () {//para cerrar las alertas provicionales
//                             for (var i = temp_id.length - 1; i >= 0; i--)
//                             {
//                                 $.gritter.remove(temp_id[i], {
//                                 fade: true,
//                                 speed: 'slow'
//                                 });
//                             };
//                         }, 10000);
                        
//                     }
//         });
//     }, 1);

// });