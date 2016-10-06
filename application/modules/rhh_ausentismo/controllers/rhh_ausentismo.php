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
        foreach ($conf as $key) {
                $ausentismo = array(
                // 'ID' => $ID,
                'tipo' => $key->tipo,
                'nombre' => $key->nombre,
                'minimo_dias_permiso' => $key->minimo_dias_permiso,
                'maximo_dias_permiso' => $key->maximo_dias_permiso,
                'cantidad_maxima_mensual' => $key->cantidad_maxima_mensual,
                'tipo_dias' => $key->tipo_dias,
                'soportes' => $key->soportes
            );
        }

        header('Content-Type: application/json');
        echo json_encode($this->load->view('configuracion_ver', array(
                'ausentismo' => $ausentismo), TRUE));
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
            $mensaje = "<div class='alert alert-danger well-sm' role='alert'><i class='fa fa-exclamation fa-2x pull-left'></i> <b>Disculpe</b>, el nombre del nuevo ausentismo no puede tener tan pocos caracteres o estar en blanco.</div>";
            $this->session->set_flashdata("mensaje", $mensaje);

            $this->session->set_flashdata("ausentismo", $ausentismo);
            redirect('ausentismo/configuracion/nueva', $ausentismo);
        }

        // VERIFICAR QUE LOS VALORES DEL FORMULARIO NO ESTEN EN BLANCO
        if ($nombre == '' || $min_dias == '' || $max_dias == '' || $max_mensual == '') {
            $mensaje = "<div class='alert alert-danger well-sm' role='alert'><i class='fa fa-exclamation fa-2x pull-left'></i> <b>Disculpe</b>, Parece que alguno(s) de los valores del formulario están en blanco, por favor completelos.</div>";
            $this->session->set_flashdata("mensaje", $mensaje);
            
            $this->session->set_flashdata("ausentismo", $ausentismo);
            redirect('ausentismo/configuracion/nueva', $ausentismo);
        }

        if ($min_dias <= 0 || $max_dias <= 0 || $max_mensual <= 0) {
            $mensaje = "<div class='alert alert-danger well-sm' role='alert'><i class='fa fa-exclamation fa-2x pull-left'></i>Los días o cantidad por mes no pueden ser negativas o menores iguales a 0.</div>";
            $this->session->set_flashdata("mensaje", $mensaje);
            
            $this->session->set_flashdata("ausentismo", $ausentismo);
            redirect('ausentismo/configuracion/nueva', $ausentismo);
        }
        
        if ($min_dias > $max_dias) {
            $mensaje = "<div class='alert alert-danger well-sm' role='alert'><i class='fa fa-exclamation fa-2x pull-left'></i>La cantidad de <b>Días Máximos</b> debe ser mayor que la Cantidad de <b>Días Mínimos</b></div>";
            $this->session->set_flashdata("mensaje", $mensaje);
            
            $this->session->set_flashdata("ausentismo", $ausentismo);
            redirect('ausentismo/configuracion/nueva', $ausentismo);
        }

        // VERFICIAR QUE EL TIPO NO SEA UNO EXISTENTE.
        if ($this->model_rhh_ausentismo->existe_configuracion_ausentismo($ausentismo)) {
            // YA HAY UN TIPO DE AUSENTISMO CON ESE NOMBRE
            $mensaje = "<div class='alert alert-danger well-sm' role='alert'><i class='fa fa-exclamation fa-2x pull-left'></i>El ausentismo que ha indicado ya existe, por favor utilice otro nombre.</div>";
            $this->session->set_flashdata("mensaje", $mensaje);

            $this->session->set_flashdata("ausentismo", $ausentismo);
            redirect('ausentismo/configuracion/nueva', $ausentismo);

        }else{
            // NO EXISTE EL TIPO DE AUSENTISMO CON ESE NOMBRE
            $mensaje = "<div class='alert alert-success well-sm' role='alert'><i class='fa fa-check fa-2x pull-left'></i>Se ha agregado el tipo de ausentismo de manera satisfactoria.<br></div>";
            $this->session->set_flashdata("mensaje", $mensaje);
            
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
            $mensaje = "<div class='alert alert-danger well-sm' role='alert'><i class='fa fa-exclamation fa-2x pull-left'></i> <b>Disculpe</b>, el nombre del nuevo ausentismo no puede tener tan pocos caracteres o estar en blanco.</div>";
            $this->session->set_flashdata("mensaje", $mensaje);

            // $this->session->set_flashdata("ausentismo", $ausentismo);
            redirect('ausentismo/configuracion/modificar/'.$ID);
        }

        // VERIFICAR QUE LOS VALORES DEL FORMULARIO NO ESTEN EN BLANCO
        if ($nombre == '' || $min_dias == '' || $max_dias == '' || $max_mensual == '') {
            $mensaje = "<div class='alert alert-danger well-sm' role='alert'><i class='fa fa-exclamation fa-2x pull-left'></i> <b>Disculpe</b>, Parece que alguno(s) de los valores del formulario están en blanco, por favor completelos.</div>";
            $this->session->set_flashdata("mensaje", $mensaje);
            
            // $this->session->set_flashdata("ausentismo", $ausentismo);
            redirect('ausentismo/configuracion/modificar/'.$ID);
        }

        if ($min_dias <= 0 || $max_dias <= 0 || $max_mensual <= 0) {
            $mensaje = "<div class='alert alert-danger well-sm' role='alert'><i class='fa fa-exclamation fa-2x pull-left'></i>Los días o cantidad por mes no pueden ser negativas o menores iguales a 0.</div>";
            $this->session->set_flashdata("mensaje", $mensaje);
            
            // $this->session->set_flashdata("ausentismo", $ausentismo);
            redirect('ausentismo/configuracion/modificar/'.$ID);
        }
        
        if ($min_dias > $max_dias) {
            $mensaje = "<div class='alert alert-danger well-sm' role='alert'><i class='fa fa-exclamation fa-2x pull-left'></i>La cantidad de <b>Días Máximos</b> debe ser mayor que la Cantidad de <b>Días Mínimos</b></div>";
            $this->session->set_flashdata("mensaje", $mensaje);
            
            // $this->session->set_flashdata("ausentismo", $ausentismo);
            redirect('ausentismo/configuracion/modificar/'.$ID);
        }

        if ($min_dias <= 0 || $max_dias <= 0 || $max_mensual <= 0) {
            $mensaje = "<div class='alert alert-danger well-sm' role='alert'><i class='fa fa-exclamation fa-2x pull-left'></i> <b>Disculpe</b>, Parece que alguno(s) de los valores del formulario son menores o iguales a cero.</div>";
            $this->load->view('template/header', $data);
            $this->load->view('configuracion_modificar', array(
                'form_data' => $ausentismo));
            $this->load->view('template/footer');
        }
        
        $this->model_rhh_ausentismo->actualizar_configuracion_ausentismo($ausentismo);
        $mensaje = "<div class='alert alert-success well-sm' role='alert'><i class='fa fa-check fa-2x pull-left'></i>Se ha modificado el tipo de ausentismo de manera satisfactoria.<br></div>";
        $this->session->set_flashdata('mensaje', $mensaje);
        redirect('ausentismo');
    }

    /* Elimina una configuración */
    public function eliminar_configuracion($ID)
    {
        if (sizeof($this->model_rhh_ausentismo->obtenerUno($ID)) > 0) {
            $this->model_rhh_ausentismo->eliminar($ID);
            $mensaje = "<div class='alert alert-success well-sm' role='alert'><i class='fa fa-check fa-2x pull-left'></i>Se ha eliminado la configuración de manera éxitosa.<br></div>";
        }else{
            $mensaje = "<div class='alert alert-danger well-sm' role='alert'><i class='fa fa-exclamation fa-2x pull-left'></i>Se ha producido un error al eliminar la configuración</div>";
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

    public function solicitar_nuevo_agregar()
    {
        $fecha_hoy = new Datetime('TODAY');
        $id_trabajador = $this->session->userdata('user')['id_usuario'];
        if($id_trabajador == ''){
            $mensaje = "<div class='alert alert-danger well-sm' role='alert'><i class='fa fa-exclamation fa-2x pull-left'></i>Debe iniciar sesión</div>";
            $this->session->set_flashdata("mensaje", $mensaje);
            redirect('usuario/cerrar-sesion');
            // echo "Usted no está logueado <br>";
        }
        
        $formulario = $this->input->post();
        // echo_pre($formulario);

        $ausentismo = $this->model_rhh_ausentismo->obtenerUno($formulario['lista_ausentismos']);
        if (sizeof($ausentismo) == 1) {
            # entonces hay almenos un ausentismo
            $ausentismo = $ausentismo[0];

            //hacer verificaciones sobre las restricciones de la solicitud
            // Tambien se juzga por el tipo para decidir en que tabla almacenar el reposo o permiso
            // las tablas para esto son: rhh_ausentismo_permiso y rhh_ausentismo_reposa
            
            /* - Cantidad Maxima Mensual */

            // Primero Jusgar el tipo de Soliticud
            if ($ausentismo->tipo == 'PERMISO') {
                echo "usted ha solicitado un permiso";
                # hacer las verificaciones del tipo, la cantidad de veces... etc
                # discriminar hacia que tabla de la base de datos


            }elseif($ausentismo->tipo == 'REPOSO'){
                echo "usted ha solicitado un reposo";
                # hacer las verificaciones del tipo, la cantidad de veces... etc
                # discriminar hacia que tabla de la base de datos

                echo "\nid_trabajador: ".$id_trabajador;
                echo_pre($fecha_hoy->format('dd-mm-yy'));
                echo_pre($ausentismo);
                die();

                $solicitud = array(
                    'id_trabajador' => $id_trabajador,
                    'id_tipo_ausentismo' => $ausentismo['ID'],
                    'nombre' => 'Nombre Opcional',
                    'descripcion' => 'TBA',
                    'fecha_inicio' => $fecha_hoy,
                    'fecha_final' => $fecha_hoy,
                    'estatus' => 'TBA',
                    'fecha_solicitud' => $fecha_hoy,
                );

            } # clasificando el tipo de ausentismo que se han presentado
        }else{
            $mensaje = "<div class='alert alert-danger well-sm' role='alert'><i class='fa fa-exclamation fa-2x pull-left'></i>Debe seleccionar un ausentismo de tipo ".strtoupper($formulario['tipo_ausentismo'])." de la lista 'Seleccione uno'</div>";
            $this->session->set_flashdata("mensaje", $mensaje);
            # hubieron 0 ó más de 1 resultado
            redirect('ausentismo/solicitar');
        } # verificando la cantidad de resultados para el ausentismo dado

        # INSERT INTO `rhh_ausentismo_permiso`(`ID`, `TIME`, `id_trabajador`, `nombre`, `descripcion`, `fecha_inicio`, `fecha_final`, `estatus`, `tipo`, `fecha_solicitud`) VALUES

    } # solicitar_nuevo_agregar FIN

}