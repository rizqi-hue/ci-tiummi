<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Assisten extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper('url');
		$this->load->model('assisten_model','assisten');
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
			$d['isi'] = $this->load->view('vadmin/assisten', $d, true);		
			$this->load->view('vadmin/media',$d);
		}else{
			$this->session->set_flashdata('result_login', '<font color="red">Sesi login habis atau terhapuskan.</font>');
			redirect('/cadmin/home/page_403','refresh');
		}
	}
	
	public function ajax_list()
	{
		$list = $this->assisten->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $assisten) {
			$no++;
			$row = array();
			$row[] = '<div class="text-center">'.$no.'</div>';
			$row[] = $assisten->nama;
			$row[] = $assisten->jab;
			$row[] = '<div class="text-center">'.$assisten->status.'</div>';

			//add html for action
			$row[] = '<div class="text-center">
					<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_assisten('."'".$assisten->id."'".')"><i class="glyphicon glyphicon-pencil"></i></a>';
				  //echo <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_assisten('."'".$assisten->id."'".')"><i class="glyphicon glyphicon-trash"></i></a>
				  //</div>';
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->assisten->count_all(),
						"recordsFiltered" => $this->assisten->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_edit($id)
	{
		$data = $this->assisten->get_by_id($id);
		echo json_encode($data);
	}

	public function ajax_add()
	{
		$data = array(
				'nama' 		=> $this->input->post('nama'),
				'jab' 		=> $this->input->post('jab'),
				'status'	=> $this->input->post('status'),
			);
		$insert = $this->assisten->save($data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_update()
	{
		
		$data = array(
				'nama' 		=> $this->input->post('nama'),
				'jab' 		=> $this->input->post('jab'),
				'status'	=> $this->input->post('status'),
			);
		
		$this->assisten->update(array('id' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id)
	{
		$this->assisten->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}
}

/* End of file assisten.php */
/* Location: ./application/controllers/assisten.php */