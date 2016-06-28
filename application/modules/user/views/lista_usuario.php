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
            "stateLoadParams": function (settings, data) {
                $("#auto").val(data.search.search);
            },
            "bDeferRender": true,
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "pagingType": "full_numbers", //se usa para la paginacion completa de la tabla
            "sDom": '<"row"<"col-sm-6"l><"col-sm-6"f>>rt<"row"<"col-sm-4"i><"col-sm-8"p>>', //para mostrar las opciones donde p=paginacion,l=campos a mostrar,i=informacion
            "order": [[0, "asc"]], //para establecer la columna a ordenar por defecto y el orden en que se quiere 
            "aoColumnDefs": [{"orderable": false, "targets": [-1]}], //para desactivar el ordenamiento en esas columnas
            "ajax": {
                "url": "<?php echo site_url('usuarios') ?>",
                "type": "GET",
                "data": function ( d ) {
                    d.dep = <?php echo $dep?>;
                }
            },
            "columns": [
                {"data": "id"},
                {"data": "nombre"},
                {"data": "rol"},
                {"data": "status"},
                {"data": "estatus"},
                {"data": "check"}

            ]
        });
        $('#auto').keyup(function () { //establece un un input para el buscador fuera de la tabla
            table.search($(this).val()).draw(); // escribe la busqueda del valor escrito en la tabla con la funcion draw
        });
        table.column(3).visible(false);
       <?php if (!$activa){?>
            table.column(4).visible(false);
            table.column(5).visible(false);
       <?php }else{?>
            table.column(4).visible(true);
            table.column(5).visible(true);
       <?php };?>

    });
</script>
<style>
    input[type='checkbox'].icon-checkbox{display:none}
    input[type='checkbox'].icon-checkbox+label .unchecked{display:inline}
    input[type='checkbox'].icon-checkbox+label .checked{display:none}
    input[type='checkbox']:checked.icon-checkbox{display:none}
    input[type='checkbox']:checked.icon-checkbox+label .unchecked{display:none}
    input[type='checkbox']:checked.icon-checkbox+label .checked{display:inline}
</style>
<!-- Page content -->
<div class="mainy">
    <!-- Page title -->
    <div class="page-title">
        <h2 align="right"><i class="fa fa-user color"></i> Control<small> de usuarios</small></h2> 
        <hr />
    </div>


    <!-- Page title -->
    <div class="row">
        <div class="col-md-12">
            <!--<div class="awidget full-width">-->
            <!--<div class="awidget-head">-->
            <!--<h3>Lista de usuarios</h3>-->

<!--<a href="<?php echo base_url() ?>index.php/usuario/listar" class="btn btn-info">Listar Usuarios</a>-->
<!--href="<?php echo base_url() ?>index.php/usuario/listar"-->
            <!-- Buscar usuario -->

            <!-- fin de Buscar usuario -->

            <!--</div>-->
            <?php if ($this->session->flashdata('create_user') == 'success') : ?>
                <div class="alert alert-success" style="text-align: center">Usuario creado con éxito</div>
            <?php endif ?>
            <?php if ($this->session->flashdata('drop_user') == 'success') : ?>
                <div class="alert alert-success" style="text-align: center">Usuario desactivado con éxito</div>
            <?php endif ?>
            <?php if ($this->session->flashdata('drop_user') == 'error') : ?>
                <div class="alert alert-danger" style="text-align: center">Ocurrió un problema Desactivando al usuario</div>
            <?php endif ?>
            <?php if ($this->session->flashdata('edit_user') == 'success') : ?>
                <div class="alert alert-success" style="text-align: center">Usuario modificado con éxito</div>
            <?php endif ?>
            <?php if ($this->session->flashdata('edit_user') == 'error') : ?>
                <div class="alert alert-danger" style="text-align: center">Ocurrió un problema con la edición del usuario</div>
            <?php endif ?>
            <!--activate_user-->
            <?php if ($this->session->flashdata('activate_user') == 'success') : ?>
                <div class="alert alert-success" style="text-align: center">Usuario activado con éxito</div>
            <?php endif ?>
            <?php if ($this->session->flashdata('activate_user') == 'error') : ?>
                <div class="alert alert-danger" style="text-align: center">Ocurrió un problema con la activacion del usuario</div>
            <?php endif ?>
            <?php // if (empty($users)) : ?>
                <!--<div class="alert alert-info" style="text-align: center">No se encontraron usuarios</div>-->
            <?php // endif ?>
            <div class="awidget-body">

                <!-- <ul class="pagination pagination-sm">
                  <li><a href="#">1</a></li>
                  <li><a href="#">2</a></li>
                  <li><a href="#">3</a></li>
                  <li><a href="#">4</a></li>
                  <li><a href="#">5</a></li>
                </ul> -->
                <?php // echo $links; ?>

