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
   $(document).ready(function () {
        $("#dependencia_select").change(function () {
            $("#dependencia_select option:selected").each(function () {
                departamento = $('#dependencia_select').val();
                $.post("base_url+index.php/mnt_solicitudes/orden/select_oficina", {
                    departamento: departamento
                }, function (data) {
                    $("#oficina_select").html(data);
                });
            });
        })
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
