  <div class="header">
         <div class="container">
            <div class="row">
               <div class="col-md-12">
                  <!-- Logo -->
                  <div class="logo text-center">
                     <!--<img src="[mfassetpath]/Logo FACYT.png" style="width: 77px; height: 60px; top: 5px;"></img>-->
                     <h1><a href="">Servicios de Intranet</a></h1>
                  </div>
               </div>
            </div>
         </div>
      </div>
      
      <!-- Logo & Navigation ends -->
     
      
      
      <!-- Page content -->
      
      <div class="page-content">
        <div class="container">
          <div class="row">
          <br>
            <div class="col-md-12">
              <div class="awidget login-reg">

                <div class="awidget-body">
                  <!-- Page title -->
                  <div class="page-title text-center">
                    <h2>Salida</h2>
                    <hr />
                  </div>
                  <!-- Page title -->
                      <?php if($logged_in): ?>
                        <p><?= $username ?> ha sido desconectado.</p>
                        <p>Gracias por su visita <?= $name ?></p>
                      <?php else: ?>
                        <p>Tu necesitas hacer <?php echo anchor('/auth/login', 'login', ''); ?> para salir del sistema!.</p>
                      <?php endif;?>

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

    
   