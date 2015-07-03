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

$route['default_controller'] = "user/usuario";
$route['404_override'] = '';
// Rutas de Usuario
$route['usuario'] 												= 'user/usuario';
$route['usuario/detalle/(:num)']								= 'user/usuario/detalle_usuario/$1';
$route['usuario/cerrar-sesion']									= 'user/usuario/logout';
$route['usuario/cerrar-sesion']									= "user/usuario/logout";
$route['usuario/crear/(:num)']									= 'user/usuario/crear_usuario';
$route['usuario/modificar']										= 'user/usuario/modificar_usuario';
$route['usuario/eliminar/(:num)']								= 'user/usuario/eliminar_usuario/$1';
$route['usuario/activar/(:num)']								= 'user/usuario/activar_usuario/$1';
//lista de usuarios
$route['usuario/listar']										= 'user/usuario/lista_usuarios';
$route['usuario/listar/(:num)']									= 'user/usuario/lista_usuarios/$1';
$route['usuario/listar/buscar']									= 'user/usuario/lista_usuarios/$1';
$route['usuario/listar/buscar/(:num)']							= 'user/usuario/lista_usuarios/$1/$2';
$route['usuario/orden/(.*)/(.*)']								= 'user/usuario/lista_usuarios/$1/$2';
$route['usuario/orden/(.*)/(.*)/(:num)']						= 'user/usuario/lista_usuarios/$1/$2/$3';
$route['usuario/orden/buscar/(.*)/(.*)']						= 'user/usuario/lista_usuarios/$1/$2';
$route['usuario/orden/buscar/(.*)/(.*)/(:num)']					= 'user/usuario/lista_usuarios/$1/$2/$3';

// Rutas de alm_solicitudes
$route['solicitud/agregar']										='alm_solicitudes/agregar_articulo';
$route['solicitud/remover']										='alm_solicitudes/quitar_articulo';
$route['solicitud/confirmar']									='alm_solicitudes/confirmar_articulos';
$route['solicitud/enviar']										='alm_solicitudes/enviar_solicitud';
$route['solicitud/revisar']										='alm_solicitudes/enviar_solicitud';
$route['solicitud/editar/(.*)']									='alm_solicitudes/editar_solicitud/$1';
$route['solicitud/completar']									='alm_solicitudes/completar_solicitud';
$route['solicitud/consultar']									='alm_solicitudes/consultar_DepSolicitudes';
//rutas para la edicion de una solicitud guardada
$route['solicitud/actual/agregar/(.*)']							='alm_solicitudes/editar_solicitud/$1';
$route['solicitud/actual/remover/(.*)']							='alm_solicitudes/editar_solicitud/$1';
$route['solicitud/actual/actualizar/(.*)']						='alm_solicitudes/editar_solicitud/$1';
// lista de solicitudes de administrador
$route['administrador/solicitudes/reiniciar']						= 'alm_solicitudes/consultar_solicitudes';
$route['administrador/solicitudes']									= 'alm_solicitudes/consultar_solicitudes';
$route['administrador/solicitudes/(:num)']							= 'alm_solicitudes/consultar_solicitudes/$1';
$route['administrador/solicitudes/orden/(.*)/(.*)']					= 'alm_solicitudes/consultar_solicitudes/$1/$2';
$route['administrador/solicitudes/orden/(.*)/(.*)/(:num)']			= 'alm_solicitudes/consultar_solicitudes/$1/$2/$3';
$route['administrador/solicitudes/filtrar']							= 'alm_solicitudes/consultar_solicitudes/$1';
$route['administrador/solicitudes/filtrar/(:num)']					= 'alm_solicitudes/consultar_solicitudes/$1/$2';
$route['administrador/solicitudes/orden/filtrar/(.*)/(.*)']			= 'alm_solicitudes/consultar_solicitudes/$1/$2/$3';
$route['administrador/solicitudes/orden/filtrar/(.*)/(.*)/(:num)']	= 'alm_solicitudes/consultar_solicitudes/$1/$2/$3/$4';
//lista de articulos de solicitudes
$route['solicitud/inventario']									= 'alm_solicitudes/generar_solicitud/';
$route['solicitud/inventario/(:num)']							= 'alm_solicitudes/generar_solicitud/$1';
$route['solicitud/inventario/orden/(.*)/(.*)']					= 'alm_solicitudes/generar_solicitud/$1/$2';
$route['solicitud/inventario/orden/(.*)/(.*)/(:num)']			= 'alm_solicitudes/generar_solicitud/$1/$2/$3';
$route['solicitud/inventario/buscar']							= 'alm_solicitudes/generar_solicitud/$1';
$route['solicitud/inventario/buscar/(:num)']					= 'alm_solicitudes/generar_solicitud/$1/$2';
$route['solicitud/inventario/orden/buscar/(.*)/(.*)']			= 'alm_solicitudes/generar_solicitud/$1/$2/$3';
$route['solicitud/inventario/orden/buscar/(.*)/(.*)/(:num)']	= 'alm_solicitudes/generar_solicitud/$1/$2/$3/$4';
$route['solicitud/ver_solicitud']								= 'alm_solicitudes/consultar_DepSolicitudes';

