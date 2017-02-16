<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Model_rhh_periodo_no_laboral extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function obtener_periodos_no_laborales()
    {
        $sql = "SELECT a . * , b.nombre AS periodo_global_nombre
        		FROM rhh_periodo_no_laboral AS a, rhh_periodo AS b
				WHERE a.periodo = b.ID";
        $query = $this->db->query($sql);
        $periodos = $query->result_array();
        return $periodos;
    }

}

?>