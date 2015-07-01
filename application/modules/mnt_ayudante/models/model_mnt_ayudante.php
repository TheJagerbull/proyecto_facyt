<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_mnt_ayudante extends CI_Model
{
	//constructor predeterminado del modelo
	function __construct()
	{
		parent::__construct();
	}

	public function ayudante_a_orden($array)
	{
		if(!empty($array))
		{
			$this->db->insert('mnt_ayudante_orden', $array);

		}
		else
		{
			return(FALSE);
		}
	}
	public function ayudante_en_orden($id_trabajador, $id_orden_trabajo)
	{
		$array = array('id_trabajador'=>$id_trabajador, 'id_orden_trabajo'=>$id_orden_trabajo);
		die_pre($array);
		$query = $this->db->get_where();
		return(FALSE);
	}
	public function ordenes_de_ayudante($id_trabajador)
	{

		return(FALSE);
	}
}