// Routers para Mantenimiento
//$route['mnt_solicitudes/listar']				        = 'mnt_solicitudes/mnt_solicitudes/lista_solicitudes';
//$route['mnt_solicitudes/listar/(:num)']					= 'mnt_solicitudes/mnt_solicitudes/lista_solicitudes/$1';
//$route['mnt_solicitudes/listar/buscar']					= 'mnt_solicitudes/mnt_solicitudes/lista_solicitudes/$1';
//$route['mnt_solicitudes/listar/buscar/(:num)'] 			        = 'mnt_solicitudes/mnt_solicitudes/lista_solicitudes/$1/$2';
//$route['mnt_solicitudes/orden/(.*)/(.*)']	                        = 'mnt_solicitudes/mnt_solicitudes/lista_solicitudes/$1/$2';
//$route['mnt_solicitudes/orden/(.*)/(.*)/(:num)']		        = 'mnt_solicitudes/mnt_solicitudes/lista_solicitudes/$1/$2/$3';
//$route['mnt_solicitudes/orden/buscar/(.*)/(.*)']			= 'mnt_solicitudes/mnt_solicitudes/lista_solicitudes/$1/$2';
//$route['mnt_solicitudes/orden/buscar/(.*)/(.*)/(:num)']			= 'mnt_solicitudes/mnt_solicitudes/lista_solicitudes/$1/$2/$3';
$route['mnt_solicitudes/lista_solicitudes']								= 'mnt_solicitudes/mnt_solicitudes/listado';
$route['mnt_solicitudes/detalle/(:num)']								= 'mnt_solicitudes/mnt_solicitudes/mnt_detalle/$1';
$route['mnt_solicitudes/solicitud']										= 'mnt_solicitudes/orden/crear_orden';

//Rutas para asignar ayudantes
$route['mnt/asignar/ayudante']											= 'mnt_ayudante/asign_help';
$route['mnt/desasignar/ayudante']										= 'mnt_ayudante/asign_help';


//Routers para mnt_cuadrillas
$route['mnt_cuadrilla'] 								= 'mnt_cuadrilla/cuadrilla/index';
$route['mnt_cuadrilla/crear']							= 'mnt_cuadrilla/cuadrilla/crear_cuadrilla';
$route['mnt_cuadrilla/listar']						    = 'mnt_cuadrilla/cuadrilla/index';
$route['mnt_cuadrilla/orden/(.*)/(.*)']					= 'mnt_cuadrilla/cuadrilla/index/$1/$2';
$route['mnt_cuadrilla/detalle/(:num)']					= 'mnt_cuadrilla/cuadrilla/detalle_cuadrilla/$1';
$route['mnt_cuadrilla/eliminar/(:num)']					= 'mnt_cuadrilla/cuadrilla/eliminar_item/$1';
$route['mnt_cuadrilla/lista']					        = 'mnt_solicitudes/mnt_cuadrilla/lista_cuadrilla';
$route['mnt_cuadrilla/lista/(.*)/(.*)']				    = 'mnt_solicitudes/mnt_cuadrilla/lista_cuadrilla/$1/$2';
$route['mnt_cuadrilla/lista/(:num)']					= 'mnt_solicitudes/mnt_cuadrilla/lista_solicitudes/$1';


// Routers para air_mant_prev_item
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

// Routers para air_tipoeq
$route['tipoeq'] 										= 'air_tipoeq/tipoeq/index';
$route['tipoeq/detalle/(:num)']						    = 'air_tipoeq/tipoeq/detalle_tipo/$1';
$route['tipoeq/cerrar-sesion']							= 'air_tipoeq/tipoeq/logout';
$route['tipoeq/cerrar-sesion']							= "air_tipoeq/tipoeq/logout";
$route['tipoeq/crear/(:num)']							= 'air_tipoeq/tipoeq/nuevo_tipo';
$route['tipoeq/modificar']								= 'air_tipoeq/tipoeq/modificar_tipo';
$route['tipoeq/listar']								    = 'air_tipoeq/tipoeq/index';
$route['tipoeq/orden/(.*)/(.*)']						= 'air_tipoeq/tipoeq/index/$1/$2';
$route['tipoeq/eliminar/(:num)']						= 'air_tipoeq/tipoeq/eliminar_tipo/$1';
$route['tipoeq/activar/(:num)']						    = 'air_tipoeq/tipoeq/activar_tipo/$1';
/* End of file routes.php */
/* Location: ./application/config/routes.php */