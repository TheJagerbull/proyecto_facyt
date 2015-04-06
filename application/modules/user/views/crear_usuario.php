    <!-- Page content -->
<div class="mainy">
  <!-- Page title -->
  <div class="page-title">
    <h2><i class="fa fa-user color"></i> <?php echo (isset($edit) && $edit) ? 'Detalle de' : 'Crear' ?><small> Usuario</small></h2> 
    <hr />
  </div>
  <!-- Page title -->
  <div class="row">
    <div class="col-md-12">
      <div class="awidget full-width">
        <div class="awidget-body">
          <!-- FORMULARIO DE CREACION DE USUARIOS PARA CONTROL DE LA APLICACION -->
          <form class="form-horizontal" action="index.php/usuarios/<?php echo ((isset($edit) && $edit)) ? 'modificar' : 'crear' ?>" method="post">
            <fieldset>
            
              <!-- Text input-->
              <div class="form-group">
                <?php echo form_error('username') ?>
                <label class="col-md-4 control-label" for="username">Email</label>  
                <div class="col-md-6">
                  <input id="username" name="username" type="email" placeholder="Email" class="form-control input-md" required="" 
                    value="<?php echo ((isset($edit) && $edit) && isset($user)) ? $user->username : '' ?>"/>
                </div>
              </div>
              
              <!-- Password input-->
              <div class="form-group">
                <?php echo form_error('password') ?>
                <div class="col-md-4"></div>
                <div class="col-md-6">
                  <?php if(isset($edit) && $edit) : ?>
                    <span class="help-block">Deje los campos de <strong>Contraseñas</strong> en blanco si no desea modificarla</span>
                  <?php endif ?>
                </div>
                <div class="col-md-2"></div>
                <label class="col-md-4 control-label" for="password">Contraseña</label>
                <div class="col-md-6">
                  <input id="password" name="password" type="password" placeholder="Contraseña" class="form-control input-md" />
                </div>
              </div>
              
              <!-- Password input-->
              <div class="form-group">
                <?php echo form_error('repass') ?>
                <label class="col-md-4 control-label" for="repass">Repetir contraseña</label>
                <div class="col-md-6">
                  <input id="repass" name="repass" type="password" placeholder="Vuelva a escribir la contraseña" class="form-control input-md" />
                </div>
              </div>
              
              <!-- Text input-->
              <div class="form-group">
                <?php echo form_error('nombre') ?>
                <label class="col-md-4 control-label" for="nombre">Nombre</label>  
                <div class="col-md-6">
                  <input id="nombre" name="nombre" type="text" placeholder="Nombre del usuario" class="form-control input-md" required="" 
                    value="<?php echo ((isset($edit) && $edit) && isset($user)) ? $user->nombre : '' ?>" />
                </div>
              </div>
              
              <!-- Text input-->
              <div class="form-group">
                <?php echo form_error('apellido') ?>
                <label class="col-md-4 control-label" for="apellido">Apellido</label>  
                <div class="col-md-6">
                  <input id="apellido" name="apellido" type="text" placeholder="Apellido del usuario" class="form-control input-md" required="" 
                    value="<?php echo ((isset($edit) && $edit) && isset($user)) ? $user->apellido : '' ?>" />
                </div>
              </div>
              
              <!-- SELECT TIPO DE USUARIO -->
              <div class="form-group">
                <label class="col-md-4 control-label" for="sys_rol">Tipo de usuario</label>
                <div class="col-md-6">
                  <select id="sys_rol" name="sys_rol" class="form-control">
                    <?php if($this->session->userdata('user')->sys_rol == 'autoridad' || $this->session->userdata('user')->sys_rol == 'asist_autoridad') : ?>
                      <?php if($this->session->userdata('user')->sys_rol == 'autoridad') : ?>
                        <option value="autoridad" <?php echo (isset($user) && ($user->sys_rol == 'autoridad')) ? 'selected' : '' ?>>
                          Autoridad
                        </option>
                      <?php endif ?>
                      <option value="asist_autoridad" <?php echo (isset($user) && ($user->sys_rol == 'asist_autoridad')) ? 'selected' : '' ?>>
                        Asistente de Autoridad
                      </option>
                      <option value="jefe_alm" <?php echo (isset($user) && ($user->sys_rol == 'jefe_alm')) ? 'selected' : '' ?>>
                        Jefe de Almacen
                      </option>
                      <option value="director_dep" <?php echo (isset($user) && ($user->sys_rol == 'director_dep')) ? 'selected' : '' ?>>
                        Director de Departamento
                      </option>
                    <?php endif ?>
                    <option value="ayudante_alm" <?php echo (isset($user) && ($user->sys_rol == 'ayudante_alm')) ? 'selected' : '' ?>>
                      Ayudante de Almacen
                    </option>
                    <option value="asistente_dep" <?php echo (isset($user) && ($user->sys_rol == 'asistente_dep')) ? 'selected' : '' ?>>
                      Asistente de Departamento
                    </option>
                  </select>
                </div>
              </div>
              
              <?php if(isset($edit) && $edit && isset($user)) : ?>
                <input type="hidden" name="id" value="<?php echo $user->id ?>" />
              <?php endif ?>
              
              <!-- Button -->
              <div class="form-group">
                <label class="col-md-4 control-label" for="singlebutton"></label>
                <div class="col-md-4">
                  <button type="submit" class="btn btn-info"><?php echo (isset($edit) && $edit) ? 'Modificar' : 'Crear' ?> usuario</button>
                </div>
              </div>
            
            </fieldset>
            </form>

          <div class="clearfix"></div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="clearfix"></div>