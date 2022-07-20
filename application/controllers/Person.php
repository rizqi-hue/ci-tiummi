<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Person extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('app_model','person');
		$this->load->model('users_model','users');
		// $this->load->model('Listcontent_model','content');
	}

	public function index()
	{
		$this->load->helper('url');
		// $this->load->view('person_view');
		$d['judul'] = $this->config->item('judul');
		$d['nama_perusahaan'] = $this->config->item('nama_perusahaan');
		$d['alamat_perusahaan'] = $this->config->item('alamat_perusahaan');
		$d['lisensi'] = $this->config->item('lisensi_app');
		// $d['record'] = $this->content->get_berkas();
		$d['isi'] = $this->load->view('media', $d, true);
		$this->load->view('media', $d);
	}
	public function login_view()
	{
		$this->load->helper('url');
		$this->load->view('login');
	}
	public function add_complaint() //fungsi create
	{
		if(!isset($_POST))
			show_404();
		if($this->person->add_complaint())
			echo json_encode(array('status'=>true));
		else
			echo json_encode(array('msg'=>'Gagal memasukan data'));
	}
	public function login(){
		$u = $this->input->post('inputUser');
		$p = $this->input->post('inputPassword');
		$this->person->getLoginData($u,$p);
	}
	public function buat_akun()
	{
		$kode=$this->input->post('nim');
		//cek nim di table mahasiswa 
		$qnim = $this->db->query("select *	FROM mahasiswa  where nim ='$kode'");
		$qnidn = $this->db->query("select *	FROM dosen  where nidn ='$kode'");
		if($qnim->num_rows()>0){
			$q = $this->db->query("select *	FROM users  where nim ='$kode'");
			if($q->num_rows()>0){
				foreach($q->result() as $k){
					$nim 		= $k->nim;
				}
				echo json_encode(array("status" => FALSE));
			}else{
			$data = array(
					'user_id' => $this->input->post('user_id'),
					'password' => md5($this->input->post('password')),
					'nim' => $this->input->post('nim'),
					'namalengkap' => $this->input->post('namalengkap'),
					'level' => $this->input->post('level'),
				);
			$insert = $this->users->save($data);
			echo json_encode(array("status" => TRUE));
			}
		}elseif($qnidn->num_rows()>0){
			$q = $this->db->query("select *	FROM users  where nim ='$kode'");
			if($q->num_rows()>0){
				foreach($q->result() as $k){
					$nim 		= $k->nim;
				}
				echo json_encode(array("status" => FALSE));
			}else{
			$data = array(
					'user_id' => $this->input->post('user_id'),
					'password' => md5($this->input->post('password')),
					'nim' => $this->input->post('nim'),
					'namalengkap' => $this->input->post('namalengkap'),
					'level' => $this->input->post('level'),
				);
			$insert = $this->users->save($data);
			echo json_encode(array("status" => TRUE));
			}
		}else{
			echo json_encode(array("status" => FALSE));
		}
			
		
	}
	public function organigram()
	{
		$this->load->helper('url');
		$d['judul'] = $this->config->item('judul');
		$d['nama_perusahaan'] = $this->config->item('nama_perusahaan');
		$d['alamat_perusahaan'] = $this->config->item('alamat_perusahaan');
		$d['lisensi'] = $this->config->item('lisensi_app');
		$id = $this->uri->segment(3);
		$d['rec'] = $this->db->get_where('content',array('id'=>$id))->row_array();
		
		$d['isi'] = $this->load->view('organigram', $d, true);
		$this->load->view('organigram', $d);
	}
}
