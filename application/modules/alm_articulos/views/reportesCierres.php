<script src="<?php echo base_url() ?>assets/js/jquery.min.js"></script>
<div class="mainy">
	
  <!-- Page title -->
  <div class="page-title">
    <!-- <h2 align="right"><i class="fa fa-file color"></i> Articulos <small>de almacen</small></h2> -->
    <h2 align="right"><img src="<?php echo base_url() ?>assets/img/alm/history3.png" class="img-rounded" alt="bordes redondeados" width="45" height="45"> Actas <small>de inventario</small></h2>
    <hr />
  </div>
  <!-- Page title -->
	<div class="row">   
		<div class="awidget full-width">
		    <div class="awidget-head">
		          <h3>Reportes y cierres generados en el sistema</h3>
		    </div>
        <div class="awidget-body">
          <?php echo $actDeIni?>
          <hr>
          <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10" align="center" style="height: 800px">
            <iframe id='visualizador' src=""  width="100%" height="100%" frameborder="0" allowtransparency="true">
            </iframe>
          </div>
          <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2" >
            <button id="reset" hidden>Cancelar</button>
          </div>
        </div>
        <div class="awidget-footer">
          <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10" align="center">
            
          </div>
        </div>
		</div>
	</div>
</div>
<script type="text/javascript">
  
      function load(value)
      {
        console.log(value);
        $('#visualizador').attr("src", value);
        $('#visualizador').focus();
        $('#reset').attr("class", 'btn btn-danger');
        $('#reset').show();
        $('html, body').animate({
            scrollTop: $('#visualizador').offset().top
        }, 1500, "swing");
      }
  $(document).ready(function() {
    if($("#actDeIni").val()!== '')
    {
      console.log($("#actDeIni").val());
      $('#visualizador').attr("src", $("#actDeIni").val());
      $('#visualizador').focus();
      $('#reset').attr("class", 'btn btn-danger');
      $('#reset').show();
      $('html, body').animate({
          scrollTop: $('#visualizador').offset().top
      }, 1500, "swing");
    }

    $('#reset').click(function(){
      console.log('crap!');
      $("#actDeIni").prop('selectedIndex', 0);
      $('#visualizador').attr("src", '');
      $('#reset').attr("class", '');
      $('#reset').hide();
      $('html, body').animate({
          scrollTop: $('.header').offset().top
      }, 1500, "swing");
    });
  });
          // 
</script>