<script type="text/javascript">
  base_url = '<?php echo base_url()?>';
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
               
                <div class="row">
                  <table id="dep_sol" class="table table-hover table-bordered col-lg-8 col-md-8 col-sm-8">
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