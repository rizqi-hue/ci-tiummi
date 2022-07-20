<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ModelTempatiKelas extends CI_Model {

	var $table = 'tempati';

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
                'kelas_kode' => $this->input->post('kelas_kode'),
                'nim' => $this->input->post('nim'),
                'thpel' => $this->input->post('thpel'),
            );
            
            if ($this->db->update($this->table, $data, ['id' => $this->input->post('id')])) {
				return $data;
			} else {
				return null;
			}

        } else {
            $data = array(
                'kelas_kode' => $this->input->post('kelas_kode'),
                'nim' => $this->input->post('nim'),
                'thpel' => $this->input->post('thpel'),
            );

            $this->db->insert($this->table, $data);
			if ($this->db->insert_id()) {
				return $data = array(
						'id' => $this->db->insert_id(),
                        'kelas_kode' => $this->input->post('kelas_kode'),
                        'nim' => $this->input->post('nim'),
                        'thpel' => $this->input->post('thpel'),
					);
			} else {
				return null;
			}
        }
	}


	public function delete($id)
    {
		$this->db->where('id',  $id);
		return $this->db->delete($this->table);
	}

	public function get_where($array = array())
	{
		return $this->db->get_where($this->table, $array)->row();
	}
	
	public function cek_kelas()
	{

		$kelas=$this->input->post('kelas');
		$thpel=$this->input->post('thpel');
		$nim=$this->input->post('nim');
		$text 	= "SELECT * FROM tempati
					WHERE kelas_kode='$kelas'
					and nim='$nim'
					and thpel='$thpel'					
					";
		$q = $this->db->query($text); 
		if($q->num_rows()>0)
		{
			foreach($q->result() as $k)
			{
				$nim = $k->nim;
				$kelas = $k->kelas_kode;
				$hasil='Error, NIM '.$k->nim.' sudah ada di kelas '.$kelas;
			}
			$hasil = $hasil;
		}
		else
		{
			$hasil = "Okey, Kelas tersedia";
		}	
		return $hasil;
	}

}
