<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_air_tipo_eq extends CI_Model
{
	//constructor predeterminado del modelo
	function __construct()
	{
		parent::__construct();
	}
	
	//verifica la combinacion de usuario y contrasena, y en case de que exista, devuelve todos los datos del usuario
	//se usa para las sesiones (Linea 43 del controlador usuario.php)
	public function existe($post)
	{
		$data = array
		(
			'id' => $post['id'],
					);
		$query = $this->db->get_where('air_tipo_eq',$data);
		if($query->num_rows() == 1)
		{
			return $query->row();
		}
		else
		{
			return FALSE;
		}
	}
	//verifica que el usuario se encuentra en la base de datos, para el controlador, linea 13
	public function exist($where)
    {
        $query = $this->db->get_where('air_tipo_eq',$where);
        if($query->num_rows() > 0)
            return TRUE;

        return FALSE;
    }

	//la funcion se usa para mostrar los usuarios de la base de datos en alguna tabla...
	//para filtrar los roles, y cualquier dato de alguna columna, se debe realizar con condicionales desde la vista en php
	public function get_alleq($field='id',$order='desc')
	{
		// SE EXTRAEN TODOS LOS DATOS DE TODOS LOS USUARIOS
		if(!empty($field))
			$this->db->order_by($field, $order); 
		$query = $this->db->get('air_tipo_eq');
		return $query->result();
	}
	
	public function get_oneq($id='')
	{
		if(!empty($id_usuario))
		{
			$this->db->where('ID',$id);
			// SE EXTRAEN TODOS LOS DATOS DE TODOS LOS USUARIOS
			$query = $this->db->get('air_tipo_eq');
			return $query->row();
		}
		return FALSE;
	}

	
	public function insert_equipo($data='')
	{
		if(!empty($data))
		{
			$this->db->insert('air_tipo_eq',$data);
			return $this->db->insert_id();
		}
		return FALSE;
	}
	
	public function edit_equipo($data='')
	{
		if(!empty($data))
		{
			$this->db->where('ID',$data['ID']);
			$this->db->update('air_tipo_eq',$data);
			return $data['ID'];
		}
		return FALSE;
	}
	
	public function drop_equipo($id='')
	{
		if(!empty($id))
		{
			$this->db->delete('air_tipo_eq',array('ID'=>$id));
			return TRUE;
		}
		return FALSE;
		
	}

	
	public function buscar_usr($eq='')
	{
		if(!empty($eq))
		{
			$this->db->like('id',$eq);
			$this->db->or_like('desc',$eq);
					
			return $this->db->get('air_tipo_eq')->result();
		}
		return FALSE;
	}

	public function sw_search($keyword)
    {
         $this->db->select('id, friendly_name');
         $this->db->from('business_category');
         $this->db->where('suppress', 0);
         $this->db->like('friendly_name', $keyword);
         $this->db->order_by("friendly_name", "asc");
         
         $query = $this->db->get();
         foreach($query->result_array() as $row){
             //$data[$row['friendly_name']];
             $data[] = $row;
         }
         //return $data;
         return $query;
     }

	public function ajax_likeUsers($data)
	{
		$this->db->like('id', $data);
		$this->db->or_like('desc',$data);
		$query = $this->db->get('air_tipo_eq');
		return $query->result();
	}
///no pertenece al proyecto


}