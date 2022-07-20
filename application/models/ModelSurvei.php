<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ModelSurvei extends CI_Model {
	var $table = 'survei_head';

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_query()
	{
		$this->db->select('survei_head.*, mahasiswa.nama');
		$this->db->from($this->table);

		if (isset($_GET['filter'])) {
			$filter = json_decode($this->input->get('filter'));
			if (isset($filter->q)) {
				$q = $filter->q;
				if ($q != '' || $q != null) {
					$this->db->where('survei_head.nim', $q);
				}
			}

			if (isset($filter->user_id)) {
				$user_id = $filter->user_id;
				if (isset($filter->permission)) {
					if ($filter->permission != 'superadmin') {
						if ($user_id != '' || $user_id != null) {
							$this->db->where('survei_head.nim', $user_id);
						}
					}
				}
			}
		}
		$this->db->join('mahasiswa', 'mahasiswa.nim = survei_head.nim');
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
		
	public function get_soal()
	{
		$this->db->select('*');
		$this->db->from('soal');
		$this->db->where('status','Y');
		$this->db->order_by('id','ASC');
		$query = $this->db->get();
		return $query->result();
	}
	public function get_soal_assisten()
	{
		$this->db->select('*');
		$this->db->from('assisten');
		$this->db->where('status','Y');
		$this->db->order_by('id','ASC');
		$query = $this->db->get();
		return $query->result();
	}
	function add_nilai(){
		date_default_timezone_set('Asia/Jakarta'); // PHP 6 mengharuskan penyebutan timezone.
		//hanya bisa satu kali postiing untuk nim yang sama 
		$nim=$this->input->post('nim',true);
		// $cek_nim=$this->app_model->cek_survei($nim);
		// if($cek_nim<=29){
		// 	return 0;
		// }else{
		//posting ke surver header 
		$this->db->insert('survei_head',array(
			'nim'	=>$this->input->post('nim',true),
			'tgl'	=>date("Y-m-d"),
			'keperluan'	=>$this->input->post('keperluan',true),
		));
		//buka soal 
		$text 	= "SELECT * FROM soal where status='Y'";
		$q = $this->db->query($text);
		if($q->num_rows()>0)
		{
			foreach($q->result() as $k)
			{
				if($k->id=="4"){
					
					$qu 	= "SELECT * FROM assisten where status='Y'";
					$r 		= $this->db->query($qu);

					foreach($r->result() as $a){
						$this->db->insert('survei_detail',array(
							'soal_id'	=>$this->input->post('soal_'.$k->id,true),
							'sh_id'		=>$this->app_model->get_IDSurvei(),
							'ass_nil'	=>$this->input->post('as'.$a->id,true),
							'ass_id'	=>$a->id,
						));
					}

				}else{
					$this->db->insert('survei_detail',array(
						'soal_id'	=>$this->input->post('soal_'.$k->id,true),
						'sh_id'		=>$this->app_model->get_IDSurvei(),
						'opsi'	=>$this->input->post('op'.$k->id,true),
					));
				}
			}
			$hasil = 1;
		}
		else
		{
			$hasil = 0;
		}
		return $hasil;
		// }
	}
	

}
