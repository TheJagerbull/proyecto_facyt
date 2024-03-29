    <!-- Page content -->
<div class="mainy">
  <!-- Page title -->
  <div class="page-title">
    <h2 align="right"><i class="fa fa-user color"></i> Crear<small> usuario</small></h2> 
    <hr />
  </div>
  <!-- Page title -->
  <div class="row">
    <div class="col-md-12">
      <div class="awidget full-width">
        <?php if($this->session->flashdata('create_user') == 'error') : ?>
              <div class="alert alert-danger" style="text-align: center">Ocurrió un problema con la creacion del usuario</div>
            <?php endif ?>
        <div class="awidget-body">
          <!-- FORMULARIO DE CREACION DE USUARIOS PARA CONTROL DE LA APLICACION -->
          <!-- Formulario -->
                       <form id="newuser"class="form-horizontal" action="<?php echo base_url() ?>index.php/user/usuario/crear_usuario" method="post">
                          <div class="col-lg-12" style="text-align: center">
                                    <?php echo form_error('id_usuario'); ?>
                                    <?php echo form_error('password'); ?>
                                    <?php echo form_error('repass'); ?>
                                    <?php echo form_error('nombre'); ?>
                                    <?php echo form_error('apellido'); ?>
                                    <?php echo form_error('email'); ?>
                                    <?php echo form_error('id_dependencia'); ?>
                                    <?php echo form_error('cargo'); ?>
                                  </div>
                      <i class="color">*  Campos Obligatorios</i>
                          <!-- nombre -->
                          <div class="form-group">
                            <label class="control-label col-lg-2" for="nombre"><i class="color">*  </i>Nombre</label>
                            <div class="col-lg-6">
                              <input type="text" class="form-control" id="nombre" name="nombre" placeholder='Nombre'>
                            </div>
                          </div>
                          <!-- apellido -->
                          <div class="form-group">
                            <label class="control-label col-lg-2" for="apellido"><i class="color">*  </i>Apellido</label>
                            <div class="col-lg-6">
                              <input type="text" class="form-control" id="apellido" name="apellido" placeholder='Apellido'>
                            </div>
                          </div>                                                                                                                                         
                          <!-- cedula -->
                          <div class="form-group">
                            <label class="control-label col-lg-2" for="cedula"><i class="color">*  </i>Cedula</label>
                            <div class="col-lg-6">
                              <input type="text" class="form-control" id="cedula" name="id_usuario" placeholder='Cedula'>
                            </div>
                          </div>
                          <!-- CORREO ELECTRONICO -->
                          <div class="form-group">
                            <label class="control-label col-lg-2" for="email">Email</label>
                            <div class="col-lg-6">
                              <input type="text" class="form-control" id="email" name="email" placeholder='Correo Electronico'>
                            </div>
                          </div>
                          <!-- TELEFONO -->
                          <div class="form-group">
                            <label class="control-label col-lg-2" for="tlf">Teléfono</label>
                            <div class="col-lg-6">
                              <input type="text" class="form-control" id="tlf" name="telefono" placeholder='Numero de Teléfono o celular'>
                            </div>
                          </div>
                          <!-- contrasena -->
                          <div class="form-group">

                            <label class="control-label col-lg-2" for="password1"><i class="color">*  </i>Contrasena</label>
                            <div class="col-lg-6">
                              <input type="password" class="form-control" id="password1" name="password">
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-lg-2" for="password2"><i class="color">*  </i>Confirmar contrasena</label>
                            <div class="col-lg-6">
                              <input type="password" class="form-control" id="password2" name="repass">
                            </div>
                          </div>

                          <!-- DEPENDENCIA -->
                          <div class="form-group">
                                <label class="control-label col-lg-2" for="id_dependencia">Dependencia</label>
                                <div class="col-lg-6">
                                <select class="form-control select2" name="id_dependencia">
                                    <option value=""></option>
                                    <?php foreach ($dependencia as $dep): ?>
                                        <option value = "<?php echo $dep->id_dependencia ?>"><?php echo $dep->dependen ?></option>
                                    <?php endforeach; ?>
                                </select>
                                </div>
                            </div>
                          
                          <!-- CARGO DEL USUARIO -->
                          <div class="form-group">
                            <label class="col-lg-2 control-label" for="cargo"><i class="color">*  </i>Cargo</label>
                            <div class="col-lg-6">
                              <input type="text" class="form-control" id="cargo" name="cargo" placeholder='Cargo en la dependencia'>
                            </div>
                          </div>

                          <!-- SELECT TIPO DE USUARIO -->
                          <div class="form-group">
                            <label class="col-lg-2 control-label" for="sys_rol">Rol de sistema</label>
                            <div class="col-lg-6">
                              <select id="sys_rol" name="sys_rol" class="form-control select2">
                                <?php if($this->session->userdata('user')['sys_rol'] == 'autoridad' || $this->session->userdata('user')['sys_rol'] == 'asist_autoridad') : ?>
                                      <?php if($this->session->userdata('user')['sys_rol'] == 'autoridad') : ?>
                                            <option value="autoridad">
                                              Autoridad
                                            </option>
                                            <option value="asist_autoridad">
                                              Asistente de Autoridad
                                            </option>
                                      <?php endif ?>
                                      <option value="jefe_alm">
                                        Jefe de Almacen
                                      </option>
                                      <option value="director_dep">
                                        Director de dependencia
                                      </option>
                                  <?php endif ?>
                                  <?php if($this->session->userdata('user')['sys_rol'] != 'ayudante_alm' && $this->session->userdata('user')['sys_rol'] != 'asistente_dep') : ?>
                                    <option value="ayudante_alm">
                                      Ayudante de almacen
                                    </option>
                                  <?php endif ?>
                                <option value="asistente_dep">
                                  Asistente de dependencia
                                </option>
                                <option value="no_visible" selected >
                                  No autorizado
                                </option>
                              </select>
                            </div>
                          </div>

                          <!-- TIPO DE PERSONAL -->
                          <div class="form-group">
                            <label class="control-label col-lg-2" for="tipoP">Tipo de personal</label>
                            <div class="col-lg-6">
                              <select id="tipoP" name="tipo" class="form-control select2">
                                  <option value="docente">
                                    Docente
                                  </option>
                                  <option value="administrativo">
                                    Administrativo
                                  </option>
                                  <option value="obrero" selected>
                                    Obrero
                                  </option>
                              </select>
                            </div>
                          </div>

                          <!-- OBSERVACION -->
                          <div class="form-group">
                            <label class="control-label col-lg-2" for="ob">Observacion</label>
                            <div class="col-lg-6">
                              <textarea rows="3" type="text" class="form-control" id="ob" name="observacion"></textarea>
                            </div>
                          </div>
                      <!-- Fin de Formulario -->
                       </div>
                       <div class="modal-footer">
                         <a href="<?php echo base_url() ?>index.php/usuario/listar" class="btn btn-default">Cancelar</a>
                         <button type="submit" class="btn btn-primary">Agregar</button>
                       </div>
                      </form>
          <div class="clearfix"></div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="clearfix"></div>