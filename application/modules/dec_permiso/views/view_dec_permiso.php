<script src="<?php echo base_url() ?>assets/js/jquery.min.js"></script>
<script type="text/javascript">
    base_url = '<?= base_url() ?>';
    $(document).ready(function () {
        var table = $('#usuarios').DataTable({
                    "bProcessing": true,
                     stateSave: true,
                    "bDeferRender": true,
                    "serverSide": true, //Feature control DataTables' server-side processing mode.
                    "pagingType": "full_numbers", //se usa para la paginacion completa de la tabla
                    "sDom": '<"top"lf<"clear">>rt<"bottom"ip<"clear">>', //para mostrar las opciones donde p=paginacion,l=campos a mostrar,i=informacion
                    "order": [[0, "asc"]], //para establecer la columna a ordenar por defecto y el orden en que se quiere 
                    "aoColumnDefs": [{"orderable": false, "targets": [-1]}],//para desactivar el ordenamiento en esas columnas
                    "ajax": {
                        "url": "<?php echo site_url('dec_permiso/dec_permiso/list_user') ?>",
                        "type": "GET"
                            },
                     "columns": [                                   
                                    { "data": "nombre" },
                                    { "data": "cargo" },
                                    { "data": "dependencia" },
                                    { "data": "id" }
                                ]
                    });
                   
    });     
</script>
<!-- Page content -->

<div class="mainy">
<!-- Page title --> 
    <div class="page-title">
        <h2 align="right"><i class="fa fa-users color"></i> Control de acceso <small>Seleccione para asignar  </small></h2>
        <hr />
    </div>
    <?php if($this->session->flashdata('set_permission') == 'error') : ?>
      <div class="alert alert-danger" style="text-align: center">Ocurrió un problema asignando permisos al usuario</div>
    <?php endif ?>
    <?php if($this->session->flashdata('set_permission') == 'success') : ?>
      <div class="alert alert-success" style="text-align: center">Permiso asignado exitósamente</div>
    <?php endif ?>
    <!-- Page title -->
    <!--<div class="row">-->
        <div class="panel panel-default">
            <div class="panel-heading"><label class="control-label">Listado de Usuarios</label>
           
            </div>
            <div class="panel-body">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <table id="usuarios" class="table table-hover table-bordered table-condensed" align="center" width="100%">
                        <thead>
                            <tr>
                                <th>Trabajador</th>
                                <th>Cargo</th>
                                <th>Dependencia</th>
                                <th valign="middle"><div align="center">Asignar</div></th>
                            </tr>
                        </thead>
                        <tbody>
   
                        </tbody>
                    </table>
                </div>
        
            </div>
        </div>
</div>    
 