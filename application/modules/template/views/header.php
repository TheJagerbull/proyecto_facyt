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
		<!-- Bootstrap CSS -->
		<link href="<?php echo base_url() ?>assets/css/bootstrap.min.css" rel="stylesheet">
      <!-- Animate css -->
      <link href="<?php echo base_url() ?>assets/css/animate.min.css" rel="stylesheet">
      <!-- Gritter -->
      <link href="<?php echo base_url() ?>assets/css/jquery.gritter.css" rel="stylesheet">
      <!-- Calendar -->
      <link href="<?php echo base_url() ?>assets/css/fullcalendar.css" rel="stylesheet">
      <!-- Bootstrap toggable -->
      <link href="<?php echo base_url() ?>assets/css/bootstrap-switch.css" rel="stylesheet">
      <!-- Date and Time picker -->
      <link href="<?php echo base_url() ?>assets/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
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
	</head>
	
	<body>

      
      <!-- Logo & Navigation starts -->
      
      <div class="header">
         <div class="container">
            <div class="row">
               <div class="col-md-3">
                  <!-- Logo -->
                  <div class="logo">
                     <h1><a href="index.html">SiSAI FACYT</a></h1>
                  </div>
               </div>
               <div class="col-md-6">
                  <div class="navbar navbar-inverse" role="banner">
                      <div class="navbar-header">
                        <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".bs-navbar-collapse">
                          <span>Menu</span>
                        </button>
                      </div>
                      <nav class="collapse navbar-collapse bs-navbar-collapse navbar-right" role="navigation">
                        <ul class="nav navbar-nav">
                          <li class="dropdown">
                            <a href="solicitud_actual.html#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-shopping-cart"></i> Solicitud actual<?php $i=rand(0,5); if($i!=0) {?><span class="label label-success"><?php } else {?><span class="label label-default"><?php } echo $i ?></span> <b class="caret"></b></a>
                            <!-- Big dropdown menu -->
                            <ul class="dropdown-menu dropdown-big animated fadeInUp">
                              <!-- Dropdown menu header -->
                              <div class="dropdown-head">
                                 <span class="dropdown-title">Articulos agregados</span>
                              </div>
                              <!-- Dropdown menu body -->
                              <div class="dropdown-body">
                                <!--
                                  <li><i class="fa fa-comments color"></i> <a href="form.html#">Vasos plasticos medianos</a><span class="label label-info pull-right">3</span></li>
                                 <li><i class="fa fa-comments color"></i> <a href="form.html#">Marcadores para pizarras acrilicas</a><span class="label label-info pull-right">10</span></li>
                                 <li><i class="fa fa-comments color"></i> <a href="form.html#">Papel Bond tamano carta</a><span class="label label-info pull-right">8</span></li>
                                 <li><i class="fa fa-comments color"></i> <a href="form.html#">clips</a><span class="label label-info pull-right">5</span></li>
                               -->
                              </div>
                              <!-- Dropdown menu footer -->
                              <div class="dropdown-foot text-center">
                                 <a href="solicitud_actual.html#">Ver solicitud</a>
                              </div>
                            </ul>
                          </li>
                          <li class="dropdown">
                            <a href="index.html#" class="dropdown-toggle" data-toggle="dropdown">
                              <?php echo ucfirst($this->session->userdata('user')->nombre).' '.ucfirst($this->session->userdata('user')->apellido) ?> <b class="caret"> </b>
                            </a>
                            <ul class="dropdown-menu animated fadeInUp">
                              <li><a href="<?php echo base_url() ?>index.php/usuario/detalle/<?php echo $this->session->userdata('user')->ID ?>">
                              <i class="fa fa-user"></i> Perfil</a></li>
                              <li><a href="<?php echo base_url() ?>index.php/usuario/cerrar-sesion">
                              <i class="fa fa-lock"></i> Cerrar Sesion</a></li>
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
                            <?php if($this->session->userdata('user')->sys_rol!='asistente_dep'&&$this->session->userdata('user')->sys_rol!='ayudante_alm'):?>
                            <li class="has_submenu">
                                 <a href="index.html#">
                                    <i class="fa fa-cog"></i> Administracion
                                    <span class="caret pull-right"></span>
                                 </a>
                                 <!-- Sub menu -->
                                 <ul>
                                  <?php if($this->session->userdata('user')->sys_rol!='asistente_dep'&&$this->session->userdata('user')->sys_rol!='ayudante_alm'):?>
                                    <li><a href="registro_art.html">Insertar Articulo</a></li>
<!--                                    <li><a href="tables.html">Activar/Desactivar</a></li> -->
                                    <li><a href="#">Consultar solicitudes</a></li>
                                    <li><a href="#">Autorizar solicitudes</a></li>
                                    <li><a href="<?php echo base_url() ?>index.php/usuario/listar">Usuarios</a></li>
                                  <?php endif ?>
                                </ul>
                            </li>
                          <?php endif ?>
                            <li class="has_submenu">
                                <a href="index.html#">
                                    <i class="fa fa-th"></i> Almacen
                                    <span class="caret pull-right"></span>
                                </a>
                                <ul>
                                    <li><a href="#">Generar solicitud</a></li>
                                    <li><a href="usr_consulta_solicitud.html">Consultar solicitudes</a></li>
                                    <li><a href="solicitud_actual.html">Editar solicitud</a></li>
                                    <!--<li><a href="solicitud_actual.html.html">Eliminar</a></li> -->
                                </ul>
                            </li> 
                            <li class="has_submenu">
                                <a href="index.html#">
                                    <i class="fa fa-wrench"></i> Mantenimiento
                                    <span class="caret pull-right"></span>
                                </a>
                                <ul>
                                    <li><a href="#">Generar solicitud</a></li>
                                    <li><a href="usr_consulta_solicitud.html">Consultar solicitudes</a></li>
                                    <li><a href="solicitud_actual.html">Editar solicitud</a></li>
                                    <!--<li><a href="solicitud_actual.html.html">Eliminar</a></li> -->
                                </ul>
                            </li> 
                          <!--  <li><a href="calendar.html"><i class="fa fa-calendar"></i> Calendar</a></li>-->
                        </ul>
                     </div>
                  </div>