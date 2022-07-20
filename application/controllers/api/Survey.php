<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Survey extends CI_Controller { 
    
    public function __construct()
	{
		parent::__construct();
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: *");
        header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
        header('Content-Type: application/json');
        
        $this->load->model('ModelSurvey');
	}
    
    public function get() {
        $data['soal'] = $this->ModelSurvey->get_soal();
		$data['ass'] = $this->ModelSurvey->get_soal_assisten();
        return $this->output->set_status_header(200)
            ->set_content_type('application/json')
            ->set_output(json_encode(['data' => $data, 'message' => 'success']));
    }   

    public function store() {
        // echo json_encode($_POST);
        $data = $this->ModelSurvey->add_nilai();
		if($data) {
            return $this->output->set_status_header(200)
            ->set_content_type('application/json')
            ->set_output(json_encode(['data' => $data, 'message' => 'success']));
        } else {
            return $this->output->set_status_header(200)
            ->set_content_type('application/json')
            ->set_output(json_encode(['data' => null, 'message' => 'failed']));
        }
    }
}