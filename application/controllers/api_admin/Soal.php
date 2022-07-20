<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Soal extends CI_Controller { 
    
    public function __construct()
	{
		parent::__construct();
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: *");
        header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
        header('Content-Type: application/json');
        
		$this->load->model('ModelSoal');
	}
    
    public function select() {
        $data = $this->ModelSoal->select();
        return $this->output->set_status_header(200)
            ->set_content_type('application/json')
            ->set_output(json_encode(['data' => $data, 'message' => 'success']));
    }
    
    
    public function show($id) {
        $data = $this->ModelSoal->get_where(['id' => $id]);
        return $this->output->set_status_header(200)
            ->set_content_type('application/json')
            ->set_output(json_encode(['data' => $data, 'message' => 'success']));
    }  

    public function delete($id) {
        $data = $this->ModelSoal->delete($id);
        return $this->output->set_status_header(200)
            ->set_content_type('application/json')
            ->set_output(json_encode(['data' => $data, 'message' => 'success']));
    }   

    public function store() {
        $data = $this->ModelSoal->insert();
        return $this->output->set_status_header(200)
            ->set_content_type('application/json')
            ->set_output(json_encode(['data' => $data, 'message' => 'success']));
    }

}