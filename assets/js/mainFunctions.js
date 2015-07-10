
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
////autocompletado de articulos
    $("#autocompleteArt").autocomplete({
        minLenght: min,
        source: function (request, response) {
            $.ajax({
                // request: $('#ACquery'),
                // blah: console.log(request),
                url: base_url + "index.php/alm_articulos/alm_articulos/ajax_likeArticulos",
                type: 'POST',
                dataType: "json",
                data: $('#ACquery2').serialize(),
                success: function (data) {
                    // console.log("hello");
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
        placeholder: "--SELECCIONE--", // <input select = "nombre select" class =" Le agregas clase de boostrap y luego la terminas con clase2 para activarlo" 
        allowClear: true, });

//permite llenar el select oficina cuando tomas la dependencia en modulos mnt_solicitudes

    $("#dependencia_select").change(function () {
        $("#dependencia_select option:selected").each(function () {
            var departamento = $('#dependencia_select').val();
            $.post(base_url + "index.php/mnt_solicitudes/orden/select_oficina", {
                departamento: departamento
            }, function (data) {
                $("#oficina_select").html(data);
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
                   searching: false,
//                    "bLengthChange": false,
//                    "iDisplayLength": 3
                });
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
    $.post(base_url + "index.php/mnt_asigna_cuadrilla/mnt_asigna_cuadrilla/get_responsable", {
        id: id
    }, function (data) {
        $(txt).val(data);
    });

    $.post(base_url + "index.php/mnt_asigna_cuadrilla/mnt_asigna_cuadrilla/mostrar_cuadrilla", {
        id: id,
        sol: num_sol.value
    }, function (data) {
        $(div).html(data);
        $('#miembro' + num_sol.value).DataTable({
//             "ordering": false,
//            searching: false,
            "bLengthChange": false,
            "iDisplayLength": 3
        });
    });
    $('.modal .btn-primary').prop('disabled', false);
    $('.modal').on('hidden.bs.modal', function () {
        $(this).find('form')[0].reset(); //para borrar todos los datos que tenga los input, textareas, select.
        $(div).empty();//para vaciar el div donde se guarda la tabla para evitar errores
    });

}

function cuad_asignada(etiqueta, sol, id_cuadrilla, div, check) {
    var id = id_cuadrilla;
    var solicitud = sol;
    $.post(base_url + "index.php/mnt_asigna_cuadrilla/mnt_asigna_cuadrilla/get_responsable", {
        id: id
    }, function (data) {
        $(etiqueta).text(data);
    });
    $.post(base_url + "index.php/mnt_miembros_cuadrilla/mnt_miembros_cuadrilla/get_cuad_assigned", {
        id: id,
        solicitud: solicitud
    }, function (data) {
        $(div).html(data);
        $('#cuad_assigned' + solicitud).DataTable({
            "bLengthChange": false,
            "iDisplayLength": 3
        });
        $('.modal .btn-primary').prop('disabled', true);// para deshabilitar el boton de guardar cambios con la finalidad de usar el checkbox...
        $(check).change(function () {//se verifica con el id del checkbox para habilitar el boton de guardar en el modal
            $('.modal .btn-primary').prop('disabled', !this.checked);
        });
        $('.modal').on('hidden.bs.modal', function () {
            $(this).find('form')[0].reset(); //para borrar todos los datos que tenga los input, textareas, select.
            $(div).empty();//para vaciar el div donde se guarda la tabla para evitar errores
        });

    });
}

function ayudantes(sol, div1, div2) {
    var id = sol;
    blah: console.log(id);
    $.post(base_url + "index.php/mnt_ayudante/mnt_ayudante/mostrar_unassigned", {
        id: id
    }, function (data) {
        $(div1).html(data);
        // console.log('#ayudantes'+sol);
        $('#ayudisp' + sol).DataTable({
            "bLengthChange": false,
            "iDisplayLength": 4
        });

    });
    $.post(base_url + "index.php/mnt_ayudante/mnt_ayudante/mostrar_assigned", {
        id: id
    }, function (data) {
        $(div2).html(data);
        $('#ayudasig' + sol).DataTable({
            "bLengthChange": false,
            "iDisplayLength": 4
        });

    });
    $('.modal .btn-primary').prop('disabled', false);
}

$(document).on("click", ".open-Modal", function () {
    var dato = $(this).data('id');
    var dato2 = $(this).data('tipo_sol');
    var dato3 = $(this).data('asunto');
    $(".modal-body #data").text(dato);
    $(".modal-body #num_sol").val(dato);
    $(".modal-body #tipo").text(dato2);
    $(".modal-body #asunto").text(dato3);

});

function estados_orden(estatus,select){
    var id = estatus;
    var sel =
    $.post(base_url + "index.php/",
}
