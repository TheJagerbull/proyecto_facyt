
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
                url: base_url + "index.php/user/usuario/ajax_likeUsers",
                type: 'POST',
                dataType: "json",
                data: $('#ACquery').serialize(),
                success: function (data) {
                    // console.log("hello");
                    response($.map(data, function (item) {
                        return {
                            label: item.title,
                            value: [item.nombre, item.apellido, item.id_usuario]

                        }
                    }));
                }
            })
        }
    });
////autocompletado de articulos 1
    $("#autocompleteArt").autocomplete({
        minLenght: min,
        source: function (request, response) {
            $.ajax({
                request: $('#ACquery2'),
                // blah: console.log(request),
                url: base_url + "index.php/alm_articulos/alm_articulos/ajax_likeArticulos",
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
                url: base_url + "index.php/alm_articulos/alm_articulos/ajax_likeArticulos",
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
        $("#check_inv").click(function(){
            //validar y formulario
            $('#error').hide();
            var articulo = $("input#autocompleteAdminArt").val();
            if (articulo == "")
            {
                $("#error").html("Debe escribir alguna descripcion &oacute; c&oacute;digo de art&iacute;culo");
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
            // console.log(dataString);
            //alert (dataString);return false;
            $.ajax({
            type: "POST",
            url: "alm_articulos/ajax_formProcessing",
            data: dataString,
            success: function(data) {
                $('#resultado').html(data)
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
                url: base_url + "index.php/mnt_solicitudes/mnt_solicitudes/ajax_likeSols",
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
                url: base_url + "index.php/mnt_cuadrilla/cuadrilla/ajax_likeSols",
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
         theme: "bootstrap",
         language: "es",
        placeholder: "--SELECCIONE--", // <input select = "nombre select" class =" Le agregas clase de boostrap y luego la terminas con clase2 para activarlo" 
        allowClear: true
       });

//permite llenar el select oficina cuando tomas la dependencia en modulos mnt_solicitudes

    $("#dependencia_select").change(function () {//Evalua el cambio en el valor del select
        $("#dependencia_select option:selected").each(function () { //en esta parte toma el valor del campo seleccionado
            var departamento = $('#dependencia_select').val();  //este valor se le asigna a una variable
            $.post(base_url + "index.php/mnt_solicitudes/orden/select_oficina", { //se le envia la data por post al controlador respectivo
                departamento: departamento  //variable a enviar
            }, function (data) { //aqui se evalua lo que retorna el post para procesarlo dependiendo de lo que se necesite
                $("#oficina_select").html(data); //aqui regreso las opciones del select dependiente 
            });
        });
    });

    $("#dependencia_agregar").change(function () {
        $("#dependencia_agregar option:selected").each(function () {
            var departamento = $('#dependencia_agregar').val();
            $.post(base_url + "index.php/mnt_ubicaciones/mnt_ubicaciones/mostrar_ubicaciones", {
                departamento: departamento
            }, function (data) {
                $("#ubica").html(data);
                $('#ubicaciones').DataTable({
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
            $.post(base_url + "index.php/mnt_solicitudes/orden/retorna_tele", {
                nombre: nombre
            }, function (data) {
                $("#telefono_contacto").val(data);
            });
        });
    });
// $(document).ready(function(){
//   $(this.target).find("#buscar").autocomplete({
//   		source: base_url+"index.php/user/usuario//autocomplete",
//         selectFirst: true
//   });
//  });
    // jQuery methods go here...
    //   $("#swSearch").autocomplete({
    // 	minLength: 1,
    // 		source: function(req, add){
    // 		$.ajax({
    // 			url: base_url+"index.php/user/usuario/jq_buscar_usuario", //Controller where search is performed
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

function mostrar(num_sol, select, txt, div) {//se usa para mostrar en el modal asignar cuadrilla la informacion que necesito
    var id = select.value;
    $.post(base_url + "index.php/mnt_responsable_orden/mnt_responsable_orden/select_responsable", {
        id: id
    }, function (data) {
        $(txt).html(data);
        $(txt).select2({placeholder: "--SELECCIONE--"});
    });

    $.post(base_url + "index.php/mnt_asigna_cuadrilla/mnt_asigna_cuadrilla/mostrar_cuadrilla", {
        id: id,
        sol: num_sol.value
    }, function (data) {
        $(div).html(data);
        $('#miembro' + num_sol.value).DataTable({
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
        $('#cuadrilla_select' + num_sol.value).select2('val', $('#cuadrilla_select' + num_sol.value).find(':selected').val());//borra la opcion seleccionada
    });

}

function cuad_asignada(select,etiqueta, sol, id_cuadrilla, div, check,check2) {
    var id = id_cuadrilla;
    var solicitud = sol;
    $.post(base_url + "index.php/mnt_asigna_cuadrilla/mnt_asigna_cuadrilla/get_responsable", {
        id: id
    }, function (data) {
        $(etiqueta).text(data);
    });
    $.post(base_url + "index.php/mnt_responsable_orden/mnt_responsable_orden/select_responsable", {
        sol: solicitud,
        id: id
    }, function (data) {
        $(select).html(data);
         $(select).select2({placeholder: "--SELECCIONE--",allowClear: true});
    });
    $.post(base_url + "index.php/mnt_miembros_cuadrilla/mnt_miembros_cuadrilla/get_cuad_assigned", {
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
//            scrollY:        200,
             scrollCollapse: true,
             'sDom': 'tp',
             responsive: true,
            "bLengthChange": false,
            "iDisplayLength": 5
        });
        $('#ayu_assigned'+ solicitud).DataTable({
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

function ayudantes(check,select,estatus,sol, div1, div2) {
    var id = sol;
    var table1;
    var table;
    var ayu = 'ayu';
    blah: console.log(id);
    $('a[data-toggle="tab"]').on( 'shown.bs.tab', function (e) {
    $.fn.dataTable.tables( {visible: true, api: true} ).columns.adjust();
     } );
    $.post(base_url + "index.php/mnt_responsable_orden/mnt_responsable_orden/select_responsable", {
        sol: sol,
        id: ayu
    }, function (data) {
        $(select).html(data);
        $(select).select2({placeholder: "--SELECCIONE--",allowClear: true});
    }); 
    $.post(base_url + "index.php/mnt_ayudante/mnt_ayudante/mostrar_unassigned", {
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
    $.post(base_url + "index.php/mnt_ayudante/mnt_ayudante/mostrar_assigned", {
        id: id,
        estatus: estatus
    }, function (data) {
        $(div2).html(data);
        table = $('#ayudasig' + sol).DataTable({
             responsive: true,
        "oLanguage": {    
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

function load_asig_trab(select){
    $.post(base_url + "index.php/mnt_ayudante/mnt_ayudante/load_ayu_asig", {
    }, function (data) {
        $(select).html(data);
        $(select).select2({placeholder: "--SELECCIONE--",allowClear: true});
    }); 
}

function load_cuadrillas_asig(select){
    $.post(base_url + "index.php/mnt_asigna_cuadrilla/mnt_asigna_cuadrilla/show_cuad_signed", {
    }, function (data) {
        $(select).html(data);
        $(select).select2({placeholder: "--SELECCIONE--",allowClear: true});
    }); 
}

function load_respon_asig(select){
    $.post(base_url + "index.php/mnt_responsable_orden/mnt_responsable_orden/show_all_respon", {
    }, function (data) {
        $(select).html(data);
        $(select).select2({placeholder: "--SELECCIONE--",allowClear: true});
    }); 
}

//function ayudantes_tmp(sol, div1, div2) {
//    var id = sol;
//    var table;
//    $.post(base_url + "index.php/mnt_ayudante/mnt_ayudante/mostrar_assigned_2", {
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

function listar_cargo(select, div, cuadrilla) {//se usa para mostrar los ayudantes al seleccionar un responsable para crear la cuadrilla
    var nombre = select.value;
    var cuad = cuadrilla.value;
    $.post(base_url + "index.php/mnt_cuadrilla/cuadrilla/listar_ayudantes", {
        nombre: nombre,
        cuad: cuad
    }, function (data) {
        $(cuadrilla).attr('disabled', 'disabled');
        $(div).html(data);
        var table = $('#cargos').DataTable({
             responsive: true,
//             "ordering": false,
//            searching: false,
            "pagingType": "full_numbers",
            "bLengthChange": false,
            "iDisplayLength": 5
        });
//        table.columns.adjust();
        $("#file-3").fileinput({
            url: (base_url + 'index.php/mnt_cuadrilla/cuadrilla/crear_cuadrilla'),
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
    $.post(base_url + "index.php/mnt_miembros_cuadrilla/mnt_miembros_cuadrilla/list_miembros", {
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
            url: (base_url + 'index.php/mnt_cuadrilla/cuadrilla/crear_cuadrilla'),
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

///////por luigi: mensajes de alerta para solicitudes aprobadas
$(document).ready(function () {

    /* Auto notification */
    setTimeout(function() {
        $.ajax({
                // url: base_url + "index.php/alm_solicitudes/alm_solicitudes/check_aprovedDepSol",
                url: base_url + "index.php/template/template/check_alerts",
                type: 'POST',
                success: function (data) {
                        console.log(data);
                        var response = $.parseJSON(data);
                        //response es una variable traida del json en el controlador linea:19 del archivo: modules/template/controllers/template.php.
                        //se utiliza para que de acuerdo con el objeto que trae, llama a la alerta correspondiente para avisar sobre el asunto que requiera atencion.
                        //para desreferenciar y consultar los atributos del objeto que trae response, es a travez del nombre que recibio el "key" del arreglo en template.php
                        //y la casilla numerica; en caso de ser varias, se debe hacer un loop, que recorra la primera referencia, ejemplo: response[key del array][numero de 0 a n].AtributoDeLaTablaSql
                        //ejemplos para ejecucion.
                        console.log('arreglo del response= '+response);
                        console.log('objeto "key" del array= '+response['depSol']);
                        console.log('valor del atributo de la consulta de sql= '+ response['depSol'][0].nr_solicitud);
                        var temp_id = [];//una variable de tipo arreglo, para los gritters que se desvaneceran solos
                        for (val in response)
                        {   
                            switch(true)
                            {
                                case val==='depSol' && response[val]!=0:
                                    temp_id[1] = $.gritter.add({
                                        // (string | mandatory) the heading of the notification
                                        title: 'Solicitudes',
                                        // (string | mandatory) the text inside the notification
                                        text: 'Disculpe, la solicitud <a href="inicio">'+response[val][0].nr_solicitud+'</a>// usted posee solicitudes aprobadas en su departamento',
                                        // (string | optional) the image to display on the left
                                        // image: base_url+'/assets/img/alm/Art_check.png',
                                        image: base_url+'/assets/img/alm/item_list_c_verde.png',
                                        // (bool | optional) if you want it to fade out on its own or just sit there
                                        sticky: true,
                                        // (int | optional) the time you want it to be alive for before fading out
                                        time: '',
                                        // (string | optional) the class name you want to apply to that specific message
                                        class_name: 'gritter-custom'
                                    });
                                break;
                                case val==='sol' && response[val]!=0:
                                    var unique_id = $.gritter.add({
                                        // (string | mandatory) the heading of the notification
                                        title: 'Solicitudes',
                                        // (string | mandatory) the text inside the notification
                                        text: 'Disculpe, su solicitud ya ha sido aprobada',
                                        // (string | optional) the image to display on the left
                                        // image: base_url+'/assets/img/alm/Art_check.png',
                                        image: base_url+'/assets/img/alm/item_list_c_verde.png',
                                        // (bool | optional) if you want it to fade out on its own or just sit there
                                        sticky: true,
                                        // (int | optional) the time you want it to be alive for before fading out
                                        time: '',
                                        // (string | optional) the class name you want to apply to that specific message
                                        class_name: 'gritter-custom',

                                        before_close: function(e){
                                            swal({
                                                title: "Recuerde",
                                                text: "Debe retirar los articulos en almacen para que no vuelva a aparecer este mensaje",
                                                type: "warning"
                                            });
                                            return false;
                                        }
                                    });
                                    // You can have it return a unique id, this can be used to manually remove it later using
                                    // setTimeout(function () {
                                    //     $.gritter.remove(unique_id, {
                                    //     fade: true,
                                    //     speed: 'slow'
                                    //     });
                                    // }, 10000);
                                break;
                                case val==='calificar' && response[val]!=0:
                                    var unique_id = $.gritter.add({
                                        // (string | mandatory) the heading of the notification
                                        title: 'Calificación',
                                        // (string | mandatory) the text inside the notification
                                        text: 'Disculpe, debe calificar las solicitudes de mantenimiento cerradas',
                                        // (string | optional) the image to display on the left
                                        // image: base_url+'/assets/img/alm/Art_check.png',
                                        image: base_url+'/assets/img/mnt/star1.png',
                                        // (bool | optional) if you want it to fade out on its own or just sit there
                                        sticky: true,
                                        // (int | optional) the time you want it to be alive for before fading out
                                        time: '',
                                        // (string | optional) the class name you want to apply to that specific message
                                        class_name: 'gritter-custom',

                                        before_close: function(e){
                                            swal({
                                                title: "Recuerde",
                                                text: "Debe calificar las solicitudes cerradas para que no vuelva a aparecer este mensaje",
                                                type: "warning"
                                            });
                                            return false;
                                        }
                                    });
                                break;
                                default:

                                console.log("nope");
                                break;
                            }
                        };

                        // You can have it return a unique id, this can be used to manually remove it later using
                        setTimeout(function () {//para cerrar las alertas provicionales
                            for (var i = temp_id.length - 1; i >= 0; i--)
                            {
                                $.gritter.remove(temp_id[i], {
                                fade: true,
                                speed: 'slow'
                                });
                            };
                        }, 10000);
                        
                    }
        });
    }, 1);

});