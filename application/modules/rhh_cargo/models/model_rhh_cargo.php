<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Model_rhh_cargo extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function obtener_cargo($id)
    {
    	$data = array('ID' => $id);
    	$query = $this->db->get_where('rhh_cargo', $data);
        return $query->result();
    }

    public function existe($codigo)
    {
        $sql = "SELECT * FROM rhh_cargo WHERE codigo = '".$codigo."'";
        $query = $this->db->query($sql);
        $rows = $query->result();
        if (sizeof($rows) > 0 ){ return true; }else{ return false; }
    }
}

?>