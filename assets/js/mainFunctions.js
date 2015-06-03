$(document).ready(function(){

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

$( "#spinner" ).spinner();

	var min = 2;

////autocompletado de usuarios
$( "#autocomplete" ).autocomplete({
	minLenght: min,
	source: function(request, response){
	$.ajax({
		// request: $('#ACquery'),
		// blah: console.log(request),
		url: base_url+"index.php/user/usuario/ajax_likeUsers",
		type: 'POST',
		dataType: "json",
		data: $('#ACquery').serialize(),
		success: function( data ) {
			// console.log("hello");
			response( $.map( data, function( item ) {
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
$( "#autocompleteArt" ).autocomplete({
	minLenght: min,
	source: function(request, response){
	$.ajax({
		// request: $('#ACquery'),
		// blah: console.log(request),
		url: base_url+"index.php/alm_articulos/alm_articulos/ajax_likeArticulos",
		type: 'POST',
		dataType: "json",
		data: $('#ACquery2').serialize(),
		success: function( data ) {
			// console.log("hello");
			response( $.map( data, function( item ) {
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
$( "#autocompleteMant" ).autocomplete({
	minLenght: min,
	source: function(request, response){
	$.ajax({
		// request: $('#ACquery'),
		// blah: console.log(request),
		url: base_url+"index.php/mnt_solicitudes/mnt_solicitudes/ajax_likeSols",
		type: 'POST',
		dataType: "json",
		data: $('#ACquery3').serialize(),
		success: function( data ) {
			// console.log("hello");
			response( $.map( data, function( item ) {
	            return {
	                label: item.title,
	                value: [item.id_orden, item.dependen,item.descripcion,item.cuadrilla]

	            }
	        }));
		}
	})	
	}
});


//Autocompletado para cuadrillas
$( "#autocomplete_cuadrilla" ).autocomplete({
	minLenght: min,
	source: function(request, response){
	$.ajax({
		url: base_url+"index.php/mnt_cuadrilla/cuadrilla/ajax_likeSols",
		type: 'POST',
		dataType: "json",
		data: $('#ACquery4').serialize(),
		success: function( data ) {
			response( $.map( data, function( item ) {
	            return {
	                label: item.title,
	                value: [item.id, item.cuadrilla]
	            }
	        }));
		}
	})	
	}
});


//permite llenar el select oficina cuando tomas la dependencia en modulos mnt_solicitudes
    $("#dependencia_select").change(function () {
        $("#dependencia_select option:selected").each(function () {
            departamento = $('#dependencia_select').val();
            $.post(base_url + "index.php/mnt_solicitudes/orden/select_oficina", {
                departamento: departamento
            }, function (data) {
                $("#oficina_select").html(data);
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
            $(cuentacampo).text($var+ "/" +limite) ; //en caso de usar con etiquetas
            //cuentacampo.value= ($var+ "/" +limite) ; //en caso de usar con inputs
            
            
      
    }
