<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Survei extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('app_model','model');
		$this->load->model('survei_model','survei');
	}

	public function index()
	{
		$this->load->helper('url');
		// $this->load->view('survei_view');
		$d['judul'] = $this->config->item('judul');
		$d['nama_perusahaan'] = $this->config->item('nama_perusahaan');
		$d['alamat_perusahaan'] = $this->config->item('alamat_perusahaan');
		$d['lisensi'] = $this->config->item('lisensi_app');
		$d['soal'] = $this->survei->get_soal();
		$d['ass'] = $this->survei->get_soal_assisten();
		
		$d['isi'] = $this->load->view('survei', $d, true);
		$this->load->view('survei', $d);
	}
	public function add_nilai() //fungsi create
	{
		echo json_encode($_POST);
		if(!isset($_POST))
			show_404();
		if($this->survei->add_nilai())
			echo json_encode(array('status'=>true));
		else
			echo json_encode(array('status'=>false));
	}
	
}
