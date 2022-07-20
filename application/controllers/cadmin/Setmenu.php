<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Setmenu extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper('url');
		$this->load->model('Person_model','menu');
	}
	
	public function index()
	{
		$cek = $this->session->userdata('logged_in');
		
		if(!empty($cek)){
			
			$d['judul'] = $this->config->item('judul');
			$d['nama_perusahaan'] = $this->config->item('nama_perusahaan');
			$d['alamat_perusahaan'] = $this->config->item('alamat_perusahaan');
			$d['lisensi'] = $this->config->item('lisensi_app');
			$d['com'] = $this->model->get_complaint();
			$d['isi'] = $this->load->view('vadmin/setmenu', $d, true);		
			$this->load->view('vadmin/media',$d);
		}else{
			$this->session->set_flashdata('result_login', '<font color="red">Sesi login habis atau terhapuskan.</font>');
			redirect('/cadmin/home/logout/','refresh');
		}
	}
	
	public function ajax_list()
	{
		$list = $this->menu->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $menu) {
			$no++;
			$row = array();
			$row[] = '<div class="text-center">'.$menu->id.'</div>';
			$row[] = $menu->menu;
			$row[] = $menu->url;
			$row[] = '<div class="text-center">'.$menu->head.'</div>';
			$row[] = '<div class="text-center">'.$menu->idh.'</div>';
			$row[] = '<div class="text-center">'.$menu->enabled.'</div>';

			//add html for action
			$row[] = '<div class="text-center"><a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_menu('."'".$menu->id."'".')"><i class="glyphicon glyphicon-pencil"></i></a>
				  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_menu('."'".$menu->id."'".')"><i class="glyphicon glyphicon-trash"></i></a></div>';
		
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->menu->count_all(),
						"recordsFiltered" => $this->menu->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_edit($id)
	{
		$data = $this->menu->get_by_id($id);
		echo json_encode($data);
	}

	public function ajax_add()
	{
		$data = array(
				'menu' => $this->input->post('menu'),
				'url' => $this->input->post('url'),
				'head' => $this->input->post('head'),
				'idh' => $this->input->post('idh'),
				'icon' => $this->input->post('icon'),
				'enabled' => $this->input->post('enabled'),
			);
		$insert = $this->menu->save($data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_update()
	{
		$data = array(
				'menu' => $this->input->post('menu'),
				'url' => $this->input->post('url'),
				'head' => $this->input->post('head'),
				'idh' => $this->input->post('idh'),
				'icon' => $this->input->post('icon'),
				'enabled' => $this->input->post('enabled'),
			);
		$this->menu->update(array('id' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id)
	{
		$this->menu->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}
}

/* End of file setmenu.php */
/* Location: ./application/controllers/setmenu.php */