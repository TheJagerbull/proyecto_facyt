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
        $mat = '011000000000000000010000000000000000001000000000000000011000000000000000000000000000000000000000000000000000000000000000000000001000000000000000000000000000000000000000000000000000010000000000000000001000000000000000000000000000000000000000000000000000010000000000000000000000000000000000000000000000000000000000000000000000';
        switch ($modulo)
        {
            case 'air':
                $permiso = ($funcion * 18) + 1;
            break;
            case 'alm':
                $permiso = ($funcion * 18) + 2;
            break;
            case 'mnt':
                $permiso = ($funcion * 18) + 3;
            break;
            case 'usr':
                $permiso = ($funcion * 18) + 4;
            break;
            default:
                return(0);
            break;
        }
        return($mat[$permiso]);
    }

    public function asignar_permiso($id_usuario)
    {

    }

    public function parse_permission()
    {

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
    //0  // 0   1   1   0   0   0   0   0   0   0   0   0   0   0   0   0   0   1 //
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

