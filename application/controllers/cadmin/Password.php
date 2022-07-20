<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Password extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper('url');	
		$this->load->model('app_model','model');
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
			$level=$this->session->userdata('level');
			$d['com'] = $this->model->get_complaint($level);
			$d['temp_pinjam'] = $this->model->get_temp_pinjam($id);
			
			$d['isi'] = $this->load->view('vadmin/password', $d, true);		
			$this->load->view('vadmin/media',$d);
		}else{
			redirect('/home/logout/','refresh');
		}
	}
	
	public function simpan()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek) ){
				
				$id['user_id'] = $this->session->userdata('username');
				
				$pwd = md5($this->input->post('pwd_1'));
				
				$up['password'] = $pwd;
				
				
				$hasil = $this->db->get_where("users",$id);
				$row = $hasil->num_rows();
				if($row>0){
					$this->app_model->updateData("users",$up,$id);
					echo "Data sukses diubah";
				}else{
					$this->app_model->insertData("users",$up);
					echo "Data sukses disimpan";
				}
		}else{
				redirect('/home/logout/','refresh');
		}
	}
}

/* End of file password.php */
/* Location: ./application/controllers/password.php */