<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Model_rhh_asistencia extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    /*
        Funcion Booleana. Verifica la existencia de la cédula.
    */
    public function existe_cedula($cedula)
    {  
        $sql = "SELECT * FROM dec_usuario WHERE id_usuario='".$cedula."'";
        $row = $this->db->query($sql);
        
        if ($row->num_rows()==1) { return TRUE; }else{ return FALSE; }
    }

    /*
        Devuelve la información de un usuario
    */
    public function obtener_persona($cedula){
        $sql = "SELECT * FROM dec_usuario WHERE id_usuario='".$cedula."'";
        $query = $this->db->query($sql);
        $persona_array = $query->result();

        foreach ($persona_array as $p) {
            $persona = $p;
        }

        return $persona;
    }

    /*
        Funcion que calcula el inicio de una semana dado un dia contendio entre esa semana
    */
    public function rangoSemana($datestr) {
        date_default_timezone_set(date_default_timezone_get());
        $dt = strtotime($datestr);
        $res['inicio'] = date('N', $dt)==1 ? date('Y-m-d', $dt) : date('Y-m-d', strtotime('last monday', $dt));
        $res['fin'] = date('N', $dt)==7 ? date('Y-m-d', $dt) : date('Y-m-d', strtotime('next sunday', $dt));
        return $res;
    }

    /*
        Agrega la asistencia del trabajador tomando en cuenta el dia actual y la cantidad de veces que ha marcado asistencia
    */
    public function agregar_asistencia($cedula){
        $semana = $this->rangoSemana(date('Y-m-d'));

        $horaActual = date('H:i:s');
        $inicioSemana = $semana['inicio'];
        $finSemana = $semana['fin'];

        $query = $this->db->get('rhh_asistencia');
        $row = $query->last_row('array');
        
        if (isset($row['hora_salida']) && $row['hora_salida'] == '00:00:00') {
            /*Busco la última entrada del usuario del día actual y actualizo la salida */
            $aux = array('hora_salida' => $horaActual );
            $this->db->where('ID',$row['ID']);
            $this->db->where('dia',date('Y-m-d'));
            $this->db->update('rhh_asistencia', $aux);
        }else{
            /*Poblando para la insercion*/
            $data = array(
                'hora_entrada' => $horaActual,
                'fecha_inicio_semana' => $inicioSemana,
                'fecha_fin_semana' => $finSemana,
                'id_trabajador' => $cedula,
                'dia' => date('Y-m-d'));
            /*Insercion*/
            $this->db->insert('rhh_asistencia', $data);
        }
    }

    /*
        Devuelve los registros asociados a la asistencia de un trabajador del dia actual
    */
    public function obtener_asistencia_del_dia($cedula){
        $hoy = date('Y-m-d');
        $data = array(
            'dia' => $hoy,
            'id_trabajador' => $cedula
        );
        $query = $this->db->get_where('rhh_asistencia', $data);
        $rows = $query->result();
        return $rows;
    }
}

?>