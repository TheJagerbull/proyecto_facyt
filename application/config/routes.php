<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] 									= "user/usuario";//= 'template/under_construction';
$route['404_override'] 											= 'template/not_found';
$route['test']													= 'template/template';
$route['error_acceso']											= 'template/error_acceso'; //if($this->session->userdata('user') == NULL){ redirect('error_acceso'); }
//Rutas Bloqueadas
$route['alm_datamining']										= 'template/not_found';//seguridad sobre los controladores
//$route['alm_datamining/(.*)']									= 'template/not_found';//seguridad sobre los controladores
$route['alm_solicitudes']										= 'template/not_found';//seguridad sobre los controladores
$route['alm_solicitudes/(.*)']									= 'template/not_found';//seguridad sobre los controladores
$route['alm_articulos']											= 'template/not_found';//seguridad sobre los controladores
$route['alm_articulos/(.*)']									= 'template/not_found';//seguridad sobre los controladores
//inicio
$route['inicio'] 												= 'user/usuario';
// Rutas de Usuario
$route['login']													= 'user/usuario/login';
$route['usuario'] 												= 'user/usuario';
$route['usuario/detalle/(:num)']								= 'user/usuario/detalle_usuario/$1';
$route['usuario/cerrar-sesion']									= 'user/usuario/logout';
$route['usuario/cerrar-sesion']									= "user/usuario/logout";
$route['usuario/crear/(:num)']									= 'user/usuario/crear_usuario';
$route['usuario/modificar']										= 'user/usuario/modificar_usuario';
$route['usuario/eliminar/(.*)']									= 'user/usuario/eliminar_usuario/$1';
$route['usuario/activar/(.*)']									= 'user/usuario/activar_usuario/$1';
//lista de usuarios
$route['usuarios']                                              = 'user/usuario/list_user';
$route['usuario/listar']										= 'user/usuario/lista_usuarios';
$route['usuario/listar/(:num)']									= 'user/usuario/lista_usuarios/$1';
$route['usuario/listar/buscar']									= 'user/usuario/lista_usuarios/$1';
$route['usuario/listar/buscar/(:num)']							= 'user/usuario/lista_usuarios/$1/$2';
$route['usuario/orden/(.*)/(.*)']								= 'user/usuario/lista_usuarios/$1/$2';
$route['usuario/orden/(.*)/(.*)/(:num)']						= 'user/usuario/lista_usuarios/$1/$2/$3';
$route['usuario/orden/buscar/(.*)/(.*)']						= 'user/usuario/lista_usuarios/$1/$2';
$route['usuario/orden/buscar/(.*)/(.*)/(:num)']					= 'user/usuario/lista_usuarios/$1/$2/$3';
//Ruta de dependencia
$route['dependencia/listar']					   	        	= 'user/usuario/dependencia';
$route['dependencia/guardar']									= 'dec_dependencia/dec_dependencia/save_dependen';
// Rutas de inventario
$route['inventario']											= 'alm_articulos';
$route['inventario/cierres']									= 'alm_articulos/opciones_cierres';
		//Rutas de Datatables
$route['tablas/inventario']										='alm_articulos/getSystemWideTable';
$route['tablas/inventario/(:num)']								='alm_articulos/getSystemWideTable/$1';
$route['tablas/inventario/historial/(.*)']						='alm_articulos/getArticulosHist/$1';
$route['tablas/inventario/solicitud/(.*)']						='alm_articulos/getInventoryTable/$1';
$route['tablas/inventario/reportes']									='alm_articulos/build_report';
		//Rutas de inputs y formularios
$route['inventario/insertar/fromExcelFile']						='alm_articulos/excel_to_DB';
$route['inventario/cierre/fromExcelFile']						='alm_articulos/upload_excel';
$route['inventario/cierre/readExcelFile']						='alm_articulos/read_excel';
$route['inventario/reporte']									='alm_articulos/pdf_reportesInv';
$route['inventario/articulo/check']								='alm_articulos/ajax_codeCheck';
$route['inventario/add/articulo'] 								='alm_articulos/ajax_formProcessing';
$route['inventario/articulo/agregar']							='alm_articulos/insertar_articulo';
$route['inventario/articulo/autocompletar']						='alm_articulos/ajax_likeArticulos';
$route['inventario/tabla_config']								='alm_articulos/build_dtConfig';

