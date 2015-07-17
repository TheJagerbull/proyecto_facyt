<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Controlador Principal Modulo mnt_cuadrilla
 */
class Cuadrilla extends MX_Controller {

    /**
     * Constructor de la clase Cuadrilla
     * =====================
     * @author Jhessica_Martinez  en fecha: 28/05/2015
     */
    public function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->helper('path');
        $this->load->helper('file');
        $this->load->helper('array');
        $this->load->library('form_validation');
        $this->load->library('pagination');
        $this->load->model('model_mnt_cuadrilla', 'model');      //permite consultar los datos de la tabla cuadrilla
        $this->load->model('user/model_dec_usuario', 'model_user');    //permite consultar los datos de los miembros y responsables
        $this->load->model('mnt_miembros_cuadrilla/model_mnt_miembros_cuadrilla', 'model_miembros_cuadrilla');
    }

    /**
     * Index
     * =====================
     * metodo base. Llamado en la vista inicial del modulo cuadrilla.
     * @author Jhessica_Martinez  en fecha: 28/05/2015
     */
    public function index($field = '', $order = '') {

        if ($this->hasPermissionClassA() || $this->hasPermissionClassC()) {

            $header['title'] = 'Ver Cuadrilla';          //	variable para la vista

            if (!empty($field)) {       // 	identifica el campo desde el que se ordenará
                switch ($field) {
                    case 'orden_codigo': $field = 'id';
                        break;
                    case 'orden_nombre': $field = 'cuadrilla';
                        break;
                    case 'orden_responsable': $field = 'id_trabajador_responsable';
                        break;
                    default: $field = 'id';     //	si no seleccionó ninguno, toma mnt_cuadrilla.id 
                        break;
                }
            }
            $order = (empty($order) || ($order == 'asc')) ? 'desc' : 'asc'; //asigna valor asc o des a la variable que ordenará
            $item = $this->model->get_allitem($field, $order);    //llama al modelo para obtener todas las cuadrillas
            $i = 0;
            foreach ($item as $cua):
                $id[$i]['nombre'] = $this->model_user->get_user_cuadrilla($cua->id_trabajador_responsable);
                $cua->nombre = $id[$i]['nombre'];
                $i++;
            endforeach;

            if ($_POST) {
                $view['item'] = $this->buscar_cuadrilla();
            } else {
                $view['item'] = $item;
            }
            $view['order'] = $order;

            //CARGA LAS VISTAS GENERALES MAS LA VISTA DE LISTAR CUADRILLA
            $this->load->view('template/header', $header);
            $this->load->view('mnt_cuadrilla/listar_cuadrillas', $view);
            $this->load->view('template/footer');
        } else {
            $header['title'] = 'Error de Acceso';
            $this->load->view('template/erroracc', $header);
        }
    }

    /**
     * buscar_cuadrilla
     * =====================
     *
     * @author Jhessica_Martínez  en fecha: 28/05/2015
     */
    public function buscar_cuadrilla() {
        if ($_POST) {
            $header['title'] = 'Buscar cuadrilla';
            $post = $_POST;
            return($this->model->buscar_cuadrilla($post['item']));
        } else {
            redirect('mnt_cuadrilla/cuadrilla/index');
        }
    }

    /**
     * detalle_cuadrilla
     * =====================
     * En este metodo, se hace una busqueda de la cuadrilla especificada y 
     * muestra el detalle.
     * Usada en la vista ver_cuadrilla
     * @author Jhessica_Martinez  en fecha: 28/05/2015
     */
    public function detalle_cuadrilla($id = '') {

        $header['title'] = 'Detalle de cuadrilla';
        if (!empty($id)) {
            //consulta todos los datos de una cuadrilla
            $item = $this->model->get_oneitem($id);

            //busca los datos del responsable en el modulo dec_usuario
            $item['nombre'] = $this->model_user->get_user_cuadrilla($item['id_trabajador_responsable']);

            //consulta todos los miembros de la cuadrilla a detallar
            $miembros = $this->model_miembros_cuadrilla->get_miembros_cuadrilla($item['id']);
            //guarda los datos consultados en la variable de la vista
            $view['item'] = $item;
            //se guarda un arreglo con los nombres y apellidos de los miembros de la cuadrilla
            $i = 0;
            foreach ($miembros as $miemb):
                $new[$i]['miembros'] = $this->model_user->get_user_cuadrilla($miemb->id_trabajador);
                $miemb->miembros = $new[$i]['miembros'];
                $i++;
            endforeach;
            //guarda el arreglo con los miembros en la variable de la vista
            $view['miembros'] = $miembros;            //

            $this->load->view('template/header', $header);         //cargando las vistas
            if ($this->session->userdata('item')['id'] == $item['id']) {
                $view['edit'] = TRUE;
                $this->load->view('mnt_cuadrilla/ver_cuadrilla', $view);
            } else {
                if ($this->hasPermissionClassA() || ($this->hasPermissionClassD())) {
                    $view['edit'] = TRUE;
                    $this->load->view('mnt_cuadrilla/ver_cuadrilla', $view);
                } else {
                    $header['title'] = 'Error de Acceso';
                    $this->load->view('template/erroracc', $header);
                }
            }
            $this->load->view('template/footer');
        } else {
            $this->session->set_flashdata('edit_cuadrilla', 'error');
            redirect(base_url() . 'index.php/Cuadrilla/listar');
        }
    }

    /**
     * modificar_cuadrilla
     * =====================
     * @author Jhessica_Martinez  en fecha: 28/05/2015
     */
    public function modificar_cuadrilla() {
        //if($this->session->userdata('item'))
        //{
        if ($_POST) {
            // REGLAS DE VALIDACION DEL FORMULARIO PARA MODIFICAR 
            $this->form_validation->set_error_delimiters('<div class="col-md-3"></div><div class="col-md-7 alert alert-danger" style="text-align:center">', '</div><div class="col-md-2"></div>');
            $this->form_validation->set_message('required', '%s es Obligatorio');
            $this->form_validation->set_rules('id', '<strong>Codigo</strong>', 'trim|required|min_lenght[7]|xss_clean');
            $this->form_validation->set_rules('cuadrilla', '<strong>Descripcion</strong>', 'trim|xss_clean');

            $post = $_POST;

            //print_r($this->form_validation->run($this));
            //die("Llego hast aaqui");
            if ($this->form_validation->run($this)) {

                $iteme = $this->model->edit_item($post);
                if ($iteme != FALSE) {
                    $this->session->set_flashdata('edit_item', 'success');
                    redirect('mnt_cuadrilla/cuadrilla/index');
                }

                $this->detalle_item($post['id']);
            } else {
                $this->session->set_flashdata('edit_item', 'error');
                $this->detalle_item($post['id']);
            }
        }
        //}
        //else
        //{
        //	$header['title'] = 'Error de Acceso';
        //	$this->load->view('template/erroracc',$header);
        //}
    }

    /**
     * eliminar_cuadrilla
     * =====================
     * @author Jhessica_Martinez  en fecha: 28/05/2015
     */
    public function eliminar_cuadrilla($id = '') {
        if ($this->hasPermissionClassA() || $this->hasPermissionClassC()) {
            if (!empty($id)) {
                $response = $this->model->drop_cuadrilla($id);
                if ($response) {
                    $this->session->set_flashdata('drop_itemprv', 'success');
                    redirect(base_url() . 'index.php/mnt_cuadrilla/cuadrilla/index');
                }
            }
            $this->session->set_flashdata('drop_itemprv', 'error');
            redirect(base_url() . 'index.php/mnt_cuadrilla/cuadrilla/index');
        } else {
            $header['title'] = 'Error de Acceso';
            $this->load->view('template/erroracc', $header);
        }
    }

    /**
     * crear_cuadrilla
     * =====================
     * @author Jhessica_Martinez  en fecha: 28/05/2015
     * Modificado por Juan Parra en fecha: 13/07/2015 */
    public function crear_cuadrilla() {
        $this->load->library('upload');
        if ($this->hasPermissionClassA() || $this->hasPermissionClassC()) {
            $obreros = $this->model_user->get_userObrero(); //listado con todos los obreros en la BD
            $view['obreros'] = $obreros;
//                echo_pre($obreros);
            $header['title'] = 'Crear Cuadrilla de Mantenimiento';
            if ($_POST) {
                $post = $_POST;
//                die_pre($post);
                //die_pre($post);
                // REGLAS DE VALIDACION DEL FORMULARIO PARA CREAR UNA CUADRILLA 
                $this->form_validation->set_error_delimiters('<div class="col-md-3"></div><div class="col-md-7 alert alert-danger" style="text-align:center">', '</div><div class="col-md-2"></div>');
                $this->form_validation->set_message('required', '%s es obligatorio');
                $this->form_validation->set_rules('cuadrilla', '<strong>Nombre de la cuadrilla</strong>', 'trim|required|min_lenght[7]|max_length[30]|xss_clean');
                $this->form_validation->set_rules('id_trabajador_responsable', '<strong>id_trabajador_responsable</strong>', 'trim|required|min_lenght[8]|max_length[8]|xss_clean');
                //validando que el nombre de la cuadrilla no exista en la BD
                $this->form_validation->set_rules('cuadrilla', '<strong>Nombre de la cuadrilla</strong>', 'trim|required|xss_clean|is_unique[mnt_cuadrilla.cuadrilla]');
                $this->form_validation->set_message('is_unique', 'El %s ingresado ya esta en uso. Por favor, ingrese otro.');

                //validando que el responsable sea un obrero 
//                foreach ($obreros as $consulta):
//                    if ($consulta['id_usuario'] == $post['id_trabajador_responsable']) {
//                        $verif = 'TRUE';
//                    } else {
//                        $verif = 'FALSE';
//                    }
//                endforeach;
//                if ($this->form_validation->run($this) && $verif == 'TRUE') {
                // SE MANDA EL ARREGLO $POST A INSERTARSE EN LA BASE DE DATOS
                echo_pre($_FILES['archivo']);
        $guardar = './assets/img/mnt';
        $guardar2 = base_url().'assets/img/mnt';
//        echo FCPATH;
        echo_pre($guardar);
         echo_pre($guardar2);
        echo set_realpath($guardar);
        echo symbolic_permissions(fileperms($guardar));

                $mi_imagen = "archivo";
        $config['upload_path'] = './assets/img/mnt/';
        $config['upload_url'] = base_url().'assets/img/mnt/';
        $config['file_name'] = $_FILES['archivo']['name'];
        $config['allowed_types'] = "gif|jpg|jpeg|png";
        $config['max_size'] = "50000";
        $config['max_width'] = "2000";
        $config['max_height'] = "2000";
//        var_dump(is_dir($config['upload_path']));
//        var_dump(is_writable($config['upload_path']));
	$this->load->library('upload', $config);
//        echo_pre($config['upload_path']);
//        $tes = (base_url().'assets/img/mnt/');
//        echo_pre('test:'.$tes);
//        echo_pre($config);
//        move_uploaded_file($_FILES['archivo']['tmp_name'], $guardar.$_FILES['archivo']['name']);
       
        if (!$this->upload->do_upload($mi_imagen)) {
            //*** ocurrio un error
            $data['uploadError'] = $this->upload->display_errors();
            echo $this->upload->display_errors();
            return;
        }
                    
        $data['uploadSuccess'] = $this->upload->data();
        
        
//                $data = array('upload_data' => $this->upload->data());
               // $uploaddir = base;
            
//                move_uploaded_file($_FILES['archivo']['tmp_name'],$dir= ("notimage/" . md5(rand() * time()) . $_FILES["img"]["name"]));  
//                echo_pre($guardar);
                echo_pre($_FILES['archivo']['name']);
                
                die_pre($post);
                $datos = array(//Guarda la cuadrilla en la tabla respectiva----Falta agregar la opcion de subir un icono
                    'id_trabajador_responsable' => $post['id_trabajador_responsable'],
                    'cuadrilla' => $post['cuadrilla'],
                    'icono'=>$guardar
                );
                $item1 = $this->model->insert_cuadrilla($datos);
                $id_ayudantes = $post['id_ayudantes'];
                array_unshift($id_ayudantes, $post['id_trabajador_responsable']);
                $id_ayudantes = array_values($id_ayudantes);
                foreach ($id_ayudantes as $ayu):
                    $datos2 = array(
                        'id_cuadrilla' => $item1,
                        'id_trabajador' => $ayu
                    );
                    $this->model_miembros_cuadrilla->guardar_miembros($datos2);
                endforeach;
                if ($item1 != 'FALSE') {
                    $this->session->set_flashdata('new_cuadrilla', 'success');
                    redirect(base_url() . 'index.php/mnt_cuadrilla/cuadrilla/index');
                } else {
                    $this->session->set_flashdata('new_cuadrilla', 'error');
                    $this->load->view('template/header', $header);
                    $this->load->view('mnt_cuadrilla/nueva_cuadrilla');
                    $this->load->view('template/footer');
                }
            } else {
                $this->load->view('template/header', $header);
                $this->load->view('mnt_cuadrilla/nueva_cuadrilla', $view);
                $this->load->view('template/footer');
            }
        } else {
            $header['title'] = 'Error de Acceso';
            $this->load->view('template/erroracc', $header);
        }
    }

