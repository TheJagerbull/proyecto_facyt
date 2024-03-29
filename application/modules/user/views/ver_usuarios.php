<div class="mainy">
         <!-- Page title -->
         <div class="page-title">
            <h2 align="right"><i class="fa fa-user color"></i> Perfil 
              <small>Rol asignado en sistema: <?php 
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
                echo 'Asistente de la dependencia ';
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
                      <h3>Modificar Perfil de Usuario</h3>
                      <div class="awidget-body">
                           <?php if($this->session->flashdata('edit_user') == 'success') : ?>
                              <div class="alert alert-success" style="text-align: center">Usuario modificado con éxito</div>
                            <?php endif ?>
                            <?php if($this->session->flashdata('edit_user') == 'error') : ?>
                              <div class="alert alert-danger" style="text-align: center">Ocurrió un problema con la edición del usuario</div>
                            <?php endif ?>
                           <!-- Profile form -->
             
                              <div class="form profile">
                                          <!-- Edit profile form (not working)-->
                                  <form name="updateUser" class="form-horizontal" action="<?php echo base_url() ?>index.php/user/usuario/modificar_usuario" method="post">
                                                <?php echo form_error('cedula'); ?>
                                                <?php echo form_error('password'); ?>
                                            <div class="row">
                                              <i class="color col-lg-8 col-md-8 col-sm-8" align="right" >*  Campos Obligatorios</i>
                                            </div>
                                            <!-- Status -->
                                            <div class="form-group">
                                              <label class="control-label col-lg-2" for="status">Estado en Sistema</label>
                                              <div class="col-lg-6">
                                                <select id="status" name="status" class="form-control select2">
                                                    <option value="activo" <?php echo (isset($user) && ($user->status == 'activo')) ? 'selected' : '' ?>>
                                                      Activado
                                                    </option>
                                                    <option value="inactivo" <?php echo (isset($user) && ($user->status == 'inactivo')) ? 'selected' : '' ?>>
                                                      Desactivado
                                                    </option>
                                                </select>
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
                                                <input type="text" class="form-control" id="cedula" name="id_usuario" value='<?php echo ucfirst($user->id_usuario)?>'>
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
                                              <label class="control-label col-lg-2" for="telefono">Teléfono</label>
                                              <div class="col-lg-6">
                                                <input onkeyup="validatePhone(name, 'telefono_msg')" type="text" class="form-control" id="telefono" name="telefono" <?php if($user->telefono!='') :?>value='<?php echo ucfirst($user->telefono)?>'<?php endif ?>>
                                                <span id="telefono_msg" class="label label-danger"></span>
                                              </div>
                                            </div>
                                            <!-- DEPENDENCIA -->
                                            <div class="form-group">
                                                  <label class="control-label col-lg-2" for="dependencia">Dependencia</label>
                                                  <div class="col-lg-6">
                                                  <select class="form-control select2" name="id_dependencia">
                                                      <option value=""></option>
                                                      <?php foreach ($dependencia as $dep): ?>
                                                          <option value = "<?php echo $dep->id_dependencia ?>" <?php if($user->id_dependencia == $dep->id_dependencia){ echo'selected';} ?> ><?php echo $dep->dependen ?></option>
                                                      <?php endforeach; ?>
                                                  </select>
                                                  </div>
                                              </div>
                                            <!-- CARGO DEL USUARIO -->
                                            <div class="form-group">
                                              <label class="col-lg-2 control-label" for="cargo"><i class="color">*  </i>Cargo</label>
                                              <div class="col-lg-6">
                                                <input onkeyup="validateLetters(name, 'cargo_msg')" type="text" class="form-control" id="cargo" name="cargo" title="setCustomValidity('Este campo es obligatorio')" required value='<?php echo ucfirst($user->cargo)?>'>
                                                <span id="cargo_msg" class="label label-danger"></span>
                                              </div>
                                            </div>
                                            <!-- SELECT TIPO DE USUARIO -->
                                            <div class="form-group">
                                              <label class="col-lg-2 control-label" for="sys_rol">Rol de Sistema</label>
                                              <div class="col-lg-6">
                                                <select id="sys_rol" name="sys_rol" class="form-control select2">
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
                                                        Director de dependencia
                                                      </option>
                                                  <?php endif ?>
                                                    <?php if($this->session->userdata('user')['sys_rol'] != 'ayudante_alm' && $this->session->userdata('user')['sys_rol'] != 'asistente_dep') : ?>
                                                      <option value="ayudante_alm" <?php echo (isset($user) && ($user->sys_rol == 'ayudante_alm')) ? 'selected' : '' ?>>
                                                        Ayudante de Almacen
                                                      </option>
                                                    <?php endif ?>
                                                  <option value="asistente_dep" <?php echo (isset($user) && ($user->sys_rol == 'asistente_dep')) ? 'selected' : '' ?>>
                                                    Asistente de dependencia
                                                  </option>
                                                  <option value="no_visible" <?php echo (isset($user) && ($user->sys_rol == 'no_visible')) ? 'selected' : '' ?>>
                                                    No autorizado
                                                  </option>
                                                </select>
                                              </div>
                                            </div>

                                            <!-- TIPO DE PERSONAL -->
                                            <div class="form-group">
                                              <label class="control-label col-lg-2" for="tipoP">Tipo de Personal</label>
                                              <div class="col-lg-6">
                                                <select id="tipoP" name="tipo" class="form-control select2">
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
                                            </div><!--  usuario/listar-->
                                            <input type="hidden" name="uri" value="<?php echo 'index.php/usuario/listar';?>"/>
                                            <?php if(isset($edit) && $edit && isset($user)) : ?>
                                              <input type="hidden" name="ID" value="<?php echo $user->ID ?>" />
                                            <?php endif ?>
                                           <div class="modal-footer">                                            
                                             <a href="<?php echo base_url() ?>index.php/usuario/listar" class="btn btn-default" >Cancelar</a>
                                              <button type="submit" class="btn btn-primary">Guardar cambios</button>
                                           </div>
                                        </form>
                                        </div>
                           
                     </div>
                  </div>
                  
               </div>
            </div>
            
      </div>
      
      <div class="clearfix"></div>
      <script type="text/javascript">
      
      function validateLetters(x,y)
      {
        var re = /^[A-Za-z ]*$/;
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
        // var phone = /^[0][24][124][1-6][0-9]*$/;
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