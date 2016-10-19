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
        // if($this->session->userdata('user') == NULL){ redirect('error_acceso'); }
        $header = $this->dec_permiso->load_permissionsView();
        $header["title"] ='Cargos';
        $cargos = $this->model_rhh_funciones->obtener_todos('rhh_cargo');
        $this->load->view('template/header', $header);
        $this->load->view('index', array(
            'cargos' => $cargos ));
        $this->load->view('template/footer');
    }

    public function nuevo($cargo = null, $action = 'cargo/agregar')
    {
        is_user_authenticated();
        // if($this->session->userdata('user') == NULL){ redirect('error_acceso'); }
        $header = $this->dec_permiso->load_permissionsView();
        $header["title"]='Control de Asistencia - Jornadas - Agregar';
        
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
        // if($this->session->userdata('user') == NULL){ redirect('error_acceso'); }
        //obtener los datos del modelo
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
            return $this->nuevo($data, 'cargo/actualizar');
        }
    }

    public function agregar()
    {
        is_user_authenticated();
        // if($this->session->userdata('user') == NULL){ redirect('error_acceso'); }
        $codigo = strtoupper($this->input->post('codigo_cargo'));
        $nombre = $this->input->post('nombre_cargo');
        $tipo = $this->input->post('tipo_cargo');
        $descripcion = $this->input->post('descripcion_cargo');

        $cargo = array(
            'codigo' => $codigo,
            'nombre' => $nombre,
            'tipo' => $tipo,
            'descripcion' => $descripcion
        );

        if ($this->model_rhh_cargo->existe($codigo) != 0) {
            set_message('danger','Ya existe un cargo con el código que especificó');
        }else{
            /* Esta función recibe 'nombre_tabla' donde se guardaran los datos pasados por $jornada */
            $this->model_rhh_funciones->guardar('rhh_cargo', $cargo);
            set_message('success','Se ha agregado el cargo de forma correcta');
        }
        redirect('cargo');
    }

    public function actualizar()
    {
        is_user_authenticated();
        // if($this->session->userdata('user') == NULL){ redirect('error_acceso'); }
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

        $this->model_rhh_funciones->guardar('rhh_cargo', $cargo);
        set_message('success','Se ha modificado el cargo de forma correcta');
        redirect('cargo');
    }

    public function eliminar($ID)
    {
        is_user_authenticated();
        // if($this->session->userdata('user') == NULL){ redirect('error_acceso'); }
        if ($this->model_rhh_funciones->existe_como('rhh_cargo','ID',$ID, null)) {
            $this->model_rhh_funciones->eliminar('rhh_cargo', $ID);
            set_message('success','Se ha eliminado el cargo de forma correcta');
        }else{
            set_message('danger','Un error impidio que se lleve acabo la operación');
        }
        redirect('cargo');
    }

}