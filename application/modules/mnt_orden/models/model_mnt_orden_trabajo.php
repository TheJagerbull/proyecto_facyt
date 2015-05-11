<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_mnt_orden_trabajo extends CI_Model
{
	//constructor predeterminado del modelo
	function __construct()
	{
		parent::__construct();}
	}
		

	//la funcion se usa para mostrar la orden...
	public function get_allorden($field='',$order='desc')
	{
		// SE EXTRAEN TODOS LOS DATOS DE TODOS LOS USUARIOS
		if(!empty($field))
			$this->db->order_by($field, $order); 
		$query = $this->db->get('mnt_orden_trabajo');
		return $query->result();
	}
	
	public function get_oneorden($id_orden='')
	{
		if(!empty($id_orden))
		{
			$this->db->where('id',$id_orden);
			// SE EXTRAEN TODOS LOS DATOS DE TODOS LOS USUARIOS
			$query = $this->db->get('mnt_orden_trabajo');
			return $query->row();
		}
		return FALSE;
	}

	
	public function insert_orden($data='')
	{
		if(!empty($data))
		{
			$this->db->insert('mnt_orden_trabajo',$data);
			return $this->db->insert_id();
		}
		return FALSE;
	}
	
	public function edit_orden($data='')
	{
		if(!empty($data))
		{
			$this->db->where('id',$data['id']);
			$this->db->update('mnt_orden_trabajo',$data);
			return $data['id'];
		}
		return FALSE;
	}
	