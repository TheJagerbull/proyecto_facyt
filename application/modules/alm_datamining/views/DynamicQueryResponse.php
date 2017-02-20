<!--https://datatables.net/forums/discussion/29260/dynamic-column-headers-via-ajax -->
<script src="<?php echo base_url() ?>assets/js/jquery.min.js"></script>
<script type="text/javascript">
 base_url = '<?php echo base_url()?>';
  $( document ).ready( function( $ ) {
      // $.ajax({
      //     "url": base_url+'alm_datamining/DQR',
      //     "dataType": "json",
      //     "success": function(json) {
      //         var tableHeaders='';
      //         $.each(json.columns, function(i, val){
      //             tableHeaders += "<th>" + val + "</th>";
      //         });
      //          console.log(tableHeaders);
      //         $("#tableDiv").empty();
      //         $("#tableDiv").append('<table id="displayTable" class="table table-hover table-bordered col-lg-8 col-md-8 col-sm-8"><thead><tr>' + tableHeaders + '</tr></thead></table>');
      //         // $("#tableDiv").find("table thead tr").append(tableHeaders);
      //         $('#displayTable').DataTable(json);
      //     }
      // });
      $("input[name='query'").on('submit change', function(){
        // console.log($("input[name='query'").val());
        $.post(base_url+'alm_datamining/query_normalization', {query: $("input[name='query'").val()}, function(data){
          newquery = data;
          console.log(newquery);
        });
      });
        
  });
</script>
<div class="mainy">
  <!-- Page title -->
  <div class="page-title">
    <h2 align="right"><i class="fa fa-inbox color"></i> Pruebas <small>para consultas dinamicas</small></h2>
    <hr />
  </div>
   <!-- Page title -->
    <div class="awidget full-width">
      <div class="awidget-head">
        <h2>Tabla de columnas dinamicas</h2>
      </div>
      <div class="awidget-body">
<!-- tabla de columnas dinamicas -->
        <div class="controls-row">
          <div class="control-group">
            <div class="input-group">
                <span class="input-group-addon btn btn-info">
                    <i class="fa fa-zoom"></i>
                </span>
                <input class="form-control input-sm" style="width: 20%" name="query" placeholder="el query" type="text">
            </div>
            <hr>
          </div>
        </div>
        <div id='tableDiv'>
        </div>
<!-- fin de tabla de columnas dinamicas -->
      </div>
    </div>
</div>