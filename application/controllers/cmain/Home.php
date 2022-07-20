<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper('url');
		$this->load->model('Content_model','content');
	
	}
	public function index()
	{
		
			$d['judul'] = $this->config->item('judul');
			$d['nama_perusahaan'] = $this->config->item('nama_perusahaan');
			$d['alamat_perusahaan'] = $this->config->item('alamat_perusahaan');
			$d['lisensi'] = $this->config->item('lisensi_app');
			
			$d['jam_now'] = $this->app_model->Jam_Now(); 
			$d['hari_now'] = $this->app_model->Hari_Bulan_Indo(); 
			$d['tgl_now'] = $this->app_model->tgl_now_indo();
			$d['record'] = $this->content->get_berkas();
			$d['isi'] = $this->load->view('vmain/dashboard', $d, true);
			
			$this->load->view('media',$d);
		
	}
	

	function listcontent(){
		
			$d['judul'] = $this->config->item('judul');
			$d['nama_perusahaan'] = $this->config->item('nama_perusahaan');
			$d['alamat_perusahaan'] = $this->config->item('alamat_perusahaan');
			$d['lisensi'] = $this->config->item('lisensi_app');
			
			$d['jam_now'] = $this->app_model->Jam_Now(); 
			$d['hari_now'] = $this->app_model->Hari_Bulan_Indo(); 
			$d['tgl_now'] = $this->app_model->tgl_now_indo();
			$d['idmenu'] = $this->uri->segment(4);
			$d['record'] = $this->content->view_content(); //panggil query content pada content_model
			$d['isi'] = $this->load->view('vmain/listcontent', $d, true);
			
			$this->load->view('media',$d);
		
	}
	
	function contentshow(){
		
			$d['judul'] = $this->config->item('judul');
			$d['nama_perusahaan'] = $this->config->item('nama_perusahaan');
			$d['alamat_perusahaan'] = $this->config->item('alamat_perusahaan');
			$d['lisensi'] = $this->config->item('lisensi_app');
			$d['jam_now'] = $this->app_model->Jam_Now(); 
			$d['hari_now'] = $this->app_model->Hari_Bulan_Indo(); 
			$d['tgl_now'] = $this->app_model->tgl_now_indo();
			$d['idmenu'] = $this->uri->segment(5);
			$d['idcont'] = $this->uri->segment(4);
			
			$id = $this->uri->segment(4);
			// $d['record'] = $this->content->get_content()->row_array();
			$d['record'] = $this->db->get_where('content',array('id'=>$id))->row_array();
			$d['isi'] = $this->load->view('vmain/contentshow', $d, true);
			$this->load->view('media',$d);
		
	}
	function download(){
		
			$d['judul'] = $this->config->item('judul');
			$d['nama_perusahaan'] = $this->config->item('nama_perusahaan');
			$d['alamat_perusahaan'] = $this->config->item('alamat_perusahaan');
			$d['lisensi'] = $this->config->item('lisensi_app');
			$d['jam_now'] = $this->app_model->Jam_Now(); 
			$d['hari_now'] = $this->app_model->Hari_Bulan_Indo(); 
			$d['tgl_now'] = $this->app_model->tgl_now_indo();
			
			$d['record'] = $this->content->get_berkas();
			$id = $this->uri->segment(4);
			
			$d['isi'] = $this->load->view('vmain/download', $d, true);
			$this->load->view('media',$d);
		
	}
	function download_berkas(){
		$this->load->helper('download');
		$id = $this->uri->segment(4);
		$file=$this->content->get_berkas_download($id);
		$data=file_get_contents("./assets/upload/".$file);
		$nama=$file;
		force_download($nama,$data);
	}
	function cari(){
			//$this->load->model('lap_bbh_model');
            if('IS_AJAX') {
			$data['kata'] = $this->app_model->get_content();
			$this->load->view('vmain/list_cari',$data); 
            }
		
	}
	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/hone.php */