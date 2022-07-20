<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Absen extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper('url');
		$this->load->model('absen_model','absen');
		$this->load->model('app_model','model');
	}
	
	public function index()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='admin' || $level=='dosen'){
			
			$d['judul'] = $this->config->item('judul');
			$d['nama_perusahaan'] = $this->config->item('nama_perusahaan');
			$d['alamat_perusahaan'] = $this->config->item('alamat_perusahaan');
			$d['lisensi'] = $this->config->item('lisensi_app');
			$id=$this->session->userdata('username');
			$d['record'] = $this->model->get_users($id);
			$d['temp_pinjam'] = $this->model->get_temp_pinjam($id);	
			$d['dosen'] = $this->absen->get_dosen();	
			$d['matakul'] = $this->absen->get_matakul();	
			$d['kelas'] = $this->absen->get_kelas();	
			$level=$this->session->userdata('level');
			$d['com'] = $this->model->get_complaint($level);
			$d['isi'] = $this->load->view('vadmin/absen', $d, true);
			$this->load->view('vadmin/media',$d);
		}else{
			$this->session->set_flashdata('result_login', '<font color="red">Akses ditolak.</font>');
			redirect('/cadmin/home/page_403','refresh');
		}
	}
	
	public function ajax_list()
	{
		$list = $this->absen->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $absen) {
			$no++;
			$row = array();
			$row[] = '<div class="text-center">'.$no.'</div>';
			$row[] = $this->app_model->find_hari($absen->hari_kode);
			$row[] = $this->app_model->find_jam($absen->jam_kode);
			$row[] = $this->app_model->find_matakul($absen->matakul_kode);
			$row[] = $this->app_model->find_dosen($absen->nidn);
			$row[] = $absen->lab.'/'.$absen->smt;
			
			//add html for action
			$row[] = '<div class="text-center">
					<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_absen('."'".$absen->id."'".')"><i class="glyphicon glyphicon-pencil"></i></a>
				  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_absen('."'".$absen->id."'".')"><i class="glyphicon glyphicon-trash"></i></a>
				  </div>';
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->absen->count_all(),
						"recordsFiltered" => $this->absen->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_edit($id)
	{
		$data = $this->absen->get_by_id($id);
		echo json_encode($data);
	}

	public function ajax_add()
	{
		$kode=$this->input->post('matakul_kode');
		$q = $this->db->query("select *	from matakul where kode ='$kode'");
		if($q->num_rows()>0){
			foreach($q->result() as $k){
				$sks 		= $k->sks;
			}
		}
			$jam=$this->input->post('jam_kode');
		$x=1;
		while($x <= $sks) {
				// echo "The number is: $x <br>";
				$x++;
			
			$data = array(
					'id' 		=> $this->app_model->getID_absen(),
					'matakul_kode' => $this->input->post('matakul_kode'),
					'nidn' 		=> $this->input->post('nidn'),
					'hari_kode' => $this->input->post('hari_kode'),
					'jam_kode' 	=> $jam,
					'kelas_kode'=> $this->input->post('kelas_kode'),
					'smt' 		=> $this->input->post('smt'),
					'thpel' 	=> $this->input->post('thpel'),
					'lab' 		=> $this->input->post('lab'),
					
				);
			$insert = $this->absen->save($data);
			$jam++;
		} 
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_update()
	{
		$data = array(
				'matakul_kode' => $this->input->post('matakul_kode'),
				'nidn' 		=> $this->input->post('nidn'),
				'hari_kode' => $this->input->post('hari_kode'),
				'jam_kode' 	=> $this->input->post('jam_kode'),
				'kelas_kode'=> $this->input->post('kelas_kode'),
				'smt' 		=> $this->input->post('smt'),
				'thpel' 	=> $this->input->post('thpel'),
				'lab' 		=> $this->input->post('lab'),
				
			);
		$this->absen->update(array('id' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id)
	{
		$this->absen->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}
		

	function view_absen(){
		
		if('IS_AJAX') {
		$data['lab']=$this->input->post('lab');
		$data['kelas']=$this->input->post('kelas');
		$data['thpel']=$this->input->post('thpel');
		$data['smt']=$this->input->post('smt');
		$data['matakul']=$this->input->post('matakul');
		$data['kata'] = $this->absen->view_absen();
		$this->load->view('vadmin/hasil_absen',$data); 
		}
		
	}
	function view_lihat_absen(){
		
		if('IS_AJAX') {
		$data['lab']=$this->input->post('lab');
		$data['kelas']=$this->input->post('kelas');
		$data['thpel']=$this->input->post('thpel');
		$data['smt']=$this->input->post('smt');
		$data['matakul']=$this->input->post('matakul');
		$data['kata'] = $this->absen->view_lihat_absen();
		$this->load->view('vadmin/hasil_absen_lihat',$data); 
		}
		
	}
	public function add_absen() //fungsi create
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) ){
		//================================
		if(!isset($_POST))
			show_404();
		
		if($this->absen->add_absen())
			echo json_encode(array('success'=>true));
		else
			echo json_encode(array('msg'=>'Gagal memasukan data'));
		//============================
		}else{
				redirect('/cadmin/home/logout/','refresh');
		}
	}
	public function simpan_absen() //fungsi create
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) ){
		//================================
		if(!isset($_POST))
			show_404();
		
		if($this->absen->simpan_absen())
			echo json_encode(array('success'=>true));
		else
			echo json_encode(array('msg'=>'Gagal memasukan data'));
		//============================
		}else{
				redirect('/cadmin/home/logout/','refresh');
		}
	}
	public function lihat()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek)){ //semua aktor
			
			$d['judul'] = $this->config->item('judul');
			$d['nama_perusahaan'] = $this->config->item('nama_perusahaan');
			$d['alamat_perusahaan'] = $this->config->item('alamat_perusahaan');
			$d['lisensi'] = $this->config->item('lisensi_app');
			$id=$this->session->userdata('username');
			$d['record'] = $this->model->get_users($id);
			$d['temp_pinjam'] = $this->model->get_temp_pinjam($id);	
			$d['dosen'] = $this->absen->get_dosen();	
			$d['matakul'] = $this->absen->get_matakul();	
			$d['kelas'] = $this->absen->get_kelas();
			$level=$this->session->userdata('level');
			$d['com'] = $this->model->get_complaint($level);
			$d['isi'] = $this->load->view('vadmin/absen_lihat', $d, true);
			$this->load->view('vadmin/media',$d);
		}else{
			$this->session->set_flashdata('result_login', '<font color="red">Akses ditolak.</font>');
			redirect('/cadmin/home/page_403','refresh');
		}
	}
	public function cek_kuliah()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek)){ //semua aktor
			
			$d['judul'] = $this->config->item('judul');
			$d['nama_perusahaan'] = $this->config->item('nama_perusahaan');
			$d['alamat_perusahaan'] = $this->config->item('alamat_perusahaan');
			$d['lisensi'] = $this->config->item('lisensi_app');
			$id=$this->session->userdata('username');
			$nim=$this->session->userdata('nim');
			
			
			$d['kuliah'] = $this->absen->get_kuliah($nim);	
			$d['record'] = $this->model->get_users($id);
			$d['temp_pinjam'] = $this->model->get_temp_pinjam($id);	
			$d['dosen'] = $this->absen->get_dosen();	
			$d['matakul'] = $this->absen->get_matakul();	
			$d['kelas'] = $this->absen->get_kelas();
			$level=$this->session->userdata('level');
			$d['com'] = $this->model->get_complaint($level);
			$d['isi'] = $this->load->view('vadmin/absen_cek_kuliah', $d, true);
			$this->load->view('vadmin/media',$d);
		}else{
			$this->session->set_flashdata('result_login', '<font color="red">Akses ditolak.</font>');
			redirect('/cadmin/home/page_403','refresh');
		}
	}
}

/* End of file absen.php */
/* Location: ./application/controllers/absen.php */