// Rutas de solicitudes de almacen
$route['solicitudes/almacen']									='alm_solicitudes/consultar_solicitudes';
$route['solicitudes/departamento']								='alm_solicitudes/consultar_DepSolicitudes';
$route['solicitudes/usuario']									='alm_solicitudes/consultar_UsrSolicitudes';
$route['solicitud/generar']										='alm_solicitudes/generar_solicitud';
$route['solicitud/editar/(.*)']									='alm_solicitudes/editar_solicitud/$1';
$route['solicitud/completar']									='alm_solicitudes/completar_solicitud';
$route['solicitud/revisar']										='alm_solicitudes/revisar_solicitud';
	//Rutas de Datatables
$route['tablas/solicitudes/(.*)']								='alm_solicitudes/build_tables/$1';
$route['tablas/solicitudes_carrito/(.*)']						='alm_solicitudes/solicitudes_carrito/$1';
$route['tablas/solicitud/paso2']								='alm_solicitudes/load_listStep2';
	//Rutas de inputs y formularios
$route['articulos/autocompletar']								='alm_articulos/ajax_likeArticulos';
$route['solicitud/enviar']										='alm_solicitudes/enviar_solicitud';
$route['solicitud/pasos']										='alm_solicitudes/solicitud_steps';
$route['solicitud/aprobar']										='alm_solicitudes/aprobar';
$route['solicitud/despachar']									='alm_solicitudes/despachar';
$route['solicitud/anular']										='alm_solicitudes/anular';
$route['solicitud/actual/actualizar/(.*)']						='alm_solicitudes/editar_solicitud/$1';
$route['solicitud/cancelar']									='alm_solicitudes/cancelar_solicitud';
$route['solicitud/cancelar/sin_enviar']							='alm_solicitudes/cancelar_carrito';
//Rutas para pruebas de solicitudes
$route['testsql']												='alm_solicitudes/test_sql';
//Rutas para migracion de sistema
$route['migrarDB']												='alm_datamining/migrate';
//rutas para la edicion de una solicitud guardada
$route['solicitud/actual/agregar/(.*)']							='alm_solicitudes/editar_solicitud/$1';
$route['solicitud/actual/remover/(.*)']							='alm_solicitudes/editar_solicitud/$1';
$route['solicitud/actual/actualizar/(.*)']						='alm_solicitudes/editar_solicitud/$1';
$route['solicitud/ver_solicitud']								='alm_solicitudes/consultar_UsrSolicitudes';

// Routes para Mantenimiento
//$route['mnt_solicitudes/listar']				        = 'mnt_solicitudes/mnt_solicitudes/lista_solicitudes';
//$route['mnt_solicitudes/listar/(:num)']					= 'mnt_solicitudes/mnt_solicitudes/lista_solicitudes/$1';
//$route['mnt_solicitudes/listar/buscar']					= 'mnt_solicitudes/mnt_solicitudes/lista_solicitudes/$1';
//$route['mnt_solicitudes/listar/buscar/(:num)'] 			        = 'mnt_solicitudes/mnt_solicitudes/lista_solicitudes/$1/$2';
//$route['mnt_solicitudes/orden/(.*)/(.*)']	                        = 'mnt_solicitudes/mnt_solicitudes/lista_solicitudes/$1/$2';
//$route['mnt_solicitudes/orden/(.*)/(.*)/(:num)']		        = 'mnt_solicitudes/mnt_solicitudes/lista_solicitudes/$1/$2/$3';
//$route['mnt_solicitudes/orden/buscar/(.*)/(.*)']			= 'mnt_solicitudes/mnt_solicitudes/lista_solicitudes/$1/$2';
//$route['mnt_solicitudes/orden/buscar/(.*)/(.*)/(:num)']			= 'mnt_solicitudes/mnt_solicitudes/lista_solicitudes/$1/$2/$3';
$route['mnt_solicitudes/lista_solicitudes']								= 'mnt_solicitudes/mnt_solicitudes/list_filter';
$route['mnt_solicitudes/solicitudes']								= 'mnt_solicitudes/mnt_solicitudes/list_sol';
$route['mnt_solicitudes/detalle/(:num)']								= 'mnt_solicitudes/mnt_solicitudes/mnt_detalle/$1';
$route['mnt_solicitudes/detalles/(:num)']								= 'mnt_solicitudes/mnt_solicitudes/mnt_detalle_dep/$1';
$route['mnt_solicitudes/solicitud']						     		    = 'mnt_solicitudes/orden/crear_orden';
$route['mnt_solicitudes/cerrada']					         			= 'mnt_solicitudes/mnt_solicitudes/listado_close';
$route['mnt_solicitudes/cerradas']					         			= 'mnt_solicitudes/mnt_solicitudes/listado_dep_close';
$route['mnt_solicitudes/anulada']                                                                        =    'mnt_solicitudes/mnt_solicitudes/listado_null';
//Ruta para permisos
$route['usuarios/permisos']                                                    = 'dec_permiso/dec_permiso/load_vista';
$route['usuarios/asignar_permisos/(:num)']                                            = 'dec_permiso/dec_permiso/asignar/$1';

