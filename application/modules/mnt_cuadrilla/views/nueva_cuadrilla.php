<script type="text/javascript">
    base_url = '<?= base_url() ?>';
</script> 

<link href= "<?php echo base_url() ?>assets/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css">
<script src="<?php echo base_url() ?>assets/js/jquery.min.js"></script>


<!-- Page content -->
<div class="mainy">
  <!-- Page title -->
  <div class="page-title">
    <h2><i class="fa fa-user color"></i> Nueva<small> Cuadrilla</small></h2> 
    <hr />
  </div>
  <!-- Page title -->
  <div class="row">
    <div class="col-md-12">
      <div class="awidget full-width">
       
             <?php if($this->session->flashdata('new_cuadrilla') == 'success') : ?>
              <div class="alert alert-success" style="text-align: center">La cuadrilla ha sido creada exitosamente.</div>
            <?php endif ?>
            <?php if($this->session->flashdata('new_cuadrilla') == 'error') : ?>
              <div class="alert alert-danger" style="text-align: center">Ocurrió un problema con la Creación de la cuadrilla. Por favor, intentelo nuevamente</div>
            <?php endif ?>
        <div class="awidget-body">
          <!-- FORMULARIO DE CREACION DE USUARIOS PARA CONTROL DE LA APLICACION -->
          <!-- Formulario -->
          <form id="newuser" class="form-horizontal"  enctype="multipart/form-data" action="<?php echo base_url() ?>index.php/mnt_cuadrilla/cuadrilla/crear_cuadrilla" onsubmit="return valida_cuadrilla()" method="post">
                          <div class="col-lg-12" style="text-align: center">
                                    <?php echo form_error('id_trabajador_responsable'); ?>
                                    <?php echo form_error('cuadrilla'); ?>
                                 
                                  </div>
                          <!-- nombre de la cuadrilla -->
                          <div class="form-group">
                            <label class="control-label col-lg-2" for="cuadrilla">Nombre de la cuadrilla</label>
                            <div class="col-lg-5">
                              <input type="text" class="form-control" id="cuadrilla" name="cuadrilla" placeholder='Nombre de la cuadrilla'>
                            </div>
                          </div>
                          <!-- SELECT RESPONSABLE -->
                          <?php $total = count($obreros);
                          ?>
                        <div class="form-group">
                            <label class="control-label col-lg-2" for = "id_trabajador_responsable">Responsable:</label>
                                <div class="col-lg-5"> 
                                    <select class="form-control input-sm select2" id = "id_trabajador_responsable" name="id_trabajador_responsable" onchange="listar_cargo(this.form.id_trabajador_responsable,($('#mostrar')),this.form.cuadrilla)">
                                        <option></option>
                                            <?php foreach ($obreros as $obr): ?>
                                        <option value = "<?php echo $obr['id_usuario'] ?>"><?php echo $obr['nombre'].' '.$obr['apellido']. '  '.'Cargo:'.$obr['cargo'] ?></option>
                                            <?php endforeach; ?>
                                    </select>
                                </div>
                        </div>
                        <div class="form-group">
                            <div id="mostrar">
                               
                            </div>
                        </div>
                        
                       <!-- Fin de Formulario -->
                       
                       <div class="modal-footer">
                         <input onClick="javascript:window.history.back();" type="button" value="Regresar" class="btn btn-info"></>
                         <button type="submit" class="btn btn-success">Agregar</button>
                       </div>
                      </form>
          </div>

          
        </div>
      </div>
    </div>
  </div>
<div class="clearfix"></div>
<script>
   

</script>

