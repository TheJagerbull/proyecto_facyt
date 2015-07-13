<script src="<?php echo base_url() ?>assets/js/jquery.min.js"></script>
<script>
$(document).ready(function(){
    $("#agregar").click(function(){
        $("#lista").toggle();
    });
$(document).ready(function() {
    $('#articulos').DataTable({
    });
} );

});
</script>
<script type="text/javascript">
    base_url = '<?=base_url()?>';
</script>
<div class="mainy">
	<div class="row">
       <!-- Page title -->
       <div class="page-title">
          <!-- <h2 align="right" id="h1"><i class="fa fa-pencil color"></i> Solicitud <small>De Almacen</small></h2> -->
          <h2 align="right" id="p"><i class="fa fa-file color"></i> Solicitud <small>de almacen</small></h2>
          <hr />
       </div>
       <!-- Page title -->
	     <div class="col-md-8 col-sm-8">
	     <?php if($this->session->flashdata('editable') == 'error') : ?>
        <div class="alert alert-warning" style="text-align: center">Esta solicitud no puede ser editada <br/>(solo las solicitudes sin enviar o en proceso pueden ser editadas)</div>
        <?php endif ?>
	    </div>
	    <div class="col-md-9 col-sm-9">
	    	<h3 style="text-align: right">Estado de la solicitud 
	              <?php switch($solicitud['status'])
	              {
	                case 'carrito':
	                  echo ' <span class="label label-danger">sin enviar</span></h3>';
	                break;
	                case 'en_proceso':
	                  echo ' <span class="label label-warning">En Proceso</span></h3>';
	                break;
	                case 'aprobada':
	                  echo ' <span class="label label-success">Aprobada</span></h3>';
	                break;
	                case 'enviado':
	                  echo ' <span class="label label-warning">Enviado a Departamento</span></h3>';
	                break;
	                case 'completado':
	                  echo ' <span class="label label-info">Solicitud Completada</span></h3>';
	                break;
	              }?></h3>
	    </div>
	        <form id="main" name="main" action="<?php echo base_url() ?>index.php/solicitud/actual/actualizar/<?php echo $solicitud['nr_solicitud']?>" method="post"><!--cambiar action-->
              <div class="col-md-12 col-sm-12">
                <div class="col-lg-12" style="text-align: right">
                  <table class="table">
                    <tr>
                      <th>Articulo</th>
                      <th>Descripcion</th>
                      <th>Cantidad</th>
                      <?php if (sizeof($articulos)>1):?>
                      <th>Descartar</th>
                    <?php endif?>
                    </tr>
            <?php foreach ($articulos as $key => $articulo) :?>
            <form id="remove_<?php echo $key+1; ?>" name="remove_<?php echo $key; ?>" action="<?php echo base_url() ?>index.php/solicitud/actual/remover/<?php echo $solicitud['nr_solicitud']?>" method="post">
            </form>
                    <?php echo form_error('qt'.$key); ?>
                    <tr>
                      <td><?php echo $key+1;?> </td>
                      <td><div class="col-lg-8"><?php echo $articulo['descripcion'] ?></div></td>
                      <td>
                        <div class="form-group">
                            <div class="col-lg-4 col-md-4 col-sm-4">
                              <input form="main" type="text" class="form-control" value="<?php echo $articulo['cant']?>" name="qt<?php echo $key; ?>">
                            </div>
                          </div>
                      </td>
                      <?php if (sizeof($articulos)>1):?>
                      <td align="center">
                        <form id="remove_<?php echo $key+1; ?>" name="remove_<?php echo $key; ?>" onsubmit="return confirm('Esta seguro que desea eliminar el articulo <?php echo $articulo['descripcion'] ?>?');" action="<?php echo base_url() ?>index.php/solicitud/actual/remover/<?php echo $solicitud['nr_solicitud']?>" method="post">
                          <input form="remove_<?php echo $key+1; ?>" type="hidden" name="id_articulo" value="<?php echo $articulo['id_articulo'] ?>" />
                          <button form="remove_<?php echo $key+1; ?>" onclick="myFunction(<?php $key?>)"><!-- id="warning<?php echo $key?>">--><i class="fa fa-minus" style="color:#D9534F"></i></button>
                        </form>
                      </td>
                    <?php endif?>
                   </tr>

                    <input form="main" type="hidden" name="ID<?php echo $key; ?>" value="<?php echo $articulo['id_articulo'] ?>" />
            <?php endforeach?>
                  </table>
                </div>
              </div>
              <div class="form-group">
                <div class="col-lg-6">
                <label class="control-label col-lg-2" for="ob">Observacion</label>
                  <textarea form="main" rows="3" type="text" class="form-control" id="ob" name="observacion"></textarea>
                </div>
              </div>
              <div class="clearfix"></div>
              <div class="col-md-10 col-sm-10">
                <div class="btn-group">
                  <button form="main" type="submit" class="btn btn-primary">Guardar</button>
                  <button type="button" onclick="javascript:window.location.href = '<?php echo base_url() ?>index.php/solicitud/consultar'" class="btn btn-danger">Cancelar</button>
                  <button id="agregar" type="button" class="btn btn-success">Agregar articulos</button>
                </div>
              </div>
            </form>

            <br>
            </br>
<!-- Inicio de la lista de articulos-->
              <div hidden id="lista">
                <table id="articulos" class="table table-hover table-bordered">
                      <thead>
                        <tr>
                          <th>Agregar</th>
                          <th>Codigo</th>
                          <th>Descripcion</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php foreach($inventario as $key => $item) : ?>
                          <tr>
                            <td align="center"><?php $aux['id_articulo']= $item->ID;?>
                              <?php if(in_array($aux, $id_articulos)) :?>
                                <i style"color: #398439" class="fa fa-check"></i>
                              <?php else: ?>
                              <form class="form-horizontal" action="<?php echo base_url() ?>index.php/solicitud/actual/agregar/<?php echo $solicitud['nr_solicitud']?>" method="post">
                                <input type="hidden" name="id_articulo" value="<?php echo $item->ID ?>" />
                                <button type="submit"><i class="fa fa-plus color"></i></button>
                              </form>
                              <?php endif; ?>
                            </td>
                            <td><a href="#Modal<?php echo $item->ID ?>" class="btn btn-info" data-toggle="modal"><?php echo $item->cod_articulo ?></a></td>
                            <td><?php echo $item->descripcion ?></td>
                          </tr>
                      <?php endforeach ?>
                      </tbody>
                </table>
               </div>
<!-- Fin de la lista de articulos-->

<!-- PRUEBA DE MODAL TABLA -->
                              
<!-- FIN DE PRUEBA DE MODAL TABLA -->
	</div>
</div>