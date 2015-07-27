<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_mnt_ayudante extends CI_Model
{
	//constructor predeterminado del modelo
	function __construct()
	{
		parent::__construct();
	}

	public function ayudantes_enOrden($id_orden_trabajo)//retorna un entero de cantidad de ayudantes asignados en una orden
	{
		$aux['id_orden_trabajo']=$id_orden_trabajo;
		$query=$this->db->get_where('mnt_ayudante_orden', $aux)->num_rows;
		return($query);
	}
	public function ayudantesDeCuadrilla_enOrden($num_sol, $num_cuadrilla)//retorna un entero de cantidad de ayudantes de una cuadrilla asignada a la orden, que sean asignados en una orden
	{
		$this->db->select('*');
		$this->db->from('mnt_ayudante_orden');
		$this->db->where('id_cuadrilla', $num_cuadrilla);
		$this->db->where('id_orden_trabajo', $num_sol);
		$this->db->join('mnt_miembros_cuadrilla', 'mnt_miembros_cuadrilla.id_trabajador=mnt_ayudante_orden.id_trabajador');
		// die_pre($this->db->get()->result_array(), __LINE__, __FILE__);
		return($this->db->get()->result_array());
	}
	public function ayudante_a_orden($array)//asigna un ayudante a una orden, el array debe contener los nombres de las columnas como keys, y los datos
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
	public function ayudante_fuera_deOrden($array)//retira un ayudante de una orden, el array contiene el id del ayudante y el numero de la orden
	{//para eliminar a todos los ayudantes de una orden, se le pasa un array('id_orden_trabajo'=> id de la orden con el cambio de estatus)
		if(!empty($array))
		{
			$this->db->where($array);
			$this->db->delete('mnt_ayudante_orden');
			return(TRUE);
		}
		else
		{
			return(FALSE);
		}
	}
	public function ayudante_en_orden($id_trabajador, $id_orden_trabajo)//verifica si un ayudante esta en la orden
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

	public function ayudantes_DeOrden($id_orden_trabajo)//lista los ayudantes asignados en una orden
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
	public function ayudantes_NoDeOrden($id_orden_trabajo)//lista los ayudantes que no esten asignados a una orden (sujeto a ser mejorado)
	{
		$aux['id_orden_trabajo']=$id_orden_trabajo;
		$this->db->select('id_trabajador as id_usuario');
		$query=$this->db->get_where('mnt_ayudante_orden', $aux);

		if(!empty($query->result_array()))//si se asignaron ayudantes a esa tabla
		{
			$this->db->select('id_usuario, nombre, apellido');
			$this->db->where('tipo', 'obrero');
			$this->db->where('status', 'activo');
			$this->db->from('dec_usuario');
			foreach ($query->result() as $row)//porcion super mal desarrollada, deberia darme verguenza
			{
			 	$aux2['id_usuario']=$row->id_usuario;
			 	$this->db->not_like($aux2);
			}
			// die_pre($this->db->get()->result_array(), __LINE__, __FILE__);
		}
		else//si no hay ayudantes en esa tabla
		{
			$this->db->select('id_usuario, nombre, apellido');
			$this->db->where('tipo', 'obrero');
			$this->db->where('status', 'activo');
			$this->db->from('dec_usuario');
		}
		

		return($this->db->get()->result_array());
	}

	public function ordenes_y_ayudantes()//lista completamente todos los datos de la tabla de mnt ayudante orden
	{
		// $this->db->order_by("id_trabajador", "desc");
		return($this->db->get('mnt_ayudante_orden')->result_array());
	}
	public function array_of_orders()//lista las ordenes que tienen ayudantes asignados
    {
    	$this->db->select('id_orden_trabajo');
        $this->db->from('mnt_ayudante_orden');
        $this->db->group_by('id_orden_trabajo');
        $aux = $this->db->get()->result_array();
        return($aux);
        // echo_pre($aux, __LINE__, __FILE__);
        // $needle = array('id_orden_trabajo' => '000000026');
        // $bool=in_array($needle, $aux, TRUE);
        // if($bool)
        // {
        // 	die_pre("TRUE", __LINE__, __FILE__);
        // }
        // die_pre($bool, __LINE__, __FILE__);


    }
    public function array_of_help()
    {

    }
}