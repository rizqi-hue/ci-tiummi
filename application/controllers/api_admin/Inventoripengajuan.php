<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Inventoripengajuan extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: *");
        header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
        header('Content-Type: application/json');

		$this->load->model('ModelInventoriPengajuan');
	}
	
	public function select() {
        $data = $this->ModelInventoriPengajuan->select();
        $total = $this->ModelInventoriPengajuan->count_filtered();
        return $this->output->set_status_header(200)
            ->set_content_type('application/json')
            ->set_output(json_encode(['data' => $data, 'total' => $total, 'message' => 'success']));
    }

    public function show($id) {
        $data = $this->ModelInventoriPengajuan->get_where(['id' => $id]);
        return $this->output->set_status_header(200)
            ->set_content_type('application/json')
            ->set_output(json_encode(['data' => $data, 'message' => 'success']));
    }

    public function store() {
        $data = $this->ModelInventoriPengajuan->insert();
        return $this->output->set_status_header(200)
            ->set_content_type('application/json')
            ->set_output(json_encode(['data' => $data, 'message' => 'success']));
    }   

    public function delete($id) {
        $data = $this->ModelInventoriPengajuan->delete($id);
        return $this->output->set_status_header(200)
            ->set_content_type('application/json')
            ->set_output(json_encode(['data' => $data, 'message' => 'success']));
    }  	
}
