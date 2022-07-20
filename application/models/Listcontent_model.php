<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Listcontent_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
		
	var $table = 'content';
	var $column_order = array('id','idmenu','judul_content','isi_content',null); //set column field database for datatable orderable
	var $column_search = array('idmenu','judul_content','isi_content'); //set column field database for datatable searchable just firstname , lastname , address are searchable
	var $order = array('id' => 'asc'); // default order 


	
	private function _get_datatables_query()
	{
		$id = $this->uri->segment(4); //idmenu
		$this->db->from($this->table);
		$this->db->where('idmenu',$id);
		$i = 0;
	
		foreach ($this->column_search as $item) // loop column 
		{
			if($_POST['search']['value']) // if datatable send POST for search
			{
				
				if($i===0) // first loop
				{
					$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$this->db->like($item, $_POST['search']['value']);
					
				}
				else
				{
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if(count($this->column_search) - 1 == $i) //last loop
					$this->db->group_end(); //close bracket
			}
			$i++;
		}
		
		if(isset($_POST['order'])) // here order processing
		{
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->order))
		{
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function get_datatables()
	{
		$this->_get_datatables_query();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered()
	{
		$this->_get_datatables_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}

	public function get_by_id($id)
	{
		$this->db->from($this->table);
		$this->db->where('id',$id);
		$query = $this->db->get();

		return $query->row();
	}

	public function save($data)
	{
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	public function update($where, $data)
	{
		$this->db->update($this->table, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_by_id($id)
	{
		$this->db->where('id', $id);
		$this->db->delete($this->table);
	}
	
	function content_add(){
		if(isset($_POST['simpan'])){
					$pattern=array();
					$pattern[0]="&lt;iframe";
					$pattern[1]="&lt;/iframe&gt;";
					$pattern[2]="&gt;";
					
					$replacement=array();
					$replacement[0]="<iframe";
					$replacement[1]="</iframe>";
					$replacement[2]=">";
					$data = array(
						'judul_content' => $this->input->post('judul',true),
						'isi_content'	=> str_replace($pattern,$replacement,$this->input->post('isi',true)),
						'idmenu'		=> $this->input->post('idmenu',true)
						);
					$this->db->insert('content',$data);
					redirect('cadmin/home/listcontent/'.$this->input->post('idmenu',true));
	
	        
		}else{
			$data['title'] = 'Modul Halaman';
			$this->template->load('vadmin/media/','vadmin/home',$data);
		}
	}
	
	function content_edit(){
		if(isset($_POST['simpan'])){
					$pattern=array();
					$pattern[0]="&lt;iframe";
					$pattern[1]="&lt;/iframe&gt;";
					$pattern[2]="&gt;";
					
					$replacement=array();
					$replacement[0]="<iframe";
					$replacement[1]="</iframe>";
					$replacement[2]=">";
			
					$data = array(
						'judul_content' => $this->input->post('judul',true),
						'isi_content'	=> str_replace($pattern,$replacement,$this->input->post('isi',true)),
						'idmenu'		=> $this->input->post('idmenu',true)
						);
					$this->db->where('id',$this->input->post('id',true));
					$this->db->update('content',$data);
					redirect('cadmin/home/listcontent/'.$this->input->post('idmenu',true));
	
	        
		}else{
			$data['title'] = 'Modul Halaman';
			$this->template->load('vadmin/media/','vadmin/home',$data);
		}
	}
	
	function upload_add(){
		if(isset($_POST['upload'])){
			if ($_FILES['berkas']['error'] <> 4) {

	            $config['upload_path'] = './assets/upload';
	            $config['allowed_types'] = 'jpg|png|gif|bmp|zip|doc|xls|docx|xlsx|ppt|pptx|rar|pdf';
	            $this->load->library('upload', $config);
				$this->upload->set_allowed_types('*');
	            if (!$this->upload->do_upload('berkas')) {
	                $error = array('error' => $this->upload->display_errors());
	                $this->index($error);
	            } else {
	                $hasil 	= $this->upload->data();
					$data = array(
						'nama'		=> $this->input->post('nama'),
						'berkas'	=> $hasil['file_name']);
					// $this->db->where('id',$this->input->post('id',true));
					$this->db->insert('berkas',$data);
					redirect('cadmin/home/upload/succ');
		        }
	        } else {
				redirect('cadmin/home/upload/err');
	        }
		}else{
			$data['berkas']=$this->db->get('berkas');
			$this->load->view('vadmin/media','vadmin/upload',$data);
		}
	}
	public function get_berkas()
	{
		$this->db->get('berkas');
		// $this->db->where('id',$id);
		$query = $this->db->get('berkas');
		return $query->result();
	}
	public function berkas_delete($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('berkas');
		
	}
}
