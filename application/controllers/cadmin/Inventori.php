<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Inventori extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper('url');
		$this->load->model('inventori_model','inventori');
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
			$d['isi'] = $this->load->view('vadmin/inventori', $d, true);
			$this->load->view('vadmin/media',$d);
		}else{
			$this->session->set_flashdata('result_login', '<font color="red">Akses ditolak.</font>');
			redirect('/cadmin/home/page_403','refresh');
		}
	}
	
	public function ajax_list()
	{
		$list = $this->inventori->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $inventori) {
			$no++;
			$row = array();
			$row[] = '<div class="text-center">'.$no.'</div>';
			$row[] = $inventori->kode;
			$row[] = $inventori->nama;
			$row[] = $inventori->kategori;
			$row[] = $this->app_model->tgl_str2($inventori->tgl);
			

			//add html for action
			$row[] = '<div class="text-center">
					<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_inventori('."'".$inventori->kode."'".')"><i class="glyphicon glyphicon-pencil"></i></a>
				  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_inventori('."'".$inventori->kode."'".')"><i class="glyphicon glyphicon-trash"></i></a>
				  </div>';
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->inventori->count_all(),
						"recordsFiltered" => $this->inventori->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}
	public function ajax_list2()
	{
		$list = $this->inventori->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $inventori) {
			$no++;
			$row = array();
			$row[] = $inventori->kode;
			$row[] = $inventori->nama;
			$row[] = '<div class="text-center">'.$this->app_model->find_qty($inventori->kode).'</div>';
			

			//add html for action
			$row[] = '<div class="text-center"><a class="btn btn-sm btn-success" href="javascript:void(0)" title="Tambah" onclick="tambah_inv('."'".$inventori->kode."'".')"><i class="glyphicon glyphicon-plus"></i> Add </a>
				  </div>';
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->inventori->count_all(),
						"recordsFiltered" => $this->inventori->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}
	public function ajax_edit($id)
	{
		$data = $this->inventori->get_by_id($id);
		echo json_encode($data);
	}

	public function ajax_add()
	{
		$data = array(
				'kode' => $this->input->post('kode'),
				'nama' => $this->input->post('nama'),
				'tgl' => $this->app_model->tgl_sql2($this->input->post('tglin')),
				'kategori' => $this->input->post('kategori'),
				
			);
		$insert = $this->inventori->save($data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_update()
	{
		$data = array(
				'kode' => $this->input->post('kode'),
				'nama' => $this->input->post('nama'),
				'tgl' => $this->app_model->tgl_sql2($this->input->post('tglin')),
				'kategori' => $this->input->post('kategori'),
			);
		$this->inventori->update(array('kode' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id)
	{
		$this->inventori->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}
	public function stok()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek)){
			
			$d['judul'] = $this->config->item('judul');
			$d['nama_perusahaan'] = $this->config->item('nama_perusahaan');
			$d['alamat_perusahaan'] = $this->config->item('alamat_perusahaan');
			$d['lisensi'] = $this->config->item('lisensi_app');
			$id=$this->session->userdata('username');
			$d['record'] = $this->model->get_users($id);
			$d['temp_pinjam'] = $this->model->get_temp_pinjam($id);	
			$level=$this->session->userdata('level');
			$d['com'] = $this->model->get_complaint($level);
			$d['isi'] = $this->load->view('vadmin/inventori_stok', $d, true);
			$this->load->view('vadmin/media',$d);
		}else{
			$this->session->set_flashdata('result_login', '<font color="red">Akses ditolak.</font>');
			redirect('/cadmin/home/page_403','refresh');
		}
	}
	function view_stok(){
		
		if('IS_AJAX') {	
		$data['tgl']=$this->input->post('tgl');
		$data['kata'] = $this->inventori->view_stok();
		$this->load->view('vadmin/hasil_stok_inventori',$data); 
		}
		
	}
}

/* End of file inventori.php */
/* Location: ./application/controllers/inventori.php */