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
                <link href="<?php echo base_url() ?>assets/css/dataTables.bootstrap.css" rel="stylesheet">
                <link href= "<?php echo base_url() ?>assets/css/select2-bootstrap.css" rel="stylesheet"/>

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
     
	</head>
	
	<body>


      <!-- Logo & Navigation starts -->
<!-- tamano de la session-->
      <?php echo 'tamaño de session: '.((strlen(serialize($this->session->all_userdata()))) * 8 / 1000).' KB';// para verificar cuanto espacio hay ocupado en la session?>
<!-- fin de tamano de la session-->
      <div class="header">
         <div class="container">
            <div class="row">
               <div class="col-md-3">
                  <!-- Logo -->
                  <div class="logo">
                     <h1><a href="<?php echo base_url() ?>index.php/air_home/index">SiSAI FACYT</a></h1>
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
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-shopping-cart"></i> Solicitud actual<?php $i=0; if(!empty($this->session->userdata('articulos'))){ $i=count($this->session->userdata('articulos'));} if($i!=0) {?><span class="label label-success"><?php } else {?><span class="label label-default"><?php } echo $i ?></span> <b class="caret"></b></a>
                            <!-- Big dropdown menu -->
                            <ul class="dropdown-menu dropdown-big animated fadeInUp">
                              <!-- Dropdown menu header -->
                              <div class="dropdown-head">
                                <?php if(!empty($this->session->userdata('nr_solicitud'))) :?>
                                  <span class="dropdown-title">Articulos agregados</span>
                                <?php else :?>
                                  <span class="dropdown-title">Agregar articulos <a href="<?php echo base_url() ?>index.php/solicitud/inventario/"><i class="fa fa-plus color"></i></a></span>
                                <?php endif?>
                                 
                              </div>
                              <!-- Dropdown menu body -->
                              <div class="dropdown-body">
                                <?php if(!empty($this->session->userdata('articulos')[0]['descripcion'])) :?>
                                  <?php foreach ($this->session->userdata('articulos') as $key => $articulo) :?>
                                      <li><i class="fa fa-chevron-right color"></i> <?php echo $articulo['descripcion']; ?><span class="label label-info pull-right"> <?php echo $articulo['cant']; ?></span></li>
                                <!--
                                 <li><i class="fa fa-comments color"></i> <a href="form.html#">Marcadores para pizarras acrilicas</a><span class="label label-info pull-right">10</span></li>
                                 <li><i class="fa fa-comments color"></i> <a href="form.html#">Papel Bond tamano carta</a><span class="label label-info pull-right">8</span></li>
                                 <li><i class="fa fa-comments color"></i> <a href="form.html#">clips</a><span class="label label-info pull-right">5</span></li>
                               -->
                                  <?php endforeach ?>
                                <?php else:?>
                                  <?php if(!is_array($this->session->userdata('articulos')[1]) && !empty($this->session->userdata('nr_solicitud'))):?>
                                    <div class="alert alert-warning"><i>Debe guardar la solicitud, para mostrar los articulos agregados</i>
                                    </div>
                                  <?php else :?>
                                    <div class="alert alert-info"><i>Debe generar una solicitud, para mostrar articulos agregados</i>
                                    </div>
                                  <?php endif?>
                                <?php endif?>
                              </div>
                              <!-- Dropdown menu footer -->
                              <div class="dropdown-foot text-center">
                                <?php if(!empty($this->session->userdata('nr_solicitud'))) :?>
                                  <a href="<?php echo base_url() ?>index.php/solicitud/editar/<?php echo $this->session->userdata('nr_solicitud')?>">Ver solicitud</a>
                                <?php else :?>
                                  <a href="<?php echo base_url() ?>index.php/solicitud/ver_solicitud">Ver solicitudes</a>
                                <?php endif?>
                              </div>
                            </ul>
                          </li>
                          <li class="dropdown">
                            <a href="index.html#" class="dropdown-toggle" data-toggle="dropdown">
                              <!--<?php echo ucfirst($this->session->userdata('user')->nombre).' '.ucfirst($this->session->userdata('user')->apellido) ?> <b class="caret"> </b>-->
                              <?php echo ucfirst($this->session->userdata('user')['nombre']).' '.ucfirst($this->session->userdata('user')['apellido']) ?> <b class="caret"> </b>
                            </a>
                            <ul class="dropdown-menu animated fadeInUp">
                              <li><a href="<?php echo base_url() ?>index.php/usuario/detalle/<?php echo $this->session->userdata('user')['ID'] ?>">
                              <i class="fa fa-user"></i> Perfil</a></li>
                              <li><a href="<?php echo base_url() ?>index.php/usuario/detalle/<?php echo $this->session->userdata('user')['ID'] ?>">
                              <i class="fa fa-user"></i> Cambiar contrase&ntilde;a</a></li>
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
                            <?php if($this->session->userdata('user')['sys_rol']!='asistente_dep'&&$this->session->userdata('user')['sys_rol']!='ayudante_alm'):?>
                            <li class="has_submenu">
                                 <a href="index.html#">
                                    <i class="fa fa-cog"></i> Administracion
                                    <span class="caret pull-right"></span>
                                 </a>
                                 <!-- Sub menu -->
                                 <ul>
                                  <?php if($this->session->userdata('user')['sys_rol']!='asistente_dep'&&$this->session->userdata('user')['sys_rol']!='ayudante_alm'):?>
                                    <li><a href="<?php echo base_url() ?>index.php/alm_articulos/insertar_articulo">Inventario</a></li>
