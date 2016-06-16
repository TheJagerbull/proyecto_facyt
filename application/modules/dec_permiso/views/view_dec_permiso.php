<script src="<?php echo base_url() ?>assets/js/jquery.min.js"></script>
<script type="text/javascript">
    base_url = '<?php echo base_url() ?>';
    $(document).ready(function () {
        var table = $('#usuarios').DataTable({
                    "language": {
                        "url": "<?php echo base_url() ?>assets/js/lenguaje_datatable/spanish.json"
                    },
                    "bProcessing": true,
                     stateSave: true,
                    "bDeferRender": true,
                    "serverSide": true, //Feature control DataTables' server-side processing mode.
                    "pagingType": "full_numbers", //se usa para la paginacion completa de la tabla
                    "sDom": '<"row"<"col-sm-6"l><"col-sm-6"f>>rt<"row"<"col-sm-4"i><"col-sm-8"p>>', //para mostrar las opciones donde p=paginacion,l=campos a mostrar,i=informacion
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
                <div class="table-responsive">
                    <div class="controls-row">
                        <div class="control-group col col-lg-3 col-md-3 col-sm-3"></div>
                        <div class="control-group col col-lg-3 col-md-3 col-sm-3">
                        </div>
                        <div class="control-group col col-lg-3 col-md-3 col-sm-3">
                        </div>
                        <div class="control-group col col-lg-3 col-md-3 col-sm-3">
                            <button class="btn btn-warning btn-sm pull-right" id="Ayuda" type="submit" title="Ayuda de lista"><i class="fa fa-question-circle fa-2x"></i></button>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <table id="usuarios" class="table table-hover table-bordered table-condensed" align="center" width="100%">
                            <thead>
                                <tr>
                                    <th>Usuario</th>
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
</div>
<script type="text/javascript">
    $("#Ayuda").on('click', function (e)
    {
        swal({
            title: "Listado de usuarios",
            text: "- En la lista solo aparecen usuarios activos y con roles en sistema. \n - Para asignar los permisos, debe hacer click en el botón \"Permisos\", y este lo llevara a una interfaz personal del usuario.\n",
            imageUrl: base_url+"assets/img/info.png"
            // type: "warning"
        });
        return false;
    });
</script>
 