<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ModelInventoriMaintenance extends CI_Model {

	var $table = 'inventori_maintenance';

	public function __construct()
	{
		parent::__construct();
	}

	private function _get_query()
	{
		$this->db->select('inventori_maintenance.*, users.namalengkap, inventori.nama');
		$this->db->from($this->table);

		if (isset($_GET['filter'])) {
			$filter = json_decode($this->input->get('filter'));
			if (isset($filter->q)) {
				$q = $filter->q;
				if ($q != '' || $q != null) {
					$this->db->like('inventori_maintenance.jenis', $q);
					$this->db->or_like('inventori_maintenance.kode_inventori', $q);  // Produces: WHERE name != 'Joe' OR id > 50
				}
			}
		}

		if (isset($_GET['id'])) {
			$this->db->where('inventori_maintenance.kode', $_GET['id']);
		}

		$this->db->join('inventori', 'inventori.kode = inventori_maintenance.kode');
		$this->db->join('users', 'users.user_id = inventori_maintenance.user_id');

		// $this->db->group_by('inventori_maintenance.kode');
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
				'no_maintenance' => $this->input->post('no_maintenance'),
				'kode' => $this->input->post('kode'),
				'jenis' => $this->input->post('jenis'),
				'ruangan' => $this->input->post('ruanga'),
				'uraian' => $this->input->post('uraian'),
				'keterangan' => $this->input->post('keterangan'),
				'user_id' => $this->input->post('user_id'),
				'tanggal' => $this->input->post('tanggal'),
			);

			if ($this->db->update($this->table, $data, ['id' => $this->input->post('id')])) {
				return $data;
			} else {
				return null;
			}

		}else {

			
			$data = array(
				'no_maintenance' => $this->input->post('no_maintenance'),
				'kode' => $this->input->post('kode'),
				'jenis' => $this->input->post('jenis'),
				'ruangan' => $this->input->post('ruanga'),
				'uraian' => $this->input->post('uraian'),
				'keterangan' => $this->input->post('keterangan'),
				'user_id' => $this->input->post('user_id'),
				'tanggal' => $this->input->post('tanggal'),
			);

			$this->db->insert($this->table, $data);
			if ($this->db->insert_id()) {
				return $data = array(
						'id' => $this->db->insert_id(),
						'no_maintenance' => $this->input->post('no_maintenance'),
						'kode' => $this->input->post('kode'),
						'jenis' => $this->input->post('jenis'),
						'ruangan' => $this->input->post('ruanga'),
						'uraian' => $this->input->post('uraian'),
						'keterangan' => $this->input->post('keterangan'),
						'user_id' => $this->input->post('user_id'),
						'tanggal' => $this->input->post('tanggal'),
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