<!--							<table class="table table-hover table-bordered ">
        <thead>
                <tr>
                <th><a href="//<?php echo base_url() ?>index.php/usuario/orden/<?php if ($this->uri->segment(3) == 'buscar') echo 'buscar/'; ?>orden_CI/<?php echo $order ?>/0">Cedula</a></th>
                <th><a href="//<?php echo base_url() ?>index.php/usuario/orden/<?php if ($this->uri->segment(3) == 'buscar') echo 'buscar/'; ?>orden_nombre/<?php echo $order ?>/0">Nombre</a></th>
                <th><a href="//<?php echo base_url() ?>index.php/usuario/orden/<?php if ($this->uri->segment(3) == 'buscar') echo 'buscar/'; ?>orden_tipousuario/<?php echo $order ?>/0">Rol En Sistema</a></th>
                <?php if ($this->session->userdata('user')['sys_rol'] == 'autoridad' || $this->session->userdata('user')['sys_rol'] == 'asist_autoridad') : ?>
                                    <th><a href="//<?php echo base_url() ?>index.php/usuario/orden/<?php if ($this->uri->segment(3) == 'buscar') echo 'buscar/'; ?>orden_status/<?php echo $order ?>/0">Estado en Sistema</a></th>
                                    <th style="text-align: center"><span class="label label-danger">O</span>Desactivar <span class="label label-success">I</span>Activar</th>
                <?php endif ?>
                </tr>
        </thead>
        <tbody>
                <?php // if (!empty($users)) : ?>
                <?php // foreach ($users as $key => $user) : ?>
                                        <tr>
                                                <td>
                                                        <a href="//<?php echo base_url() ?>index.php/usuario/detalle/<?php echo $user->ID ?>">
                <?php // echo $user->id_usuario ?>
                                                        </a>
                                                </td>
                                                <td>//<?php echo ucfirst($user->nombre) . ' ' . ucfirst($user->apellido) ?></td>
                <?php
