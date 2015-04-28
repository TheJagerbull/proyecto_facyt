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
$( "#autocomplete" ).autocomplete({
	maxLenght: 2,
	source: availableTags
});
   // jQuery methods go here...
   $("#swSearch").autocomplete({
 	minLength: 1,
 		source: function(req, add){
 		$.ajax({
 			url: '<?php echo base_url() ?>index.php/user/usuario/buscar_usuario', //Controller where search is performed
 			dataType: 'json',
 			type: 'POST',
 			data: req,
 			success: function(data){
 				if(data.response =='true'){
 				   add(data.message);
 				}
 			}
 		});
 		}
	});
});