//Ruta para reportes
$route['mnt_solicitudes/reportes']					       = 'mnt_reportes/mnt_reportes/reporte';
$route['mnt_solicitudes/reportes_pdf']                                         = 'mnt_reportes/mnt_reportes/pdf_reportes_worker';
$route['mnt_solicitudes/mnt_buscar_trabajador']                                = 'mnt_ayudante/mnt_ayudante/load_ayu_asig';
$route['mnt_solicitudes/mnt_buscar_responsable']                               = 'mnt_responsable_orden/mnt_responsable_orden/show_all_respon';
$route['mnt_solicitudes/mnt_buscar_tipo_orden']                                = 'mnt_asigna_cuadrilla/mnt_asigna_cuadrilla/show_cuad_signed';
$route['mnt_solicitudes/mnt_trabajador']                                       = 'mnt_ayudante/mnt_ayudante/load_consult';
$route['mnt_solicitudes/mnt_responsable']                                      = 'mnt_responsable_orden/mnt_responsable_orden/load_respond';
$route['mnt_solicitudes/mnt_tipo_orden']                                       = 'mnt_asigna_cuadrilla/mnt_asigna_cuadrilla/load_cuad_tipo_orden';

//Ruta para agregar ubicaciones
$route['mnt_ubicaciones/agregar']                                      ='mnt_ubicaciones/mnt_ubicaciones/agregar_ubicacion';

//Rutas para asignar ayudantes
$route['mnt/asignar/ayudante']											= 'mnt_ayudante/asign_help';
$route['mnt/desasignar/ayudante']										= 'mnt_ayudante/asign_help';


//Routes para mnt_cuadrillas
$route['mnt_cuadrilla'] 								= 'mnt_cuadrilla/cuadrilla/index';
$route['mnt_cuadrilla/crear']							= 'mnt_cuadrilla/cuadrilla/crear_cuadrilla';
$route['mnt_cuadrilla/prueba']							= 'mnt_cuadrilla/person/index';
$route['mnt_cuadrilla/tabla']                                                 = 'mnt_cuadrilla/cuadrilla/prueba';
$route['mnt_cuadrilla/listar']						    = 'mnt_cuadrilla/cuadrilla/index';
$route['mnt_cuadrilla/orden/(.*)/(.*)']					= 'mnt_cuadrilla/cuadrilla/index/$1/$2';
$route['mnt_cuadrilla/detalle/(:num)']					= 'mnt_cuadrilla/cuadrilla/detalle_cuadrilla/$1';
$route['mnt_cuadrilla/eliminar/(:num)']					= 'mnt_cuadrilla/cuadrilla/eliminar_item/$1';
$route['mnt_cuadrilla/lista']					        = 'mnt_solicitudes/mnt_cuadrilla/lista_cuadrilla';
$route['mnt_cuadrilla/lista/(.*)/(.*)']				    = 'mnt_solicitudes/mnt_cuadrilla/lista_cuadrilla/$1/$2';
$route['mnt_cuadrilla/lista/(:num)']					= 'mnt_solicitudes/mnt_cuadrilla/lista_solicitudes/$1';


