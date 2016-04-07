<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Model_rhh_cargos extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    /*
        Obtener lista de cargos disponibles
    */
    public function obtener_cargos()
    {
        $query = $this->db->get('rhh_cargo');
        return $query->result();
    }
}

?>