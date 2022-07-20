<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Listcontent extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper('url');
		$this->load->model('Listcontent_model','content');
	}
	
	public function ajax_list()
	{
		
		$id = $this->uri->segment(4);
		$list = $this->content->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $content) {
			$no++;
			$row = array();
			$row[] = $content->judul_content;
			$row[] = $this->app_model->find_menu($content->idmenu);
			$row[] = htmlentities(substr($content->isi_content,0,200)).'...';
			
			

			//add html for action
			$row[] = '<a class="btn btn-sm btn-primary" href="'.base_url('cadmin/home/contentedit/'.$content->id.'').'" title="Edit" onclick="edit_content('."'".$content->id."'".')"><i class="glyphicon glyphicon-pencil"></i></a>
				  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_content('."'".$content->id."'".')"><i class="glyphicon glyphicon-trash"></i></a>
				  <a class="btn btn-sm btn-primary" href="'.base_url('cadmin/home/contentshow/'.$content->id.'').'" target="_self" title="View"><i class="glyphicon glyphicon-new-window"></i></a>';
		
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->content->count_all(),
						"recordsFiltered" => $this->content->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_edit($id)
	{
		$data = $this->content->get_by_id($id);
		echo json_encode($data);
	}

	public function ajax_add()
	{
		$data = array(
				'content' => $this->input->post('content'),
				'url' => $this->input->post('url'),
				'head' => $this->input->post('head'),
				'idh' => $this->input->post('idh'),
				'icon' => $this->input->post('icon'),
				'enabled' => $this->input->post('enabled'),
			);
		$insert = $this->content->save($data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_update()
	{
		$data = array(
				'content' => $this->input->post('content'),
				'url' => $this->input->post('url'),
				'head' => $this->input->post('head'),
				'idh' => $this->input->post('idh'),
				'icon' => $this->input->post('icon'),
				'enabled' => $this->input->post('enabled'),
			);
		$this->content->update(array('id' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id)
	{
		$this->content->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}
}

/* End of file listcontent.php */
/* Location: ./application/controllers/listcontent.php */