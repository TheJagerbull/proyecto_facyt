<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

<script type="text/javascript">
    base_url = '<?= base_url() ?>';
</script><!-- Page content -->

<div class="mainy">
    <?php if ($this->session->flashdata('create_orden') == 'success') : ?>
        <div class="alert alert-success" style="text-align: center">Solicitud creada con éxito</div>
    <?php endif ?>
    <?php if ($this->session->flashdata('create_orden') == 'error') : ?>
        <div class="alert alert-danger" style="text-align: center">Ocurrió un problema creando su solicitud</div>
    <?php endif ?>

    <!-- Page title --> 
    <div class="page-title">
        <h2 align="right"><i class="fa fa-desktop color"></i> Consulta de solicitud <small>Seleccione para ver detalles </small></h2>
        <hr />
    </div>
          
    <!-- Page title -->
    <div class="row">
        <div class="col-md-12">
            <div class="awidget full-width">
                <div class="awidget-head">
                    <h3>Lista de Solicitudes</h3>
                </div>
                 <!-- Buscar solicitudes -->
                    <div class="form-group">
                        <div class="col-lg-5">
                         <form id="ACquery3" class="input-group form" action="<?php echo base_url() ?>index.php/mnt_solicitudes/listar/buscar" method="post">
                            <div class="container" id="sandbox-container">
                              <div>
                                  <?php $tmp = $this->session->userdata('tmp');?>
                                <input type="search" readonly style="width: 200px" name="fecha" id="fecha" value="<?php echo (!empty($tmp['fecha'])) ? $tmp['fecha'] : 'Fecha' ?>"class="form-control" placeholder="Fecha" /> 
                                <span class="input-group-btn">
                                    <button type="reset" class="btn-info">
                                    <i class="fa fa-chevron-left"></i>
                                  </button>
                               </span>            
                            </div>
                                <input id="autocompleteMant" type="search" name="solicitudes" class="form-control" placeholder="Orden... ó cuadrilla... ó ubicación...  ó estatus">
                             <fieldset>
                               <span class="input-group-btn">
                                 <button type="submit" class="btn btn-info">
                                    <i class="fa fa-search"></i>
                                 </button>
                               </span>            
                            </fieldset>
                                
                           </div>
                        </form>
                        </div>
                        <div class="col-lg-4">
                            <a href="<?php echo base_url() ?>index.php/mnt_solicitudes/listar" class="btn btn-info">Listar</a>
                            <a href="<?php echo base_url() ?>index.php/mnt_solicitudes/solicitud" class="btn btn-success" data-toggle="modal">Crear Solicitud</a>
                            <!--href="<?php echo base_url() ?>index.php/mnt_solicitudes/lista_solicitudes"-->
                        </div>
                    </div>
                    <!-- fin de Buscar solicitudes -->
                
                <?php if (empty($mant_solicitudes)) : ?>
                    <div class="alert alert-info" style="text-align: center">No se encontraron Solicitudes</div>
                <?php endif ?>
                <div class="awidget-body">
                    <div class="list-group" align="right"><?php echo $links; ?></div>
                    

                    <table class="table table-hover table-bordered ">
                        <thead>
                            <tr>
                                <th><a href="<?php echo base_url() ?>index.php/mnt_solicitudes/orden/<?php if($this->uri->segment(3)=='buscar') echo 'buscar/'; ?>orden/<?php echo $order ?>/0">Orden</a></th>
                                <th><a href="<?php echo base_url() ?>index.php/mnt_solicitudes/orden/<?php if($this->uri->segment(3)=='buscar') echo 'buscar/'; ?>fecha/<?php echo $order ?>/0">Fecha</a></th>
                                <th><a href="<?php echo base_url() ?>index.php/mnt_solicitudes/orden/<?php if($this->uri->segment(3)=='buscar') echo 'buscar/'; ?>dependencia/<?php echo $order ?>/0">Dependencia</a></th>
                                <th><?php echo 'Asunto'; ?></th>
                                <th><a href="<?php echo base_url() ?>index.php/mnt_solicitudes/orden/<?php if($this->uri->segment(3)=='buscar') echo 'buscar/'; ?>estatus/<?php echo $order ?>/0">Estatus</a></th>
                                <th colspan="3"><div align="center"> Asignar personal</div>
