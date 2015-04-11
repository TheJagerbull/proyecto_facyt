        <div class="mainy">
               <!-- Page title -->
               <div class="page-title">
                  <h2><i class="fa fa-desktop color"></i> Perfil 
                    <small>Rol asignado en sistema: <?php 
                    if($user->sys_rol=='autoridad')
                      echo 'Autoridad';
                    if($user->sys_rol=='asist_autoridad')
                      echo 'Asistente de Autoridad';
                    if($user->sys_rol=='jefe_alm')
                      echo 'Jefe de Almacen';
                    if($user->sys_rol=='director_dep')
                    {
                      echo 'Director del Departamento de ';
                      echo $user->dependencia;
                    }
                    if($user->sys_rol=='asistente_dep')
                    {
                      echo 'Asistente del Departamento de';
                      echo $user->dependencia;
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
                                                        <?php echo form_error('cedula'); ?>
                                                        <?php echo form_error('password'); ?>
                                  </div>
                                    <table class="table">
                                    
                                       <tr>
                                          <td><strong>Nombre y Apellido</strong></td>
                                          <td>:</td>
                                          <td><?php echo ucfirst($user->nombre).' '.ucfirst($user->apellido) ?></td>
                                       </tr>
                                       <tr>
                                          <td><strong>Cedula de Identidad</strong></td>
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
                                          <td><strong>Numero de Telefono</strong></td>
                                          <td>:</td>
                                          <td><?php echo $user->telefono ?></td>
                                           <?php endif?>
                                       </tr>
                                       <tr>
                                          <td><strong>Dependencia</strong></td>
                                          <td>:</td>
                                          <td><?php echo $user->dependencia ?></td>
                                       </tr>
                                       <tr>
                                          <td><strong>Cargo</strong></td>
                                          <td>:</td>
                                          <td><?php echo ucfirst($user->cargo); ?></td>
                                       </tr>
                                       <tr>
                                          <td><strong>Rol Asignado en el Sistema</strong></td>
                                          <td>:</td>
                                          <?php 
                                          switch($user->sys_rol)
                                          {
                                            case 'autoridad':
                                              echo '<td>Autoridad</td>';
                                            break;
                                            case 'asist_autoridad':
                                              echo '<td>Asistente de Autoridad</td>';
                                            break;
                                            case 'jefe_alm':
                                              echo '<td>Jefe de Almacen</td>';
                                            break;
                                            case 'director_dep':
                                              echo '<td>Director de Departamento</td>';
                                            break;
                                            case 'asistente_dep':
                                              echo '<td>Asistente de Departamento</td>';
                                            break;
                                            case 'ayudante_alm':
                                              echo '<td>Ayudante de Almacen</td>';
                                            break;
                                          }?>
                                       </tr>
                                       <tr>
                                          <td><strong>Tipo de Personal</strong></td>
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
                                                      
                                                      <div class="alert alert-info">
                                                          <span class="help-block">Deje los campos de <strong>Contraseñas</strong> en blanco si no desea modificarla</span>
                                                      </div>
                                              <div class="form profile">
                                                <!-- Edit profile form (not working)-->
                                                <form class="form-horizontal" action="" method="post">
                                                    <!-- nombre -->
                                                    <div class="form-group">
                                                      <label class="control-label col-lg-2" for="nombre">Nombre</label>
                                                      <div class="col-lg-6">
                                                        <input type="text" class="form-control" id="nombre" name="nombre" value='<?php echo ucfirst($user->nombre)?>'>
                                                      </div>
                                                    </div>
                                                    <!-- apellido -->
                                                    <div class="form-group">
                                                      <label class="control-label col-lg-2" for="apellido">Apellido</label>
                                                      <div class="col-lg-6">
                                                        <input type="text" class="form-control" id="apellido" name="apellido" value='<?php echo ucfirst($user->apellido)?>'>
                                                      </div>
                                                    </div>                                                                                                                                         
                                                    <!-- cedula -->
                                                    <div class="form-group">
                                                      <label class="control-label col-lg-2" for="cedula">Cedula</label>
                                                      <div class="col-lg-6">
                                                        <input type="text" class="form-control" id="cedula" name="id_usuario" value='<?php echo ucfirst($user->id_usuario)?>'>
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
                                                    <div class="form-group">

                                                      <label class="control-label col-lg-2" for="password1">Contrasena</label>
                                                      <div class="col-lg-6">
                                                        <input type="password" class="form-control" id="password1" name="password">
                                                      </div>
                                                    </div>
                                                    <div class="form-group">
                                                      <label class="control-label col-lg-2" for="password2">Confirmar Contrasena</label>
                                                      <div class="col-lg-6">
                                                        <input type="password" class="form-control" id="password2" name="repass">
                                                      </div>
                                                    </div>

                                                    <!-- DEPENDENCIA -->
                                                    <div class="form-group">
                                                      <label class="control-label col-lg-2" for="dep">Dependencia</label>
                                                      <div class="col-lg-6">
                                                        <input type="text" class="form-control" id="dep" name="dependencia" value='<?php echo ucfirst($user->dependencia)?>'>
                                                      </div>
                                                    </div>
                                                    
                                                    <!-- CARGO DEL USUARIO -->
                                                    <div class="form-group">
                                                      <label class="col-lg-2 control-label" for="cargo">Cargo</label>
                                                      <div class="col-lg-6">
                                                        <input type="text" class="form-control" id="cargo" name="cargo" value='<?php echo ucfirst($user->cargo)?>'>
                                                      </div>
                                                    </div>

                                                    <!-- SELECT TIPO DE USUARIO -->
                                                    <div class="form-group">
                                                      <label class="col-lg-2 control-label" for="sys_rol">Rol de Sistema</label>
                                                      <div class="col-lg-6">
                                                        <select id="sys_rol" name="sys_rol" class="form-control">
                                                          <?php if($this->session->userdata('user')->sys_rol == 'autoridad' || $this->session->userdata('user')->sys_rol == 'asist_autoridad') : ?>
                                                            <?php if($this->session->userdata('user')->sys_rol == 'autoridad') : ?>
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
                                                            <?php if($this->session->userdata('user')->sys_rol != 'ayudante_alm' && $this->session->userdata('user')->sys_rol != 'asistente_dep') : ?>
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
                                                      <label class="control-label col-lg-2" for="tipoP">Tipo de Personal</label>
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