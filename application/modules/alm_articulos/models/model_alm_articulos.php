<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_alm_articulos extends CI_Model
{
	//constructor predeterminado del modelo
	function __construct()
	{
		parent::__construct();
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
		$this->db->where('ACTIVE', 1);
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
		$this->db->where('ACTIVE', '1');
		$this->db->where_in('ID', $ID);
		if($bool)//para obtener 1 solo resultado
		{
			return($this->db->get('alm_articulo')->result_array()[0]);
		}
		else
		{
			return($this->db->get('alm_articulo')->result_array());
		}
		
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
			$this->db->where('ACTIVE', '1');
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
		$this->db->where('ACTIVE', 1);
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
		$this->db->where($array);
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
	public function update_articulo($articulo, $historial)
	{
		// die_pre($articulo, __LINE__, __FILE__);
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
		echo_pre($array['cod_articulo'], __LINE__, __FILE__);
		$articulo['id_articulo'] = $array['cod_articulo'];
		$this->db->where($articulo);
		$this->db->order_by('TIME', 'desc');
		$history = $this->db->get('alm_genera_hist_a')->row_array();
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
	public function build_report($array)//reporte oficial de cierre de inventario
	{
		$this->db->select('descripcion, (usados + nuevos) AS existencia');
		$this->db->select_sum('entrada', 'entradas');
		$this->db->select_sum('salida', 'salidas');
		$this->db->where('alm_historial_a.TIME >', date('Y-m-d H:i:s', $array['desde']));
		$this->db->where('alm_historial_a.TIME <=', date('Y-m-d H:i:s', $array['hasta']));
		$this->db->group_by('id_articulo');
		$this->db->join('alm_genera_hist_a', 'alm_genera_hist_a.id_historial_a = alm_historial_a.id_historial_a');
		$this->db->join('alm_articulo', 'alm_articulo.cod_articulo = alm_genera_hist_a.id_articulo');
		$query = $this->db->get('alm_historial_a')->result_array();
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
/////////////////////////////////////////fin de cierre de inventario
}