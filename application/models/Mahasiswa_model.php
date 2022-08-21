<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mahasiswa_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
		
	var $table = 'mahasiswa';

	private function _get_query()
	{
		
		$this->db->select('*');
		$this->db->from($this->table);
		if(isset($_GET['pagination'])) {
			$pagination = json_decode($this->input->get('pagination'));
			$length = $pagination->perPage;
			$start = ($pagination->perPage * $pagination->page) - $pagination->perPage;
			$this->db->limit($length, $start);
		}

		if (isset($_GET['filter'])) {
			$filter = json_decode($this->input->get('filter'));
			if (isset($filter->q)) {
				$q = $filter->q;
				if ($q != '' || $q != null) {
					$this->db->like('nim', $q);
					$this->db->or_like('nama', $q);  // Produces: WHERE name != 'Joe' OR id > 50
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
		$query = $this->db->get()->result_array();
		return $query;
	}

	public function get_by_id($nim)
	{
		$this->db->select('*,DATE_FORMAT(tgllahir,"%d/%m/%Y") as tgl');
		$this->db->from($this->table);
		$this->db->where('nim',$nim);
		$query = $this->db->get();

		return $query->row();
	}

	public function get_where($array = array())
	{
		return $this->db->get_where($this->table, $array)->row();
	}

	public function save($data)
	{
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	public function store()
	{
		if ($this->input->post('id')) {
			$data = array(
				'id' => $this->input->post('id'),
				'nim' => $this->input->post('nim'),
				'nama' => $this->input->post('nama'),
				'tlahir' => $this->input->post('tlahir'),
				'tgllahir' => $this->input->post('tgllahir'),
				'jk' => $this->input->post('jk'),
				'alamat' => $this->input->post('alamat'),
				'jurusan' => $this->input->post('jurusan'),
				'telp' => $this->input->post('telp'),
				'telp_ortu' => $this->input->post('telp_ortu'),
			);

			if ($this->db->update($this->table, $data, ['id' => $this->input->post('id')])) {
				return $data;
			} else {
				return null;
			}
		} else {
			$data = array(
				'nim' => $this->input->post('nim'),
				'nama' => $this->input->post('nama'),
				'tlahir' => $this->input->post('tlahir'),
				'tgllahir' => $this->input->post('tgllahir'),
				'jk' => $this->input->post('jk'),
				'alamat' => $this->input->post('alamat'),
				'jurusan' => $this->input->post('jurusan'),
				'telp' => $this->input->post('telp'),
				'telp_ortu' => $this->input->post('telp_ortu'),
			);
			$this->db->insert($this->table, $data);
			if ($this->db->insert_id()) {
				$data = array(
					'id' => $this->db->insert_id(),
					'nim' => $this->input->post('nim'),
					'nama' => $this->input->post('nama'),
					'tlahir' => $this->input->post('tlahir'),
					'tgllahir' => $this->input->post('tgllahir'),
					'jk' => $this->input->post('jk'),
					'alamat' => $this->input->post('alamat'),
					'jurusan' => $this->input->post('jurusan'),
					'telp' => $this->input->post('telp'),
					'telp_ortu' => $this->input->post('telp_ortu'),
				);
	
				return $data;
			} else {
				return null;
			}
		}
	}


	public function delete($id)
	{
		$this->db->where('id', $id);
		return $this->db->delete($this->table);
	}

}