//Juan Parra
    public function listar_ayudantes() {
        if (!empty($this->input->post('cuad'))):
            $id = $this->input->post('id');
            $nombre = $this->input->post('cuad');
            $existe = $this->model->existe_cuadrilla($nombre);
          if ((!empty($id))):
            if ($existe != 'TRUE'):
                $directory = base_url()."assets/img/mnt";
                $images = glob($directory . ".jpg")
                ?>
                <style>
                    .glyphicon:before {
                        visibility: visible;
                    }
                    .glyphicon.glyphicon-minus:checked:before {
                        content: "\e013";
                    }
                    input[type=checkbox].glyphicon{
                        visibility: hidden;        
                    }
                </style>
                <label class="control-label" for = "responsable">Asignar ayudantes</label>
                <table id="cargos" name="cuadrilla" class="table table-hover table-bordered table-condensed">
                    <thead>
                        <tr> 
                            <th><div align="center">Seleccione</div></th>
                            <th><div align="center">Nombre</div></th>
                            <th><div align="center">Apellido</div></th>
                            <th><div align="center">Cargo</div></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $ayudantes = $this->model_user->get_userObrero();
                        foreach ($ayudantes as $ayu):
                            if ($ayu['id_usuario'] == $id):
                                $cargo = $ayu['cargo'];
                            endif;
                        endforeach;
                        if (!empty($cargo)):
                            foreach ($ayudantes as $ayu):
                                if ($ayu['id_usuario'] != $id && $cargo == $ayu['cargo']):
                                    ?>
                                    <tr>
                                        <td>
                                           <div align="center"><input type="checkbox" value="<?php echo $ayu['id_usuario'] ?>"name="id_ayudantes[]" class="glyphicon glyphicon-minus" ></div>
                                        </td>
                                        <td><div align="center"><?php echo($ayu['nombre']); ?> </div></td>
                                        <td><div align="center"><?php echo($ayu['apellido']); ?> </div>  </td> 
                                        <td><div align="center"><?php echo($cargo); ?> </div>  </td>
                                    </tr>
                                    <?php
                                endif;
                            endforeach;
                        endif;
                        ?>
                    </tbody> 
                </table>
                <div class="form-group">
                    <input id="file-3" name="archivo" type="file" multiple=true class="file-loading">
                </div>
                <div class="form-group">
                    <button class="btn btn-default" type="reset">Reset</button>
                </div>
        <?php            
            else:
                echo ('Esta cuadrilla ya existe');
            endif;
          endif;
        else:
            echo ('Debe escribir el nombre de la cuadrilla');
        endif;
    }

            //--------------------------------------------Control de permisologia para usar las funciones
    //Para usuario = autoridad y/o Asistente de autoridad
    public function hasPermissionClassA() {
        return ($this->session->userdata('user')['sys_rol'] == 'autoridad' || $this->session->userdata('user')['sys_rol'] == 'asist_autoridad');
    }

    //Para usuario = "Director de Departamento" y/o "jefe de Almacen"
    public function hasPermissionClassB() {
        return ($this->session->userdata('user')['sys_rol'] == 'director_dep' || $this->session->userdata('user')['sys_rol'] == 'jefe_alm');
    }

    //Para usuario = "Jefe de Almacen"
    public function hasPermissionClassC() {
        return ($this->session->userdata('user')['sys_rol'] == 'jefe_alm');
    }

    //Para usuario = "Director de Departamento"
    public function hasPermissionClassD() {
        return ($this->session->userdata('user')['sys_rol'] == 'director_dep');
    }

    public function isOwner($user = '') {
        if (!empty($user) || $this->session->userdata('user')) {
            return $this->session->userdata('user')['ID'] == $user['ID'];
        } else {
            return FALSE;
        }
    }

    //-----------------------------------Fin del Control de permisologia para usar las funciones
    //----------------------------Usado para el campo de autocompletado de la vista de cuadrilla (dec_usuarios)
    public function ajax_likeSols() {
        $cuadrilla = $this->input->post('item');            // item es el name del input en la vista
        header('Content-type: application/json');
        $query = $this->model->ajax_likeSols($cuadrilla);  // pasa la variable al modelo para buscarla en la tabla mnt_cuadrilla
        $query = objectSQL_to_array($query);
        echo json_encode($query);
    }

}
