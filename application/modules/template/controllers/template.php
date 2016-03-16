<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Template extends MX_Controller
{
	function __construct() //constructor predeterminado del controlador
    {
        parent::__construct();
        $this->load->model("alm_solicitudes/model_alm_solicitudes");
    }
    //la egne &ntilde;
    //acento &acute;
    public function index()//sin usar todavia
    {

        $header['title'] = 'datos de json';
        $this->load->view('template/testjson',$header);
    }


    public function check_alerts()
    {
        $array['depSol'] = $this->model_alm_solicitudes->get_depAprovedSolicitud();//solicitudes aprobadas de almacen (retorna vacio si no las hay)
        $array['sol'] = $this->model_alm_solicitudes->get_ownAprovedSolicitud();
        // $array['flag'] = "true";
        echo json_encode($array);
        //esta funcion consulta a travez del modelo aquellas solicitudes o funciones necesarias, para "fastidiar" al usuario para que este pendiente
    }

}