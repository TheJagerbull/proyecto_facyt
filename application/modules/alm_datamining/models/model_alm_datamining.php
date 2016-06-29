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
		$this->db->select('alm_genera_hist_a.TIME AS TIME, cod_articulo, entrada, salida, nuevos + usados AS exist, descripcion');
		$this->db->join('alm_genera_hist_a', 'alm_genera_hist_a.id_articulo=alm_articulo.cod_articulo');
		$this->db->join('alm_historial_a', 'alm_historial_a.id_historial_a=alm_genera_hist_a.id_historial_a');
		$this->db->group_by(array('id_articulo', 'alm_genera_hist_a.ID', 'alm_historial_a.ID'));
		$query = $this->db->get('alm_articulo')->result_array();
		$aux=$query;
		$query = array();
		foreach ($aux as $key => $value)
		{
			$query[$value['cod_articulo']]['movimientos']=0;
			$query[$value['cod_articulo']]['TIME']=0;
			$query[$value['cod_articulo']]['entradas']=0;
			$query[$value['cod_articulo']]['salidas']=0;
			$query[$value['cod_articulo']]['existencia']=$value['exist'];
		}
		foreach ($aux as $key => $value)
		{
			$inttime=strtotime($value['TIME']);
			$query[$value['cod_articulo']]['movimientos']++;
			$query[$value['cod_articulo']]['TIME']+=$inttime;
			$query[$value['cod_articulo']]['entradas']+=$value['entrada'];
			$query[$value['cod_articulo']]['salidas']+=$value['salida'];
			$query[$value['cod_articulo']]['existencia']=$value['exist'];
			$query[$value['cod_articulo']]['descripcion']=$value['descripcion'];
		}
		$datestring = "%Y-%m-%d %H:%i:%s";
		foreach ($query as $key => $value)
		{
			$aux = $query[$key]['TIME']/$query[$key]['movimientos'];
			$query[$key]['TIME']=mdate($datestring, round($aux));

			// $query[$key]['TIME']= $query[$key]['TIME']/$query[$key]['movimientos'];
			// $query[$key]['other']= round($query[$key]['TIME']);
			// $query[$key]['time_format']=mdate($datestring, round($query[$key]['TIME']));
		}
		return($query);
	}


}