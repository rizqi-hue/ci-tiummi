<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ModelJurusan extends CI_Model {

	var $table = 'jurusan';
	
	public function __construct()
	{
		parent::__construct();
	}

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
	
    public function insert()
    {
		if ($this->input->post('id')) {
			$data = array(
				'id' => $this->input->post('id'),
				'fakultas'	=> $this->input->post('fakultas',true),
				'prodi'		=> $this->input->post('prodi',true),
				'jurusan'	=> $this->input->post('jurusan',true),
				'sing_jur'	=> $this->input->post('sing_jur',true),
			);

			if ($this->db->update($this->table, $data, ['id' => $this->input->post('id')])) {
				return $data;
			} else {
				return null;
			}
			
		} else {
			$data = array(
				'fakultas'	=> $this->input->post('fakultas',true),
				'prodi'		=> $this->input->post('prodi',true),
				'jurusan'	=> $this->input->post('jurusan',true),
				'sing_jur'	=> $this->input->post('sing_jur',true),
			);
			$this->db->insert($this->table, $data);
			if ($this->db->insert_id()) {
				return $data = array(
					'id' => $this->db->insert_id(),
					'fakultas'	=> $this->input->post('fakultas',true),
					'prodi'		=> $this->input->post('prodi',true),
					'jurusan'	=> $this->input->post('jurusan',true),
					'sing_jur'	=> $this->input->post('sing_jur',true),
				);
			} else {
				return null;
			}
		}
    }

	public function update()
    {
        return $this->db->update($this->table,array(
			'fakultas'	=> $this->input->post('fakultas',true),
			'prodi'		=> $this->input->post('prodi',true),
			'jurusan'	=> $this->input->post('jurusan',true),
			'sing_jur'	=> $this->input->post('sing_jur',true),
		), ['id' => $this->input->post('id')]);
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