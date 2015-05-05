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
