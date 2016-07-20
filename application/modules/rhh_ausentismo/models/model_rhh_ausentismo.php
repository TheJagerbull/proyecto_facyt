<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Model_rhh_ausentismo extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    /* Funcion Booleana. Verifica la existencia del Tipo de Ausentismo. (por nombre) */
    public function existe_configuracion_ausentismo($data)
    {  
        $sql = $this->db->get_where(
            'rhh_configuracion_ausentismo',
            array(
                'tipo' => $data['tipo'],
                'nombre' => $data['nombre'])
            );
        $row = $this->db->query($sql);
        
        if ($row->num_rows()==1) { return TRUE; }else{ return FALSE; }
    }

    public function agregar_configuracion_ausentismo($data)
    {
        $this->db->insert('rhh_configuracion_ausentismo', $data);
    }

    /* Devuelve todos las configuraciones cargadas en la tabla */
    public function obtenerTodos()
    {
        return $this->db->get('rhh_configuracion_ausentismo')->result_array();
    }

    /* Devuelve un configuracion por su ID */
    public function obtenerUno($ID)
    {
        $data = array('ID' => $ID);
        $query = $this->db->get_where('rhh_configuracion_ausentismo', $data);
        $rows = $query->result();
        return $rows;
    }

    public function actualizar_configuracion_ausentismo($data)
    {
        $this->db->where('ID', $data['ID']);
        $this->db->update('rhh_configuracion_ausentismo', $data);
    }

    public function eliminar($ID)
    {
        $this->db->where('ID', $ID);
        $this->db->delete('rhh_configuracion_ausentismo');
    }

    /* Obtiene los ausentismos por tipo */
    public function get_ausentimos_by_tipo($tipo)
    {
        $sql = $this->db->get_where(
            'rhh_configuracion_ausentismo',
            array(
                'tipo' => $tipo
            ));
        $row = $sql->result();
        return $row;
    }
}
?>