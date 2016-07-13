<script src="<?php echo base_url() ?>assets/js/jquery.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/bootstrap-touchspin.js"></script>
<script src="<?php echo base_url() ?>assets/js/bootstrap-number-input.js"></script>
<script type="text/javascript">
  base_url = '<?php echo base_url()?>';
    $(document).ready(function () {
//        $('[name="motivo"]').hide();
        $("[name='my-checkbox']").bootstrapSwitch();
       
    });
    
    function act_mot(check,motivo){
        if (check[0].checked){
            $(motivo).show();
        }else{
            $(motivo).hide();
        }
       
    }
</script>
<?php $aux = $this->session->userdata('query');
      $aux2 = $this->session->userdata('range');
?>
            <div class="mainy">
                <?php if ($this->session->flashdata('anulada') == 'error') : ?>
                    <div class="alert alert-danger" style="text-align: center">Error... Debe escribir el motivo por el cual anula la solicitud</div>
                <?php endif ?>
                <?php if ($this->session->flashdata('anulada') == 'success') : ?>
                    <div class="alert alert-success" style="text-align: center">Solicitud anulada</div>
                <?php endif ?>
              <!-- Page title -->
              <div class="page-title">
                  <h2 align="right"><i class="fa fa-inbox color"></i> Solicitudes <small>de almacen</small></h2>
                  <hr />
               </div>
               <!-- Page title -->
                
                <div class="row">
        <!-- para delimitar el permiso de ver stodas las solicitudes-->
                <?php if(!empty($permits['alm']['2'])):?>
                  <div class="col-md-9 col-lg-9">
                      <form class="input-group form" action="<?php echo base_url() ?>index.php/administrador/solicitudes<?php echo (!empty($aux)) ? '/filtrar' : '' ?>" method="post">
                              <?php if(!empty($aux)):?>
                              <input type="hidden" name="<?php echo key($this->session->userdata('query'))?>" value="<?php echo (!empty($aux)) ? $this->session->userdata('query')[key($this->session->userdata('query'))] : '' ?>" />
                              <?php endif?>
                              <div class="col-md-6 col-lg-6">  
                                <div class="form-group">
                                  <label class="col-lg-4 control-label">Opciones</label>
                                    
                                    <select id="opciones" name='command' class="form-control">
                                      <option value="blah" selected >...Elija una opcion para mostrar...</option>
                                      <option value="dep" <?php echo (!empty($aux) && (key($this->session->userdata('query')) == 'id_dependencia')) ? 'selected' : '' ?>>Por departamento</option>
                                      <option value="find_usr" <?php echo (!empty($aux) && (key($this->session->userdata('query')) == 'id_usuario')) ? 'selected' : '' ?>>Por usuario (Buscar usuario)</option>
                                      <option value="status" <?php echo (!empty($aux) && (key($this->session->userdata('query')) == 'status')) ? 'selected' : '' ?>>Por estado de la solicitud</option>
                                    </select>
                                </div>
                              </div>
                              <div class="col-md-5 col-lg-5">
                              <table class="table">
                                  <tr>Por fecha</tr>
                                  <tr>
                                    <th>
                                      <div>
                                          <input type="text" readonly style="width: 200px" name="fecha" id="fecha" class="form-control" value="<?php echo (!empty($aux2)) ? $this->session->userdata('range') : 'Fecha' ?>" />
                                          <span class="input-group-btn">
                                           <button type="submit" class="btn btn-info">
                                              <i class="fa fa-calendar"></i>
                                           </button>
                                          </span>            
                                      </div>
                                    </th>
                                  </tr>
                                  <tr>
                                    <th>
                                        <button type="submit" class="btn btn-primary">Consultar</button>
                                    </th>
                                    <th>
                                      <a class="btn btn-warning" href="<?php echo base_url() ?>index.php/administrador/solicitudes/reiniciar">reiniciar</a>
                                    </th>
                                    <th>
                                        <button onclick="change(); submit" type="button" class="btn btn-danger" align="right">Limpiar</button>
                                    </th>
                                  </tr>
                              </table>
                            </div>
                              
                      </form>
                  </div>
        <!--Fin de limitacion para permisos de ver todas las solicitudes -->
                 </div>
                 <!--<?php //if(isset($command) && ($command == 'find_usr')):?>-->
                 <div id="blah" style="display:none" class="opcional col-lg-5">
                  <!--esta Area es para control sobre el script de custom.js-->
                  </div>
                  <!-- Este de el campo de busqueda de usuario -->
                      <div id="find_usr" style="display:none" class="opcional col-lg-5">
                        <form id="ACquery" class="input-group form" action="<?php echo base_url() ?>index.php/administrador/solicitudes/filtrar" method="post">
                          <input type="hidden" name="command" value="find_usr" />
                          <input type="hidden" name="fecha" value="<?php echo (!empty($aux2)) ? $this->session->userdata('range') : 'Fecha' ?>" />
                          <input id="autocomplete" type="search" name="usuarios" class="form-control" placeholder="Cedula... o Nombre... o Apellido...">
                            <span class="input-group-btn">
                              <button type="submit" class="btn btn-info">
                                <i class="fa fa-search"></i>
                              </button>
                            </span>
                        </form>
                      </div>
                      <!-- Este de el campo de busqueda por departamento -->
                      <div id="dep" style="display:none" class="opcional col-lg-5">
                        <form class="input-group form" action="<?php echo base_url() ?>index.php/administrador/solicitudes/filtrar" method="post">
                          <input type="hidden" name="command" value="dep" />
                          <input type="hidden" name="fecha" value="<?php echo (!empty($aux2)) ? $this->session->userdata('range') : 'Fecha' ?>" />
                          <?php echo $dependencia ?>
                          <!-- <select name="id_dependencia" onchange="submit()">
                              <option value="" selected >--SELECCIONE--</option> -->
                              <?php //foreach ($dependencia as $dep): ?>
                                  <!-- <option value = "<?php echo $dep->id_dependencia ?>"><?php echo $dep->dependen ?></option> -->
                              <?php //endforeach; ?>
                          <!-- </select> -->
                        </form>
                      </div>
                      <!-- Este de el campo de busqueda por estado de solicitud -->
                      <div id="status" style="display:none" class="opcional col-lg-5">
                        <form class="input-group form" action="<?php echo base_url() ?>index.php/administrador/solicitudes/filtrar" method="post">
                          <input type="hidden" name="command" value="status" />
                          <input type="hidden" name="fecha" value="<?php echo (!empty($aux2)) ? $this->session->userdata('range') : 'Fecha' ?>" />
                          <select name="status" class="form-control" >
                            <option value="en_proceso">En proceso</option>
                            <option value="aprobada">Aprobada</option>
                            <option value="enviado">Enviado a departamento</option>
                            <option value="completado">Solicitud completada</option>
                          </select>
                            <span class="input-group-btn">
                              <button type="submit" class="btn btn-info">
                                <i class="fa fa-search"></i>
                              </button>
                            </span>
                        </form>
                      </div>
                <?php endif;?>
                      <!--
                      case 'en_proceso':
                        echo '<td><span class="label label-warning">En proceso</span></td>';
                      break;
                      case 'aprobada':
                        echo '<td><span class="label label-success">Aprobada</span></td>';
                      break;
                      case 'enviado':
                        echo '<td><span class="label label-warning">Enviado a departamento</span></td>';
                      break;
                      case 'completado':
                        echo '<td><span class="label label-info">Solicitud completada</span></td>';
                      break;
                    -->
                    <!--<?php //endif ?>-->
                  <div class="row">
                     <div class="col-md-12">
                  <?php if($this->session->flashdata('solicitudes') == 'error') : ?>
                    <div class="alert alert-danger" style="text-align: center">No se encontraron solicitudes</div>
                  <?php endif ?>
                  <?php if(empty($solicitudes)):?>
                    <div class="alert alert-warning" style="text-align: center">No hay solicitudes
                      <?php if(empty($permits['alm']['13']) && empty($permits['alm']['12']) && !empty($permits['alm']['2'])){echo '.';}?>
                      <?php if(empty($permits['alm']['2']) && !empty($permits['alm']['13'])){echo ' para despachar.';}?>
                      <?php if(empty($permits['alm']['2']) && !empty($permits['alm']['12'])){echo ' para aprobar.';}?>
                      
                    </div>
                  <?php endif;?>
                        <div class="awidget full-width">
                           <div class="awidget-head">
                              <h3>Últimas solicitudes recibidas</h3>
                             
                           </div>
                           <div class="awidget-body">
                              <?php echo $links; ?>
                              <table class="table table-hover table-bordered ">
                               <thead>
                                 <tr>
                                   <th><a href="<?php echo base_url() ?>index.php/administrador/solicitudes/orden/<?php if($this->uri->segment(3)=='filtrar' || $this->uri->segment(4)=='filtrar') echo 'filtrar/'; ?>orden_sol/<?php echo $order ?>/0">Solicitud</a></th>
                                   <th><a href="<?php echo base_url() ?>index.php/administrador/solicitudes/orden/<?php if($this->uri->segment(3)=='filtrar' || $this->uri->segment(4)=='filtrar') echo 'filtrar/'; ?>orden_fecha/<?php echo $order ?>/0">Fecha generada</a></th>
                                   <th><a href="<?php echo base_url() ?>index.php/administrador/solicitudes/orden/<?php if($this->uri->segment(3)=='filtrar' || $this->uri->segment(4)=='filtrar') echo 'filtrar/'; ?>orden_gen/<?php echo $order ?>/0">Generado por:</a></th>
                                   <!--<th><a href="<?php echo base_url() ?>index.php/administrador/solicitudes/orden/<?php if($this->uri->segment(3)=='filtrar' || $this->uri->segment(4)=='filtrar') echo 'filtrar/'; ?>orden_rol/<?php echo $order ?>/0">Rol en sistema</a></th>-->
                                   <th><a href="<?php echo base_url() ?>index.php/administrador/solicitudes/orden/<?php if($this->uri->segment(3)=='filtrar' || $this->uri->segment(4)=='filtrar') echo 'filtrar/'; ?>orden_stad/<?php echo $order ?>/0">Estado de solicitud</a></th>
                                 </tr>
                               </thead>
                               <tbody>

                                <?php foreach ($solicitudes as $key => $solicitud):
                                    if(!empty($permits['alm']['12'])&& !empty($permits['alm']['13'])):?>
                                         <tr>
                                   <td><a href='#sol<?php echo $solicitud['nr_solicitud'] ?>' data-toggle="modal"><?php echo $solicitud['nr_solicitud']; ?></a></td>
                                   <td><?php echo date("d/m/Y", strtotime($solicitud['fecha_gen'])); ?></td>
                                   <td><a href='#us<?php echo $solicitud['id_usuario'] ?>' data-toggle="modal"><?php echo $solicitud['nombre']." ".$solicitud['apellido']; ?></a></td>
                                    <?php 
