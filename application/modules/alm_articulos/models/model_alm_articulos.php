<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_alm_articulos extends CI_Model
{
	//constructor predeterminado del modelo
	function __construct()
	{
		parent::__construct();
	}

	public function exist($codigo='')
	{
		if(!empty($codigo))
		{
			return($this->db->get_where('alm_articulo', $codigo)->row_array());
		}
	}
	public function get_artID($articulo)
	{
	    if(is_numeric($articulo))
	    {
	        $where['cod_articulo'] = $articulo;
	    }
	    else
	    {
	        $where['descripcion'] = $articulo;
	    }
	    $query = $this->db->get_where('alm_articulo', $where)->row_array();
	    return($query['ID']);
	}
	public function get_allArticulos($per_page='', $offset='')
	{
		if(empty($per_page) && empty($offset))
		{
			$query = $this->db->get('alm_articulo');
		}
		else
		{
			$query = $this->db->get('alm_articulo', $per_page, $offset);
		}
		return($query->result_array());
	}

	public function get_activeArticulos($field='',$order='',$per_page='', $offset='')
	{
		$this->db->select('*');
		$this->db->select('(usados + nuevos) AS disp');
		if(!empty($field))
		{
			if($field=='existencia')
			{
				$this->db->select('(disp + reserv) AS existencia');
			}
			$this->db->order_by($field, $order);
		}
		// $this->db->where('ACTIVE', 1);
		if(!empty($per_page))
		{
			$query = $this->db->get('alm_articulo', $per_page, $offset);
		}
		else
		{
			$query = $this->db->get('alm_articulo');
		}
		return($query->result());
	}

	public function get_articulo($ID, $bool='')
	{
		// die_pre($ID, __LINE__, __FILE__);
		$this->db->select('*');
		$this->db->select('(usados + nuevos) as disp');
		$this->db->select('(usados + nuevos + reserv) as exist');
		// $this->db->where('ACTIVE', '1');
		$this->db->where_in('ID', $ID);
		if($bool)//para obtener 1 solo resultado
		{
			return($this->db->get('alm_articulo')->result_array()[0]);
		}
		else
		{
			return($this->db->get('alm_articulo')->result());
		}
		
	}

	public function get_articulos($articulos) //recibe un array de varios ID de articulos
	{
		// die_pre($articulos, __LINE__, __FILE__);
		foreach ($articulos as $key => $value)
		{
			// die_pre($value);
			$this->db->select('descripcion');
			$this->db->where(array('ID' => $value['id_articulo']));
			// die_pre($this->db->get('alm_articulo')->row_array());
			$lista[$key] = $this->db->get('alm_articulo')->row_array();
			$lista[$key]['id_articulo'] = $value['id_articulo'];
			$lista[$key]['cant'] = $value['cant_solicitada'];
		}
			// die_pre($lista, __LINE__, __FILE__);
			return($lista);
	}

	public function find_articulo($art='', $field='', $order='', $per_page='', $offset='')
	{
		if(!empty($art))
		{
			$this->db->select('*');
			$this->db->select('(usados + nuevos) AS disp');
			if(!empty($field))
			{
				if($field=='existencia')
				{
					$this->db->select('*');
					$this->db->select('(disp + reserv) AS existencia');
				}
				$this->db->order_by($field, $order);

			}
			// $this->db->where('ACTIVE', '1');
			$this->db->like('descripcion',$art);

			return $this->db->get('alm_articulo', $per_page, $offset)->result();
		}
		return FALSE;
	}
	public function count_foundArt($art='')
	{
		if(!empty($art))
		{

			$this->db->like('descripcion',$art);
			// $this->db->or_like('apellido',$art);

			return $this->db->count_all_results('alm_articulo');
		}
		return FALSE;
	}

	public function count_articulos()
	{
		// $this->db->where('ACTIVE', 1);
		return($this->db->count_all_results('alm_articulo'));
	}

	public function get_existencia($id_articulo)
	{
		$this->db->select('*, (usados + nuevos) AS disp');
		$this->db->where('cod_articulo', $id_articulo);
		$query = $this->db->get('alm_articulo')->row_array();
		return($query);
	}

	public function ajax_likeArticulos($data)
	{
		$this->db->like('descripcion', $data);
		$this->db->or_like('cod_articulo', $data);
		$query = $this->db->get('alm_articulo');
		return $query->result();
	}

	public function exist_articulo($array)
	{
		if(is_array($array))
		{
			$this->db->where($array);
			$query = $this->db->get('alm_articulo')->row_array();
			return($query);
		}
		// else
		// {
		// if(is_array($array))
		// {
		// 	if(isset($array['cod_articulo']) && !empty($array['cod_articulo']))
		// 	{
		// 		$this->db->where('cod_articulo', $array['cod_articulo']);
		// 	}
		// 	if(isset($array['descripcion']) && !empty($array['descripcion']))
		// 	{
		// 		$this->db->or_where('descripcion', $array['descripcion']);
		// 	}

		// 	$query = $this->db->get('alm_articulo')->row_array();
		// 	return($query);
		// }
		else
		{
			return false;
		}
	}
	public function used_dataArticulo($array)
	{
		$this->db->where($array);
		$query = $this->db->get('alm_articulo')->result_array();
		return($query);
	}
	public function get_lastHistoryID()
	{
		$this->db->select_max('ID');
		$query = $this->db->get('alm_historial_a');
		$row = $query->row();
		return($row->ID);
	}
	public function add_newArticulo($articulo, $historial)
	{
		$this->db->insert('alm_articulo', $articulo);
		$this->db->insert('alm_historial_a', $historial);
		$link=array(
        'id_historial_a'=>$historial['id_historial_a'],
        'id_articulo'=> $articulo['cod_articulo']
        );
        $this->db->insert('alm_genera_hist_a', $link);
        return($this->db->insert_id());
	}
	public function add_articulo($articulo)
	{
		$cod['cod_articulo'] = $articulo['cod_articulo'];
		if(!$this->exist($cod))
		{
			$new_articulo = $articulo;
		}
		if($articulo['nuevos'])
		{
			$cod_historial = $articulo['cod_articulo'].'1'.$this->get_lastHistoryID();
			$historial= array(
	                    'id_historial_a'=> $cod_historial,//revisar, considerar eliminar la dependencia del codigo
	                    'entrada'=>$articulo['nuevos'],
	                    'nuevo'=>1,
	                    'observacion'=>'[insertado por lote, desde archivo de excel]',
	                    'por_usuario'=>$this->session->userdata('user')['id_usuario']
	                    );
			$link=array(
		        'id_historial_a'=> $cod_historial,
		        'id_articulo'=> $articulo['cod_articulo']
		        );
		}
		if($articulo['usados'])
		{
			$cod_historial = $articulo['cod_articulo'].'0'.$this->model_alm_articulos->get_lastHistoryID();
			$historial= array(
	                    'id_historial_a'=> $cod_historial,//revisar, considerar eliminar la dependencia del codigo
	                    'entrada'=>$articulo['usados'],
	                    'nuevo'=>0,
	                    'observacion'=>'[insertado por lote, desde archivo de excel]',
	                    'por_usuario'=>$this->session->userdata('user')['id_usuario']
	                    );	
			$link=array(
		        'id_historial_a'=> $cod_historial,
		        'id_articulo'=> $articulo['cod_articulo']
		        );
		}
		// if(!($value['nuevos'] || $value['usados']))//ley de morgan (!$value['nuevos'] && !$value['usados']) para captar los articulos inactivos
		// {
		// 	// echo_pre($key.' activo = '.$value['ACTIVE']);
			
		// }
		if(!empty($new_articulo))
		{
			$this->db->insert('alm_articulo', $new_articulo);
		}
		// $this->db->update('alm_articulo', $articulo, 'cod_articulo');
		if(!empty($historial))
		{
			$this->db->insert('alm_historial_a', $historial);
			$this->db->insert('alm_genera_hist_a', $link);
		}
		return( $this->db->insert_id());
		// return(0);
	}
//para insertar varios articulos nuevos y existentes// el add_batchArticulos se extinguira
	public function add_batchArticulos($articulos='')//esta en la capacidad de cargar respectivamente a las tablas que debe tocar en funcion de actividad, o inactividad
	{//incluido la insercion de codigos de articulos
		foreach ($articulos as $key => $value)
		{
			// echo_pre($value);
			if($value['nuevos'])
			{
				$cod_historial = $value['cod_articulo'].'1'.$this->model_alm_articulos->get_lastHistoryID();
				$historial[]= array(
		                    'id_historial_a'=> $cod_historial,//revisar, considerar eliminar la dependencia del codigo
		                    'entrada'=>$value['nuevos'],
		                    'nuevo'=>1,
		                    'observacion'=>'[insertado por lote, desde archivo de excel]',
		                    'por_usuario'=>$this->session->userdata('user')['id_usuario']
		                    );
				$link[]=array(
			        'id_historial_a'=> $cod_historial,
			        'id_articulo'=> $value['cod_articulo']
			        );
				$articulos[$key]['ACTIVE']=1;
			}
			if($value['usados'])
			{
				$cod_historial = $value['cod_articulo'].'0'.$this->model_alm_articulos->get_lastHistoryID();
				$historial[]= array(
		                    'id_historial_a'=> $cod_historial,//revisar, considerar eliminar la dependencia del codigo
		                    'entrada'=>$value['usados'],
		                    'nuevo'=>0,
		                    'observacion'=>'[insertado por lote, desde archivo de excel]',
		                    'por_usuario'=>$this->session->userdata('user')['id_usuario']
		                    );	
				$link[]=array(
			        'id_historial_a'=> $cod_historial,
			        'id_articulo'=> $value['cod_articulo']
			        );
				$articulos[$key]['ACTIVE']=1;
			}
			$cod['cod_articulo'] = $value['cod_articulo'];
			if(!$this->exist($cod))
			{
				$new_articulos[] = $value;
			}
			// if(!($value['nuevos'] || $value['usados']))//ley de morgan (!$value['nuevos'] && !$value['usados']) para captar los articulos inactivos
			// {
			// 	// echo_pre($key.' activo = '.$value['ACTIVE']);
				
			// }
		}
		// echo_pre($historial, __LINE__, __FILE__);
		// echo_pre($new_articulos, __LINE__, __FILE__);
		// sleep(8);
		if(!empty($new_articulos))
		{
			$this->db->insert_batch('alm_articulo', $new_articulos);
		}
		$this->db->update_batch('alm_articulo', $articulos, 'cod_articulo');
		if(!empty($historial))
		{
			$this->db->insert_batch('alm_historial_a', $historial);
			$this->db->insert_batch('alm_genera_hist_a', $link);
		}
		return( $this->db->insert_id());
		// die_pre($link);
	}
//fin de insertar varios articulos nuevos
	public function update_articulo($articulo, $historial)
	{
//		 die_pre($articulo, __LINE__, __FILE__);
		$this->db->where('cod_articulo', $articulo['cod_articulo']);
		$this->db->update('alm_articulo', $articulo);
		$this->db->insert('alm_historial_a', $historial);
		$link=array(
        'id_historial_a'=>$historial['id_historial_a'],
        'id_articulo'=> $articulo['cod_articulo']
        );
        $this->db->insert('alm_genera_hist_a', $link);
        return($this->db->insert_id());
	}
	public function get_ArtHistory($array)
	{
		// echo_pre($array['cod_articulo'], __LINE__, __FILE__);
		if(!is_array($array))
		{
			$aux = $array;
			$array = array('cod_articulo' => $aux);
		}
		$articulo['id_articulo'] = $array['cod_articulo'];
		$this->db->where($articulo);
		$this->db->order_by('alm_genera_hist_a.TIME', 'desc');
		$this->db->join('alm_genera_hist_a', 'alm_genera_hist_a.id_historial_a = alm_historial_a.id_historial_a');
		$history = $this->db->get('alm_historial_a')->result_array();
		return($history);

	}
	public function get_histConsumo($array)
	{

	}

	public function get_histmovimiento($array)
	{
		// echo_pre(date($array['desde']), __LINE__, __FILE__);
		// die_pre(date($array['hasta']), __LINE__, __FILE__);
		$this->db->where('alm_historial_a.TIME >', date('Y-m-d H:i:s', $array['desde']));
		$this->db->where('alm_historial_a.TIME <=', date('Y-m-d H:i:s', $array['hasta']));
		$this->db->join('alm_genera_hist_a', 'alm_genera_hist_a.id_historial_a = alm_historial_a.id_historial_a');
		$this->db->join('alm_articulo', 'alm_articulo.cod_articulo = alm_genera_hist_a.id_articulo');
		$query = $this->db->get('alm_historial_a');
		// die_pre($query->result_array(), __LINE__, __FILE__);
		return($query->result_array());
	}

/////////////////////////////////////////cierre de inventario
	public function ult_cierre()//fecha del ultimo cierre(si es primera vez, retorna la primera fecha registrada en el historial de la BD)
	{
////////validar fecha de ultimo cierre
		$this->load->helper('date');
		$this->db->select_max('TIME');
		$this->db->where('observacion', sha1('cierredeinventario'));
		$query = strtotime($this->db->get('alm_historial_a')->row_array()['TIME']);
		// die_pre(mdate("%d-%m-%Y", $query), __LINE__, __FILE__);
		if(empty($query))//para primera vez que se usa el sistema
		{
			$this->db->select_min('TIME');
			$query = strtotime($this->db->get('alm_historial_a')->row_array()['TIME']); //para uso del sistema
		}//fin de primera vez
////////fin validar fecha de ultimo cierre
		return($query);
	}
	public function ant_cierre($date)//devuelve la fecha del cierre anterior a la fecha dada.
	{
		$this->db->select('TIME');
		$this->db->where('alm_historial_a.TIME <=', date('Y-m-d H:i:s', $date));
		$this->db->where('observacion', sha1('cierredeinventario'));
		$query = strtotime($this->db->get('alm_historial_a')->row_array()['TIME']);
		if(empty($query))//para primera vez que se usa el sistema
		{
			$this->db->select_min('TIME');
			$query = strtotime($this->db->get('alm_historial_a')->row_array()['TIME']); //para uso del sistema
		}
		// die_pre($query['TIME'], __LINE__, __FILE__);
		return($query);

	}
	public function CEF() //fecha de Cierre de Ejercicio Fiscal segun gaceta oficial extraordinaria del 21 de marzo
	{	//http://www.uc.edu.ve/archivos/gacetas/extra2012/gacetaExtraor537.pdf
		$this->load->helper('date');
		$aux = mdate("%Y", time());
		$cef['desde'] = strtotime("01-01-".$aux);
		$cef['hasta'] = strtotime("31-03-".$aux);
		return($cef);
	}
	public function todos_cierres()//todos los cierres registrados en la BD se retornan para uso de referencia de historial implicito
	{
		$this->db->select('TIME');
		$this->db->where('observacion', sha1('cierredeinventario'));
		$query = $this->db->get('alm_historial_a');
		$cierres = array();
		foreach ($query->result() as $row)
		{
			$cierres[] = strtotime($row->TIME);
		}
		return($cierres);
	}
	public function build_report($config='')//reporte oficial de cierre de inventario
	{
		if(empty($config))//aqui es para el documento de cierre de inventario ($config debe estar vacio)
		{
			$this->db->select('cod_articulo AS Codigo, descripcion AS Descripcion, unidad AS Unidad, (usados + nuevos) AS Inventario_inicial');
			$this->db->where('ACTIVE', 1);
			$this->db->order_by('descripcion', 'asc');
			// $this->db->select_sum('entrada', 'entradas');
			// $this->db->select_sum('salida', 'salidas');
			// $this->db->where('alm_historial_a.TIME >', date('Y-m-d H:i:s', $array['desde']));
			// $this->db->where('alm_historial_a.TIME <=', date('Y-m-d H:i:s', $array['hasta']));
			// $this->db->group_by('id_articulo');
			// $this->db->join('alm_genera_hist_a', 'alm_genera_hist_a.id_historial_a = alm_historial_a.id_historial_a');
			// $this->db->join('alm_articulo', 'alm_articulo.cod_articulo = alm_genera_hist_a.id_articulo');
			// $query = $this->db->get('alm_historial_a')->result_array();
			$query = $this->db->get('alm_articulo')->result_array();
		}
		else//aqui es para la verificacion de parametros para generar un reporte generico de inventario
		{
			die_pre($config);
		}
		return($query);
	}
	public function insert_cierre($array)//to be continued
	{
		$rango['desde']=date('Y-m-d H:i:s', $array['desde']);
		$rango['hasta']=date('Y-m-d H:i:s', $array['hasta']);
		// echo_pre($rango, __LINE__, __FILE__);
		$fecha_cierre = strtotime('jan 1 +1 year');
		// echo_pre(date('Y-m-d H:i:s', $fecha_cierre), __LINE__, __FILE__);
		$history = array(
				array('TIME' => date('Y-m-d H:i:s', $fecha_cierre),
						'id_historial_a' => $this->get_lastHistoryID(), 
						'nuevo' => 0,
						'entrada' => null, 
						'observacion' => sha1('cierredeinventario'),
						'por_usuario' => $this->session->userdata('user')['id_usuario'])
					);
		$this->db->select('cod_articulo, descripcion, (usados + nuevos) AS existencia');
		$this->db->select_sum('entrada', 'entradas');
		$this->db->select_sum('salida', 'salidas');
		$this->db->where('alm_historial_a.TIME >', date('Y-m-d H:i:s', $array['desde']));
		$this->db->where('alm_historial_a.TIME <=', date('Y-m-d H:i:s', $array['hasta']));
		$this->db->group_by('id_articulo');
		$this->db->join('alm_genera_hist_a', 'alm_genera_hist_a.id_historial_a = alm_historial_a.id_historial_a');
		$this->db->join('alm_articulo', 'alm_articulo.cod_articulo = alm_genera_hist_a.id_articulo');
		$query = $this->db->get('alm_historial_a')->result_array();
		$generaHistorial = array();
		foreach ($query as $key => $value)
		{
			$auxhist = array('TIME' => date('Y-m-d H:i:s', $fecha_cierre),
							 'id_historial_a' => $this->get_lastHistoryID().$key,
							 'entrada' => $value['existencia'], 
							 'nuevo' => 0,
							 'observacion' => "cierre de inventario ".date('Y', time()),
							 'por_usuario' => $this->session->userdata('user')['id_usuario']
							 );
			$auxGenHist = array('id_articulo' => $value['cod_articulo'],
								'id_historial_a' => $this->get_lastHistoryID().$key);
			array_push($history, $auxhist);
			array_push($generaHistorial, $auxGenHist);
		}
		$this->db->insert_batch('alm_historial_a', $history);
		$this->db->insert_batch('alm_genera_hist_a', $generaHistorial);
		echo_pre($history, __LINE__, __FILE__);
		die_pre($generaHistorial, __LINE__, __FILE__);

		die_pre($query, __LINE__, __FILE__);


	}
	public function verif_arts($array='', $cods='')//verifica dado un codigo de articulo, y una cantidad, que en efecto en la BD sea igual
	{
		// echo '<br><strong>'.count($array).'</strong><br>';
		// $this->db->select('cod_articulo AS codigo, descripcion, (usados + nuevos) AS existencia');
		$this->db->select('cod_articulo');
		$query = $this->db->get('alm_articulo')->result_array();
	//Para extraer los articulos que estan el en archivo y no esten en el sistema
		$syscods=array();
		$middle=array();
		foreach ($query as $key2 => $value2)
		{
			$syscods[]=$value2['cod_articulo'];
		}

		$notInSystem = array_diff($cods, $syscods);
		foreach ($notInSystem as $key => $value)
		{
			$aux['codigo'] = $array[$key]['cod_articulo'];
			$aux['descripcion'] = $array[$key]['descripcion'];
			$aux['existencia'] = '';
			$aux['fisico'] = $array[$key]['existencia'];
			// $aux['observacion'] = 'El artículo en la línea '.$array['linea'].' no se encuentra registrado en el sistema';
			$aux['observacion'] = 'Linea: '.($key+2).' del excel suministrado';
			$aux['clasifier'] = 'Los siguientes artículos no se encuentran registrados en el sistema';
			$aux['sinRegistrar'] = 1;
			$aux['sobrante'] = 0;
			$aux['faltante'] = 0;
    		$aux['sinReportar'] = 0;
			$aux['sinProblemas'] = 0;
			$aux['sobranteGlobal'] =0;
			$aux['faltanteGlobal'] =0;
			// unset($array[$key]);
			$middle[] = $aux;
		}
	//verifica las cantidades entre los articulos del archivo y el sistema
		$top=array();
		$bottom=array();
		foreach ($array as $key => $value)
		{
			if($value['cod_articulo']!=' ')
			{
				$this->db->select('cod_articulo AS codigo, descripcion, (usados + nuevos) AS existencia');
				// $this->db->where('ACTIVE', 1);
				$this->db->where('cod_articulo', $value['cod_articulo']);
				$query = $this->db->get('alm_articulo')->row_array();
				if($value['existencia'] == $query['existencia'])
				{
					$aux['codigo'] = $value['cod_articulo'];
					$aux['descripcion'] = $value['descripcion'];
					$aux['existencia'] = $query['existencia'];
					$aux['fisico'] = $value['existencia'];
					// $aux['observacion'] = 'El artículo en la línea '.$array['linea'].' no se encuentra registrado en el sistema';
					$aux['observacion'] = '';
					$aux['clasifier'] = '-- No hay incongruencias --';
					$aux['sinRegistrar'] = 0;
					$aux['sobrante'] = 0;
					$aux['faltante'] = 0;
            		$aux['sinReportar'] = 0;
					$aux['sinProblemas'] = 1;
					$aux['sobranteGlobal'] =0;
					$aux['faltanteGlobal'] =0;
					$bottom[]=$aux;
				}
				else
				{
					if($value['existencia']> $query['existencia'])
					{

						$aux['sinRegistrar'] = 0;
						$aux['faltante'] = 0;
	            		$aux['sinReportar'] = 0;
						$aux['sinProblemas'] = 0;
						$aux['faltanteGlobal'] =0;
						$aux['sobrante'] = 1;
						$aux['sobranteGlobal'] = ($value['existencia']-$query['existencia']);
					}
					else
					{

						$aux['sinRegistrar'] = 0;
						$aux['sobrante'] = 0;
	            		$aux['sinReportar'] = 0;
						$aux['sinProblemas'] = 0;
						$aux['sobranteGlobal'] =0;
						$aux['faltante'] = 1;
						$aux['faltanteGlobal'] = ($query['existencia']-$value['existencia']);
					}
					$aux['codigo'] = $value['cod_articulo'];
					$aux['descripcion'] = $value['descripcion'];
					$aux['existencia'] = $query['existencia'];
					$aux['fisico'] = $value['existencia'];
					// $aux['observacion'] = 'El artículo en la línea '.$array['linea'].' no se encuentra registrado en el sistema';
					$aux['observacion'] = '';
					$aux['clasifier'] = 'Incongruencias en inventario';
					$top[]=$aux;
				}
			}
		}
		// die_pre($top, __LINE__, __FILE__);
		$aux = array_merge($top, $middle);
		$verified = array_merge($aux, $bottom);
		return($verified);
	}
	public function art_notInReport($array='')//verifica dado un arreglo resultante para el reporte, que los codigos que no esten en la lista de excel, sean agregados como no reportados
	{
		if(!empty($array) && isset($array))
		{
			// echo_pre($array, __LINE__, __FILE__);
			$this->db->select('cod_articulo AS codigo, descripcion, (usados + nuevos) AS existencia');
			$this->db->where('ACTIVE', 1);
			$aux=array();
			foreach ($array as $key => $value)
			{
				if($value['codigo']!=' ')
				{
					// $this->db->not_like('cod_articulo', $value['codigo'], 'none');
					$aux[]=$value['codigo'];
				}
			}
			$this->db->where_not_in('cod_articulo', $aux);
			$this->db->order_by('descripcion', 'asc');
			$query = $this->db->get('alm_articulo')->result_array();
			// echo_pre($query, __LINE__, __FILE__);
			// die_pre($this->db->last_query());
			$cod = 'codigo';
			if(!empty($query) && isset($query))
			{
				foreach ($query as $key => $value)
				{
					$value['fisico'] = 'X';
					// $value['observacion'] = 'El articulo no aparece en el reporte fisico suministrado';
					// $value['observacion'] = 'No hay referencia válida sobre el articulo en el reporte físico suministrado';
					$value['observacion'] = '';
					$value['clasifier'] = 'No hay referencia válida sobre el artículo en el reporte físico suministrado';
					$value['sinReportar'] = 1;
					$value['sinRegistrar'] = 0;
					$value['sobrante'] = 0;
					$value['faltante'] = 0;
					$value['sinProblemas'] = 0;
					$value['sobranteGlobal'] = 0;
					$value['faltanteGlobal'] = 0;
					$array[]=$value;
				}
			}
			return($array);
		}
	}
/////de la nueva tabla
	public function insert_reporte($reporte='')//inserta un solo item en la tabla de reporte
	{
		if(!empty($reporte))
		{
			// echo_pre($reporte);
			if(isset($reporte['cod_articulo'])&& isset($reporte['existencia']))
			{
				$this->db->select('ID, usados + nuevos + reserv AS existencia');
				$record = $this->db->get_where('alm_articulo', array('cod_articulo'=>$reporte['cod_articulo']))->row_array();
				$aux['id_articulo'] = $record['ID'];
				$aux['exist_reportada'] = $reporte['existencia'];
				$aux['exist_sistema'] = $record['existencia'];
				$this->db->insert('alm_reporte', $aux);
			}
			return($this->db->affected_rows() > 0) ? true : false;
		}

	}
	public function get_UnfinishedReporte($bool='')
	{
		$this->db->select('*');
		$query = $this->db->get_where('alm_reporte', array('revision'=>'reportado'))->result_array();
		if($query)
		{
			return($query);
		}
		else
		{
			return (FALSE);
		}
	}
	public function get_reportedTable()
	{
		die_pre($this->input->get_post());
	}
	//retorna el reporte más nuevo, si $year(año está vacío), en caso de tener el año de cualquiera de los dos formatos ('YYYY', 'YY'), solo retorna el reporte de ese año
	public function get_reporte($year='')
	{
		$this->load->helper('date');
		$this->db->select('*');
		$query = $this->db->get('alm_reporte')->result_array();//traigo toda la tabla
		$aux = 0;
		$rep = 0;
		foreach ($query as $key => $value)//recorro cada record de la tabla
		{
			if(isset($year)&&!empty($year))//si piden el año...
			{
				if($year == mdate('%Y', $aux) || $year == mdate('%y', $aux))//si el año del reporte es de 4 digitos o solo 2...
				{
					$i = $rep;//tomo la posicion del conjunto de reportes, de acuerdo al año que pide.
				}
			}
			if(mdate('%Y%m%d', strtotime($value['TIME']))-mdate('%Y%m%d', $aux) > 0)//si la diferencia entre un record y el siguiente es positiva(ha pasado mucho tiempo entre un record y el siguiente)
			{
				$rep++;//creo otro arreglo para el siguiente reporte
			}
			$reportes[$rep][]= $value;//almaceno el record en la variable de arreglos de reportes
			$aux = strtotime($value['TIME']);//guardo el tiempo del record actual, para compararlo en la siguiente iteración
		}
		if(isset($i))//si el parametro del año fue usado y encontró el reporte
		{
			$rep = $i;//reemplazo el reporte más nuevo, por el reporte del año solicitado
		}
		die_pre($reportes[$rep]);
		return ($reportes[$rep]);//retorno el reporte solicitado
	}
	//Retorna todos los reportes en un arreglo de reportes
	public function get_reportes()
	{
		$this->load->helper('date');
		$this->db->select('*');
		$query = $this->db->get('alm_reporte')->result_array();
		$aux = 0;
		$rep = 0;
		foreach ($query as $key => $value)
		{
			if(mdate('%y%m%d', strtotime($value['TIME']))-mdate('%y%m%d', $aux) > 0)
			{
				$rep++;
			}
			$reportes[$rep][]= $value;
			// $query[$key]['Report'] = mdate('%y%m%d', strtotime($value['TIME']))-mdate('%y%m%d', $aux);
			// $query[$key]['Report'] = mdate('%d', strtotime($value['TIME']) - $aux);
			$aux = strtotime($value['TIME']);
		}
		// echo $query[sizeof($query)-1]['TIME'].'<br>'.$query[0]['TIME'].'<br>';
		// echo ($query[sizeof($query)-1]['seconds'] - $query[0]['seconds']);
		// $aux = mdate('%y%m%d%i', ($query[sizeof($query)-1]['seconds'] - $query[0]['seconds']));
		// echo '<br>'.$aux.'<br>';
		die_pre($reportes);
		return($reportes);
	}
/////////////////////////////////////////fin de cierre de inventario
////////////////////alteraciones sobre tablas de la BD
	public function alterarAlmacen($fecha)
	{
		$this->load->dbforge();
		if($fecha=='17-10-2016')
		{
			if(!$this->db->field_exists('cod_artviejo', 'alm_articulo'))
			{
		//agrega campos nuevos a dos tablas existentes
				$fields = array(
					'partida_presupuestaria'=>array(
						'type'=>'varchar',
						'constraint'=>20,
						'collate'=>'utf8_general_ci'),
					'cod_ubicacion'=>array(
						'type'=>'varchar',
						'constraint'=>10,
						'collate'=>'utf8_general_ci'),
					'cod_artviejo'=>array(
						'type'=> 'varchar',
						'constraint'=>20,
						'collate'=>'utf8_general_ci',
						'NULL' => FALSE,
						'after' => 'cod_articulo'),
					'categoria'=> array(
						'type' =>"ENUM('0','1','2','3','4','5','6','7','8','9','10','11','12','13','14')",
						'default' => '0',
						'null'=>FALSE )
					);
				$this->dbforge->add_column('alm_articulo', $fields);
				$moreFields = array(
					'precio'=>array('type'=>'float')
					);
				$this->dbforge->add_column('alm_historial_a', $moreFields);
				$field = array(
					'motivo_alm'=>array(
						'type'=>'text'));
				$this->dbforge->add_column('alm_art_en_solicitud', $field);
		//debo retirar las clausulas de claves foraneas
		//las claves foraneas estan en la tabla alm_genera_hist_a
				$sql = 'ALTER TABLE `alm_genera_hist_a`
				DROP FOREIGN KEY `alm_genera_hist_a_ibfk_1`,
				DROP FOREIGN KEY `alm_genera_hist_a_ibfk_2`;';
				$this->db->query($sql);
				$sql = 'ALTER TABLE `alm_pertenece`
					DROP FOREIGN KEY `alm_pertenece_ibfk_1`;';
				$this->db->query($sql);
				$sql = 'ALTER TABLE `alm_retira`
					DROP FOREIGN KEY `alm_retira_ibfk_2`;';
			  	$this->db->query($sql);
		//Altera los tamanos de los campos necesarios
				$field_art = array(
					'cod_articulo'=>array(
						'type'=>'varchar',
						'constraint'=>20));
				$this->dbforge->modify_column('alm_articulo', $field_art);
				$fields_gen_hist_a = array(
					'id_articulo'=>array(
						'type'=>'varchar',
						'constraint'=>20),
					'id_historial_a'=>array(
						'type'=>'varchar',
						'constraint'=>29));
				$this->dbforge->modify_column('alm_genera_hist_a', $fields_gen_hist_a);
				$field_hist_a =array(
					'id_historial_a'=>array(
						'type'=>'varchar',
						'constraint'=>29));
				$this->dbforge->modify_column('alm_historial_a', $field_hist_a);
				$field_pertenece=array(
					'cod_articulo'=>array(
						'type'=>'varchar',
						'constraint'=>20));
				$this->dbforge->modify_column('alm_pertenece', $field_pertenece);
		//ahora vuelvo a agregar las clausulas de claves foraneas
				$sql = 'ALTER TABLE `alm_genera_hist_a`
				ADD CONSTRAINT `alm_genera_hist_a_ibfk_1` FOREIGN KEY (`id_articulo`) REFERENCES `alm_articulo` (`cod_articulo`) ON DELETE CASCADE ON UPDATE CASCADE,
				ADD CONSTRAINT `alm_genera_hist_a_ibfk_2` FOREIGN KEY (`id_historial_a`) REFERENCES `alm_historial_a` (`id_historial_a`) ON DELETE CASCADE ON UPDATE CASCADE;';
				$this->db->query($sql);
				$sql = 'ALTER TABLE `alm_pertenece`
				  ADD CONSTRAINT `alm_pertenece_ibfk_1` FOREIGN KEY (`cod_articulo`) REFERENCES `alm_articulo` (`cod_articulo`) ON DELETE CASCADE ON UPDATE CASCADE;';
				$this->db->query($sql);		  
					$sql = 'ALTER TABLE `alm_retira`
				  ADD CONSTRAINT `alm_retira_ibfk_2` FOREIGN KEY (`cod_articulo`) REFERENCES `alm_articulo` (`cod_articulo`) ON DELETE CASCADE ON UPDATE CASCADE;';
			  	$this->db->query($sql);

		//copia los codigos actuales, en la columna cod_artviejo en la tabla
				$this->db->select('cod_articulo AS cod_artviejo, cod_articulo');
				$art_codViejo = $this->db->get('alm_articulo')->result_array();
				$this->db->update_batch('alm_articulo', $art_codViejo, 'cod_articulo');

				$sql = "CREATE INDEX codigo_nuevo ON alm_articulo(cod_artviejo)";
				$this->db->query($sql);
			}
			else
			{
				echo_pre('Las alteraciones pertinentes de almacen, ya fueron realizadas previamente');
			}
		}
		if($fecha=='22-03-2017')//para actualizar la BD del sistema para las nuevas funciones, y posibles correcciones
		{
			if(!$this->db->field_exists('cod_categoria', 'alm_pertenece'))
			{
				$column = array(
					'cod_cartegoria'=>array(
						'name'=>'cod_categoria',
						'type'=>'varchar',
						'constraint'=>30));
				$this->dbforge->modify_column('alm_pertenece', $column);
			}
			if(!$this->db->table_exists('alm_reporte'))
			{
				$fields = array(
					'ID' => array(
						'type'=> 'bigint',
						'constraint'=>'20',
						'auto_increment'=>TRUE
						),
					'TIME' => array(
						'type'=> 'TIMESTAMP'
						),
					'id_articulo' => array(
						'type' => 'bigint'
						),
					'exist_reportada' => array(
						'type'=>'int',
						'constraint'=>11
						),
					'exist_sistema' => array(
						'type'=>'int',
						'constraint'=>11
						),
					'acta' => array(
						'type'=>'text',
						'null'=>TRUE
						),
					'justificacion' =>array(
						'type'=>'text',
						'null'=>TRUE
						),
					'revision' =>array(
						'type' => 'ENUM("reportado", "por_revisar", "revisado")',
						'default' => 'reportado',
						'null' => FALSE
						)
					);
				$this->dbforge->add_field($fields);
				$this->dbforge->add_field('CONSTRAINT FOREIGN KEY (id_articulo) REFERENCES alm_articulo(ID)');
				$this->dbforge->add_key(array('ID'), TRUE);
				$tableattrs=array('ENGINE' => 'InnoDB', 'CHARSET'=>'utf8');
				$this->dbforge->create_table('alm_reporte', TRUE, $tableattrs);
				// die_pre($this->db->last_query());
			}
			else
			{
				echo_pre('La tabla `alm_reporte` ya existe en la base de datos');
			}
			if(!$this->db->field_exists('segmento', 'alm_categoria') && !$this->db->field_exists('familia', 'alm_categoria'))
			{
				$fields = array(
					'cod_segmento'=>array(
						'type'=>'varchar',
						'constraint'=>3
						),
					'segmento' => array(
						'type'=>'text',
						'null'=>TRUE
						),
					'cod_familia'=>array(
						'type'=>'varchar',
						'constraint'=>5
						),
					'familia' => array(
						'type'=>'text',
						'null'=>TRUE
						)
					);
				$this->dbforge->add_column('alm_categoria', $fields);
			}
			else
			{
				echo_pre('El atributo `segmento` y `familia` ya existen en la tabla `alm_categoria`');
			}
			$cod_art = array(
					'cod_articulo'=>array(
						'name'=>'cod_articulo',
						'type'=>'varchar',
						'constraint'=>30));
			$id_cod_art = array(
					'id_articulo'=>array(
						'name'=>'id_articulo',
						'type'=>'varchar',
						'constraint'=>30));
			$hist_art = array(
					'id_historial_a'=>array(
						'name'=>'id_historial_a',
						'type'=>'varchar',
						'constraint'=>40));
			$this->dbforge->modify_column('alm_articulo', $cod_art);
			$this->dbforge->modify_column('alm_genera_hist_a', $id_cod_art);
			$this->dbforge->modify_column('alm_genera_hist_a', $hist_art);
			$this->dbforge->modify_column('alm_historial_a', $hist_art);
			$this->dbforge->modify_column('alm_pertenece', $cod_art);
			$this->dbforge->modify_column('alm_retira', $cod_art);
		}

	}

	public function create_newVersionTables()//migracion para version del 21/07/2016
	{
		$this->db->query("CREATE TABLE IF NOT EXISTS `alm_historial_s` (
				  		    `ID` bigint(20) NOT NULL AUTO_INCREMENT,
				  		    `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
				  		    `nr_solicitud` varchar(10) NOT NULL,
				  		    `fecha_ej` timestamp NOT NULL DEFAULT '2015-01-30 00:00:01',
				  		    `usuario_ej` varchar(9) NOT NULL,
				  		    `status_ej` enum('carrito','en_proceso','aprobado','enviado', 'retirado', 'completado', 'cancelado', 'anulado', 'cerrado') NOT NULL,
				  		    PRIMARY KEY (`ID`),
				  		    UNIQUE KEY `historial` (`nr_solicitud`, `status_ej`, `usuario_ej`)
				  		  ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;");
		
		$this->db->query("CREATE TABLE IF NOT EXISTS `alm_solicitud` (
						    `ID` bigint(20) NOT NULL AUTO_INCREMENT,
						    `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
						    `nr_solicitud` varchar(9) NOT NULL,
						    `status` enum('carrito','en_proceso','aprobado','enviado','completado', 'cancelado', 'anulado', 'cerrado') NOT NULL,
						    `observacion` text,
						    `motivo` text,
						    `fecha_gen` timestamp NOT NULL DEFAULT '2015-01-30 00:00:01',
						    `fecha_comp` timestamp NULL DEFAULT NULL,
						    PRIMARY KEY (`nr_solicitud`),
						    UNIQUE KEY `ID` (`ID`)
						  ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");

		$this->db->query("CREATE TABLE IF NOT EXISTS `alm_efectua` (
		  		  		    `ID` bigint(20) NOT NULL AUTO_INCREMENT,
		  		  		    `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		  		  		    `id_usuario` varchar(9) NOT NULL,
		  		  		    `nr_solicitud` varchar(9) NOT NULL,
		  		  		    `id_historial_s` bigint(20) NOT NULL,
		  		  		    PRIMARY KEY (`ID`),
		  		  		    UNIQUE KEY `procesa` (`id_usuario`,`nr_solicitud`, `id_historial_s`),
		  		  		    UNIQUE KEY `ID` (`ID`),
		  		  		    KEY `nr_solicitud` (`nr_solicitud`)
		  		  		  ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");

		$this->db->query("CREATE TABLE IF NOT EXISTS `alm_art_en_solicitud` (
		  		  		    `ID` bigint(20) NOT NULL AUTO_INCREMENT,
		  		  		    `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		  		  		    `id_articulo` bigint(20) NOT NULL,
		  		  		    `id_usuario` varchar(9) DEFAULT NULL,
		  		  		    `nr_solicitud` varchar(9) NOT NULL,
		  		  		    `cant_solicitada` int(11) NOT NULL,
		  		  		    `cant_aprobada` int(11) DEFAULT NULL,
		  		  		    `cant_usados` int(11) DEFAULT '0',
		  		  		    `cant_nuevos` int(11) DEFAULT '0',
		  		  		    `estado_articulo` enum('activo', 'anulado') NOT NULL DEFAULT 'activo',
		  		  		    `motivo` text CHARACTER SET utf8 DEFAULT NULL,
		  		  		    UNIQUE KEY `ID` (`ID`),
		  		  		    UNIQUE KEY `cont_art_solicitud` (`id_articulo`,`nr_solicitud`),
		  		  		    KEY `nr_solicitud` (`nr_solicitud`)
		  		  		  ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");
	}

	public function rename_oldVersionTables()//migracion para version del 21/07/2016
	{
		$this->load->dbforge();
		if(!$this->db->table_exists('alm_old_tablehistorial_s'))
		{
			$this->dbforge->rename_table('alm_historial_s', 'alm_old_tablehistorial_s');
			$this->dbforge->rename_table('alm_solicitud', 'alm_old_tablesolicitud');
		}
		else
		{
			die_pre('La migracion de version de la base de datos de almacen, ya fueron realizadas previamente');
		}
	}

	public function delete_oldVersionTables()//migracion para version del 21/07/2016
	{
		$this->load->dbforge();
		$this->dbforge->drop_table('alm_old_tablehistorial_s');
		$this->dbforge->drop_table('alm_aprueba');
		$this->dbforge->drop_table('alm_genera');
		$this->dbforge->drop_table('alm_retira');
		$this->dbforge->drop_table('alm_contiene');
		$this->dbforge->drop_table('alm_old_tablesolicitud');
	}

	public function migrate_ver1point3()//migracion para version del 21/07/2016
	{
		//creating the new tables
		$this->db->order_by('ID');
		// // $solicitudes=$this->db->get('alm_solicitud')->result_array();
		$solicitudes=$this->db->get('alm_old_tablesolicitud')->result_array();
		// // echo_pre($solicitudes, __LINE__, __FILE__);
		//enum('carrito','en_proceso','aprobado','enviado','completado', 'cancelado', 'anulado', 'cerrado') NOT NULL,
		// enum('carrito','en_proceso','aprobada','enviado','completado')
		foreach ($solicitudes as $key => $value)
		{
			unset($solicitudes[$key]['id_usuario']);
			if($value['status']=='aprobada')
			{
				$solicitudes[$key]['status']='aprobado';
			}
			$this->db->insert('alm_solicitud', $solicitudes[$key]);
		}
		$this->db->select('TIME, nr_solicitud, id_usuario');
		$this->db->order_by('ID');
		$genera = $this->db->get('alm_genera')->result_array();
		// echo_pre($genera, __LINE__, __FILE__);
		$this->db->select('nr_solicitud, TIME, id_usuario');
		$this->db->from('alm_aprueba');
		// $this->db->group_by('nr_solicitud DESC');
		$this->db->order_by('nr_solicitud ASC');
		$aprueba = array_reverse($this->db->get()->result_array());
		// die_pre($aprueba, __LINE__, __FILE__);
		$this->db->distinct();
		$this->db->select('TIME, nr_solicitud, id_usuario');
		$this->db->order_by('nr_solicitud');
		$this->db->group_by('nr_solicitud');
		$retira = $this->db->get('alm_retira')->result_array();//hay un nr_solicitud y un id_usuario por cada articulo en la solicitud
		// echo_pre($retira, __LINE__, __FILE__);
		$stop[] = count($genera);
		$stop[] = count($aprueba);
		$stop[] = count($retira);
		for ($i=0; $i < max($stop); $i++)
		{
			if(isset($genera[$i]))
			{
				$aux = array('nr_solicitud'=>$genera[$i]['nr_solicitud'],
							 'fecha_ej'=>$genera[$i]['TIME'],
							 'usuario_ej'=>$genera[$i]['id_usuario'],
							 'status_ej'=> 'carrito');
				$this->db->insert('alm_historial_s', $aux);
				$aux2 = array('TIME'=>$genera[$i]['TIME'],
							  'nr_solicitud'=>$genera[$i]['nr_solicitud'],
							  'id_usuario'=>$genera[$i]['id_usuario'],
							  'id_historial_s'=>$this->db->insert_id());
				$this->db->insert('alm_efectua', $aux2);
				$aux = array('nr_solicitud'=>$genera[$i]['nr_solicitud'],
							 'fecha_ej'=>$genera[$i]['TIME'],
							 'usuario_ej'=>$genera[$i]['id_usuario'],
							 'status_ej'=> 'en_proceso');
				$this->db->insert('alm_historial_s', $aux);
				$aux2 = array('TIME'=>$genera[$i]['TIME'],
							  'nr_solicitud'=>$genera[$i]['nr_solicitud'],
							  'id_usuario'=>$genera[$i]['id_usuario'],
							  'id_historial_s'=>$this->db->insert_id());
				$this->db->insert('alm_efectua', $aux2);
			}
			if(isset($aprueba[$i]))
			{
				$aux = array('nr_solicitud'=>$aprueba[$i]['nr_solicitud'],
							 'fecha_ej'=>$aprueba[$i]['TIME'],
							 'usuario_ej'=>$aprueba[$i]['id_usuario'],
							 'status_ej'=> 'aprobado');
				$this->db->insert('alm_historial_s', $aux);
				$aux2 = array('TIME'=>$aprueba[$i]['TIME'],
							  'nr_solicitud'=>$aprueba[$i]['nr_solicitud'],
							  'id_usuario'=>$aprueba[$i]['id_usuario'],
							  'id_historial_s'=>$this->db->insert_id());
				$this->db->insert('alm_efectua', $aux2);
			}
			if(isset($retira[$i]))
			{
				$aux = array('nr_solicitud'=>$retira[$i]['nr_solicitud'],
							 'fecha_ej'=>$retira[$i]['TIME'],
							 'usuario_ej'=>$retira[$i]['id_usuario'],
							 'status_ej'=> 'completado');
				$this->db->insert('alm_historial_s', $aux);
				$aux2 = array('TIME'=>$retira[$i]['TIME'],
							  'nr_solicitud'=>$retira[$i]['nr_solicitud'],
							  'id_usuario'=>$retira[$i]['id_usuario'],
							  'id_historial_s'=>$this->db->insert_id());
				$this->db->insert('alm_efectua', $aux2);
			}
		}


		//version vieja
		// CREATE TABLE IF NOT EXISTS `alm_contiene` (
		//   `NRS` varchar(9) NOT NULL,
		// ) ENGINE=InnoDB AUTO_INCREMENT=501 DEFAULT CHARSET=utf8;
		$cont_en_sol = $this->db->get('alm_contiene')->result_array();
		foreach ($cont_en_sol as $key => $value)
		{
			unset($cont_en_sol[$key]['NRS']);
			$cont_en_sol[$key]['id_usuario']=NULL;
			$cont_en_sol[$key]['estado_articulo']='activo';
			$cont_en_sol[$key]['motivo']='';
			$this->db->insert('alm_art_en_solicitud', $cont_en_sol[$key]);
		}
		//version nueva
		// CREATE TABLE `alm_art_en_solicitud` (
		//   `id_usuario` varchar(9) DEFAULT NULL,
		//   `estado_articulo` enum('activo','anulado') NOT NULL DEFAULT 'activo',
		//   `motivo` text
		// ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	}
////////////////////FIN de alteraciones sobre tablas de la BD
   //Esta es la funcion para cargar los datos desde el servidor para el datatable 
    function get_art()
    { 
       	$table = 'alm_articulo'; //El nombre de la tabla que estamos usando
        /* Array de las columnas para la table que deben leerse y luego ser enviados al DataTables. Usar ' ' donde
         * se desee usar un campo que no este en la base de datos
         */
        $aColumns = array('ID', 'descripcion', 'cod_articulo','categoria','cod_ubicacion');
  
        /* Indexed column (se usa para definir la cardinalidad de la tabla) */
        $sIndexColumn = "ID";
        
        
        /* Se establece la cantidad de datos que va a manejar la tabla (el nombre ya esta declarado al inico y es almacenado en var table */
        $sQuery = "SELECT COUNT('" . $sIndexColumn . "') AS row_count FROM $table ";
        $rResultTotal = $this->db->query($sQuery);
        $aResultTotal = $rResultTotal->row();
        $iTotal = $aResultTotal->row_count;
 
        /*
         * Paginacion (no debe manipularse)
         */
        $sLimit = "";
        $iDisplayStart = $this->input->get_post('start', true);
        $iDisplayLength = $this->input->get_post('length', true);
        if (isset($iDisplayStart) && $iDisplayLength != '-1') :
            $sLimit = "LIMIT " . intval($iDisplayStart) . ", " .
                    intval($iDisplayLength);
        endif;
        /* estos parametros son de configuracion por lo tanto tampoco deben tocarse*/
        $uri_string = $_SERVER['QUERY_STRING'];
        $uri_string = preg_replace("/\%5B/", '[', $uri_string);
        $uri_string = preg_replace("/\%5D/", ']', $uri_string);
 
        $get_param_array = explode("&", $uri_string);
        $arr = array();
        foreach ($get_param_array as $value):
            $v = $value;
            $explode = explode("=", $v);
            $arr[$explode[0]] = $explode[1];
        endforeach;
 
        $index_of_columns = strpos($uri_string, "columns", 1);
        $index_of_start = strpos($uri_string, "start");
        $uri_columns = substr($uri_string, 7, ($index_of_start - $index_of_columns - 1));
        $columns_array = explode("&", $uri_columns);
        $arr_columns = array();
        foreach ($columns_array as $value):
            $v = $value;
            $explode = explode("=", $v);
            if (count($explode) == 2):
                $arr_columns[$explode[0]] = $explode[1];
            else:
                $arr_columns[$explode[0]] = '';
            endif;
        endforeach;
 
        /*
         * Ordenamiento
         */
        $sOrder = "ORDER BY ";
        $sOrderIndex = $arr['order[0][column]'];
        $sOrderDir = $arr['order[0][dir]'];
        $bSortable_ = $arr_columns['columns[' . $sOrderIndex . '][orderable]'];
        if ($bSortable_ == "true"):
            $sOrder .= $aColumns[$sOrderIndex] .
                    ($sOrderDir === 'asc' ? ' asc' : ' desc');
        endif;
 
        /*
         * Filtros de busqueda(Todos creados con sentencias sql nativas ya que al usar las de framework daba errores)
         en la variable $sWhere se guarda la clausula sql del where y se evalua dependiendo de las situaciones */ 

        $sWhere = ""; // Se inicializa y se crea la variable
        $sSearchVal = $arr['search[value]']; //Se asigna el valor de la busqueda, este es el campo de busqueda de la tabla
        if (isset($sSearchVal) && $sSearchVal != ''): //SE evalua si esta vacio o existe
            $sWhere = "WHERE (";  //Se comienza a almacenar la sentencia sql
            for ($i = 0; $i < count($aColumns); $i++): //se abre el for para buscar en todas las columnas que leemos de la tabla
                $sWhere .= $aColumns[$i] . " LIKE '%" . $this->db->escape_like_str($sSearchVal) . "%' OR ";// se concatena con Like 
            endfor;
            $sWhere = substr_replace($sWhere, "", -3);
            $sWhere .= ')'; //Se cierra la sentencia sql
        endif;
 
        /* Filtro de busqueda individual */
        $sSearchReg = $arr['search[regex]'];
        for ($i = 0; $i < count($aColumns)-9; $i++):
            $bSearchable_ = $arr['columns[' . $i . '][searchable]'];
            if (isset($bSearchable_) && $bSearchable_ == "true" && $sSearchReg != 'false'):
                $search_val = $arr['columns[' . $i . '][search][value]'];
                if ($sWhere == ""):
                    $sWhere = "WHERE ";
                else:
                    $sWhere .= " AND ";
                endif;
                $sWhere .= $aColumns[$i] . " LIKE '%" . $this->db->escape_like_str($sSearchVal) . "%' ";
            endif;
        endfor; 
 
         /*
         * SQL queries
         * Aqui se obtienen los datos a mostrar
          * sJoin creada para el proposito de unir las tablas en una sola variable 
         */
      	
        // $this->db->join('alm_pertenece', 'alm_articulo.cod_articulo = alm_pertenece.cod_articulo');
        // $this->db->join('alm_categoria', 'alm_pertenece.cod_categoria = alm_categoria.cod_categoria');
        $sJoin="LEFT JOIN alm_pertenece ON alm_articulo.cod_articulo = alm_pertenece.cod_articulo
        JOIN alm_categoria ON alm_categoria.cod_categoria = alm_pertenece.cod_categoria";
        if ($sWhere == ""):
            $sQuery = "SELECT SQL_CALC_FOUND_ROWS alm_articulo.ID AS ID, alm_articulo.descripcion AS descripcion, alm_articulo.cod_articulo AS cod_articulo, alm_categoria.descripcion AS categoria, cod_ubicacion
            FROM $table $sJoin $sOrder $sLimit";
        else:
            $sQuery = "SELECT SQL_CALC_FOUND_ROWS alm_articulo.ID AS ID, alm_articulo.descripcion AS descripcion, alm_articulo.cod_articulo AS cod_articulo, alm_categoria.descripcion AS categoria, cod_ubicacion
            FROM $table $sJoin $sWhere $sOrder $sLimit";
        endif;
       	// echo_pre($sQuery);
        $rResult = $this->db->query($sQuery);
 
        /* Para buscar la cantidad de datos filtrados */
        $sQuery = "SELECT FOUND_ROWS() AS length_count";
        $rResultFilterTotal = $this->db->query($sQuery);
        $aResultFilterTotal = $rResultFilterTotal->row();
        $iFilteredTotal = $aResultFilterTotal->length_count;
 
        /*
         * A partir de aca se envian los datos del query hecho anteriormente al controlador y la cantidad de datos encontrados
         */
        $sEcho = $this->input->get_post('draw', true);
        $output = array(
            "draw" => intval($sEcho),
            "recordsTotal" => $iTotal,
            "recordsFiltered" => $iFilteredTotal,
            "data" => array()
        );
        //Aqui se crea el array que va a contener todos los datos que se necesitan para el datatable a medida que se obtienen de la tabla
        foreach ($rResult->result_array() as $art):
            $row = array();
            $row['ID'] = $art['ID'];      
            $row['descripcion'] = $art['descripcion'];
            $row['cod_articulo'] = $art['cod_articulo'];
            $row['categoria'] = $art['categoria'];
            $row['cod_ubicacion'] = $art['cod_ubicacion'];
            $output['data'][] = $row;
        endforeach;
        return $output;// Para retornar los datos al controlador
    }
    public function update_cod_articulo($articulo, $historial)
    {
//		 die_pre($articulo, __LINE__, __FILE__);
	$this->db->where('ID', $articulo['ID']);
//        $this->db->where_not_in('cod_articulo',$articulo['cod_articulo']);
	$this->db->update('alm_articulo', $articulo);
	$this->db->insert('alm_historial_a', $historial);
	$link=array(
            'id_historial_a'=>$historial['id_historial_a'],
            'id_articulo'=> $articulo['cod_articulo']
        );
        $this->db->insert('alm_genera_hist_a', $link);
        return($this->db->insert_id());
	}
        
    public function consul_cod($articulos)
    {
//        die_pre($articulos);
        $query = $this->db->get_where('alm_articulo',array('descripcion'=>$articulos['descripcion'],'cod_articulo'=> $articulos['cod_articulo'],'categoria'=> $articulos['categoria']));
        if($query->num_rows() > 0){
            return TRUE;
        }
        return FALSE;
            
    }
    public function edit_artCod($cod_artviejo, $nueva_data)
    {
    	$this->db->where('cod_artviejo', $cod_artviejo);
    	$this->db->update('alm_articulo', $nueva_data);
    	if($this->db->affected_rows()>0)
    	{
    		return TRUE;
    	}
    	else
    	{
    		return FALSE;
    	}
    }
    public function insert_categoria($categoria='')
    {
    	if(is_array($categoria))
    	{
    		$this->db->insert_batch('alm_categoria', $categoria);
    	}
    	else
    	{
    		$this->db->insert('alm_categoria', $categoria);
    	}

    	if($this->db->affected_rows()>0)
    	{
    		return TRUE;
    	}
    	else
    	{
    		return FALSE;
    	}
    }
}