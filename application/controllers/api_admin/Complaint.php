<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Complaint extends CI_Controller { 
    
    public function __construct()
	{
		parent::__construct();
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: *");
        header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
        header('Content-Type: application/json');
        
        $this->load->model('ModelComplaint');
	}
    
    public function get() {
        $data = $this->ModelComplaint->select_admin();
        return $this->output->set_status_header(200)
            ->set_content_type('application/json')
            ->set_output(json_encode(['data' => $data, 'message' => 'success']));
    }

    public function getDetail() {
        $id = $this->input->post('id');

        $data = $this->ModelComplaint->getWhere(['id' => $id]);
        return $this->output->set_status_header(200)
            ->set_content_type('application/json')
            ->set_output(json_encode(['data' => $data, 'message' => 'success']));
    }

    // public function store() {
    //     $data = $this->ModelComplaint->insert();
    //     return $this->output->set_status_header(200)
    //         ->set_content_type('application/json')
    //         ->set_output(json_encode(['data' => $data, 'message' => 'success']));
    // }    

    public function delete() {
        $data = $this->ModelComplaint->delete();
        return $this->output->set_status_header(200)
            ->set_content_type('application/json')
            ->set_output(json_encode(['data' => $data, 'message' => 'success']));
    }    
}