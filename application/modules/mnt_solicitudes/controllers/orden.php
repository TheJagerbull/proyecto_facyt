<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Orden extends MX_Controller {

    /**
     * 
     * Metodo Construct.
     * 
     * 
     */
    function __construct() { //constructor predeterminado del controlador 
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('mnt_tipo/model_mnt_tipo_orden', 'model_tipo');
        $this->load->model('model_mnt_solicitudes', 'model_sol');
        $this->load->model('mnt_observacion/model_mnt_observacion_orden', 'model_obser'); // llamo al modelo desde su ubicacion (carpeta de ubicacion, nombre del modelo)
        $this->load->model('mnt_ubicaciones/model_mnt_ubicaciones_dep', 'model_ubica');
        $this->load->model('dec_dependencia/model_dec_dependencia', 'model_dependen');
        $this->load->model('mnt_estatus/model_mnt_estatus', 'model_estatus');
        $this->load->model('mnt_estatus_orden/model_mnt_estatus_orden', 'model_estatus_orde');
    }

    public function crear_orden() {

        if ($this->hasPermissionClassA()) {
            $this->nueva_orden_autor();
        } elseif ($this->hasPermissionClassD()) {
            $this->nueva_orden_dep();
        } else {
            $header['title'] = 'Error de Acceso';
            $this->load->view('template/erroracc', $header);
        }
    }

// PARA CREAR UNA NUEVA ORDEN...

    public function nueva_orden_dep() {

        //llamo a las variables de la funcion de consulta de los modelos
        $view['tipo'] = $this->model_tipo->devuelve_tipo();
        $view['ubica'] = $this->model_ubica->get_ubicaciones();
        ($depe = $this->session->userdata('user')['id_dependencia']);
        $view['nombre_depen'] = $this->model_dependen->get_nombre_dependencia($depe);
        $view['id_depen'] = $depe;
              
        //die_pre($depe);
        //defino el permiso del usuario
        if ($this->hasPermissionClassD()) {
            // $HEADER Y $VIEW SON LOS ARREGLOS DE PARAMETROS QUE SE LE PASAN A LAS VISTAS CORRESPONDIENTES
            $header['title'] = 'Crear orden';

            if ($_POST) {
                //se llama al id_dependencia y al usuario con el cual se inicio session
                //($depe = $this->session->userdata('user')['id_dependencia']);
                ($usu = $this->session->userdata('user')['id_usuario']);

                //me devuelve la fecha actual
                $this->load->helper('date');
                $datestring = "%Y-%m-%d %h:%i:%s";
                $time = time();
                $fecha = mdate($datestring, $time);

                //asigno un valor al id del estatus
                $ver = 'id_estado';
                $ver = "1";

                //die_pre($ver);
                //die_pre($depe);
                $post = $_POST;
                //die_pre($post);

                // REGLAS DE VALIDACION DEL FORMULARIO PARA CREAR LA ORDEN
                $this->form_validation->set_error_delimiters('<div class="col-md-3"></div><div class="col-md-7 alert alert-danger" style="text-align:center">', '</div><div class="col-md-2"></div>');
                $this->form_validation->set_message('required', '%s es Obligatorio');
                $this->form_validation->set_rules('nombre_contacto', '<strong>Nombre de Contacto</strong>', 'trim|required');
                $this->form_validation->set_rules('telefono_contacto', '<strong>Telefono de Contacto</strong>', 'trim|required');
                $this->form_validation->set_rules('asunto', '<strong>Titulo de la solicitud</strong>', 'trim|required');
                $this->form_validation->set_rules('descripcion_general', '<strong>Detalles de la solicitud</strong>', 'trim|required');
                $this->form_validation->set_rules('oficina_select', 'trim|required');
                //$this->form_validation->set_rules('observac', '<strong>Observacion</strong>', 'trim|required');
                //$this->form_validation->set_rules('oficina_txt', 'trim|required');

                //die_pre($post);

                if ($this->form_validation->run($this)) {
                    
                    //die_pre($post);
                    //verifica cual de las 2 variables no esta vacia para guardar
                    $aux = 0;
                    if (isset($post['oficina_select'])) {
                        $oficina = $post['oficina_select'];
                        //die_pre($oficina);
                    } else {
                        $oficina = "N/A";
                        $orden = $this->model_ubica->get_oficina_null($depe);
                        $aux=1;
                    }
                    if($aux==1){
                        $ubicacion = $orden;
                    }else{
                        $ubicacion = $oficina;
                    }
                    
                  
                    //arreglo para guardar en tabla mnt_orden_trabajo
                    $data1 = array(
                        'fecha' => $fecha,
                        'id_tipo' => $post['id_tipo'],
                        'nombre_contacto' => strtoupper($post['nombre_contacto']),
                        'telefono_contacto' => $post['telefono_contacto'],
                        'asunto' => strtoupper($post['asunto']),
                        'descripcion_general' => strtoupper($post['descripcion_general']),
                        'dependencia' => $depe,
                        'ubicacion' => $ubicacion,
                        'estatus' => $ver);
                    $orden2 = $this->model_sol->insert_orden($data1);
                    //arreglo para guardar en tabla mnt_observacion_orden
                    $id_orden = $this->generar_no($orden2);// para generar el id a mostrar al usuario
                    $id_string = array (
                        'id_orden' => $id_orden);
                    $this->db->where('id', $orden2);//busca el id correspondiente devuelto en orden2
                    $this->db->update('mnt_orden_trabajo',$id_string);//actualiza en la base de datos este campo
                   if (isset($post['observac'])):
                    $data2 = array(
                        'id_usuario' => $usu,
                        'id_orden_trabajo' => $orden2, //llamo a $orden2 para que devuel el id de orden
                        'observac' => $post['observac']);
                    else:
                         $data2 = array(
                        'id_usuario' => $usu,
                        'id_orden_trabajo' => $orden2);
                     endif;

                    $orden3 = $this->model_obser->insert_orden($data2);
                    //arreglo para guardar en tabla mnt_estatus_orden
                    //die_pre($orden2);
                    $data4 = array(
                        'id_estado' => $ver,
                        'id_orden_trabajo' => $orden2, //llamo a $orden2 para que devuel el id de orden
                        'id_usuario' => $usu,
                        'fecha_p' => $fecha);
                    $orden = $this->model_estatus_orde->insert_orden($data4);



                    if (isset($ubicacion)) {

                        $this->session->set_flashdata('create_orden', 'success');
                        redirect(base_url() . 'index.php/mnt_solicitudes/lista_solicitudes');
                    }
                }
            } //$this->session->set_flashdata('create_orden','error');

            $this->load->view('template/header', $header);
            $this->load->view('mnt_solicitudes/nueva_orden_dep', $view);
            $this->load->view('template/footer');
        } else {
            $header['title'] = 'Error de Acceso';
            $this->load->view('template/erroracc', $header);
        }
    }

    public function nueva_orden_autor() {
       
        //$this->model_sol->get_select_oficina();
        //$this->model_sol->get_select_dependencia();
        //llamo a las variables de la funcion de consulta de los modelos
        $view['tipo'] = $this->model_tipo->devuelve_tipo();
        $view['dependencia'] = $this->model_dependen->get_dependencia();
        //die_pre($orden);
        //defino el permiso del usuario
        if ($this->hasPermissionClassA()) {
            // $HEADER Y $VIEW SON LOS ARREGLOS DE PARAMETROS QUE SE LE PASAN A LAS VISTAS CORRESPONDIENTES
            $header['title'] = 'Crear orden';

            if ($_POST) {
                
                
                ($usu = $this->session->userdata('user')['id_usuario']);

                //me devuelve la fecha actual
                $this->load->helper('date');
                $datestring = "%Y-%m-%d %h:%i:%s";
                $time = time();
                $fecha = mdate($datestring, $time);

                //asigno un valor al id del estatus
                $ver = 'id_estado';
                $ver = "1";

                //die_pre($ver);
                //die_pre($dep);
                $post = $_POST;


                // REGLAS DE VALIDACION DEL FORMULARIO PARA CREAR LA ORDEN
                $this->form_validation->set_error_delimiters('<div class="col-md-3"></div><div class="col-md-7 alert alert-danger" style="text-align:center">', '</div><div class="col-md-2"></div>');
                $this->form_validation->set_message('required', '%s es Obligatorio');
                $this->form_validation->set_rules('nombre_contacto', '<strong>Nombre de Contacto</strong>', 'trim|required');
                $this->form_validation->set_rules('telefono_contacto', '<strong>Telefono de Contacto</strong>', 'trim|required');
                $this->form_validation->set_rules('asunto', '<strong>Asunto</strong>', 'trim|required');
                $this->form_validation->set_rules('descripcion_general', '<strong>Descripcion</strong>', 'trim|required');
                //$this->form_validation->set_rules('observac', '<strong>Observacion</strong>', 'trim|required');
                $this->form_validation->set_rules('oficina_select', 'trim|required');
                $this->form_validation->set_rules('oficina_txt', 'trim|required');

                if ($this->form_validation->run($this)) {
                    $dependen = ($post['dependencia_select']);
                    //die_pre($dependen);
                    //verifica cual de las 2 variables no esta vacia para guardar
                    $aux = 0;
                    if (isset($post['oficina_select'])) {
                        $oficina = $post['oficina_select'];
                    } else {
                        $oficina = $post['oficina_txt'];
                        $data3 = array(
                        'id_dependencia' => $dependen,
                        'oficina' => $oficina);
                        //$orden = $this->model_ubica->insert_orden($data3);
                       $aux=1;
                    }
                    if($aux==1){
                        $ubicacion = $orden;
                    }else{
                        $ubicacion = $oficina;
                    }
                    //die_pre($data3);
                    //arreglo para guardar en tabla mnt_orden_trabajo
                    $data1 = array(
                       'fecha' => $fecha,
                        'id_tipo' => $post['id_tipo'],
                        'nombre_contacto' => strtoupper($post['nombre_contacto']),
                        'telefono_contacto' => $post['telefono_contacto'],
                        'asunto' => strtoupper($post['asunto']),
                        'descripcion_general' => strtoupper($post['descripcion_general']),
                        'dependencia' => $dependen,
                        'ubicacion' => $ubicacion,
                        'estatus' => $ver);
                    $orden2 = $this->model_sol->insert_orden($data1);
                    //arreglo para guardar en tabla mnt_observacion_orden
                    $id_orden = $this->generar_no($orden2);// para generar el id a mostrar al usuario
                    $id_string = array (
                        'id_orden' => $id_orden);
                    $this->db->where('id', $orden2);//busca el id correspondiente devuelto en orden2
                    $this->db->update('mnt_orden_trabajo',$id_string);//actualiza en la base de datos este campo
                    $data2 = array(
                        'id_usuario' => $usu,
                        'id_orden_trabajo' => $orden2); //llamo a $orden2 para que devuel el id de orden
                        //'observac' => $post['observac']);
                    $orden3 = $this->model_obser->insert_orden($data2);
                    //arreglo para guardar en tabla mnt_estatus_orden
                    //die_pre($orden2);
                    $data4 = array(
                        'id_estado' => $ver,
                        'id_orden_trabajo' => $orden2, //llamo a $orden2 para que devuel el id de orden
                        'id_usuario' => $usu,
                        'fecha_p' => $fecha);
                    $orden5 = $this->model_estatus_orde->insert_orden($data4);
                    

                    if (isset($ubicacion)) {
                        $this->session->set_flashdata('create_orden', 'success');
                        //die_pre($this->session->flashdata('create_orden'));
                        redirect(base_url() . 'index.php/mnt_solicitudes/lista_solicitudes');
                    }
                }
            } //$this->session->set_flashdata('create_orden','error');
            $this->load->view('template/header', $header);
            $this->load->view('mnt_solicitudes/nueva_orden_autor', $view);
            $this->load->view('template/footer');
        } else {
            $header['title'] = 'Error de Acceso';
            $this->load->view('template/erroracc', $header);
        }
    }

    ////////////////////////Control de permisologia para usar las funciones
    public function hasPermissionClassA() {//Solo si es usuario autoridad y/o Asistente de autoridad
        return ($this->session->userdata('user')['sys_rol'] == 'autoridad' || $this->session->userdata('user')['sys_rol'] == 'asist_autoridad');
    }

    public function hasPermissionClassB() {//Solo si es usuario "Director de Departamento" y/o "jefe de Almacen"
        return ($this->session->userdata('user')['sys_rol'] == 'director_dep' || $this->session->userdata('user')['sys_rol'] == 'jefe_alm');
    }

    public function hasPermissionClassC() {//Solo si es usuario "Jefe de Almacen"
        return ($this->session->userdata('user')['sys_rol'] == 'jefe_alm');
    }

    public function hasPermissionClassD() {//Solo si es usuario "Director de Departamento"
        return ($this->session->userdata('user')['sys_rol'] == 'director_dep');
    }

    public function isOwner($user = '') {
        if (!empty($user) || $this->session->userdata('user')) {
            return $this->session->userdata('user')['ID'] == $user['ID'];
        } else {
            return FALSE;
        }
    }
    public function generar_no($id) {//se utiliza para generar un valor de 9 caracteres de tipo string que sera el numero de la solicitud
//        $aux = $this->model_sol->get_last_id() + 1;
        $nr = str_pad($id, 9, '0', STR_PAD_LEFT); // tomado de http://stackoverflow.com/questions/1699958/formatting-a-number-with-leading-zeros-in-php
        // die_pre($nr);
        return((string) $nr);
    }

    public function select_oficina() {
        if ($this->input->post('departamento')) {
            $dependencia = $this->input->post('departamento');
            $oficina = $this->model_ubica->get_ubicaciones_dependencia($dependencia);
            if (isset($oficina)) {
                foreach ($oficina as $fila) {
                    ?>
                    <option value="<?= $fila->id_ubicacion ?>"><?= $fila->oficina ?></option>
                    <?php
                }
            } else {
                echo '<option value="">N/A</option>';
            }
        }
    }

    ////////////////////////Fin del Control de permisologia para usar las funciones
}
