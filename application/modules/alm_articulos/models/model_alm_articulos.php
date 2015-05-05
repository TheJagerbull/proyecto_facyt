<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_alm_articulos extends CI_Model
{
	//constructor predeterminado del modelo
	function __construct()
	{
		parent::__construct();
	}

	public function get_allArticulos($per_page='', $offset='')
	{
		$query = $this->db->get('alm_articulo', $per_page, $offset);
		return($query->result());
	}

	public function get_activeArticulos($per_page='', $offset='', $articulo='')
	{
		if(!empty($articulo))
			$this->db->like('descripcion', $articulo);
		$this->db->where('ACTIVE', '1');
		$query = $this->db->get('alm_articulo', $per_page, $offset);
		return($query->result());
	}

	public function get_articulo($articulo='')
	{

	}

	public function find_articulo($descripcion)
	{
		$this->db->like('descripcion', $descripcion);
		$query = $this->db->get('alm_articulo');
		return $query->result();
	}

	public function count_articulos()
	{
		return($this->db->count_all('alm_articulo'));
	}

	public function ajax_likeArticulos($data)
	{
		$this->db->like('descripcion', $data);
		$query = $this->db->get('alm_articulo');
		return $query->result();
	}

}