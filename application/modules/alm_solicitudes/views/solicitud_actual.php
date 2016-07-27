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

        <?php if(!isset($alm)) : ?>
          <div class="alert alert-danger" style="text-align: center"><?php echo $alm;?>no tiene permisos</div>
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
              <form id="none" name="none" action="<?php echo base_url() ?>index.php/solicitud/revisar" method="post"></form>
              <input form="none" type="hidden" id="carrito" name="id_carrito" value="<?php echo $carrito['id_carrito']?>"/>
              <textarea form="none" hidden id="newobservacion" name="observacion"></textarea>
          <form id="main" name="main" action="<?php echo base_url() ?>index.php/solicitud/actual/actualizar/<?php echo $carrito['id_carrito']?>" method="post"><!--cambiar action-->
              
                <div class="col-lg-12 col-md-12 col-sm-12" style="text-align: right">
                  <table class="table">
                    <tr>
                      <th>Articulo</th>
                      <th>Descripcion</th>
                      <th>Cantidad</th>
                      <?php if (sizeof($articulos)>1):?>
                        <?php if($this->session->userdata('user')['id_usuario'] != $carrito['id_usuario']):?>
                          <th>Revisar</th>
                          <th id="showMotiv" hidden  style="text-align:center">Motivo</th>
                        <?php else:?>
                          <th>Descartar</th>
                        <?php endif;?>
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
                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                              <input form="main" type="text" class="form-control" value="<?php echo $articulo['cant']?>" id="qt<?php echo $key; ?>" name="qt<?php echo $key; ?>" onkeyup="validateNumber(name), updateCant('<?php echo $articulo['id_articulo'] ?>', '<?php echo $key; ?>', value);">
                              <span id="qt<?php echo $key; ?>_msg" class="label label-danger"></span>
                            </div>
                          </div>
                      </td>
                      <?php if (sizeof($articulos)>1):?>