//                                          switch($solicitud['sys_rol'])
//                                          {
//                                            case 'autoridad':
//                                              echo '<td>Autoridad</td>';
//                                            break;
//                                            case 'asist_autoridad':
//                                              echo '<td>Asistente de autoridad</td>';
//                                            break;
//                                            case 'jefe_alm':
//                                              echo '<td>Jefe de almacen</td>';
//                                            break;
//                                            case 'director_dep':
//                                              echo '<td>Director de departamento</td>';
//                                            break;
//                                            case 'asistente_dep':
//                                              echo '<td>Asistente de departamento</td>';
//                                            break;
//                                            case 'ayudante_alm':
//                                              echo '<td>Ayudante de almacen</td>';
//                                            break;
//                                          }
                                          ?>
                                          <?php 
                                          switch($solicitud['status'])
                                          {
                                            case 'carrito':
                                              echo '<td><span class="label label-danger">sin enviar</span></td>';
                                            break;
                                            case 'en_proceso':
                                              echo '<td><span class="label label-warning">En proceso</span></td>';
                                            break;
                                            case 'aprobada':
                                              echo '<td><span class="label label-success">Aprobada</span></td>';
                                            break;
                                            case 'enviado':
                                              echo '<td><span class="label label-warning">Enviado a departamento</span></td>';
                                            break;
                                            case 'completado':
                                              echo '<td><span class="label label-info">Solicitud completada</span></td>';
                                            break;
                                          }?>
                                   
                                   <!--<td><span class="label label-success"> </span></td>-->
                                 </tr>
                                                                      
                                   <?php elseif(!empty($permits['alm']['13'])):