// Routes para air_mant_prev_item
$route['itemmp'] 										= 'air_mntprvitm/itemmp/index';
$route['itemmp/detalle/(:num)']						    = 'air_mntprvitm/itemmp/detalle_item/$1';
$route['itemmp/cerrar-sesion']							= 'user/usuario/logout';
$route['itemmp/cerrar-sesion']							= "user/usuario/logout";
$route['itemmp/crear']									= 'air_mntprvitm/itemmp/crear_item';
$route['itemmp/listar']								    = 'air_mntprvitm/itemmp/index';
$route['itemmp/modificar']								= 'air_mntprvitm/itemmp/modificar_item';
$route['itemmp/orden/(.*)/(.*)']						= 'air_mntprvitm/itemmp/index/$1/$2';
$route['itemmp/eliminar/(:num)']						= 'air_mntprvitm/itemmp/eliminar_item/$1';
$route['itemmp/activar/(:num)']						    = 'air_mntprvitm/itemmp/activar_item/$1';

// Routes para air_cntrl_mp_equipo
$route['cntrlmnt'] 										= 'air_cntrl_mp_equipo/cntrlmp/index';
$route['cntrlmnt/detalle/(:num)']						= 'air_cntrl_mp_equipo/cntrlmp/detalle_cntrl/$1';
$route['cntrlmnt/cerrar-sesion']						= 'user/usuario/logout';
$route['cntrlmnt/cerrar-sesion']						= "user/usuario/logout";
$route['cntrlmnt/crear']								= 'air_cntrl_mp_equipo/cntrlmp/crear_cntrl';
$route['cntrlmnt/listar']								= 'air_cntrl_mp_equipo/cntrlmp/index';
$route['cntrlmnt/modificar']							= 'air_cntrl_mp_equipo/cntrlmp/modificar_cntrl';
$route['cntrlmnt/orden/(.*)/(.*)']						= 'air_cntrl_mp_equipo/cntrlmp/index/$1/$2';
$route['cntrlmnt/eliminar/(:num)']						= 'air_cntrl_mp_equipo/cntrlmp/eliminar_cntrl/$1';
$route['cntrlmnt/activar/(:num)']						= 'air_cntrl_mp_equipo/cntrlmp/activar_cntrl/$1';

// Routes para air_tipoeq
$route['tipoeq'] 										= 'air_tipoeq/tipoeq/index';
$route['tipoeq/detalle/(:num)']						    = 'air_tipoeq/tipoeq/detalle_tipo/$1';
$route['tipoeq/cerrar-sesion']							= 'user/usuario/logout';
$route['tipoeq/cerrar-sesion']							= "user/usuario/logout";
$route['tipoeq/crear/(:num)']							= 'air_tipoeq/tipoeq/nuevo_tipo';
$route['tipoeq/modificar']								= 'air_tipoeq/tipoeq/modificar_tipo';
$route['tipoeq/listar']								    = 'air_tipoeq/tipoeq/index';
$route['tipoeq/orden/(.*)/(.*)']						= 'air_tipoeq/tipoeq/index/$1/$2';
$route['tipoeq/eliminar/(:num)']						= 'air_tipoeq/tipoeq/eliminar_tipo/$1';
$route['tipoeq/activar/(:num)']						    = 'air_tipoeq/tipoeq/activar_tipo/$1';

// Routes para inv_equipo
$route['inveq'] 										= 'inv_equipos/equipos/index';
$route['inveq/detalle/(:num)']						    = 'inv_equipos/equipos/detalle_equipo/$1';
$route['inveq/cerrar-sesion']							= 'user/usuario/logout';
$route['inveq/cerrar-sesion']							= "user/usuario/logout";
$route['inveq/crear/(:num)']							= 'inv_equipos/equipos/nuevo_equipo';
$route['inveq/modificar']								= 'inv_equipos/equipos/modificar_equipo';
$route['inveq/listar']								    = 'inv_equipos/equipos/index';
$route['inveq/orden/(.*)/(.*)']							= 'inv_equipos/equipos/index/$1/$2';
$route['inveq/eliminar/(:num)']						 	= 'inv_equipos/equipos/eliminar_equipo/$1';
$route['inveq/activar/(:num)']						    = 'inv_equipos/equipos/activar_equipo/$1';

// Routes para mnt_observacion
$route['mnt_observacion/prueba']						= 'mnt_observacion/observa/index';
/* End of file routes.php */
/* Location: ./application/config/routes.php */

/******** INI : RUTAS LUIS PEREZ **********/
// Routes para rhh_asistencia
$route['asistencia/vista']								= 'rhh_asistencia/vista';