<!-- para revision -->  <?php if($this->session->userdata('user')['id_usuario'] != $carrito['id_usuario']):?>
                          <td><button form="none" type="button" onclick="cancelarItem(<?php echo $articulo['id_articulo'] ?>, <?php echo $key ?>)" ><i id="boton<?php echo $articulo['id_articulo'] ?>" class="fa fa-check color"></i></button></td>
                          <td hidden id="motivo<?php echo $key ?>"><textarea form="none" placeholder="Indique el motivo..." rows="2" type="text" class="form-control" name="motivo[<?php echo $articulo['id_articulo'] ?>]"></textarea><span id="motiv<?php echo $key; ?>_msg" class="label label-danger"></span></td>
                          <input form="none" type="hidden" id="cant[<?php echo $articulo['id_articulo'] ?>]" name="cant[<?php echo $articulo['id_articulo'] ?>]" value="<?php echo $articulo['cant']?>"/>
                        <?php else: ?>
                          <td align="center">
                            <form id="remove_<?php echo $key+1; ?>" name="remove_<?php echo $key; ?>" onsubmit="return confirm('Esta seguro que desea eliminar el articulo <?php echo $articulo['descripcion'] ?>?');" action="<?php echo base_url() ?>index.php/solicitud/actual/remover/<?php echo $carrito['id_carrito']?>" method="post">
                              <input form="remove_<?php echo $key+1; ?>" type="hidden" name="id_articulo" value="<?php echo $articulo['id_articulo'] ?>" />
                              <button form="remove_<?php echo $key+1; ?>" onclick="myFunction(<?php $key?>)"><!-- id="warning<?php echo $key?>">--><i class="fa fa-minus" style="color:#D9534F"></i></button>
                            </form>
                          </td>
                      <?php endif;?>
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
              <div class="clearfix"></div>
              <div class="col-md-10 col-sm-10">
                <div class="btn-group">
                  <?php //if($this->session->userdata('user')['id_usuario'] != $carrito['id_usuario']):?>
                    <?php //if(): ?><!-- consultar el permiso -->
                      <button type="button" onclick="revision();" class="btn btn-success">Enviar</button>
                    <?php //endif;?>
                  <?php //else: ?>
                    <button form="main" type="submit" class="btn btn-primary">Guardar</button>
                  <?php //endif;?>
                  
                          <input form="cancel" type="hidden" name="id_usuario" value="<?php echo $this->session->userdata('user')['id_usuario']; ?>" />
                          <input form="cancel" type="hidden" name="id_carrito" value="<?php echo $carrito['id_carrito']?>" />
                          <?php if($this->session->userdata('user')['id_usuario'] != $carrito['id_usuario']):?>
                            <input form="cancel" type="hidden" name="uri" value="solicitud/consultar" />
                          <?php else:?>
                            <input form="cancel" type="hidden" name="uri" value="solicitud/inventario" />
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
          msg.innerHTML = "Debe ser un numero entero positivo";
          // document.getElementById('numero_msg').innerHTML = "Debe ser un numero";
          return false;
        }
    }
    function updateCant(item, posicion, newval)//para actualizar el valor del input de otro formulario (formulario escondido para revision de articulos)
    {
      // console.log(item);
      // console.log(posicion);
      // console.log(newval);
      var input = document.getElementById('cant['+item+']');
      input.value = newval;
      if(newval<1)
      {
        $('#motivo'+posicion).show();
        var visibles = ($('td[id^="motivo"]:visible').length);
        if(visibles > 0)
        {
          $('#showMotiv').show();
        }
        $('#boton'+item).attr("class", "fa fa-times");//pasa a ser un articulo cancelado por el usuario que revisa
        $('#boton'+item).attr("style", "color:#D9534F");
        if(visibles === 0)
        {
          $('#showMotiv').hide();
        }
      }
      if(newval>0)
      {
        $('#motivo'+posicion).hide();
        var visibles = ($('td[id^="motivo"]:visible').length);
        if(visibles > 0)
        {
          $('#showMotiv').show();
        }
        $('#boton'+item).attr("class", "fa fa-check color");//pasa a ser un articulo aprobado por el usuario que revisa
        $('#boton'+item).attr("style", "");
        if(visibles === 0)
        {
          $('#showMotiv').hide();
        }
      }

      // console.log(input);
    }

    function cancelarItem(item, posicion)
    {//linea 86
      $('#motivo'+posicion).toggle();//para que aparezca el campo de motivo al lado del boton que fue presionado
      var visibles = ($('td[id^="motivo"]:visible').length);//cuenta los items con motivo visibles para esconder su respectiva columna en la tabla
      if(visibles > 0)
      {
        $('#showMotiv').show();
      }
      if($('#boton'+item).attr('class')==='fa fa-times')//compara el estado visual del boton, y lo cambia al estado opuesto
      {
        $('#boton'+item).attr("class", "fa fa-check color");//pasa a ser un articulo aprobado por el usuario que revisa
        $('#boton'+item).attr("style", "");
        //cambia el valor del input para evitar revision con valores a 0
        var inputa = document.getElementById('qt'+posicion);
        inputa.value = 1;
        validateNumber(inputa.name);
        var inputb = document.getElementById('cant['+item+']');
        inputb.value = 1;
      }
      else
      {
        $('#boton'+item).attr("class", "fa fa-times");//pasa a ser un articulo cancelado por el usuario que revisa
        $('#boton'+item).attr("style", "color:#D9534F");
      }
      if(visibles === 0)
      {
        $('#showMotiv').hide();
      }
        return false;//para impedir el submit del formulario
    }

    function revision()
    {
      var formulario = document.createElement("FORM");
      // var visibles = ($('td[id^="motivo"]').length)-($('td[id^="motivo"] :hidden').length);
      // for (var i = $('td[id^="motivo"').length - 1; i >= 0; i--) {
      //   console.log($('td[id="motivo'+i+'"] textarea').val());
      // };
      $('#newobservacion').val($('#ob').val())
      // console.log($('#newobservacion').val());
      // console.log($('td[id^="motivo"]:visible > textarea').length);
      var verified=1//para validar el recorrido de todos los textos
      for (var i = $('td[id^="motivo"]:visible').length - 1; i >= 0; i--)//validar los campos de los articulos que fueron cancelados
      {
        // console.log($('td[id^="motivo"]:visible > textarea')[i].value);
        if($('td[id^="motivo"]:visible > textarea')[i].value === '')//verifica el articulo que esta vacio
        {//para los mensajes de validacion
          // <span id="motiv<?php echo $key; ?>_msg" class="label label-danger"></span>
          $('td[id^="motivo"]:visible > textarea')[i].style.background='#F2DEDE';
          verified *=0;//falso
        }
        else
        {
          $('td[id^="motivo"]:visible > textarea')[i].style.background='#DFF0D8';
          verified *=1;//verdadero
        }
      };
      for (var i = $('td[id^="motivo"]:hidden').length - 1; i >= 0; i--)//validar los campos de los articulos que fueron cancelados
      {
        $('td[id^="motivo"]:hidden > textarea')[i].value="";
      };
      if(verified === 1)//si todos dan verdadero, puedo enviar el formulario
      {
        $('#none').submit();//realiza el submit del formulario al finalizar validaciones
      }
      else//sino muestro una alerta de validacion de motivo
      {
        swal({
            title: "Recuerde",
            text: "Debe indicar un motivo a la cancelacion del articulo.",
            type: "warning"
        });
        return false;
      }
    }

</script>