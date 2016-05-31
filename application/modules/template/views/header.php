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
		<link rel="icon" type="image/x-icon" href="<?php echo base_url() ?>assets/img/FACYT4.png" />
		
		<!-- Styles -->
		<!-- Select2 CSS -->
		<link href= "<?php echo base_url() ?>assets/css/select2.css" rel="stylesheet"/>
		<!-- Bootstrap CSS -->
		<link href="<?php echo base_url() ?>assets/css/bootstrap.min.css" rel="stylesheet">
                <link href="<?php echo base_url() ?>assets/css/bootstrap-touchspin.css" rel="stylesheet">
                <link href="<?php echo base_url() ?>assets/css/dataTables.bootstrap.css" rel="stylesheet">
                <!--<link href="<?php echo base_url() ?>assets/css/responsive.bootstrap.css" rel="stylesheet">-->
                <link href="<?php echo base_url() ?>assets/css/buttons.bootstrap.min.css" rel="stylesheet">
                <link href= "<?php echo base_url() ?>assets/css/select2-bootstrap.css" rel="stylesheet"/>
                <link href= "<?php echo base_url() ?>assets/css/bootstrap-vertical-tabs.css" rel="stylesheet"/>
    
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
<?php 
  $aux=$this->session->userdata('articulos');
  $aux2=$this->session->userdata('id_carrito');
