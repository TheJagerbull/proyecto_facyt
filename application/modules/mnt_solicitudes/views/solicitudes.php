<script src="<?php echo base_url() ?>assets/js/jquery.min.js"></script>
<script type="text/javascript">
    base_url = '<?= base_url() ?>';
    $(document).ready(function () {
    //para usar dataTable en la table solicitudes
    var table = $('#solicitudes').DataTable({
        "pagingType": "full_numbers", //se usa para la paginacion completa de la tabla
        "sDom": '<"top"lp<"clear">>rt<"bottom"ip<"clear">>', //para mostrar las opciones donde p=paginacion,l=campos a mostrar,i=informacion
        "order": [[1, "desc"]], //para establecer la columna a ordenar por defecto y el orden en que se quiere 
        "aoColumnDefs": [{"orderable": false, "targets": [0, 9]}]//para desactivar el ordenamiento en esas columnas
    });
    table.column(9).visible(false);//para hacer invisible una columna usando table como variable donde se guarda la funcion dataTable 
    //$('div.dataTables_filter').appendTo(".search-box");//permite sacar la casilla de busqueda a un div donde apppendTo se escribe el nombre del div destino
    $('#buscador').keyup(function () { //establece un un input para el buscador fuera de la tabla
        table.search($(this).val()).draw(); // escribe la busqueda del valor escrito en la tabla con la funcion draw
    });


    $('a.toggle-vis').on('click', function (e) {//esta funcion se usa para mostrar columnas ocultas de la tabla donde a.toggle-vis es el <a class> de la vista 
        e.preventDefault();

        // toma el valor que viene de la vista en <a data-column>para establecer la columna a mostrar
        var column = table.column($(this).attr('data-column'));

        // Esta es la funcion que hace el cambio de la columna
        column.visible(!column.visible());
    });

    $('#fecha').change(function () {//este es el input que funciona con el dataranger para mostrar las fechas
        table.draw(); // la variable table, es la tabla a buscar la fecha

    });
    //esta funcion permite que al hacer click sobre el input de la fecha para borrar el valor que tenga 
    $('#fecha').on('click', function () {
        document.getElementById("fecha").value = "";//se toma el id del elemento y se hace vacio el valor del mismo
        table.draw();//devuelve este valor a la escritura de la tabla para reiniciar los valores por defecto
    });

    $('#ayudantes').DataTable({
        "bLengthChange": false,
        "iDisplayLength": 10
    });
});
</script>


<!-- Page content -->

