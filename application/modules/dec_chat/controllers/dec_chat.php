<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dec_chat extends MX_Controller
{
    function __construct() //constructor predeterminado del controlador
    {
        parent::__construct();
        // $this->load->library('form_validation');
        // $this->load->library('excel');
        // $this->load->model('model_alm_articulos');
        // $this->load->module('dec_permiso/dec_permiso');
    }

    public function index()
    {
        $this->load->view('chat_main');
    }

    public function ajax()
    {
        if(get_magic_quotes_gpc()){

            // If magic quotes is enabled, strip the extra slashes
            array_walk_recursive($_GET,create_function('&$v,$k','$v = stripslashes($v);'));
            array_walk_recursive($_POST,create_function('&$v,$k','$v = stripslashes($v);'));
        }

        try{

            // Connecting to the database
            DB::init($dbOptions);

            $response = array();

            // Handling the supported actions:

            switch($_GET['action']){

                case 'login':
                    $response = Chat::login($_POST['name'],$_POST['email']);
                break;

                case 'checkLogged':
                    $response = Chat::checkLogged();
                break;

                case 'logout':
                    $response = Chat::logout();
                break;

                case 'submitChat':
                    $response = Chat::submitChat($_POST['chatText']);
                break;

                case 'getUsers':
                    $response = Chat::getUsers();
                break;

                case 'getChats':
                    $response = Chat::getChats($_GET['lastID']);
                break;

                default:
                    throw new Exception('Wrong action');
            }

            echo json_encode($response);
        }
        catch(Exception $e){
            die(json_encode(array('error' => $e->getMessage())));
        }
    }

    public function chatBase($options)
    {
        foreach($options as $k=>$v)
        {
            if(isset($this->$k))
            {
                $this->$k = $v;
            }
        }

    }

    public function chatLine()
    {
        DB::query("
            INSERT INTO webchat_lines (author, gravatar, text)
            VALUES (
                '".DB::esc($this->author)."',
                '".DB::esc($this->gravatar)."',
                '".DB::esc($this->text)."'
        )");

        // Returns the MySQLi object of the DB class

        return DB::getMySQLiObject();
    }
}