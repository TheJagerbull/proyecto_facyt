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
            <div class="panel-heading">
                <label class="control-label">Listado de Usuarios</label>
                <button class="btn btn-warning pull-right" id="Ayuda" type="submit" title="Ayuda de lista"><i class="fa fa-question fa-fw"></i></button>
            </div>
            <div class="panel-body">
                <button id="UsrXPermit" class="btn btn-info btn-xs" style="vertical-align: 80%;">Listar usuarios por permiso</button>
                <div class="table-responsive">
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
                            <tbody></tbody>
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
            text: "- En la lista solo aparecen usuarios activos y con roles en sistema. \n - Para asignar los permisos, debe hacer click en el botón \"Permisos\", y este lo llevará a una interfaz personal del usuario.\n",
            imageUrl: base_url+"assets/img/info.png"
            // type: "warning"
        });
        return false;
    });
    $("#UsrXPermit").on('click', function(e)
    {
        var permitUI = '<div class="panel-body">';
            permitUI +='<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">';
            permitUI +='<div class="panel panel-default">';
            permitUI +='            <div class="panel-heading" role="tab" id="headingOne">';
            permitUI +='                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">';
            permitUI +='                    <h3 class="panel-title">';
            permitUI +='                        <img src="http://localhost/proyecto_facyt/assets/img/alm/main.png" class="img-responsive pull-left" alt="bordes redondeados" style="margin-right: 10px;" width="20" height="20"><span class="negritas permisos-nombre-grande">Almacén</span>';
            permitUI +='                    </h3>';
            permitUI +='                </a>                            ';
            permitUI +='            </div>';
            permitUI +='            <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne" style="height: 114px;">';
            permitUI +='                <ul id="myTab2" class="nav nav-tabs" role="tablist">';
            permitUI +='                    <li class="active"><a href="#tab-table1" data-toggle="tab">Crear/Insertar</a></li>';
            permitUI +='                    <li><a href="#tab-table2" data-toggle="tab">Consultar</a></li>';
            permitUI +='                    <li><a href="#tab-table3" data-toggle="tab">Editar</a></li>';
            permitUI +='                </ul>';
            permitUI +='                <div class="tab-content">';
            permitUI +='                    <div class="tab-pane active" id="tab-table1">';
            permitUI +='                                                        <div class="table-responsive">';
            permitUI +='                        <table id="test" class="table table-bordered table-condensed" width="100%" align="center">';
            permitUI +='                            <thead>';
            permitUI +='                                <tr class="active">';
            permitUI +='                                    <th valign="middle"><div align="center">Artículo</div></th>';
            permitUI +='                                    <th valign="middle"><div align="center">Solicitud</div></th>';
            permitUI +='                                    <th valign="middle"><div align="center">Inventario por archivo</div></th>';
            permitUI +='                                    <th valign="middle"><div align="center">Cierre Inventario</div></th>';
            permitUI +='                                </tr>';
            permitUI +='                            </thead>';
            permitUI +='                            <tbody align="center">';
            permitUI +='                                <tr><td><input class="alm_crea" name="alm[6]" id="agregar1" value="1" type="checkbox"></td>';
            permitUI +='                                <td><input class="alm_crea" name="alm[9]" id="agregar4" value="1" type="checkbox"></td>';
            permitUI +='                                <td><input class="alm_crea" name="alm[7]" id="agregar2" value="1" type="checkbox"></td>';
            permitUI +='                                <td><input class="alm_crea" name="alm[8]" id="agregar3" value="1" type="checkbox"></td>';
            permitUI +='                            </tr></tbody>';
            permitUI +='                        </table>';
            permitUI +='                                                        </div>';
            permitUI +='                    </div>';
            permitUI +='                    <div class="tab-pane" id="tab-table2">';
            permitUI +='                                                        <div class="table-responsive">';
            permitUI +='                        <table id="test" class="table table-hover table-bordered table-condensed" width="100%" align="center">';
            permitUI +='                            <thead>';
            permitUI +='                                <tr class="active">';
            permitUI +='                                    <th valign="middle"><div align="center">Catálogo</div></th>';
            permitUI +='                                    <th valign="middle"><div align="center">Solicitudes en almacén</div></th>';
            permitUI +='                                    <th valign="middle"><div align="center">Solicitudes por departamento</div></th>';
            permitUI +='                                    <th valign="middle"><div align="center">Inventario</div></th>';
            permitUI +='                                    <th valign="middle"><div align="center">Historial / Reportes </div></th>';
            permitUI +='                                </tr>';
            permitUI +='                            </thead>';
            permitUI +='                            <tbody align="center">';
            permitUI +='                                <tr><td><input class="alm_consul" name="alm[1]" id="consultar1" value="1" type="checkbox"></td>';
            permitUI +='                                <td><input class="alm_consul" name="alm[2]" id="consultar2" value="1" type="checkbox"></td>';
            permitUI +='                                <td><input class="alm_consul" name="alm[3]" id="consultar3" value="1" type="checkbox"></td>';
            permitUI +='                                <td><input class="alm_consul" name="alm[4]" id="consultar4" value="1" type="checkbox"></td>';
            permitUI +='                                <td><input class="alm_consul" name="alm[5]" id="consultar5" value="1" type="checkbox"></td>';
            permitUI +='                            </tr></tbody>';
            permitUI +='                        </table>';
            permitUI +='                                                        </div>';
            permitUI +='                    </div>';
            permitUI +='                    <div class="tab-pane" id="tab-table3">';
            permitUI +='                                                        <div class="table-responsive">';
            permitUI +='                        <table class="table table-hover table-bordered table-condensed" width="100%" align="center">';
            permitUI +='                            <thead>';
            permitUI +='                                <tr class="active">';
            permitUI +='                                    <th valign="middle"><div align="center">Anular solicitud</div></th>';
            permitUI +='                                    <th valign="middle"><div align="center">Aprobar solicitud</div></th>';
            permitUI +='                                    <th valign="middle"><div align="center">Artículo</div></th>';
            permitUI +='                                                                                    <th valign="middle"><div align="center">Retirar artículo</div></th>';
            permitUI +='                                    <th valign="middle"><div align="center">Cancelar solicitud</div></th>';
            permitUI +='                                    <th valign="middle"><div align="center">Despachar solicitud</div></th>';
            permitUI +='                                    <th valign="middle"><div align="center">Enviar solicitud</div></th>';
            permitUI +='                                    <th valign="middle"><div align="center">Solicitud</div></th>';
            permitUI +='                                </tr>';
            permitUI +='                            </thead>';
            permitUI +='                            <tbody align="center">';
            permitUI +='                                <tr><td><input class="alm_edit" name="alm[15]" id="editar6" value="1" type="checkbox"></td>';
            permitUI +='                                <td><input class="alm_edit" name="alm[12]" id="editar4" value="1" type="checkbox"></td>';
            permitUI +='                                <td><input class="alm_edit" name="alm[10]" id="editar1" value="1" type="checkbox"></td>';
            permitUI +='                                                                            <td><input class="alm_edit" name="alm[17]" id="editar8" value="1" type="checkbox"></td>';
            permitUI +='                                <td><input class="alm_edit" name="alm[16]" id="editar7" value="1" type="checkbox"></td>';
            permitUI +='                                <td><input class="alm_edit" name="alm[13]" id="editar5" value="1" type="checkbox"></td>';
            permitUI +='                                <td><input class="alm_edit" name="alm[14]" id="editar3" value="1" type="checkbox"></td>';
            permitUI +='                                <td><input class="alm_edit" name="alm[11]" id="editar2" value="1" type="checkbox"></td>';
            permitUI +='';
            permitUI +='                            </tr></tbody>';
            permitUI +='                        </table>';
            permitUI +='                                                        </div>';
            permitUI +='                    </div>';
            permitUI +='                            </div>';
            permitUI +='                        </div>';
            permitUI +='                    </div>';
            permitUI +='                </div>';
            permitUI +='                <!-- 1. PERMISOS DE ALAMACÉN -->';
            permitUI +='                <!-- 2. PERMISOS DE MANTENIMIENTO -->';
            permitUI +='                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">';
            permitUI +='                    <div class="panel panel-default">';
            permitUI +='                        <div class="panel-heading" role="tab" id="headingOne">';
            permitUI +='                            <a class="negritas permisos-nombre-grande" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">';
            permitUI +='                                <h3 class="panel-title">';
            permitUI +='                                    <i class="fa fa-wrench fa-fw" style="margin-right: 10px;"></i><span class="negritas permisos-nombre-grande">Mantenimiento</span>';
            permitUI +='                                </h3>';
            permitUI +='                            </a>';
            permitUI +='                        </div>';
            permitUI +='                        <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne" style="height: 132px;">';
            permitUI +='                            <ul id="myTab3" class="nav nav-tabs" role="tablist">';
            permitUI +='                                <li class="active"><a href="#tab-table6" data-toggle="tab">Crear/Insertar</a></li>';
            permitUI +='                                <li><a href="#tab-table7" data-toggle="tab">Consultar</a></li>';
            permitUI +='                                <li><a href="#tab-table8" data-toggle="tab">Editar</a></li>';
            permitUI +='                                <li><a href="#tab-table9" data-toggle="tab">Eliminar</a></li>';
            permitUI +='                            </ul>';
            permitUI +='                            <div class="tab-content">';
            permitUI +='                                <div class="tab-pane active" id="tab-table6"><!--Crear-->';
            permitUI +='                                    <div class="table-responsive">';
            permitUI +='                                        <table id="test" class="table table-bordered table-condensed" width="100%" align="center">';
            permitUI +='                                            <thead>';
            permitUI +='                                                <tr class="active">';
            permitUI +='                                                    <th valign="middle"><div align="center">Solicitudes</div></th>';
            permitUI +='                                                    <th valign="middle"><div align="center">Sol. por departamento</div></th>';
            permitUI +='                                                    <th valign="middle"><div align="center">Cuadrilla</div></th>';
            permitUI +='                                                    <th valign="middle"><div align="center">Ubicación</div></th>';
            permitUI +='                                                    <th valign="middle"><div align="center">Asignar personal</div></th>';
            permitUI +='                                                    <th valign="middle"><div align="center">Agregar miembros de cuadrilla</div></th>';
            permitUI +='                                                    <th valign="middle"><div align="center">Calificar solicitudes</div></th>';
            permitUI +='                                                    <th valign="middle"><div align="center">Observaciones</div></th>';
            permitUI +='                                                </tr>                      ';
            permitUI +='                                            </thead>';
            permitUI +='                                            <tbody align="center">';
            permitUI +='                                                <tr><td><input class="mnt_crea" name="mnt[1]" id="mnt_crear1" value="1" type="checkbox"></td>';
            permitUI +='                                                <td><input class="mnt_crea" name="mnt[2]" id="mnt_crear2" value="1" type="checkbox"></td>';
            permitUI +='                                                <td><input class="mnt_crea" name="mnt[3]" id="mnt_crear2" value="1" type="checkbox"></td>';
            permitUI +='                                                <td><input class="mnt_crea" name="mnt[4]" id="mnt_crear4" value="1" type="checkbox"></td>';
            permitUI +='                                                <td><input class="mnt_crea" name="mnt[5]" id="mnt_crear5" value="1" type="checkbox"></td>';
            permitUI +='                                                <td><input class="mnt_crea" name="mnt[6]" id="mnt_crear6" value="1" type="checkbox"></td>';
            permitUI +='                                                <td><input class="mnt_crea" name="mnt[7]" id="mnt_crear7" value="1" type="checkbox"></td>';
            permitUI +='                                                <td><input class="mnt_crea" name="mnt[8]" id="mnt_crear8" value="1" type="checkbox"></td>';
            permitUI +='                                            </tr></tbody>';
            permitUI +='                                        </table>';
            permitUI +='                                    </div>';
            permitUI +='                                </div>';
            permitUI +='                                <div class="tab-pane" id="tab-table7"><!--<i class="fa fa-search fa-lg"></i> Consultar-->';
            permitUI +='                                    <div class="table-responsive">';
            permitUI +='                                        <table class="table table-hover table-bordered table-condensed" width="100%">';
            permitUI +='                                            <thead>';
            permitUI +='                                                <tr>';
            permitUI +='                                                    <th colspan="9" class="active" valign="middle"><div align="center">Solicitudes</div></th>';
            permitUI +='                                                </tr>';
            permitUI +='                                                <tr>';
            permitUI +='                                                    <th valign="middle"><div align="center">Todas Depend.</div></th>';
            permitUI +='                                                    <th valign="middle"><div align="center">Estatus</div></th>';
            permitUI +='                                                    <th valign="middle"><div align="center">En Proceso</div></th>';
            permitUI +='                                                    <th valign="middle"><div align="center">Cerradas</div></th>';
            permitUI +='                                                    <th valign="middle"><div align="center">Anuladas</div></th>';
            permitUI +='                                                    <th valign="middle"><div align="center">Detalle</div></th>';
            permitUI +='                                                    <th valign="middle"><div align="center">Asignación</div></th>';
            permitUI +='                                                    <th valign="middle"><div align="center">Reportes</div></th>';
            permitUI +='                                                </tr>';
            permitUI +='                                            </thead>';
            permitUI +='                                            <tbody align="center">';
            permitUI +='                                                <tr><td><input class="mnt_consul" name="mnt[9]" id="mnt_ver1" value="1" type="checkbox"></td>';
            permitUI +='                                                <td><input class="mnt_consul" name="mnt[10]" id="mnt_ver2" value="1" type="checkbox"></td>';
            permitUI +='                                                <td><input class="mnt_consul" name="mnt[11]" id="mnt_ver3" value="1" type="checkbox"></td>';
            permitUI +='                                                <td><input class="mnt_consul" name="mnt[12]" id="mnt_ver4" value="1" type="checkbox"></td>';
            permitUI +='                                                <td><input class="mnt_consul" name="mnt2[3]" id="mnt_ver6" value="1" type="checkbox"></td>';
            permitUI +='                                                <td><input class="mnt_consul" name="mnt[13]" id="mnt_ver7" value="1" type="checkbox"></td>';
            permitUI +='                                                <td><input class="mnt_consul" name="mnt[14]" id="mnt_ver8" value="1" type="checkbox"></td>';
            permitUI +='                                                <td><input class="mnt_consul" name="mnt[15]" id="mnt_ver9" value="1" type="checkbox"></td>';
            permitUI +='                                            </tr></tbody>';
            permitUI +='                                        </table>';
            permitUI +='                                    </div>';
            permitUI +='                                </div>';
            permitUI +='                                <div class="tab-pane" id="tab-table8"><!--<i class="fa fa-edit fa-lg"></i> Editar-->';
            permitUI +='                                    <table class="table table-bordered table-condensed">';
            permitUI +='                                        <thead>';
            permitUI +='                                            <tr class="active">';
            permitUI +='                                                <th valign="middle"><div align="center">Solicitudes abiertas</div></th>';
            permitUI +='                                                <th valign="middle"><div align="center">Estatus solicitud</div></th>';
            permitUI +='                                                <th valign="middle"><div align="center">Cuadrillas</div></th>';
            permitUI +='                                            </tr>                      ';
            permitUI +='                                        </thead>';
            permitUI +='                                        <tbody align="center">';
            permitUI +='                                            <tr><td><input class="mnt_edit" name="mnt[16]" id="mnt_editar1" value="1" type="checkbox"></td>';
            permitUI +='                                            <td><input class="mnt_edit" name="mnt[17]" id="mnt_editar2" value="1" type="checkbox"></td>';
            permitUI +='                                            <td><input class="mnt_edit" name="mnt2[1]" id="mnt_editar3" value="1" type="checkbox"></td>';
            permitUI +='                                        </tr></tbody>';
            permitUI +='                                    </table>';
            permitUI +='                                </div>';
            permitUI +='                                <div class="tab-pane" id="tab-table9"><!--Eliminar-->';
            permitUI +='                                    <table class="table table-bordered table-condensed">';
            permitUI +='                                        <thead>';
            permitUI +='                                            <tr class="active">';
            permitUI +='                                                <th valign="middle"><div align="center">Miembros de cuadrilla</div></th>';
            permitUI +='                                                <!--<th valign="middle"><div align="center">Todo</div></th>-->';
            permitUI +='                                            </tr>                      ';
            permitUI +='                                        </thead>';
            permitUI +='                                        <tbody align="center">';
            permitUI +='                                            <tr><td><input name="mnt2[2]" id="mnt_eliminar" value="1" type="checkbox"></td>';
            permitUI +='                                            <!--<td><div align="center"><input type="checkbox" id="checkAll_10" onclick="diferent(\'mnt_proceso\')"></div></td>-->';
            permitUI +='                                        </tr></tbody>';
            permitUI +='                                    </table>';
            permitUI +='                                </div>  ';
            permitUI +='                            </div>';
            permitUI +='                        </div>';
            permitUI +='                    </div>';
            permitUI +='                </div>';
            permitUI +='                <!-- 2. PERMISOS DE MANTENIMIENTO -->';
            permitUI +='                <!-- 3. PERMISOS DE USUARIOS -->';
            permitUI +='                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">';
            permitUI +='                    <div class="panel panel-default">';
            permitUI +='                        <div class="panel-heading" role="tab" id="headingOne">';
            permitUI +='                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="true" aria-controls="collapseThree">';
            permitUI +='                                <h3 class="panel-title">';
            permitUI +='                                    <i class="fa fa-users fa-fw" style="margin-right: 10px;"></i><span class="negritas permisos-nombre-grande">Usuarios</span>';
            permitUI +='                                </h3>';
            permitUI +='                            </a>';
            permitUI +='                        </div>';
            permitUI +='                        <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne" style="height: 114px;">';
            permitUI +='                            <ul id="myTab4" class="nav nav-tabs" role="tablist">';
            permitUI +='                                <li class="active">';
            permitUI +='                                    <a href="#tab-table11" data-toggle="tab">Crear/Agregar</a>';
            permitUI +='                                </li>';
            permitUI +='                                <li>';
            permitUI +='                                    <a href="#tab-table12" data-toggle="tab">Consultar</a>';
            permitUI +='                                </li>';
            permitUI +='                                <li>';
            permitUI +='                                    <a href="#tab-table13" data-toggle="tab">Editar</a>';
            permitUI +='                                </li>';
            permitUI +='                                <!-- <li>';
            permitUI +='                                    <a href="#tab-table14" data-toggle="tab">Procesos</a>';
            permitUI +='                                </li> -->';
            permitUI +='                            </ul>';
            permitUI +='                            <div class="tab-content">';
            permitUI +='                                <div class="tab-pane active" id="tab-table11">';
            permitUI +='                                    <table class="table table-bordered table-condensed" width="100%" align="center">';
            permitUI +='                                        <thead>';
            permitUI +='                                            <tr class="active">';
            permitUI +='                                                <th valign="middle"><div align="center">Usuarios</div></th>';
            permitUI +='                                            </tr>                      ';
            permitUI +='                                        </thead>';
            permitUI +='                                        <tbody align="center">';
            permitUI +='                                            <tr><td><input name="usr[1]" id="usr_agregar1" value="1" type="checkbox"></td>';
            permitUI +='                                        </tr></tbody>';
            permitUI +='                                    </table>';
            permitUI +='                                </div>';
            permitUI +='                                <div class="tab-pane" id="tab-table12">';
            permitUI +='                                    <table id="test" class="table table-bordered table-condensed" width="100%" align="center">';
            permitUI +='                                        <thead>';
            permitUI +='                                            <tr class="active">';
            permitUI +='                                                <th valign="middle"><div align="center">Todos</div></th>';
            permitUI +='                                                <th valign="middle"><div align="center">Por dependencia</div></th>';
            permitUI +='                                            </tr>';
            permitUI +='                                        </thead>';
            permitUI +='                                        <tbody align="center">';
            permitUI +='                                                <tr><td><input name="usr[2]" id="usr_ver1" value="1" type="checkbox"></td>';
            permitUI +='                                                <td><input name="usr[3]" id="usr_ver2" value="1" type="checkbox"></td>';
            permitUI +='                                        </tr></tbody>';
            permitUI +='                                    </table>';
            permitUI +='                                </div>';
            permitUI +='                                <div class="tab-pane" id="tab-table13">';
            permitUI +='                                    <table class="table table-bordered table-condensed" width="100%" align="center">';
            permitUI +='                                        <thead>';
            permitUI +='                                            <tr class="active">';
            permitUI +='                                                <th valign="middle"><div align="center">Usuarios</div></th>';
            permitUI +='                                                <th valign="middle"><div align="center">Activar/Desactivar usuarios</div></th>';
            permitUI +='                                            </tr>                      ';
            permitUI +='                                        </thead>';
            permitUI +='                                        <tbody align="center">';
            permitUI +='                                                <tr><td><input class="usr_edit" name="usr[4]" id="usr_editar1" value="1" type="checkbox"></td>';
            permitUI +='                                                <td><input class="usr_edit" name="usr[5]" id="usr_proceso1" value="1" type="checkbox"></td>';
            permitUI +='                                        </tr></tbody>';
            permitUI +='                                    </table>';
            permitUI +='                                </div>';
            permitUI +='                                <!-- <div class="tab-pane" id="tab-table14">';
            permitUI +='                                    <table class="table table-hover table-bordered table-condensed" align="center" width="100%">';
            permitUI +='                                        <thead>';
            permitUI +='                                            <tr>';
            permitUI +='                                                <th valign="middle"><div align="center">Activar/Desactivar</div></th>';
            permitUI +='                                            </tr>                      ';
            permitUI +='                                        </thead>';
            permitUI +='                                        <tbody>';
            permitUI +='                                                <td><div align="center"><input type="checkbox" name="usr[5]" id="usr_proceso1" value="1"></div></td>';
            permitUI +='                                        </tbody>';
            permitUI +='                                    </table>';
            permitUI +='                                </div> -->';
            permitUI +='                            </div>';
            permitUI +='                        </div>';
            permitUI +='                    </div>';
            permitUI +='                </div>';
            permitUI +='                <!-- 3. PERMISOS DE USUARIOS -->';
            permitUI +='            </div>';
        buildModal('bla!', "Listado de usuario por permiso", permitUI, "<button class=\"btn btn-warning btn-xs pull-right\">Close</button>");
    });
</script>
 