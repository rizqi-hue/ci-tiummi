<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mahasiswa extends CI_Controller { 
    
    public function __construct()
	{
		parent::__construct();
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: DELETE, POST, GET, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
        header("Content-Type: application/json");
        
        $this->load->model('Mahasiswa_model');
	}

    public function select()
    {
        $data = $this->Mahasiswa_model->select();
        $total = $this->Mahasiswa_model->count_all();

        return $this->output->set_status_header(200)
            ->set_content_type('application/json')
            ->set_output(json_encode(['data' => $data, 'total' => $total,'message' => 'success']));   
    }

    public function store() {
        $data = $this->Mahasiswa_model->store();

        return $this->output->set_status_header(200)
        ->set_content_type('application/json')
        ->set_output(json_encode(['data' => $data, 'message' => 'success']));   
    }

    public function update() {
        $data = $this->Mahasiswa_model->update();
        return $this->output->set_status_header(200)
        ->set_content_type('application/json')
        ->set_output(json_encode(['data' => $data, 'message' => 'success']));   
    }

    public function delete($id) {
        $data = $this->Mahasiswa_model->delete($id);
        return $this->output->set_status_header(200)
        ->set_content_type('application/json')
        ->set_output(json_encode(['data' => $data, 'message' => 'success']));   
    }

    public function show($id)
    {
        $data = $this->Mahasiswa_model->get_where(['id' => $id]);
        return $this->output->set_status_header(200)
            ->set_content_type('application/json')
            ->set_output(json_encode(['data' => $data, 'message' => 'success']));   
    }

}