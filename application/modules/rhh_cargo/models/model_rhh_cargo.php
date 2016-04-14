<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Model_rhh_cargo extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    /* Devuelve todos las configuraciones cargadas en la tabla */
    public function obtenerTodos()
    {
        return $this->db->get('rhh_cargo')->result_array();
    }

    public function obtener_cargo($id)
    {
    	$data = array('ID' => $id);
    	$query = $this->db->get_where('rhh_cargo', $data);
        return $query->result();
    }
}

?>