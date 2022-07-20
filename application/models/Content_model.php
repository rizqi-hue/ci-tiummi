<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Content_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	

	function view_content()
	{
		$id=$this->uri->segment(4);
		$this->db->where('idmenu',$id);
		$query = $this->db->get('content');
        return $query->result();
	}
	function get_content()
	{
		$id=$this->uri->segment(4);
		$this->db->where('id',$id);
		$query = $this->db->get('content');
        return $query->result();
	}
	
	public function get_berkas()
	{
		$this->db->get('berkas');
		// $this->db->where('id',$id);
		$query = $this->db->get('berkas');
		return $query->result();
	}
	public function get_berkas_download($id)
	{
		$q = $this->db->query("select * from berkas
			WHERE id='$id'
			group by id");
		if($q->num_rows()>0){
			foreach($q->result() as $k){
				$hasil = $k->berkas;
			}
		}else{
			$hasil = 0;
		}
		return $hasil;
	}
}
