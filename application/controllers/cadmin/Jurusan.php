<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Jurusan extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper('url');
		$this->load->model('jurusan_model','jurusan');
		$this->load->model('app_model','model');
	}
	
	public function index()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='admin'){
			
			$d['judul'] = $this->config->item('judul');
			$d['nama_perusahaan'] = $this->config->item('nama_perusahaan');
			$d['alamat_perusahaan'] = $this->config->item('alamat_perusahaan');
			$d['lisensi'] = $this->config->item('lisensi_app');
			$id=$this->session->userdata('username');
			$d['record'] = $this->model->get_users($id);
			$d['temp_pinjam'] = $this->model->get_temp_pinjam($id);	
			$level=$this->session->userdata('level');
			$d['com'] = $this->model->get_complaint($level);
			$d['isi'] = $this->load->view('vadmin/jurusan', $d, true);
			$this->load->view('vadmin/media',$d);
		}else{
			$this->session->set_flashdata('result_login', '<font color="red">Akses ditolak.</font>');
			redirect('/cadmin/home/page_403','refresh');
		}
	}
	
	public function ajax_list()
	{
		$list = $this->jurusan->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $jurusan) {
			$no++;
			$row = array();
			$row[] = '<div class="text-center">'.$no.'</div>';
			$row[] = $jurusan->fakultas;
			$row[] = $jurusan->prodi;
			$row[] = $jurusan->jurusan;
			$row[] = $jurusan->sing_jur;
			

			//add html for action
			$row[] = '<div class="text-center">
					<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_jurusan('."'".$jurusan->id."'".')"><i class="glyphicon glyphicon-pencil"></i></a>
				  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_jurusan('."'".$jurusan->id."'".')"><i class="glyphicon glyphicon-trash"></i></a>
				  </div>';
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->jurusan->count_all(),
						"recordsFiltered" => $this->jurusan->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_edit($id)
	{
		$data = $this->jurusan->get_by_id($id);
		echo json_encode($data);
	}

	public function ajax_add()
	{
		$data = array(
				'id' => $this->input->post('id'),
				'fakultas' => $this->input->post('fakultas'),
				'prodi' => $this->input->post('prodi'),
				'jurusan' => $this->input->post('jurusan'),
				'sing_jur' => $this->input->post('sing_jur'),
				
			);
		$insert = $this->jurusan->save($data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_update()
	{
		$data = array(
				'id' => $this->input->post('id'),
				'fakultas' => $this->input->post('fakultas'),
				'prodi' => $this->input->post('prodi'),
				'jurusan' => $this->input->post('jurusan'),
				'sing_jur' => $this->input->post('sing_jur'),
			);
		$this->jurusan->update(array('id' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id)
	{
		$this->jurusan->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}
}

/* End of file jurusan.php */
/* Location: ./application/controllers/jurusan.php */