<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper('url');	
		$this->load->model('app_model','model');
		$this->load->model('chart_model','chart');
		$this->load->model('absen_model','absen');
		$this->load->model('Listcontent_model','content');
		$this->load->library('session');
	}
	public function index()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){
			$d['judul'] = $this->config->item('judul');
			$d['nama_perusahaan'] = $this->config->item('nama_perusahaan');
			$d['alamat_perusahaan'] = $this->config->item('alamat_perusahaan');
			$d['lisensi'] = $this->config->item('lisensi_app');
			
			$d['jam_now'] = $this->app_model->Jam_Now(); 
			$d['hari_now'] = $this->app_model->Hari_Bulan_Indo(); 
			$d['tgl_now'] = $this->app_model->tgl_now_indo();
			$id=$this->session->userdata('username');
			$d['temp_pinjam'] = $this->model->get_temp_pinjam($id);
			$d['record'] = $this->model->get_users($id);
			$level=$this->session->userdata('level');
			$d['com'] = $this->model->get_complaint($level);
			$sesi=$this->session->userdata('session_id');
			$d['sesi'] = $this->model->get_ci_sesi($sesi);
			$d['isi'] = $this->load->view('vadmin/dashboard', $d, true);
			
			$this->load->view('vadmin/media',$d);
		}else{
			$this->session->set_flashdata('result_login', '<font color="red">Sesi login habis atau terhapuskan.</font>');
			redirect('./cadmin/home/logout/','refresh');
		}
	}
	public function ecomplaint()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){
			$d['judul'] = $this->config->item('judul');
			$d['nama_perusahaan'] = $this->config->item('nama_perusahaan');
			$d['alamat_perusahaan'] = $this->config->item('alamat_perusahaan');
			$d['lisensi'] = $this->config->item('lisensi_app');
			
			$d['jam_now'] = $this->app_model->Jam_Now(); 
			$d['hari_now'] = $this->app_model->Hari_Bulan_Indo(); 
			$d['tgl_now'] = $this->app_model->tgl_now_indo();
			$id=$this->session->userdata('username');
			$d['temp_pinjam'] = $this->model->get_temp_pinjam($id);
			$d['record'] = $this->model->get_users($id);
			$level=$this->session->userdata('level');
			$d['com'] = $this->model->get_complaint($level);
			$sesi=$this->session->userdata('session_id');
			$d['sesi'] = $this->model->get_ci_sesi($sesi);
			$d['isi'] = $this->load->view('vadmin/ecomplaint', $d, true);
			
			$this->load->view('vadmin/media',$d);
		}else{
			$this->session->set_flashdata('result_login', '<font color="red">Sesi login habis atau terhapuskan.</font>');
			redirect('./cadmin/home/logout/','refresh');
		}
	}
	public function complaint_ajax_list()
	{
		$list = $this->model->get_datatables_complaint();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $r) {
			$no++;
			$row = array();
			$row[] = '<div class="text-center">'.$no.'</div>';
			$row[] = $r->nama."<br/>".$this->app_model->tgl_str($r->tgl);
			$row[] = '<strong>'.$r->subject.'</strong><br/>'.$r->pesan;
			//add html for action
			$row[] = '<div class="text-center">
				  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_complaint('."'".$r->id."'".')"><i class="glyphicon glyphicon-trash"></i></a>
				  </div>';
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->model->count_all_complaint(),
						"recordsFiltered" => $this->model->count_filtered_complaint(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}
	public function page_403()
	{
		
			$d['judul'] = $this->config->item('judul');
			$d['nama_perusahaan'] = $this->config->item('nama_perusahaan');
			$d['alamat_perusahaan'] = $this->config->item('alamat_perusahaan');
			$d['lisensi'] = $this->config->item('lisensi_app');
			
			$d['jam_now'] = $this->app_model->Jam_Now(); 
			$d['hari_now'] = $this->app_model->Hari_Bulan_Indo(); 
			$d['tgl_now'] = $this->app_model->tgl_now_indo();
				
			$this->load->view('vadmin/page_403',$d);
		
	}
	
	public function logout(){
		$this->session->sess_destroy();
		//header('location:'.base_url());
		redirect('','refresh');
	}
	
	public function profile()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek)){
			$d['judul'] = $this->config->item('judul');
			$d['nama_perusahaan'] = $this->config->item('nama_perusahaan');
			$d['alamat_perusahaan'] = $this->config->item('alamat_perusahaan');
			$d['lisensi'] = $this->config->item('lisensi_app');
			
			$d['jam_now'] = $this->app_model->Jam_Now(); 
			$d['hari_now'] = $this->app_model->Hari_Bulan_Indo(); 
			$d['tgl_now'] = $this->app_model->tgl_now_indo();
			$id=$this->session->userdata('username');
			$nim=$this->session->userdata('nim');
			$d['temp_pinjam'] = $this->model->get_temp_pinjam($id);
			if($level=="mhs"){
				$d['mhs'] = $this->model->get_mhs_id($nim);
			}elseif($level=="dosen"){
				$d['mhs'] = $this->model->get_dosen_id($nim);
			}
			$level=$this->session->userdata('level');
			$d['com'] = $this->model->get_complaint($level);
			$d['record'] = $this->model->get_users($id);
			$d['isi'] = $this->load->view('vadmin/profile', $d, true);
			
			$this->load->view('vadmin/media',$d);
		}else{
			$this->session->set_flashdata('result_login', '<font color="red">Sesi login habis atau terhapuskan.</font>');
			redirect('./cadmin/home/logout/','refresh');
		}
	}
	public function koneksi_mesin()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek)){
			$d['judul'] = $this->config->item('judul');
			$d['nama_perusahaan'] = $this->config->item('nama_perusahaan');
			$d['alamat_perusahaan'] = $this->config->item('alamat_perusahaan');
			$d['lisensi'] = $this->config->item('lisensi_app');
			
			$d['jam_now'] = $this->app_model->Jam_Now(); 
			$d['hari_now'] = $this->app_model->Hari_Bulan_Indo(); 
			$d['tgl_now'] = $this->app_model->tgl_now_indo();
			$id=$this->session->userdata('username');
			$nim=$this->session->userdata('nim');
			$d['temp_pinjam'] = $this->model->get_temp_pinjam($id);
			if($level=="mhs"){
				$d['mhs'] = $this->model->get_mhs_id($nim);
			}elseif($level=="dosen"){
				$d['mhs'] = $this->model->get_dosen_id($nim);
			}
			$d['record'] = $this->model->get_users($id);
			$d['dosen'] = $this->absen->get_dosen();	
			$d['matakul'] = $this->absen->get_matakul();	
			$d['kelas'] = $this->absen->get_kelas();
			$level=$this->session->userdata('level');
			$d['com'] = $this->model->get_complaint($level);
			$d['isi'] = $this->load->view('vadmin/koneksi_mesin', $d, true);
			
			$this->load->view('vadmin/media',$d);
		}else{
			$this->session->set_flashdata('result_login', '<font color="red">Sesi login habis atau terhapuskan.</font>');
			redirect('./cadmin/home/logout/','refresh');
		}
	}
	public function ambildata() //fungsi create
	{
		if('IS_AJAX') {
		$data['id']=$this->input->post('id');
		$data['dosen'] = $this->absen->get_dosen();	
		$data['matakul'] = $this->absen->get_matakul();	
		$data['kelas'] = $this->absen->get_kelas();
		$data['kata'] = $this->model->ambildata();
		$this->load->view('vadmin/view_data_db',$data); 
		}
	}
	public function upload_add() //fungsi create
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		
		if(!empty($cek)){
		//================================
		if(!isset($_POST))
			show_404();
		
		if($this->model->upload_add())
			echo json_encode(array('success'=>true));
		else
			echo json_encode(array('msg'=>'Gagal memasukan data'));
		//============================
		}else{
				redirect('/cadmin/home/logout/','refresh');
		}
	}
	
	public function upload()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) and $level=='admin' or $level=="dosen"){
			$d['judul'] = $this->config->item('judul');
			$d['nama_perusahaan'] = $this->config->item('nama_perusahaan');
			$d['alamat_perusahaan'] = $this->config->item('alamat_perusahaan');
			$d['lisensi'] = $this->config->item('lisensi_app');
			
			$d['jam_now'] = $this->app_model->Jam_Now(); 
			$d['hari_now'] = $this->app_model->Hari_Bulan_Indo(); 
			$d['tgl_now'] = $this->app_model->tgl_now_indo();
			
			$id=$this->session->userdata('username');
			$nidn=$this->app_model->find_nidn($id);
			$d['temp_pinjam'] = $this->model->get_temp_pinjam($id);
			$d['record'] = $this->model->get_users($id);
			$d['upload'] = $this->model->get_berkas($nidn);
			$d['matakul'] = $this->absen->get_matakul();
			$d['nidn']= $nidn;
			$level=$this->session->userdata('level');
			$d['com'] = $this->model->get_complaint($level);
			$d['isi'] = $this->load->view('vadmin/upload', $d, true);
			
			$this->load->view('vadmin/media',$d);
		}else{
			$this->session->set_flashdata('result_login', '<font color="red">Sesi login habis atau terhapuskan.</font>');
			redirect('/cadmin/home/page_403','refresh');
		}
	}
	public function nidn_auto()
	{
		$q=$this->model->nidn_auto();
		echo json_encode(array($q));
	}
	public function upload_dokumen() //fungsi create
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		
		if(!empty($cek) and $level=="admin" or $level=="dosen"){
		//================================
		if(!isset($_POST))
			show_404();
		
		if($this->model->upload_dokumen())
			echo json_encode(array('success'=>true));
		else
			echo json_encode(array('msg'=>'Gagal memasukan data'));
		//============================
		}else{
				redirect('/cadmin/home/logout/','refresh');
		}
	}
	function download_materi(){
		$this->load->helper('download');
		$id = $this->uri->segment(4);
		$file=$this->model->get_berkas_id($id);
		$data=file_get_contents("./assets/upload/".$file);
		$nama=$file;
		force_download($nama,$data);
	}
	public function hapus_berkas($id)
	{
		$this->model->berkas_delete($id);
		echo json_encode(array("status" => TRUE));
		// redirect('/cadmin/home/upload/','refresh');
		
	}
	public function download()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek)){
			$d['judul'] = $this->config->item('judul');
			$d['nama_perusahaan'] = $this->config->item('nama_perusahaan');
			$d['alamat_perusahaan'] = $this->config->item('alamat_perusahaan');
			$d['lisensi'] = $this->config->item('lisensi_app');
			
			$d['jam_now'] = $this->app_model->Jam_Now(); 
			$d['hari_now'] = $this->app_model->Hari_Bulan_Indo(); 
			$d['tgl_now'] = $this->app_model->tgl_now_indo();
			$id=$this->session->userdata('username');
			$nidn=$this->uri->segment(4);
			
			if($nidn==""){
				$nidn=$this->app_model->find_nidn($id);
			}else{
				$nidn=$this->uri->segment(4);
			}
			
			
			$kodemk=$this->uri->segment(5);
			$level=$this->session->userdata('level');
			$d['com'] = $this->model->get_complaint($level);
			$d['temp_pinjam'] = $this->model->get_temp_pinjam($id);
			$d['record'] = $this->model->get_users($id);
			$d['upload'] = $this->model->get_berkas_download($nidn,$kodemk);
			$d['isi'] = $this->load->view('vadmin/download', $d, true);
			
			$this->load->view('vadmin/media',$d);
		}else{
			$this->session->set_flashdata('result_login', '<font color="red">Sesi login habis atau terhapuskan.</font>');
			redirect('./cadmin/home/logout/','refresh');
		}
	}
	public function chart_hadir()  
	{
		//chart_model dipanggil menjadi chart
		echo $this->chart->chart_hadir(); //
	}
	function listcontent(){
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){
			$d['judul'] = $this->config->item('judul');
			$d['nama_perusahaan'] = $this->config->item('nama_perusahaan');
			$d['alamat_perusahaan'] = $this->config->item('alamat_perusahaan');
			$d['lisensi'] = $this->config->item('lisensi_app');
			
			$d['jam_now'] = $this->app_model->Jam_Now(); 
			$d['hari_now'] = $this->app_model->Hari_Bulan_Indo(); 
			$d['tgl_now'] = $this->app_model->tgl_now_indo();
			$d['idmenu'] = $this->uri->segment(4);
			$d['record'] = $this->db->get('content');
			$id=$this->session->userdata('username');
			$nidn=$this->app_model->find_nidn($id);
			$d['temp_pinjam'] = $this->model->get_temp_pinjam($id);
			$d['record'] = $this->model->get_users($id);
			$d['upload'] = $this->model->get_berkas($nidn);
			$d['matakul'] = $this->absen->get_matakul();
			$d['nidn']= $nidn;
			$level=$this->session->userdata('level');
			$d['com'] = $this->model->get_complaint($level);
			
			$d['isi'] = $this->load->view('vadmin/listcontent', $d, true);
			
			$this->load->view('vadmin/media',$d);
		}else{
			$this->session->set_flashdata('result_login', '<font color="red">Sesi login habis atau terhapuskan.</font>');
			redirect('./cadmin/home/logout/','refresh');
		}
	}
	function contentpost(){
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){
			$d['judul'] 			= $this->config->item('judul');
			$d['nama_perusahaan'] 	= $this->config->item('nama_perusahaan');
			$d['alamat_perusahaan'] = $this->config->item('alamat_perusahaan');
			$d['lisensi'] 			= $this->config->item('lisensi_app');
			
			$d['jam_now'] = $this->app_model->Jam_Now(); 
			$d['hari_now'] = $this->app_model->Hari_Bulan_Indo(); 
			$d['tgl_now'] = $this->app_model->tgl_now_indo();
			$d['idmenu'] = $this->uri->segment(4);
			$d['record'] = $this->db->get('content');
			$id=$this->session->userdata('username');
			$nidn=$this->app_model->find_nidn($id);
			$d['temp_pinjam'] = $this->model->get_temp_pinjam($id);
			$d['record'] = $this->model->get_users($id);
			$d['upload'] = $this->model->get_berkas($nidn);
			$d['matakul'] = $this->absen->get_matakul();
			$d['nidn']= $nidn;
			$level=$this->session->userdata('level');
			$d['com'] = $this->model->get_complaint($level);
			
			$d['isi'] = $this->load->view('vadmin/contentpost', $d, true);
			
			$this->load->view('vadmin/media',$d);
		}else{
			$this->session->set_flashdata('result_login', '<font color="red">Sesi login habis atau terhapuskan.</font>');
			redirect('./cadmin/home/logout/','refresh');
		}
	}
	public function content_add() //fungsi create
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		
		if(!empty($cek) && $level=='admin'){
		//================================
		if(!isset($_POST))
			show_404();
		
		if($this->content->content_add())
			echo json_encode(array('success'=>true));
		else
			echo json_encode(array('msg'=>'Gagal memasukan data'));
		//============================
		}else{
				redirect('/cadmin/home/logout/','refresh');
		}
	}
	function contentedit(){
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){
			$d['judul'] = $this->config->item('judul');
			$d['nama_perusahaan'] = $this->config->item('nama_perusahaan');
			$d['alamat_perusahaan'] = $this->config->item('alamat_perusahaan');
			$d['lisensi'] = $this->config->item('lisensi_app');
			
			$d['jam_now'] = $this->app_model->Jam_Now(); 
			$d['hari_now'] = $this->app_model->Hari_Bulan_Indo(); 
			$d['tgl_now'] = $this->app_model->tgl_now_indo();
			
			$id=$this->session->userdata('username');
			$nidn=$this->app_model->find_nidn($id);
			$d['temp_pinjam'] = $this->model->get_temp_pinjam($id);
			$d['record'] = $this->model->get_users($id);
			$d['upload'] = $this->model->get_berkas($nidn);
			$d['matakul'] = $this->absen->get_matakul();
			$d['nidn']= $nidn;
			$level=$this->session->userdata('level');
			$d['com'] = $this->model->get_complaint($level);
			
			$id = $this->uri->segment(4);
			$d['rec'] = $this->db->get_where('content',array('id'=>$id))->row_array();
		
			$d['isi'] = $this->load->view('vadmin/contentedit', $d, true);
			
			$this->load->view('vadmin/media',$d);
		}else{
			$this->session->set_flashdata('result_login', '<font color="red">Sesi login habis atau terhapuskan.</font>');
			redirect('./cadmin/home/logout/','refresh');
		}
	}
	public function content_edit() //fungsi create
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		
		if(!empty($cek) && $level=='admin'){
		//================================
		if(!isset($_POST))
			show_404();
		
		if($this->content->content_edit())
			echo json_encode(array('success'=>true));
		else
			echo json_encode(array('msg'=>'Gagal memasukan data'));
		//============================
		}else{
				redirect('/cadmin/home/logout/','refresh');
		}
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/hone.php */