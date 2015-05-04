<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_alm_articulos extends CI_Model
{
	//constructor predeterminado del modelo
	function __construct()
	{
		parent::__construct();
	}

	public function get_allArticulos()
	{
		$query = $this->db->get('alm_articulo');
		return($query->result());
	}

	public function get_articulo($articulo='')
	{

	}

}