<script src="<?php echo base_url() ?>assets/js/jquery.min.js"></script>
<script type="text/javascript">
  base_url = '<?php echo base_url()?>';
  
  $(document).ready(function()
  {

    var adminTable = $('#admin').DataTable({
      "language": {
          "url": "<?php echo base_url() ?>assets/js/lenguaje_datatable/spanish.json"
      },
      "bProcessing": true,
            "bServerSide": true,
            "sServerMethod": "GET",
            "sAjaxSource": "alm_solicitudes/build_tables/admin",
            "bDeferRender": true,
            "fnServerData": function (sSource, aoData, fnCallback, oSettings){
                aoData.push({"name":"fecha", "value": $('#fecha').val()});//para pasar datos a la funcion que construye la tabla
                oSettings.JqXHR = $.ajax({
                  "dataType": "json",
                  "type": "GET",
                  "url": sSource,
                  "data": aoData,
                  "success": fnCallback
                });
            },
            "iDisplayLength": 10,
            "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "aaSorting": [[0, 'asc']],
            "aoColumns": [
        { "bVisible": true, "bSearchable": true, "bSortable": true },
        { "bVisible": true, "bSearchable": true, "bSortable": true },
        { "bVisible": true, "bSearchable": true, "bSortable": true },
        { "bVisible": true, "bSearchable": true, "bSortable": true },
        { "bVisible": true, "bSearchable": false, "bSortable": true },
        { "bVisible": true, "bSearchable": false, "bSortable": false },
        { "bVisible": true, "bSearchable": false, "bSortable": false }//la columna extra
            ]
    });
    $('#fecha').change(function(){adminTable.ajax.reload();});
    
      //script
        $("input[type='numb']").keyup(function(){
          console.log(this.val());
        });
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
               <div class="awidget full-width">
                  <div class="awidget-head">
                    <h2>Solicitudes recibidas</h2>
                  </div>
                  <div class="awidget-body">
                    <div class="controls-row">
                      <div class="control-group">
                        <div class="input-group">
                            <span class="input-group-addon btn btn-info">
                                <i class="fa fa-calendar"></i>
                            </span>
                            <input class="form-control input-sm" style="width: 20%" name="fecha" id="fecha" readonly placeholder=" Búsqueda por Fechas" type="search">
                        </div>
                        <hr>
                      </div>
                    </div>
                    <table id="admin" class="table table-hover table-bordered col-lg-8 col-md-8 col-sm-8">
                        <thead>
                            <tr>
                                <th>Solicitud</th>
                                <th>Fecha generada</th>
                                <th>Generada por:</th>
                                <th>Departamento</th>
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
            </div>