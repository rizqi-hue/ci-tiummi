<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ModelWhatsapp extends CI_Model {

	var $table = 'whatsapp';
	
	public function __construct()
	{
		parent::__construct();
	}

	private function _get_query()
	{
		
		$this->db->from($this->table);
		
		if (isset($_GET['filter'])) {
			$filter = json_decode($this->input->get('filter'));
			if (isset($filter->q)) {
				$q = $filter->q;
				if ($q != '' || $q != null) {
					$this->db->like('nama', $q);
					$this->db->or_like('no_hp', $q);  // Produces: WHERE name != 'Joe' OR id > 50
				}
			}
		}

		$this->db->order_by('id', 'DESC');
	}

	function count_filtered()
	{
		$this->_get_query();
		$query = $this->db->get();
		return $query->num_rows();
	}
	
	public function count_all()
	{
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}
	
	public function select()
	{
		$this->_get_query();

		if(isset($_GET['pagination'])) {
			$pagination = json_decode($this->input->get('pagination'));
			$length = $pagination->perPage;
			$start = ($pagination->perPage * $pagination->page) - $pagination->perPage;
			$this->db->limit($length, $start);
		}

		$query = $this->db->get()->result_array();
		return $query;
	}

    public function insert()
    {
		if ($this->input->post('id')) {
			$data = array(
				'id' => $this->input->post('id'),
				'nama'	=> $this->input->post('nama',true),
				'message'=> $this->input->post('message',true),
				'no_hp'	=> $this->input->post('no_hp',true),
				'status'=> $this->input->post('status',true),
				'action'=> $this->input->post('action',true),
			);

			if ($this->db->update($this->table, $data, ['id' => $this->input->post('id')])) {
				return $data;
			} else {
				return null;
			}

		} else {

			$action = $this->input->post('action');
			if ($action == null || $action == '') {
				$action = 'Sedang Mengirim';
			}

			$data = array(
				'nama'	=> $this->input->post('nama',true),
				'message'	=> $this->input->post('message',true),
				'no_hp'	=> $this->input->post('no_hp',true),
				'status'	=> $this->input->post('status',true),
				'action'	=> $action,
			);
			
			$this->db->insert($this->table, $data);
			if ($this->db->insert_id()) {
				return $data = array(
						'id' => $this->db->insert_id(),
						'nama'	=>$this->input->post('nama',true),
						'message'	=>$this->input->post('message',true),
						'no_hp'	=>$this->input->post('no_hp',true),
						'status'	=>$this->input->post('status',true),
						'action'	=> $action
					);
			} else {
				return null;
			}
		}
    }


	public function delete($id) {
		$this->db->where('id',  $id);
		return $this->db->delete($this->table);
	}

	public function get_where($array = array())
	{
		return $this->db->get_where($this->table, $array)->row();
	}
}