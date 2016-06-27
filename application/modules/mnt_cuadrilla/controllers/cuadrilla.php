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
        $this->load->helper('array');
        $this->load->library('form_validation');
        $this->load->library('pagination');
        $this->load->model('model_mnt_cuadrilla', 'model');      //permite consultar los datos de la tabla cuadrilla
        $this->load->model('user/model_dec_usuario', 'model_user');    //permite consultar los datos de los miembros y responsables
        $this->load->model('mnt_miembros_cuadrilla/model_mnt_miembros_cuadrilla', 'model_miembros_cuadrilla');
        $this->load->model('mnt_tipo/model_mnt_tipo_orden', 'model_tipo');
        $this->load->module('dec_permiso/dec_permiso');
    }

    /**
     * Index
     * =====================
     * metodo base. Llamado en la vista inicial del modulo cuadrilla.
     * @author Jhessica_Martinez  en fecha: 28/05/2015 //Editado por Juan Carlos Parra e Ilse Moreno
     */
    public function index($field = '', $order = '') {

        if ($this->dec_permiso->has_permission('mnt',3) || $this->dec_permiso->has_permission('mnt',6) || $this->dec_permiso->has_permission('mnt2',2)) {
            if ($this->dec_permiso->has_permission('mnt',3)){
              $view['cuadrilla']=1;
            }else{
              $view['cuadrilla']=0;
            }
            //CARGA LAS VISTAS GENERALES MAS LA VISTA DE LISTAR CUADRILLA
            $header = $this->dec_permiso->load_permissionsView();
            $this->load->view('template/header', $header);
            $this->load->view('mnt_cuadrilla/listar_cuadrillas',$view);
            $this->load->view('template/footer');
        } else {
            $this->session->set_flashdata('permission', 'error');
            redirect('inicio');
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
        if ($this->dec_permiso->has_permission('mnt2',1) ){
            $view['editar']=1;
        }else{
            $view['editar']=0;
        }
        if ($this->dec_permiso->has_permission('mnt', 6)) {
            $view['agregar']=1;
        }else{
            $view['agregar']=0;
        }
        if ($this->dec_permiso->has_permission('mnt2', 2)) {
            $view['eliminar']=1;
        }else{
            $view['eliminar']=0;
        }
        $header['title'] = 'Detalle de cuadrilla';
//        $obreros = $this->model_miembros_cuadrilla->get_miembros_cuadrilla($id); //listado con todos los miembros de la cuadrilla
//            $view['obreros'] = $obreros;
//            echo_pre($obreros);
        if (!empty($id)) {
            //consulta todos los datos de una cuadrilla
            $item = $this->model->get_oneitem($id);
            //busca los datos del responsable en el modulo dec_usuario
            $item['nombre'] = $this->model_user->get_user_cuadrilla($item['id_trabajador_responsable']);
            //echo_pre($item);
            //consulta todos los miembros de la cuadrilla a detallar
//            $item['miembros'] = $this->model_miembros_cuadrilla->get_miembros_cuadrilla($id);
//            $item['ayudantes'] = $this->model_user->get_userObrero();
//            die_pre($miembros);
            //guarda los datos consultados en la variable de la vista
            $view['item'] = $item;
//            echo_pre($view);
            //guarda el arreglo con los miembros en la variable de la vista
            //$view['miembros'] = $miembros;            //
//            echo_pre($view);
            $header = $this->dec_permiso->load_permissionsView();
            $header['title'] = 'Ver Cuadrilla';          // variable para la vista
			$this->load->view('template/header', $header);         //cargando las vistas
            if ($this->session->userdata('item')['id'] == $item['id']) {
                $view['edit'] = TRUE;
                $this->load->view('mnt_cuadrilla/ver_cuadrilla', $view);
            } else {
                if ($this->dec_permiso->has_permission('mnt',3) || $this->dec_permiso->has_permission('mnt',6) || $this->dec_permiso->has_permission('mnt2',2)) {
                    $view['edit'] = TRUE;
                    $this->load->view('mnt_cuadrilla/ver_cuadrilla', $view);
                } else {
                    $this->session->set_flashdata('permission', 'error');
                    redirect('inicio');
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
        echo_pre($_FILES);
        die_pre($_POST);
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
     * Modificado por Juan Parra en fecha: 24/06/2016 */
    public function eliminar_cuadrilla($id = '') {
//        if ($this->hasPermissionClassA() || $this->hasPermissionClassC()) {
          if ($this->dec_permiso->has_permission('mnt',20)) {
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
//        if ($this->hasPermissionClassA() || $this->hasPermissionClassC()) {
        if ($this->dec_permiso->has_permission('mnt',3)){
           
            $obreros = $this->model_user->get_userObrero(); //listado con todos los obreros en la BD
            $view['obreros'] = $obreros;
//                echo_pre($obreros);
            
            if ($_POST) {
                  $post = $_POST;
               // die_pre($post);
                //die_pre($post);
                // REGLAS DE VALIDACION DEL FORMULARIO PARA CREAR UNA CUADRILLA 
                $this->form_validation->set_error_delimiters('<div class="col-md-3"></div><div class="col-md-7 alert alert-danger" style="text-align:center">', '</div><div class="col-md-2"></div>');
                $this->form_validation->set_message('required', '%s es obligatorio');
                $this->form_validation->set_rules('cuadrilla', '<strong>Nombre de la cuadrilla</strong>', 'trim|required|min_lenght[7]|max_length[30]|xss_clean');
                $this->form_validation->set_rules('id_trabajador_responsable', '<strong>id_trabajador_responsable</strong>', 'trim|required|min_lenght[8]|max_length[8]|xss_clean');
                //validando que el nombre de la cuadrilla no exista en la BD
                $this->form_validation->set_rules('cuadrilla', '<strong>Nombre de la cuadrilla</strong>', 'trim|required|xss_clean|is_unique[mnt_cuadrilla.cuadrilla]');
                $this->form_validation->set_message('is_unique', 'El %s ingresado ya esta en uso. Por favor, ingrese otro.');
                // AQUI EMPIEZA EL CODIGO PARA SUBIR IMAGEN
                $dir = './uploads/mnt/'; //para enviar a la funcion de guardar imagen
                $tipo = 'gif|jpg|png|jpeg'; //Establezco el tipo de imagen
                $mi_imagen = 'archivo'; // asigno en nombre del input_file a $mi_imagen
                if($this->model->guardar_imagen($dir,$tipo,$_POST['nombre_img'],$mi_imagen)=='exito'){   
                // AQUI TERMINA
                $ext = ($this->upload->data());
                $ruta = 'uploads/mnt/'.$_POST['nombre_img'].$ext['file_ext'];//para guardar en la base de datos
                $datos = array(//Guarda la cuadrilla en la tabla respectiva tabla----
                    'id_trabajador_responsable' => $post['id_trabajador'],
                    'cuadrilla' => $post['cuadrilla'],
                    'icono'=>$ruta
                );
                $item1 = $this->model->insert_cuadrilla($datos);
                $data = array (//crea el tipo de orden con el nombre de la cuadrilla
                    'tipo_orden' => strtoupper($post['cuadrilla']),
                );
                $this->model_tipo->set_tipo_orden($data);
                $acti_usr = array(
                    'id_usuario' => $post['id_trabajador'],
                    'status' => 'activo',
                    'Cargo' => strtoupper('Jefe de Cuadrilla'),
                    'sys_rol' => 'asistente_dep'
                );
                $this->model_user->edit_user($acti_usr);
                if (isset($post['id_ayudantes'])):
                   $id_ayudantes = $post['id_ayudantes'];
                   array_unshift($id_ayudantes, $post['id_trabajador']);
                   foreach ($id_ayudantes as $ayu):
                    $datos2 = array(
                        'id_cuadrilla' => $item1,
                        'id_trabajador' => $ayu
                    );
                    $this->model_miembros_cuadrilla->guardar_miembros($datos2);
                endforeach;
                else:
                    $id_ayudantes = $post['id_trabajador'];
                    $datos2 = array(
                        'id_cuadrilla' => $item1,
                        'id_trabajador' => $id_ayudantes
                    );
                    $this->model_miembros_cuadrilla->guardar_miembros($datos2);
                endif;
                
//                $id_ayudantes = array_values($id_ayudantes);
                
                if ($item1 != 'FALSE') {
                    $this->session->set_flashdata('new_cuadrilla', 'success');
                    redirect(base_url() . 'index.php/mnt_cuadrilla/cuadrilla/index');
                } else {
                    $this->session->set_flashdata('new_cuadrilla', 'error');
                    $header = $this->dec_permiso->load_permissionsView();
			$this->load->view('template/header', $header);
                    $this->load->view('mnt_cuadrilla/nueva_cuadrilla');
                    $this->load->view('template/footer');
                 }
                }else{
                    $view['error'] = ($this->model->guardar_imagen($dir,$tipo,$_POST['nombre_img'],$mi_imagen));
                    $header = $this->dec_permiso->load_permissionsView();
			$this->load->view('template/header', $header);
                    $this->load->view('mnt_cuadrilla/nueva_cuadrilla', $view);
                    $this->load->view('template/footer');
                }
            } else {
                $header = $this->dec_permiso->load_permissionsView();
                $header['title'] = 'Crear Cuadrilla de Mantenimiento';
			$this->load->view('template/header', $header);
                $this->load->view('mnt_cuadrilla/nueva_cuadrilla', $view);
                $this->load->view('template/footer');
            }
        } else {
            $this->session->set_flashdata('permission', 'error');
            redirect('inicio');
        }
    }

//Juan Parra
    public function listar_ayudantes() {
//        die_pre($this->input->post('nombre'));
//        die_pre($this->input->post('cuad'));
        if (!empty($_POST['cuad'])):
            $trabajador = $this->input->post('nombre');
            $nombre = $this->input->post('cuad');
            $existe = $this->model->existe_cuadrilla($nombre);
          if ((!empty($trabajador))):
            if ($existe != 'TRUE'):
//                $directory = base_url()."assets/img/mnt";
//                $images = glob($directory . ".jpg")
                ?>
<!--                <style>
                     input[type='checkbox'].icon-checkbox{display:none}
                     input[type='checkbox'].icon-checkbox+label .unchecked{display:inline}
                     input[type='checkbox'].icon-checkbox+label .checked{display:none}
                     input[type='checkbox']:checked.icon-checkbox{display:none}
                     input[type='checkbox']:checked.icon-checkbox+label .unchecked{display:none}
                     input[type='checkbox']:checked.icon-checkbox+label .checked{display:inline}
                </style>-->
                
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
//                        die_pre($ayudantes);
                        foreach ($ayudantes as $ayu):
                            $completo = $ayu['nombre'].' '.$ayu['apellido'];
//                             echo $completo;
                            if ($completo == $trabajador):
//                                echo $ayu['id_usuario'];
                                 $id = $ayu['id_usuario'];
//                                 echo_pre ($id);
//                                 if ($ayu['id_usuario'] == $id):
                                $cargo = $ayu['cargo'];
//                              endif;
                            endif;
//                            echo_pre ($id);
                        endforeach;
//                        if (!empty($cargo)):
                            foreach ($ayudantes as $ayu):
                                if ($ayu['id_usuario'] != $id):
                                    ?>
                                    <tr>
                                        
                                        <td>
                                           <div align="center"><input type="checkbox" value="<?php echo $ayu['id_usuario'] ?>" name="id_ayudantes[]"><label for="checkbox1">
<!--                                                   <span style="color:#D9534F" class="glyphicon glyphicon-minus unchecked"></span>
                                                   <span class="glyphicon glyphicon-plus checked color"></span></label></div>-->
                                        </td>
                                        <td><div align="center"><?php echo($ayu['nombre']); ?> </div></td>
                                        <td><div align="center"><?php echo($ayu['apellido']); ?> </div>  </td> 
                                        <td><div align="center"><?php echo($ayu['cargo']); ?> </div>  </td>
                                    </tr>
                                    <?php
                                endif;
                            endforeach;
//                        endif;
                        ?>
                    </tbody> 
                </table>
                <input type="hidden" name="id_trabajador" id="id_trabajador" value="<?php echo $id ?>"> <!--id del trabajador-->
                <div class="row">
                <div class="col-xs-6">
                     
                    <label class="control-label"><i class="color">* </i>Selecciona una imagen <i class="color">* jpg, gif y png de 512 x 512 pixeles </i></label>
                    <input id="file-3" name="archivo" type="file" multiple=true class="file-loading">
                    
                </div>
                <div class="col-xs-12">
                        
                </div>
                <div class="col-xs-3">
                    <label class="control-label"><i class="color">* </i>Nombre de la imagen:</label>
                    <input class="form-control"name="nombre_img" id="nombre_img" type="text">
                </div>
                  <div class="col-xs-12">
                        
                 </div>
                </div>
        <?php            
            else:?>
                <script type="text/javascript"> 
                    var nombre = $("#cuadrilla").val();
                    $("#cuadrilla").removeAttr('disabled');
                    $("#cuadrilla").focus();
                    swal('La cuadrilla '+ nombre+ ' ya existe');
                    $("#cuadrilla").val('');
                    $("#id_trabajador_responsable").select2("val", "");
                </script>  
                <?php // echo '<div class="alert alert-danger" style="text-align: center">Esta cuadrilla ya existe</div>';
            endif;
          endif;
        else:?>
                <script type="text/javascript"> 
                    $("#cuadrilla").removeAttr('disabled');
                    $("#cuadrilla").focus();
                    swal('Debe escribir el nombre de la cuadrilla');
                    $("#id_trabajador_responsable").select2("val", "");
                </script>      
            <?php // echo ('<div class="alert alert-danger" style="text-align: center">Debe escribir el nombre de la cuadrilla</div>');
        endif;
    }

            //--------------------------------------------Control de permisologia para usar las funciones
    //Para usuario = autoridad y/o Asistente de autoridad
    public function hasPermissionClassA() {
        return ($this->session->userdata('user')['sys_rol'] == 'autoridad' || $this->session->userdata('user')['sys_rol'] == 'asist_autoridad'|| $this->session->userdata('user')['sys_rol'] == 'jefe_mnt');
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
    
    public function get_cuadrilla() {
        $results = $this->model->get_allitem();;
         $i = 0;
            foreach ($results as $cua):
                $id[$i]['nombre'] = $this->model_user->get_user_cuadrilla($cua->id_trabajador_responsable);
                $cua->nombre = $id[$i]['nombre'];
                $i++;
            endforeach;
        $data = array();    
        foreach ($results  as $i=> $r):
//            if ($this->dec_permiso->has_permission('mnt',13) || $this->dec_permiso->has_permission('mnt',15)): 
                array_push($data, array(
                    '<a href="'.base_url().'index.php/mnt_cuadrilla/detalle/'. $r->id.'">'.strtoupper($r->cuadrilla).'</a>',
                    $r->nombre
                ));
//            else:
//                array_push($data, array(
//                    $r->cuadrilla,
//                    $r->nombre
//                ));
//            endif;
        endforeach;
        echo json_encode(array('data' => $data));
    }
    
    public function get_json($id='') {
        $results = $this->model_miembros_cuadrilla->get_miembros_cuadrilla($id);
        $data = array();
//        echo_pre($results);
        foreach ($results  as $i=> $r):
            $dos = str_pad($i+1, 2, '0', STR_PAD_LEFT);
            array_push($data, array(
                '<input type="checkbox" value="'.$r->id_trabajador.'"name="id_ayudantes[]" class="glyphicon glyphicon-minus" >',
                $dos,
                $r->trabajador
             ));
        endforeach;
        echo json_encode(array('data' => $data));
    }

    public function ajax_detalle($id = '') {
//            echo_pre($id);
        $list = $this->model->get_datatables($id);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $i=>$person):
            $no++;
//            $dos = str_pad($i+1, 2, '0', STR_PAD_LEFT);
            $row = array();
//            $row[] = $dos;
            $row[] = $person->nombre;
            $row[] = $person->apellido;
//            if ($this->dec_permiso->has_permission('mnt',15)): 
                $row[] = '<a href="javascript:void()" title="Eliminar" style="color:#D9534F" onclick="delete_person(' . "'" . $person->id_trabajador . "'" . ')"><i class="glyphicon glyphicon-remove"></i></a>';
                $data[] = $row;
//            endif;
        endforeach;

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->model->count_all($id),
            "recordsFiltered" => $this->model->count_filtered($id),
            "data" => $data,
        );
        //output to json format
//                echo_pre($output);
        echo json_encode($output);
    }
    
    public function mostrar_unassigned($id='')//Funcion para mostrar a los trabajadores para asignarlos a una cuadrilla en edicion
    {
//       echo_pre($id);
       $asignar = $this->model->get_datos($id);
//       echo_pre($asignar);
       $data = array();
//        echo_pre($results);
        foreach ($asignar  as $i=> $r):
            array_push($data, array(
                $r['id_usuario'],
                $r['nombre'],
                $r['apellido'],
                $r['cargo']
             ));
        endforeach;
        echo json_encode(array('data' => $data));
    }
    
    public function ajax_guardar($cuad)
	{
        if ($this->input->post('id_ayudantes')):
        $id = $this->input->post('id_ayudantes');
        foreach ($id as $i):
		$data = array(
                        'id_cuadrilla' => $cuad,
		        'id_trabajador' => $i
			);
		$insert = $this->model_miembros_cuadrilla->guardar_miembros($data);
        endforeach;
               if($insert):
		echo json_encode(array("status" => TRUE));
               else:
                 echo json_encode(array("status" => FALSE));  
               endif;
        endif;
        }
        
        public function ajax_borrar()
	{
            $id=$this->input->post('id');
            $cuad=$this->input->post('cuad');
		if($this->model_miembros_cuadrilla->borrar_by_id($id,$cuad)):
		  echo json_encode(array("status" => TRUE));
                else:
                  echo json_encode(array("status" => FALSE));
                endif;
	}
     
        public function ajax_edit($id)
    {
        $data = $this->model->get_oneitem($id);
        $data['responsable'] = $this->model_user->get_user_cuadrilla($data['id_trabajador_responsable']);
        $data['obreros'] = $this->model_user->get_userObrero();
        echo json_encode($data);
    }

}

