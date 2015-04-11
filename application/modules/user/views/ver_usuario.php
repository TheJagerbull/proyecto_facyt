        <div class="mainy">
               <!-- Page title -->
               <div class="page-title">
                  <h2><i class="fa fa-desktop color"></i> Perfil 
                    <small>Rol asignado en sistema: <?php 
                    if($this->session->userdata('user')->sys_rol=='autoridad')
                      echo 'Autoridad';
                    if($this->session->userdata('user')->sys_rol=='asist_autoridad')
                      echo 'Asistente de Autoridad';
                    if($this->session->userdata('user')->sys_rol=='jefe_alm')
                      echo 'Jefe de Almacen';
                    if($this->session->userdata('user')->sys_rol=='director_dep')
                    {
                      echo 'Director del Departamento de ';
                      echo $this->session->userdata('user')->dependencia;
                    }
                    if($this->session->userdata('user')->sys_rol=='asistente_dep')
                    {
                      echo 'Asistente del Departamento de';
                      echo $this->session->userdata('user')->dependencia;
                    }
                    if($this->session->userdata('user')->sys_rol=='ayudante_alm')
                      echo 'Ayudante de Almacen';

                    ?></small></h2>
                  <hr />
               </div>
               <!-- Page title -->
               
                  <div class="row">
                     <div class="col-md-12">
                     
                        <div class="awidget full-width">
                           <div class="awidget-head">
                              <h3>Mi Perfil de Usuario</h3>
                           </div>
                           <div class="awidget-body">
                              <div class="row">
                                 <div class="col-md-3 col-sm-3">
                                    <a href="profile.html#"></a>
                                 </div>
                                 <div class="col-md-9 col-sm-9">
                                    <table class="table">
                                    
                                       <tr>
                                          <td><strong>Nombre y Apellido</strong></td>
                                          <td>:</td>
                                          <td><?php echo ucfirst($this->session->userdata('user')->nombre).' '.ucfirst($this->session->userdata('user')->apellido) ?></td>
                                       </tr>
                                       <tr>
                                          <td><strong>Cedula de Identidad</strong></td>
                                          <td>:</td>
                                          <td><?php echo $this->session->userdata('user')->id_usuario ?></td>
                                       </tr>
                                       <tr>
                                          <?php if($this->session->userdata('user')->email!='') :?>
                                            <td><strong>Email</strong></td>
                                            <td>:</td>
                                            <td><?php echo $this->session->userdata('user')->email ?></td>
                                           <?php endif?>
                                       </tr>
                                       <tr>
                                          <?php if($this->session->userdata('user')->telefono!='') :?>
                                          <td><strong>Numero de Telefono</strong></td>
                                          <td>:</td>
                                          <td><?php echo $this->session->userdata('user')->telefono ?></td>
                                           <?php endif?>
                                       </tr>
                                       <tr>
                                          <td><strong>Dependencia</strong></td>
                                          <td>:</td>
                                          <td><?php echo $this->session->userdata('user')->dependencia ?></td>
                                       </tr>
                                       <tr>
                                          <td><strong>Cargo</strong></td>
                                          <td>:</td>
                                          <td><?php echo $this->session->userdata('user')->cargo ?></td>
                                       </tr>
                                       
                                    </table>
                                 </div>
                              </div>
                           </div>
                        </div>
                        
                        
                        <div class="awidget full-width">
                           <div class="awidget-head">
                              <h3>Update Profile</h3>
                           </div>
                           <div class="awidget-body">
                                 
                                 <!-- Profile form -->
                   
                                    <div class="form profile">
                                      <!-- Edit profile form (not working)-->
                                      <form class="form-horizontal">
                                          <!-- nombre -->
                                          <div class="form-group">
                                            <label class="control-label col-lg-2" for="name1">Nombre</label>
                                            <div class="col-lg-6">
                                              <input type="text" class="form-control" id="name1">
                                            </div>
                                          </div>
                                          <!-- apellido -->
                                          <div class="form-group">
                                            <label class="control-label col-lg-2" for="name1">Apellido</label>
                                            <div class="col-lg-6">
                                              <input type="text" class="form-control" id="name1">
                                            </div>
                                          </div>                                                                                                                                         
                                          <!-- cedula -->
                                          <div class="form-group">
                                            <label class="control-label col-lg-2" for="username2">Cedula</label>
                                            <div class="col-lg-6">
                                              <input type="text" class="form-control" id="username2">
                                            </div>
                                          </div>
                                          <!-- contrasena -->
                                          <div class="form-group">
                                            <label class="control-label col-lg-2" for="password2">Contrasena</label>
                                            <div class="col-lg-6">
                                              <input type="password" class="form-control" id="password2">
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="control-label col-lg-2" for="password2">Confirmar Contrasena</label>
                                            <div class="col-lg-6">
                                              <input type="password" class="form-control" id="password2">
                                            </div>
                                          </div>
                                          <!-- Checkbox -->
                                          <!--<div class="form-group">
                                             <div class="col-lg-6 col-lg-offset-2">
                        
                                                <label class="checkbox inline">
                                                   <input type="checkbox" id="inlineCheckbox3" value="agree"> Agree with Terms and Conditions
                                                </label>
                                             </div>
                                          </div> -->
                                          
                                          <!-- Buttons -->
                                          <div class="form-group">
                                             <!-- Buttons -->
                                              <div class="col-lg-6 col-lg-offset-2">
                                                <button type="submit" class="btn btn-info">Update</button>
                                                <button type="reset" class="btn btn-default">Reset</button>
                                             </div>
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