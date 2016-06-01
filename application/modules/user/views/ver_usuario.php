       <div class="mainy">
               <!-- Page title -->
               <div class="page-title">
                  <h2 align="right"><i class="fa fa-user color"></i> Perfil 
                    <small>Rol: <?php 
                    if($user->sys_rol=='autoridad')
                      echo 'Autoridad';
                    if($user->sys_rol=='asist_autoridad')
                      echo 'Asistente de Autoridad';
                    if($user->sys_rol=='jefe_alm')
                      echo 'Jefe de Almacen';
                    if($user->sys_rol=='director_dep')
                    {
                      echo 'Director de la dependencia ';
                      foreach ($dependencia as $i => $dep)
                      {
                          if($user->id_dependencia == $dep->id_dependencia)
                          {
                            $aux=$dep->dependen;
                          }
                      }
                      echo($aux);
                    }
                    if($user->sys_rol=='asistente_dep')
                    {
                      echo 'Asistente de la dependencia';
                      foreach ($dependencia as $i => $dep)
                      {
                          if($user->id_dependencia == $dep->id_dependencia)
                          {
                            $aux=$dep->dependen;
                          }
                      }
                      echo($aux);
                    }
                    if($user->sys_rol=='ayudante_alm')
                      echo 'Ayudante de Almacen';

                    ?></small></h2>
                  <hr />
               </div>
               <!-- Page title -->
               
                  <div class="row">
                     <div class="col-md-12">
                     
                        <div class="awidget full-width">
                           <div class="awidget-head">
                              <h3>Perfil de Usuario</h3>
                           </div>
                           <div class="awidget-body">
                            <?php if($this->session->flashdata('edit_user') == 'success') : ?>
                              <div class="alert alert-success" style="text-align: center">Usuario modificado con éxito</div>
                            <?php endif ?>
                            <?php if($this->session->flashdata('edit_user') == 'error') : ?>
                              <div class="alert alert-danger" style="text-align: center">Ocurrió un problema con la edición del usuario</div>
                            <?php endif ?>
                              <div class="row">
                                 <div class="col-md-3 col-sm-3">
                                    <a href="profile.html#"></a>
                                 </div>
                                 <div class="col-md-9 col-sm-9">
                                  <div class="col-lg-12" style="text-align: center">
                                  </div>
                                    <table class="table">
                                    
                                       <tr>
                                          <td><strong>Nombre y apellido</strong></td>
                                          <td>:</td>
                                          <td><?php echo ucfirst($user->nombre).' '.ucfirst($user->apellido) ?></td>
                                       </tr>
                                       <tr>
                                          <td><strong>Cedula de identidad</strong></td>
                                          <td>:</td>
                                          <td><?php echo $user->id_usuario ?></td>
                                       </tr>
                                       <tr>
                                          <?php if(!empty($user->email)) :?>
                                            <td><strong>Email</strong></td>
                                            <td>:</td>
                                            <td><?php echo $user->email ?></td>
                                           <?php endif?>
                                       </tr>
                                       <tr>
                                          <?php if(!empty($user->telefono)) :?>
                                          <td><strong>Numero de telefono</strong></td>
                                          <td>:</td>
                                          <td><?php echo $user->telefono ?></td>
                                          <?php endif?>
                                       </tr>
                                       <tr>
                                          <td><strong>Dependencia</strong></td>
                                          <td>:</td>
                                          <?php foreach ($dependencia as $dep): ?>
                                          <?php if($user->id_dependencia == $dep->id_dependencia){ echo "<td>".$dep->dependen."</td>";} ?>
                                          <?php endforeach; ?>
                                       </tr>
                                       <tr>
                                          <?php if(!empty($user->cargo)) :?>
                                          <td><strong>Cargo</strong></td>
                                          <td>:</td>
                                          <td><?php echo ucfirst($user->cargo); ?></td>
                                          <?php endif; ?>
                                       </tr>
                                       <tr>
                                          <td><strong>Rol asignado en el sistema</strong></td>
                                          <td>:</td>
                                          <?php 
                                          switch($user->sys_rol)
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
                                            default:
                                              echo '<td>No autorizado</td>';
                                            break;
                                          }?>
                                       </tr>
                                       <tr>
                                          <td><strong>Tipo de personal</strong></td>
                                          <td>:</td>
                                          <td><?php echo ucfirst($user->tipo); ?></td>
                                       </tr>
                                          <?php if(!empty($user->observacion)) :?>
                                       <tr>
                                            <td><strong>Observacion</strong></td>
                                            <td>:</td>
                                            <td><?php echo ucfirst($user->observacion); ?></td>
                                       </tr>
                                           <?php endif?>
                                       
                                    </table>
                                 </div>
                              </div>
                           </div>
                        </div>
                        
                        


                                <!-- Button to trigger modal -->
                                 <?php if(isset($edit) && $edit && isset($user)) : ?>
                                  <a href="#modificar" class="btn btn-info pull-right" data-toggle="modal">Actualizar perfil</a>
                                 <?php endif ?>
                                <!-- Modal -->
                                <div id="modificar" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modificacion" aria-hidden="true">
                                     <div class="modal-dialog">
                                       <div class="modal-content">
                                           <div class="modal-header">
                                             <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                                             <h4 class="modal-title">Perfil</h4>
                                           </div>
                                           <div class="modal-body">
                                            <!-- Profile form -->
                                                      
                                              <div class="form profile">
                                                <!-- Edit profile form (not working)-->
                                                <form name="updateUser" class="form-horizontal" action="<?php echo base_url() ?>index.php/user/usuario/modificar_usuario" method="post">
                                                        <?php echo form_error('cedula'); ?>
                                                        <?php echo form_error('password'); ?>
                                                    <div class="row">
                                                      <i class="color col-lg-8 col-md-8 col-sm-8" align="right" >*  Campos Obligatorios</i>
                                                      <div class="form-group col-lg-12" align="right">
                                                        <button type="button" class="btn btn-success" onclick="$('#pass').toggle();">cambiar contrase&ntilde;a</button>
                                                      </div>
                                                    </div>
                                                    <!-- nombre -->
                                                    <div class="form-group">
                                                      <label class="control-label col-lg-2" for="nombre"><i class="color">*  </i>Nombre</label>
                                                      <div class="col-lg-6">
                                                        <input onkeyup="validateLetters(name, 'nombre_msg')" type="text" class="form-control" id="nombre" name="nombre" title="setCustomValidity('Este campo es obligatorio')" required value='<?php echo ucfirst($user->nombre)?>'>
                                                        <span id="nombre_msg" class="label label-danger"></span>
                                                      </div>
                                                    </div>
                                                    <!-- apellido -->
                                                    <div class="form-group">
                                                      <label class="control-label col-lg-2" for="apellido"><i class="color">*  </i>Apellido</label>
                                                      <div class="col-lg-6">
                                                        <input onkeyup="validateLetters(name, 'apellido_msg')" type="text" class="form-control" id="apellido" name="apellido" title="setCustomValidity('Este campo es obligatorio')" required value='<?php echo ucfirst($user->apellido)?>'>
                                                        <span id="apellido_msg" class="label label-danger"></span>
                                                      </div>
                                                    </div>                                                                                                                                         
                                                    <!-- cedula -->
                                                    <!-- <div class="form-group">
                                                      <label class="control-label col-lg-2" for="cedula">Cedula</label>
                                                      <div class="col-lg-6">
                                                        <input required type="text" class="form-control" id="cedula" name="id_usuario" value='<?php echo ucfirst($user->id_usuario)?>'>
                                                      </div>
                                                    </div> -->
                                                    <!-- CORREO ELECTRONICO -->
                                                    <div class="form-group">
                                                      <label class="control-label col-lg-2" for="email">Email</label>
                                                      <div class="col-lg-6">
                                                        <input onkeyup="validateEmail(name, 'email_msg')" type="text" class="form-control" id="email" name="email" <?php if($user->email!='') :?>value='<?php echo ucfirst($user->email)?>'<?php endif ?>>
                                                        <span id="email_msg" class="label label-danger"></span> 
                                                      </div>
                                                    </div>
                                                    <!-- TELEFONO -->
                                                    <div class="form-group">
                                                      <label class="control-label col-lg-2" for="telefono"><i class="color">*  </i>Teléfono</label>
                                                      <div class="col-lg-6">
                                                        <input onkeyup="validatePhone(name, 'telefono_msg')" type="text" class="form-control" id="telefono" name="telefono" title="setCustomValidity('Este campo es obligatorio')" required <?php if($user->telefono!='') :?>value='<?php echo ucfirst($user->telefono)?>'<?php endif ?>>
                                                        <span id="telefono_msg" class="label label-danger"></span>
                                                      </div>
                                                    </div>
                                                    <!-- contrasena -->
                                                    <div hidden id="pass">
                                                        <div class="form-group">

                                                          <label class="control-label col-lg-2" for="password1">Contrasena</label>
                                                          <div class="col-lg-6">
                                                            <input type="password" class="form-control" id="password1" name="password">
                                                          </div>
                                                        </div>
                                                        <div class="form-group">
                                                          <label class="control-label col-lg-2" for="password2">Confirmar contrasena</label>
                                                          <div class="col-lg-6">
                                                            <input type="password" class="form-control" id="password2" name="repass">
                                                          </div>
                                                        </div>
                                                    </div>
                                                    <?php if($user->sys_rol=='autoridad' || $user->sys_rol=='asist_autoridad'):?>
                                                            <!-- DEPENDENCIA -->
                                                            <div class="form-group">
                                                                  <label class="control-label col-lg-3" for="dependencia"><i class="color">*  </i>Dependencia</label>
                                                                  <div class="col-lg-6">
                                                                      <select name="id_dependencia" class="form-control select2">
                                                                        <option value="">--SELECCIONE--</option>
                                                                        <?php foreach ($dependencia as $dep): ?>
                                                                            <option value = "<?php echo $dep->id_dependencia ?>" <?php if($user->id_dependencia == $dep->id_dependencia){ echo'selected';} ?> ><?php echo $dep->dependen ?></option>
                                                                        <?php endforeach; ?>
                                                                    </select>
                                                                  </div>
                                                            </div>
                                                            
                                                            <!-- CARGO DEL USUARIO -->
                                                            <div class="form-group">
                                                              <label class="col-lg-2 control-label" for="cargo">Cargo</label>
                                                              <div class="col-lg-6">
                                                                <input onkeyup="validateLetters(name, 'cargo_msg')" type="text" class="form-control" id="cargo" name="cargo" value='<?php echo ucfirst($user->cargo)?>'>
                                                                <span id="cargo_msg" class="label label-danger"></span>
                                                              </div>
                                                            </div>

                                                            <!-- SELECT TIPO DE USUARIO -->
                                                            <div class="form-group">
                                                              <label class="col-lg-2 control-label" for="sys_rol">Rol de sistema</label>
                                                              <div class="col-lg-6">
                                                                <select id="sys_rol" name="sys_rol" class="form-control select2">
                                                                    <option></option>
                                                                  <?php if($this->session->userdata('user')['sys_rol'] == 'autoridad' || $this->session->userdata('user')['sys_rol'] == 'asist_autoridad') : ?>
                                                                    <?php if($this->session->userdata('user')['sys_rol'] == 'autoridad') : ?>
                                                                      <option value="autoridad" <?php echo (isset($user) && ($user->sys_rol == 'autoridad')) ? 'selected' : '' ?>>
                                                                        Autoridad
                                                                      </option>
                                                                    <option value="asist_autoridad" <?php echo (isset($user) && ($user->sys_rol == 'asist_autoridad')) ? 'selected' : '' ?>>
                                                                      Asistente de Autoridad
                                                                    </option>
                                                                    <?php endif ?>
                                                                    <option value="jefe_alm" <?php echo (isset($user) && ($user->sys_rol == 'jefe_alm')) ? 'selected' : '' ?>>
                                                                      Jefe de Almacen
                                                                    </option>
                                                                    <option value="director_dep" <?php echo (isset($user) && ($user->sys_rol == 'director_dep')) ? 'selected' : '' ?>>
                                                                      Director de Departamento
                                                                    </option>
                                                                    <?php endif ?>
                                                                    <?php if($this->session->userdata('user')['sys_rol'] != 'ayudante_alm' && $this->session->userdata('user')['sys_rol'] != 'asistente_dep') : ?>
                                                                      <option value="ayudante_alm" <?php echo (isset($user) && ($user->sys_rol == 'ayudante_alm')) ? 'selected' : '' ?>>
                                                                        Ayudante de Almacen
                                                                      </option>
                                                                    <?php endif ?>
                                                                  <option value="asistente_dep" <?php echo (isset($user) && ($user->sys_rol == 'asistente_dep')) ? 'selected' : '' ?>>
                                                                    Asistente de Departamento
                                                                  </option>
                                                                </select>
                                                              </div>
                                                            </div>
                                                    <?php endif?>
                                                    <!-- TIPO DE PERSONAL -->
                                                    <div class="form-group">
                                                      <label class="control-label col-lg-2" for="tipoP">Tipo de personal</label>
                                                      <div class="col-lg-6">
                                                        <select id="tipoP" name="tipo" class="form-control select2">
                                                            <option></option>
                                                            <option value="docente" <?php echo (isset($user) && ($user->tipo == 'docente')) ? 'selected' : '' ?>>
                                                              Docente
                                                            </option>
                                                            <option value="administrativo" <?php echo (isset($user) && ($user->tipo == 'administrativo')) ? 'selected' : '' ?>>
                                                              Administrativo
                                                            </option>
                                                            <option value="obrero" <?php echo (isset($user) && ($user->tipo == 'obrero')) ? 'selected' : '' ?>>
                                                              Obrero
                                                            </option>
                                                        </select>
                                                      </div>
                                                    </div>

                                                    <!-- OBSERVACION -->
                                                    <div class="form-group">
                                                      <label class="control-label col-lg-2" for="ob">Observacion</label>
                                                      <div class="col-lg-6">
                                                        <textarea rows="3" type="text" class="form-control" id="ob" name="observacion"><?php echo ucfirst($user->observacion)?></textarea>
                                                      </div>
                                                    </div>
                                                    <input type="hidden" name="uri" value="<?php echo 'index.php/'.$this->uri->uri_string();?>"/>
                                                    <?php if(isset($edit) && $edit && isset($user)) : ?>
                                                      <input type="hidden" name="ID" value="<?php echo $user->ID ?>" />
                                                    <?php endif ?>
                                                   <div class="modal-footer">
                                                     <button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Cancelar</button>
                                                     <button type="submit" class="btn btn-primary">Guardar cambios</button>
                                                   </div>
                                                </form>
                                              </div>
                                           </div>
                                     </div>
                                 </div>
                                <hr />

                                </div>
                      </div>
                  
            </div>
            
            <div class="clearfix"></div>
            
         </div>
      <script type="text/javascript">
      
      function validateLetters(x,y)
      {
        var re = /^[A-Za-z -']*$/;
        if(re.test(document.getElementById(x).value))
        {
          document.getElementById(x).style.background ='#DFF0D8';
          document.getElementById(y).innerHTML = "";
          return true;
        }
        else
        {
          document.getElementById(x).style.background ='#F2DEDE';
          document.getElementById(y).innerHTML = "Solo se permiten letras";
          return false; 
        }
      }
      function validatePhone(x,y)
      {
        var phone = /^[0][24][0-9]*$/;
        if(phone.test(document.getElementById(x).value))
        {
          document.getElementById(x).style.background ='#DFF0D8';
          document.getElementById(y).innerHTML = "";
          return true;
        }
        else
        {
          document.getElementById(x).style.background ='#F2DEDE';
          document.getElementById(y).innerHTML = "Debe ser un numero de telefono válido Ej.: 04...., 02.....";
          return false;
        }
      }

      function validateEmail(x,y)
      {
        var mail = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
        if(mail.test(document.getElementById(x).value))
        {
          document.getElementById(x).style.background ='#DFF0D8';
          document.getElementById(y).innerHTML = "";
          return true;
        }
        else
        {
          document.getElementById(x).style.background ='#F2DEDE';
          document.getElementById(y).innerHTML = "Correo invalido (ejemplo: 'usuario'@'servidor'.'dominio')";
          return false;
        }
      }

      </script>