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

    public function asign_help()
	{
		if($_POST)
		{
        	die_pre($_POST);
        }
        else
        {
        	die_pre("WTF!!!!!");
        }
	}
/* End of file mnt_ayudante.php */
/* Location: ./application/modules/mnt_ayudante/controllers/mnt_ayudante.php */
}