//                                       if($solicitud['status'] == 'aprobada'):?> 
                                   
                                <tr>
                                   <td><a href='#sol<?php echo $solicitud['nr_solicitud'] ?>' data-toggle="modal"><?php echo $solicitud['nr_solicitud']; ?></a></td>
                                   <td><?php echo date("d/m/Y", strtotime($solicitud['fecha_gen'])); ?></td>
                                   <td><a href='#us<?php echo $solicitud['id_usuario'] ?>' data-toggle="modal"><?php echo $solicitud['nombre']." ".$solicitud['apellido']; ?></a></td>
                                    <?php 
//                                          switch($solicitud['sys_rol'])
//                                          {
//                                            case 'autoridad':
//                                              echo '<td>Autoridad</td>';
//                                            break;
//                                            case 'asist_autoridad':
//                                              echo '<td>Asistente de autoridad</td>';
//                                            break;
//                                            case 'jefe_alm':
//                                              echo '<td>Jefe de almacen</td>';
//                                            break;
//                                            case 'director_dep':
//                                              echo '<td>Director de departamento</td>';
//                                            break;
//                                            case 'asistente_dep':
//                                              echo '<td>Asistente de departamento</td>';
//                                            break;
//                                            case 'ayudante_alm':
//                                              echo '<td>Ayudante de almacen</td>';
//                                            break;
//                                          }
                                          ?>
                                          <?php 
                                          switch($solicitud['status'])
                                          {
                                            case 'carrito':
                                              echo '<td><span class="label label-danger">sin enviar</span></td>';
                                            break;
                                            case 'en_proceso':
                                              echo '<td><span class="label label-warning">En proceso</span></td>';
                                            break;
                                            case 'aprobada':
                                              echo '<td><span class="label label-success">Aprobada</span></td>';
                                            break;
                                            case 'enviado':
                                              echo '<td><span class="label label-warning">Enviado a departamento</span></td>';
                                            break;
                                            case 'completado':
                                              echo '<td><span class="label label-info">Solicitud completada</span></td>';
                                            break;
                                          }?>
                                   
                                   <!--<td><span class="label label-success"> </span></td>-->
                                 </tr>
                                 <?php // endif ?>
                                 <?php elseif(!empty($permits['alm']['12'])):?>
                                     <tr>
                                   <td><a href='#sol<?php echo $solicitud['nr_solicitud'] ?>' data-toggle="modal"><?php echo $solicitud['nr_solicitud']; ?></a></td>
                                   <td><?php echo date("d/m/Y", strtotime($solicitud['fecha_gen'])); ?></td>
                                   <td><a href='#us<?php echo $solicitud['id_usuario'] ?>' data-toggle="modal"><?php echo $solicitud['nombre']." ".$solicitud['apellido']; ?></a></td>
                                    <?php 
