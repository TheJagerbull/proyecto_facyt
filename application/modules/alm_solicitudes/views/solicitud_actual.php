<script src="<?php echo base_url() ?>assets/js/jquery.min.js"></script>
<script>
$(document).ready(function(){
    $("#agregar").click(function(){
        $("#artInv").modal("show");
    });
$(document).ready(function() {
    $('#articulos').DataTable({
     "language": {
                "url": "<?php echo base_url() ?>assets/js/lenguaje_datatable/spanish.json"
      },
      stateSave: true,
    });
} );

});
</script>
<script type="text/javascript">
    base_url = '<?php echo base_url()?>';
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
	     <div class="col-md-9 col-sm-9">
        <?php if($this->session->flashdata('editable') == 'error') : ?>
          <div class="alert alert-warning" style="text-align: center">Esta solicitud no puede ser editada <br/>(solo las solicitudes sin enviar o en proceso pueden ser editadas)</div>
        <?php endif ?>
        <?php if($this->session->flashdata('saved') == 'success') : ?>
          <div class="alert alert-success" style="text-align: center">Solicitud guardada con éxito</div>
        <?php endif ?>
        <?php if(empty($alm)) : ?>
          <div class="alert alert-danger" style="text-align: center">no tiene permisos</div>
        <?php endif ?>
	    </div>
      <div class="col-lg-12 col-md-12 col-sm-12 col-xm-12">
          <div class="col-lg-5 col-md-5 col-sm-5 col-xm-5">
        <?php if($this->session->userdata('user')['id_usuario'] != $carrito['id_usuario']):?>
              <?php echo '<label for="nombre" class="label label-info">Generado por: </label> <h5 id="nombre" style="text-align: center">'.$user['nombre'].' '.$user['apellido'].'</h5>';?>
        <?php endif;?>
          </div>
  	    <div class="col-lg-7 col-md-7 col-sm-7 col-xm-7">
  	    	<h3 style="text-align: right">Estado de la solicitud 
                <span class="label label-danger">sin enviar</span></h3>
  	    </div>
      </div>
	        <form id="main" name="main" action="<?php echo base_url() ?>index.php/solicitud/actual/actualizar/<?php echo $carrito['id_carrito']?>" method="post"><!--cambiar action-->
              
                <div class="col-lg-12 col-md-12 col-sm-12" style="text-align: right">
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
            <form id="remove_<?php echo $key+1; ?>" name="remove_<?php echo $key; ?>" action="<?php echo base_url() ?>index.php/solicitud/actual/remover/<?php echo $carrito['id_carrito']?>" method="post">
            </form>
                    <?php echo form_error('qt'.$key); ?>
                    <tr>
                      <td><?php echo $key+1;?> </td>
                      <td><div class="col-lg-8"><?php echo $articulo['descripcion'] ?></div></td>
                      <td>
                        <div class="form-group">
                            <div class="col-lg-4 col-md-4 col-sm-4">
                              <input form="main" type="text" class="form-control" value="<?php echo $articulo['cant']?>" id="qt<?php echo $key; ?>" name="qt<?php echo $key; ?>" onkeyup="validateNumber(name)">
                              <span id="qt<?php echo $key; ?>_msg" class="label label-danger"></span>
                            </div>
                          </div>
                      </td>
                      <?php if (sizeof($articulos)>1):?>
                      <td align="center">
                        <form id="remove_<?php echo $key+1; ?>" name="remove_<?php echo $key; ?>" onsubmit="return confirm('Esta seguro que desea eliminar el articulo <?php echo $articulo['descripcion'] ?>?');" action="<?php echo base_url() ?>index.php/solicitud/actual/remover/<?php echo $carrito['id_carrito']?>" method="post">
                          <input form="remove_<?php echo $key+1; ?>" type="hidden" name="id_articulo" value="<?php echo $articulo['id_articulo'] ?>" />
                          <button form="remove_<?php echo $key+1; ?>" onclick="myFunction(<?php $key?>)"><!-- id="warning<?php echo $key?>">--><i class="fa fa-minus" style="color:#D9534F"></i></button>
                        </form>
                      </td>
                    <?php endif?>
                   </tr>

                    <input form="main" type="hidden" name="ID<?php echo $key; ?>" value="<?php echo $articulo['id_articulo'] ?>" />
            <?php endforeach?>
                  <!-- Para agregar mas articulos -->
                  <tr>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td align="center">Agregar</td>
                  </tr>
                  <tr>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td align="center"><button id="agregar" type="button" ><i class="fa fa-plus color"></i></button></td>
                  </tr>
                  <!-- Fin de agregar mas articulos-->
                  </table>
                </div>
              <div class="form-group">
                <div class="col-lg-6 col-md-6 col-sm-6">
                <label class="control-label col-lg-2 col-md-2 col-sm-2" for="ob">Observacion</label>
                  <textarea form="main" rows="3" type="text" class="form-control" id="ob" name="observacion"><?php if(isset($carrito['observacion']) && !empty($carrito['observacion'])){echo $carrito['observacion'];} ?></textarea>
                </div>
              </div>
              <form id="cancel" action="<?php echo base_url() ?>index.php/solicitud/cancelar" method="post">
              </form>
              
              <form id="enviar<?php echo $carrito['id_carrito']?>" action="<?php echo base_url() ?>index.php/solicitud/enviar" method="post">
              </form>
              <div class="clearfix"></div>
              <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
                <div class="btn-group">
                  <button form="main" type="submit" class="btn btn-primary">Guardar</button>
                          <input form="cancel" type="hidden" name="id_usuario" value="<?php echo $this->session->userdata('user')['id_usuario']; ?>" />
                          <input form="cancel" type="hidden" name="id_carrito" value="<?php echo $carrito['id_carrito']?>" />
                          <?php if($this->session->userdata('user')['id_usuario'] != $carrito['id_usuario']):?>
                            <input form="cancel" type="hidden" name="uri" value="solicitud/consultar" />
                          <?php else:?>
                            <input form="cancel" type="hidden" name="uri" value="solicitud/inventario" />
                          <?php endif;?>
                          <?php if(!empty($alm['14'])):?>
                              <input form="enviar<?php echo $carrito['id_carrito']?>" type="hidden" name="id_carrito" value="<?php echo $carrito['id_carrito']; ?>" />
                              <input form="enviar<?php echo $carrito['id_carrito']?>" type="hidden" name="url" value="solicitud/consultar" />
                              <!--<input form="enviar<?php echo $carrito['id_carrito']?>" type="hidden" name="url" value="<?php echo $this->uri->uri_string(); ?>" />-->
                              <input form="enviar<?php echo $carrito['id_carrito']?>" type="hidden" name="id_usuario" value="<?php echo $carrito['id_usuario']; ?>" />
                              <button form="enviar<?php echo $carrito['id_carrito']?>" type="submit" class="btn btn-success">Enviar</button>
                          <?php endif;?>
                  <button form ="cancel" type="submit" class="btn btn-danger">Eliminar</button>
                  <?php if(!empty($solicitudesDependencia) && isset($solicitudesDependencia)):?>
                    <button type="button" onclick="javascript:window.location.href = '<?php echo base_url() ?>index.php/solicitud/consultar'" class="btn btn-warning">Regresar</button>
                  <?php else:?>
                    <button type="button" onclick="javascript:window.location.href = '<?php echo base_url() ?>index.php/solicitud/inventario'" class="btn btn-warning">Regresar</button>
                  <?php endif;?>                  
                </div>
              </div>
            </form>

            <br>
            </br>

