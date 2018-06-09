<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function die_pre($array = array(), $line='', $file='')
{
	//header('Content-Type: text/html; charset=utf-8');
	echo "<pre>die_pre:
	<br /><br />";
	if(!empty($line) && !empty($file))
	{

		echo "linea: ".$line."<br />
		";
		echo "archivo: ".$file."<br />
		";
	}
    die(print_r($array, TRUE)."<br /><br />
    	/die_pre</pre>");
}

function echo_pre($array = array(), $line='', $file='')
{
	//header('Content-Type: text/html; charset=utf-8');
	echo "<pre>echo_pre:
	<br /><br />";
	if(!empty($line) && !empty($file))
	{
		echo "linea: ".$line."<br />
		";
		echo "archivo: ".$file."<br />
		";
	}
    echo print_r($array, TRUE)."<br /><br />
    /echo_pre</pre>";
}

function memory_units($size)
{
    $unit=array('b','kb','mb','gb','tb','pb');
    return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
}

function time_units($seconds)
{
    $trans = array(60, 3200);
    $hours=0;
    while ($seconds >= 3200)
    {
        $hours++;
        $seconds-=3200;
    }
    $minutes=0;
    while ($seconds >= 60)
    {
        $minutes++;
        $seconds-=60;
    }
    return($hours.':'.$minutes.':'.$seconds);
    // return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
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
function sortByObservacion($a, $b)
{
	return(strcasecmp($a['observacion'], $b['observacion']));
}
function readNumber($num, $depth=0)
{
    $num = (int)$num;
    $retval ="";
    if ($num < 0) // if it's any other negative, just flip it and call again
    {
        return "negativo " + readNumber(-$num, 0);
    }
    if ($num > 99) // 100 and above
    {
        if ($num > 999) // 1000 and higher
        {
        	if($num < 2000) $retval.="mil ".readNumber($num%1000, 0);
        	else
        	{
        		// echo $num/1000;
        		$retval.=readNumber($num/1000, 0)." mil ";
        	}
            // $retval .= readNumber($num/1000, $depth+3);
            // echo $num%1000;
            // $retval.="mil".readNumber($num%1000, 0);
        }

        $num %= 1000; // now we just need the last three digits
        if ($num > 99) // as long as the first digit is not zero
        {
        	
        	if($num >= 900) $retval .= "novecientos ".readNumber($num%100, 2);
        	else if($num >= 800) $retval .= "ochocientos ".readNumber($num%100, 2);
        	else if($num >= 700) $retval .= "setescientos ".readNumber($num%100, 2);
        	else if($num >= 600) $retval .= "seiscientos ".readNumber($num%100, 2);
        	else if($num >= 500) $retval .= "quinientos ".readNumber($num%100, 2);
        	else if($num >= 400) $retval .= "cuatrocientos ".readNumber($num%100, 2);
        	else if($num >= 300) $retval .= "trescientos ".readNumber($num%100, 2);
        	else if($num >= 200) $retval .= "doscientos ".readNumber($num%100, 2);
        	else if($num > 100) $retval .= "ciento ".readNumber($num%100, 2);
        	else if($num == 100) $retval .= "cien";
        	// {
        		// $retval.=readNumber($num/100, 0)."ciento";
        	// }
            // $retval .= readNumber($num/100, 2)." cien\n";
            // $retval .= "ciento".readNumber($num%100, 2);
        }
        // $retval .=readNumber($num%100, 1); // our last two digits                       
    }
    else // from 0 to 99
    {
        $mod = floor($num / 10);
        if ($mod == 0) // ones place
        {
            if ($num == 1) $retval.="uno";
            else if ($num == 2) $retval.="dos";
            else if ($num == 3) $retval.="tres";
            else if ($num == 4) $retval.="cuatro";
            else if ($num == 5) $retval.="cinco";
            else if ($num == 6) $retval.="seis";
            else if ($num == 7) $retval.="siete";
            else if ($num == 8) $retval.="ocho";
            else if ($num == 9) $retval.="nueve";
        }
        else if ($mod == 1) // if there's a one in the ten's place
        {
            if ($num == 10) $retval.="diez";
            else if ($num == 11) $retval.="once";
            else if ($num == 12) $retval.="doce";
            else if ($num == 13) $retval.="trece";
            else if ($num == 14) $retval.="catorce";
            else if ($num == 15) $retval.="quince";
            else if ($num == 16) $retval.="dieciséis";
            else if ($num == 17) $retval.="diecisiete";
            else if ($num == 18) $retval.="dieciocho";
            else if ($num == 19) $retval.="diecinueve";
        }
        else // if there's a different number in the ten's place
        {
            if ($mod == 2)
            {
            	if ($num == 20) $retval.="veinte";
            	else if ($num == 21) $retval.="veintiuno";
            	else if ($num == 22) $retval.="veintidos";
            	else if ($num == 23) $retval.="veintitrés";
            	else if ($num == 24) $retval.="veinticuatro";
            	else if ($num == 25) $retval.="veinticinco";
            	else if ($num == 26) $retval.="veintiséis";
            	else if ($num == 27) $retval.="veintisiete";
            	else if ($num == 28) $retval.="veintiocho";
            	else if ($num == 29) $retval.="veintinueve";
            }
            else
            { 
            	if ($mod == 3) $retval.="treinta ";
	            else if ($mod == 4) $retval.="cuarenta ";
	            else if ($mod == 5) $retval.="cincuenta ";
	            else if ($mod == 6) $retval.="sesenta ";
	            else if ($mod == 7) $retval.="setenta ";
	            else if ($mod == 8) $retval.="ochenta ";
	            else if ($mod == 9) $retval.="noventa ";
	            if (($num % 10) != 0)
	            {
	                $retval = rtrim($retval); //get rid of space at end
	                $retval .= " y ";
	            }
	            $retval.=readNumber($num % 10, 0);
	        }
        }
    }

    if ($num != 0)
    {
        if ($depth == 3)
            $retval.=" mil\n";
        else if ($depth == 6)
            $retval.=" millón\n";
        if ($depth == 9)
            $retval.=" billón\n";
    }
    return $retval;
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
	//$id_trabajador = $CI->session->userdata('user')['id_usuario'];
	if($CI->session->userdata('user')['id_usuario'] == ''){ redirect('usuario/cerrar-sesion'); }
}

// PARA AGREGAR LOS MENSAJES EN LOS FLASH DATA
function set_message($type = NULL, $message = NULL, $icon = NULL)
{
	$CI = & get_instance();
	$type = strtolower($type);
	$icon = strtolower($icon);

	if ($type == NULL || $message == NULL){echo "Usted no ha especificado ningún message ó type"; die(); }
    if($icon == NULL){
        if($type == 'success' || $type == 'exito'){
            $mensaje = "<div class='alert alert-success well-sm text-center' role='alert'><i class='fa fa-check fa-2x pull-left'></i>".$message.".<br></div>";
        }elseif($type == 'danger' || $type == 'error'){
            $mensaje = "<div class='alert alert-danger well-sm text-center' role='alert'><i class='fa fa-times fa-2x pull-left'></i>".$message.".<br></div>";
        }elseif($type == 'warning' || $type == 'precaucion'){
            $mensaje = "<div class='alert alert-warning well-sm text-center' role='alert'><i class='fa fa-hand-pointer-o fa-2x pull-left'></i>".$message.".<br></div>";
        }elseif($type == 'info' || $type == 'info'){
            $mensaje = "<div class='alert alert-info well-sm text-center' role='alert'><i class='fa fa-info-circle fa-2x pull-left'></i>".$message.".<br></div>";
        }
    }else{
        if($type == 'success' || $type == 'exito'){
            $mensaje = "<div class='alert alert-success well-sm text-center' role='alert'><i class='fa ".$icon." fa-2x pull-left'></i>".$message.".<br></div>";
        }elseif($type == 'danger' || $type == 'error'){
            $mensaje = "<div class='alert alert-danger well-sm text-center' role='alert'><i class='fa ".$icon." fa-2x pull-left'></i>".$message.".<br></div>";
        }elseif($type == 'warning' || $type == 'precaucion'){
            $mensaje = "<div class='alert alert-warning well-sm text-center' role='alert'><i class='fa ".$icon." fa-2x pull-left'></i>".$message.".<br></div>";
        }elseif($type == 'info' || $type == 'info'){
            $mensaje = "<div class='alert alert-info well-sm text-center' role='alert'><i class='fa ".$icon." fa-2x pull-left'></i>".$message.".<br></div>";
        }
    }

	$CI->session->set_flashdata('mensaje', $mensaje);
}

//VERIFICA SI EL METODO QUE RECIBE ES EL MISMO QUE SE ENVIO EN LA PETICIÓN
function is_method_right($peticion_recibida, $peticion_correcta){ if ($peticion_recibida == $peticion_correcta) { return TRUE; }else{ return FALSE; } }