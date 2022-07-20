<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Laporan extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('laporan_model','laporan');
		$this->load->library('fpdf'); // Load library
	}
	
	public function cetak_bukti_pinjam()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek)){ //semua aktor bisa
			$this->laporan->lap_bukti_pinjam_pdf(); //
		}else{
			redirect('./cadmin/home/logout/','refresh');
		}
	}
	public function cetak_jadwal()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek)){ //semua aktor bisa
			$this->laporan->cetak_jadwal_pdf(); //
		}else{
			redirect('./cadmin/home/logout/','refresh');
		}
	}
	public function cetak_absen()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek)){ //semua aktor bisa
			$this->laporan->cetak_absen_pdf(); //
		}else{
			redirect('./cadmin/home/logout/','refresh');
		}
	}
	public function cetak_stok()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek)){ //semua aktor bisa
			$this->laporan->cetak_stok_pdf(); //
		}else{
			redirect('./cadmin/home/logout/','refresh');
		}
	}
	
	
	
	

	
}

/* End of file rpjmdes.php */
/* Location: ./application/controllers/rpjmdes.php */