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

    /* Agrega la asistencia del trabajador tomando en cuenta el dia actual y la cantidad de veces que ha marcado asistencia */
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
        $asistencia = $query->result();
        $row = $query->last_row('array');
        
        $cargo = $this->obtener_cargo($cedula);
        if (sizeof($cargo) == 1){
            $id_cargo = $cargo[0]['id_cargo'];
            //la cédula existe y tiene un cargo asignado
            $jornada = $this->obtener_jornada_trabajador($id_cargo);
            if (sizeof($jornada) == 1){
                //el cargo tiene una jornada de trabajo asignada
                $inicio_jornada = $jornada[0]['hora_inicio'];
                $fin_jornada = $jornada[0]['hora_fin'];
                $tolerancia_jornada = $jornada[0]['tolerancia'];
            }
        }
        $hr_ini_jornada = new DateTime($inicio_jornada);
        $hr_fin_jornada = new DateTime($fin_jornada);

        //echo 'Son las: '.$hora_actual->format('h:i:s a').'<br>';
        //echo 'Su jornada comienza a las '.$hr_ini_jornada->format('h:i a').' y termina a las '.$hr_fin_jornada->format('h:i a').' y usted dispone de '.$tolerancia_jornada.'hrs para llegar tarde <br>';
        
        //echo 'Son las '.$hora_actual->format('h:i:s a').'<br>';
        //echo 'Usted entra a las '.$hr_ini_jornada->format('h:i:s a').'<br>';
        //echo 'Usted sale a las '.$hr_fin_jornada->format('h:i:s a').'<br>';

        if (sizeof($asistencia) == 0) {
            $data = array(
                'hora_entrada' => $hora_actual->format('H:i:s'),
                'fecha_inicio_semana' => $inicio_semana,
                'fecha_fin_semana' => $fin_semana,
                'id_trabajador' => $cedula,
                'dia' => date('Y-m-d'));
            $this->db->insert('rhh_asistencia', $data);
            
            //echo_pre($this->db->insert_id(), __LINE__, __FILE__);
        }else{
            $aux = array('hora_salida' => $hora_actual->format('H:i:s'));
            $this->db->where('ID',$row['ID']);
            $this->db->where('dia',date('Y-m-d'));
            $this->db->update('rhh_asistencia', $aux);
        }

        $diff  = $hr_ini_jornada->diff($hora_actual);
        $diff_hrs = $diff->format('%H');
        $diff_min = $diff->format('%I');

        if ($hr_ini_jornada > $hora_actual) {
            $mensaje = "Esta llegando ".$diff->format('%H hr y %I min').' antes de la hora<br>';
        }else{
            if ($tolerancia_jornada > $diff_hrs) {
                $mensaje = "Esta llegando ".$diff->format('%H hr y %I min')." tarde, pero dentro de la tolerancia (".$tolerancia_jornada."hrs) permitida.<br>";
            }else{
                //verificar si se alacena como entrada o salida, calculando el tiempo medio entre las horas de trabajo
                $mitad_jornada = $hr_ini_jornada->diff($hr_fin_jornada);
                //$mitad_jornada_hrs = ($mitad_jornada->format('%H'))/2;
                //$mitad_jornada_min = ($mitad_jornada->format('%I'))/2;

                //echo 'Sus horas de trabajo son: '.$mitad_jornada->format('%Hhrs y %Imin').' [sin tomar encuenta el tiempo de descanso]<br>';

                //echo 'La mitad de su jornada laboral tiene '.$mitad_jornada_hrs.'hrs y '.$mitad_jornada_min.'min.<br>';

                //agregar una nota con:
                if (sizeof($asistencia) == 0) {
                    $mensaje = "Esta llegando ".$diff->format('%H hr y %I min')." tarde, superando el tiempo de tolerancia (".$tolerancia_jornada."hrs) permitida. Se ha generado una nota para que pueda justificar su retraso.<br>";
                
                    $nota = array(
                        'cuerpo_nota' => '',
                        'id_asistencia' => $this->db->insert_id(),
                        'tiempo_retraso' => $diff->format('%H hr y %I min'),
                        'fecha' => date('Y-m-d')
                    );
                    $this->db->insert('rhh_nota', $nota);
                }

                //if ($diff_hrs >= $mitad_jornada_hrs) { echo "Ustede llego despues de la mitad de su jornada laboral. Esta entrada seŕa almacenada como una salida."; }
            }
        }

        return $mensaje;
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
            $this->db->select('*, rhh_cargo.nombre AS nombre_cargo, rhh_jornada_laboral.ID AS ID ');
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