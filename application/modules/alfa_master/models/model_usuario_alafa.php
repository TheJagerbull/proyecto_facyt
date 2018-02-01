<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_dec_usuario extends CI_Model
{
	//constructor predeterminado del modelo
	function __construct()
	{
		parent::__construct();
	}
	
	//verifica la cedula del usuario entrando desde alfa, y en case de que exista, devuelve todos los datos del usuario
	public function existe_ced($cedula)
	{
		/*$data = array
		(
			'id_usuario' => $post['id'],
			'password' => $post['password']
		);*/
		$query = $this->db->get_where('dec_usuario',$cedula);
		if($query->num_rows() == 1)
		{
			return TRUE;
			//$query->row();
		}
		else
		{
			return FALSE;
		}
	}

		//verifica la cedula del usuario entrando desde alfa, y en case de que exista, devuelve todos los datos del usuario
	public function existe_user($usermane)
	{
		/*$data = array
		(
			'id_usuario' => $post['id'],
			'password' => $post['password']
		);*/
		$query = $this->db->get_where('dec_usuario',$username);
		if($query->num_rows() == 1)
		{
			return TRUE;
			//$query->row();
		}
		else
		{
			return FALSE;
		}
	}

}