<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Matakul extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper('url');
		$this->load->model('matakul_model','matakul');
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
			$level=$this->session->userdata('level');
			$d['com'] = $this->model->get_complaint($level);
			$d['temp_pinjam'] = $this->model->get_temp_pinjam($id);	
			$d['isi'] = $this->load->view('vadmin/matakul', $d, true);
			$this->load->view('vadmin/media',$d);
		}else{
			$this->session->set_flashdata('result_login', '<font color="red">Akses ditolak.</font>');
			redirect('/cadmin/home/page_403','refresh');
		}
	}
	
	public function ajax_list()
	{
		$list = $this->matakul->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $matakul) {
			$no++;
			$row = array();
			$row[] = '<div class="text-center">'.$no.'</div>';
			$row[] = $matakul->kode;
			$row[] = $matakul->matakul;
			$row[] = $matakul->sks;
			$row[] = $matakul->temu;
			
			//add html for action
			$row[] = '<div class="text-center">
					<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_matakul('."'".$matakul->kode."'".')"><i class="glyphicon glyphicon-pencil"></i></a>
				  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_matakul('."'".$matakul->kode."'".')"><i class="glyphicon glyphicon-trash"></i></a>
				  </div>';
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->matakul->count_all(),
						"recordsFiltered" => $this->matakul->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_edit($id)
	{
		$data = $this->matakul->get_by_id($id);
		echo json_encode($data);
	}

	public function ajax_add()
	{
		$data = array(
				'kode' => $this->input->post('kode'),
				'matakul' => $this->input->post('matakul'),
				'sks' => $this->input->post('sks'),
				'temu' => $this->input->post('temu'),
				
			);
		$insert = $this->matakul->save($data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_update()
	{
		$data = array(
				'kode' => $this->input->post('kode'),
				'matakul' => $this->input->post('matakul'),
				'sks' => $this->input->post('sks'),
				'temu' => $this->input->post('temu'),
				
			);
		$this->matakul->update(array('kode' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id)
	{
		$this->matakul->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}
}

/* End of file matakul.php */
/* Location: ./application/controllers/matakul.php */