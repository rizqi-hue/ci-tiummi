<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: *");
        header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
        header('Content-Type: application/json');
	}
		
	var $table = 'users';
	
	private function _get_query()
	{
		
		$this->db->from($this->table);
		if(isset($_GET['pagination'])) {
			$pagination = json_decode($this->input->get('pagination'));
			$length = $pagination->perPage;
			$start = ($pagination->perPage * $pagination->page) - $pagination->perPage;
			$this->db->limit($length, $start);
		}

		$this->db->order_by('id', 'DESC');
		// $i = 0;
		// foreach ($this->column_search as $item) // loop column 
		// {
		// 	if($_POST['search']['value']) // if datatable send POST for search
		// 	{
				
		// 		if($i===0) // first loop
		// 		{
		// 			$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
		// 			$this->db->like($item, $_POST['search']['value']);
		// 		}
		// 		else
		// 		{
		// 			$this->db->or_like($item, $_POST['search']['value']);
		// 		}
		
		// 		if(count($this->column_search) - 1 == $i) //last loop
		// 			$this->db->group_end(); //close bracket
		// 	}
		// 	$i++;
		// }
		
		// if(isset($_POST['order'])) // here order processing
		// {
		// 	$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		// } 
		// else if(isset($this->order))
		// {
		// 	$order = $this->order;
		// 	$this->db->order_by(key($order), $order[key($order)]);
		// }
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
		$query = $this->db->get()->result_array();
		return $query;
	}

	public function get_by_id($id)
	{
		$this->db->from($this->table);
		$this->db->where('id',$id);
		$query = $this->db->get();

		return $query->row();
	}

	public function store()
	{
		
		if ($this->input->post('id')) {
			$data = array(
				'id' => $this->input->post('id'),
				'user_id' => $this->input->post('user_id'),
				'password' => $this->input->post('password'),
				'level' => 'super admin',
				'namalengkap' => $this->input->post('namalengkap'),
				'nim' => '',
			);
	
			if ($this->db->update($this->table, $data, ['id' => $this->input->post('id')])) {
				return $data;
			} else {
				return null;
			}

		} else {
			$data = array(
				'user_id' => $this->input->post('user_id'),
				'password' => $this->input->post('password'),
				'level' => 'super admin',
				'namalengkap' => $this->input->post('namalengkap'),
				'nim' => '',
			);

			$this->db->insert($this->table, $data);
			if ($this->db->insert_id()) {
				return $data = array(
					'id' => $this->db->insert_id(),
					'user_id' => $this->input->post('user_id'),
					'password' => $this->input->post('password'),
					'level' => 'super admin',
					'namalengkap' => $this->input->post('namalengkap'),
					'nim' => '',
				);
			} else {
				return null;
			}
		}
	}

	public function update()
	{
		
	}


	public function delete($id)
	{
		$this->db->where('id', $id);
		return $this->db->delete($this->table);
	}
	
	public function get_where($array = array())
	{
		return $this->db->get_where($this->table, $array)->row();
	}

}