//                                          switch($solicitud['sys_rol'])
//                                          {
//                                            case 'autoridad':
//                                              echo '<td>Autoridad</td>';
//                                            break;
//                                            case 'asist_autoridad':
//                                              echo '<td>Asistente de autoridad</td>';
//                                            break;
//                                            case 'jefe_alm':
//                                              echo '<td>Jefe de almacen</td>';
//                                            break;
//                                            case 'director_dep':
//                                              echo '<td>Director de departamento</td>';
//                                            break;
//                                            case 'asistente_dep':
//                                              echo '<td>Asistente de departamento</td>';
//                                            break;
//                                            case 'ayudante_alm':
//                                              echo '<td>Ayudante de almacen</td>';
//                                            break;
//                                          }
                                          ?>
                                          <?php 
                                          switch($solicitud['status'])
                                          {
                                            case 'carrito':
                                              echo '<td><span class="label label-danger">sin enviar</span></td>';
                                            break;
                                            case 'en_proceso':
                                              echo '<td><span class="label label-warning">En proceso</span></td>';
                                            break;
                                            case 'aprobada':
                                              echo '<td><span class="label label-success">Aprobada</span></td>';
                                            break;
                                            case 'anulado':
                                              echo '<td><span class="label label-danger">Solicitud anulada</span></td>';
                                            break;
                                            case 'enviado':
                                              echo '<td><span class="label label-warning">Enviado a departamento</span></td>';
                                            break;
                                            case 'completado':
                                              echo '<td><span class="label label-info">Solicitud completada</span></td>';
                                            break;
                                          }?>
                                   
                                   <!--<td><span class="label label-success"> </span></td>-->
                                 </tr>
                                 <?php endif; ?>
                               <?php endforeach ?>
                               </tbody>
                             </table>
                              <?php echo $links; ?>
                                <?php foreach ($solicitudes as $key => $solicitud):?>
                                <!-- Modal de articulos -->
                                 <div id="sol<?php echo $solicitud['nr_solicitud'] ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                      <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                                            <h4 class="modal-title">Numero de solicitud <?php echo $solicitud['nr_solicitud'];?></h4>
                                            <h3><i class="fa fa-time color"></i><?php echo date("d/m/Y", strtotime($solicitud['fecha_gen']))." a las".date(" H:i:s", strtotime($solicitud['fecha_gen'])); ?></h3>
                                          </div>
                                          <div class="modal-body">
                                                                     
                                            <form class="form" id="aprueba<?php echo $solicitud['nr_solicitud'];?>" name="aprueba" action="<?php echo base_url() ?>index.php/alm_solicitudes/aprobar" method="post"> 
                                            <!-- Profile form -->
                                            <div class="table-responsive">
                                                <table id="tblGrid" class="table table-hover table-bordered table-condensed">
                                                <thead>
                                                      <tr>                                                        
                                                        <th rowspan="2" valign="middle"><div align="center">Item</div></th>
                                                        <th rowspan="2" valign="middle"><div align="center">Descripcion</div></th>
                                                        <th rowspan="2" valign="middle"><div align="center">Solicitados</div></th>
                                                       <?php if(!empty($permits['alm']['12'])): ?>
                                                            <th colspan="2" valign="middle"><div align="center">Disponibles</div></th>
                                                       <?php endif ?>
                                                        <th colspan="1"><div align="center">Aprobados</div></th>
                                                        <th rowspan="2" valign="middle"><div align="center">Por despachar</div></th>
                                                    </tr>
                                                    <tr>  
                                                       <?php if(!empty($permits['alm']['12'])): ?>
                                                            <th><div align="center">nuevos|usados</div></th>
                                                        <!--<th><div align="center">usados</div></th>-->
                                                             <th><div align="center">Existencia</div></th>
                                                            <th><div align="center">nuevos    |    usados</div></th>
                                                            <!--<th><div align="center">usados</div></th>-->              
                                                       <?php endif ?>
                                                    </tr>

                                                </thead>
                                                <tbody>
                                                  <?php foreach ($articulos[$solicitud['nr_solicitud']] as $i => $articulo) :?>
                                                    <tr>
                                                        <td><div align="center"><?php echo $articulo['id_articulo']?></div></td>
                                                        <td><?php echo $articulo['descripcion']?></td>
                                                        <td><div align="center"><?php echo $articulo['cant']?></div></td>
                                                        <?php if(!empty($permits['alm']['12'])): ?>
                                                            <td><div align="center"><?php echo $articulo['nuevos'].' | '.$articulo['usados']?></div></td>
                                                            <td><div align="center"><?php echo $articulo['disp']?></div></td>
                                                        <?php endif ?>
                                                        <td>
                                                            <div align="center">
                                                              <?php if(($solicitud['status']!='completado') && (!empty($permits['alm']['12']))):?>
                                                                <div class="col-xs-6"><input form="aprueba<?php echo $solicitud['nr_solicitud'];?>" style="pointer-events: none;" class="form-control input-sm" id="nuevos<?php echo $solicitud['nr_solicitud'].$articulo['id_articulo']; ?>" type="text" value="" name="nuevos[<?php echo $articulo['id_articulo']; ?>]"></div>
                                                                <div class="col-xs-6"><input form="aprueba<?php echo $solicitud['nr_solicitud'];?>" style="pointer-events: none;" class="form-control input-sm" id="usados<?php echo $solicitud['nr_solicitud'].$articulo['id_articulo']; ?>" type="text" value="" name="usados[<?php echo $articulo['id_articulo']; ?>]"></div>
