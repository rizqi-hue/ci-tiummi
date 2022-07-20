<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pinjam extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper('url');
		$this->load->model('pinjam_model','pinjam');
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
			$d['mhs'] = $this->pinjam->get_mahasiswa();
			$level=$this->session->userdata('level');
			$d['com'] = $this->model->get_complaint($level);
			$d['isi'] = $this->load->view('vadmin/pinjam', $d, true);
			$this->load->view('vadmin/media',$d);
		}else{
			$this->session->set_flashdata('result_login', '<font color="red">Akses ditolak.</font>');
			redirect('/cadmin/home/page_403','refresh');
		}
	}
	public function bukti()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek)){//semua aktor
			
			$d['judul'] = $this->config->item('judul');
			$d['nama_perusahaan'] = $this->config->item('nama_perusahaan');
			$d['alamat_perusahaan'] = $this->config->item('alamat_perusahaan');
			$d['lisensi'] = $this->config->item('lisensi_app');
			$id=$this->session->userdata('username');
			$d['record'] = $this->model->get_users($id);
			$d['temp_pinjam'] = $this->model->get_temp_pinjam($id);
			$d['bukti_pinjam'] = $this->pinjam->get_bukti_pinjam($id);
			$d['mhs'] = $this->pinjam->get_mahasiswa();
			$level=$this->session->userdata('level');
			$d['com'] = $this->model->get_complaint($level);
			$d['isi'] = $this->load->view('vadmin/pinjam_bukti', $d, true);
			$this->load->view('vadmin/media',$d);
		}else{
			$this->session->set_flashdata('result_login', '<font color="red">Akses ditolak.</font>');
			redirect('/cadmin/home/page_403','refresh');
		}
	}
	public function ajax_list()
	{
		$list = $this->pinjam->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $pinjam) {
			$no++;
			$row = array();
			$row[] = '<div class="text-center">'.$no.'</div>';
			$row[] = $pinjam->kode;
			$row[] = $pinjam->nama;
			$row[] = '<div class="text-center">'.$this->app_model->find_qty($pinjam->kode).'</div>';			
			//add html for action
			$row[] = '<div class="text-center">
					<a class="btn btn-sm btn-success" href="javascript:void(0)" title="Pinjam Barang" onclick="add_cart('."'".$pinjam->kode."'".')"><i class="glyphicon glyphicon-shopping-cart"></i> Pinjam</a>
				    </div>';
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->pinjam->count_all(),
						"recordsFiltered" => $this->pinjam->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}
	public function ajax_list2() //temp_pinjam
	{
		$list = $this->pinjam->get_datatables_temp();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $pinjam) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $pinjam->kode;
			$row[] = $pinjam->nama;
			$row[] = '<div class="text-center">'.$pinjam->qty.'</div>';
			
			//add html for action
			$row[] = '<div class="text-center" style="width:150px;">
			<a class="btn btn-sm btn-success" href="javascript:void(0)" title="Hapus" onclick="edit_cart('."'".$pinjam->id."'".')"><i class="glyphicon glyphicon-edit"></i> Edit </a><a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="hapus_temp('."'".$pinjam->id."'".')"><i class="glyphicon glyphicon-trash"></i> Hapus </a></div>';
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->pinjam->count_all(),
						"recordsFiltered" => $this->pinjam->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}
	
	public function ajax_edit($id)
	{
		$data = $this->pinjam->get_by_id($id);
		echo json_encode($data);
	}
	public function temp_ajax_edit($id)
	{
		$data = $this->pinjam->temp_get_by_id($id);
		echo json_encode($data);
	}
	public function ajax_add_temp()
	{
		$data = array(
				'id' => $this->app_model->GetID_temp_pinjam(),
				'kode' => $this->input->post('kode'),
				'nama' => $this->input->post('nama'),
				'qty' => $this->input->post('qty'),
				'user_id' => $this->session->userdata('username'),
			);
		$insert = $this->pinjam->save($data);
		echo json_encode(array("status" => TRUE));
	}
	public function ajax_add_cart()
	{
		//simpan ke table pinjam_detail
		$user_id=$this->session->userdata('username');
		$q = $this->db->query("select *	from temp_pinjam where user_id='$user_id'");
		if($q->num_rows()>0){
			foreach($q->result() as $k){
				$kode 		= $k->kode;
				$qty 		= $k->qty;
				
				//entri ke tabel mutasi stok 
				$detail=array(
					'id'		=>$this->app_model->GetID_pinjam_d(),
					'idh'		=>$this->app_model->GetID_pinjam_h(),
					'inv_kode'	=>$kode,
					'qty'		=>$qty
				);
				$insert_detail = $this->pinjam->save_pd($detail);
				//editkan stok menjadi berkurang ketika dipinjam 
				$data_adjust = array(
					'qty' => $qty*-1,
					'inv_kode' => $kode,				
					'tgl' => $this->app_model->tgl_sql2($this->input->post('tgl')),
				);
				$this->pinjam->save_adjust($data_adjust);
			}
		}else{
			$hasil = 0;
		}
		//simpan ke table pinjam_h
		$data = array(
				'id' => $this->app_model->GetID_pinjam_h(),
				'nim' => $this->input->post('nim'),
				'ket' => $this->input->post('ket'),
				'tgl' => $this->app_model->tgl_sql2(substr($this->input->post('tgl'),0,10)),
				'tglkembali'=>$this->app_model->tgl_sql2(substr($this->input->post('tgl'),13,10)),
				'user_id' => $this->session->userdata('username'),
			);
		$insert = $this->pinjam->save_ph($data);
		//detele table temporari 
		$this->pinjam->delete_temp($user_id);
		
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_update_temp()
	{
		$data = array(
				'kode' => $this->input->post('kode'),
				'nama' => $this->input->post('nama'),
				'qty' => $this->input->post('qty'),
			);
		$this->pinjam->update(array('id' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function temp_ajax_delete($id)
	{
		$this->pinjam->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}
	//kembalikan buku
	public function kembalikan() //fungsi create
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) ){
		//================================
		if(!isset($_POST))
			show_404();
		
		if($this->pinjam->kembalikan())
			echo json_encode(array('success'=>true));
		else
			echo json_encode(array('msg'=>'Gagal memasukan data'));
		//============================
		}else{
				redirect('/cadmin/home/logout/','refresh');
		}
	}
}

/* End of file pinjam.php */
/* Location: ./application/controllers/pinjam.php */