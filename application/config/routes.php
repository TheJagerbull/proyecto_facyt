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

$route['usuario'] 										= 'user/usuario';
$route['usuario/detalle/(:num)']						= 'user/usuario/detalle_usuario/$1';
$route['usuario/cerrar-sesion']							= 'user/usuario/logout';
$route['usuario/cerrar-sesion']							= "user/usuario/logout";
$route['usuario/crear/(:num)']							= 'user/usuario/crear_usuario';
$route['usuario/listar']								= 'user/usuario/lista_usuarios';
$route['usuario/modificar']								= 'user/usuario/modificar_usuario';
$route['usuario/orden/(.*)/(.*)']						= 'user/usuario/lista_usuarios/$1/$2';
$route['usuario/eliminar/(:num)']						= 'user/usuario/eliminar_usuario/$1';
$route['usuario/activar/(:num)']						= 'user/usuario/activar_usuario/$1';


// Routers para air_mant_prev_item
$route['itemmp'] 										= 'air_mntprvitm/itemmp/index';
$route['itemmp/detalle/(:num)']						    = 'air_mntprvitm/itemmp/detalle_item/$1';
$route['itemmp/cerrar-sesion']							= 'user/usuario/logout';
$route['itemmp/cerrar-sesion']							= "user/usuario/logout";
$route['itemmp/crear/(:num)']							= 'air_mntprvitm/itemmp/crear_item';
$route['itemmp/listar']								    = 'air_mntprvitm/itemmp/index';
$route['itemmp/modificar']								= 'air_mntprvitm/itemmp/modificar_item';
$route['itemmp/orden/(.*)/(.*)']						= 'air_mntprvitm/itemmp/index/$1/$2';
$route['itemmp/eliminar/(:num)']						= 'air_mntprvitm/itemmp/eliminar_item/$1';
$route['itemmp/activar/(:num)']						    = 'air_mntprvitm/itemmp/activar_item/$1';

// Routers para air_tipoeq
$route['tipoeq'] 										= 'air_tipoeq/tipoeq/index';
$route['tipoeq/detalle/(:num)']						    = 'air_tipoeq/tipoeq/detalle_tipo/$1';
$route['tipoeq/crear/(:num)']							= 'air_tipoeq/tipoeq/crear_tipo';
$route['tipoeq/modificar']								= 'air_tipoeq/tipoeq/modificar_tipo';
$route['tipoeq/listar']								    = 'air_tipoeq/tipoeq/index';
$route['tipoeq/orden/(.*)/(.*)']						= 'air_tipoeq/tipoeq/index/$1/$2';
/* End of file routes.php */
/* Location: ./application/config/routes.php */