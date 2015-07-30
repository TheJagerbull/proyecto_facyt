<script src="<?php echo base_url() ?>assets/js/jquery.min.js"></script>
<script type="text/javascript">
    base_url = '<?= base_url() ?>';
       $(document).ready(function () {
        //para usar dataTable en la table solicitudes
        var table = $('#lista_cuadrilla').DataTable({
            "pagingType": "full_numbers", //se usa para la paginacion completa de la tabla
            "sDom": '<"top"lp<"clear">>rt<"bottom"ip<"clear">>', //para mostrar las opciones donde p=paginacion,l=campos a mostrar,i=informacion
            "order": [[0, "asc"]] //para establecer la columna a ordenar por defecto y el orden en que se quiere 
        });
        //$('div.dataTables_filter').appendTo(".search-box");//permite sacar la casilla de busqueda a un div donde apppendTo se escribe el nombre del div destino
        $('#buscador').keyup(function () { //establece un un input para el buscador fuera de la tabla
            table.search($(this).val()).draw(); // escribe la busqueda del valor escrito en la tabla con la funcion draw
        });
        $('#reset').on('click', function () {
            $('#buscador').val("");//se toma el id del elemento y se hace vacio el valor del mismo
            table  //Aqui se hace el vaciado de la busqueda. 
             .search( '' )
             .columns().search( '' )
             .draw();
        });
});    
</script>

<!-- Page content -->
<div class="mainy">
    <!-- Page title -->
    <div class="page-title">
        <h2 align="right"><i class="fa fa-user color"></i> Cuadrillas<small> Seleccione el nombre para ver detalles</small></h2> 
        <hr />
    </div>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand"><span class="glyphicon glyphicon-cog"></span></a>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="<?php echo base_url() ?>index.php/mnt_cuadrilla/listar">Listar <span class="sr-only">(current)</span></a></li>
                </ul>
                <form class="navbar-form navbar-left" role="search">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Buscar" id="buscador">
                    </div>
                    <button type="reset" id="reset" class="btn btn-default">Reset</button>
                </form>
                <ul class="nav navbar-form navbar-right">
                    <a href="<?php echo base_url() ?>index.php/mnt_cuadrilla/cuadrilla/crear_cuadrilla" class="btn btn-success" data-toggle="modal">Agregar</a>
                </ul>

            </div> <!--/.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>

    <div class="row">
        <div class="col-md-12">
            <div class="awidget full-width">
                <div class="awidget-head">
                    <!-- Buscar cuadrilla -->
<!--                    <div class="col-lg-6">
                        <form id="ACquery4" class="input-group form" action="<?php echo base_url() ?>index.php/mnt_cuadrilla/cuadrilla/index" method="post">
                            <input id="autocomplete_cuadrilla" type="search" name="item" class="form-control" placeholder="Nombre de cuadrila... ">
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-info">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                        </form>
                    </div>-->
                    <!-- fin de Buscar cuadrilla -->

                </div>
                <?php if ($this->session->flashdata('create_item') == 'success') : ?>
                    <div class="alert alert-success" style="text-align: center">Cuadrilla creada con éxito</div>
                <?php endif ?>
                <?php if ($this->session->flashdata('edit_item') == 'success') : ?>
                    <div class="alert alert-success" style="text-align: center">Cuadrilla modificada con éxito</div>
                <?php endif ?>
                <?php if ($this->session->flashdata('drop_item') == 'success') : ?>
                    <div class="alert alert-success" style="text-align: center">Cuadrilla eliminada con éxito</div>
                <?php endif ?>
                <?php if ($this->session->flashdata('drop_item') == 'error') : ?>
                    <div class="alert alert-danger" style="text-align: center">Ocurrió un problema eliminando la cuadrilla</div>
                <?php endif ?>
                <?php if ($this->session->flashdata('edit_item') == 'error') : ?>
                    <div class="alert alert-danger" style="text-align: center">Ocurrió un problema con la edición de la cuadrilla</div>
                <?php endif ?>

                <?php if (empty($item)) : ?>
                    <div class="alert alert-info" style="text-align: center">No se encontraron cuadrillas</div>
                <?php endif ?>
                <div class="awidget-body">
                   <table class="table table-hover table-bordered" id="lista_cuadrilla">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Responsable</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($item)) : ?>

                                <?php foreach ($item as $key => $cuadrilla) : ?>
                                    <tr>
                                        <td>
                                            <a href="<?php echo base_url() ?>index.php/mnt_cuadrilla/detalle/<?php echo $cuadrilla->id ?>">
                                                <?php echo $cuadrilla->cuadrilla ?>
                                            </a>
                                        </td>
                                        <td><?php echo ($cuadrilla->nombre) ?></td>


                                    </tr>
                                <?php endforeach; ?>
                            <?php endif ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
<div class="clearfix"></div>