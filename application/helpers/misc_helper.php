<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function die_pre($array = array())
{
    die("<pre>die_pre:<br /><br />".print_r($array, TRUE)."<br /><br />/die_pre</pre>");
}

function echo_pre($array = array())
{
    echo "<pre>echo_pre:<br /><br />".print_r($array, TRUE)."<br /><br />/echo_pre</pre>";
}

//ESTA FUNCION CONVIERTE UN OBEJTO RESULT SQL EN ARRAY(tomado del codigo de hecto932@gmail.com)
function objectSQL_to_array($object_sql)
{
	//OBJETO QUE DEVUELVE LA FUNCION (ARRAY)
	$obj_array = array();
	$i = 0;
	//POR CADA ELEMENTO DEL OBJETO DE SQL
	foreach ($object_sql as $key => $value) 
	{
		$aux_array = array();
		foreach ($value as $k => $v) 
		{
			$aux_array[$k] = $v;
		}
		$obj_array[$i++] = $aux_array;
	}

	return $obj_array;
}

function SQL_to_array($object_sql)
{
	$array = array();
	foreach ($object_sql as $key => $value) 
	{
		$array[$key] = $value;
	}

	return $array;
}