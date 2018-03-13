<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

Class Dec_permiso extends MX_Controller{
    
    function __construct() { //constructor predeterminado del controlador
        parent::__construct(); //carga los helpers
        $this->load->helper('array');
        $this->load->library('form_validation');
        $this->load->library('pagination');
        $this->load->model('user/model_dec_usuario', 'model_user');
        $this->load->model('model_dec_permiso', 'model_permisos');
    }
    private $dominio = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H');//se puede definir cualquier otro dominio para el arreglo
    private function modules()//retorna la cantidad de modulos embebidos en el string de permisos
    {
        $permit = $this->deCrypt($this->model_permisos->get_permission('', true));
        if($permit)
        {
            // $this->showMatrix($permit);
            $aux = strlen($permit);
            $modules = $aux/18;
        }
        else
        {
            $modules = 1;
        }
        return($modules);
    }
    private function initString()//inicia el string para asignar permisos, a partir de la cantidad de modulos definidos en la permisologia
    {
        $string='';
        $mods=$this->modules();
        for ($i=0; $i < ($mods*18); $i++)
        {
            if($i>=0 && $i<$mods)
            {
                $string.='1';
            }
            else
            {
                $string.='0';
            }
        }
        // $this->showMatrix($string);
        // die_pre($string);
        return($string);
    }
    private function addModuleMatrix($original, $modules='')//funcion para agregar un modulo de permisos a la estructura
    {
        $newM = '';
        // echo strlen($original)/18;
        if(!isset($modules) || $modules==0)
        {
            $modules=1;
        }
        $tope = strlen($original)/18;
        $j=0;
        for ($i=0; $i < strlen($original); $i++)
        {
            $newM.=$original[$i];
            $j++;
            if($j==$tope)
            {
                if($i==$tope-1)
                {
                    // $newM.= '1';
                    $newM.= str_repeat("1",$modules);
                }
                else
                {
                    // $newM.= '0';
                    $newM.= str_repeat("0",$modules);
                }
                $j=0;

            }
        }
        return($newM);
    }
    private function Crypt($original='')//para encriptar
    {
        // $dominio = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H');//se puede definir cualquier otro dominio para el arreglo
        return($this->model_permisos->crypt($original, $this->dominio));
    }
    private function deCrypt($crypted)//para desencriptar
    {
        // $dominio = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H');//se puede definir cualquier otro dominio para el arreglo
        return($this->model_permisos->translate($crypted, $this->dominio));
    }
    private function showMatrix($string)//para mostrar la matriz
    {
        echo '<br>';
        echo 'length: '.strlen($string).'<br>';
        $m = strlen($string)/18;
        echo 'modules: '.$m.'<br><br>';
        $j=0;
        for ($i=0; $i < strlen($string); $i++)
        {
            echo $string[$i];
            $j++;
            if($j==$m)
            {
                echo "<br>";
                $j=0;
            }
        }
        echo "<br><br>";
    }

    private function update_permits($int='', $how='')//para actualizar los permisos que ya fueron asignados en el sistema
    {
        if($this->session->userdata('user')['id_usuario']=='18781981')
        {
            if(isset($int) && !empty($int) && $int!=0)//define el punto fijo de modulos en uso, a conciencia del programador del sistema
            {

            }
            else
            {
                if($how=='Adjust&Crypt')
                {
                    $flag = 1;
                    $users = $this->model_permisos->get_dec_permiso();
                    foreach ($users as $key => $value)
                    {
                        $original = $value['nivel'];
                        $new = '';
                        for ($i=0; $i < strlen($original); $i++)//me salto las primeras $max_mod casillas del string
                        {
                            if(isset($original[$i+1]))
                            {
                                $new .= $original[$i+1];
                            }
                            else
                            {
                                $new.='0';
                            }
                        }
                        // $resultante['nivel'] = $new;
                        $aux = $this->Crypt($new);
                        $resultante['nivel'] = $aux;
                        $resultante['TIME'] = $value['TIME'];

                        // $this->showMatrix($original);
                        // $this->showMatrix($new);
                        // echo "crypted:<br>".$aux;
                        // $this->showMatrix($this->deCrypt($aux));
                        $flag*=$this->model_permisos->edit_dec_permiso($value, $resultante);
                    }
                    if($flag)
                    {
                        $this->session->set_flashdata('set_permission','success');
                        redirect('usuarios/permisos');
                    }
                    else
                    {

                        $this->session->set_flashdata('set_permission','error');
                        redirect('usuarios/permisos');
                    }
                }
            }
        }

    }
    //Esta funcion se una para construir el json para el llenado del datatable en la vista de permisos
    function list_user()//lista usuarios por datatable
    {
        $results = $this->model_permisos->get_list($this->dominio);//Va al modelo para tomar los datos para llenar el datatable
        echo json_encode($results); //genera la salida de datos
    }
    
    public function load_vista()
    {
        if($this->session->userdata('user'))
        {
            $header['title'] = 'Asignación de Permisos de Usuarios';
            $this->load->view('template/header', $header);
            $this->load->view('dec_permiso/view_dec_permiso');
            $this->load->view('template/footer');
        }
        else
        {
            $header['title'] = 'Error de Acceso';
            $this->load->view('template/erroracc');
        }
    }
    
    public function has_permission($modulo, $funcion='',$id_user='')//la variable $funcion es un valor entero, del 1 al 17, de acuerdo a las funciones registradas en el modulo
    {///IMPORTANTE!!!!!!!!!!!!!!!!
        if($this->session->userdata('user'))
        {
        // $mat = $this->session->userdata('user')['permiso'];
            if(empty($id_user))
            {
                $mat = $this->deCrypt($this->model_permisos->get_permission());
            }
            else
            {
                $mat = $this->deCrypt($this->model_permisos->get_permission($id_user));
            }
        // echo strlen($mat).'</br>';
        // for ($i=0; $i < 324; $i++)
        // {
        //     echo $mat[$i];
        //     if($i%18 == 0)
        //     {
        //         echo "</br>";
        //     }
        // }
        // die_pre($mat);
        // $mat = '011000000000000000010000000000000000001000000000000000011000000000000000000000000000000000000000000000000000000000000000000000001000000000000000000000000000000000000000000000000000010000000000000000001000000000000000000000000000000000000000000000000000010000000000000000000000000000000000000000000000000000000000000000000000';
            if(!is_array($modulo) && !empty($funcion))//para verificar el permiso de la funcion $funcion, en el modulo $modulo
            {
                switch ($modulo)//pueden haber un maximo de 18 modulos a verificar por permisologia
                {
                    case 'air':
                        if($mat[0]!=1)//validar que el permiso halla sido asignado desde el sistema y no manualmente
                        {
                            $permiso = ($funcion * 18) + 0;//localizo la casilla del permiso correspondiente
                        }
                        else
                        {
                            return 0;
                        }
                    break;
                    case 'alm':
                        if($mat[1]!=1)//validar que el permiso halla sido asignado desde el sistema y no manualmente
                        {
                            $permiso = ($funcion * 18) + 1;//localizo la casilla del permiso correspondiente
                        }
                        else
                        {
                            return 0;
                        }
                    break;
                    case 'mnt':
                        if($mat[2]!=1)//validar que el permiso halla sido asignado desde el sistema y no manualmente
                        {
                            $permiso = ($funcion * 18) + 2;//localizo la casilla del permiso correspondiente
                        }
                        else
                        {
                            return 0;
                        }
                    break;
                    case 'usr':
                        if($mat[3]!=1)//validar que el permiso halla sido asignado desde el sistema y no manualmente
                        {
                            $permiso = ($funcion * 18) + 3;//localizo la casilla del permiso correspondiente
                        }
                        else
                        {
                            return 0;
                        }
                    break;
                    case 'mnt2':
                        if($mat[4]!=1)//validar que el permiso halla sido asignado desde el sistema y no manualmente
                        {
                            $permiso = ($funcion * 18) + 4;//localizo la casilla del permiso correspondiente
                        }
                    else
                        {
                            return 0;
                        }
                    break;
                    case 'rhh':
                        if($mat[5]!=1)//validar que el permiso halla sido asignado desde el sistema y no manualmente
                        {
                            $permiso = ($funcion * 18) + 5;//localizo la casilla del permiso correspondiente
                        }
                        else
                        {
                            return 0;
                        }
                    break;
                    case 'tic':
                        if($mat[6]!=1)//validar que el permiso halla sido asignado desde el sistema y no manualmente
                        {
                            $permiso = ($funcion * 18) + 6;//localizo la casilla del permiso correspondiente
                        }
                        else
                        {
                            return 0;
                        }
                    break;
                    case 'tic2':
                        if($mat[7]!=1)//validar que el permiso halla sido asignado desde el sistema y no manualmente
                        {
                            $permiso = ($funcion * 18) + 7;//localizo la casilla del permiso correspondiente
                        }
                        else
                        {
                            return 0;
                        }
                    break;
                    case 'alm2':
                        if($mat[8]!=1)//validar que el permiso halla sido asignado desde el sistema y no manualmente
                        {
                            $permiso = ($funcion * 18) + 8;//localizo la casilla del permiso correspondiente
                        }
                        else
                        {
                            return 0;
                        }
                    break;
                    default:
                        return(0);
                    break;
                }
                // die_pre($mat[$permiso], __LINE__, __FILE__);
                return($mat[$permiso]);//retorno el valor del permiso que se consulta
            }
        }
        else
        {
            $header['title'] = 'Error de Acceso';
            $this->load->view('template/erroracc');
        }
    }
    public function asignar_permiso()//COMPLETADO
    {///IMPORTANTE!!!!!!!!!!!!!!!!
     // die_pre($_POST, __LINE__, __FILE__);luigi 010101111111111111101010000000000000001010000000000000001000000000000000001010000000000000001010000000000000001000000000000000001000000000000000001000000000000000001000000000000000001000000000000000001000000000000000001000000000000000001000000000000000001000000000000000001000000000000000001000000000000000001000000000000000
        if($this->session->userdata('user'))
        {
            if($_POST['id_usuario'])
            {
                // die_pre($_POST, __LINE__, __FILE__);
                $user = $_POST['id_usuario'];//el id del usuario a quien se le asignara el permiso, se usa el post para evitar los pasos por uri
                unset($_POST['id_usuario']);
                // $string = '011111111111111111100000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000';
                $string = $this->initString();
                // echo strlen($string).'</br>';
                foreach ($_POST as $key => $value)
                {
                    // echo $key.'</br>';
                    switch ($key)
                    {
                        case 'air':
                            $string[0] = 0;
                            foreach ($value as $i => $perm)
                            {
                                // echo $i."</br>";
                                $permiso = ($i*18);
                                $string[$permiso]='1';
                            }
                        break;
                        case 'alm':
                            $string[1] = 0;
                            foreach ($value as $i => $perm)
                            {
                                // echo $i."</br>";
                                $permiso = ($i*18)+1;
                                $string[$permiso]='1';
                            }
                        break;
                        case 'mnt':
                            $string[2] = 0;
                            foreach ($value as $i => $perm)
                            {
                                // echo $i."</br>";
                                $permiso = ($i*18)+2;
                                $string[$permiso]='1';
                            }
                        break;
                        case 'usr':
                            $string[3] = 0;
                            foreach ($value as $i => $perm)
                            {
                                // echo $i."</br>";
                                $permiso = ($i*18)+3;////        $permiso -3 = $i*8      ($permiso - 4)/18)
                                $string[$permiso]='1';
                            }
                        break;
                        case 'mnt2':
                            $string[4] = 0;
                            foreach ($value as $i => $perm)
                            {
                                // echo $i."</br>";
                                $permiso = ($i*18)+4;
                                $string[$permiso]='1';
                            }
                        break;
                        case 'rhh':
                            $string[5] = 0;
                            foreach ($value as $i => $perm)
                            {
                                $permiso = ($i*18)+5;
                                $string[$permiso]='1';
                            }
                        break;
                        case 'tic':
                            $string[6] = 0;
                            foreach ($value as $i => $perm)
                            {
                                // echo $i."</br>";
                                $permiso = ($i*18)+6;
                                $string[$permiso]='1';
                            }
                        break;
                        case 'tic2':
                            $string[7] = 0;
                            foreach ($value as $i => $perm)
                            {
                                // echo $i."</br>";
                                $permiso = ($i*18)+7;
                                $string[$permiso]='1';
                            }
                        break;
                        case 'alm2':
                            $string[8] = 0;
                            foreach ($value as $i => $perm)
                            {
                                // echo $i."</br>";
                                $permiso = ($i*18)+8;
                                $string[$permiso]='1';
                            }
                        break;
                        default:
                            return(0);
                        break;
                    }
                }
            }
            // $this->showMatrix($string);
            // die_pre($string, __LINE__, __FILE__);
            $assign['id_usuario'] = $user;
            $assign['nivel'] = $this->Crypt($string);
            if($this->model_permisos->set_permission($assign))
            {
                $this->session->set_flashdata('set_permission','success');
                redirect('usuarios/permisos');
            }
            else
            {
                $this->session->set_flashdata('set_permission','error');
                redirect('usuarios/permisos');
            }
        }
        else
        {
            $this->session->set_flashdata('set_permission','error');
            redirect('usuarios/permisos');
        }
    }

    public function parse_permission($id_usuario='', $modulo='')//3 formas distintas de usar, explicado mas abajo
    {///IMPORTANTE!!!!!!!!!!!!!!!!
        if(empty($id_usuario))
        {
            $id_usuario = $this->session->userdata('user')['id_usuario'];
        }
        $mat = $this->deCrypt($this->model_permisos->get_permission($id_usuario));
        // $mat = '101011111111111111010100000000000000010100000000000000010000000000000000010100000000000000010100000000000000010000000000000000010000000000000000010000000000000000010000000000000000010000000000000000010000000000000000010000000000000000010000000000000000010000000000000000010000000000000000010000000000000000010000000000000000';
        // $max_mod = 18;//numero maximo de modulos en el sistema
        $max_mod = $this->modules();//numero maximo de modulos en el sistema
        $strlength = strlen($mat);//tamano total del string del permiso
        /////alm[1]
        for ($i=$max_mod; $i < $strlength; $i++)//me salto las primeras $max_mod casillas del string
        {
            if($mat[$i]== 1)
            {
                if(is_int((($i)/$max_mod)))//modulo de aires
                {
                    $parse['air'][((($i)/$max_mod))]= 1;
                }
                if(is_int((($i-1)/$max_mod)))//modulo de almacen
                {
                    $parse['alm'][((($i-1)/$max_mod))]= 1;
                }
                if(is_int((($i-2)/$max_mod)))//modulo de mantenimiento
                {
                    $parse['mnt'][((($i-2)/$max_mod))]= 1;
                }
                if(is_int((($i-3)/$max_mod)))//modulo de usuario
                {
                    $parse['usr'][((($i-3)/$max_mod))]= 1;
                }
                if(is_int((($i-4)/$max_mod)))//modulo de mantenimiento continuacion
                {
                    $parse['mnt2'][((($i-4)/$max_mod))]= 1;
                }
                if(is_int((($i-5)/$max_mod)))//modulo de recursos humanos
                {
                    $parse['rhh'][((($i-5)/$max_mod))]= 1;
                }
                if(is_int((($i-6)/$max_mod)))//modulo tic
                {
                    $parse['tic'][((($i-6)/$max_mod))]= 1;
                }
                if(is_int((($i-7)/$max_mod)))//modulo tic2
                {
                    $parse['tic2'][((($i-7)/$max_mod))]= 1;
                }
                if(is_int((($i-8)/$max_mod)))//modulo alm2
                {
                    $parse['tic2'][((($i-8)/$max_mod))]= 1;
                }
                // echo (($i-2)/18).'</br>';
            }
        }
        // die_pre($parse, __LINE__, __FILE__);
        if(isset($parse))
        {
            if(empty($modulo))
            {
                return($parse);
            }
            return(array($modulo => $parse[$modulo]));
        }
        else
        {
            return(NULL);
        }
    }
    
    public function load_permissionsView()
    {///IMPORTANTE!!!!!!!!!!!!!!!!
        $aux = $this->parse_permission($this->session->userdata('user')['id_usuario']);//retorna los permisos de los modulos solicitados
        // echo_pre($aux, __LINE__, __FILE__);
//////////filtro para menu de almacen
        if(!empty($aux['alm'][1])||!empty($aux['alm'][4])||!empty($aux['alm'][5])||!empty($aux['alm'][6])||!empty($aux['alm'][7])||!empty($aux['alm'][8])||!empty($aux['alm'][10]))
        {
            $view['inventario']=1;//alm 1, 4, 5, 6, 7, 8, 10
            if(!empty($aux['alm'][5]))
            {
                $view['actas']=1;
            }
        }
        if(!empty($aux['alm'][2])||!empty($aux['alm'][12])||!empty($aux['alm'][13]))
        {
            $view['solicitudes']=1;//alm 2, 12, 13
        }
        if(!empty($aux['alm'][9]))
        {
            $view['almGenerarSolicitud']=1;//alm 9
        }
        if(!empty($aux['alm'][3])||!empty($aux['alm'][11])||!empty($aux['alm'][14]))
        {
            $view['solicitudesDependencia']=1;//alm 3, 11, 14
        }
//////////fin de filtro para menus de almacen
//////////filtro para menu de mantenimiento
        if((!empty($aux['mnt'][1]) || !empty($aux['mnt'][2]))):
            $view['mntGenerarSolicitud']=1;//mnt
        endif;  
        if((!empty($aux['mnt'][3]) || !empty($aux['mnt'][6]) || !empty($aux['mnt2'][1]) || !empty($aux['mnt2'][2]))):
            $view['AdministrarCuadrilla']=1;//mnt 3, 6, y mnt2 1,2
        endif;
        if((!empty($aux['mnt'][4]))):
            $view['agregarUbicaciones']=1;//mnt 4
        endif; 
        if((!empty($aux['mnt'][5]) || !empty($aux['mnt'][7]) || !empty($aux['mnt'][9]) || !empty($aux['mnt'][10]) || !empty($aux['mnt'][11]) || !empty($aux['mnt'][12]) || !empty($aux['mnt'][13]) || !empty($aux['mnt'][14]) || !empty($aux['mnt'][16]) || !empty($aux['mnt'][17]) || !empty($aux['mnt2'][3]))):
            $view['consultarSolicitud']=1;//mnt 5,7,9, 10, 11, 12, 13, 14,16,17 //mnt2 3
        endif;
        if((!empty($aux['mnt'][15]))):
            $view['reportes']=1;//mnt 15
        endif; 
//////////fin de filtro para menu de mantenimiento
//////////filtro para menu tic
        if((!empty($aux['tic'][1]) || !empty($aux['tic'][2]))):
            $view['ticGenerarSolicitud']=1;//mnt
        endif;  
        if((!empty($aux['tic'][3]) || !empty($aux['tic'][6]) || !empty($aux['tic2'][1]) || !empty($aux['tic2'][2]))):
            $view['AdministrarTicCuadrilla']=1;//mnt 3, 6, y mnt2 1,2
        endif;
        if((!empty($aux['tic'][4]))):
            $view['agregarUbicacionesTic']=1;//mnt 4
        endif; 
        if((!empty($aux['tic'][5]) || !empty($aux['tic'][7]) || !empty($aux['tic'][9]) || !empty($aux['tic'][10]) || !empty($aux['tic'][11]) || !empty($aux['tic'][12]) || !empty($aux['tic'][13]) || !empty($aux['tic'][14]) || !empty($aux['tic'][16]) || !empty($aux['tic'][17]) || !empty($aux['tic2'][3]))):
            $view['consultarSolicitudTic']=1;//mnt 5,7,9, 10, 11, 12, 13, 14,16,17 //mnt2 3
        endif;
        if((!empty($aux['tic'][15]))):
            $view['reportesTic']=1;//mnt 15
        endif; 
//////////fin de filtro para menu tic
//////////filtro para menu de aires
            // $view['administracionEquipos']=1;//air
            // $view['tiposEquipos']=1;//air
            // $view['itemsPreventivo']=1;//air
            // $view['controlMantenimiento']=1;//air
            // $view['editarSolicitud']=1;//air
//////////fin de filtro para menu de aires
        if(empty($view))
        {
            return(false);
        }
        else
        {
            return($view);
        }
    }
    public function asignar($id='')
    {
        if($this->session->userdata('user'))
        {
            $aux = $this->parse_permission($id);
            if(!empty($aux))
            {
                $view = $aux;
                // echo_pre($view, __LINE__, __FILE__);
            }
            $view['id'] = $id;
            $view['nombre'] = $this->model_user->get_user_cuadrilla($id);
            $header = $this->load_permissionsView();
            $header['title'] = 'Asignación de Permisos de Usuarios';
            $this->load->view('template/header', $header);
            $this->load->view('dec_permiso/asignar_permisos',$view);///IMPORTANTE!!!!!!!!!!!!!!!!
            $this->load->view('template/footer');
        }
        else
        {
            $header['title'] = 'Error de Acceso';
            $this->load->view('template/erroracc');
        }
    }
    public function UserByPermission($modulo='', $funcion='')//dado un permiso, muestra a los usuarios que lo poseen
    {
        if($this->session->userdata('user'))
        {
            $blah = array('alm' => 1);
            $this->model_dec_permiso->listUserXpermission();
            // $this->load->view('dec_permiso/UserXpermit')
            // die_pre($modulo);
        }
        else
        {
            $header['title'] = 'Error de Acceso';
            $this->load->view('template/erroracc');
        }
    }
    public function testCrypt($original='')
    {
        // die_pre($this->dominio);
        // $this->initString();
        if(!isset($original) || $original=='')
        {
            // $original = $this->model_permisos->get_permission('10131920');
            $original = $this->deCrypt($this->model_permisos->get_permission());
            // $original = str_repeat("1", 558);
        }
        // $dominio = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H');//se puede definir cualquier otro dominio para el arreglo
        $crypt = $this->Crypt($original);
        $decrypt = $this->deCrypt($crypt);
        if(strcmp($original, $decrypt)==0)
        {
            echo "<br>crypt length: ".strlen($crypt);
            echo '<br>crypt: '.$crypt;
        }
        // echo '<br>original: '.$original;
        // echo '<br>decrypt:  '.$decrypt;
        $this->showMatrix($original);
        // $this->showMatrix($decrypt);
    }
    public function test()//para agrandar la tabla de permisos a 30 columnas(modulos), en lugar de 18
    {
        // Adjust&Crypt
        $this->update_permits('', 'Adjust&Crypt');

        //matriz 18x18 = 324, ahora 31x18 = 558
        // $original = $this->model_permisos->get_permission('10131920');
        // $users = $this->model_permisos->get_dec_permiso();
        // foreach ($users as $key => $value)
        // {
        //     $original = $value['nivel'];
        //     $new = '';
        //     for ($i=0; $i < strlen($original); $i++)//me salto las primeras $max_mod casillas del string
        //     {
        //         if(isset($original[$i+1]))
        //         {
        //             $new .= $original[$i+1];
        //         }
        //         else
        //         {
        //             $new.='0';
        //         }
        //     }
        //     // $resultante['nivel'] = $new;
        //     $aux = $this->Crypt($new);
        //     $resultante['nivel'] = $aux;
        //     $resultante['TIME'] = $value['TIME'];

        //     // $this->showMatrix($original);
        //     // $this->showMatrix($new);
        //     // echo "crypted:<br>".$aux;
        //     // $this->showMatrix($this->deCrypt($aux));
        //     $this->model_permisos->edit_dec_permiso($value, $resultante);
        // }
        // $newM =$this->addModuleMatrix($original, 13);

    }
}
//Design By Luigi:
    ////////////////////////Instrucciones///////////////////////////////
    // los permisos estarán en la BD como un string de 324 caracteres, y representara una
    // matriz imaginaria de 18x18, donde la primera fila de 18 caracteres, seran los modulos
    // el valor 1 representará si tiene permisos sobre ese modulo, y 0 no tiene permiso.
    // las filas siguientes, seran a partir de los caracteres:
    // 19, 37, 55, 73, 91, 109, 127, 145, 163, 181, 199, 217, 235, 253, 271, 289, 307.
    // cada fila es una funcionalidad del modulo, e indica 1 si tiene permiso, y 0 si no.
    ////////////////////FIN DE Instrucciones////////////////////////////
    //////////////////////Permisos//////////////////////////////////////////////////
    //mod//    Air Alm Mnt Usr Mnt2 Rhh Tic Tic Alm ___ ___ ___ ___ ___ ___ ___ ___  ___ ___ ___ ___ ___ ___ ___ ___ ___ ___ ___ ___ ___ ___//
    //0  // 0   0   1   1   1   1   1   1   1   1   1   1   1   1   1   1   1   0    1   1   1   1   1   1   1   1   1   1   1   1   1   1  //
    //19 //     0   1   0   0   0   0   0   0   0   0   0   0   0   0   0   0   0    0   0   0   0   0   0   0   0   0   0   0   0   0   0  //alm20:[1] ver catalogo                  alm27: reportar art    mnt21: ver solicitudes de dependencia
    //37 //     0   0   1   0   0   0   0   0   0   0   0   0   0   0   0   0   0    0   0   0   0   0   0   0   0   0   0   0   0   0   0  //alm38:[2] ver solicitud                 alm45:                 mnt39: ver solicitudes de todas las dependencias
    //55 //     0   1   1   0   0   0   0   0   0   0   0   0   0   0   0   0   0    0   0   0   0   0   0   0   0   0   0   0   0   0   0  //alm56:[3] ver solicitud de departamento                        mnt57: ver solicitudes de todos los estatus
    //73 //     0   0   0   0   0   0   0   0   0   0   0   0   0   0   0   0   0    0   0   0   0   0   0   0   0   0   0   0   0   0   0  //alm74:[4] ver historial/reportes                               mnt75: ver solicitudes en proceso
    //91 //     0   0   0   0   0   0   0   0   0   0   0   0   0   0   0   0   0    0   0   0   0   0   0   0   0   0   0   0   0   0   0  //alm92:[5] ver inventario                                       mnt93: ver solicitudes cerradas/anuladas
    //109//     0   0   0   0   0   0   0   0   0   0   0   0   0   0   0   0   0    0   0   0   0   0   0   0   0   0   0   0   0   0   0  //alm110:[6] agregar inventario                                  mnt111: ver personal asignado
    //127//     0   0   1   0   0   0   0   0   0   0   0   0   0   0   0   0   0    0   0   0   0   0   0   0   0   0   0   0   0   0   0  //alm128:[7] agregar por archivo                                 mnt129: ver detalle de solicitud de dependencia
    //145//     0   0   0   0   0   0   0   0   0   0   0   0   0   0   0   0   0    0   0   0   0   0   0   0   0   0   0   0   0   0   0  //alm146:[8] generar cierre                                      mnt147: ver detalle de solicitud adm
    //163//     0   0   0   0   0   0   0   0   0   0   0   0   0   0   0   0   0    0   0   0   0   0   0   0   0   0   0   0   0   0   0  //alm164:[9] editar articulo                                     mnt165: agregar cuadrilla
    //181//     0   1   0   0   0   0   0   0   0   0   0   0   0   0   0   0   0    0   0   0   0   0   0   0   0   0   0   0   0   0   0  //alm182:[10] editar solicitud                                    mnt183: agregar ubicacion
    //199//     0   0   1   0   0   0   0   0   0   0   0   0   0   0   0   0   0    0   0   0   0   0   0   0   0   0   0   0   0   0   0  //alm200:[11] aprobar solicitud                                   mnt201: crear solicitud de dependencia
    //217//     0   0   0   0   0   0   0   0   0   0   0   0   0   0   0   0   0    0   0   0   0   0   0   0   0   0   0   0   0   0   0  //alm218:[12] despachar solicitud                                 mnt219: crear solicitud adm
    //235//     0   0   0   0   0   0   0   0   0   0   0   0   0   0   0   0   0    0   0   0   0   0   0   0   0   0   0   0   0   0   0  //alm236:[13] generar solicitud                                   mnt237: editar solicitudes abiertas
    //253//     0   1   0   0   0   0   0   0   0   0   0   0   0   0   0   0   0    0   0   0   0   0   0   0   0   0   0   0   0   0   0  //alm254:[14] enviar solicitud                                    mnt255: cambiar estatus de solicitudes
    //271//     0   0   0   0   0   0   0   0   0   0   0   0   0   0   0   0   0    0   0   0   0   0   0   0   0   0   0   0   0   0   0  //alm272:[15] anular solicitud                                    mnt273: asignar personal
    //289//     0   0   0   0   0   0   0   0   0   0   0   0   0   0   0   0   0    0   0   0   0   0   0   0   0   0   0   0   0   0   0  //alm290:[16] cancelar solicitud                                  mnt291: editar cuadrilla
    //307//     0   0   0   0   0   0   0   0   0   0   0   0   0   0   0   0   0    0   0   0   0   0   0   0   0   0   0   0   0   0   0  //alm308:[17] retirar solicitud                                   mnt309: eliminar miembros de cuadrilla
    ///////////////////FIN DE Permisos//////////////////////////////////////////////

