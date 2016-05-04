<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Model_rhh_asistencia extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    /* Funcion Booleana. Verifica la existencia de la cédula. */
    public function existe_cedula($cedula)
    {  
        $sql = "SELECT * FROM dec_usuario WHERE id_usuario='".$cedula."'";
        $row = $this->db->query($sql);
        if ($row->num_rows()==1) { return TRUE; }else{ return FALSE; }
    }

    /* Devuelve la información de un usuario */
    public function obtener_persona($cedula){
        $sql = "SELECT * FROM dec_usuario WHERE id_usuario='".$cedula."'";
        $query = $this->db->query($sql);
        $persona_array = $query->result();

        foreach ($persona_array as $p) { $persona = $p; }
        return $persona;
    }

    /* Funcion que calcula el inicio de una semana dado un dia contendio entre esa semana */
    public function rangoSemana($datestr) {
        date_default_timezone_set(date_default_timezone_get());
        $dt = strtotime($datestr);
        $res['inicio'] = date('N', $dt)==1 ? date('Y-m-d', $dt) : date('Y-m-d', strtotime('last monday', $dt));
        $res['fin'] = date('N', $dt)==7 ? date('Y-m-d', $dt) : date('Y-m-d', strtotime('next sunday', $dt));
        return $res;
    }

    /* Para obtener cargo de la tabla de rhh_trabajador_cargo */
    public function obtener_cargo($cedula)
    {  
        $sql = "SELECT * FROM rhh_trabajador_cargo WHERE id_trabajador='".$cedula."'";
        $row = $this->db->query($sql);
        return $row->result_array();
    }

    public function obtener_jornada_trabajador($cargo)
    {
        $sql = "SELECT * FROM rhh_jornada_laboral WHERE id_cargo='".$cargo."'";
        $row = $this->db->query($sql);
        return $row->result_array();
    }

    /*
        Agrega la asistencia del trabajador tomando en cuenta el dia actual y la cantidad de veces que ha marcado asistencia
    */
    public function agregar_asistencia($cedula){
        $semana = $this->rangoSemana(date('Y-m-d'));

        date_default_timezone_set('America/Caracas');
        $hora_actual = new DateTime('NOW');
        $inicio_semana = $semana['inicio'];
        $fin_semana = $semana['fin'];

        $this->db->order_by("ID", "asc"); 
        $this->db->where('id_trabajador', $cedula);
        $this->db->where('dia', date('Y-m-d'));
        $query = $this->db->get('rhh_asistencia');
        $row = $query->last_row('array');

        /* obtengo las asistencias del día
            hasta este punto la cedula del trabajador ya está verificada
                Verificar si es entrada o salida dependiendo si entró tarde, validar contra la tolerancia que se le dio a la jornada.
                    Primero obtener jornada
                    de la jornada obtener la tolerancia
        */
        
        $persona = $this->obtener_cargo($cedula);
        if (sizeof($persona) == 1){
            $cargo = $persona[0]['id_cargo'];
            $jornada = $this->obtener_jornada_trabajador($cargo);
            if (sizeof($jornada) == 1){
                $inicio_jornada = $jornada[0]['hora_inicio'];
                $fin_jornada = $jornada[0]['hora_fin'];
                $tolerancia_jornada = $jornada[0]['tolerancia'];
            }
        }
        $hr_ini_jornada = new DateTime($inicio_jornada);
        $hr_fin_jornada = new DateTime($fin_jornada);

        echo 'Son las: '.$hora_actual->format('h:i:s a').'<br>';
        echo 'Su jornada comienza a las: '.$inicio_jornada.'; termina a las: '.$fin_jornada.' y usted dispone de '.$tolerancia_jornada.'hrs para llegar tarde <br>';
        echo 'Calculos: <br>';
        echo 'Son las '.$hora_actual->format('h:i:s a').'<br>';
        echo 'Usted entra a las '.$hr_ini_jornada->format('h:i:s a').'<br>';
        echo 'Usted sale a las '.$hr_fin_jornada->format('h:i:s a').'<br>';

        $diff  = $hr_ini_jornada->diff($hora_actual);
        $diff_hrs = $diff->format('%H');

        if ($hr_ini_jornada > $hora_actual) {
            echo "Esta llegando ".$diff->format('%H hr y %I min').' antes de la hora<br>';
        }else{
            if ($tolerancia_jornada > $diff_hrs) {
                echo "Esta llegando ".$diff->format('%H hr y %I min')." tarde, pero dentro de la tolerancia (".$tolerancia_jornada.") permitida.<br>";
                //Aqui se puede considerar como una entrada.
            }else{
                echo "Esta llegando ".$diff->format('%H hr y %I min')." tarde, pero dentro de la tolerancia (".$tolerancia_jornada.") permitida.<br>";
            }
        }
        
        /*if (isset($row['hora_salida']) && $row['hora_salida'] == '00:00:00') {
            // Busco la última entrada del usuario del día actual y actualizo la salida
            $aux = array('hora_salida' => $hora_actual);
            $this->db->where('ID',$row['ID']);
            $this->db->where('dia',date('Y-m-d'));
            $this->db->update('rhh_asistencia', $aux);
        }else{
            // Poblando para la insercion
            $data = array(
                'hora_entrada' => $hora_actual,
                'fecha_inicio_semana' => $inicio_semana,
                'fecha_fin_semana' => $fin_semana,
                'id_trabajador' => $cedula,
                'dia' => date('Y-m-d'));
            // Insercion
            $this->db->insert('rhh_asistencia', $data);
        }*/
    }

    /* Devuelve los registros asociados a la asistencia de un trabajador del dia actua */
    public function obtener_asistencia_del_dia($cedula){
        $hoy = date('Y-m-d');
        $data = array(
            'dia' => $hoy,
            'id_trabajador' => $cedula
        );
        $query = $this->db->get_where('rhh_asistencia', $data);
        return $query->result();
    }

    /* Agregar Configuración */
    public function guardar_configuracion($id,$cantidad)
    {
        $data = array(
            'ID' => $id,
            'minimo_horas_ausentes_sem' => $cantidad);

        $this->db->where('ID', $id);
        $this->db->update('rhh_configuracion_asistencia', $data);
    }

    /* Obtener configuraciones agregadas */
    public function obtener_configuracion()
    {
        $query = $this->db->get('rhh_configuracion_asistencia');
        return $query->result();
    }

    /* Obtener lista de jornadas ingresadas en la base de datos */
    public function obtener_jornadas()
    {
        // si jornada es al menos 1 y cargo es al menos 1
        $jornadas = $this->db->get('rhh_jornada_laboral');
        $jornadas = $jornadas->result();
        $cargos = $this->db->get('rhh_cargo');
        $cargos = $cargos->result();

        if (sizeof($jornadas) > 0 && sizeof($cargos) > 0) {
            $this->db->select('*, rhh_cargo.nombre AS nombre_cargo, rhh_jornada_laboral.nombre AS nombre_jornada, rhh_jornada_laboral.ID AS ID ');
            $this->db->join('rhh_cargo','rhh_cargo.ID=rhh_jornada_laboral.id_cargo', 'left');
            $query = $this->db->get('rhh_jornada_laboral');
            return $query->result();
        }else{
            return [];
        }
    }

    /* Obtener una jornada, dado su ID */
    public function obtener_jornada($id)
    {
    	$data = array('ID' => $id);
    	$query = $this->db->get_where('rhh_jornada_laboral', $data);
        return $query->result();
    }

}
?>