<!--                                                            <div class="col-xs-6">
                                                                <input style="pointer-events: none;" name="nuevos[<?php echo $articulo['id_articulo']; ?>]" id="nuevo<?php echo $articulo['id_articulo']; ?>" class="form-control input-sm" type="number"  min="0" <?php if($articulo['cant_nuevos']!=0):?>value=" <?php echo $articulo['cant_nuevos']?>"<?php else:?>value="0"<?php endif; if($articulo['cant'] > $articulo['nuevos']):?> max= "<?php echo $articulo['nuevos']+1;?>"<?php else:?> max="<?php echo $articulo['cant'];?>"<?php endif;?> />
                                                            </div>
                                                            <div class="col-xs-6">
                                                                <input style="pointer-events: none;" name="usados[<?php echo $articulo['id_articulo']; ?>]" id="usado<?php echo $articulo['id_articulo']; ?>" class="form-control input-sm" type="number"  min="0" <?php if($articulo['cant_usados']!=0):?>value=" <?php echo $articulo['cant_usados']?>"<?php else:?>value="0"<?php endif; if($articulo['cant'] > $articulo['usados']):?> max= "<?php echo $articulo['usados'];?>"<?php else:?> max="<?php echo $articulo['cant'];?>"<?php endif;?> />
                                                            </div>
                                                            <script>
                                                                $('#usado<?php echo $articulo['id_articulo']; ?>').bootstrapNumber();
                                                                $('#nuevo<?php echo $articulo['id_articulo']; ?>').bootstrapNumber({
//                                                                    upClass: 'success',
//                                                                    downClass: 'danger',                    
                                                                });
                                                                $("#usado<?php echo $articulo['id_articulo']; ?>").bind('keyup mouseup', function () {
                                                                     alert("changed"); 
//                                                                  
                                                                });
