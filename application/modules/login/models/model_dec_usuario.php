<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_dec_usuario extends CI_Model
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
			'id_usuario' => $post['id'],
			'password' => $post['password']
		);
		$query = $this->db->get_where('dec_usuario',$data);
		
		if($query->num_rows() == 1)
			return $query->row();
		else
			return FALSE;
	}

	//verifica que el usuario se encuentra en la base de datos, para el controlador, linea 13
	public function exist($where)
    {
        $query = $this->db->get_where('dec_usuario',$where);
        if($query->num_rows() > 0)
            return TRUE;

        return FALSE;
    }
	
	//la funcion se usa para mostrar los usuarios de la base de datos en alguna tabla...
	//para filtrar los roles, y cualquier dato de alguna columna, se debe realizar con condicionales desde la vista en php
	public function get_allusers($field='id_usuario',$order='desc')
	{
		// SE EXTRAEN TODOS LOS DATOS DE TODOS LOS USUARIOS
		if(!empty($field))
			$this->db->order_by($field, $order); 
		$query = $this->db->get('dec_usuario');
		return $query->result();
	}
	
	public function get_oneuser($id_usuario='')
	{
		if(!empty($id_usuario))
		{
			$this->db->where('id',$id_usuario);
			// SE EXTRAEN TODOS LOS DATOS DE TODOS LOS USUARIOS
			$query = $this->db->get('dec_usuario');
			return $query->row();
		}
		return FALSE;
	}
	
	public function insert_user($data='')
	{
		if(!empty($data))
		{
			$this->db->insert('dec_usuario',$data);
			return $this->db->insert_id();
		}
		return FALSE;
	}
	
	public function edit_user($data='')
	{
		if(!empty($data))
		{
			$this->db->where('id',$data['id']);
			$this->db->update('dec_usuario',$data);
			return $data['id'];
		}
		return FALSE;
	}
	
	public function drop_user($id='')
	{
		if(!empty($id))
		{
			$this->db->delete('dec_usuario',array('id'=>$id));
			return TRUE;
		}
		return FALSE;
	}
}