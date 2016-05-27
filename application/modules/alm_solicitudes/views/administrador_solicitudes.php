<script src="<?php echo base_url() ?>assets/js/jquery.min.js"></script>
<script type="text/javascript">
  base_url = '<?php echo base_url()?>';
  
  $(document).ready(function()
  {
    $('#data').dataTable({
      "bProcessing": true,
            "bServerSide": true,
            "sServerMethod": "GET",
            "sAjaxSource": "alm_solicitudes/build_tables/admin",
            "iDisplayLength": 10,
            "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "aaSorting": [[0, 'asc']],
            "aoColumns": [
        { "bVisible": true, "bSearchable": true, "bSortable": true },
        { "bVisible": true, "bSearchable": true, "bSortable": true },
        { "bVisible": true, "bSearchable": true, "bSortable": true },
        { "bVisible": true, "bSearchable": false, "bSortable": true },
        { "bVisible": true, "bSearchable": false, "bSortable": true },
        { "bVisible": true, "bSearchable": false, "bSortable": true },
        { "bVisible": true, "bSearchable": true, "bSortable": false }//la columna extra
            ]
    })
  });
  
</script>
<?php $aux = $this->session->userdata('query');
      $aux2 = $this->session->userdata('range');
?>
            <div class="mainy">
              <!-- Page title -->
              <div class="page-title">
                <h2 align="right"><i class="fa fa-inbox color"></i> Solicitudes <small>de almacen</small></h2>
                <hr />
              </div>
               <!-- Page title -->
               
                <div class="row">
                  <table id="data" class="table table-hover table-bordered col-lg-8 col-md-8 col-sm-8">
                      <thead>
                          <tr>
                              <th>Solicitud</th>
                              <th>Fecha generada</th>
                              <th>Generada por:</th>
                              <th>Revisada por:</th>
                              <th>Estado actual</th>
                              <th>Detalles</th>
                              <th>Acciones</th>
                          </tr>
                      </thead>
                      <tbody></tbody>
                      <tfoot></tfoot>
                  </table>
                </div>
            </div>