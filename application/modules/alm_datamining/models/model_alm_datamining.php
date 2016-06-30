<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_alm_datamining extends CI_Model
{
	//constructor predeterminado del modelo
	function __construct()
	{
		parent::__construct();
	}

	public function get_allArticulos()
	{
		$this->load->helper('date');
		// $this->db->select('alm_genera_hist_a.TIME AS TIME, cod_articulo, entrada, salida, nuevos + usados AS exist, descripcion');
		// $this->db->select('alm_genera_hist_a.TIME AS TIME, cod_articulo, entrada, salida, nuevos + usados AS exist');
		$this->db->select('cod_articulo, entrada, salida, nuevos + usados AS exist');
		$this->db->join('alm_genera_hist_a', 'alm_genera_hist_a.id_articulo=alm_articulo.cod_articulo');
		$this->db->join('alm_historial_a', 'alm_historial_a.id_historial_a=alm_genera_hist_a.id_historial_a');
		$this->db->group_by(array('id_articulo', 'alm_genera_hist_a.ID', 'alm_historial_a.ID'));
		$query = $this->db->get('alm_articulo')->result_array();
		$aux=$query;
		echo_pre($query, __LINE__, __FILE__);

		$query = array();
		$cantExit=array();
		$cantEntry=array();
		foreach ($aux as $key => $value)
		{
			if(!isset($query[$value['cod_articulo']]))
			{
				$query[$value['cod_articulo']]['movimientos']=0;
				// $query[$value['cod_articulo']]['TIME']=0;
				$query[$value['cod_articulo']]['entradas']=0;
				$query[$value['cod_articulo']]['salidas']=0;
				$query[$value['cod_articulo']]['existencia']=$value['exist'];
				$cantExit[$value['cod_articulo']]=0;
				$cantEntry[$value['cod_articulo']]=0;
			}
		}
		foreach ($aux as $key => $value)
		{
			// $inttime=strtotime($value['TIME']);
			$query[$value['cod_articulo']]['movimientos']++;
			// $query[$value['cod_articulo']]['TIME']+=$inttime;
			$query[$value['cod_articulo']]['entradas']+=$value['entrada'];
			$query[$value['cod_articulo']]['salidas']+=$value['salida'];
			$query[$value['cod_articulo']]['existencia']=$value['exist'];
			if(isset($aux[$key]['entrada']))
			{
				$cantEntry[$value['cod_articulo']]++;
			}
			if(isset($aux[$key]['salida']))
			{
				$cantExit[$value['cod_articulo']]++;
			}
			// $query[$value['cod_articulo']]['descripcion']=$value['descripcion'];
		}
		$datestring = "%Y-%m-%d %H:%i:%s";
		$i=0;
		$dataset=array();
		foreach ($query as $key => $value)
		{
			// $aux = $query[$key]['TIME']/$query[$key]['movimientos'];
			$dataset[$i]['cod_articulo'] = $key;
			$dataset[$i]['movimientos']= $query[$key]['movimientos'];
			// $dataset[$i]['TIME']=mdate($datestring, round($aux));
			// $dataset[$i]['TIME']= $query[$key]['TIME'];
			$dataset[$i]['entradas']= $query[$key]['entradas']/$query[$key]['movimientos'];
			// $dataset[$i]['entradas']= $query[$key]['entradas']/$cantEntry[$key];
			$dataset[$i]['salidas']= $query[$key]['salidas']/$query[$key]['movimientos'];
			// $dataset[$i]['salidas']= $query[$key]['salidas']/$cantExit[$key];
			$dataset[$i]['existencia']= $query[$key]['existencia'];
			// $dataset[$i]['descripcion']= $query[$key]['descripcion'];
			$dataset[$i]['solicitado']= $this->count_solicitado($key);
			// $dataset[$i]['TIME']= $query[$key]['TIME']/$query[$key]['movimientos'];
			// $query[$key]['other']= round($query[$key]['TIME']);
			// $query[$key]['time_format']=mdate($datestring, round($query[$key]['TIME']));
			$i++;
		}
		return($dataset);
	}

	public function count_solicitado($cod_articulo)
	{
		$this->db->select('ID');
		$this->db->where('cod_articulo', $cod_articulo);
		$aux = $this->db->get('alm_articulo')->row_array();
		$this->db->where('id_articulo', $aux['ID']);
		return(count($this->db->get('alm_art_en_solicitud')->result_array()));
	}

	public function migrate_ver3point1()
	{

	}

}