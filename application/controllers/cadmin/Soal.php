<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Soal extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper('url');
		$this->load->model('soal_model','soal');
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
			$d['isi'] = $this->load->view('vadmin/soal', $d, true);		
			$this->load->view('vadmin/media',$d);
		}else{
			$this->session->set_flashdata('result_login', '<font color="red">Sesi login habis atau terhapuskan.</font>');
			redirect('/cadmin/home/page_403','refresh');
		}
	}
	
	public function ajax_list()
	{
		$list = $this->soal->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $soal) {
			$no++;
			$row = array();
			$row[] = '<div class="text-center">'.$no.'</div>';
			$row[] = $soal->soal;
			$row[] = '<div class="text-center">'.$soal->status.'</div>';

			//add html for action
			$row[] = '<div class="text-center">
					<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_soal('."'".$soal->id."'".')"><i class="glyphicon glyphicon-pencil"></i></a>';
				  //echo <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_soal('."'".$soal->id."'".')"><i class="glyphicon glyphicon-trash"></i></a>
				  //</div>';
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->soal->count_all(),
						"recordsFiltered" => $this->soal->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_edit($id)
	{
		$data = $this->soal->get_by_id($id);
		echo json_encode($data);
	}

	public function ajax_add()
	{
		$data = array(
				'soal' 		=> $this->input->post('soal'),
				'status'	=> $this->input->post('status'),
			);
		$insert = $this->soal->save($data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_update()
	{
		
		$data = array(
				'soal' 		=> $this->input->post('soal'),
				'status' 	=> $this->input->post('status'),
			);
		
		$this->soal->update(array('id' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id)
	{
		$this->soal->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}
}

/* End of file soal.php */
/* Location: ./application/controllers/soal.php */