//                            switch ($user->sys_rol) {
//                                case 'autoridad':
//                                    echo '<td>Autoridad</td>';
//                                    break;
//                                case 'asist_autoridad':
//                                    echo '<td>Asistente de autoridad</td>';
//                                    break;
//                                case 'jefe_alm':
//                                    echo '<td>Jefe de almacen</td>';
//                                    break;
//                                case 'director_dep':
//                                    echo '<td>Director de dependencia</td>';
//                                    break;
//                                case 'asistente_dep':
//                                    echo '<td>Asistente de dependencia</td>';
//                                    break;
//                                case 'ayudante_alm':
//                                    echo '<td>Ayudante de almacen</td>';
//                                    break;
//                                default:
//                                    echo '<td>No autorizado</td>';
//                                    break;
//                            }
                ?>
                                                
                <?php // if ($this->session->userdata('user')['sys_rol'] == 'autoridad' || $this->session->userdata('user')['sys_rol'] == 'asist_autoridad') : ?>
                                                             <td style="text-align: center">//<?php echo ucfirst($user->status) ?></td> 
                                                                    
                <?php // if ($user->status == 'activo'): ?>
                                                                        <td style="text-align: center"><span class="label label-info"> Activado </span></td>
                                                                        <td><div class="make-switch switch-mini" data-on-label="I" data-off-label="O" data-on="success" data-off="danger">
                                                                                <input onChange="desacivar(////<?php echo $user->ID ?>)" type="checkbox" checked>
                                                                        </div></td>
                                                                         <td style="text-align: center"><a href="////<?php echo base_url() ?>index.php/usuario/eliminar/<?php echo $user->ID ?>">
                                                                                <span class="btn btn-danger">O</span>
                                                                        </a></td> 
                <?php
                // endif;
                if ($user->status == 'inactivo'):
                    ?>
                                                                                <td style="text-align: center"><div class="label label-danger"> Desactivado </div></td>
                                                                                <td><div class="make-switch switch-mini" data-on-label="I" data-off-label="O" data-on="success" data-off="danger">
                                                                                        <input onChange="activar(////<?php echo $user->ID ?>)" type="checkbox">
                                                                                </div></td>
                                                                                 <td style="text-align: center"><a href="////<?php echo base_url() ?>index.php/usuario/activar/<?php echo $user->ID ?>">
                                                                                        <span class="btn btn-info">I</span>
                                                                                </a></td> 
                    <?php // endif;  ?>
                                    
                    <?php // endif  ?>
                                                </tr>
                    <?php // endforeach; ?>
                <?php endif ?>
        </tbody>-->
                <!--</table>-->

                <!-- <ul class="pagination pagination-sm">
                          <li><a href="#">1</a></li>
                          <li><a href="#">2</a></li>
                          <li><a href="#">3</a></li>
                          <li><a href="#">4</a></li>
                          <li><a href="#">5</a></li>
                </ul> -->
                <?php // echo $links;   ?>
                <!--<div class="clearfix"></div>-->
                <div class="panel panel-default">
                    <div class="panel-heading"><label class="control-label">Lista de Usuarios</label>
                        <?php if($agregar):?>
                            <a href="<?php echo base_url() ?>index.php/user/usuario/crear_usuario" class="btn btn-success pull-right" data-toggle="modal">Agregar</a>
                        <?php endif;?>
                    </div>
                    <div class="panel-body">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="col-lg-6">
                                <div class="input-group">
                                    <!---->
                                <!--<form class="input-group form" action="<?php echo base_url() ?>index.php/usuario/listar/buscar" method="post">-->
                                    <input id="auto" name="usuarios" class="form-control" placeholder="Cedula... o Nombre... o Apellido...">
                                    <span class="input-group-addon">
                                        <!--<button class="btn btn-info">-->
                                            <i class="fa fa-search"></i>
                                        <!--</button>-->
                                    </span>
                                <!--</form>-->
                                </div>
                            </div>
                            <div class="col-lg-6"><br></div>
                            <div class="col-lg-6"><br></div>

                            <table id="usuarios" class="table table-hover table-bordered table-condensed display select" align="center" width="100%">
                                <thead>
                                    <tr>
                                        <th valign="middle"><div align="center">Cédula</div></th>
                                        <th valign="middle"><div align="center">Nombre</div></th>
                                        <th valign="middle"><div align="center">Rol en sistema</div></th>
                                        <th valign="middle"><div align="center">Estatus</div></th>
                                        <th valign="middle"><div align="center">Estatus</div></th>
                                        <th valign="middle"><div align="center"> Activar/Desactivar</div></th>

                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                        <input id="uri" hidden value="<?php echo str_replace('/', '-', '-' . $this->uri->uri_string()); ?>">
                    </div>
                </div>
            </div>
            <!--</div>-->
        </div>
    </div>

    <!-- CREAR USUARIO -->


</div>

<div class="clearfix"></div>
<style type="text/css">
	.has-switch > div { z-index: 0; }
</style>
<script type="text/javascript">
    function desacivar(user) {
        var uri = document.getElementById("uri").value;
        window.location.href = "<?php echo base_url() ?>index.php/usuario/eliminar/" + user + uri;
    }
    function activar(user) {
        var uri = document.getElementById("uri").value;
        window.location.href = "<?php echo base_url() ?>index.php/usuario/activar/" + user + uri;
    }
</script>