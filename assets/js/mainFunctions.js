$(document).ready(function(){

   // jQuery methods go here...
   $( "#usuarios" ).autocomplete({
      maxLenght: 2,
      source: function( request, response ) {
      $.ajax({
          url: "<?php echo base_url() ?>index.php/user/usuario/ajax_likeUsers",
          type: 'POST',
          dataType: "json",
          data: $('#search_autocomplete').serialize(),
          success: function( data ) {
            console.log(data);
            console.log($('#usuarios').val());
              response( $.map( data, function( item ) {
                  return {
                      label: item.title,
                      value: item.name
                  }
              }));
          }
      });

	}
});
});