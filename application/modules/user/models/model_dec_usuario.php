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
        $query = $this->db->get_where('dec_usuario',$where);
        if($query->num_rows() > 0)
            return TRUE;

        return FALSE;
    }
	public function get_userCount()
	{
		return($this->db->count_all('dec_usuario'));
	}
	//la funcion se usa para mostrar los usuarios de la base de datos en alguna tabla...
	//para filtrar los roles, y cualquier dato de alguna columna, se debe realizar con condicionales desde la vista en php
	public function get_allusers($field='',$order='', $per_page='', $offset='')
	{
		// SE EXTRAEN TODOS LOS DATOS DE TODOS LOS USUARIOS
		if(!empty($field))
			$this->db->order_by($field, $order);
		$query = $this->db->get('dec_usuario', $per_page, $offset);
		return $query->result();
	}
	
	public function get_oneuser($id_usuario='')
	{
		if(!empty($id_usuario))
		{
			$this->db->where('ID',$id_usuario);
			// SE EXTRAEN TODOS LOS DATOS DE TODOS LOS USUARIOS
			$query = $this->db->get('dec_usuario');
			return $query->row();
		}
		return FALSE;
	}
    
    //agregado por jcparra para mostrar datos de los usuarios de la cuadrilla
    public function get_user_cuadrilla($id_usuario='')
	{
		if(!empty($id_usuario))
		{
			$this->db->where('id_usuario',$id_usuario);
            $this->db->select('nombre , apellido');
			$query = $this->db->get('dec_usuario');
			return $query->row_array();
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
			$this->db->where('ID',$data['ID']);
			$this->db->update('dec_usuario',$data);
			return $data['ID'];
		}
		return FALSE;
	}
	
	public function drop_user($id='')
	{
		if(!empty($id))
		{
			//$this->db->delete('dec_usuario',array('ID'=>$id));
			$this->db->where('ID', $id);
			$data = array(
					'status'=> 'inactivo'
					);
			$this->db->update('dec_usuario', $data);
			return TRUE;
		}
		return FALSE;
	}

	public function activate_user($id='')
	{
		if(!empty($id))
		{
			//$this->db->delete('dec_usuario',array('ID'=>$id));
			$this->db->where('ID', $id);
			$data = array(
					'status'=> 'activo'
					);
			$this->db->update('dec_usuario', $data);
			return TRUE;
		}
		return FALSE;
	}
	public function buscar_usr($usr='', $field='', $order='', $per_page='', $offset='')
	{
		if(!empty($usr))
		{
			if(!empty($field))
			{
				$this->db->order_by($field, $order);
			}
			$usr=preg_split("/[\s,]+/", $usr);
			$first = $usr[0];
			if(!empty($usr[1]))
			{
				$second = $usr[1];
				$this->db->like('apellido',$second);
			}
			if(!empty($usr[2]))
			{
				$third = $usr[2];
				$this->db->like('id_usuario',$third);
			}
			$this->db->like('nombre',$first);
			$this->db->or_like('apellido',$first);
			$this->db->or_like('id_usuario',$first);
			$this->db->or_like('sys_rol',$first);
			// $this->db->or_like('dependencia',$first); //hay que acomodar, ahora dependencia es un codigo
			$this->db->or_like('cargo',$first);
			$this->db->or_like('status',$first);
			if(!empty($per_page)&& !empty($offset))
			{
				return $this->db->get('dec_usuario', $per_page, $offset)->result();
			}
			else
			{
				return $this->db->get('dec_usuario')->result();
			}
		}
		return FALSE;
	}
	public function buscar_usrCount($usr='')
	{
		if(!empty($usr))
		{
			$usr=preg_split("/[\s,]+/", $usr);
			$first = $usr[0];
			if(!empty($usr[1]))
			{
				$second = $usr[1];
				$this->db->like('apellido',$second);
			}
			if(!empty($usr[2]))
			{
				$third = $usr[2];
				$this->db->like('id_usuario',$third);
			}
			$this->db->like('nombre',$first);
			$this->db->or_like('apellido',$first);
			$this->db->or_like('id_usuario',$first);
			$this->db->or_like('sys_rol',$first);
			$this->db->or_like('id_dependencia',$first);
			$this->db->or_like('cargo',$first);
			$this->db->or_like('status',$first);
			
			return $this->db->count_all_results('dec_usuario');
		}
		return FALSE;
	}

	// public function sw_search($keyword)
 //    {
 //         $this->db->select('id, friendly_name');
 //         $this->db->from('business_category');
 //         $this->db->where('suppress', 0);
 //         $this->db->like('friendly_name', $keyword);
 //         $this->db->order_by("friendly_name", "asc");
         
 //         $query = $this->db->get();
 //         foreach($query->result_array() as $row){
 //             //$data[$row['friendly_name']];
 //             $data[] = $row;
 //         }
 //         //return $data;
 //         return $query;
 //     }

	public function ajax_likeUsers($data)
	{
		$this->db->like('nombre', $data);
		$this->db->or_like('apellido',$data);
		$this->db->or_like('id_usuario',$data);
		$query = $this->db->get('dec_usuario');
		return $query->result();
	}
///no pertenece al proyecto


}