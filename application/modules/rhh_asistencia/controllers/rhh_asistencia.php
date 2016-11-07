<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rhh_asistencia extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->module('dec_permiso/dec_permiso');
        $this->load->model('model_rhh_asistencia'); /*Para procesar los datos en la BD */
        $this->load->model('model_rhh_funciones'); /*Para procesar los datos en la BD */
    }

    public function vista()
    {
        $header = $this->dec_permiso->load_permissionsView();
        $header["title"]='Control de Asistencia';
        $this->load->view('template/header', $header);
        $this->load->view('vista');
        $this->load->view('template/footer');
    }
    
    /* Carga elementos para efectos demostrativos */
    public function index()
    {
        is_user_authenticated();
        $header = $this->dec_permiso->load_permissionsView();
        $header["title"]='Control de Asistencia';
        
        $this->load->view('template/header', $header);
        $this->load->view('inicio');
        $this->load->view('template/footer');
    }

    /* Vista: Agregar Asistencia*/
    public function agregar()
    {
        $header = $this->dec_permiso->load_permissionsView();
        $header["title"]='Control de Asistencia - Agregar';
        $this->load->view('rhh_asistencia/rhh_header', $header);
        $this->load->view('agregar');
        $this->load->view('rhh_asistencia/rhh_footer');
    }

    public function agregado()
    {
        $cedula = $this->session->flashdata('cedula');
        if ($cedula == null) {
            redirect('asistencia/agregar');
        }
        $persona = $this->model_rhh_asistencia->obtener_persona($cedula);
        $asistencias = $this->model_rhh_asistencia->obtener_asistencia_del_dia($cedula);

        $header = $this->dec_permiso->load_permissionsView();
        $header["title"]='Control de Asistencia - Agregar';

        $this->load->view('rhh_asistencia/rhh_header', $header);
        $this->load->view('agregado',
            array(
                'persona' => $persona,
                'asistencias' => $asistencias,
            )
        );
        $this->load->view('rhh_asistencia/rhh_footer');
    }

    #Pre: Verificar que el trabajador existe
    public function verificar()
    {
        $cedula = $this->input->post('cedula');
        $resultado = '';
        $semana = $this->model_rhh_asistencia->rangoSemana(date('Y-m-d'));

        date_default_timezone_set('America/Caracas');
        $hora_actual = new DateTime('NOW');
        $inicio_semana = $semana['inicio'];
        $fin_semana = $semana['fin'];

        if ($this->model_rhh_asistencia->existe_cedula($cedula)) {
            if ($this->model_rhh_asistencia->is_usuario_activo($cedula)) {
                //Verificar cargo
                $cargo = $this->model_rhh_asistencia->obtener_cargo($cedula);
                if (sizeof($cargo) == 0) {
                    set_message('danger', "La cédula <b>".$cedula."</b> está registrada pero no tiene cargo asociado.");
                    redirect('asistencia/agregar');
                }else{

                    $id_cargo = $cargo[0]['id_cargo'];
                    //la cédula existe y tiene un cargo asignado
                    $jornada = $this->model_rhh_asistencia->obtener_jornada_trabajador($id_cargo);
                    if (sizeof($jornada) == 0){
                        set_message('danger','Usted no tiene jornada de trabajo asignada.');
                        redirect('asistencia/agregar');
                    }else{
                        //el cargo tiene una jornada de trabajo asignada
                        $inicio_jornada = $jornada[0]['hora_inicio'];
                        $fin_jornada = $jornada[0]['hora_fin'];
                        $tolerancia_jornada = $jornada[0]['tolerancia'];
                        $dias_jornada = $jornada[0]['dias_jornada'];

                        $hr_ini_jornada = new DateTime($inicio_jornada);
                        $hr_fin_jornada = new DateTime($fin_jornada);

                        //calcular la duracion de la jornada
                        $hr_duracion_jornada = $hr_ini_jornada->diff($hr_fin_jornada);
                        // echo 'Su jornada dura: '.$hr_duracion_jornada->format('%H').' horas y '.$hr_duracion_jornada->format('%I').' minutos';

                        if ($inicio_jornada > $fin_jornada) {
                            /* $mensaje = $mensaje." "."Su jornada comienza un día y termina al siguiente.<br>"; */
                        }

                        $vector = unserialize($dias_jornada);
                        if (in_array($hora_actual->format('w'), $vector)) {
                        //$mensaje = $mensaje.' '."SEGUN SU JORNADA DE TRABAJO HOY DEBE LABORAR.<br>";
                        //echo 'Son las: '.$hora_actual->format('h:i:s a').'<br>';
                        //echo 'Su jornada comienza a las '.$hr_ini_jornada->format('h:i a').' y termina a las '.$hr_fin_jornada->format('h:i a').' y usted dispone de '.$tolerancia_jornada.'hrs para llegar tarde <br>';

                        //echo 'Son las '.$hora_actual->format('h:i:s a').'<br>';
                        //echo 'Usted entra a las '.$hr_ini_jornada->format('h:i:s a').'<br>';
                        //echo 'Usted sale a las '.$hr_fin_jornada->format('h:i:s a').'<br>';
                            $asistencia = $this->model_rhh_asistencia->obtener_asistencia_del_dia($cedula);
                            if ($this->model_rhh_asistencia->es_entrada($cedula)) {
                                //es entrada
                                $data = array(
                                    'hora_entrada' => $hora_actual->format('H:i:s'),
                                    'hora_salida' => '00:00:00', //solo si no esta por defecto en la bd
                                    'fecha_inicio_semana' => $inicio_semana,
                                    'fecha_fin_semana' => $fin_semana,
                                    'id_trabajador' => $cedula,
                                    'dia' => date('Y-m-d'));

                                $this->db->insert('rhh_asistencia', $data);
                                
                                $diff  = $hr_ini_jornada->diff($hora_actual);
                                $diff_hrs = $diff->format('%H');
                                $diff_min = $diff->format('%I');

                                if ($hr_ini_jornada > $hora_actual) {
                                    $resultado = $resultado.' '."Está llegando ".$diff->format('%H hr y %I min').' antes de la hora<br>';
                                }else{
                                    if ($tolerancia_jornada > $diff_hrs) {
                                        //tarde pero no tanto
                                        $resultado = $resultado.' '."Esta llegando ".$diff->format('%H hr y %I min')." tarde, pero dentro de la tolerancia (".$tolerancia_jornada."hrs) permitida.<br>";
                                    }else{
                                        //tarde pero mas de lo permitido
                                        $mitad_jornada = $hr_ini_jornada->diff($hr_fin_jornada);
                                        $resultado = $resultado.' '."Está llegando ".$diff->format('%H hr y %I min')." tarde, superando el tiempo de tolerancia (".$tolerancia_jornada."hrs) permitida. Se ha generado una nota para que pueda justificar su retraso.<br>";

                                        $nota = array(
                                            'tipo' => 'Entrada',
                                            'cuerpo_nota' => '',
                                            'id_trabajador' => $cedula,
                                            'id_asistencia' => $this->db->insert_id(),
                                            'tiempo_retraso' => $diff->format('%H hr y %I min'),
                                            'fecha' => date('Y-m-d')
                                        );
                                        
                                        $this->db->insert('rhh_nota', $nota);
                                            
                                        //if ($diff_hrs >= $mitad_jornada_hrs) { echo "Ustede llego despues de la mitad de su jornada laboral. Esta entrada seŕa almacenada como una salida."; }

                                    }//llego con retraso
                                }// calculando la hora de entrada
                            }else{
                                //es salida
                                //ya marcó salida y no puede volver hacerlo
                                
                                if($asistencia[0]->hora_salida != '00:00:00') {
                                    $time = new DateTime($asistencia[0]->hora_salida);
                                    // $resultado = $resultado.' '."Se ha actualizado la hora de salida del día de hoy.<br>";
                                    set_message('danger',"Ya ha marcado salida a las ".$time->format('h:i a').", no puede actualizar esta hora.");
                                    redirect('asistencia/agregar');
                                }else{
                                    // no ha marcado salida
                                        //verificar si está cumpliendo con el tiempo necesario
                                        //calculando el tiempo que duro su trabajo

                                    $diff_salida = $hora_actual->diff($hr_fin_jornada);
                                    
                                    $hora_entrada = new DateTime($asistencia[0]->hora_entrada);
                                    $tiempo_trabajado = $hora_entrada->diff($hora_actual);

                                    // echo "<pre>";
                                    // echo '$diff_salida es en '.$diff_salida->format('%H horas con %I min');
                                    // echo '<br>$tiempo_trabajado es: '.$tiempo_trabajado->format('%H horas con %I minutos');
                                    // echo '<br>$hora_duracion_jornada es '.$hr_duracion_jornada->format('%H horas con %I minutos');

                                    if ($tiempo_trabajado->format('%H') >= $hr_duracion_jornada->format('%H')) {
                                        // echo "<br>Usted ha laborado mas o igual tiempo contemplado en su jornada";

                                        $aux = array('hora_salida' => $hora_actual->format('H:i:s'));
                                        $this->db->where('ID',$asistencia[0]->ID);
                                        $this->db->where('dia',date('Y-m-d'));
                                        $this->db->update('rhh_asistencia', $aux);

                                        set_message('success','Se ha actualizado la hora de salida, usted cumplió con las horas establecidas en la jornada laboral.');
                                        $this->session->set_flashdata("cedula", $cedula);
                                        redirect('asistencia/agregado');

                                    }else{
                                        if ($hora_actual > $hr_fin_jornada){
                                            // echo "Se está yendo despues de su hora de salida. <br>";
                                            $aux = array('hora_salida' => $hora_actual->format('H:i:s'));
                                            $this->db->where('ID',$asistencia[0]->ID);
                                            $this->db->where('dia',date('Y-m-d'));
                                            $this->db->update('rhh_asistencia', $aux);

                                        }else{
                                            // AQUI DEBE NOTIFICAR QUE SE ESTÁ YENDO ANTES DE LA HORA DE SALIDA QUE SI REALMENTE DESEA MARCARLA
                                            set_message('info', "<h3>Se está yendo ".$diff_salida->format('%H hrs y %I min')." antes de su hora de salida</h3>");
                                            $this->session->set_flashdata("cedula", $cedula);
                                            $this->session->set_flashdata("id_asistencia", $asistencia[0]->ID);
                                            $this->session->set_flashdata("retraso", $diff_salida->format('%H hr y %I min'));
                                            $this->session->set_flashdata("hora_salida", $hora_actual->format('H:i:s'));
                                            //redirijo a la vista donde le indico que se está yendo antes
                                            redirect('asistencia/salida');
                                        }
                                    }
                                }
                                // echo 'Usted sale a las '.$hr_fin_jornada->format('h:i:s a').'<br>';
                                // echo 'Diferencia de la salida '.$diff_salida->format('%H:%I').'<br>';
                            }//fin es_entrada

                            set_message('success', $resultado);
                            $this->session->set_flashdata("cedula", $cedula);
                            redirect('asistencia/agregado');
                        }else{
                            set_message('danger','Según su jornada laboral usted no debe laborar hoy, la entrada no séra guardada.');
                            redirect('asistencia/agregar');
                        }//fin le toca laborar hoy
                    }//fin cargo tiene jornada
                }//fin verificar cargo
            }else{
                set_message('danger','El usuario se encuentra inactivo en el sistema, no se puede guardar la asistencia');
                redirect('asistencia/agregar');
            }
        }else{
            set_message('danger',"La cédula <b>".$cedula."</b> que ha ingresado no se encuentra en nuestros registros.");
            redirect('asistencia/agregar');
        }
    }

    public function salir_antes()
    {
        $header = $this->dec_permiso->load_permissionsView();
        $header["title"]='Control de Asistencia';
        $this->load->view('rhh_asistencia/rhh_header', $header);
        $this->load->view('salir_antes');
        $this->load->view('rhh_asistencia/rhh_footer');
    }

    public function salir_antes_guardar()
    {
        //obtengo los datos del formulario;
        $post = $this->input->post();

        $aux = array('hora_salida' => $post['hora_salida']);
        $this->db->where('ID',$post['id_asistencia']);
        $this->db->where('dia',date('Y-m-d'));
        $this->db->update('rhh_asistencia', $aux);
        $nota = array(
            'tipo' => 'Salida',
            'cuerpo_nota' => '',
            'id_trabajador' => $post['cedula'],
            'id_asistencia' => $post['id_asistencia'],
            'tiempo_retraso' => $post['retraso'],
            'fecha' => date('Y-m-d')
        );
        $this->db->insert('rhh_nota', $nota);
        set_message('success', "Se ha almacenado la hora de salida de forma exitosa, además se generó una nota de salida");
        $this->session->set_flashdata("cedula", $post['cedula']);
        redirect('asistencia/agregado');
    }

    #Pos: Devolver la información recien almacenada
    /* Tiene las condifuraciones que controlan las Asistencias
        Ej. Cantidad de Min_Hrs_Falta_Semanal
        Mostrará las configuraciones existentes
    */
    public function configuracion()
    {
        if($this->session->userdata('user') == NULL){ redirect('error_acceso'); }

        $configuraciones = $this->model_rhh_asistencia->obtener_configuracion();
        $header = $this->dec_permiso->load_permissionsView();
        $header["title"]='Control de Asistencia - Configuraciones';

        $this->load->view('template/header', $header);
        $this->load->view('configuracion', array(
            'configuraciones' => $configuraciones));
        $this->load->view('template/footer');
    }

    /*
    public function configuracion_agregar()
    {
        $data["title"]='Control de Asistencia - Configuraciones - Agregar';
        //$header = $this->dec_permiso->load_permissionsView();
        $this->load->view('template/header', $data);
        $this->load->view('configuracion_agregar');
        $this->load->view('template/footer');
    }*/

    public function verificar_configuracion()
    {
        if($this->session->userdata('user') == NULL){ redirect('error_acceso'); }
        $header = $this->dec_permiso->load_permissionsView();
        /*Guardar en la base de datos lo que está mal*/
        $cantidad = $this->input->post('cantidad');
        $id = $this->input->post('id');

        if ($cantidad > 0) {
            $this->model_rhh_asistencia->guardar_configuracion($id, $cantidad);

            set_message('success','Se ha agregado la configuración de forma correcta.');
            $configuraciones = $this->model_rhh_asistencia->obtener_configuracion();

            $header["title"]='Control de Asistencia - Configuraciones';
            //$header = $this->dec_permiso->load_permissionsView();
            /*$this->load->view('template/header', $header);
            $this->load->view('configuracion',array(
                'configuraciones' => $configuraciones));
            $this->load->view('template/footer');*/
            redirect('asistencia/configuracion');
        }else{
            set_message('danger','La cantidad de horas debe ser mayor a 0.');            
            $header["title"]='Control de Asistencia - Configuraciones - Agregar';
            //$header = $this->dec_permiso->load_permissionsView();
            $this->load->view('template/header', $header);
            $this->load->view('configuracion_agregar', array(
                'cantidad' => $cantidad));
            $this->load->view('template/footer');
        }
    }

    /* Modificar una entrada de la tabla de configuraciones de asistencia */
    public function modificar_configuracion($id, $cantidad)
    {
        if($this->session->userdata('user') == NULL){ redirect('error_acceso'); }
        $header = $this->dec_permiso->load_permissionsView();
        $header["title"]='Control de Asistencia - Configuraciones - Agregar';

        $this->load->view('template/header', $header);
        $this->load->view('configuracion_agregar', array(
            'cantidad' => $cantidad,
            'id' => $id));
        $this->load->view('template/footer');
    }


    /* Devuelve la lista de jornadas de la BD */
    public function jornada()
    {
        if($this->session->userdata('user') == NULL){ redirect('error_acceso'); }
        $jornadas = $this->model_rhh_asistencia->obtener_jornadas();
        $header = $this->dec_permiso->load_permissionsView();
        $header["title"]='Control de Asistencia - Jornadas - Lista';

        $this->load->view('template/header', $header);
        $this->load->view('jornada', array(
            'jornadas' => $jornadas));
        $this->load->view('template/footer');
    }

    /*
        Carga la vista(formulario) para 
            - agregar una jornada
            - modificar una jornada
    */
    public function nueva_jornada($jornada = null, $action = 'jornada/agregar')
    {
        if($this->session->userdata('user') == NULL){ redirect('error_acceso'); }
        $header = $this->dec_permiso->load_permissionsView();
        $header["title"]='Control de Asistencia - Jornadas - Agregar';
        $this->load->view('template/header', $header);
        $this->load->view('jornada_agregar', array(
            'jornada' => $jornada,
            'action' => $action));
        $this->load->view('template/footer');
    }

    /* Procesa el formulario de una jornada nueva */
    public function agregar_jornada()
    {
        if($this->session->userdata('user') == NULL){ redirect('error_acceso'); }
        $hora_inicio = $this->input->post('hora_inicio');
        $ampm = $this->input->post('ampm_inicio');
        $hora_inicio = $hora_inicio.' '.$ampm;
        $hrs_ini = new DateTime($hora_inicio);

        $hora_fin = $this->input->post('hora_fin');
        $ampm = $this->input->post('ampm_fin');
        $hora_fin = $hora_fin.' '.$ampm;
        $hrs_fin = new DateTime($hora_fin);

        $cantidad_horas_descanso = $this->input->post('cantidad_horas_descanso');
        $tolerancia = $this->input->post('tolerancia');
        $tipo = $this->input->post('tipo');
        $cargo = $this->input->post('cargo');

        $dias_jornada = $this->input->post('dias_jornada');

        $jornada = array(
            'hora_inicio' => $hrs_ini->format('H:i:s'), //Guardando en formato 24hrs
            'hora_fin'  => $hrs_fin->format('H:i:s'), //Guardando en formato 24hrs
            'tipo'  => $tipo,
            'tolerancia'    => $tolerancia,
            'cantidad_horas_descanso' => $cantidad_horas_descanso,
            'id_cargo' => $cargo,
            'dias_jornada' => serialize($dias_jornada)
        );

        /* Esta función recibe 'nombre_tabla' donde se guardaran los datos pasados por $jornada */
        if ($this->model_rhh_funciones->existe_como('rhh_jornada_laboral', 'id_cargo', $cargo, null)) {
            $mensaje = "<div class='alert alert-danger well-sm' role='alert'><i class='fa fa-exclamation fa-2x pull-left'></i>Ya existe una Jornada asociada al cargo que especificó.</div>";
            return $this->corregir_jornada($jornada,'jornada/agregar',$mensaje);
        }else{
            $this->model_rhh_funciones->guardar('rhh_jornada_laboral', $jornada);
            set_message('success','Se ha agregado la configuración de forma correcta');
            redirect('jornada');
        }
    }

    public function corregir_jornada($jornada, $action = 'jornada/agregar', $mensaje)
    {
        $header = $this->dec_permiso->load_permissionsView();
        $header["title"]='Control de Asistencia - Jornadas - Agregar';

        $this->load->view('template/header', $header);
        $this->load->view('jornada_editar', array(
            'jornada' => $jornada,
            'action' => $action,
            'mensaje' => $mensaje));
        $this->load->view('template/footer');
    }

    public function modificar_jornada($ID)
    {
        is_user_authenticated();
        // if($this->session->userdata('user') == NULL){ redirect('error_acceso'); }
        //obtener los datos del modelo
        $jornada = $this->model_rhh_asistencia->obtener_jornada($ID);

        //Devolverlos a la vista
        if ($jornada == null) {
            set_message('danger',"La jornada que intenta modificar no existe.");
            redirect('jornada');
        }else{
            foreach ($jornada as $key) {
                $data = array(
                    'ID' => $key->ID,
                    'hora_inicio' => $key->hora_inicio,
                    'hora_fin' => $key->hora_fin,
                    'tolerancia' => $key->tolerancia,
                    'tipo' => $key->tipo,
                    'cargo' => $key->id_cargo,
                    'cantidad_horas_descanso' => $key->cantidad_horas_descanso,
                    'dias_jornada' => $key->dias_jornada
                );
            }
            // retorna al formulario de agregar jornada los datos para ser modificados
            return $this->nueva_jornada($data, 'jornada/actualizar');
        }
    }

    /* Para procesar los datos de un jornada modificada */
    public function actualizar_jornada()
    {
        if($this->session->userdata('user') == NULL){ redirect('error_acceso'); }

        $ID = $this->input->post('ID');

        $hora_inicio = $this->input->post('hora_inicio');
        $ampm = $this->input->post('ampm_inicio');
        $hora_inicio = $hora_inicio.' '.$ampm;
        $hrs_ini = new DateTime($hora_inicio);

        $hora_fin = $this->input->post('hora_fin');
        $ampm = $this->input->post('ampm_fin');
        $hora_fin = $hora_fin.' '.$ampm;
        $hrs_fin = new DateTime($hora_fin);

        $cantidad_horas_descanso = $this->input->post('cantidad_horas_descanso');
        $tolerancia = $this->input->post('tolerancia');
        $tipo = $this->input->post('tipo');
        $cargo = $this->input->post('cargo');
        $dias_jornada = $this->input->post('dias_jornada');

        $jornada = array(
            'ID' => $ID,
            'hora_inicio' => $hrs_ini->format('H:i:s'), //Guardando en formato 24hrs
            'hora_fin'  => $hrs_fin->format('H:i:s'), //Guardando en formato 24hrs
            'tipo'  => $tipo,
            'tolerancia'    => $tolerancia,
            'cantidad_horas_descanso' => $cantidad_horas_descanso,
            'id_cargo' => $cargo,
            'dias_jornada' => serialize($dias_jornada)
        );

        /* Esta función recibe 'nombre_tabla' donde se guardaran los datos pasados por $jornada
        en este caso jornada tiene un campo ID para actualizar */
        if ($this->model_rhh_funciones->existe_como('rhh_jornada_laboral', 'id_cargo', $cargo, $ID)) {
            set_message('danger',"Ya existe una Jornada asociada al cargo que especificó");
        }else{
            $this->model_rhh_funciones->guardar('rhh_jornada_laboral', $jornada);
            set_message('success','Se ha modificado la Jornada de forma exitosa.');
        }
        redirect('jornada');
    }

    public function eliminar_jornada($id)
    {
        is_user_authenticated();
        // if($this->session->userdata('user') == NULL){ redirect('error_acceso'); }

        /* Verificar que existe una jornada para eliminar */
        if($this->model_rhh_funciones->existe_como('rhh_jornada_laboral', 'ID', $id, null))
        {
            $this->model_rhh_funciones->eliminar('rhh_jornada_laboral', $id);
            set_message('success','Se ha eliminado la jornada con exito');
        }else{
            set_message('danger','La Jornada que intenta eliminar no existe');
        }
        $this->session->set_flashdata("mensaje", $mensaje);
        redirect('jornada');
    }

}