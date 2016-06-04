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
        $data["title"] ='Cargos';
        $cargos = $this->model_rhh_funciones->obtener_todos('rhh_cargo');
        $this->load->view('template/header', $data);
        $this->load->view('index', array(
            'cargos' => $cargos ));
        $this->load->view('template/footer');
    }

    public function nuevo($cargo = null, $action = 'cargo/agregar')
    {
        $data["title"]='Control de Asistencia - Jornadas - Agregar';
        //$header = $this->dec_permiso->load_permissionsView();
        $this->load->view('template/header', $data);
        $this->load->view('nuevo', array(
            'cargo' => $cargo,
            'action' => $action));
        $this->load->view('template/footer');
    }

    public function modificar($ID)
    {
        //obtener los datos del modelo
        $cargo = $this->model_rhh_cargo->obtener_cargo($ID);

        //Devolverlos a la vista
        if ($cargo == null) {
            $mensaje = "<div class='alert alert-danger well-sm' role='alert'><i class='fa fa-exclamation fa-2x pull-left'></i>El Cargo que intenta modificar no existe.</div>";
            $this->session->set_flashdata("mensaje", $mensaje);
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
        $codigo = $this->input->post('codigo_cargo');
        $nombre = $this->input->post('nombre_cargo');
        $tipo = $this->input->post('tipo_cargo');
        $descripcion = $this->input->post('descripcion_cargo');

        $cargo = array(
            'codigo' => $codigo,
            'nombre' => $nombre,
            'tipo' => $tipo,
            'descripcion' => $descripcion
        );

        /* Esta función recibe 'nombre_tabla' donde se guardaran los datos pasados por $jornada */
        if ($this->model_rhh_cargo->existe($codigo)) {
            $mensaje = "<div class='alert alert-danger well-sm' role='alert'><i class='fa fa-exclamation fa-2x pull-left'></i>Ya existe una entrada con el mismo nombre y tipo.</div>";
        }else{
            $this->model_rhh_funciones->guardar('rhh_cargo', $cargo);
            $mensaje = "<div class='alert alert-success well-sm' role='alert'><i class='fa fa-check fa-2x pull-left'></i>Se ha agregado el cargo de forma correcta.</div>";
        }
        
        $this->session->set_flashdata("mensaje", $mensaje);
        redirect('cargo');
    }

    public function actualizar()
    {
        $ID = $this->input->post('ID');
        $codigo = $this->input->post('codigo_cargo');
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
        $mensaje = "<div class='alert alert-success well-sm' role='alert'><i class='fa fa-check fa-2x pull-left'></i>Se ha modificado el cargo de forma correcta.</div>";
        $this->session->set_flashdata("mensaje", $mensaje);
        redirect('cargo');
    }

    public function eliminar($ID)
    {
        if ($this->model_rhh_funciones->existe_como('rhh_cargo','ID',$ID, null)) {
            $this->model_rhh_funciones->eliminar('rhh_cargo', $ID);
            $mensaje = "<div class='alert alert-success well-sm' role='alert'><i class='fa fa-check fa-2x pull-left'></i>Se ha eliminado el cargo de forma correcta.<br></div>";
        }else{
            $mensaje = "<div class='alert alert-danger well-sm' role='alert'><i class='fa fa-exclamation fa-2x pull-left'></i>Un error impidio que se lleve acabo la operación</div>";
        }
        $this->session->set_flashdata("mensaje", $mensaje);
        redirect('cargo');
    }

}