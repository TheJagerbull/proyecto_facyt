<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
    <base href="<?php echo base_url() ?>" />
		<!-- Title here -->
		<title>Login - [NOMBRE DEL SISTEMA] FACYT</title>
		<!-- Description, Keywords and Author -->
    <meta name="description" content="Your description">
    <meta name="keywords" content="Your,Keywords">
    <meta name="author" content="Jose Henriquez" >
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Styles -->
    <!-- Bootstrap CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
      <!-- Animate css -->
      <link href="assets/css/animate.min.css" rel="stylesheet">
      <!-- Gritter -->
      <link href="assets/css/jquery.gritter.css" rel="stylesheet">
      <!-- Calendar -->
      <link href="assets/css/fullcalendar.css" rel="stylesheet">
      <!-- Bootstrap toggable -->
      <link href="assets/css/bootstrap-switch.css" rel="stylesheet">
      <!-- Date and Time picker -->
      <link href="assets/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
      <!-- Star rating -->
      <link href="assets/css/rateit.css" rel="stylesheet">
      <!-- Star rating -->
      <link href="assets/css/jquery.cleditor.css" rel="stylesheet">
      <!-- jQuery UI -->
      <link href="assets/css/jquery-ui.css" rel="stylesheet">
      <!-- prettyPhoto -->
      <link href="assets/css/prettyPhoto.css" rel="stylesheet">
    <!-- Font awesome CSS -->
    <link href="assets/css/font-awesome.min.css" rel="stylesheet">   
    <!-- Custom CSS -->
    <link href="assets/css/style.css" rel="stylesheet">
    
    <!-- Favicon -->
    <link rel="shortcut icon" href="form.html#">
  </head>
	
	<body>

      
      <!-- Logo & Navigation starts -->
      
      <div class="header">
         <div class="container">
            <div class="row">
               <div class="col-md-12">
                  <!-- Logo -->
                  <div class="logo text-center">
                     <!--<img src="[mfassetpath]/Logo FACYT.png" style="width: 77px; height: 60px; top: 5px;"></img>-->
                     <h1><a href="index.html">Bienvenido a [NOMBRE DEL SISTEMA] FACYT</a></h1>
                  </div>
                  <h3> <small>Debes tener tu cuenta en "alfa" activa, para poder acceder</small> </h2>
               </div>
            </div>
         </div>
      </div>
      
      <!-- Logo & Navigation ends -->
     
      
      
      <!-- Page content -->
      
      <div class="page-content blocky" style="min-height: 625px">
         <div class="container">

                  
               
                  <div class="row">
                     <div class="col-md-12">
                        <div class="awidget login-reg">
                           <div class="awidget-head">
                           
                           </div>
                           <div class="awidget-body">
                              <!-- Page title -->
                              <div class="page-title text-center">
                                 <h2>Iniciar Sesión</h2>
                                 <hr />
                              </div>
                              <!-- Page title -->
                              
                              <br />
                              <form class="form-horizontal" role="form" action="<?php echo base_url() ?>index.php/login/usuario/login" method="post">
                                
                                <div class="form-group">
                                  <div class="col-lg-12" style="text-align: center">
                                    <?php echo form_error('id'); ?>
                                    <?php echo form_error('password'); ?>
                                </div>
                                  <label for="inputUser1" class="col-lg-2 control-label">Cedula</label>
                                  <div class="col-lg-10">
                                    <input type="text" class="form-control" name="id" placeholder="de identidad" required >
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label for="inputPassword1" class="col-lg-2 control-label">Contraseña</label>
                                  <div class="col-lg-10">
                                    <input type="password" class="form-control" name="password" placeholder="Contraseña">
                                  </div>
                                </div>
                                <hr />
                                <div class="form-group">
                                  <div class="col-lg-offset-2 col-lg-10">
                                    <button type="submit" class="btn btn-info">Entrar</button>
                                  </div>
                                </div>
                              </form>
                           </div>
                        </div>
                     </div>
                  </div>
         </div>
      </div>
     
      
      
      <!-- Footer starts -->
     <footer>
         <div class="container">
         
            <div class="copy text-center">
               derechos reservados &FACYT; - <a href="">Desarrollo</a>
            </div>
            
         </div>
      </footer>
      <!-- Footer ends -->
      
      <!-- Scroll to top -->
      <span class="totop"><a href="#"><i class="fa fa-chevron-up"></i></a></span> 
      
		<!-- Javascript files -->
		<!-- jQuery -->
		<script src="assets/js/jquery.js"></script>
		<!-- Bootstrap JS -->
		<script src="assets/js/bootstrap.min.js"></script>  
      <!-- jQuery UI -->
      <script src="assets/js/jquery-ui-1.10.2.custom.min.js"></script>     
      <!-- jQuery Peity -->
      <script src="assets/js/peity.js"></script>  
      <!-- Calendar -->
      <script src="assets/js/fullcalendar.min.js"></script>  
      <!-- jQuery Star rating -->
      <script src="assets/js/jquery.rateit.min.js"></script>
      <!-- prettyPhoto -->
      <script src="assets/js/jquery.prettyPhoto.js"></script>  
      
      <!-- jQuery flot -->
      <!--[if lte IE 8]><script language="javascript" type="text/javascript" src="js/excanvas.min.js"></script><![endif]-->
      <script src="assets/js/jquery.flot.js"></script>     
      <script src="assets/js/jquery.flot.pie.js"></script>
      <script src="assets/js/jquery.flot.stack.js"></script>
      <script src="assets/js/jquery.flot.resize.js"></script>
      
      
      
      <!-- Gritter plugin -->
      <script src="assets/js/jquery.gritter.min.js"></script> 
      <!-- CLEditor -->
      <script src="assets/js/jquery.cleditor.min.js"></script> 
      <!-- Date and Time picker -->
      <script src="assets/js/bootstrap-datetimepicker.min.js"></script>  
      <!-- jQuery Toggable -->
      <script src="assets/js/bootstrap-switch.min.js"></script>
		<!-- Respond JS for IE8 -->
		<script src="assets/js/respond.min.js"></script>
		<!-- HTML5 Support for IE -->
		<script src="assets/js/html5shiv.js"></script>
		<!-- Custom JS -->
		<!--<script src="assets/js/custom.js"></script>-->
	</body>	
</html>
