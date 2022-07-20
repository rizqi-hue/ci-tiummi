<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mahasiswa extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper('url');
		$this->load->model('mahasiswa_model','mahasiswa');
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
			$d['jurusan'] = $this->model->get_jurusan();
			$level=$this->session->userdata('level');
			$d['com'] = $this->model->get_complaint($level);
			$d['temp_pinjam'] = $this->model->get_temp_pinjam($id);
			$d['isi'] = $this->load->view('vadmin/mahasiswa', $d, true);
		$this->load->view('vadmin/media',$d);
		}else{
			$this->session->set_flashdata('result_login', '<font color="red">Akses ditolak.</font>');
			redirect('/cadmin/home/page_403','refresh');
		}
	}
	
	public function ajax_list()
	{
		$list = $this->mahasiswa->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $mahasiswa) {
			$no++;
			$row = array();
			$row[] = '<div class="text-center">'.$no.'</div>';
			$row[] = $mahasiswa->nim;
			$row[] = $mahasiswa->Badgenumb;
			$row[] = $mahasiswa->nama.' ('.$mahasiswa->jk.')';
			$row[] = $mahasiswa->tlahir.', '.$this->app_model->tgl_str2($mahasiswa->tgllahir);
			$row[] = $mahasiswa->jurusan;
			$row[] = $mahasiswa->alamat.' HP:'.$mahasiswa->telp;
			$row[] = $mahasiswa->telp_ortu;

			//add html for action
			$row[] = '<div class="text-center">
					<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_mahasiswa('."'".$mahasiswa->nim."'".')"><i class="glyphicon glyphicon-pencil"></i></a>
				  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_mahasiswa('."'".$mahasiswa->nim."'".')"><i class="glyphicon glyphicon-trash"></i></a>
				  </div>';
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->mahasiswa->count_all(),
						"recordsFiltered" => $this->mahasiswa->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_edit($id)
	{
		$data = $this->mahasiswa->get_by_id($id);
		echo json_encode($data);
	}

	public function ajax_add()
	{
		$data = array(
				'nim' => $this->input->post('nim'),
				'Badgenumb' => $this->input->post('Badgenumb'),
				'nama' => $this->input->post('nama'),
				'tlahir' => $this->input->post('tlahir'),
				'tgllahir' => $this->app_model->tgl_sql2($this->input->post('tgllahir')),
				'jk' => $this->input->post('gender'),
				'alamat' => $this->input->post('alamat'),
				'jurusan' => $this->input->post('jurusan'),
				'telp' => $this->input->post('telp'),
				'telp_ortu' => $this->input->post('telp_ortu'),
			);
		$insert = $this->mahasiswa->save($data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_update()
	{
		$data = array(
				'nim' => $this->input->post('nim'),
				'Badgenumb' => $this->input->post('Badgenumb'),
				'nama' => $this->input->post('nama'),
				'tlahir' => $this->input->post('tlahir'),
				'tgllahir' => $this->app_model->tgl_sql2($this->input->post('tgllahir')),
				'jk' => $this->input->post('gender'),
				'alamat' => $this->input->post('alamat'),
				'jurusan' => $this->input->post('jurusan'),
				'telp' => $this->input->post('telp'),
				'telp_ortu' => $this->input->post('telp_ortu'),
			);
		$this->mahasiswa->update(array('nim' => $this->input->post('nim')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id)
	{
		$this->mahasiswa->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}
}

/* End of file mahasiswa.php */
/* Location: ./application/controllers/mahasiswa.php */