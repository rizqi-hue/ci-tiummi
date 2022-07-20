<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ModelPinjam extends CI_Model {
	var $table = 'pinjam_h';

    public function __construct()
	{
		parent::__construct();
	}

	private function _get_query()
	{
		$this->db->select('pinjam_h.*, mahasiswa.nama');
		$this->db->from($this->table);

		if(isset($_GET['pagination'])) {
			$pagination = json_decode($this->input->get('pagination'));
			$length = $pagination->perPage;
			$start = ($pagination->perPage * $pagination->page) - $pagination->perPage;
			$this->db->limit($length, $start);
		}

		if (isset($_GET['filter'])) {
			$filter = json_decode($this->input->get('filter'));

			if (isset($filter->user_id)) {
				$user_id = $filter->user_id;
				if (isset($filter->permission)) {
					if ($filter->permission != 'superadmin') {
						if ($user_id != '' || $user_id != null) {
							$this->db->where('pinjam_h.nim', $user_id);
						}
					}
				}
			}
		}

		$this->db->join('mahasiswa', 'mahasiswa.nim = pinjam_h.nim');
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
		// echo json_encode($_POST);

        if ($this->input->post('id')) {
            $data = array(
				'id' => $this->input->post('id'),
				'nim' 			=> $this->input->post('nim'),
                'tgl' 			=> $this->input->post('tgl'),
                'tglkembali' 	=> $this->input->post('tglkembali'),
                'ket' 		=> $this->input->post('ket'),
                'user_id' 		=> 1,
                'status' 	=> $this->input->post('status'),
            );

            if ($this->db->update($this->table, $data, ['id' => $this->input->post('id')])) {
				$this->db->where('idh', $this->input->post('id'));
				$this->db->delete('pinjam_d');

				$inventori = json_decode($this->input->post('inventori'));
				$pinjam_detail = array();
				foreach($inventori as $field) {
					array_push($pinjam_detail, [
						'idh' => $this->input->post('id'),
						'kode' => $field->kode,
						'qty' => $field->qty
					]);
				}

				$this->db->insert_batch('pinjam_d', $pinjam_detail);

				return $data;
			} else {
				return null;
			}

        } else {
			// 0 menunggu 1 disetujui 2 ditolak 3 dipinjam 4 dikembalikan
            $data = array(
                'nim' 		=> $this->input->post('nim'),
                'tgl' 		=> $this->input->post('tgl'),
                'tglkembali' 		=> $this->input->post('tglkembali'),
                'ket' 		=> $this->input->post('ket'),
                'user_id' 		=> 1,
                'status' 	=> '0',
            );

			$this->db->insert($this->table, $data);
			if ($this->db->insert_id()) {

				$inventori = json_decode($this->input->post('inventori'));
				$pinjam_detail = array();
				foreach($inventori as $field) {
					array_push($pinjam_detail, [
						'idh' => $this->db->insert_id(),
						'kode' => $field->kode,
						'qty' => $field->qty
					]);
				}

				$this->db->insert_batch('pinjam_d', $pinjam_detail);

				return $data = array(
					'id' => $this->db->insert_id(),
					'nim' 		=> $this->input->post('nim'),
					'tgl' 		=> $this->input->post('tgl'),
					'tglkembali' 		=> $this->input->post('tglkembali'),
					'ket' 		=> $this->input->post('ket'),
					'user_id' 		=> 1,
					'status' 	=> '1',
				);

			} else {
				return null;
			}
        }
    }

    public function setStatus() {
        $data = array(
            'status' 	=> $this->input->post('status'),
        );

        $this->db->where('id', $this->input->post('id'));
        return $this->db->update($this->table, $data);
    }

    public function delete($id) {
		$this->db->where('id',  $id);
		return $this->db->delete($this->table);
	}

	public function get_where($array = array()) {
		return $this->db->get_where($this->table, $array)->row();
	}

	public function show($array = array()) {
		$pinjam_h = $this->db->get_where($this->table, $array)->row();
		$pinjam_h->inventori = $this->db->get_where('pinjam_d' , ['idh' => $pinjam_h->id])->result_array();
		return $pinjam_h;

	}

}
