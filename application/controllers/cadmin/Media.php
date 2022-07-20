<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Media extends CI_Controller {

	/**
	 * @author : Deddy Rusdiansyah,S.Kom
	 * @web : http://deddyrusdiansyah.blogspot.com
	 * @keterangan : Controller untuk halaman awal ketika pengguna berhasil login dan masuk ke halaman utama
	 **/
	 public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper('url');	
		$this->load->model('app_model','model');
		$this->load->library('session');
	}
	public function index()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){
			$d['judul'] = $this->config->item('judul');
			$d['nama_perusahaan'] = $this->config->item('nama_perusahaan');
			$d['alamat_perusahaan'] = $this->config->item('alamat_perusahaan');
			$d['lisensi'] = $this->config->item('lisensi_app');
			$id=$this->session->userdata('username');
			$d['record'] = $this->model->get_users($id);
			$d['temp_pinjam'] = $this->model->get_temp_pinjam($id);
			$sesi=$this->session->userdata('session_id');
			$d['sesi'] = $this->model->get_ci_sesi($sesi);
			$level=$this->session->userdata('level');
			$d['com'] = $this->model->get_complaint($level);
			$d['jam_now'] = $this->app_model->Jam_Now(); 
			$d['hari_now'] = $this->app_model->Hari_Bulan_Indo(); 
			$d['tgl_now'] = $this->app_model->tgl_now_indo();
			
			$query = $this->db->query("SELECT * FROM menu where head='0' and enabled='Y' order by id asc")->result();
			$d['menu'] = $query;
			
			$d['isi'] = $this->load->view('vadmin/dashboard', $d, true);
			
			$this->load->view('vadmin/media',$d);
		}else{
			redirect('./cadmin/home/logout/','refresh');
		}
	}
	public function chart_hadir()  
	{
		//chart_model dipanggil menjadi chart
		echo $this->chart->chart_hadir(); //
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/media.php */