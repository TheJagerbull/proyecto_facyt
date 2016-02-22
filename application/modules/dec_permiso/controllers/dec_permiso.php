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

    
    //Esta funcion se una para construir el json para el llenado del datatable en la vista de permisos
    function list_user() {
        $results = $this->model_permisos->get_list();//Va al modelo para tomar los datos para llenar el datatable
        echo json_encode($results); //genera la salida de datos
    }
    
    public function load_vista() {
        $header['title'] = 'Asignación de Permisologia de Usuarios';
        $this->load->view('template/header', $header);
        $this->load->view('dec_permiso/view_dec_permiso');
        $this->load->view('template/footer');
    }
    
    public function has_permission($modulo, $funcion)//la variable $funcion es un valor entero, del 1 al 17, de acuerdo a las funciones registradas en el modulo
    {
        // $mat = $this->session->userdata('user')['permiso'];
        $mat = $this->model_permisos->get_permission();
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
        switch ($modulo)//pueden haber un maximo de 18 modulos a verificar por permisologia
        {
            case 'air':
                if($mat[1]!=1)//validar que el permiso halla sido asignado desde el sistema y no manualmente
                {
                    $permiso = ($funcion * 18) + 1;//localizo la casilla del permiso correspondiente
                }
                else
                {
                    return 0;
                }
            break;
            case 'alm':
                if($mat[2]!=1)//validar que el permiso halla sido asignado desde el sistema y no manualmente
                {
                    $permiso = ($funcion * 18) + 2;//localizo la casilla del permiso correspondiente
                }
                else
                {
                    return 0;
                }
            break;
            case 'mnt':
                if($mat[3]!=1)//validar que el permiso halla sido asignado desde el sistema y no manualmente
                {
                    $permiso = ($funcion * 18) + 3;//localizo la casilla del permiso correspondiente
                }
                else
                {
                    return 0;
                }
            break;
            case 'usr':
                if($mat[4]!=1)//validar que el permiso halla sido asignado desde el sistema y no manualmente
                {
                    $permiso = ($funcion * 18) + 4;//localizo la casilla del permiso correspondiente
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

    public function asignar_permiso()//COMPLETADO
    {
        if($_POST['id_usuario'])
        {
//             die_pre($_POST, __LINE__, __FILE__);
            $user = $_POST['id_usuario'];//el id del usuario a quien se le asignara el permiso, se usa el post para evitar los pasos por uri
            unset($_POST['id_usuario']);
            $string = '011111111111111111100000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000';
            // echo strlen($string).'</br>';
            foreach ($_POST as $key => $value)
            {
                // echo $key.'</br>';
                switch ($key)
                {
                    case 'air':
                        $string[1] = 0;
                        foreach ($value as $i => $perm)
                        {
                            // echo $i."</br>";
                            $permiso = ($i*18)+1;
                            $string[$permiso]='1';
                        }
                    break;
                    case 'alm':
                        $string[2] = 0;
                        foreach ($value as $i => $perm)
                        {
                            // echo $i."</br>";
                            $permiso = ($i*18)+2;
                            $string[$permiso]='1';
                        }
                    break;
                    case 'mnt':
                        $string[3] = 0;
                        foreach ($value as $i => $perm)
                        {
                            // echo $i."</br>";
                            $permiso = ($i*18)+3;
                            $string[$permiso]='1';
                        }
                    break;
                    case 'usr':
                        $string[4] = 0;
                        foreach ($value as $i => $perm)
                        {
                            // echo $i."</br>";
                            $permiso = ($i*18)+4;////        $permiso -4 = $i*8      ($permiso - 4)/18)
                            $string[$permiso]='1';
                        }
                    break;
                    default:
                        return(0);
                    break;
                }
            }
            // for ($i=0; $i < 324; $i++)
            // {
            //     echo $string[$i];
            //     if($i%18 == 0)
            //     {
            //         echo "</br>";
            //     }
            // }
            // echo "</br>".$string;
            $assign['id_usuario'] = $user;
            $assign['nivel'] = $string;
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
    }

    public function parse_permission($id_usuario)
    {
        $mat = $this->model_permisos->get_permission($id_usuario);

        /////alm[1]
        for ($i=18; $i < 324; $i++)//me salto las primeras 18 casillas del string
        {
            if($mat[$i]== 1)
            {
                if(is_int((($i-1)/18)))//modulo de aires
                {
                    $parse['air'][((($i-1)/18))]= 1;
                }
                if(is_int((($i-2)/18)))//modulo de almacen
                {
                    $parse['alm'][((($i-2)/18))]= 1;
                }
                if(is_int((($i-3)/18)))//modulo de mantenimiento
                {
                    $parse['mnt'][((($i-3)/18))]= 1;
                }
                if(is_int((($i-4)/18)))//modulo de usuario
                {
                    $parse['usr'][((($i-4)/18))]= 1;
                }
                // echo (($i-2)/18).'</br>';
            }
        }
        // echo_pre($parse, __LINE__, __FILE__);
        if(isset($parse))
        {
            return($parse);
        }
        else
        {
            return(0);
        }
    }
    
    public function asignar($id='')
    {
        $aux = $this->parse_permission($id);
        if(!empty($aux))
        {
            $view = $aux;
            // echo_pre($view, __LINE__, __FILE__);
        }
        $view['id'] = $id;
        $view['nombre'] = $this->model_user->get_user_cuadrilla($id);
        $header['title'] = 'Asignación de Permisologia de Usuarios';
        $this->load->view('template/header', $header);
        $this->load->view('dec_permiso/asignar_permisos',$view);
        $this->load->view('template/footer');
    }
}
    ////////////////////////Instrucciones///////////////////////////////
    // los permisos estarán en la BD como un string de 324 caracteres, y representara una
    // matriz imaginaria de 18x18, donde la primera fila de 18 caracteres, seran los modulos
    // el valor 1 representará si tiene permisos sobre ese modulo, y 0 no tiene permiso.
    // las filas siguientes, seran a partir de los caracteres:
    // 19, 37, 55, 73, 91, 109, 127, 145, 163, 181, 199, 217, 235, 253, 271, 289, 307.
    // cada fila es una funcionalidad del modulo, e indica 1 si tiene permiso, y 0 si no.
    ////////////////////FIN DE Instrucciones////////////////////////////
    //////////////////////Permisos//////////////////////////////////////////////////
    //mod//Air Alm Mnt Usr ___ ___ ___ ___ ___ ___ ___ ___ ___ ___ ___ ___ ___ per//
    //0  // 1   0   0   1   1   1   1   1   1   1   1   1   1   1   1   1   1   1 //
    //19 // 0   1   0   0   0   0   0   0   0   0   0   0   0   0   0   0   0   0 //alm20: ver catalogo                     mnt21: ver solicitudes de dependencia
    //37 // 0   0   1   0   0   0   0   0   0   0   0   0   0   0   0   0   0   0 //alm38: ver solicitud                    mnt39: ver solicitudes de todas las dependencias
    //55 // 0   1   1   0   0   0   0   0   0   0   0   0   0   0   0   0   0   0 //alm56: ver solicitud de departamento    mnt57: ver solicitudes de todos los estatus
    //73 // 0   0   0   0   0   0   0   0   0   0   0   0   0   0   0   0   0   0 //alm74: ver historial/reportes           mnt75: ver solicitudes en proceso
    //91 // 0   0   0   0   0   0   0   0   0   0   0   0   0   0   0   0   0   0 //alm92: ver inventario                   mnt93: ver solicitudes cerradas/anuladas
    //109// 0   0   0   0   0   0   0   0   0   0   0   0   0   0   0   0   0   0 //alm110: agregar inventario              mnt111: ver personal asignado
    //127// 0   0   1   0   0   0   0   0   0   0   0   0   0   0   0   0   0   0 //alm128: agregar por archivo             mnt129: ver detalle de solicitud de dependencia
    //145// 0   0   0   0   0   0   0   0   0   0   0   0   0   0   0   0   0   0 //alm146: generar cierre                  mnt147: ver detalle de solicitud adm
    //163// 0   0   0   0   0   0   0   0   0   0   0   0   0   0   0   0   0   0 //alm164: editar articulo                 mnt165: agregar cuadrilla
    //181// 0   1   0   0   0   0   0   0   0   0   0   0   0   0   0   0   0   0 //alm182: editar solicitud                mnt183: agregar ubicacion
    //199// 0   0   1   0   0   0   0   0   0   0   0   0   0   0   0   0   0   0 //alm200: aprobar solicitud               mnt201: crear solicitud de dependencia
    //217// 0   0   0   0   0   0   0   0   0   0   0   0   0   0   0   0   0   0 //alm218: despachar solicitud             mnt219: crear solicitud adm
    //235// 0   0   0   0   0   0   0   0   0   0   0   0   0   0   0   0   0   0 //alm236: enviar solicitud                mnt237: editar solicitudes abiertas
    //253// 0   1   0   0   0   0   0   0   0   0   0   0   0   0   0   0   0   0 //alm254: generar solicitud               mnt255: cambiar estatus de solicitudes
    //271// 0   0   0   0   0   0   0   0   0   0   0   0   0   0   0   0   0   0 //alm272: S/A                             mnt273: asignar personal
    //289// 0   0   0   0   0   0   0   0   0   0   0   0   0   0   0   0   0   0 //alm290: S/A                             mnt291: editar cuadrilla
    //307// 0   0   0   0   0   0   0   0   0   0   0   0   0   0   0   0   0   0 //alm308: S/A                             mnt309: eliminar miembros de cuadrilla
    ///////////////////FIN DE Permisos//////////////////////////////////////////////

