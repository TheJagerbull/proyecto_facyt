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
                      echo 'Director del Departamento de ';
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
                      echo 'Asistente del Departamento de';
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
                                          <?php if($user->email!='') :?>
                                            <td><strong>Email</strong></td>
                                            <td>:</td>
                                            <td><?php echo $user->email ?></td>
                                           <?php endif?>
                                       </tr>
                                       <tr>
                                          <?php if($user->telefono!='') :?>
                                          <td><strong>Numero de telefono</strong></td>
                                          <td>:</td>
                                          <td><?php echo $user->telefono ?></td>
                                           <?php endif?>
                                       </tr>
                                       <tr>
                                          <td><strong>Dependencia</strong></td>
                                          <td>:</td>
                                          <td><?php echo $user->id_dependencia ?></td>
                                       </tr>
                                       <tr>
                                          <td><strong>Cargo</strong></td>
                                          <td>:</td>
                                          <td><?php echo ucfirst($user->cargo); ?></td>
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
                                              echo '<td>Director de departamento</td>';
                                            break;
                                            case 'asistente_dep':
                                              echo '<td>Asistente de departamento</td>';
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
                                       <tr>
                                          <?php if($user->observacion!='') :?>
                                            <td><strong>Observacion</strong></td>
                                            <td>:</td>
                                            <td><?php echo ucfirst($user->observacion); ?></td>
                                           <?php endif?>
                                       </tr>
                                       
                                    </table>
                                 </div>
                              </div>
                           </div>
                        </div>
                        
                        


                                <!-- Button to trigger modal -->
                                 <?php if(isset($edit) && $edit && isset($user)) : ?>
                                  <a href="#modificar" class="btn btn-info" data-toggle="modal">Actualizar perfill</a>
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
                                                <form name="updateUser" onsubmit="return validateForm()" class="form-horizontal" action="<?php echo base_url() ?>index.php/user/usuario/modificar_usuario" method="post">
                                                        <?php echo form_error('cedula'); ?>
                                                        <?php echo form_error('password'); ?>
                                                    <div class="row">
                                                      <div class="form-group col-lg-12" align="right">
                                                        <button type="button" class="btn btn-success" onclick="$('#pass').toggle();">cambiar contrase&ntilde;a</button>
                                                      </div>
                                                    </div>
                                                    <!-- nombre -->
                                                    <div class="form-group">
                                                      <label class="control-label col-lg-2" for="nombre">Nombre</label>
                                                      <div class="col-lg-6">
                                                        <input onblur="validateName(name)" type="text" class="form-control" id="nombre" name="nombre" value='<?php echo ucfirst($user->nombre)?>'>
                                                      </div>
                                                    </div>
                                                    <!-- apellido -->
                                                    <div class="form-group">
                                                      <label class="control-label col-lg-2" for="apellido">Apellido</label>
                                                      <div class="col-lg-6">
                                                        <input required type="text" class="form-control" id="apellido" name="apellido" value='<?php echo ucfirst($user->apellido)?>'>
                                                      </div>
                                                    </div>                                                                                                                                         
                                                    <!-- cedula -->
                                                    <div class="form-group">
                                                      <label class="control-label col-lg-2" for="cedula">Cedula</label>
                                                      <div class="col-lg-6">
                                                        <input required type="text" class="form-control" id="cedula" name="id_usuario" value='<?php echo ucfirst($user->id_usuario)?>'>
                                                      </div>
                                                    </div>
                                                    <!-- CORREO ELECTRONICO -->
                                                    <div class="form-group">
                                                      <label class="control-label col-lg-2" for="email">Email</label>
                                                      <div class="col-lg-6">
                                                        <input type="text" class="form-control" id="email" name="email" <?php if($user->email!='') :?>value='<?php echo ucfirst($user->email)?>'<?php endif ?>>
                                                      </div>
                                                    </div>
                                                    <!-- TELEFONO -->
                                                    <div class="form-group">
                                                      <label class="control-label col-lg-2" for="tlf">Telefono</label>
                                                      <div class="col-lg-6">
                                                        <input type="text" class="form-control" id="tlf" name="telefono" <?php if($user->telefono!='') :?>value='<?php echo ucfirst($user->telefono)?>'<?php endif ?>>
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

                                                    <!-- DEPENDENCIA -->
                                                    <div class="form-group">
                                                          <label class="control-label col-lg-2" for = "dependencia">Dependencia</label>
                                                          <select name="id_dependencia">
                                                              <option value="">--SELECCIONE--</option>
                                                              <?php foreach ($dependencia as $dep): ?>
                                                                  <option value = "<?php echo $dep->id_dependencia ?>" <?php if($user->id_dependencia == $dep->id_dependencia){ echo'selected';} ?> ><?php echo $dep->dependen ?></option>
                                                              <?php endforeach; ?>
                                                          </select>
                                                      </div>
                                                    
                                                    <!-- CARGO DEL USUARIO -->
                                                    <div class="form-group">
                                                      <label class="col-lg-2 control-label" for="cargo">Cargo</label>
                                                      <div class="col-lg-6">
                                                        <input required type="text" class="form-control" id="cargo" name="cargo" value='<?php echo ucfirst($user->cargo)?>'>
                                                      </div>
                                                    </div>

                                                    <!-- SELECT TIPO DE USUARIO -->
                                                    <div class="form-group">
                                                      <label class="col-lg-2 control-label" for="sys_rol">Rol de sistema</label>
                                                      <div class="col-lg-6">
                                                        <select id="sys_rol" name="sys_rol" class="form-control">
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

                                                    <!-- TIPO DE PERSONAL -->
                                                    <div class="form-group">
                                                      <label class="control-label col-lg-2" for="tipoP">Tipo de personal</label>
                                                      <div class="col-lg-6">
                                                        <select id="tipoP" name="tipo" class="form-control">
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
                                                     <button type="submit" class="btn btn-primary">Guardar cambios</button>
                                                     <button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Cancelar</button>
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
      </div>
      <script type="text/javascript">
      
      function validateName(x){
        var re = /[A-Za-z -']$/;
        console.log(x);
        if(re.test(document.getElementById(x).value))
        {
          document.getElementById(x).style.background ='#DFF0D8';
          return true;
        }
        else
        {
          document.getElementById(x).style.background ='#F2DEDE';
          return false; 
        }
      }
      // function validateForm(){
      //   var nombre = document.forms["updateUser"]["nombre"].value;
      //   var apellido = document.forms["updateUser"]["apellido"].value;
      //   var id_usuario = document.forms["updateUser"]["id_usuario"].value;
      //   var email = document.forms["updateUser"]["email"].value;
      //   var telefono = document.forms["updateUser"]["telefono"].value;
      //   var cargo = document.forms["updateUser"]["cargo"].value;
      //   var observacion = document.forms["updateUser"]["observacion"].value;
      //   var password = document.forms["updateUser"]["password"].value;
      //   var repass = document.forms["updateUser"]["repass"].value;

      // }
      </script>