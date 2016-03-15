<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Template extends MX_Controller
{
	function __construct() //constructor predeterminado del controlador
    {
        parent::__construct();
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
        // echo($this->session->userdata('user')['id_usuario']);
        
        echo "true";

        // echo json_encode($array);
        // if ($this->input->post('data'))
        // {
        //     echo $this->input->post('data');
        // }
    }

}