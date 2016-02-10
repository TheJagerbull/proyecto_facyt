<div class="mainy">
               <!-- Page title -->
               <div class="page-title">
                  <h2 align="right"><i class="fa fa-tags color"></i>Confirmar solicitud <small>Indique la cantidad de cada articulo</small></h2>
                  <hr />
               </div>
               <!-- End Page title -->
               <!--stepwizard -->
               
                      <div class="stepwizard col-md-offset-3">
                        <div class="stepwizard-row setup-panel">
                          <div class="stepwizard-step">
                            <a href="<?php echo base_url() ?>index.php/solicitud/inventario" type="button" class="btn btn-default btn-circle">1</a>
                            <p>Paso 1</p>
                          </div>

                          <div class="stepwizard-step">
                            <a href="" type="button" class="btn btn-primary btn-circle">2</a>
                            <p>Paso 2</p>
                          </div>

                          <div class="stepwizard-step">
                            <a href="" type="button" class="btn btn-default btn-circle" disabled="disabled">3</a>
                            <p>Paso 3</p>
                          </div>
                        </div>
                      </div>
               <!-- end Stepwizard -->
                <?php if($this->session->flashdata('create_solicitud') == 'error') : ?>
                <div class="alert alert-success" style="text-align: center">Solicitud Guardada con éxito</div>
                <?php endif ?>
              <div class="row">
                <div class="col-md-12">
                  <!-- <div class="form-control"> -->
                  <div class="alert alert-info">
                      <span class="help-block">Su solicitud no sera guardada para la proxima vez que inicie secion, hasta que no haga clic en guardar</span>
                  </div>
                    <form id="main" name="main" action="<?php echo base_url() ?>index.php/solicitud/confirmar" method="post">
                      <div>
                        <div class="col-lg-12" style="text-align: right">
                          <table class="table">
                            <tr>
                              <th>Articulo</th>
                              <th>Descripcion</th>
                              <th>Cantidad</th>
                              <th>Descartar</th>
                            </tr>
                            <input form="main" type="hidden" name="nr" value="<?php echo $nr; ?>" />
                            <?php echo form_error('nr'); ?>
                    <?php foreach ($articulos as $key => $articulo) :?>
                    <form id="remove_<?php echo $key+1; ?>" name="remove_<?php echo $key; ?>" action="<?php echo base_url() ?>index.php/solicitud/remover" method="post">
                    </form>
                            <?php echo form_error('qt'.$key); ?>
                            <tr>
                              <td><?php echo $key+1;?> </td>
                              <td><div class="col-lg-8"><?php echo $articulo->descripcion ?></div></td>
                              <td>
                                <div class="form-group">
                                    <div class="col-lg-6 col-md-10 col-sm-10">
                                      <input form="main" type="text" class="form-control" id="qt<?php echo $key; ?>" name="qt<?php echo $key; ?>"  onkeyup="validateNumber(name)">
                                      <span id="qt<?php echo $key; ?>_msg" class="label label-danger"></span>
                                    </div>
                                  </div>
                              </td>
                              <td align="center">
                                <form id="remove_<?php echo $key+1; ?>" name="remove_<?php echo $key; ?>" action="<?php echo base_url() ?>index.php/solicitud/remover" method="post">
                                  <input form="remove_<?php echo $key+1; ?>" type="hidden" name="ID" value="<?php echo $articulo->ID ?>" />
                                  <button form="remove_<?php echo $key+1; ?>" type="submit"><i class="fa fa-minus" style="color:#D9534F"></i></button>
                                </form>
                              </td>
                           </tr>

                            <input form="main" type="hidden" name="ID<?php echo $key; ?>" value="<?php echo $articulo->ID ?>" />
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
                          <form id="cancel" action="<?php echo base_url() ?>index.php/solicitud/cancelar" method="post">
                        <div class="btn-group">
                          <button form="main" type="submit" class="btn btn-primary">Guardar</button>
                          <!-- <button type="button" onclick="javascript:window.location.href = '<?php echo base_url() ?>index.php/solicitud/inventario'" class="btn btn-danger">Cancelar</button> -->
                            <input form="cancel" type="hidden" name="uri" value="<?php echo base_url() ?>index.php/solicitud/inventario" />
                            <button form ="cancel" type="submit" class="btn btn-danger">Cancelar</button>
                        </div>
                          </form>
                      </div>
                    </form>
                  <!-- </div> -->
                </div>
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