/////Instrucciones para usar parse_permission($id_usuario='', $modulo='')
/////cuando se llama $this->dec_permiso->parse_permission(), revisara y traducira todos los permisos
/////de todos los modulos del sistema del usuario en session, y lo devolvera en un formato de arreglo de arreglos, donde la
/////primera referencia de arreglos es la de cada modulo, ej: 'alm', 'mnt', 'air', etc.
/////la sub siguiente referencia corresponde con el numero asociado a la funcion de dicho modulo
/////ej: Array
/////   (
/////       [alm] => Array   [alm] => Array
/////         (                (
/////             [1] => 1          [1] => 1
/////             [2] => 1          [2] => 1
/////             [3] => 1          [3] => 1
/////             [4] => 1          [4] => 1
/////             [5] => 1          [5] => 1
/////             [6] => 1          [6] => 1
/////             [7] => 1          [7] => 1
/////             [8] => 1          [8] => 1
/////             [9] => 1          [9] => 1
/////             [10] => 1         [10] => 1
/////             [11] => 1         [11] => 1
/////             [12] => 1         [12] => 1
/////             [13] => 1         [13] => 1
/////             [14] => 1         [14] => 1
/////         )                     [15] => 1
/////                           )
/////   )
/////
/////cuando se llama $this->dec_permiso->parse_permission($id_usuario), revisara, todo lo antes mencionado,
/////pero de un usuario suministrado por la variable $id_usuario.
/////cuando se llama $this->dec_permiso->parse_permission('', 'alm'), revisara solo las funciones del permiso
/////sobre el modulo 'alm', del usuario en session.
/////cuando se llama $this->dec_permiso->parse_permission($id_usuario, 'mnt'), revisara las funciones del permiso
/////sobre el modulo 'mnt', del usuario suministrado.