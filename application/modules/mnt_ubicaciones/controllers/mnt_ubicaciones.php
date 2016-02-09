<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mnt_ubicaciones extends MX_Controller {

    function __construct() { //constructor predeterminado del controlador
        parent::__construct(); //carga los helpers
        $this->load->helper('array');
        $this->load->library('form_validation');
        $this->load->model('model_mnt_ubicaciones_dep', 'model_ubicacion'); //cargar los modelos de los cuales se necesitan datos
        $this->load->model('mnt_solicitudes/model_mnt_solicitudes', 'model_sol');
        $this->load->model('mnt_tipo/model_mnt_tipo_orden', 'model_tipo');
        $this->load->model('dec_dependencia/model_dec_dependencia', 'model_dependen');
        $this->load->model('user/model_dec_usuario', 'model_user');
    }

    public function agregar_ubicacion() {
        if ($this->hasPermissionClassA()) {
            $view['dependencia'] = $this->model_dependen->get_dependencia();
            $header['title'] = 'Agregar Ubicaciones';
            $this->load->view('template/header', $header);
            $this->load->view('mnt_ubicaciones/agregar', $view);
            $this->load->view('template/footer');
        } else {
            $header['title'] = 'Error de Acceso';
            $this->load->view('template/erroracc', $header);
        }
    }

    public function mostrar_ubicaciones() {
        if ($this->input->post('departamento')):
            $dependencia = $this->input->post('departamento');
//            $nombre = $this->model_dependen->get_nombre_dependencia($dependencia);
            $oficina = $this->model_ubicacion->get_ubicaciones_dependencia($dependencia);
            if (!empty($oficina)):
                ?>
                <div class="form-control" align="center">
                    <p>Ubicaciones</p>
                </div>
                <div class="col-lg-12"> 
                    <table id="ubicaciones" name="ubicaciones" class="table table-hover table-bordered table-condensed">
                        <thead>
                            <tr>
                                <th>Oficina</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($oficina as $fila):
                                    if ($fila->oficina!='N/A'):?> 
                                     <tr>
                                       <td> 
                                        <?php  echo($fila->oficina);?>
                                       </td> 
                                     </tr>
                            <?php   endif;
                                  endforeach; ?>
                        </tbody>

                    </table>
                <?php else :
                    ?>
                    <div class="alert alert-warning" style="text-align: center">No hay ubicaciones en esta Dependencia</div>
            <?php
            endif;?>
               </div>
                              <div class="form-group">
                        <div class="col-lg-8">
                            <div class="input-group col-lg-12">
                                <span class="input-group-addon">
                                    <input type="checkbox"  onclick= "document.orden.oficina_txt.disabled = !document.orden.oficina_txt.disabled;document.orden.guarda.disabled = !document.orden.guarda.disabled">
                                </span>
                                <input type="text" class="form-control"  id="oficina_txt" name="oficina_txt" disabled="true" placeholder="Agregar">
                            </div>
                        </div>

                    </div>
        <?php endif;
    }

    public function guardar_ubicacion() {
        $post = $_POST;
        $dependen = $post['dependencia_agregar'];
//        die_pre($post);
        if (isset($post['oficina_txt'])) {
            $oficina = $post['oficina_txt'];
            $data = array(
                'id_dependencia' => $dependen,
                'oficina' => $oficina);
            $this->model_ubicacion->insert_orden($data);
            $this->session->set_flashdata('create_ubi', 'success');
        } else {
            $this->session->set_flashdata('create_ubi', 'error');
        }
        redirect(base_url() . 'index.php/mnt_ubicaciones/agregar');
    }

////////////////////////Control de permisologia para usar las funciones
    public function hasPermissionClassA() {//Solo si es usuario autoridad y/o Asistente de autoridad
        return ($this->session->userdata('user')['sys_rol'] == 'autoridad' || $this->session->userdata('user')['sys_rol'] == 'asist_autoridad'|| $this->session->userdata('user')['sys_rol'] == 'jefe_mnt');
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

    ////////////////////////Fin del Control de permisologia para usar las funciones
}
