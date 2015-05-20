 <script type="text/javascript">
    base_url = '<?=base_url()?>';
</script> 
  <!-- Page content -->
<div class="mainy">
  <!-- Page title -->
  <div class="page-title">
    <h2><i class="fa fa-desktop color"></i> Solicitud<small> Genere una nueva solicitud</small></h2>
    <hr /> 
  </div>

  <!-- Page title -->
  <div class="row">
    <div class="col-md-12">
      <div class="awidget full-width">
        <?php if($this->session->flashdata('create_orden') == 'success') : ?>
              <div class="alert alert-success" style="text-align: center">Solicitud creada con éxito</div>
        <?php endif ?>
       <!-- <?php if($this->session->flashdata('create_orden') == 'error') : ?>
              <div class="alert alert-danger" style="text-align: center">Ocurrió un problema creando su solicitud</div>
        <?php endif ?> -->
            
            
        <div class="awidget-body">
          
          <!-- FORMULARIO DE CREACION DE UNA NUEVA ORDEN DE TRABAJO-->
          <!-- Formulario -->
                       <form class="form-horizontal" action="<?php echo base_url() ?>index.php/mnt_orden/orden/nueva_orden" method="post" name="nueva_orden" id="nueva_orden">
                          <div class="col-lg-12" style="text-align: center">
                                    <?php echo form_error('nombre_contacto'); ?>
                                    <?php echo form_error('telefono_contacto'); ?>
                                    <?php echo form_error('asunto'); ?>
                                    <?php echo form_error('descripcion_general'); ?>
                                    <?php echo form_error('observac'); ?>
                                    <?php echo form_error('oficina'); ?>
                          </div>


                        <!-- SELECT TIPO DE ORDEN -->
                        <div class="form-group">
                            <label class="control-label col-lg-2" for = "id_tipo">Tipo de Orden</label>
                              <select id = "id_tipo" name="id_tipo">
                                <option value="">--SELECCIONE--</option>
                                <?php foreach ($consulta as $ord):?>
                                <option value = "<?php echo $ord ->id_tipo ?>"><?php echo $ord ->tipo_orden ?></option>
                              <?php endforeach; ?>
                              </select>
                        </div>

                        <!-- NOMBRE -->
                        <div class="form-group">
                            <label class="control-label col-lg-2" for="nombre_contacto">Nombre</label>
                            <div class="col-lg-6">
                              <input type="text" class="form-control" id="nombre_contacto" name="nombre_contacto" placeholder='Persona de Contacto'></input>
                            </div>
                        </div>

                        <!-- TELEFONO -->
                        <div class="form-group">
                            <label class="control-label col-lg-2" for="telefono_contacto">Telefono</label>
                            <div class="col-lg-6">
                              <input type="text" class="form-control" id="telefono_contacto" name="telefono_contacto" placeholder='Telefono de Contacto'></input>
                            </div>
                        </div>

                        <!-- ASUNTO -->
                        <div class="form-group">
                            <label class="control-label col-lg-2" for="asunto">Asunto</label>
                            <div class="col-lg-6">
                              <input type="text" class="form-control" id="asunto" name="asunto" placeholder='Asunto'></input>
                            </div>
                        </div>

                        <!-- DESCRIPCION-->
                        <div class="form-group">
                            <label class="control-label col-lg-2" for="descripcion_general">Descripcion</label>
                            <div class="col-lg-6">
                              <textarea rows="3" type="text" class="form-control" id="descripcion_general" name="descripcion_general" placeholder='Breve Descripcion'></textarea>
                            </div>
                        </div>  

                        <!-- OBSERVACION -->
                        <div class="form-group">
                            <label class="control-label col-lg-2" for="observac">Observacion</label>
                            <div class="col-lg-6">
                              <textarea rows="3" type="text" class="form-control" id="observac" name="observac"></textarea>
                            </div>
                        </div> 

                         <!-- UBICACION-->
                        <div class="form-group">
                            <label class="control-label col-lg-2" for = "oficina">Ubicacion</label>
                              <select id = "oficina_select" name="oficina_select" enabled>
                                <option value="">--SELECCIONE--</option>
                                <?php foreach ($query as $ubi):?>
                                <option value = "<?php echo $ubi ->oficina ?>"><?php echo $ubi ->oficina ?></option>
                              <?php endforeach; ?>
                              </select>
                        </div>
                        <div class="form-group">
                          <div class="col-lg-6" >
                            <label class="checkbox-inline">
                              <input type="checkbox" id="otro" value="opcion_1" onclick= "document.nueva_orden.oficina_select.disabled=!document.nueva_orden.oficina_select.disabled,document.nueva_orden.oficina_txt.disabled=!document.nueva_orden.oficina_txt.disabled">Otra Ubicacion
                            </label>
                                                         
                            <div class="control-label">
                              <input type="text" class="form-control" id="oficina_txt" name="oficina_txt" placeholder="Escriba la ubicación" disabled>
                            </div>

                             

                        </div>
                        </div>
                          
                      <!-- Fin de Formulario -->
                       
                       <div class="modal-footer">
                         <button type="submit" class="btn btn-primary">Guardar</button>
                         <a href="<?php echo base_url() ?>index.php/air_home/index" class="btn btn-default">Cancelar</a>
                         
                       </div> 
                      </form>

           <div class="clearfix"></div> 
        </div>
      </div>
    </div>
  </div>
</div>