?>
      <div class="header">
         <div class="container">
            <div class="row">
               <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                  <!-- Logo -->
                  <div class="logo">
                     <h1><a href="<?php echo base_url() ?>index.php/inicio"><img src="<?php echo base_url() ?>assets/img/FACYT_1.png" class="img-rounded" alt="bordes redondeados" width="45" height="45">SiSAI FACYT</a></h1>
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
                          <?php //if($this->session->userdata('user')['sys_rol']=='autoridad'||$this->session->userdata('user')['sys_rol']=='asist_autoridad'):?>
                          <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src="<?php echo base_url() ?>assets/img/alm/solicitud_actual4.png" class="img-rounded" alt="bordes redondeados" width="25" height="23">  Solicitud actual<?php $i=0; if(!empty($aux)){ $i=count($this->session->userdata('articulos'));} if($i!=0) {?><span id="cart_nr" class="label label-success"><?php } else {?><span id="cart_nr" class="label label-default"><?php } echo $i ?></span> <b class="caret"></b></a>
                            <!-- Big dropdown menu -->
                            <ul class="dropdown-menu dropdown-big animated fadeInUp">
                              <!-- Dropdown menu header -->
                              <div class="dropdown-head">
                                <?php if(($this->session->userdata('id_carrito')!=NULL) && !empty($aux2)) :?>
                                  <span class="dropdown-title">Artículos agregados</span>
                                <?php else :?>
                                  <span class="dropdown-title">Agregar artículos <a href="<?php echo base_url() ?>index.php/solicitud/inventario/"><i class="fa fa-plus color"></i></a></span>
                                <?php endif?>
                                 
                              </div>
                              <!-- Dropdown menu body -->
                              <div class="dropdown-body">
                                <?php if(isset($this->session->userdata('articulos')[0]['descripcion']) && !empty($aux[0]['descripcion'])) :?>
                                  <?php foreach ($this->session->userdata('articulos') as $key => $articulo) :?>
                                      <li><i class="fa fa-chevron-right color"></i> <?php echo $articulo['descripcion']; ?><span class="label label-info pull-right"> <?php echo $articulo['cant']; ?></span></li>
                                  <?php endforeach ?>
                                <?php else:?>
                                  <?php if(($this->session->userdata('id_carrito')!=NULL) && !is_array($this->session->userdata('articulos')[1]) && !empty($aux2)):?>
                                    <div id="cart" class="alert alert-warning"><i>Debe guardar la solicitud, para mostrar los articulos agregados</i>
                                    </div>
                                  <?php else :?>
                                    <div id="cart" class="alert alert-info"><i>Debe generar una solicitud, para mostrar articulos agregados</i>
                                    </div>
                                  <?php endif?>
                                <?php endif?>
                              </div>
                              <!-- Dropdown menu footer -->
                              <div class="dropdown-foot text-center">
                                <?php if(($this->session->userdata('id_carrito')!=NULL) && !empty($aux2)) :?>
                                  <a href="<?php echo base_url() ?>index.php/solicitud/editar/<?php echo $this->session->userdata('id_carrito')?>">Ver solicitud</a>
                                <?php else :?>
                                  <?php if(!empty($solicitudesDependencia) && isset($solicitudesDependencia)):?>
                                    <a href="<?php echo base_url() ?>index.php/solicitud/ver_solicitud">Ver solicitudes</a>
                                  <?php endif;?>
                                <?php endif?>
                              </div>
                            </ul>
                          </li>
                          <?php //endif?>
                          <li class="dropdown">
                            <a href="index.html#" class="dropdown-toggle" data-toggle="dropdown">
                              <!--<?php echo ucfirst($this->session->userdata('user')->nombre).' '.ucfirst($this->session->userdata('user')->apellido) ?> <b class="caret"> </b>-->
                              <?php echo ucfirst($this->session->userdata('user')['nombre']).' '.ucfirst($this->session->userdata('user')['apellido']) ?> <b class="caret"> </b>
                            </a>
                            <ul class="dropdown-menu animated fadeInUp">
                              <li><a href="<?php echo base_url() ?>index.php/usuario/detalle/<?php echo $this->session->userdata('user')['ID'] ?>">
                              <i class="fa fa-user"></i> Perfil</a></li>
                              <li><a href="<?php echo base_url() ?>index.php/usuario/cerrar-sesion">
                              <i class="fa fa-lock"></i> Cerrar sesion</a></li>
                            </ul>
                          </li>
                          <li class="dropdown">
                            <a id="currentTime" class="dropdown-toggle" data-toggle="dropdown">0:00:00 am
                            </a>
                          </li>
                        </ul>
                      </nav>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <script type="text/javascript">
        base_url = '<?php echo base_url()?>';
      </script>
      <!-- Logo & Navigation ends -->
      
      <!-- Page content -->
      
      <div class="page-content blocky">
        <div class="container">
                
                  <div class="sidebar-dropdown"><a href="index.html#">MENU</a></div>
                  <div class="sidey">
                 
                 
                     <div class="side-cont">
                        <ul class="nav">
                            <!-- Main menu -->
                            <?php //if($this->session->userdata('user')['sys_rol']!='asistente_dep'&&$this->session->userdata('user')['sys_rol']!='ayudante_alm'):?>
                            <?php if($this->session->userdata('user')['sys_rol']=='autoridad'||$this->session->userdata('user')['sys_rol']=='asist_autoridad'):?>
                              <li class="has_submenu">
                                   <a href="index.html#">
                                      <i class="fa fa-cog"></i> Administracion
                                      <span class="caret pull-right"></span>
                                   </a>
                                   <!-- Sub menu -->
                                   <ul>
                                    <?php if($this->session->userdata('user')['sys_rol']!='asistente_dep'&&$this->session->userdata('user')['sys_rol']!='ayudante_alm'):?>
                                      <li><a href="<?php echo base_url() ?>index.php/usuario/listar">Control de usuarios</a></li>
                                      <li><a href="<?php echo base_url() ?>index.php/usuarios/permisos">Control de acceso</a></li>
                                      <li><a href="<?php echo base_url() ?>index.php/dependencia/listar">Control de dependencias</a></li>
                                    <?php endif ?>
                                  </ul>
                              </li>
                            <?php endif ?>
                            <?php //if($this->session->userdata('user')['sys_rol']=='autoridad'||$this->session->userdata('user')['sys_rol']=='asist_autoridad'):?>
                          <?php if(!(empty($inventario) && empty($solicitudes) && empty($almGenerarSolicitud) && empty($solicitudesDependencia))):?>
                            <li class="has_submenu">
                                <a href="<?php echo base_url() ?>index.php/alm_solicitudes/">
                                    <i class="fa fa-th"></i> Almacen
                                    <span class="caret pull-right"></span>
                                </a>
                                <ul>
                                  <?php //if($this->session->userdata('user')['sys_rol']=='jefe_alm' || $this->session->userdata('user')['sys_rol']=='asist_autoridad' || $this->session->userdata('user')['sys_rol']=='autoridad'):?>
                                    <?php if(!empty($inventario) && isset($inventario)):?><li><a href="<?php echo base_url() ?>index.php/inventario">Inventario<!-- <span class="label label-warning">en prueba</span> --></a></li><?php endif;?>
                                    <?php if(!empty($solicitudes) && isset($solicitudes)):?><li><a href="<?php echo base_url() ?>index.php/administrador/solicitudes">Solicitudes<!--<span class="label label-danger">en construccion</span>--></a></li><?php endif;?>
                                    <!-- <li><a href="<?php echo base_url() ?>index.php/alm_solicitudes/autorizar_solicitudes">Autorizar solicitudes<span class="label label-danger">en construccion</span></a></li> -->
                                  <?php //endif ?>
                                  <?php if($this->session->userdata('user')['sys_rol']!='jefe_alm'):?>
                                    <?php if(!empty($almGenerarSolicitud) && isset($almGenerarSolicitud)):?><li><a href="<?php echo base_url() ?>index.php/solicitud/inventario/">Generar solicitud<!-- <span class="label label-danger">en construccion</span> --></a></li><?php endif;?>
                                    <?php if(!empty($solicitudesDependencia) && isset($solicitudesDependencia)):?><li><a href="<?php echo base_url() ?>index.php/solicitud/consultar">Solicitudes de Dependencia<!-- <span class="label label-danger">en construccion</span> --></a></li><?php endif;?>
                                  <?php endif ?>
                                </ul>
                            </li> 
                          <?php endif;?>
                            <?php //endif?>
                            <!-- Modificado por Juan Parra 30 Abril 2015 -->
                          <?php if(!(empty($AdministrarCuadrilla) && empty($agregarUbicaciones) && empty($consultarSolicitud) && empty($mntGenerarSolicitud) && empty($reportes))):?>
                            <li class="has_submenu">
                                <a href="<?php echo base_url() ?>index.php/mnt_solicitudes/">
                                    <i class="fa fa-wrench"></i> Mantenimiento
                                    <span class="caret pull-right"></span>
                                </a>
                                <ul>
                                  <?php // if($this->session->userdata('user')['sys_rol']=='autoridad'|| $this->session->userdata('user')['sys_rol'] == 'jefe_mnt'):?>
                                    <?php if(!empty($AdministrarCuadrilla) && isset($AdministrarCuadrilla)):?><li><a href="<?php echo base_url() ?>index.php/mnt_cuadrilla">Administrar cuadrilla</a></li><?php endif;?>
                                    <?php if(!empty($agregarUbicaciones) && isset($agregarUbicaciones)):?><li><a href="<?php echo base_url() ?>index.php/mnt_ubicaciones/agregar_ubicacion">Agregar ubicaciones</a></li><?php endif;?>
                                  <?php // endif ?>
                                    <?php if(!empty($consultarSolicitud) && isset($consultarSolicitud)):?><li><a href="<?php echo base_url() ?>index.php/mnt_solicitudes/lista_solicitudes">Consultar solicitud</a></li><?php endif;?>
                                    <?php if(!empty($mntGenerarSolicitud) && isset($mntGenerarSolicitud)):?><li><a href="<?php echo base_url() ?>index.php/mnt_solicitudes/solicitud">Generar solicitud</a></li><?php endif;?>
                                  <?php // if($this->session->userdata('user')['sys_rol']=='autoridad'|| $this->session->userdata('user')['sys_rol'] == 'jefe_mnt'):?>
                                    <?php if(!empty($reportes) && isset($reportes)):?><li><a href="<?php echo base_url() ?>index.php/mnt_solicitudes/reportes">Reportes</a></li><?php endif;?>
                                  <?php // endif ?>
