<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * Archivo de Configuracion de conexiones Auth_Ldap.
 * 
 */


/**
 * Array Index      - Usage
 * hosts            - Array de servidores ldap para intentar autenticarse contra
 * ports            - El puerto remoto en el servidor ldap para conectarse a
 * basedn           - La base dn de su almacén de datos ldap
 * login_attribute  - El atributo LDAP utilizado para comprobar los nombres de usuario contra
 * proxy_user       - Nombre distintivo de un usuario proxy si su servidor LDAP no permite anonymous binds
 * proxy pass       - password para usar con las anteriores
 * roles            - Una serie de nombres de función que se utilizarán en la aplicación. Los valores son arbitrarios.  
 *                     Las propias llaves representan la
 *			"security level," ie
 *			if( $security_level >= 3 ) {
 *				// Is a power user
 *				echo display_info_for_power_users_or_admins();
 *			}
 * member_attribute - Atributo a la búsqueda para determinar la asignación después del éxito authentication
 * auditlog         - Ubicación para registrar eventos auditables. Necesita ser grabable
 *                      por el servidor web
 */


$config['hosts'] = array('alfa.facyt.uc.edu.ve');
$config['ports'] = array(389);
$config['basedn'] = 'ou=people,dc=facyt,dc=uc,dc=edu,dc=ve';
$config['login_attribute'] = 'uid';
$config['proxy_user'] = '';
$config['proxy_pass'] = '';
/*$config['roles'] = array(1 => 'User', 
    3 => 'Power User',
    5 => 'Administrator');*/
$config['member_attribute'] = 'memberUid';
$config['auditlog'] = 'application/logs/audit.log';  // Algún lugar para registrar intentos de inicio de sesión (separado del registro de mensajes)
?>
