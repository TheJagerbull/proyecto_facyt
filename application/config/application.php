<?php

/*
|------------------------------------------------------------------
| Sitio en mantenimiento
|------------------------------------------------------------------
| Muchas veces necesitamos poner nuestro website offline.
| Asignando el valor TRUE a al parámetro de configuración
| $config['is_offline'] el sitio mostrará un cartel de
| mantenimiento a todos aquellos ips que no se encuentren
| definidos en el parametro $config['offline_allowed_ips']
|
| $config['is_offline'] = TRUE; // sitio offline
| $config['is_offline'] = FALSE; // sitio online
| $config['offline_allowed_ips'] = array('xxx.xxx.xxx.xxx') // ips permitidos
*/
 
$config['is_offline'] = FALSE;
$config['offline_allowed_ips'] = array('127.0.0.1');

