<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function die_pre($array = array(), $line='', $file='')
{
	//header('Content-Type: text/html; charset=utf-8');
	echo "<pre>die_pre:<br /><br />";
	if(!empty($line) && !empty($file))
	{

		echo "linea: ".$line."<br />";
		echo "archivo: ".$file."<br />";
	}
    die(print_r($array, TRUE)."<br /><br />/die_pre</pre>");
}

function echo_pre($array = array(), $line='', $file='')
{
	//header('Content-Type: text/html; charset=utf-8');
	echo "<pre>echo_pre:<br /><br />";
	if(!empty($line) && !empty($file))
	{
		echo "linea: ".$line."<br />";
		echo "archivo: ".$file."<br />";
	}
    echo print_r($array, TRUE)."<br /><br />/echo_pre</pre>";
}

function current_time()
{
	return(now());
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

function initPagination($url, $total_rows, $per_page, $uri_segment)
{
		$config['base_url'] = base_url().$url;
        $config['total_rows'] = $total_rows;
        $config['per_page'] = $per_page;
        $config['uri_segment'] = $uri_segment;
        $config['num_links'] = 3;
        //style template use
			$config['full_tag_open']='<ul class="pagination pagination-sm">';
			$config['full_tag_close']='</ul>';
			$config['first_tag_open'] = $config['last_tag_open']= $config['next_tag_open']= $config['prev_tag_open'] = $config['num_tag_open'] = '<li>';
	        $config['first_tag_close'] = $config['last_tag_close']= $config['next_tag_close']= $config['prev_tag_close'] = $config['num_tag_close'] = '</li>';
	        $config['cur_tag_open'] = "<li><span><b>";
	        $config['cur_tag_close'] = "</b></span></li>";
        //end style template use

		return $config; 
}

function date_to_query($fecha)
{
	$this->load->helper('date');
	die_pre($fecha);
    $datestring = "%Y-%m-%d %h:%i:%s";
    $time = human_to_unix($fecha);
    $time = mdate($datestring, $time);
    echo $time;
    return($time);
}

function query_to_human($query)
{
	$this->load->helper('date');
    $datestring = "%d-%m-%Y %h:%i:%s";
    $time = human_to_unix($query);
    $time = mdate($datestring, $time);
    echo $time;
    return($time);                  
}

function isSubArray_inArray($subArray, $array, $index, $key='')
{
//////////////////////////////////////recursivo
	if(!is_array($subArray))
	{
		return (false);
	}
	else
	{
		if(!empty($key) && isset($key))
		{
			if(isset($array[$key]) && !empty($array[$key][$index]))
			{
				return(($subArray[$index]==$array[$key][$index]) || (isSubArray_inArray($subArray, $array, $index, ($key+1))));
			}
			else
			{
				return(false);
			}
		}
		else
		{
			if(isset($array[0]) && !empty($array[0][$index]))
			{
				return(($subArray[$index]==$array[0][$index]) || (isSubArray_inArray($subArray, $array, $index, 1)));
			}
			else
			{
				return(false);
			}
		}
	}
//////////////////////////////////////Fin del recursivo
//////////////////////////////////////////////////Iterativo
	/*if(!is_array($subArray))
	{
		return (null);
	}
	else
	{
		if(isset($subArray[$index]))
		{
			foreach ($array as $key => $value)
			{
				if($subArray[$index]==$value[$index])
				{
					return(true);
				}
			}
			return(false);
		}
		else
		{
			return(null);
		}
	}*/
//////////////////////////////////////////////////Fin del Iterativo
}

function sortByDescripcion($a, $b)//condicion para orden alfabetico de un arreglo que contenga el indice "descripcion" en sus subarreglos
{
	return(strcasecmp($a['descripcion'], $b['descripcion']));
}

//Para revisar el contenido json de las transacciones de javascript
function check_json($data)
{
	$this->session->set_flashdata('data', $data);
	redirect('test');
}

//VERIFICA SI UN USUARIO ESTA LOGUEADO EN EL SISTEMA
function is_user_logged($user){ if($user == NULL){ redirect('error_acceso'); } }

// FUNCION PARA VERIFICAR SI UN USUARIO TIENE LA SESION INICIADA 
function is_user_authenticated()
{
	$CI = & get_instance();
	$id_trabajador = $CI->session->userdata('user')['id_usuario'];
	if($id_trabajador == ''){ redirect('usuario/cerrar-sesion'); }
}

//VERIFICA SI EL METODO QUE RECIBE ES EL MISMO QUE SE ENVIO EN LA PETICIÓN
function is_method_right($peticion_recibida, $peticion_correcta){ if ($peticion_recibida == $peticion_correcta) { return TRUE; }else{ return FALSE; } }