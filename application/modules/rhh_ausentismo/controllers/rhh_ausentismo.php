<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rhh_ausentismo extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->module('dec_permiso/dec_permiso');
        $this->load->model('model_rhh_ausentismo');
        $this->load->model('model_rhh_funciones');
    }
    
    /* Muestra todos los tipos de ausentismos agregados en la configuracion */
    public function index()
    {
        is_user_authenticated();

        $header = $this->dec_permiso->load_permissionsView();
        $header["title"] ='Ausentimos';

        $ausentismos = $this->model_rhh_ausentismo->obtenerTodos();
        $this->load->view('template/header', $header);
        $this->load->view('configuraciones_ausentismos_index', array(
            'ausentismos' => $ausentismos ));
        $this->load->view('template/footer');
    }

    /* Devuelve los datos de una configuracion de ausentismo para ser mostrada en la vista del index */
    public function ver($ID)
    {
        $conf = $this->model_rhh_funciones->obtener_uno('rhh_configuracion_ausentismo', $ID);

        // foreach ($conf as $key) {
        //         $ausentismo = array(
        //         // 'ID' => $ID,
        //         'tipo' => $key->tipo,
        //         'nombre' => $key->nombre,
        //         'minimo_dias_permiso' => $key->minimo_dias_permiso,
        //         'maximo_dias_permiso' => $key->maximo_dias_permiso,
        //         'cantidad_maxima_mensual' => $key->cantidad_maxima_mensual,
        //         'tipo_dias' => $key->tipo_dias,
        //         'soportes' => $key->soportes
        //     );
        // }

        header('Content-Type: application/json');
        echo json_encode($this->load->view('configuracion_ver', array(
                'ausentismo' => $conf), TRUE));
    }

    /* Devuelve la vista para cargar una nueva configuración de ausentismo */
    public function configuracion_nueva()
    {
        // CUANDO ESTOY OBTENIENDO UN ERROR DEL CONTROLADOR Y QUIERO USAR EL FLASHDATA PARA PASAR EL MENSAJE
        $ausentismo = $this->session->flashdata('ausentismo');

        $header = $this->dec_permiso->load_permissionsView();
        $header["title"]='Ausentimos - Configuraciones';
        $this->load->view('template/header', $header);
        $this->load->view('configuracion_agregar', array(
            'form_data' => $ausentismo));
        $this->load->view('template/footer');
    }

     // MANEJA LA PETICIÓN DE AGREGACION DE UNA CONFIGURACIÓN DE AUSENTISMO 
    public function configuracion_verificar()
    {
        $header['title'] = 'Ausentimos - Configuraciones - Agregar';

        // OBTENIENDO LOS VALORES DEL FORMULARIO
        $tipo_ausentismo = strtoupper($this->input->post('tipo_ausentismo'));
        $nombre = strtoupper($this->input->post('nombre'));
        $min_dias = $this->input->post('min_dias');
        $max_dias = $this->input->post('max_dias');
        $max_mensual = $this->input->post('max_mensual');
        $tipo_dias = $this->input->post('tipo_dias');
        $soportes = $this->input->post('soportes');

        $ausentismo = array(
            'tipo' => $tipo_ausentismo,
            'nombre' => $nombre,
            'minimo_dias_permiso' => $min_dias,
            'maximo_dias_permiso' => $max_dias,
            'cantidad_maxima_mensual' => $max_mensual,
            'tipo_dias' => $tipo_dias,
            'soportes' => $soportes
        );

        if (strlen($nombre) < 3 || $nombre == ' ') {
            set_message('danger', '<b>Disculpe</b>, el nombre del nuevo ausentismo no puede tener tan pocos caracteres o estar en blanco.');
            $this->session->set_flashdata("ausentismo", $ausentismo);
            redirect('ausentismo/configuracion/nueva', $ausentismo);
        }

        // VERIFICAR QUE LOS VALORES DEL FORMULARIO NO ESTEN EN BLANCO
        if ($nombre == '' || $min_dias == '' || $max_dias == '' || $max_mensual == '') {
            set_message('danger', '<b>Disculpe</b>, Parece que alguno(s) de los valores del formulario están en blanco, por favor completelos.');
            $this->session->set_flashdata("ausentismo", $ausentismo);
            redirect('ausentismo/configuracion/nueva', $ausentismo);
        }

        if ($min_dias <= 0 || $max_dias <= 0 || $max_mensual <= 0) {
            set_message('danger', 'Los días o cantidad por mes no pueden ser negativas o menores iguales a 0.');
            $this->session->set_flashdata("ausentismo", $ausentismo);
            redirect('ausentismo/configuracion/nueva', $ausentismo);
        }
        
        if ($min_dias > $max_dias) {
            set_message('danger', 'La cantidad de <b>Días Máximos</b> debe ser mayor que la Cantidad de <b>Días Mínimos</b>');
            $this->session->set_flashdata("ausentismo", $ausentismo);
            redirect('ausentismo/configuracion/nueva', $ausentismo);
        }

        // VERFICIAR QUE EL TIPO NO SEA UNO EXISTENTE.
        if ($this->model_rhh_ausentismo->existe_configuracion_ausentismo($ausentismo)) {
            // YA HAY UN TIPO DE AUSENTISMO CON ESE NOMBRE
            set_message('danger', 'El ausentismo que ha indicado ya existe, por favor utilice otro nombre.');
            $this->session->set_flashdata("ausentismo", $ausentismo);
            redirect('ausentismo/configuracion/nueva', $ausentismo);

        }else{
            set_message('success', 'Se ha agregado el tipo de ausentismo de manera satisfactoria.');
            
            // ALMACENAR EN LA BASE DE DATOS EL AUSENTISMO 
            $this->model_rhh_ausentismo->agregar_configuracion_ausentismo($ausentismo);
            redirect('ausentismo');
        }
    }

    /* Maneja las cantidades de configuraciones */
    public function configuracion_editar($ID)
    {
        $conf = $this->model_rhh_ausentismo->obtenerUno($ID);
        foreach ($conf as $key) {
                $ausentismo = array(
                'ID' => $ID,
                'tipo' => $key->tipo,
                'nombre' => $key->nombre,
                'minimo_dias_permiso' => $key->minimo_dias_permiso,
                'maximo_dias_permiso' => $key->maximo_dias_permiso,
                'cantidad_maxima_mensual' => $key->cantidad_maxima_mensual,
                'tipo_dias' => $key->tipo_dias,
                'soportes' => $key->soportes
            );
        }

        $header["title"]='Ausentimos - Configuraciones';
        $this->load->view('template/header', $header);
        $this->load->view('configuracion_modificar', array(
            'form_data' => $ausentismo));
        $this->load->view('template/footer');
    }

    /* Actualiza una configuración */
    public function guardar_modificacion($ID)
    {
        $header["title"]='Ausentimos - Configuraciones';
        /*Obeteniendo los valores del formulario*/
        $tipo_ausentismo = strtoupper($this->input->post('tipo_ausentismo'));
        $nombre = strtoupper($this->input->post('nombre'));
        $min_dias = $this->input->post('min_dias');
        $max_dias = $this->input->post('max_dias');
        $max_mensual = $this->input->post('max_mensual');
        $tipo_dias = $this->input->post('tipo_dias');
        $soportes = $this->input->post('soportes');

        $ausentismo = array(
            'ID' => $ID,
            'tipo' => $tipo_ausentismo,
            'nombre' => $nombre,
            'minimo_dias_permiso' => $min_dias,
            'maximo_dias_permiso' => $max_dias,
            'cantidad_maxima_mensual' => $max_mensual,
            'tipo_dias' => $tipo_dias,
            'soportes' => $soportes
        );

        if (strlen($nombre) < 3 || $nombre == ' ') {
            set_message('danger', "<b>Disculpe</b>, el nombre del nuevo ausentismo no puede tener tan pocos caracteres o estar en blanco.");
            $this->session->set_flashdata("mensaje", $mensaje);

            // $this->session->set_flashdata("ausentismo", $ausentismo);
            redirect('ausentismo/configuracion/modificar/'.$ID);
        }

        // VERIFICAR QUE LOS VALORES DEL FORMULARIO NO ESTEN EN BLANCO
        if ($nombre == '' || $min_dias == '' || $max_dias == '' || $max_mensual == '') {
            set_message('danger', "<b>Disculpe</b>, Parece que alguno(s) de los valores del formulario están en blanco, por favor completelos.");
            // $this->session->set_flashdata("ausentismo", $ausentismo);
            redirect('ausentismo/configuracion/modificar/'.$ID);
        }

        if ($min_dias <= 0 || $max_dias <= 0 || $max_mensual <= 0) {
            set_message('danger', "Los días o cantidad por mes no pueden ser negativas o menores iguales a 0.");
            // $this->session->set_flashdata("ausentismo", $ausentismo);
            redirect('ausentismo/configuracion/modificar/'.$ID);
        }
        
        if ($min_dias > $max_dias) {
            set_message('danger', "La cantidad de <b>Días Máximos</b> debe ser mayor que la Cantidad de <b>Días Mínimos</b>");
            redirect('ausentismo/configuracion/modificar/'.$ID);
        }

        if ($min_dias <= 0 || $max_dias <= 0 || $max_mensual <= 0) {
            set_message("danger", "<b>Disculpe</b>, Parece que alguno(s) de los valores del formulario son menores o iguales a cero.");
            $this->load->view('template/header', $data);
            $this->load->view('configuracion_modificar', array(
                'form_data' => $ausentismo));
            $this->load->view('template/footer');
        }
        
        $this->model_rhh_ausentismo->actualizar_configuracion_ausentismo($ausentismo);
        set_message('success', 'Se ha modificado el tipo de ausentismo de manera satisfactoria.');
        redirect('ausentismo');
    }

    /* Elimina una configuración */
    public function eliminar_configuracion($ID)
    {
        if (sizeof($this->model_rhh_ausentismo->obtenerUno($ID)) > 0) {
            $this->model_rhh_ausentismo->eliminar($ID);
            set_message('success', "Se ha eliminado la configuración de manera éxitosa.");
        }else{
            set_message('danger', "Se ha producido un error al eliminar la configuración");
        }
        $this->session->set_flashdata("mensaje", $mensaje);
        redirect('ausentismo');
    }

    /**********************************************/
    /******** PARA SOLICITAR UN AUSENTISMO ********/
    /**********************************************/

    /* Formulario para solicitar un ausentismo */
    public function solicitar_nuevo()
    {
        $header = $this->dec_permiso->load_permissionsView();
        $header["title"]='Ausentimos - Configuraciones';
        $this->load->view('template/header', $header);
        $this->load->view('solicitar_nuevo');
        $this->load->view('template/footer');
    }

    /* es para el ajax de obtener los tipos de ausentismos cuando el usuario está agregando un ausentismo nuevo */
    public function obtener_tipos()
    {
        $formulario = $this->input->post();
        $result = $this->model_rhh_ausentismo->get_ausentimos_by_tipo($formulario['tipo']);
        header('Content-Type: application/json');
        echo json_encode($result);
    }












    /*Para calcular la fecha final en la que debe terminar el ausentismo, partiendo de la fecha indicada*/
    public function tipo_dias_ausentimos($ausentismo, $formulario, $fecha_final)
    {
        // El ausentismo inicia en la fecha indicada por el user
        $fecha_final = new DateTime($formulario['fecha_inicio_ausentismo']);

        // var_dump($formulario);
        // var_dump($fecha_final); die();

        $long_ausentismo = $ausentismo->maximo_dias_permiso;
        $long_ausentismo--;

        // si son dias habiles (Lun-Vie), dias continuos (Lun-Dom)
        if ($ausentismo->tipo_dias == 'Hábiles') {
            $str = date('d-m-Y', strtotime($fecha_final->format('Y-m-d').' + '.$long_ausentismo.' weekdays'));
            $fecha_final = new DateTime($str);

        }elseif ($ausentismo->tipo_dias == 'Continuos') {
            $fecha_final->add(new DateInterval('P'.$long_ausentismo.'D'));
        }else{
            echo_pre("Este tipo_dias para un Ausentimo no esta definido", __LINE__, __FILE__);
        }
        
        return $fecha_final;
    }

    /* *  * */
    public function diferencia_dias($formulario, $ausentismo)
    {
        var_dump($formulario);
        var_dump($ausentismo);

        $date_ini = new DateTime($formulario['fecha_inicio_ausentismo']);
        $date_fin = new DateTime($formulario['fecha_final_ausentismo']);

        $diferencia = $date_ini->diff($date_fin);
        $diferencia = $diferencia->days;
        
        if ($diferencia > $ausentismo->maximo_dias_permiso) {
            set_message("danger", "El intervalo de fechas que ha elegido supera en días a la cantidad maxima permitida para el ausentismo que seleccionó. Cham@ la tas'ca");
            redirect('ausentismo/solicitar');
        }
        die();
    }


















    /* Permite a un usuario del sistema solicitar un ausentismo (permiso o reposo) */
    public function solicitar_nuevo_agregar()
    {
        $fecha_hoy = new Datetime('NOW');
        $fecha_final = new DateTime('NOW');

        is_user_authenticated();
        // $id_trabajador = $this->session->userdata('user')['id_usuario'];
        // if($id_trabajador == ''){ redirect('usuario/cerrar-sesion'); }
        
        $formulario = $this->input->post();
        $ausentismo = $this->model_rhh_ausentismo->obtenerUno($formulario['lista_ausentismos']);

        if (sizeof($ausentismo) == 1) {
            # entonces hay almenos un ausentismo
            $ausentismo = $ausentismo[0];

            //Para calcular la diferencia entre días que indicó el user
            $diff_dias = $this->diferencia_dias($formulario, $ausentismo);

            // Para calcular la fecha final de la solicitud
            $fecha_final = $this->tipo_dias_ausentimos($ausentismo, $formulario, $fecha_final);

            // var_dump($ausentismo);
            // var_dump($fecha_final); die();

            // Creando el elemento a insertar
            $solicitud = array('id_trabajador' => $id_trabajador,
                'id_tipo_ausentismo' => $ausentismo->ID,
                'nombre' => $ausentismo->nombre,
                'descripcion' => 'TBA',
                'fecha_inicio' => $fecha_hoy->format('Y/m/d H:i:s'),
                'fecha_final' => $fecha_final->format('Y/m/d'),
                'estatus' => 'TBA',
                'fecha_solicitud' => $fecha_hoy->format('Y/m/d H:i:s')
            );
            // var_dump($solicitud); die();

            // Primero Jusgar el tipo de Soliticud
            if ($ausentismo->tipo == 'PERMISO') {
                echo "usted ha solicitado un permiso";
                # hacer las verificaciones del tipo, la cantidad de veces... etc
                # discriminar hacia que tabla de la base de datos
                $this->model_rhh_ausentismo->agregar_solicitud_ausentismo($solicitud, $ausentismo->tipo);

            }elseif($ausentismo->tipo == 'REPOSO'){
                // echo "usted ha solicitado un reposo";
                # hacer las verificaciones del tipo, la cantidad de veces... etc
                // Despues de haber superado las validaciones insertar
                $this->model_rhh_ausentismo->agregar_solicitud_ausentismo($solicitud, $ausentismo->tipo);

            } # clasificando el tipo de ausentismo que se han presentado
        }else{
            set_message("danger", "Debe seleccionar un ausentismo de tipo ".strtoupper($formulario['tipo_ausentismo'])." de la lista 'Seleccione uno'");
            # hubieron 0 ó más de 1 resultado
            redirect('ausentismo/solicitar');
        } # verificando la cantidad de resultados para el ausentismo dado

        set_message('success', "Se ha solicitado satisfactoriamente un ausentismo de tipo ".strtoupper($formulario['tipo_ausentismo']).", este pendiente del estatus del mismo. A partir del dia de mañana dispone de 3 dias habiles para subir el soporte en digital al sistema");
        
        redirect('ausentismo/usuario/listar');

    } # solicitar_nuevo_agregar FIN

    /*Lista los ausentimos de un usuario (todos)*/
    public function listar_ausentismos()
    {
        is_user_authenticated();

        $mis_ausentismos = $this->model_rhh_ausentismo->obtener_mis_ausentismos($this->session->userdata('user')['id_usuario']);

        $header = $this->dec_permiso->load_permissionsView();
        $header["title"]='Ausentimos - Configuraciones';
        $this->load->view('template/header', $header);
        $this->load->view('usuario_mis_ausentismos', $mis_ausentismos);
        $this->load->view('template/footer');
    }

    /*Detalles de un ausentismo solicitado*/
    public function usuario_solicitados_ver($ID_ausentismo_config, $ID_ausentismo_solicitado)
    {
        $conf = $this->model_rhh_funciones->obtener_uno('rhh_configuracion_ausentismo', $ID_ausentismo_config);

        if ($conf['tipo'] == 'REPOSO') {
            $sol = $this->model_rhh_funciones->obtener_uno('rhh_ausentismo_reposo', $ID_ausentismo_solicitado);
        }else{
            $sol = $this->model_rhh_funciones->obtener_uno('rhh_ausentismo_permiso', $ID_ausentismo_solicitado);
        }

        header('Content-Type: application/json');
        echo json_encode(
            $this->load->view('solicitado_usuario_ver', 
            array(
                'ausentismo' => $conf,
                'solicitud' => $sol,
            ), TRUE));
    }

    public function usuario_solicitado_eliminar($ID_ausentismo_solicitado)
    {
        /*echo "this is the controller we should calling";*/
        // echo $ID_ausentismo_solicitado; die();
        set_message('success', 'Se ha eliminado la solicitud de forma correcta');
        redirect('ausentismo/usuario/listar', 'auto');
    }

}