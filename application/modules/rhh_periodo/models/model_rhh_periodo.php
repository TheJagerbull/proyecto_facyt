<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Model_rhh_periodo extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function obtener_periodo($id)
    {
    	$data = array('ID' => $id);
    	$query = $this->db->get_where('rhh_periodo_no_laboral', $data);
        return $query->result();
    }

}

?>