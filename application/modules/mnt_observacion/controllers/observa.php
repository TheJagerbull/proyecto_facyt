<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Observa extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('observa_model','observa');
    }

    public function index()
    {
        $this->load->helper('url');
        $this->load->view('observa_view');
    }

    public function ajax_list($id='')
    {
//            echo_pre($id);
        $list = $this->person->get_datatables($id);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $person) {
            $no++;
            $row = array();
//                        if ($id == $person->id_cuadrilla):
                         $row[] = $person->nombre;
             $row[] = $person->apellido;
                         //add html for action
//                         <a class="btn btn-sm btn-primary" href="javascript:void()" title="Edit" onclick="edit_person('."'".$person->id_trabajador."'".')"><i class="glyphicon glyphicon-pencil"></i> Editar</a>
             $row[] = '
                  <a class="btn btn-sm btn-danger" href="javascript:void()" title="Hapus" onclick="delete_person('."'".$person->id_trabajador."'".')"><i class="glyphicon glyphicon-trash"></i> Borrar</a>';
        
             $data[] = $row;
//                        endif;
        }

        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->person->count_all($id),
                        "recordsFiltered" => $this->person->count_filtered($id),
                        "data" => $data,
                );
        //output to json format
//                echo_pre($output);
        echo json_encode($output);
    }

    public function ajax_edit($id)
    {
        $data = $this->person->get_by_id($id);
        echo json_encode($data);
    }

    public function ajax_add()
    {
        $data = array(
                'firstName' => $this->input->post('firstName'),
                'lastName' => $this->input->post('lastName'),
                'gender' => $this->input->post('gender'),
                'address' => $this->input->post('address'),
                'dob' => $this->input->post('dob'),
            );
        $insert = $this->person->save($data);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_update()
    {
        $data = array(
                'firstName' => $this->input->post('firstName'),
                'lastName' => $this->input->post('lastName'),
                'gender' => $this->input->post('gender'),
                'address' => $this->input->post('address'),
                'dob' => $this->input->post('dob'),
            );
        $this->person->update(array('id' => $this->input->post('id')), $data);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_delete($id)
    {
        $this->person->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }

}