$route['asistencia']									= 'rhh_asistencia/index';
$route['asistencia/agregar']                            = 'rhh_asistencia/agregar';
$route['asistencia/agregado']                           = 'rhh_asistencia/agregado';
$route['asistencia/verificar']							= 'rhh_asistencia/verificar';
$route['asistencia/configuracion']						= 'rhh_asistencia/configuracion';
$route['asistencia/configuracion/verificar']			= 'rhh_asistencia/verificar_configuracion';
$route['asistencia/configuracion/modificar/(:num)/(:num)']     = 'rhh_asistencia/modificar_configuracion/$1/$2';
$route['asistencia/salida']                             = 'rhh_asistencia/salir_antes';
$route['asistencia/salir/guardar']      				= 'rhh_asistencia/salir_antes_guardar';

$route['jornada']										= 'rhh_asistencia/jornada';
$route['jornada/nueva']									= 'rhh_asistencia/nueva_jornada';
$route['jornada/agregar']								= 'rhh_asistencia/agregar_jornada';
$route['jornada/modificar/(:num)']  			 		= 'rhh_asistencia/modificar_jornada/$1';
$route['jornada/actualizar']   							= 'rhh_asistencia/actualizar_jornada';
$route['jornada/eliminar/(:num)']  					    = 'rhh_asistencia/eliminar_jornada/$1';

$route['cargo']				    						= 'rhh_cargo/index';
$route['cargo/nuevo']				    				= 'rhh_cargo/nuevo';
$route['cargo/modificar/(:num)']                        = 'rhh_cargo/modificar/$1';
$route['cargo/eliminar/(:num)']	    			    	= 'rhh_cargo/eliminar/$1';
$route['cargo/agregar']				    				= 'rhh_cargo/agregar';
$route['cargo/actualizar']			    				= 'rhh_cargo/actualizar';

$route['periodo']                                       = 'rhh_periodo/index';
$route['periodo/nuevo']                                 = 'rhh_periodo/nuevo';
$route['periodo/agregar']                               = 'rhh_periodo/agregar';
$route['periodo/modificar/(:num)']                      = 'rhh_periodo/modificar/$1';
$route['periodo/duplicar/(:num)']                       = 'rhh_periodo/duplicar/$1';
$route['periodo/actualizar']                            = 'rhh_periodo/actualizar';
$route['periodo/eliminar/(:num)']	                    = 'rhh_periodo/eliminar/$1';

$route['periodo-no-laboral']                            = 'rhh_periodo_no_laboral/index';
$route['periodo-no-laboral/nuevo']                      = 'rhh_periodo_no_laboral/nuevo';
$route['periodo-no-laboral/agregar']                    = 'rhh_periodo_no_laboral/agregar';
$route['periodo-no-laboral/modificar/(:num)']           = 'rhh_periodo_no_laboral/modificar/$1';
$route['periodo-no-laboral/actualizar']                 = 'rhh_periodo_no_laboral/actualizar';
$route['periodo-no-laboral/eliminar/(:num)']	    	= 'rhh_periodo_no_laboral/eliminar/$1';

/*
* IR DE LO MÁS GENERAL A LO MÁS ESPECIFICO
*/
$route['ausentismo']                                    = 'rhh_ausentismo/index';
$route['ausentismo/configuracion/nueva']                = 'rhh_ausentismo/configuracion_nueva';
$route['ausentismo/configuracion/verificar']            = 'rhh_ausentismo/configuracion_verificar';
$route['ausentismo/configuracion/ver/(:num)']   		= 'rhh_ausentismo/ver/$1';
$route['ausentismo/configuracion/eliminar/(:num)']      = 'rhh_ausentismo/eliminar_configuracion/$1';
$route['ausentismo/configuracion/modificar/(:num)']     = 'rhh_ausentismo/configuracion_editar/$1';
$route['ausentismo/configuracion/actualizar/(:num)']    = 'rhh_ausentismo/guardar_modificacion/$1';

$route['ausentismo/solicitar']                          = 'rhh_ausentismo/solicitar_nuevo';
$route['ausentismo/solicitar/agregar']                  = 'rhh_ausentismo/solicitar_nuevo_agregar';
$route['ausentismo/obtener/tipo']               	    = 'rhh_ausentismo/obtener_tipos';

$route['nota']											= 'rhh_nota/index';
$route['nota/actualizar']								= 'rhh_nota/actualizar';
$route['nota/eliminar/(:num)']							= 'rhh_nota/eliminar/$1';

/******** FIN : RUTAS LUIS PEREZ **********/
