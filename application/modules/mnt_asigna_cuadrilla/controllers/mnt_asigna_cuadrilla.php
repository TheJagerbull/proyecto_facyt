<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mnt_asigna_cuadrilla extends MX_Controller {

    function __construct() { //constructor predeterminado del controlador
        parent::__construct(); //carga los helpers
        $this->load->helper('array');
        $this->load->library('form_validation');
        $this->load->library('pagination');
        $this->load->model('model_mnt_asigna_cuadrilla', 'model_asigna'); 
        $this->load->model('mnt_tipo/model_mnt_tipo_orden', 'model_tipo');
        $this->load->model('dec_dependencia/model_dec_dependencia', 'model_dependen');
        $this->load->model('mnt_ubicaciones/model_mnt_ubicaciones_dep', 'model_ubicacion');
        $this->load->model('mnt_cuadrilla/model_mnt_cuadrilla', 'model_cuadrilla');
        $this->load->model('mnt_asigna_cuadrilla/model_mnt_asigna_cuadrilla', 'model_asigna');
        $this->load->model('mnt_miembros_cuadrilla/model_mnt_miembros_cuadrilla', 'model_miembros_cuadrilla');
        $this->load->model('user/model_dec_usuario', 'model_user');
        $this->load->model('mnt_estatus_orden/model_mnt_estatus_orden', 'model_estatus');
    }

    public function get_responsable() {
        if ($this->input->post('id')):
            $vienenombre = $this->input->post('id');
            //echo_pre($vienenombre);
            $cuadrilla = $this->model_cuadrilla->get_cuadrillas();
            $i = 0;
            foreach ($cuadrilla as $cua):
                if ($vienenombre == $cua->id):
                    $id[$i]['nombre'] = $this->model_user->get_user_cuadrilla($cua->id_trabajador_responsable);
                    $cua->nombre = $id[$i]['nombre'];
                    echo $cua->nombre;
                    $id_cuad = $cua->id;
                endif;
                $i++;
            endforeach;

        endif;
    }

    public function mostrar_cuadrilla() {
        if ($this->input->post('id')):
            $id_cuadrilla = $this->input->post('id');
            $miembros = $this->model_miembros_cuadrilla->get_miembros();
            $i = 0;
            ?>
            <thead>
                <tr>
                    <th>Seleccione </th>
                    <th>Nombre</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>Seleccione</th>
                    <th>Nombre</th>
                </tr>
            </tfoot>
            <?php
            $i = 0;
            foreach ($miembros as $miemb):
                if ($id_cuadrilla == $miemb->id_cuadrilla):
                    $new[$i]['miembros'] = $this->model_user->get_user_cuadrilla($miemb->id_trabajador);
                    $miemb->miembros = $new[$i]['miembros'];
                    ?>
                    <tbody>
                        <tr>
                            <td>
                                <div class="checkbox">
                                    <label>
                                        <input name="campo[]" id="campo[]" type="checkbox" checked="checked" value="<?php echo($miemb->id_trabajador); ?>">
                                    </label>
                                </div></td>
                            <td> <?php echo($miemb->miembros); ?>   </td> 
                        </tr>
                    </tbody>
                    <?php
                endif;
                $i++;
            endforeach;
        endif;
    }

    public function asignar_cuadrilla() {

        if (isset($_POST['campo'])):
            ($user = $this->session->userdata('user')['id_usuario']);
            $var = "2";
            $num_sol = $_POST['num_sol'];
            $cuadrilla = $_POST['cuadrilla_select'];
            $miembros = $_POST['campo'];
//        $responsable = $_POST['responsable'];
            echo_pre($num_sol);
            echo_pre($cuadrilla);
            echo_pre($miembros);
//        echo_pre($responsable);
            $datos = array(
                'id_usuario' => $user,      
                'id_cuadrilla' => $cuadrilla,
                'id_ordenes' => $num_sol); 
            $agregar = $this->model_asigna->set_cuadrilla($datos);
            $datos2 = array(
               'id_estado' => $var);
            $actualizar = $this->model_estatus->change_status($datos2,$num_sol);
            $this->session->set_flashdata('asigna_cuadrilla','success');
            redirect(base_url() . 'index.php/mnt_solicitudes/listar');
         else:
             $this->session->set_flashdata('asigna_cuadrilla','error');
             redirect(base_url() . 'index.php/mnt_solicitudes/listar');
        endif;
    }

}
