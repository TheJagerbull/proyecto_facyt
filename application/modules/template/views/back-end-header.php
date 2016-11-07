<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<!-- Title here -->
    <!-- en el controlador, se debe llenar una variable que contenga ['title'], y asignarle el nombre que tomara la pagina que va a cargar
    por ejemplo, $header['title']= 'solicitudes';luego, cuando se valla a cargar la vista, se le manda la variable de la siguiente forma
    $this->load->view('includes/header',$header);-->
		<title><?php echo (isset($title) && !empty($title)) ? $title.' | SiSAI FACYT' : 'SiSAI FACYT' ?></title>
		<!-- Description, Keywords and Author -->
		<meta name="description" content="Your description">
		<meta name="keywords" content="Your,Keywords">
		<meta name="author" content="ResponsiveWebInc">
		
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<!-- Styles -->
                <!-- Select2 CSS -->
                 <link href= "<?php echo base_url() ?>assets/css/select2.css" rel="stylesheet"/>
		<!-- Bootstrap CSS -->
		<link href="<?php echo base_url() ?>assets/css/bootstrap.min.css" rel="stylesheet">
                <link href="<?php echo base_url() ?>assets/css/bootstrap-touchspin.css" rel="stylesheet">
                <link href="<?php echo base_url() ?>assets/css/dataTables.bootstrap.css" rel="stylesheet">
                <link href= "<?php echo base_url() ?>assets/css/select2-bootstrap.css" rel="stylesheet"/>
     
      <!-- Modal by jcparra css -->
      <link href="<?php echo base_url() ?>assets/css/modal.css" rel="stylesheet">
      <!-- Animate css -->
      <link href="<?php echo base_url() ?>assets/css/animate.min.css" rel="stylesheet">
      <!-- Sweet-alert css -->
      <link href="<?php echo base_url() ?>assets/css/sweet-alert.css" rel="stylesheet">
      <!-- Gritter -->
      <link href="<?php echo base_url() ?>assets/css/jquery.gritter.css" rel="stylesheet">
      <!-- Calendar -->
      <link href="<?php echo base_url() ?>assets/css/fullcalendar.css" rel="stylesheet">
      <!-- Bootstrap toggable -->
      <link href="<?php echo base_url() ?>assets/css/bootstrap-switch.css" rel="stylesheet">
      <!-- Date and Time picker -->
      <link href="<?php echo base_url() ?>assets/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<!--      <link href="<?php //echo base_url() ?>assets/css/bootstrap-datepicker.css" rel="stylesheet">-->
      <link href="<?php echo base_url() ?>assets/css/daterangepicker-bs3.css" rel="stylesheet">
      <!-- Star rating -->
      <link href="<?php echo base_url() ?>assets/css/rateit.css" rel="stylesheet">
      <!-- Star rating -->
      <link href="<?php echo base_url() ?>assets/css/jquery.cleditor.css" rel="stylesheet">
      <!-- jQuery UI -->
      <link href="<?php echo base_url() ?>assets/css/jquery-ui.css" rel="stylesheet">
      <!-- prettyPhoto -->
      <link href="<?php echo base_url() ?>assets/css/prettyPhoto.css" rel="stylesheet">
		<!-- Font awesome CSS -->
		<link href="<?php echo base_url() ?>assets/css/font-awesome.min.css" rel="stylesheet">		
		<!-- Custom CSS -->
		<link href="<?php echo base_url() ?>assets/css/style.css" rel="stylesheet"> 	
		<!-- Favicon -->
		<link rel="shortcut icon" href="#">
    <!-- FileInput -->
    <link href= "<?php echo base_url() ?>assets/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css">
     <!-- prettify for bootstrapWizard -->
  <link href="<?php echo base_url() ?>assets/css/prettify.css" rel="stylesheet">
	</head>
	
	<body>


      <!-- Logo & Navigation starts -->
<!-- tamano de la session-->
      <!--<?php //echo 'tamaño de session: '.((strlen(serialize($this->session->all_userdata()))) * 8 / 1000).' KB';// para verificar cuanto espacio hay ocupado en la session?>-->
<!-- fin de tamano de la session-->
      <div class="header">
         <div class="container">
            <div class="row">
               <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                  <!-- Logo -->
                  <div class="logo">
                     <h1><a href="<?php echo base_url() ?>inicio"><img src="<?php echo base_url() ?>assets/img/FACYT_1.png" class="img-rounded" alt="bordes redondeados" width="45" height="45">SiSAI FACYT</a></h1>
                  </div>
               </div>
               <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                  <div class="navbar navbar-inverse" role="banner">
                      <div class="navbar-header">
                        <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".bs-navbar-collapse">
                          <span>Menu</span>
                        </button>
                      </div>
                      <nav class="collapse navbar-collapse bs-navbar-collapse navbar-right" role="navigation">
                        <ul class="nav navbar-nav">
                          <li class="dropdown">
                            <a href="index.html#" class="dropdown-toggle" data-toggle="dropdown">
                              <!--<?php echo ucfirst($this->session->userdata('user')->nombre).' '.ucfirst($this->session->userdata('user')->apellido) ?> <b class="caret"> </b>-->
                              <?php echo ucfirst($this->session->userdata('user')['nombre']).' '.ucfirst($this->session->userdata('user')['apellido']) ?> <b class="caret"> </b>
                            </a>
                            <ul class="dropdown-menu animated fadeInUp">
                              <li><a href="<?php echo base_url() ?>usuario/detalle/<?php echo $this->session->userdata('user')['ID'] ?>">
                              <i class="fa fa-user"></i> Perfil</a></li>
                              <li><a href="<?php echo base_url() ?>usuario/cerrar-sesion">
                              <i class="fa fa-lock"></i> Cerrar sesion</a></li>
                            </ul>
                          </li>
                        </ul>
                      </nav>
                  </div>
               </div>
            </div>
         </div>
      </div>
      
      <!-- Logo & Navigation ends -->
      
      <!-- Page content -->
      
      <div class="page-content blocky">
        <div class="container">
                
                  <div class="sidebar-dropdown"><a href="index.html#">MENU</a></div>
                  <div class="sidey">
                     <div class="side-cont">
                        <ul class="nav">
                            <!-- Main menu -->
                            
                              <li class="has_submenu">
                                   <a href="index.html#">
                                      <i class="fa fa-cog"></i> Administracion
                                      <span class="caret pull-right"></span>
                                   </a>
                                   <!-- Sub menu -->
                                   <ul>
                                      <li><a href="<?php echo base_url() ?>usuario/listar">Control de usuarios</a></li>
                                      <li><a href="<?php echo base_url() ?>usuarios/permisos">Control de acceso</a></li>
                                      <li><a href="<?php echo base_url() ?>dependencia/listar">Control de dependencias</a></li>
                                  </ul>
                              </li>
                          <!--  <li><a href="calendar.html"><i class="fa fa-calendar"></i> Calendar</a></li>-->
                        </ul>
                     </div>
                  </div>