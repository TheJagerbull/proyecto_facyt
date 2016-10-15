<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Model_rhh_periodo extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function obtener_periodos_asociados($ID)
    {
    	$sql = "SELECT * FROM rhh_periodo_no_laboral as p WHERE p.periodo =".$ID;
    	$query = $this->db->query($sql);
        $p_n_laboral = $query->result_array();
        return $p_n_laboral;
    }

}

?>