<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mnt_ayudante extends MX_Controller
{
	function __construct() //constructor predeterminado del controlador
    {
        parent::__construct();
        $this->load->library('form_validation');
		$this->load->library('pagination');
		$this->load->model('model_mnt_ayudante');
		$this->load->model('user/model_dec_usuario');
    }

    public function asign_help()//puede ser usado desde cualquier vista, siempre y cuando el post contenga:
	{
		//un campo que se llame 'uri' que tenga anexo este valor $this->uri->uri_string(), para redireccionar a la vista de donde viene
		//un campo que se llame 'id_trabajador' que es el id del trabajador que se asignara a la orden y
		//un campo que se llame 'id_orden_trabajo' que es el id de la orden de trabajo a la cual se le asigna el ayudante
		if($_POST)
		{
        	// echo_pre($_POST);
        	$uri=$_POST['uri'];
        	unset($_POST['uri']);
        	// die_pre($_POST);
        	if(!$this->model_mnt_ayudante->ayudante_a_orden($_POST))
        	{
        		$this->session->set_flashdata('asign_help','success');
        		redirect($uri);
        	}
        	else
        	{
        		$this->session->set_flashdata('asign_help','error');
        		redirect($uri);
        	}
        }
        else
        {
        	die_pre("WTF!!!!!");
        }
        // redirect("mnt_solicitudes/lista_solicitudes");
	}

/* End of file mnt_ayudante.php */
/* Location: ./application/modules/mnt_ayudante/controllers/mnt_ayudante.php */
}