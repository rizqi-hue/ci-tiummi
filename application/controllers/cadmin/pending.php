<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pending extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper('url');
		$this->load->model('pending_model','pending');
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
			$d['kelas'] = $this->model->get_kelas();
			$d['temp_pinjam'] = $this->model->get_temp_pinjam($id);
			
			$d['jam_now'] = $this->app_model->Jam_Now(); 
			$d['hari_now'] = $this->app_model->Hari_Bulan_Indo(); 
			$d['tgl_now'] = $this->app_model->tgl_now_indo();
			$level=$this->session->userdata('level');
			$d['com'] = $this->model->get_complaint($level);
			$d['isi'] = $this->load->view('vadmin/outbox', $d, true);		
			$this->load->view('vadmin/media',$d);
		}else{
			$this->session->set_flashdata('result_login', '<font color="red">Sesi login habis atau terhapuskan.</font>');
			redirect('/cadmin/home/page_403','refresh');
		}
	}
	
	public function ajax_list()
	{
		$list = $this->pending->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $pending) {
			$no++;
			$row = array();
			$row[] = '<div class="text-center">'.$no.'</div>';
			$row[] = $pending->UpdatedInDB.'<br/>'.$pending->DestinationNumber;;
			$row[] = $pending->TextDecoded;
			$row[] = $pending->CreatorID;
			//add html for action
			$row[] = '<div class="text-center">
					<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_outbox('."'".$pending->ID."'".')"><i class="glyphicon glyphicon-envelope"></i></a>
				  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_outbox('."'".$pending->ID."'".')"><i class="glyphicon glyphicon-trash"></i></a>
				  </div>';
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->pending->count_all(),
						"recordsFiltered" => $this->pending->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_edit($id)
	{
		$data = $this->pending->get_by_id($id);
		echo json_encode($data);
	}

	public function ajax_add()
	{
		$data = array(
				'DestinationNumber' => $this->input->post('nomor'),
				'SenderID' 		=> '',
				'TextDecoded' 	=> $this->input->post('pesan'),
				'CreatorID' 	=> 'MelatiUMMI',
			);
		$insert = $this->pending->save($data);
		echo json_encode(array("status" => TRUE));
	}
	public function ajax_add_sms_group()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) ){
		//================================
		if(!isset($_POST))
			show_404();
		
		if($this->pending->add_sms_group())
			echo json_encode(array('status'=>TRUE));
		else
			echo json_encode(array('msg'=>'Gagal memasukan data'));
		//============================
		}else{
				redirect('/cadmin/home/logout/','refresh');
		}
		
	}
	
	public function ajax_delete($id)
	{
		$this->pending->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}
}

/* End of file pending.php */
/* Location: ./application/controllers/pending.php */