<!-- PRUEBA DE MODAL TABLA -->
              <div id="artInv" class="modal modal-message modal-info fade" tabindex="-1" role="dialog" aria-labelledby="mod" aria-hidden="true">
                      <div class="modal-dialog">
                          <div class="modal-content">
                              <div class="modal-header">
                                  <label class="modal-title"><i><img src="<?php echo base_url() ?>assets/img/alm/delivery30.png" class="img-rounded" alt="bordes redondeados" width="45" height="45"></i></label>
                                  <span></span>
                              </div>
                              <div class="modal-body row">

<!-- Inicio de la lista de articulos-->
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
                              <form class="form-horizontal" action="<?php echo base_url() ?>index.php/solicitud/actual/agregar/<?php echo $carrito['id_carrito']?>" method="post">
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
<!-- Fin de la lista de articulos-->
                              </div>
                              <div class="modal-footer">
                              </div>
                          </div> <!-- /.modal-content -->
                      </div> <!-- /.modal-dialog -->
              </div><!-- /.Fin de modal estatus-->
<!-- FIN DE PRUEBA DE MODAL TABLA -->
	</div>
</div>
<script type="text/javascript">
    function validateNumber(x)
    {
        // var numb = /[0-9]$|[0-9]^|[0-9]*/;
        var numb = /^[0-9]+$/;
        var input = document.getElementById(x);
        var msg = document.getElementById(x+"_msg");
          // console.log(input.value);
        if(numb.test(input.value))
        {
          // console.log(input.value);
          input.style.background ='#DFF0D8';
          msg.innerHTML = "";
          // document.getElementById('numero_msg').innerHTML = "";
          return true;
        }
        else
        {
          input.style.background ='#F2DEDE';
          msg.innerHTML = "Debe ser un numero entero";
          // document.getElementById('numero_msg').innerHTML = "Debe ser un numero";
          return false;
        }
    }

</script>