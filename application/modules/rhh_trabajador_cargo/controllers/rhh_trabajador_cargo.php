<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rhh_trabajador_cargo extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('model_rhh_trabajador_cargo');
    }

}