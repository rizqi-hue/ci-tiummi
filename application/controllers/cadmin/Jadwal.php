<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Jadwal extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper('url');
		$this->load->model('jadwal_model','jadwal');
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
			$d['hari'] = $this->model->get_hari();	
			$d['jam'] = $this->model->get_jam();	
			$d['dosen'] = $this->jadwal->get_dosen();	
			$d['matakul'] = $this->jadwal->get_matakul();	
			$d['kelas'] = $this->jadwal->get_kelas();	
			$level=$this->session->userdata('level');
			$d['com'] = $this->model->get_complaint($level);
			$d['isi'] = $this->load->view('vadmin/jadwal', $d, true);
			$this->load->view('vadmin/media',$d);
		}else{
			$this->session->set_flashdata('result_login', '<font color="red">Akses ditolak.</font>');
			redirect('/cadmin/home/page_403','refresh');
		}
	}
	
	public function ajax_list()
	{
		$list = $this->jadwal->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $jadwal) {
			$no++;
			$row = array();
			$row[] = '<div class="text-center">'.$no.'</div>';
			$row[] = $this->app_model->find_hari($jadwal->hari_kode);
			$row[] = $this->app_model->find_jam($jadwal->jam_kode);
			$row[] = $jadwal->matakul_kode;
			// $row[] = $this->app_model->find_matakul($jadwal->matakul_kode);
			$row[] = $jadwal->nidn;
			// $row[] = $this->app_model->find_dosen($jadwal->nidn);
			$row[] = $jadwal->lab.'/'.$jadwal->smt;
			$row[] = $jadwal->kelas_kode;
			// $row[] = $this->app_model->find_kelas($jadwal->kelas_kode);
			
			

			//add html for action
			$row[] = '<div class="text-center">
					<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_jadwal('."'".$jadwal->id."'".')"><i class="glyphicon glyphicon-pencil"></i></a>
				  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_jadwal('."'".$jadwal->id."'".')"><i class="glyphicon glyphicon-trash"></i></a>
				  </div>';
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->jadwal->count_all(),
						"recordsFiltered" => $this->jadwal->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_edit($id)
	{
		$data = $this->jadwal->get_by_id($id);
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
					'id' 		=> $this->app_model->getID_jadwal(),
					'matakul_kode' => $this->input->post('matakul_kode'),
					'nidn' 		=> $this->input->post('nidn'),
					'hari_kode' => $this->input->post('hari_kode'),
					'jam_kode' 	=> $jam,
					'kelas_kode'=> $this->input->post('kelas_kode'),
					'smt' 		=> $this->input->post('smt'),
					'thpel' 	=> $this->input->post('thpel'),
					'lab' 		=> $this->input->post('lab'),
					
				);
			$insert = $this->jadwal->save($data);
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
		$this->jadwal->update(array('id' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id)
	{
		$this->jadwal->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}
	public function ajax_cek_jadwal()
	{
		
		$data=$this->jadwal->cek_jadwal();
		echo json_encode($data);
	}
	
	public function lihat()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek)){ //semua aktor bisa lihat jadwal 
			
			$d['judul'] = $this->config->item('judul');
			$d['nama_perusahaan'] = $this->config->item('nama_perusahaan');
			$d['alamat_perusahaan'] = $this->config->item('alamat_perusahaan');
			$d['lisensi'] = $this->config->item('lisensi_app');
			$id=$this->session->userdata('username');
			$lev=$this->session->userdata('level');
			$d['record'] = $this->model->get_users($id);
			$d['temp_pinjam'] = $this->model->get_temp_pinjam($id);	
			$d['hari'] = $this->model->get_hari();	
			$d['jam'] = $this->model->get_jam();	
			$d['dosen'] = $this->jadwal->get_dosen();	
			$d['matakul'] = $this->jadwal->get_matakul();	
			$d['kelas'] = $this->jadwal->get_kelas();
			if($lev=="mhs"){
				$d['nidn']="";
			}else{
				$d['nidn']=$this->model->find_nidn($id);
			}
			$level=$this->session->userdata('level');
			$d['com'] = $this->model->get_complaint($level);
			$d['isi'] = $this->load->view('vadmin/jadwal_lihat', $d, true);
			$this->load->view('vadmin/media',$d);
		}else{
			$this->session->set_flashdata('result_login', '<font color="red">Akses ditolak.</font>');
			redirect('/cadmin/home/page_403','refresh');
		}
	}
	function view_jadwal(){
		
		if('IS_AJAX') {
		$data['lab']=$this->input->post('lab');
		$data['kelas']=$this->input->post('kelas');
		$data['thpel']=$this->input->post('thpel');
		$data['smt']=$this->input->post('smt');
		$data['nidn']=$this->input->post('nidn');
		$data['kata'] = $this->jadwal->view_jadwal();
		$this->load->view('vadmin/hasil_jadwal',$data); 
		}
		
	}
}

/* End of file jadwal.php */
/* Location: ./application/controllers/jadwal.php */