<!--                                    <li><a href="<?php // echo base_url() ?>index.php/mnt_solicitudes/prueba">Prueba</a></li>-->
                                    <!--<li><a href="solicitud_actual.html.html">Eliminar</a></li> -->
                                </ul>
                            </li>
                          <?php endif;?>
                            <!-- Agregado por Jose Henriquez 13 de abril 2015, modificado 15-06-2015 -->
                            <?php //if($this->session->userdata('user')['sys_rol']=='autoridad'||$this->session->userdata('user')['sys_rol']=='asist_autoridad'):?>
                           <?php if(!(empty($administracionEquipos) && empty($tiposEquipos) && empty($itemsPreventivo) && empty($controlMantenimiento) && empty($editarSolicitud))):?> 
                            <li class="has_submenu">
                                <a href="index.html#">
                                    <i class="fa fa-wrench"></i> Mantenimientos aires
                                    <span class="caret pull-right"></span>
                                </a>
                                <ul>
                                    <?php if(!empty($administracionEquipos) && isset($administracionEquipos)):?><li><a href="<?php echo base_url() ?>index.php/inv_equipos/equipos/listar_equipos">Administración de equípos<span class="label label-danger">en construccion</span></a></li><?php endif;?>
                                    <?php if(!empty($tiposEquipos) && isset($tiposEquipos)):?><li><a href="<?php echo base_url() ?>index.php/air_tipoeq/tipoeq/index">Tipos de equipos<span class="label label-danger">en construccion</span></a></li><?php endif;?>
                                    <?php if(!empty($itemsPreventivo) && isset($itemsPreventivo)):?><li><a href="<?php echo base_url() ?>index.php/air_mntprvitm/itemmp/index">Items mant. preventivo<span class="label label-danger">en construccion</span></a></li><?php endif;?>
                                    <?php if(!empty($controlMantenimiento) && isset($controlMantenimiento)):?><li><a href="<?php echo base_url() ?>index.php/air_cntrl_mp_equipo/cntrlmp/index">Control mantenimiento<span class="label label-danger">en construccion</span></a></li><?php endif;?>
                                    <?php if(!empty($editarSolicitud) && isset($editarSolicitud)):?><li><a href="solicitud_actual.html">Editar solicitud<span class="label label-danger">en construccion</span></a></li><?php endif;?>
                                    <!--<li><a href="solicitud_actual.html.html">Eliminar</a></li> -->
                                </ul>
                            </li>
                          <?php endif;?>
                          <?php //endif;?>
                          <!--  <li><a href="calendar.html"><i class="fa fa-calendar"></i> Calendar</a></li>-->
                          <li class="has_submenu">
                            <a href="#">
                              <i class="fa fa-list fa-fw"></i> Asistencia
                              <span class="caret pull-right"></span>
                            </a>
                            <!-- Sub menu -->
                            <ul style="display: none;">
                              <li><?php echo anchor('asistencia/agregar','Marcar Asistencia'); ?></li>
                              <li><?php echo anchor('asistencia/configuracion','Asistencia Config'); ?></li>
                              <li><?php echo anchor('asistencia/configuracion/agregar','Asistencia Add Config',array('class'=>'disabled')); ?></li>
                              <li><?php echo anchor('ausentismo','Configuración Ausentismos'); ?></li>
                              <li><?php echo anchor('cargo','Cargos'); ?></li>
                              <li><?php echo anchor('jornada','Jornandas'); ?></li>
                              <li><?php echo anchor('periodo-no-laboral', 'Periodo No Laboral'); ?></li>
                              <li><?php echo anchor('nota', 'Nota Asistencia'); ?></li>
                            </ul>
                          </li>
                        </ul>
                     </div>
                  </div>