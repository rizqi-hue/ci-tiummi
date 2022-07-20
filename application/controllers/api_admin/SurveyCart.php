<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class SurveyCart extends CI_Controller {

	 public function __construct()
	{
		parent::__construct();
		header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: *");
        header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
        header('Content-Type: application/json');
		$this->load->model('app_model','model');
		$this->load->model('ModelCart','chart');
	}
	public function chart_survey()  
	{
		//chart_model dipanggil menjadi chart
		$data = $this->chart->chart_survey(); 

		return $this->output->set_status_header(200)
		->set_content_type('application/json')
		->set_output(json_encode(['data' => $data, 'message' => 'success']));
	}
	public function chart_survey_assisten()  
	{
		//chart_model dipanggil menjadi chart
		echo $this->chart->chart_survey_assisten(); //
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/media.php */