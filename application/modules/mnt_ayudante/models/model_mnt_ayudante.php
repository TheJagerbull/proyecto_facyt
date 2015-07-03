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

	public function ayudantes_DeOrden($id_orden_trabajo)
	{
		$aux['id_orden_trabajo']=$id_orden_trabajo;
		$this->db->select('id_usuario, nombre, apellido');
		$this->db->where('tipo', 'obrero');
		$this->db->where('status', 'activo');
		$this->db->from('dec_usuario');
		$this->db->like($aux);
		$this->db->join('mnt_ayudante_orden', 'mnt_ayudante_orden.id_trabajador = dec_usuario.id_usuario','right');
		// die_pre($this->db->get()->result_array(), __LINE__, __FILE__);
		return($this->db->get()->result_array());
	}
	public function ayudantes_NoDeOrden($id_orden_trabajo)
	{
		$bool=!empty($this->db->get('mnt_ayudante_orden')->result_array());
		$aux['id_orden_trabajo']=$id_orden_trabajo;
		
		$this->db->select('id_usuario, nombre, apellido');
		$this->db->where('tipo', 'obrero');
		$this->db->where('status', 'activo');
		$this->db->from('dec_usuario');
		// if($bool)
		// {
		// 	$this->db->not_like($aux);
		// 	$this->db->join('mnt_ayudante_orden', 'mnt_ayudante_orden.id_trabajador = dec_usuario.id_usuario', 'right');
		// }
		

		// die_pre($this->db->get()->result_array(), __LINE__, __FILE__);
		return($this->db->get()->result_array());
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