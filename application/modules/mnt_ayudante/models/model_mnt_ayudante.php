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
			return(TRUE);

		}
		else
		{
			return(FALSE);
		}
	}
	public function ayudante_en_orden($id_trabajador, $id_orden_trabajo)
	{
		$array = array('id_trabajador'=>$id_trabajador, 'id_orden_trabajo'=>$id_orden_trabajo);
		$query = $this->db->get_where('mnt_ayudante_orden', $array);
		if($query->num_rows==0)
		{
			return(FALSE);
		}
		else
		{
			return(TRUE);
		}
	}
	public function ayudantes_de_orden($id_orden_trabajo)
	{
		$aux['id_orden_trabajo']=$id_orden_trabajo;
		$this->db->select('id_trabajador');
		$this->db->like($aux);
		// die_pre($this->db->get('mnt_ayudante_orden')->result_array(), __LINE__, __FILE__);
		return($this->db->get('mnt_ayudante_orden')->result_array());
	}
	public function ordenes_y_ayudantes()
	{
		// $this->db->order_by("id_trabajador", "desc");
		return($this->db->get('mnt_ayudante_orden')->result_array());
	}
	public function array_of_orders()
    {
        $aux = $this->ordenes_y_ayudantes();

        foreach ($aux as $key => $item)
        {
        	$help[$item['id_trabajador']]=
			echo_pre($item);
        }

        die_pre($aux, __LINE__, __FILE__);

    }
    public function array_of_help()
    {

    }
}