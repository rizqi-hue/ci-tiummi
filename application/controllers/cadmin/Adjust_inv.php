<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Adjust_inv extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper('url');
		$this->load->model('adjust_inv_model','adjust_inv');
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
			$d['temp_pinjam'] = $this->model->get_temp_pinjam($id);
			$d['record'] = $this->model->get_users($id);
			$d['inventori'] = $this->adjust_inv->get_inventori();
			$level=$this->session->userdata('level');
			$d['com'] = $this->model->get_complaint($level);
			$d['isi'] = $this->load->view('vadmin/adjust_inv', $d, true);
			$this->load->view('vadmin/media',$d);
		}else{
			$this->session->set_flashdata('result_login', '<font color="red">Akses ditolak.</font>');
			redirect('/cadmin/home/page_403','refresh');
		}
	}
	
	public function ajax_list()
	{
		$list = $this->adjust_inv->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $adjust_inv) {
			$no++;
			$row = array();
			$row[] = '<div class="text-center">'.$no.'</div>';
			$row[] = $adjust_inv->inv_kode;
			$row[] = '<div class="text-center">'.$adjust_inv->qty.'</div>';
			$row[] = '<div class="text-right">Rp '.number_format($adjust_inv->harga,0).'</div>';
			$row[] = '<div class="text-right">Rp '.number_format($adjust_inv->harga*$adjust_inv->qty,0).'</div>';
			$row[] = '<div class="text-left">'.$this->app_model->find_sumber($adjust_inv->sumber).'</div>';
			$row[] = '<div class="text-center">'.$this->app_model->tgl_str2($adjust_inv->tgl).'</div>';
			

			//add html for action
			$row[] = '<div class="text-center">
					<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_adjust_inv('."'".$adjust_inv->id."'".')"><i class="glyphicon glyphicon-pencil"></i></a>
				  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_adjust_inv('."'".$adjust_inv->id."'".')"><i class="glyphicon glyphicon-trash"></i></a>
				  </div>';
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->adjust_inv->count_all(),
						"recordsFiltered" => $this->adjust_inv->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_edit($id)
	{
		$data = $this->adjust_inv->get_by_id($id);
		echo json_encode($data);
	}

	public function ajax_add()
	{
		$data = array(
				'inv_kode' => $this->input->post('kode'),
				'qty' => $this->input->post('qty'),
				'tgl' => $this->app_model->tgl_sql2($this->input->post('tglin')),
				'harga' => $this->input->post('harga'),
				'sumber' => $this->input->post('sumber'),
				
			);
		$insert = $this->adjust_inv->save($data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_update()
	{
		$data = array(
				'inv_kode' => $this->input->post('kode'),
				'qty' => $this->input->post('qty'),
				'tgl' => $this->app_model->tgl_sql2($this->input->post('tglin')),
				'harga' => $this->input->post('harga'),
				'sumber' => $this->input->post('sumber'),
			);
		$this->adjust_inv->update(array('id' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id)
	{
		$this->adjust_inv->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}
}

/* End of file adjust_inv.php */
/* Location: ./application/controllers/adjust_inv.php */