<div class="mainy">


    <?php if ($this->session->flashdata('create_orden') == 'success') : ?>
        <div class="alert alert-success" style="text-align: center">Solicitud creada con éxito</div>
    <?php endif ?>
    <?php if ($this->session->flashdata('create_orden') == 'error') : ?>
        <div class="alert alert-danger" style="text-align: center">Ocurrió un problema creando su solicitud</div>
    <?php endif ?>
    <?php if ($this->session->flashdata('asigna_cuadrilla') == 'success') : ?>
        <div class="alert alert-success" style="text-align: center">Cuadrilla asignada con éxito</div>
    <?php endif ?>
    <?php if ($this->session->flashdata('asigna_cuadrilla') == 'error') : ?>
        <div class="alert alert-danger" style="text-align: center">Ocurrió un problema asignando la cuadrilla... Verifique los datos</div>
    <?php endif ?>

    <!-- Page title --> 
    <div class="page-title">
        <h2 align="right"><i class="fa fa-desktop color"></i> Consulta de solicitud <small>Seleccione para ver detalles </small></h2>
        <hr />
    </div>

    <!-- Page title -->
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading"><label class="control-label">Lista de Solicitudes</label>
                <a href="<?php echo base_url() ?>index.php/mnt_solicitudes/solicitud" class="btn btn-success pull-right btn-sm">Crear Solicitud</a>
            </div>
            <div class="panel-body">
                <input type="hidden" id="valor" name="valor">  <!--estos inputs vienen del custom js en la funcion externa de busqueda por -->
                <input type="hidden" id="result1" name="result1"><!-- rangos para mostrar los resultados, estan ocultos despues de probar -->
                <input type="hidden" id="result2" name="result1"><!--por lo cual se pueden cambiar a tipo text para ver como funciona la busqueda-->
                <div class="table-responsive">

                    <div class="controls-row">
                        <div class="control-group col col-lg-3 col-md-3 col-sm-3">
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1"><i class="fa fa-calendar"></i></span>
                                <input type="search" readonly class="form-control input-sm" style="width: 200px" name="fecha" id="fecha" placeholder="Fecha" />
                            </div>
                        </div>
                        <div class="control-group col col-lg-3 col-md-3 col-sm-3">
                            <div class="input-group">
                                <input type="text" class="form-control input-sm" style="width: 200px" id="buscador">
                                <span class="input-group-addon" id="basic-addon2"><i class="fa fa-search"></i></span>
                            </div>
                        </div>
                        <div class="control-group col col-lg-12 col-md-12 col-sm-12">
                            <div class="form-control" align="center">
                                <a class="toggle-vis" data-column="9">Haz click aquí para cambiar el estatus de una solicitud</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <table id="solicitudes" class="table table-hover table-bordered table-condensed" align="center" width="100%">
                            <thead>
                                <tr >
                                    <th rowspan="2"></th>
                                    <th rowspan="2" valign="middle"><div align="center">Orden</div></th>
                            <th colspan="4"></th>
                            <th colspan="3"><div align="center">Asignar personal</div></th>
                            <th rowspan="2"><div valign="middle" align="center">Cambio de estatus</div></th>
                                </tr>
                            <tr>

                                <th>Fecha</th>
                                <th>Dependencia</th>
                                <th>Asunto</th>
                                <th>Estatus</th>
                                <th><img src="<?php echo base_url() ?>assets/img/mnt/tecn5.png" class="img-rounded" alt="bordes redondeados" width="30" height="30"></th>
                                <th>c+a</th>
                                <th><img src="<?php echo base_url() ?>assets/img/mnt/ayudantes4.png" class="img-rounded" alt="bordes redondeados" width="30" height="30"></th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($mant_solicitudes as $key => $sol) : ?>
                                    <tr>
                                        <td><input type="checkbox"></td>
                                        <td>

                                            <a href="<?php echo base_url() ?>index.php/mnt_solicitudes/detalle/<?php echo $sol['id_orden'] ?>">
                                                <?php echo $sol['id_orden'] ?>
                                            </a>
                                        </td>
                                        <td><?php echo date("d/m/Y", strtotime($sol['fecha'])); ?></td>
                                        <td> <?php echo $sol['dependen']; ?></td>
                                        <td> <?php echo $sol['asunto']; ?></td>
                                        <td> <?php echo $sol['descripcion']; ?></td>
                                        <td> <?php if (!empty($sol['cuadrilla'])): ?>
                                            <a href='#cuad<?php echo $sol['id_orden'] ?> ' data-toggle="modal" data-id="<?php echo $sol['id_orden']; ?>" data-asunto="<?php echo $sol['asunto'] ?>" data-tipo_sol="<?php echo $sol['tipo_orden']; ?>" class="open-Modal" >
                                                <div align="center"> <img src="<?php echo base_url() . $sol['icono']; ?>" class="img-rounded" alt="bordes redondeados" width="25" height="25"></div></a>
                                                
                                                <?php
                                            else :
                                                ?>

                                                <a href='#cuad<?php echo $sol['id_orden'] ?> ' data-toggle="modal" data-id="<?php echo $sol['id_orden']; ?>" data-asunto="<?php echo $sol['asunto'] ?>" data-tipo_sol="<?php echo $sol['tipo_orden']; ?>" class="open-Modal" >
                                                    <div align="center"><i class="glyphicon glyphicon-remove" style="color:#D9534F"></i></div></a>
                                            <?php endif; ?>                      
                                        </td>
                                        <td>i2</td>
                                        <td><a href='#ayudante<?php echo $sol['id_orden'] ?>' data-toggle="modal"><div align="center"><i class="glyphicon glyphicon-remove" style="color:#D9534F"></i></div></a></td>
                                        <td>
                                            <form class="form" method="post" name="edita" id="edita">
                                            <div class="form-group">
                                                <div class="col-xs-3"> 
                                                    <select size="1"id = "select_estado" name="select_estado">
                                                        <option value="">--SELECCIONE--</option>
                                                        <?php foreach ($estatus as $est): ?>
                                                            <option value = "<?php echo $est->id_estado ?>"><?php echo $est->descripcion ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                    <input type="hidden" id="orden" name="orden" value="<?php echo $sol['id_orden'] ?>">
                                                </div>
                                            </div>
                                            </form>
                                        </td>                
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <?php foreach ($mant_solicitudes as $key => $sol) : ?>
            <!-- modal de cuadrilla -->
            <div id="cuad<?php echo $sol['id_orden'] ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="cuadrilla" >
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                            <h3 class="modal-title" align="center">Asignar Cuadrilla</h3>
                        </div>
                        <div class="modal-body">
                            <div align="center">
                                <h4><label>Solicitud Número:
                                        <label name="data" id="data"></label>
                                    </label></h4>
                                <label class="control-label" for = "tipo">Tipo de Solicitud:</label>
                                <label class="control-label" id="tipo"></label>
                                <br>
                                <label class="control-label" for = "tipo">Asunto:</label>
                                <label class="control-label" id="asunto"></label>

                            </div>
                            <?php if (empty($sol['cuadrilla'])): ?>
                            <form class="form" action="<?php echo base_url() ?>index.php/mnt_asigna_cuadrilla/mnt_asigna_cuadrilla/asignar_cuadrilla" method="post" name="modifica" id="modifica">
                                <div class="form-group">   

                                </div>
                                <input type="hidden" id="num_sol" name="num_sol" value="">
                                <div class="form-group">

                                    <label class="control-label" for="cuadrilla">Cuadrilla</label>
                                    <div class="control-label">
                                        <select class = "form-control" id = "cuadrilla_select" name="cuadrilla_select" onchange="mostrar(this.form.cuadrilla_select, this.form.responsable, ($('#<?php echo $sol['id_orden'] ?>')))">
                                            <option selected=" " value = "">--Seleccione--</option>
                                            <?php foreach ($cuadrilla as $cuad): ?>
                                                <?php //if ($tipo['cuadrilla'] != $cuad->cuadrilla): ?>
                                                <option value = "<?php echo $cuad->id ?>"><?php echo $cuad->cuadrilla ?></option>
                                                <?php // endif;  ?>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">   
                                    <label class="control-label" for = "responsable">Responsable</label>
                                    <input type="text" readonly="true" class="form-control" id = "responsable" name = "responsable">

                                </div>
                                <div id= "test" class="form-group">   
                                    <div id="<?php echo $sol['id_orden'] ?>">
                                      
                                    </div>

                                </div>
                                        <?php if (isset($edit) && $edit && isset($tipo)) : ?>
                                            <input type="hidden" name="id" value="<?php echo $tipo['id_orden'] ?>" />
                                        <?php endif ?>
                                   <?php else:?>
                                    <hr>
                                    <div align="center"><label class="alert-danger">Esta cuadrilla ya fue asignada</label></div>
                                    
                                  <?php endif ?>   
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Guardar cambios</button>
                                    <button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Cancelar</button>
                                </div>
                            </form>


                        </div>
                    </div>
                </div>
            </div>
            <!-- fin de modal de cuadrilla-->
            <!-- MODAL DE AYUDANTES-->
            <div id="ayudante<?php echo $sol['id_orden'] ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                    <h4 class="modal-title">Asignar Ayudantes</h4>
                  </div>
                    <div class="modal-body">
                        <?php if(!empty($ayudantes)) :?>
                            <table id="ayudantes" class="table table-hover table-bordered">
                                  <thead>
                                    <tr>
                                      <th>Agregar</th>
                                      <th>Nombre</th>
                                      <th>Apellidos</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <form class="form-horizontal" action="<?php echo base_url() ?>index.php/solicitud/actual/agregar/<?php echo $sol['id_orden']?>" method="post">
                                  <?php foreach($ayudantes as $index => $worker) : ?>
                                      <tr>
                                        <td align="center"><?php //$aux['id_articulo']= $worker->ID;?>
                                          <?php //if(in_array($aux, $id_articulos)) :?>
                                            <!-- <i style"color: #398439" class="fa fa-check"></i> -->
                                          <!--<?php //else: ?>-->
                                            <input uncheck type="checkbox" id="<?php echo $index.$sol['id_orden'] ?>" value="<?php echo $worker['id_usuario'] ?>">
                                          
                                           <!--  <input type="hidden" name="id_trabajador" value="<?php echo $worker['id_usuario'] ?>" />
                                            <input type="hidden" name="id_orden_trabajo" value="<?php echo $sol['id_orden'] ?>" />
                                            <button type="submit"><i class="fa fa-plus color"></i></button> -->

                                          <!--<?php //endif; ?>-->
                                        </td>
                                        <td><?php echo ucfirst($worker['nombre']) ?></td>
                                        <td><?php echo ucfirst($worker['apellido']) ?></td>
                                      </tr>
                                  <?php endforeach ?>
                                    </form>
                                  </tbody>
                            </table>
                        <?php else:?>
                            <div class="alert alert-info">
                                      No hay ayudantes disponibles.
                            </div>
                        <?php endif;?>
                    </div>
                </div>
              </div>
            </div>

            <!-- FIN DE MODAL DE AYUDANTES-->
            <!-- fin Modal --> 
        <?php endforeach ?>
    </div>
   