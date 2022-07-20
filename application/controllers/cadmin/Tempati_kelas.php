<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tempati_kelas extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper('url');
		$this->load->model('tempati_kelas_model','tempati_kelas');
		$this->load->model('jadwal_model','jadwal');
		$this->load->model('mhs_model','mhs');
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
			$d['kelas'] = $this->jadwal->get_kelas();	
			$d['mhs'] = $this->model->get_mhs();
			$level=$this->session->userdata('level');
			$d['com'] = $this->model->get_complaint($level);
			$d['temp_pinjam'] = $this->model->get_temp_pinjam($id);
			$d['isi'] = $this->load->view('vadmin/tempati_kelas', $d, true);
			$this->load->view('vadmin/media',$d);
		}else{
			$this->session->set_flashdata('result_login', '<font color="red">Akses ditolak.</font>');
			redirect('/cadmin/home/page_403','refresh');
		}
	}
	
	public function ajax_list()
	{
		$list = $this->tempati_kelas->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $tempati_kelas) {
			$no++;
			$row = array();
			$row[] = '<div class="text-center">'.$no.'</div>';
			$row[] = $tempati_kelas->kelas_kode;
			$row[] = $tempati_kelas->nim;
			$row[] = $this->app_model->find_nama($tempati_kelas->nim);
			$row[] = $tempati_kelas->thpel;
			

			//add html for action
			$row[] = '<div class="text-center">
					<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_tempati_kelas('."'".$tempati_kelas->id."'".')"><i class="glyphicon glyphicon-pencil"></i></a>
					<a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_tempati_kelas('."'".$tempati_kelas->id."'".')"><i class="glyphicon glyphicon-trash"></i></a>
					</div>';
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->tempati_kelas->count_all(),
						"recordsFiltered" => $this->tempati_kelas->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}
	
	public function mahasiswa_list()
	{
		$list = $this->mhs->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $k) {
			$no++;
			$row = array();
			$row[] = $k->nim;
			$row[] = $k->nim;
			$row[] = $k->nama;
			$row[] = $k->alamat;
			

			//add html for action
			$row[] = '<div class="text-center">
					<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="tambah_mhs('."'".$k->nim."'".')"><i class="glyphicon glyphicon-plus"></i></a>
					</div>';
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->mhs->count_all(),
						"recordsFiltered" => $this->mhs->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_edit($id)
	{
		$data = $this->tempati_kelas->get_by_id($id);
		echo json_encode($data);
	}

	public function ajax_add()
	{
		$nim=$this->input->post('nim');
		if($nim==""){
		$data_nik=$this->input->post('data-nik');
		
		$exp = explode('&',$data_nik);
		$var = explode('=',$exp[0]);
		$length=$var[1]+1;
		$var = explode('=',$exp[1]);
		$select_all=$var[1];
		
			
		if($select_all=="1" and $nim==""){
			
			$x = 2; 
			//echo $length;
			while($x <= $length) {
				// echo "".$exp[$x]."";
				$nim = explode('=',$exp[$x]);
				// echo $nim[1]."; ";
				$x++;
				//entri secara looping 
				$data = array(
					'nim' 		=> $nim[1],
					'kelas_kode'=> $this->input->post('kelas_kode'),
					'thpel'		=> $this->input->post('thpel'),
					
				);
				$insert = $this->tempati_kelas->save($data);
			} 
		}elseif($select_all=="" and $nim==""){
			$data = array(
					'nim' => $this->input->post('nim'),
					'kelas_kode' => $this->input->post('kelas_kode'),
					'thpel' => $this->input->post('thpel'),
					
				);
			$insert = $this->tempati_kelas->save($data);
		}else{
			$jml = count(explode('&',$data_nik));
			$exp = explode('&',$data_nik);
			$var = explode('=',$exp[1]);
			// echo $jml;
			$i=1;
			while($i <= $jml-1) {
				// echo "".$exp[$x]."";
				$nim = explode('=',$exp[$i]);
				// echo $nim[1]."; ";
				$i++;
				$data = array(
					'nim' 		=> $nim[1],
					'kelas_kode'=> $this->input->post('kelas_kode'),
					'thpel'		=> $this->input->post('thpel'),
					
				);
				$insert = $this->tempati_kelas->save($data);
			}
		}
		}else{
			$data = array(
					'nim' => $this->input->post('nim'),
					'kelas_kode' => $this->input->post('kelas_kode'),
					'thpel' => $this->input->post('thpel'),
					
				);
			$insert = $this->tempati_kelas->save($data);
		}
		
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_update()
	{
		$data = array(
				'nim' => $this->input->post('nim'),
				'kelas_kode' => $this->input->post('kelas_kode'),
				'thpel' => $this->input->post('thpel'),
				
			);
		$this->tempati_kelas->update(array('id' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id)
	{
		$this->tempati_kelas->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}
	public function ajax_cek_kelas()
	{
		
		$data=$this->tempati_kelas->cek_kelas();
		echo json_encode($data);
	}
}

/* End of file tempati_kelas.php */
/* Location: ./application/controllers/tempati_kelas.php */