<!--                                    <li><a href="tables.html">Activar/Desactivar</a></li> -->
                                    <li><a href="<?php echo base_url() ?>index.php/administrador/solicitudes">Solicitudes de almacen</a></li>
                                    <li><a href="<?php echo base_url() ?>index.php/alm_solicitudes/autorizar_solicitudes">Autorizar solicitudes</a></li>
                                    <li><a href="<?php echo base_url() ?>index.php/usuario/listar">Control de usuarios</a></li>
                                  <?php endif ?>
                                </ul>
                            </li>
                          <?php endif ?>
                            <li class="has_submenu">
                                <a href="<?php echo base_url() ?>index.php/alm_solicitudes/">
                                    <i class="fa fa-th"></i> Almacen
                                    <span class="caret pull-right"></span>
                                </a>
                                <ul>
                                    <li><a href="<?php echo base_url() ?>index.php/solicitud/inventario/">Generar solicitud</a></li>
                                    <li><a href="<?php echo base_url() ?>index.php/solicitud/consultar">Consultar solicitudes</a></li>
                                    <!-- <li><a href="<?php echo base_url() ?>index.php/solicitud/editar">Editar solicitud</a></li> -->
                                    <!--<li><a href="solicitud_actual.html.html">Eliminar</a></li> -->
                                </ul>
                            </li> 
                            <!-- Modificado por Juan Parra 30 Abril 2015 -->
                            <li class="has_submenu">
                                <a href="<?php echo base_url() ?>index.php/mnt_solicitudes/">
                                    <i class="fa fa-wrench"></i> Mantenimiento
                                    <span class="caret pull-right"></span>
                                </a>
                                <ul>
                                    <li><a href="<?php echo base_url() ?>index.php/mnt_cuadrilla">Administrar cuadrilla</a></li>
                                    <li><a href="<?php echo base_url() ?>index.php/mnt_solicitudes/lista_solicitudes">Consultar solicitud</a></li>
                                    <li><a href="<?php echo base_url() ?>index.php/mnt_solicitudes/solicitud">Generar solicitud</a></li>
<!--                                    <li><a href="<?php // echo base_url() ?>index.php/mnt_solicitudes/prueba">Prueba</a></li>-->
                                    <!--<li><a href="solicitud_actual.html.html">Eliminar</a></li> -->
                                </ul>
                            </li> 
                            <!-- Agregado por Jose Henriquez 13 de abril 2015, modificado 15-06-2015 -->
                            <li class="has_submenu">
                                <a href="index.html#">
                                    <i class="fa fa-wrench"></i> Mantenimientos Aires
                                    <span class="caret pull-right"></span>
                                </a>
                                <ul>
                                    <li><a href="<?php echo base_url() ?>index.php/inv_equipos/equipos/listar_equipos">Administración de equípos</a></li>
                                    <li><a href="<?php echo base_url() ?>index.php/air_tipoeq/tipoeq/index">Tipos de equipos</a></li>
                                    <li><a href="<?php echo base_url() ?>index.php/air_mntprvitm/itemmp/index">Items mant. preventivo</a></li>
                                    <li><a href="<?php echo base_url() ?>index.php/air_cntrl_mp_equipo/cntrlmp/index">Control Mantenimiento</a></li>
                                    <li><a href="solicitud_actual.html">Editar solicitud</a></li>
                                    <!--<li><a href="solicitud_actual.html.html">Eliminar</a></li> -->
                                </ul>
                            </li> 

                          <!--  <li><a href="calendar.html"><i class="fa fa-calendar"></i> Calendar</a></li>-->
                        </ul>
                     </div>
                  </div>