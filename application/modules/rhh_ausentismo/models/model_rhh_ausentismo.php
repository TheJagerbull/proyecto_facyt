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

    /* Agrega a la base de datos un tipo nuevo de configuracion de ausentismo*/
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

    /* Elimina un tipo de configuracion de ausentismo */
    public function eliminar($ID)
    {
        $this->db->where('ID', $ID);
        $this->db->delete('rhh_configuracion_ausentismo');
    }

    /* Obtiene los ausentismos por tipo (PERMISO, REPOSO) */
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

    /* PARA MANEJAR LAS SOLICITUDES DE AUSENTISMOS */

    /* Agregar una solicitud de ausentismo, discriminando por tipo (PERMISO, REPOSO) */
    public function agregar_solicitud_ausentismo(array $ausentismo, $tipo)
    {
        if ($tipo == 'PERMISO') {
            // echo_pre($ausentismo); die();
            $this->db->insert('rhh_ausentismo_permiso', $ausentismo);
        }elseif ($tipo == 'REPOSO') {
            $this->db->insert('rhh_ausentismo_reposo', $ausentismo);
        }
    }

    // Obtiene los Reposos y los Permisos de un usuario
    public function obtener_mis_ausentismos($id_trabajador)
    {
        $sql_permiso = $this->db->get_where('rhh_ausentismo_permiso', array('id_trabajador' => $id_trabajador));
        $result_permiso = $sql_permiso->result();
   
        $sql_reposo = $this->db->get_where('rhh_ausentismo_reposo', array('id_trabajador' => $id_trabajador));
        $result_reposo = $sql_reposo->result();

        $result = array(
            "permisos" => $result_permiso,
            "reposos" => $result_reposo);

        return $result;
    }

    public function obtener_uno_solicitado($ID)
    {
        $data = array('ID' => $ID);
        $query = $this->db->get_where('rhh_configuracion_ausentismo', $data);
        $rows = $query->result();
        return $rows;
    }

    /* Elimina un ausentismo solicitado por un usuario */
    public function eliminar_ausentismo_solicitado($ID_ausentismo_solicitado, $tipo)
    {
        if ($tipo == 'PERMISO') {
            $this->db->where('ID', $ID_ausentismo_solicitado);
            $this->db->delete('rhh_ausentismo_permiso');
        }elseif ($tipo == 'REPOSO') {
            $this->db->where('ID', $ID_ausentismo_solicitado);
            $this->db->delete('rhh_ausentismo_reposo');
        }
    }
}
?>