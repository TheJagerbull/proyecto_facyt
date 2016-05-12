<script type="text/javascript">
    base_url = '<?php echo base_url() ?>';
</script> 

<link href= "<?php echo base_url() ?>assets/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css">
<script src="<?php echo base_url() ?>assets/js/jquery.min.js"></script>

<!-- Page content -->
<div class="mainy">
  <!-- Page title -->
  <div class="page-title">
    <?php if (!isset($error)):?>
      <h2 align="right"><i class="fa fa-user color"></i> Nueva<small> Cuadrilla</small></h2> 
     <?php else : ?>
      <h2 align="center" class="alert-danger"><?php echo $error ?> </h2> 
      
      <?php endif;?>
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
        
        <li class="active"><a href="<?php echo base_url() ?>index.php/mnt_cuadrilla/cuadrilla/crear_cuadrilla">Agregar</a></li>
      
      <form class="navbar-form navbar-left" role="search">
        <div class="form-group">
            <input type="text" class="form-control" placeholder="Buscar" disabled>
        </div>
          <button type="reset" class="btn btn-default" disabled>Borrar</button>
      </form>
        </ul>
       <ul class="nav navbar-form navbar-right">
        <a href="<?php echo base_url() ?>index.php/mnt_cuadrilla/listar" class="btn btn-info" data-toggle="modal">Listar</a>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
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
                            <label class="control-label col-lg-2" for="cuadrilla">Nombre:</label>
                            <div class="col-lg-5">
                              <input type="text" class="form-control" id="cuadrilla" name="cuadrilla" placeholder='Nombre de la cuadrilla'>
                            </div>
                          </div>
                          <!-- SELECT RESPONSABLE -->
                          <?php $total = count($obreros);
                          ?>
                        <div class="form-group">
                            <label class="control-label col-lg-2" for = "id_trabajador_responsable">Jefe de cuadrilla:</label>
                                <div class="col-lg-5"> 
                                    <select class="form-control input-sm select2" id = "id_trabajador_responsable" name="id_trabajador_responsable" onchange="listar_cargo(this.form.id_trabajador_responsable,($('#mostrar')),this.form.cuadrilla)">
                                        <option></option>
                                            <?php foreach ($obreros as $obr): ?>
                                        <option value = "<?php echo $obr['nombre'].' '.$obr['apellido'] ?>"><?php echo $obr['nombre'].' '.$obr['apellido']. '  '.'Cargo:'.$obr['cargo'] ?></option>
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
                        <button class="btn btn-default" type="reset">Borrar</button>
<!--                        <input onClick="javascript:window.history.back();" type="button" value="Regresar" class="btn btn-info"></>-->
                        <button type="submit" class="btn btn-primary" onclick="$('#cuadrilla').removeAttr('disabled');">Agregar</button>
                       </div>
                      </form>
          </div>

          
        </div>
      </div>
    </div>
  </div>
<div class="clearfix"></div>


