<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Survei extends CI_Controller { 
    
    public function __construct()
	{
		parent::__construct();
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: *");
        header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
        header('Content-Type: application/json');
        
        $this->load->model('ModelSurvei');
		$this->load->model('ModelSoal');
		$this->load->model('ModelAssisten');
	}
    
    public function select() {
        $data = $this->ModelSurvei->select();
        $total = $this->ModelSurvei->count_filtered();
        return $this->output->set_status_header(200)
            ->set_content_type('application/json')
            ->set_output(json_encode(['data' => $data, 'total' => $total, 'message' => 'success']));
    }

    public function get() {
        $data['soal'] = $this->ModelSurvei->get_soal();
		$data['ass'] = $this->ModelSurvei->get_soal_assisten();
        return $this->output->set_status_header(200)
            ->set_content_type('application/json')
            ->set_output(json_encode(['data' => $data, 'message' => 'success']));
    }   

    public function getSoal() {
        $data = $this->ModelSoal->select();
        return $this->output->set_status_header(200)
            ->set_content_type('application/json')
            ->set_output(json_encode(['data' => $data, 'message' => 'success']));
    }
    
    public function getAssisten() {
        $data = $this->ModelAssisten->select();
        return $this->output->set_status_header(200)
            ->set_content_type('application/json')
            ->set_output(json_encode(['data' => $data, 'message' => 'success']));
    }

    public function getOneAssisten() {
        $data = $this->ModelAssisten->selectOne();
        return $this->output->set_status_header(200)
            ->set_content_type('application/json')
            ->set_output(json_encode(['data' => $data, 'message' => 'success']));
    }  
    
    public function getOneSoal() {
        $data = $this->ModelSoal->selectOne();
        return $this->output->set_status_header(200)
            ->set_content_type('application/json')
            ->set_output(json_encode(['data' => $data, 'message' => 'success']));
    }  

    public function store() {
        $data = $this->ModelSurvei->add_nilai();
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

    public function storeAssisten() {
        // echo json_encode($_POST);
        $data = $this->ModelAssisten->insert();
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

    public function deleteAssisten() {
        $data = $this->ModelAssisten->delete();
        return $this->output->set_status_header(200)
            ->set_content_type('application/json')
            ->set_output(json_encode(['data' => $data, 'message' => 'success']));
    } 

    public function updateStatusAssisten() {
        $data = $this->ModelAssisten->setStatus();
        return $this->output->set_status_header(200)
            ->set_content_type('application/json')
            ->set_output(json_encode(['data' => $data, 'message' => 'success']));
    }

    public function updateAssisten() {
        $data = $this->ModelAssisten->update();
        return $this->output->set_status_header(200)
            ->set_content_type('application/json')
            ->set_output(json_encode(['data' => $data, 'message' => 'success']));
    }

    public function deleteSoal() {
        $data = $this->ModelSoal->delete();
        return $this->output->set_status_header(200)
            ->set_content_type('application/json')
            ->set_output(json_encode(['data' => $data, 'message' => 'success']));
    }   

    public function storeSoal() {
        $data = $this->ModelSoal->insert();
        return $this->output->set_status_header(200)
            ->set_content_type('application/json')
            ->set_output(json_encode(['data' => $data, 'message' => 'success']));
    }

    public function updateStatus() {
        $data = $this->ModelSoal->setStatus();
        return $this->output->set_status_header(200)
            ->set_content_type('application/json')
            ->set_output(json_encode(['data' => $data, 'message' => 'success']));
    }

    public function updateSoal() {
        $data = $this->ModelSoal->update();
        return $this->output->set_status_header(200)
            ->set_content_type('application/json')
            ->set_output(json_encode(['data' => $data, 'message' => 'success']));
    }
}