<script src="<?php echo base_url() ?>assets/js/jquery.min.js"></script>
<script type="text/javascript">
    base_url = '<?= base_url() ?>';
    $(document).ready(function () {
        var table = $('#usuarios').DataTable({
//                    "bProcessing": true,
//                    "bDeferRender": true,
//                    "serverSide": true, //Feature control DataTables' server-side processing mode.
                    "pagingType": "full_numbers", //se usa para la paginacion completa de la tabla
                    "sDom": '<"top"lp<"clear">>rt<"bottom"ip<"clear">>', //para mostrar las opciones donde p=paginacion,l=campos a mostrar,i=informacion
                    "order": [[0, "desc"]] //para establecer la columna a ordenar por defecto y el orden en que se quiere 
//                    "ajax": {
//                        "url": "<?php echo site_url('mnt_solicitudes/mnt_solicitudes/list_sol/') ?>",
//                        "type": "GET",
//                            }
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
                                <th valign="middle"><div align="center">Acción</div></th>
                                <th><div align="center">Nombre</div></th>
                                <th><div align="center">Rol en el sistema</div></th>
                            </tr>
                        </thead>
                        <tbody>
   
                        </tbody>
                    </table>
                </div>
        
            </div>
        </div>
</div>    
 