<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mnt_ayudante extends MX_Controller
{
	function __construct() //constructor predeterminado del controlador
    {
        parent::__construct();
        $this->load->library('form_validation');
		$this->load->library('pagination');
		$this->load->model('model_mnt_ayudante');
		$this->load->model('user/model_dec_usuario');
        $this->load->model('mnt_solicitudes/model_mnt_solicitudes');
        $this->load->model('mnt_estatus_orden/model_mnt_estatus_orden');
    }

    public function asign_help()//puede ser usado desde cualquier vista, siempre y cuando el post contenga:
	{
		//un campo que se llame 'uri' que tenga anexo este valor $this->uri->uri_string(), para redireccionar a la vista de donde viene
		//un campo que se llame 'id_trabajador' que es el id del trabajador que se asignara a la orden y
		//un campo que se llame 'id_orden_trabajo' que es el id de la orden de trabajo a la cual se le asigna el ayudante
		if($_POST)
		{
        	// echo_pre($_POST);
        	$uri=$_POST['uri'];
            $num_sol=$_POST['id_orden_trabajo'];
        	unset($_POST['uri']);
            // $this->unassigned($num_sol);//para probar funciones
        	// die_pre($_POST);
            $bool=FALSE;
            if(!array_key_exists('id_trabajador', $_POST))
            {
                $i=0;
                while(!empty($_POST['id_trabajador'.$i]))//para pasar varios id_trabajadores de forma simultanea desde la vista
                {
                    $aux = array(
                        'id_trabajador'=>$_POST['id_trabajador'.$i],
                        'id_orden_trabajo'=>$_POST['id_orden_trabajo']
                        );
                    if(!$this->model_mnt_ayudante->ayudante_en_orden($aux['id_trabajador'], $aux['id_orden_trabajo']))
                    {
                        $bool=$bool+$this->model_mnt_ayudante->ayudante_a_orden($aux);
                    }
                    $i++;
                }
                // die_pre($bool);
            }
            else
            {
                if(!$this->model_mnt_ayudante->ayudante_en_orden($_POST['id_trabajador'], $_POST['id_orden_trabajo']))
                {
                    $bool=$bool+$this->model_mnt_ayudante->ayudante_a_orden($_POST);
                }
                
            }

        	if($bool)
        	{
                $this->load->helper('date');
                $datestring = "%Y-%m-%d %h:%i:%s";
                $time = time();
                $fecha = mdate($datestring, $time);
                //actualizar en mnt_solicitudes
                //fecha (fecha de timestamp), y estatus (2 correspondiente a "EN_PROCESO")
                $update = array(
                'fecha' => $fecha,
                'estatus'=> 2);
                // $this->model_mnt_solicitudes->actualizar_orden($update, $num_sol);
                //guardar en mnt_estatus_orden con valores de:
                //id_estado (respectivo a "EN_PROCESO"), id_orden_trabajo (id de la orden de trabajo), id_usuario (el id del usuario de session), fecha_p (formato timestamp)
                $insert = array(
                    'id_estado' => 2,
                    'id_orden_trabaj' => $num_sol,
                    'id_usuario' => $this->session->userdata('user')['id_usuario'],
                    'fecha_p' => $fecha);
                // $this->model_mnt_estatus_orden->insert_orden($insert);
        		$this->session->set_flashdata('asign_help','success');
        		redirect($uri);
        	}
        	else
        	{
        		$this->session->set_flashdata('asign_help','error');
        		redirect($uri);
        	}
        }
        else
        {
            $header['title'] = 'Error de Acceso';
            $this->load->view('template/erroracc',$header);
        }
	}
    public function assigned($id_orden_trabajo)
    {
        echo_pre($id_orden_trabajo, __LINE__, __FILE__);
        die_pre($this->model_mnt_ayudante->ayudantes_DeOrden($id_orden_trabajo), __LINE__, __FILE__);
        return($this->model_mnt_ayudante->ayudantes_DeOrden($id_orden_trabajo));
    }
    public function unassigned($id_orden_trabajo)
    {
        echo_pre($id_orden_trabajo, __LINE__, __FILE__);
        die_pre($this->model_mnt_ayudante->ayudantes_NoDeOrden($id_orden_trabajo), __LINE__, __FILE__);
        return($this->model_mnt_ayudante->ayudantes_NoDeOrden($id_orden_trabajo));
    }

    public function mostrar_unassigned()
    {
        if ($this->input->post('id')):
            $id_orden_trabajo = $this->input->post('id');
            $ayudantes = $this->model_miembros_cuadrilla->get_miembros();
            ?>

            <label class="control-label" for = "responsable">Ayudantes disponibles</label>
            <table id="disponibles<?php echo $id_orden_trabajo; ?>" name="miembro" class="table table-hover table-bordered table-condensed">
                <thead>
                    <tr>
                        <th><div align="center">Seleccione</div> </th>
            <th>Trabajador</th>
            </tr>
            </thead>
            <?php
            $i = 0;
            foreach ($miembros as $miemb):
                if ($id_cuadrilla == $miemb->id_cuadrilla):
                    $new[$i]['miembros'] = $this->model_user->get_user_cuadrilla($miemb->id_trabajador);
                    if (!empty($new[$i]['miembros'])):  //Valida que esto no retorne vacio, ya que al retornar vacio quiere decir que el trabajador esta inactivo
                        $miemb->miembros = $new[$i]['miembros'];
                        ?>
                        <tbody>
                            <tr>
                                <td>
                                    <div align="center">
                                        <div class="checkbox">
                                            <label class="checkbox-inline">
                                                <input name="campo[]" id="campo[]" type="checkbox" checked="checked" value="<?php echo($miemb->id_trabajador); ?>">
                                            </label>
                                        </div>
                                    </div>
                                </td>
                                <td> <?php echo($miemb->miembros); ?>   </td> 
                            </tr>
                        </tbody>
                        <?php
                    endif;
                    $i++;
                endif;
            endforeach;
            ?>
            </table>
            <?php
        endif;
    }


/* End of file mnt_ayudante.php */
/* Location: ./application/modules/mnt_ayudante/controllers/mnt_ayudante.php */
}