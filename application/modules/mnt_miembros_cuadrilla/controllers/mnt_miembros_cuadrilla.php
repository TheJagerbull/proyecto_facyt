<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mnt_miembros_cuadrilla extends MX_Controller {

    function __construct() { //constructor predeterminado del controlador
        parent::__construct(); //carga los helpers
        $this->load->helper('array');
        $this->load->library('form_validation');
        $this->load->library('pagination');
        $this->load->model('model_mnt_miembros_cuadrilla'); //cargar los modelos de los cuales se necesitan datos
        $this->load->model('mnt_tipo/model_mnt_tipo_orden', 'model_tipo');
        $this->load->model('dec_dependencia/model_dec_dependencia', 'model_dependen');
        $this->load->model('mnt_ubicaciones/model_mnt_ubicaciones_dep', 'model_ubicacion');
        $this->load->model('mnt_cuadrilla/model_mnt_cuadrilla', 'model_cuadrilla');
        $this->load->model('mnt_asigna_cuadrilla/model_mnt_asigna_cuadrilla', 'model_asigna');
        $this->load->model('mnt_miembros_cuadrilla/model_mnt_miembros_cuadrilla', 'model_miembros_cuadrilla');
        $this->load->model('user/model_dec_usuario', 'model_user');
        $this->load->model('mnt_estatus/model_mnt_estatus', 'model_estatus');
        $this->load->model('mnt_ayudante/model_mnt_ayudante');
    }

    public function get_cuad_assigned() {
        $id = $this->input->post('id');
        $num_sol = $this->input->post('solicitud');
        ?>
        <label class="control-label" for = "responsable">Miembros de la Cuadrilla</label>
        <table id="cuad_assigned<?php echo $num_sol ?>" name="cuadrilla" class="table table-hover table-bordered table-condensed">
            <thead>
                <tr>       
                    <th><div align="center">Nombre></div></th>
                    <th><div align="center">Apellido</div></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $asignados = $this->model_mnt_ayudante->ayudantesDeCuadrilla_enOrden($num_sol, $id);
                foreach ($asignados as $miem):
                    $nom['nombre'] = $this->model_user->get_user_cuadrilla($miem['id_trabajador']);
                    $nombre = explode(" ", $nom['nombre']);
                    ?>
                    <tr>
                        <td>
                            <?php echo($nombre['0']); ?>
                        </td>
                        <td> <?php echo($nombre['1']); ?>   </td> 
                    </tr><?php endforeach; ?>
            </tbody> 
        </table>
        <?php
    }

}
