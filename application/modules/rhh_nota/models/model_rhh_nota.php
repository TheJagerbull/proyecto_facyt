<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Model_rhh_nota extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function obtener_todas_notas()
    {
        $sql = "
        SELECT n.ID AS 'idnota', u.ID AS 'idusuario', n.cuerpo_nota, n.tipo, n.id_trabajador, n.id_asistencia, n.tiempo_retraso, n.fecha, u.nombre, u.apellido
        FROM rhh_nota AS n, dec_usuario AS u
        WHERE u.id_usuario = n.id_trabajador";
        $row = $this->db->query($sql);
        return $row->result_array();
    }
}
?>