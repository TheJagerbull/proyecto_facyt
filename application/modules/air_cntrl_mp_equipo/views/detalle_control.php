<script type="text/javascript">
    base_url = '<?= base_url() ?>';
</script> 
<!-- Page content -->
<div class="mainy">
    <!-- Page title -->
    <div class="page-title">
        <h2 align="right"><i class="fa fa-desktop color"></i> Crear<small> un nuevo control de mantenimiento</small></h2>
        <hr /> 
    </div>
    
    <!-- Page title -->
    <div class="row">
        <div class="container-fluid">
        <div class="col-md-12">
            <div class="awidget full-width">
                <div class="awidget-body">

                    <!-- FORMULARIO DE CREACION DE UN NUEVO CONTROL-->
                    <!-- Formulario -->
                    <form class="form-horizontal" action="<?php echo base_url() ?>index.php/air_cntrl_mp_equipo/cntrlmp/modificar_cntrl" method="post" name="nuevo_control" id="nuevo_control" enctype="multipart/form-data">
                        <div class="col-lg-12" style="text-align: center">
                            <?php echo form_error('capacidad'); ?>
                            <?php echo form_error('fecha_mp'); ?>
                            <?php echo form_error('periodo'); ?>
                            
                            
                        </div>


                        <!-- MUESTRA DATOS DEL USUARIO QUE INICIA SESION -->
                       <div class="form-group">
                             <!-- DEPENDENCIA A LA QUE PERTENECE -->
                            <h3 align='left'>Dependencia: <?php echo $nombre_depen; ?></h3>
                       <!-- SELECT ID DEL EQUIPO ASOCIADO -->
                        <div class="form-group">
                            <label class="control-label col-lg-2" for = "id_equipo">Equipo:</label>
                                <div class="col-lg-4"> 
                                    <select class="form-control" id = "id_equipo" name="id_equipo">
                                        <option value="<?php echo $cntrl->id_inv_equipo; ?>"><?php echo $cntrl->id_inv_equipo; ?></option>
                                            <?php foreach ($equipo as $eq): ?>
                                        <option value = "<?php echo $eq->id; ?>"><?php echo "(".$eq->inv_uc.", ".$eq->marca.", ".$eq->modelo.")"; ?></option>
                                            <?php endforeach; ?>
                                    </select>
                                </div>
                        </div>   
                       <!-- FECHA ULTIMO MANTENIMIENTO -->
                        <div class="form-group">
                            <label class="control-label col-lg-2" for="nombre_contacto">Fecha Último Mant.:</label>
                            <div class="col-lg-4">
                            <input type="text" value="<?php echo $cntrl->id_inv_equipo; ?>"
                                       class="form-control" id="fecha_mp" name="fecha_mp"  placeholder='AAAA-MM-DD'></input>
                            <!-- <input type="search" readonly class="form-control input-sm" style="width: 200px" name="fecha" id="fecha" placeholder="Fecha" />-->
                            </div>
                            <div class="col-xs-6">
                             <small><p align="left">Si no se ha hecho mantenimiento coloque la de compra</p></small>
                                </div>
                        </div>
                        <!-- CAPACIDAD DEL EQUIPO -->
                        <div class="form-group">
                            <label class="control-label col-lg-2" for="telefono_contacto">Cap&aacute;cidad:</label>
                            <div class="col-lg-4">
                                <input type="text" value="<?php echo $cntrl->id_inv_equipo; ?>"  placeholder='Cap&aacute;cidad'
                                       style="text-transform:uppercase;" onkeyup="javascript:this.value = this.value.toUpperCase();" class="form-control" id="capacidad" name="capacidad"></input>
                            </div>
                            <div class="col-xs-6">
                             <small><p align="left">Cap&aacute;cidad del Equipo</p></small>
                                </div>
                        </div>
                        
                        <!-- PERIODO MANTENIMIENTO -->
                        <div class="form-group">
                            <label class="control-label col-lg-2" for="telefono_contacto">Periodo:</label>
                            <div class="col-lg-4">
                                <input type="text" value="<?php echo $cntrl->id_inv_equipo; ?>"  placeholder='Periodo en d&iacute;as'
                                       style="text-transform:uppercase;" onkeyup="javascript:this.value = this.value.toUpperCase();" class="form-control" id="periodo" name="periodo"></input>
                            </div>
                            <div class="col-xs-6">
                             <small><p align="left">hasta el proximo mantenimiento</p></small>
                                </div>
                        </div>
                        
                        <!-- SELECT DE DEPENDENCIA-->
                        <div class="form-group">
                            <label class="control-label col-lg-2" for = "dependencia_label">Dependencia:</label>
                            <div class="col-lg-4"> 
                                <select class="form-control input-sm select2" id = "dependencia_select" name="dependencia_select">
                                <option value="<?php echo $cntrl->id_inv_equipo; ?>"></option>
                                <?php foreach ($dependencia as $ubi): ?>
                                    <option value = "<?php echo $ubi->id_dependencia ?>"><?php echo $ubi->dependen ?></option>
                                <?php endforeach; ?>
                            </select>
                            </div>
                        </div>

                        <!-- SELECT DE UBICACION-->
                        <div class="form-group">
                            <label class="control-label col-lg-2" for = "oficina">Ubicación:</label>
                            <div class="col-lg-4"> 
                                <select class="form-control input-sm" id = "oficina_select" name="oficina_select">
                                <option value="<?php echo $cntrl->id_inv_equipo; ?>"><?php echo $cntrl->id_inv_equipo; ?></option>
                            </select>
                            </div>

                        </div>
                         

                          

                        <!-- Fin de Formulario -->

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Guardar</button>
                            <a href="<?php echo base_url() ?>index.php/air_cntrl_mp_equipo/cntrlmp/index" class="btn btn-default">Cancelar</a>
                        </div> 
                    </form>

                    <div class="clearfix"></div> 
                </div>
            </div>
        </div>
        </div>
    </div>
</div>