//                                                                $("#nuevo<?php echo $articulo['id_articulo']; ?>").on('change', function () {
//                                                                    var nuevos = <?php echo $articulo['cant']?> - $("input[name='usados[<?php echo $articulo['id_articulo']; ?>]']").val();
//                                                                    console.log($("input[name='usados[<?php echo $articulo['id_articulo']; ?>]']").val());
//                                                                    console.log($("#usado<?php echo $articulo['id_articulo']; ?>").val());
//                                                                    $("input[name='nuevos[<?php echo $articulo['id_articulo']; ?>]']").trigger("touchspin.updatesettings", {max: nuevos});
////                                                                    console.log();
//                                                                });
                                                            </script>-->
                                                                <script>//Este script es para hacer funcionar el TouchSpin
                                                                    
                                                                    $("#usados<?php echo $solicitud['nr_solicitud'].$articulo['id_articulo']; ?>").TouchSpin({
                                                                        min:0, //Valor minimo del input 
                                                                       <?php if($articulo['cant_usados']!=0):?> //Se evalua la cantidad de aprobados para el valor inicial del input
                                                                            initval: <?php echo $articulo['cant_usados']?>,
                                                                        <?php else:?>
                                                                            initval: 0,
                                                                        <?php endif;
                                                                        if($articulo['cant'] > $articulo['usados']):?>
                                                                          <?php if($articulo['cant_usados'] < $articulo['usados']):?>
                                                                              max: <?php echo $articulo['usados']?>, //Se limita el valor maximo
                                                                          <?php else: ?>
                                                                              max: <?php echo $articulo['cant_usados']?>
                                                                          <?php endif; ?>
                                                                        <?php else:?>
                                                                            max:<?php echo $articulo['cant']?>,                                                                      
                                                                        <?php endif;?>                                                        
                                                                    });                                                               
                                                                    $("#nuevos<?php echo $solicitud['nr_solicitud'].$articulo['id_articulo']; ?>").TouchSpin({
                                                                        min:0, //Valor minimo del input 
                                                                       <?php if($articulo['cant_nuevos']!=0):?> //Se evalua la cantidad de aprobados para el valor inicial del input
                                                                            initval: <?php echo $articulo['cant_nuevos']?>,
                                                                        <?php else:?>
                                                                            initval: 0,
                                                                        <?php endif;
                                                                        if($articulo['cant'] > $articulo['nuevos']):?>
                                                                          <?php if($articulo['cant_nuevos'] < $articulo['nuevos']):?>
                                                                              max: <?php echo $articulo['nuevos']?>, //Se limita el valor maximo
                                                                          <?php else: ?>
                                                                              max: <?php echo $articulo['cant_nuevos']?>
                                                                          <?php endif; ?>
                                                                        <?php endif;
                                                                         if($articulo['cant'] <= $articulo['nuevos']):?>
                                                                            max:<?php echo $articulo['cant']?>,
                                                                        <?php endif;?>                                                                                                
                                                                    });
                                                                     var total = 0;
    //                                                                console.log(total);
    //                                                                var tota1 = 0;
                                                                    $("#nuevos<?php echo $solicitud['nr_solicitud'].$articulo['id_articulo']; ?>, #usados<?php echo $solicitud['nr_solicitud'].$articulo['id_articulo']; ?>").on("touchspin.on.startspin", function() {
    //                                                                    var tota = [<?php echo $articulo['cant']?>];
    //                                                                    total = tota - $("input[name='nuevos[<?php echo $articulo['id_articulo']; ?>]']").val();
    //                                                                    console.log(total);
                                                                        // var nuevo = $("input[name='nuevos[<?php echo $articulo['id_articulo']; ?>]']").val();
                                                                        // var usado = $("input[name='usados[<?php echo $articulo['id_articulo']; ?>]']").val();
                                                                        var nuevo = $("#nuevos<?php echo $solicitud['nr_solicitud'].$articulo['id_articulo']; ?>").val();
                                                                        var usado = $("#usados<?php echo $solicitud['nr_solicitud'].$articulo['id_articulo']; ?>").val();
                                                                        var req = <?php echo $articulo['cant']?>;
                                                                        var resultado = (parseInt(nuevo)+parseInt(usado));
                                                                        console.log('usados'+usado);
                                                                        console.log('nuevos'+nuevo);
                                                                        console.log('resultado'+resultado);
                                                                        console.log('solicitado'+req);//HATA AQUI
                                                                        var maxnuevos = <?php echo $articulo['nuevos']?>;
                                                                        var maxusados = <?php echo $articulo['usados']?>;
                                                                        // $("#nuevos<?php echo $solicitud['nr_solicitud'].$articulo['id_articulo']; ?>").trigger('touchspin.updatesettings', {max: parseInt(req-usado)});
                                                                        if (resultado === req+1)
                                                                        {
                                                                            var maxLL = 4;
                                                                            console.log("dentro "+nuevo);
                                                                            if(nuevo>usado)
                                                                            {
                                                                                nuevo = nuevo-1;
                                                                            }
                                                                            else
                                                                            {
                                                                                usado = usado-1;
                                                                            }
                                                                            $("#nuevos<?php echo $solicitud['nr_solicitud'].$articulo['id_articulo']; ?>").val(nuevo);//    'max', $("#nuevos<?php echo $solicitud['nr_solicitud'].$articulo['id_articulo']; ?>").val());
                                                                            $("#nuevos<?php echo $solicitud['nr_solicitud'].$articulo['id_articulo']; ?>").trigger("touchspin.updatesettings", {max: nuevo});
                                                                            $("#usados<?php echo $solicitud['nr_solicitud'].$articulo['id_articulo']; ?>").val(usado);//    'max', $("#usados<?php echo $solicitud['nr_solicitud'].$articulo['id_articulo']; ?>").val());
                                                                            $("#usados<?php echo $solicitud['nr_solicitud'].$articulo['id_articulo']; ?>").trigger("touchspin.updatesettings", {max: usado});
                                                                            $(function(){
                                                                                 
    //                                                                            $("input[type='number']").prop('min',1);
    //                                                                            $("input[type='number']").prop('max',0);
                                                                                  $("input[name='nuevos[<?php echo $articulo['id_articulo']; ?>]'], input[name='usados[<?php echo $articulo['id_articulo']; ?>]']").trigger("touchspin.settings", {max: 3});
                                                                                  console.log($("input[name='nuevos[<?php echo $articulo['id_articulo']; ?>]']").trigger("touchspin.settings"));
                                                                                  console.log('hola2');
                                                                            });
    //                                                                      $("#nuevo<?php echo $articulo['id_articulo']; ?> , #usados<?php echo $articulo['id_articulo']; ?>").prop("disable", false); 
    //                                                                      $("input[name='nuevos[<?php echo $articulo['id_articulo']; ?>]'], input[name='usados[<?php echo $articulo['id_articulo']; ?>]']").trigger("touchspin.updatesettings", {max: 0});
                                                                            console.log(resultado);
                                                                        }
    //                                                                    console.log(parseFloat(nuevo)+parseFloat(usado));
    //                                                                    console.log(usado);
    //                                                                    if (tota1 == 0){
    //                                                                        $("input[name='usados[<?php echo $articulo['id_articulo']; ?>]']").trigger("touchspin.updatesettings", {max: total});
    //                                                                    }
    //                                                                    console.log(max);
                                                                    });

    //                                                                $("input[name='usados[<?php echo $articulo['id_articulo']; ?>]']").on('change', function () {
    //                                                                    var tota = <?php echo $articulo['cant']?>;
    //                                                                    total = tota - $("input[name='usados[<?php echo $articulo['id_articulo']; ?>]']").val();
    //                                                                    console.log(total);
    ////                                                                    if(total< total){
    //                                                                    $("input[name='nuevos[<?php echo $articulo['id_articulo']; ?>]']").trigger("touchspin.updatesettings", {max: total});
    ////                                                                    console.log();
    ////                                                                    }
    //                                                                });

                                                                 
                                                                    // $("input[name='nuevos[<?php echo $articulo['id_articulo']; ?>]']").on('change', function () {});
                                                                    // $("input[name='nuevos[<?php echo $articulo['id_articulo']; ?>]']").trigger("touchspin.updatesettings", {max: <?php echo $articulo['cant']?>-$("input[name='usados[<?php echo $articulo['id_articulo']; ?>]']").val()});
                                                                    // $("input[name='usados[<?php echo $articulo['id_articulo']; ?>]']").trigger("touchspin.updatesettings", {max: <?php echo $articulo['cant']?>-$("input[name='nuevos[<?php echo $articulo['id_articulo']; ?>]']").val()});
                                                                </script>
                                                              <?php else :?>
                                                                <?php if(!empty($permits['alm']['12'])): ?>
                                                                    <div class="col-xs-6"><?php echo $articulo['cant_nuevos']?></div>
                                                                    <div class="col-xs-6"><?php echo $articulo['cant_usados']?></div>
                                                                <?php else: ?>    
                                                                      <div align="center"><?php echo $articulo['reserv']?></div>
                                                                <?php endif ?>    
                                                              <?php endif;?>
                                                            </div>
                                                        </td>
                                                        <td><div align="center"><?php echo $articulo['reserv']?></div></td>
                                                    </tr>
                                                  <?php endforeach ?>
                                                </tbody>
                                                </table>
                                            </div>
                                                <div class="modal-footer">
                                                    <input  type="hidden" name="nr_solicitud" value="<?php echo $solicitud['nr_solicitud']; ?>" />
                                                    <input  type="hidden" name="uri" value="<?php echo $this->uri->uri_string() ?>"/>
                                                    <div align="center" class = "col-md-12">
                                                      <!-- Observacion de la solicitud -->
                                                        <?php if(isset($solicitud['observacion']) && !empty($solicitud['observacion'])):?>
                                                            <label class="control-label col-lg-1" for="observacion">Nota: </label>
                                                            <div class="col-lg-11" align="left"><?php echo $solicitud['observacion'];?></div>
                                                            <br>
                                                            <br>
                                                            <hr>
                                                        <?php endif;?>
                                                        <?php 
                                                            switch($solicitud['status'])
                                                            {
                                                            case 'en_proceso':?>
                                                            <div class="col-md-12"><strong>Anular Solicitud </strong><input data-on-text="Si" data-off-text="No" value="SI" type="checkbox" name="my-checkbox" id="check<?php echo $solicitud['nr_solicitud']; ?>" data-size="small" unchecked onChange="act_mot($('#check<?php echo $solicitud['nr_solicitud']; ?>'),$('#motivo<?php echo $solicitud['nr_solicitud']; ?>'))">
                                                                <div class="col-md-12"><br></div>
                                                                <div id="motivo<?php echo $solicitud['nr_solicitud']; ?>" name="motivo" class="col-md-12" style="display:none;">
                                                                    <textarea class="form-control" name="motivo"></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12"><br></div>
                                                                <button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Cancelar</button>
                                                             <?php   if(!empty($permits['alm']['12']))//habilita el boton de aprobar
                                                                {
                                                                  echo '<button form="aprueba'.$solicitud['nr_solicitud'].'" type="submit" class="btn btn-success">Guardar</button>';
                                                                }
                                                            break;
                                                            case 'aprobada':?>
                                                                <?php if(!empty($permits['alm']['13'])):?>
                                                                <form method="post"> 
                                                                </form>
                                                                   <form class="form" id="despacha<?php echo $solicitud['nr_solicitud'];?>" name="despacha" action="<?php echo base_url() ?>index.php/alm_solicitudes/despachar" method="post"> 
                                                                    
                                                                    <div class="form-group">
                                                                    <label class="control-label col-lg-4" for="recibido"><i class="color">*  </i>Recibido por:</label>
                                                                    <div class="col-lg-6">
                                                                        <select form="despacha<?php echo $solicitud['nr_solicitud'];?>" class="form-control input select2" id="recibido" name="id_usuario" required>
                                                                        <option></option>
                                                                        <?php foreach ($act_users as $all):
                                                                            // if (($this->session->userdata('user')['id_usuario'])!= $all['id_usuario']):?>
                                                                             <option value="<?php echo ucfirst($all['id_usuario'])?>"><?php echo ucfirst($all['nombre']) . ' ' . ucfirst($all['apellido']) ?></option>
                                                                        <?php 
                                                                            // endif;
                                                                        endforeach; ?>
                                                                    </select>
                                    
                                                                    </div>
                                                                    </div>
                                                        <hr>
                                                        <br>
                                                                
                                                                <div class="col-lg-12">
                                                                    <button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Cancelar</button>
                                                                        <?php if(!empty($permits['alm']['12'])):?>
                                                                            <button form="aprueba<?php echo $solicitud['nr_solicitud'];?>" type="submit" class="btn btn-success">Guardar</button>
                                                                    <?php endif;?>
                                                                        <input form="despacha<?php echo $solicitud['nr_solicitud'];?>" type="hidden" name="nr_solicitud" value="<?php echo $solicitud['nr_solicitud']; ?>" />
                                                                        <input form="despacha<?php echo $solicitud['nr_solicitud'];?>" type="hidden" name="uri" value="<?php echo $this->uri->uri_string() ?>"/>
                                                                        <button form="despacha<?php echo $solicitud['nr_solicitud'];?>" type="submit" class="btn btn-warning">Despachar</button>
                                                                </div>
                                                                    </form>
                                                              <?php elseif(!empty($permits['alm']['12'])):?>
                                                                        <button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Cancelar</button>
                                                                        <button form="aprueba<?php echo $solicitud['nr_solicitud'];?>" type="submit" class="btn btn-success">Guardar</button>
                                                                    <?php endif;?>
                                                            <?php 
                                                            break;
                                                            case 'completado':
                                                            echo '<label class="control-label col-lg-4" for="recibido">Recibido por:</label>
                                                                    <div class="col-lg-6">'.$recibidos[$solicitud['nr_solicitud']].'</div> <hr><br>';
                                                            echo '<td><span class="label label-info">Solicitud completada</span></td>';
                                                            break;
                                                            case 'anulado':
                                                                echo '<div align="center"><span class="label label-danger">Solicitud anulada</span></div>';
                                                                echo '<label class="col-lg-12"></label><br>';
                                                                echo '<label class="control-label col-lg-2" for="motivo">Motivo:</label>
                                                                    <div class="col-lg-4">'.$solicitud['motivo'].'</div> <hr><br>';
                                                               
                                                            break;
                                                            }?>
                                                        
                                                       
                                                    </div>
                                                </div>
                                            </form>
                                            <?php // endif?>
                                          </div>
                                        </div>
                                      </div>
                                  </div>
                                 <!-- FIN de Modal de articulos -->

                                 <!-- Modal de Usuario -->
                                 <div id="us<?php echo $solicitud['id_usuario'] ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                      <div class="modal-dialog">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                                            <h4 class="modal-title">Perfil del usuario que gener&oacute; la solicitud</h4>
                                          </div>
                                          <div class="modal-body">
                                            <!-- Profile form -->
                                            <table class="table">
                                               <tr>
                                                  <td><strong>Nombre</strong></td>
                                                  <td>:</td>
                                                  <td><?php echo ucfirst($solicitud['nombre']).' '.ucfirst($solicitud['apellido']) ?></td>
                                               </tr>
                                               <tr>
                                                  <td><strong>Cedula</strong></td>
                                                  <td>:</td>
                                                  <td><?php echo $solicitud['id_usuario'] ?></td>
                                               </tr>
                                               <tr>
                                                  <?php if($solicitud['email']!='') :?>
                                                    <td><strong>Email</strong></td>
                                                    <td>:</td>
                                                    <td><?php echo $solicitud['email'] ?></td>
                                                   <?php endif?>
                                               </tr>
                                               <tr>
                                                  <?php if($solicitud['telefono']) :?>
                                                  <td><strong>Numero</strong></td>
                                                  <td>:</td>
                                                  <td><?php echo $solicitud['telefono'] ?></td>
                                                   <?php endif?>
                                               </tr>
                                               <tr>
                                                  <td><strong>Rol asignado en el sistema</strong></td>
                                                  <td>:</td>
                                                  <?php 
                                                  switch($solicitud['sys_rol'])
                                                  {
                                                    case 'autoridad':
                                                      echo '<td>Autoridad</td>';
                                                    break;
                                                    case 'asist_autoridad':
                                                      echo '<td>Asistente de autoridad</td>';
                                                    break;
                                                    case 'jefe_alm':
                                                      echo '<td>Jefe de almacen</td>';
                                                    break;
                                                    case 'director_dep':
                                                      echo '<td>Director de dependencia</td>';
                                                    break;
                                                    case 'asistente_dep':
                                                      echo '<td>Asistente de dependencia</td>';
                                                    break;
                                                    case 'ayudante_alm':
                                                      echo '<td>Ayudante de almacen</td>';
                                                    break;
                                                  }?>
                                               </tr>
                                               
                                            </table>
                                          </div>
                                        </div>
                                      </div>
                                  </div>
                                 <!-- FIN de Modal de Usuario -->
                                <?php endforeach ?>
                               <div class="clearfix"></div>
                              
                           </div>
                        </div>
                      </div>
                    </div>
                  </div>

                 <script>
                    function change(){
                      document.getElementById("fecha").value= "Fecha";
                      // document.getElementById("hasta").value= "";
                      document.getElementById("opciones").value= "blah";
                      $("#find_usr").hide();
                      $("#dep").hide();
                      $("#status").hide();
                    }
                    // function option(value){
                    //   $("#find_usr").hide();
                    //   console.log(value);
                    //   value='#'+value;
                    //   console.log(value);
                    //   $(value).show();

                    // }
                    </script>