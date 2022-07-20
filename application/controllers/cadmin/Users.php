<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper('url');
		$this->load->model('users_model','users');
		$this->load->model('app_model','model');
	}
	
	public function index()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		
		if(!empty($cek && $level=='admin')){
			
			$d['judul'] = $this->config->item('judul');
			$d['nama_perusahaan'] = $this->config->item('nama_perusahaan');
			$d['alamat_perusahaan'] = $this->config->item('alamat_perusahaan');
			$d['lisensi'] = $this->config->item('lisensi_app');
			$id=$this->session->userdata('username');
			$d['record'] = $this->model->get_users($id);
			$d['temp_pinjam'] = $this->model->get_temp_pinjam($id);
			
			$d['jam_now'] = $this->app_model->Jam_Now(); 
			$d['hari_now'] = $this->app_model->Hari_Bulan_Indo(); 
			$d['tgl_now'] = $this->app_model->tgl_now_indo();
			$level=$this->session->userdata('level');
			$d['com'] = $this->model->get_complaint($level);
			$d['isi'] = $this->load->view('vadmin/users', $d, true);		
			$this->load->view('vadmin/media',$d);
		}else{
			$this->session->set_flashdata('result_login', '<font color="red">Sesi login habis atau terhapuskan.</font>');
			redirect('/cadmin/home/page_403','refresh');
		}
	}
	
	public function ajax_list()
	{
		$list = $this->users->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $users) {
			$no++;
			$row = array();
			$row[] = '<div class="text-center">'.$no.'</div>';
			$row[] = $users->user_id;
			$row[] = $users->password;
			$row[] = $users->namalengkap;
			$row[] = $users->level;
			$row[] = $users->nim;

			//add html for action
			$row[] = '<div class="text-center">
					<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_users('."'".$users->id."'".')"><i class="glyphicon glyphicon-pencil"></i></a>
				  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_users('."'".$users->id."'".')"><i class="glyphicon glyphicon-trash"></i></a>
				  </div>';
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->users->count_all(),
						"recordsFiltered" => $this->users->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_edit($id)
	{
		$data = $this->users->get_by_id($id);
		echo json_encode($data);
	}

	public function ajax_add()
	{
		$data = array(
				'user_id' => $this->input->post('user_id'),
				'password' => md5($this->input->post('password')),
				'level' => $this->input->post('level'),
				'namalengkap' => $this->input->post('namalengkap'),
				'nim' => $this->input->post('nim'),
			);
		$insert = $this->users->save($data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_update()
	{
		$pass=$this->input->post('password');
		if(!empty($pass)){
		$data = array(
				'user_id' => $this->input->post('user_id'),
				'password' => md5($this->input->post('password')),
				'level' => $this->input->post('level'),
				'namalengkap' => $this->input->post('namalengkap'),
				'nim' => $this->input->post('nim'),
			);
		}else{
		$data = array(
				'user_id' => $this->input->post('user_id'),
				// 'password' => md5($this->input->post('password')),
				'level' => $this->input->post('level'),
				'namalengkap' => $this->input->post('namalengkap'),
				'nim' => $this->input->post('nim'),
			);
		}
		$this->users->update(array('id' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id)
	{
		$this->users->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}
}

/* End of file users.php */
/* Location: ./application/controllers/users.php */