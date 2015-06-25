<!--<script src="<?php// echo base_url() ?>assets/js/jquery.min.js"></script>-->
<script type="text/javascript">
    base_url = '<?= base_url() ?>';
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
                <input type="text" id="valor" name="valor">  <!--estos inputs vienen del custom js en la funcion externa de busqueda por -->
                <input type="text" id="result1" name="result1"><!-- rangos para mostrar los resultados, estan ocultos despues de probar -->
                <input type="text" id="result2" name="result1"><!--por lo cual se pueden cambiar a tipo text para ver como funciona la busqueda-->
                <div class="table-responsive">

                    <div class="controls-row">
                        <div class="control-group col col-lg-3">
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1"><i class="fa fa-calendar"></i></span>
                                <input type="search" readonly class="form-control input-sm" style="width: 200px" name="fecha" id="fecha" placeholder="Fecha" />
                            </div>
                        </div>
                        <div class="control-group col col-lg-3">
                            <div class="input-group">
                                <input type="text" class="form-control input-sm" style="width: 200px" id="buscador">
                                <span class="input-group-addon" id="basic-addon2"><i class="fa fa-search"></i></span>
                            </div>
                        </div>
                        <div class="control-group col col-lg-12">
                            <div class="input-group">
                                <a class="toggle-vis" data-column="9">Haz click aquí para cambiar el estatus de una solicitud</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12">
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
                                <th><img src="<?php echo base_url() ?>assets/img/mnt/tecn.png" class="img-rounded" alt="bordes redondeados" width="25" height="25"></th>
                                <th>c+a</th>
                                <th>ayu</th>
                            </tr>
                            </thead>
    <!--                        <tfoot>
                            <tr>
                                <th>Orden</th>
                                <th>Fecha</th>
                                <th>Dependencia</th>
                                <th>Asunto</th>
                                <th>Estatus</th>
                                <th>cua</th>
                                <th>c+a</th>
                                <th>ayu</th>
                                <th>Cambio</th>
                                </tr>
                            </tfoot>-->
                            <tbody>
                                <?php foreach ($mant_solicitudes as $key => $sol) : ?>
                                    <tr>
                                        <td><input type="checkbox"></td>
                                        <td>

                                            <a href="<?php echo base_url() ?>index.php/mnt_solicitudes/detalle/<?php echo $sol['id_orden'] ?>">
                                                <?php echo $sol['id_orden'] ?>
                                            </a>
                                        </td>
                                        <td><?php echo date("d/m/Y", strtotime($sol['fecha_p'])); ?></td>
                                        <td> <?php echo $sol['dependen']; ?></td>
                                        <td> <?php echo $sol['asunto']; ?></td>
                                        <td> <?php echo $sol['descripcion']; ?></td>
                                        <td> <?php if (!empty($sol['cuadrilla'])): ?>
                                                <div align="center"> <img src="<?php echo base_url() . $sol['icono']; ?>" class="img-rounded" alt="bordes redondeados" width="25" height="25"></div>
                                                <?php
                                            else :
                                                ?>

                                                <a href='#cuad<?php echo $sol['id_orden'] ?> ' data-toggle="modal" data-id="<?php echo $sol['id_orden']; ?>" data-asunto="<?php echo $sol['asunto'] ?>" data-tipo_sol="<?php echo $sol['tipo_orden']; ?>" class="open-Modal" >
                                                    <div align="center"><img src="<?php echo base_url() ?>assets/img/mnt/noo.png" class="img-rounded" alt="bordes redondeados" width="15" height="15"></div></a>
                                            <?php endif; ?>                      
                                        </td>
                                        <td>i2</td>
                                        <td>i3</td>
                                        <td><div class="form-group">
                                                <div class="col-xs-3"> 
                                                    <select size="1"id = "select_estado" name="select_estado">
                                                        <option value="">--SELECCIONE--</option>
                                                        <?php foreach ($estatus as $est): ?>
                                                            <option value = "<?php echo $est->id_estado ?>"><?php echo $est->descripcion ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div></td>                
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
                                <div class="form-group">   
                                    <div id="<?php echo $sol['id_orden'] ?>">

                                    </div>

                                </div>
                                <?php if (isset($edit) && $edit && isset($tipo)) : ?>
                                    <input type="hidden" name="id" value="<?php echo $tipo['id_orden'] ?>" />
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
            <!-- fin Modal --> 
        <?php endforeach ?>
    </div>
   