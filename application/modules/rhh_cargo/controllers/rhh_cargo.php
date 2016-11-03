<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rhh_cargo extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->module('dec_permiso/dec_permiso');
        $this->load->model('model_rhh_cargo'); /*Para procesar los datos en la BD */
        /* Incluyo otro modelo para usuar funciones que están "sobrecargadas"? y son comunes en todos los modulos de rhh
            - public function guardar($tabla, $data)
            - public function eliminar($tabla, $ID)
            - public function existe_como($tabla, $columna, $id, $este)
        */
        $this->load->model('model_rhh_funciones');
    }
    
    /* Carga elementos para efectos demostrativos */
    public function index()
    {
        is_user_authenticated();
        $header = $this->dec_permiso->load_permissionsView();
        $header["title"] ='Cargos';
        $cargos = $this->model_rhh_funciones->obtener_todos('rhh_cargo');
        $this->load->view('template/header', $header);
        $this->load->view('index', array(
            'cargos' => $cargos ));
        $this->load->view('template/footer');
    }

    public function nuevo($cargo = NULL, $action = 'cargo/agregar', $message)
    {
        is_user_authenticated();
        $header = $this->dec_permiso->load_permissionsView();
        $header["title"]='Control de Asistencia - Jornadas - Agregar';

        /* al llamar la funcion desde otro metodo del controlador no se muestran los mensajes, entonces hay que pasarlos y colocarlos en el metodo que tiene la llamada a la vista o la función redirect() para ver los flashdata */
        if ($message != NULL) { set_message($message['tipo'], $message['mensaje']); }
        
        if ($cargo == NULL) { $titulo = "Cargo Nuevo"; }else{ $titulo = "Modificar Cargo"; }
        $this->load->view('template/header', $header);
        $this->load->view('nuevo', array(
            'cargo' => $cargo,
            'titulo_panel' => $titulo,
            'action' => $action));
        $this->load->view('template/footer');
    }

    public function modificar($ID)
    {
        is_user_authenticated();
        $cargo = $this->model_rhh_cargo->obtener_cargo($ID);

        //Devolverlos a la vista
        if ($cargo == null) {
            set_message('danger','El Cargo que intenta modificar no existe');
            redirect('cargo');
        }else{
            foreach ($cargo as $key) {
                $data = array(
                    'ID' => $key->ID,
                    'codigo' => $key->codigo,
                    'nombre' => $key->nombre,
                    'tipo' => $key->tipo,
                    'descripcion' => $key->descripcion,
                );
            }
            // retorna al formulario de agregar cargo los datos para ser modificados
            return $this->nuevo($data, 'cargo/actualizar', NULL);
        }
    }

    // AGREGA EL CARGO EN LA BASE DE DATOS
    public function agregar()
    {
        is_user_authenticated();
        $codigo = strtoupper($this->input->post('codigo_cargo'));
        $nombre = $this->input->post('nombre_cargo');
        $tipo = $this->input->post('tipo_cargo');
        $descripcion = $this->input->post('descripcion_cargo');

        $cargo = array(
            'ID' => null, // si ocurre algun problema con la validacion esto debe estar en null porque la inserción no se pudo realizar
            'codigo' => $codigo,
            'nombre' => $nombre,
            'tipo' => $tipo,
            'descripcion' => $descripcion
        );

        $resultado = $this->verificar_datos_cargo($cargo);
        // echo_pre($resultado);

        if ($resultado['bandera'] != NULL) {

            if ($this->model_rhh_cargo->existe($codigo) != 0) {
                // echo $this->model_rhh_cargo->existe($codigo); die();
                $resultado['tipo'] = 'danger';
                $resultado['mensaje'] = "Ya existe un cargo con el código '".$cargo['codigo']."' que especificó";
            }else{
                /* Esta función recibe 'nombre_tabla' donde se guardaran los datos pasados por $cargo */
                $this->model_rhh_funciones->guardar('rhh_cargo', $cargo);
                set_message('success','Se ha agregado el cargo de forma correcta');
                redirect('cargo');
            }
        }
        
        $this->nuevo($cargo, 'cargo/agregar', $resultado);
    }

    public function actualizar()
    {
        is_user_authenticated();
        $ID = $this->input->post('ID');
        $codigo = strtoupper($this->input->post('codigo_cargo'));
        $nombre = $this->input->post('nombre_cargo');
        $tipo = $this->input->post('tipo_cargo');
        $descripcion = $this->input->post('descripcion_cargo');

        $cargo = array(
            'ID' => $ID,
            'codigo' => $codigo,
            'nombre' => $nombre,
            'tipo' => $tipo,
            'descripcion' => $descripcion
        );

        $resultado = $this->verificar_datos_cargo($cargo);
        if ($resultado['bandera']) {
            $this->model_rhh_funciones->guardar('rhh_cargo', $cargo);
            set_message('success','Se ha modificado el cargo de forma correcta');
            redirect('cargo');
        }else{
            set_message($resultado['tipo'], $resultado['mensaje']);
            redirect('cargo/modificar/'.$ID);
        }
    }

    public function eliminar($ID)
    {
        is_user_authenticated();
        if ($this->model_rhh_funciones->existe_como('rhh_cargo','ID',$ID, null)) {
            $this->model_rhh_funciones->eliminar('rhh_cargo', $ID);
            set_message('success','Se ha eliminado el cargo de forma correcta');
        }else{
            set_message('danger','Un error impidio que se lleve acabo la operación');
        }
        redirect('cargo');
    }

    /* PARA CONTROLAR LOS VALORES DEL FORMULARIO */
    private function verificar_datos_cargo(&$cargo)
    {
        // PARA MODIFICAR APROPIADAMENTE EL CODIGO
        $cargo['codigo'] = strtoupper(preg_replace('/\s+/', '', $cargo['codigo']));
        $cargo['codigo'] = str_replace(' ', '', $cargo['codigo']);
        $cargo['descripcion'] = preg_replace('/\s+/', ' ', $cargo['descripcion']);

        $mensaje = [];
        $mensaje['bandera'] = true;

        if(isset($cargo)){
            if(strlen($cargo['codigo']) >= 0 && strlen($cargo['codigo']) <= 3) {
                $mensaje['bandera'] = false;
                $mensaje['tipo'] = 'error';
                $mensaje['mensaje'] = "El <b>Código</b> deberá ser de más de 3 caracteres";
            }

            if (trim($cargo['codigo'], " \t\n\r\0\x0B") == '') {
                $mensaje['bandera'] = false;
                $mensaje['tipo'] = 'error';
                $mensaje['mensaje'] = "El <b>Código</b> no debe ser espacios en blanco";
            }

        }else{
            echo "Error funcion verificar_datos_cargo $parametro is not set";
            die();
        }
        
        return $mensaje;
    }

}