<!--                                    <a href="<?php// echo base_url() ?>index.php/mnt_solicitudes/lista/cuadrilla/<?php// echo $order ?>">Cuadrilla</a>-->
<!--                        <div align="center"><img src="<?php //echo base_url() ?>assets/img/mnt/tecn.png" class="img-rounded" alt="bordes redondeados" width="25" height="25"></div>-->
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                              
                            <?php if (!empty($mant_solicitudes)) : ?>

                                <?php foreach ($mant_solicitudes as $key => $sol) : ?>

                                    <tr>
                                        <td>
                                            <a href="<?php echo base_url() ?>index.php/mnt_solicitudes/detalle/<?php echo $sol->id_orden ?>">
                                                <?php echo $sol->id_orden ?>
                                            </a>
                                        </td>

                                        <td><?php echo date("d/m/Y", strtotime($sol->fecha_p)); ?></td>

                                        <td> <?php echo $sol->dependen; ?></td>
                                        <td> <?php echo $sol->asunto; ?></td>
                                        <td> <?php echo $sol->descripcion; ?></td>
                                        
                                            <th>
                                            <?php
                                            if (!empty($sol->cuadrilla)):?>
                                               <div align="center"> <img src="<?php echo base_url().$sol->icono;?>" class="img-rounded" alt="bordes redondeados" width="25" height="25"></div>
                                            <?php                                                
                                             else :
                                                 ?><a href="#modificar" data-toggle="modal" data-id="<?php echo $sol->id_orden." ".$sol->tipo_orden;?>" class="open-Modal fadeIn">
                                                 <div align="center"><img src="<?php echo base_url() ?>assets/img/mnt/noo.jpg" class="img-rounded" alt="bordes redondeados" width="25" height="25"></div></a>
                                            <?php endif;
                                            ?> 
                                             </th>
                                             <th>i2</th>
                                             <th>i3</th>
                                         
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>

                    <div class="list-group" align="right"><?php echo $links; ?></div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        
    </div>
    <!-- Modal -->
            <div id="modificar" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modificacion" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                            <h4 class="modal-title">Asignar Cuadrilla</h4>
                        </div>
                        <div class="modal-body">
                            <label>Solicitud Número:
                            <?php  $var = '<label name="data" id="data"> </label>';
//                              echo $var;
                              //settype($var, "string");
//                              $var1 = explode(" ", $var);
                              
//                              echo_pre($var1);  
                            
                             echo($var);  
//                            $var = preg_split("/ y /", $var);
//                            $var1 = $var[0];
//                            $var2 = $var[1];
//                            $var1 = explode(" ", $var);
                             $var = '<script type="text/javascript">; document.on.write(id); </script>'; 
                            echo_pre($var);
//                          echo $var2;
                            ?></label>
                            <input type="hidden" id="data1">
                            
                            <div>
                                
                                <form class="form-horizontal" action="<?php echo base_url() ?>" method="post" name="modifica" id="modifica">
                                   <div class="form-group">   
                                        <label class="control-label" for = "tipo">Tipo de Solicitud:
                                        <?php 
//                                        echo gettype($var);
                                        
//                                        echo gettype($var);
                                        foreach ($mant_solicitudes as $key => $sol) : 
                                            //echo $var;
//                                            echo gettype($sol->id_orden);
//                                            echo $sol->id_orden;
//                                            echo $sol->tipo_orden;
                                            if ($var==$sol->id_orden):
                                              echo $sol->tipo_orden;
                                          endif;    
                                        endforeach;
                                        ?></label>
                                   </div>
                                    <div class="form-group">
                                        <label class="control-label" for="cuadrilla">Cuadrilla</label>
                                        <div class="control-label">
                                            <select class = "form-control" id = "cuadrilla_select" name="cuadrilla_select" onchange="mostrar(this.form.cuadrilla_select,this.form.responsable,($('#miembro')))">
                                                <option selected=" " value = "">--Seleccione--</option>
                                            <?php foreach ($cuadrilla as $cuad): ?>
                                                <?php //if ($tipo['cuadrilla'] != $cuad->cuadrilla): ?>
                                                    <option value = "<?php echo $cuad->nombre ?>"><?php echo $cuad->cuadrilla ?></option>
                                                <?php// endif; ?>
                                            <?php endforeach; ?>
                                        </select>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">   
                                        <label class="control-label" for = "responsable">Responsable</label>
                                        <input type="text" readonly="true" class="form-control" id = "responsable" name = "responsable">
                                       
                                    </div>
                                    <div class="form-group">   
                                        <label class="control-label" for = "responsable">Miembros de la Cuadrilla</label>
                                      <div id="lista">
                                        <table id="miembro" class="table table-hover table-bordered">
                                        </table>
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
               

            </div>
        </div>
<div class="clearfix"></div>