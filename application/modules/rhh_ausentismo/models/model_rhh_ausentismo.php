<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Model_rhh_ausentismo extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    /*
        Funcion Booleana. Verifica la existencia del Tipo de Ausentismo. (por nombre)
    */
    public function existe_configuracion_ausentismo($data)
    {  
        $sql = "SELECT * FROM rhh_configuracion_ausentismo WHERE tipo='".$data['tipo']."' AND nombre='".$data['nombre']."';";
        $row = $this->db->query($sql);
        
        if ($row->num_rows()==1) { return TRUE; }else{ return FALSE; }
    }

    public function agregar_configuracion_ausentismo($data)
    {
        $this->db->insert('rhh_configuracion_ausentismo', $data);
    }

    public function obtenerTodos()
    {
        $query = $this->db->get('rhh_configuracion_ausentismo');
        return $query->result();
    }
}

?>