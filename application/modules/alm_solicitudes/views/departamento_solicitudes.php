<script src="<?php echo base_url() ?>assets/js/jquery.min.js"></script>
<script type="text/javascript">
  base_url = '<?php echo base_url()?>';
  $(document).ready(function()
  {

    $('#dep').dataTable({
      "language": {
          "url": "<?php echo base_url() ?>assets/js/lenguaje_datatable/spanish.json"
      },
      "bProcessing": true,
      "lengthChange": false,
      "info": false,
            "bServerSide": true,
            "sServerMethod": "GET",
            "sAjaxSource": "<?php echo base_url() ?>tablas/solicitudes/dep",
            "bDeferRender": true,
            "fnServerParams": function (data){
              data.push({"name":"data", "value": "the_value"}, {"name":"data2", "value": "the_2ndvalue"});

            },
            "iDisplayLength": 10,
            "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "aaSorting": [[0, 'desc']],
            "aoColumns": [
        { "bVisible": true, "bSearchable": true, "bSortable": true },
        { "bVisible": true, "bSearchable": true, "bSortable": true },
        { "bVisible": true, "bSearchable": true, "bSortable": true },
        { "bVisible": true, "bSearchable": false, "bSortable": true },
        { "bVisible": true, "bSearchable": false, "bSortable": false },
        { "bVisible": true, "bSearchable": false, "bSortable": false }//la columna extra
            ]
    }),

    $('#por_enviar').dataTable({
      "language": {
          "url": "<?php echo base_url() ?>assets/js/lenguaje_datatable/spanish.json"
      },
      "bProcessing": true,
      "lengthChange": false,
      "info": false,
            "bServerSide": true,
            "sServerMethod": "GET",
            "sAjaxSource": "<?php echo base_url() ?>tablas/solicitudes_carrito/dep",
            "bDeferRender": true,
            "fnServerParams": function (data){
              data.push({"name":"data", "value": "the_value"}, {"name":"data2", "value": "the_2ndvalue"});

            },
            "iDisplayLength": 10,
            "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "aaSorting": [[0, 'asc']],
            "aoColumns": [
        { "bVisible": true, "bSearchable": false, "bSortable": false },
        { "bVisible": true, "bSearchable": true, "bSortable": true },
        { "bVisible": true, "bSearchable": true, "bSortable": true },
        { "bVisible": true, "bSearchable": true, "bSortable": false },
        { "bVisible": true, "bSearchable": false, "bSortable": false },
        { "bVisible": true, "bSearchable": false, "bSortable": false }//la columna extra
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
                <h2 align="right"><i class="fa fa-inbox color"></i> Solicitudes <small>del departamento</small></h2>
                <hr />
              </div>
               <!-- Page title -->
               
                <div class="awidget full-width">
                  <div class="awidget-head">
                    <h2>Solicitudes en Proceso</h2>
                  </div>
                  <div class="awidget-body">
                  <!-- <div class="row"> -->
                    <table id="dep" class="table table-hover table-bordered col-lg-8 col-md-8 col-sm-8">
                        <thead>
                            <tr>
                                <th><div align="center">Solicitud</div></th>
                                <th><div align="center">Fecha</div></th>
                                <th>Usuario</th>
                                <th><div align="center">Estatus</div></th>
                                <th><div align="center">Detalles</div></th>
                                <th><div align="center">Acciones</div></th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                        <tfoot></tfoot>
                    </table>
                  <!-- </div> -->
                  </div>
                </div>
                <div class="awidget full-width">
                  <div class="awidget-head">
                    <h2>Solicitudes sin enviar</h2>
                  </div>
                  <div class="awidget-body">
                  <!-- <div class="row"> -->
                    <table id="por_enviar" class="table table-hover table-bordered col-lg-8 col-md-8 col-sm-8">
                        <thead>
                            <tr>
                                <th><div align="center">Solicitud</div></th>
                                <th><div align="center">Fecha</div></th>
                                <th>Usuario</th>
                                <th><div align="center">Observacion</div></th>
                                <th><div align="center">Detalles</div></th>
                                <th><div align="center">Acciones</div></th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                        <tfoot></tfoot>
                    </table>
                  <!-- </div> -->
                </div>
              </div>
            </div>