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
		return($query->result());
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
		// if(is_array($array))
		// {
		// 	$this->db->where($array);
		// }
		// else
		// {
			$this->db->where('cod_articulo', $array['cod_articulo']);
			$this->db->or_where('descripcion', $array['descripcion']);
		// }
		$query = $this->db->get('alm_articulo')->row_array();
		return($query);
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
	public function verif_art($array='')//verifica dado un codigo de articulo, y una cantidad, que en efecto en la BD sea igual
	{
		$this->db->select('cod_articulo AS codigo, descripcion, (usados + nuevos) AS existencia');
		$this->db->where('cod_articulo', $array['cod_articulo']);
		$query = $this->db->get('alm_articulo')->row_array();
		$query['fisico'] = $array['existencia'];
		if(!$query['codigo'])
		{
			$query = 'error de codigo de art&iacute;culo en l&iacute;nea '.$array['linea'];
			return($query);
		}
		else
		{
			if($query['fisico']>$query['existencia'])
			{
				$query['observacion'] = 'Hay un descuadre de inventario por: '.($query['fisico']-$query['existencia']).' art&iacute;culos de m&aacute;s';
				// $query['observacion'] = '+'.($query['fisico']-$query['existencia']);
			}
			else
			{
				if($query['fisico']<$query['existencia'])
				{
					$query['observacion'] = 'Hay un descuadre de inventario por: '.($query['existencia']-$query['fisico']).' art&iacute;culos menos';
					// $query['observacion'] = ($query['fisico']-$query['existencia']);
				}
				else
				{
					$query['observacion'] = '';
				}
			}
		}
		return($query);
	}
	public function art_notInReport($array='')//verifica dado un arreglo resultante para el reporte, que los codigos que no esten en la lista de excel, sean agregados como no reportados
	{
		if(!empty($array) && isset($array))
		{
			// echo_pre($array, __LINE__, __FILE__);
			$this->db->select('cod_articulo AS codigo, descripcion, (usados + nuevos) AS existencia');
			$this->db->where('ACTIVE', 1);
			$this->db->order_by('descripcion', 'asc');
			$query = $this->db->get('alm_articulo')->result_array();
			$cod = 'codigo';
			foreach ($query as $key => $value)
			{
				if(!isSubArray_inArray($value, $array, $cod))
				{
					// echo_pre($value);
					$value['fisico'] = 'X';
					$value['observacion'] = 'El articulo no aparece en el reporte fisico suministrado';
					$array[]=$value;
				}
			}
			usort($array, 'sortByDescripcion');
			// die_pre($array, __LINE__, __FILE__);
			return($array);
		}
	}
/////////////////////////////////////////fin de cierre de inventario
	public function alterarAlmacen()
	{
		$this->load->dbforge();
		// $this->dbforge->add_key('cod_artnuevo');
		$fields = array(
			'precio'=>array(
				'type'=>'float'),
			'partida_presupuestaria'=>array(
				'type'=>'varchar',
				'constraint'=>20),
			'cod_ubicacion'=>array(
				'type'=>'varchar',
				'constraint'=>10),
			'cod_artviejo'=>array(
				'type'=> 'varchar',
				'constraint'=>20,
				'NULL' => FALSE,
				'after' => 'cod_articulo')
			);
		$this->dbforge->add_column('alm_articulo', $fields);
		$field = array(
			'motivo_alm'=>array(
				'type'=>'text'));
		$this->dbforge->add_column('alm_art_en_solicitud', $field);


		$field_art = array(
			'cod_articulo'=>array(
				'type'=>'varchar',
				'constraint'=>9));
		$this->dbforge->modify_column('alm_articulo', $field_art);
		$fields_gen_hist_a = array(
			'id_articulo'=>array(
				'type'=>'varchar',
				'constraint'=>9),
			'id_historial_a'=>array(
				'type'=>'varchar',
				'constraint'=>15));
		$this->dbforge->modify_column('alm_genera_hist_a', $fields_gen_hist_a);
		$field_hist_a =array(
			'id_historial_a'=>array(
				'type'=>'varchar',
				'constraint'=>15));
		$this->dbforge->modify_column('alm_historial_a', $field_hist_a);


		$sql = "CREATE INDEX codigo_nuevo ON alm_articulo(cod_artviejo)";
		$this->db->query($sql);

	}
        
    var $table = 'alm_articulo'; //El nombre de la tabla que estamos usando
   //Esta es la funcion para cargar los datos desde el servidor para el datatable 
    function get_art()
    { 
       
        /* Array de las columnas para la table que deben leerse y luego ser enviados al DataTables. Usar ' ' donde
         * se desee usar un campo que no este en la base de datos
         */
        $aColumns = array('ID', 'cod_articulo', 'descripcion');
  
        /* Indexed column (se usa para definir la cardinalidad de la tabla) */
        $sIndexColumn = "ID";
        
        
        /* Se establece la cantidad de datos que va a manejar la tabla (el nombre ya esta declarado al inico y es almacenado en var table */
        $sQuery = "SELECT COUNT('" . $sIndexColumn . "') AS row_count FROM $this->table ";
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
            $sWhere = "where (";  //Se comienza a almacenar la sentencia sql
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
                    $sWhere = "AND ";
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
      
        if ($sWhere == ""):
            $sQuery = "SELECT SQL_CALC_FOUND_ROWS " . str_replace(" , ", " ", implode(", ", $aColumns)) . "
            FROM $this->table $sOrder $sLimit";
        else:
            $sQuery = "SELECT SQL_CALC_FOUND_ROWS " . str_replace(" , ", " ", implode(", ", $aColumns)) . "
            FROM $this->table $sWhere $sOrder $sLimit";
        endif;
//        echo_pre($sQuery);
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
            $output['data'][] = $row;
        endforeach;
        return $output;// Para retornar los datos al controlador
    }
    public function update_cod_articulo($articulo, $historial)
    {
//		 die_pre($articulo, __LINE__, __FILE__);
	$this->db->where('ID', $articulo['ID']);
        $this->db->where_not_in('cod_articulo',$articulo['cod_articulo']);
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
        $query = $this->db->get_where('alm_articulo',array('cod_articulo'=> $articulos['cod_articulo']));
        if($query->num_rows() > 0){
            return TRUE;
        }
        return FALSE;
            
    }
}