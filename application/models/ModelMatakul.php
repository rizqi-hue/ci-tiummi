<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ModelMatakul extends CI_Model {

    var $table = 'matakul';

	public function __construct()
	{
		parent::__construct();
	}

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
					$this->db->like('kode', $q);
					$this->db->or_like('matakul', $q);  // Produces: WHERE name != 'Joe' OR id > 50
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

    public function insert()
	{
        if ($this->input->post('id')) {

            $data = array(
				'id' => $this->input->post('id'),
                'kode' => $this->input->post('kode'),
                'matakul' => $this->input->post('matakul'),
                'sks' => $this->input->post('sks'),
                'temu' => $this->input->post('temu'),
            );

            if ($this->db->update($this->table, $data, ['id' => $this->input->post('id')])) {
				return $data;
			} else {
				return null;
			}

        } else {

            $data = array(
                'kode' => $this->input->post('kode'),
                'matakul' => $this->input->post('matakul'),
                'sks' => $this->input->post('sks'),
                'temu' => $this->input->post('temu'),
            );

            $this->db->insert($this->table, $data);
			if ($this->db->insert_id()) {
				return $data = array(
						'id' => $this->db->insert_id(),
                        'kode' => $this->input->post('kode'),
                        'matakul' => $this->input->post('matakul'),
                        'sks' => $this->input->post('sks'),
                        'temu' => $this->input->post('temu'),
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
