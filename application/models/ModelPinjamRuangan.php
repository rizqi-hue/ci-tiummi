<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ModelPinjamRuangan extends CI_Model {
	var $table = 'pinjam_ruangan_h';

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

			if (isset($filter->user_id)) {
				$user_id = $filter->user_id;
				if (isset($filter->permission)) {
					if ($filter->permission != 'superadmin') {
						if ($user_id != '' || $user_id != null) {
							$this->db->where('pinjam_ruangan_h.nim', $user_id);
						}
					}
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
		// echo json_encode($_POST);

        if ($this->input->post('id')) {
            $data = array(
				'id' => $this->input->post('id'),
				'tanggal_pengajuan' 			=> date('d/m/y'),
                'tanggal_pemakaian' 			=> $this->input->post('tanggal_pemakaian'),
                'tanggal_selesai' 				=> $this->input->post('tanggal_selesai'),
                'nama_peminjam' 				=> $this->input->post('nama_peminjam'),
                'keperluan' 					=> $this->input->post('keperluan'),
                'status' 						=> $this->input->post('status'),
            );

            if ($this->db->update($this->table, $data, ['id' => $this->input->post('id')])) {
				$this->db->where('idh', $this->input->post('id'));
				$this->db->delete('pinjam_ruangan_d');

				$ruangan = json_decode($this->input->post('ruangan'));
				$pinjam_detail = array();
				foreach($ruangan as $field) {
					array_push($pinjam_detail, [
						'idh' => $this->input->post('id'),
						'kode' => $field->kode,
					]);
				}

				$this->db->insert_batch('pinjam_ruangan_d', $pinjam_detail);

				return $data;
			} else {
				return null;
			}

        } else {
			// 0 menunggu 1 disetujui 2 ditolak 3 dipinjam 4 dikembalikan
            $data = array(
				'tanggal_pengajuan' 			=> date('d/m/y'),
                'tanggal_pemakaian' 			=> $this->input->post('tanggal_pemakaian'),
                'tanggal_selesai' 				=> $this->input->post('tanggal_selesai'),
                'nama_peminjam' 				=> $this->input->post('nama_peminjam'),
                'keperluan' 					=> $this->input->post('keperluan'),
                'status' 						=> '0',
            );

			$this->db->insert($this->table, $data);
			if ($this->db->insert_id()) {

				$ruangan = json_decode($this->input->post('ruangan'));
				$pinjam_detail = array();
				foreach($ruangan as $field) {
					array_push($pinjam_detail, [
						'idh' => $this->db->insert_id(),
						'kode' => $field->kode,
					]);
				}

				$this->db->insert_batch('pinjam_ruangan_d', $pinjam_detail);

				return $data = array(
					'id' => $this->db->insert_id(),
					'tanggal_pengajuan' 			=> date('d/m/y'),
					'tanggal_pemakaian' 			=> $this->input->post('tanggal_pemakaian'),
					'tanggal_selesai' 				=> $this->input->post('tanggal_selesai'),
					'nama_peminjam' 				=> $this->input->post('nama_peminjam'),
					'keperluan' 					=> $this->input->post('keperluan'),
					'status' 						=> '0',
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
		$pinjam_h->ruangan = $this->db->get_where('pinjam_ruangan_d' , ['idh' => $pinjam_h->id])->result_array();
		return $pinjam_h;
	}

}
