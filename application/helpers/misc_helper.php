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