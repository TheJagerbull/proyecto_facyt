<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Model_rhh_funciones extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    /* Recibe el nombre de una tabla los datos y decide si almacenar o actualizar el elemento */
    public function guardar($tabla, $data)
    {
        /* Diferenciar entre si data tiene el atributo ID */
        /* La diferenciación se utiliza para guardar o actualizar elementos */
        if (array_key_exists('ID', $data)) {
            $this->db->where('ID', $data['ID']);
            $this->db->update($tabla, $data);
        }else{
            $this->db->insert($tabla, $data);
        }
    }

    /* Recibe la tabla donde se buscará el elemento ID a eliminar */
    public function eliminar($tabla, $ID)
    {
        $this->db->where('ID', $ID);
        $this->db->delete($tabla);
    }

    /* Para buscar posibles claves foraneas duplicadas */
    public function existe_como($tabla, $columna, $id, $este = NULL)
    {
        if($este != NULL)
            $sql = "SELECT * FROM ".$tabla." WHERE ".$columna."='".$id."' AND ID!='".$este."'";
        else
            $sql = "SELECT * FROM ".$tabla." WHERE ".$columna."='".$id."'";
        
        $row = $this->db->query($sql);
        if ($row->num_rows() == 1) { return TRUE; }else{ return FALSE; }
    }

    /*Dado el nombre de la tabla y un ID devuelve el elemento*/
    public function obtener_uno($tabla, $id)
    {
        $data = array('ID' => $id);
        $query = $this->db->get_where($tabla, $data);
        $result = $query->row_array();
        return $result;
    }

    /* Devuelve todos los elementos de la tabla */
    public function obtener_todos($tabla)
    {
        return $this->db->get($tabla)->result_array();
    }

}
?>