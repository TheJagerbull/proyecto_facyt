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
                echo 'Asistente del Departamento de ';
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
                        <h3>Modificar Perfil de Usuario</h3>
                     </div>
                     <div class="awidget-body">
                           
                           <!-- Profile form -->
             
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
                                                     <a href="<?php echo base_url() ?>index.php/usuario/listar" class="btn btn-default" >Cancelar</a>
                                                   </div>
                                                </form>
                                        </div>
                           
                     </div>
                  </div>
                  
               </div>
            </div>
            
      </div>
      
      <div class="clearfix"></div>
      
   </div>
</div>  