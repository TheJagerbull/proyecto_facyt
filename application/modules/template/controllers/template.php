<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Template extends MX_Controller
{
	function __construct() //constructor predeterminado del controlador
    {
        parent::__construct();
        $this->load->model("alm_solicitudes/model_alm_solicitudes");
        $this->load->model("mnt_solicitudes/model_mnt_solicitudes");
        $this->load->module('dec_permiso/dec_permiso');
        $this->load->module('alm_solicitudes/alm_solicitudes');
    }
    //la egne &ntilde;
    //acento &acute;
    public function index()//sin usar todavia
    {

        $header['title'] = 'Comet Programing';
        $this->load->view('template/testjson',$header);
    }

    public function under_construction()
    {
        $this->load->view('template/mantenimiento2');
    }

    public function check_alerts()//una funcion para las alertas del sistema
    {
        //para usarlo se declara una variable en el arreglo "$array", que se llevara algo del modelo, o nada
        //luego se consulta como lleno o vacio en el script "mainFunctions.js" linea 924
        if($this->dec_permiso->has_permission('alm', 3))
        {
            $array['depSol'] = $this->model_alm_solicitudes->get_depAprovedSolicitud();//solicitudes aprobadas de almacen (retorna vacio si no las hay)
        }
        if($this->dec_permiso->has_permission('alm', 14))
        {
            $array['despSol'] = $this->model_alm_solicitudes->get_depServedSolicitud();//solicitudes aprobadas de almacen (retorna vacio si no las hay)
        }
        // $array['sol'] = $this->model_alm_solicitudes->get_ownAprovedSolicitud();
        if($this->dec_permiso->has_permission('mnt', 7))
        {
            $array['calificar'] = $this->model_mnt_solicitudes->get_califica();// me retorna las calificaciones vacias
        }
        // $array['flag'] = "true";
        echo json_encode($array);
        //esta funcion consulta a travez del modelo aquellas solicitudes o funciones necesarias, para "fastidiar" al usuario para que este pendiente
    }
    public function not_found()
    {
        $this->load->view('template/error_404.php');
    }
    public function get_serverTime()
    {
        echo json_encode(time()*1000);
    }
    public function error_acceso()
    {
        $this->load->view('template/erroracc.php');
    }
    public function update_cart_session()
    {
        $uri = $this->input->post();
        echo ($this->input->post('uri'));
        $this->alm_solicitudes->updateUserCart();
    }
}