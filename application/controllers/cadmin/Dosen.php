<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dosen extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper('url');
		$this->load->model('dosen_model','dosen');
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
			$d['isi'] = $this->load->view('vadmin/dosen', $d, true);
			$this->load->view('vadmin/media',$d);
		}else{
			$this->session->set_flashdata('result_login', '<font color="red">Akses ditolak.</font>');
			redirect('/cadmin/home/page_403','refresh');
		}
	}
	
	public function ajax_list()
	{
		$list = $this->dosen->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $dosen) {
			$no++;
			$row = array();
			$row[] = '<div class="text-center">'.$no.'</div>';
			$row[] = $dosen->nidn;
			$row[] = $dosen->nama.' ('.$dosen->jk.')';
			$row[] = $dosen->tlahir.', '.$this->app_model->tgl_str2($dosen->tgllahir);
			$row[] = $dosen->jabatan;
			$row[] = $dosen->alamat;

			//add html for action
			$row[] = '<div class="text-center">
					<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_dosen('."'".$dosen->nidn."'".')"><i class="glyphicon glyphicon-pencil"></i></a>
				  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_dosen('."'".$dosen->nidn."'".')"><i class="glyphicon glyphicon-trash"></i></a>
				  </div>';
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->dosen->count_all(),
						"recordsFiltered" => $this->dosen->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_edit($id)
	{
		$data = $this->dosen->get_by_id($id);
		echo json_encode($data);
	}

	public function ajax_add()
	{
		$data = array(
				'nidn' => $this->input->post('nidn'),
				'nama' => $this->input->post('nama'),
				'tlahir' => $this->input->post('tlahir'),
				'tgllahir' => $this->app_model->tgl_sql2($this->input->post('tgllahir')),
				'jk' => $this->input->post('gender'),
				'alamat' => $this->input->post('alamat'),
				'jabatan' => $this->input->post('jabatan'),
			);
		$insert = $this->dosen->save($data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_update()
	{
		$data = array(
				'nidn' => $this->input->post('nidn'),
				'nama' => $this->input->post('nama'),
				'tlahir' => $this->input->post('tlahir'),
				'tgllahir' => $this->app_model->tgl_sql2($this->input->post('tgllahir')),
				'jk' => $this->input->post('gender'),
				'alamat' => $this->input->post('alamat'),
				'jabatan' => $this->input->post('jabatan'),
			);
		$this->dosen->update(array('nidn' => $this->input->post('nidn')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id)
	{
		$this->dosen->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}
}

/* End of file dosen.php */
/* Location: ./application/controllers/dosen.php */