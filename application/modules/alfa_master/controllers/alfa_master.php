<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Alfa_master extends MX_Controller
{
     function __construct() {
        parent::__construct();

        $this->load->helper('form');
        $this->load->library('Form_validation');
        $this->load->library('auth_ldap');
        $this->load->helper('url');
        $this->load->library('table');
        
        $this->load->model('Model_usuario_alfa');
       
           
    }

    function index() {
        $this->session->keep_flashdata('tried_to');
        
        //$data['error'] = $this->session->flashdata('error');
        //$this->load->view('template/header');
        $this->login();
        //$this->load->view('template/footer');
    }

    function login($errorMsg = NULL){

        // $this->session->set_userdata('username');

         
        if(!$this->auth_ldap->is_authenticated()) {

        // Set up rules for form validation
            $rules = $this->form_validation;
            $rules->set_rules('username', 'Username', 'required|alpha_dash');
            $rules->set_rules('password', 'Password', 'required');
            
            // Do the login...
            if($rules->run() && $this->auth_ldap->login($rules->set_value('username'),$rules->set_value('password'))){
                // Login WIN!

                if($this->session->userdata('username')){
                    //echo_pre($this->session->all_userdata()); //imprime el array de la data
                   // $this->load->view('template/header');
                  $user = $this->input->post('username');
                 
                  echo $user;
                  //consulta que exitan en bd
                  $user = $this->model_usuario_alfa->existe_user($user);
                  if($user){
                   // permisos en la bd
                    
                  }else{
                   // registrarlo
                  }
                  $this->load->view('auth/header');
                  $this->load->view('auth/home', $user);
                  $this->load->view('auth/footer');
                   // $this->load->view('template/footer');
                    //redirect('welcome_message');
                        
                }else{
                    $this->load->view('template/error_404');
                }
            }else{
                // Login FAIL
               $this->load->view('auth/login_form', array('login_fail_msg'=> 'Error with LDAP authentication.'));
            }
        }else {
                // Already logged in...
                //echo "ya estas registrado";
          $user = $this->input->post('username');
          $user = $this->input->post('username');
                  $this->load->view('auth/header');
                  $this->load->view('auth/home');
                  $this->load->view('auth/footer');
        }
    }

    function logout() {
         $this->load->view('auth/header');

         if($this->session->userdata('logged_in')) {
            $data['name'] = $this->session->userdata('cn');
            $data['username'] = $this->session->userdata('username');
            $data['logged_in'] = TRUE;
            $this->auth_ldap->logout();
        } else {
            $data['logged_in'] = FALSE;
        }


         
          $this->load->view('auth/logout_view', $data);
          $this->load->view('auth/footer');

    }
}