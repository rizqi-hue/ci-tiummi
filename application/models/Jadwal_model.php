<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jadwal_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
		
	var $table = 'jadwal';
	var $column_order = array('id','matakul_kode','hari_kode','jam_kode','nidn','kelas_kode','smt','thpel'); //set column field database for datatable orderable
	var $column_search = array('id','matakul_kode','hari_kode','jam_kode','nidn','kelas_kode','smt','thpel'); //set column field database for datatable searchable just firstname , lastname , address are searchable
	var $order = array('id' => 'asc'); // default order 
	
	private function _get_datatables_query()
	{
		
		$this->db->from($this->table);
		$i = 0;
		foreach ($this->column_search as $item) // loop column 
		{
			if($_POST['search']['value']) // if datatable send POST for search
			{
				
				if($i===0) // first loop
				{
					$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$this->db->like($item, $_POST['search']['value']);
				}
				else
				{
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if(count($this->column_search) - 1 == $i) //last loop
					$this->db->group_end(); //close bracket
			}
			$i++;
		}
		
		if(isset($_POST['order'])) // here order processing
		{
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->order))
		{
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function get_datatables()
	{
		$this->_get_datatables_query();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered()
	{
		$this->_get_datatables_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}

	public function get_by_id($kode)
	{
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->where('id',$kode);
		$query = $this->db->get();

		return $query->row();
	}

	public function save($data)
	{
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	public function update($where, $data)
	{
		$this->db->update($this->table, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_by_id($id)
	{
		$this->db->where('id', $id);
		$this->db->delete($this->table);
	}
	
	public function get_dosen()
	{
		$this->db->select('*');
		$this->db->from('dosen');
		$this->db->order_by('nama','ASC');
		// $this->db->where('id',$id);
		$query = $this->db->get();
		return $query->result();
	}
	public function get_matakul()
	{
		$this->db->select('*');
		$this->db->from('matakul');
		$this->db->order_by('kode','ASC');
		// $this->db->where('id',$id);
		$query = $this->db->get();
		return $query->result();
	}
	public function get_kelas()
	{
		$this->db->select('*');
		$this->db->from('kelas');
		$this->db->order_by('kode','ASC');
		// $this->db->where('id',$id);
		$query = $this->db->get();
		return $query->result();
	}
	public function cek_jadwal()
	{
		$hari=$this->input->post('hari');
		$jam=$this->input->post('jam');
		$smt=$this->input->post('smt');
		$kelas=$this->input->post('kelas');
		$thpel=$this->input->post('thpel');
		$lab=$this->input->post('lab');
		$text 	= "SELECT * FROM jadwal 
					WHERE hari_kode='$hari'
					and jam_kode='$jam'
					
					and lab='$lab'
					and thpel='$thpel'
					and smt='$smt'
					
					";
		$q = $this->db->query($text); 
		if($q->num_rows()>0)
		{
			foreach($q->result() as $k)
			{
				$hari = $this->app_model->find_hari($k->hari_kode);
				$jam = $this->app_model->find_jam($k->jam_kode);
				$hasil='Error, Jam '.$jam.' Hari: '.$hari.' sudah ada, ubah jam dan hari';
			}
			$hasil = $hasil;
		}
		else
		{
			$hasil = "Sukses, Jadwal Belum ada dan lajutkan ke penyimpanan";
		}	
		return $hasil;
	}
	
	public function view_jadwal() 
	{ //okey ini mah
		
		$smt=$this->input->post('smt');
		$kelas=$this->input->post('kelas');
		$thpel=$this->input->post('thpel');
		$lab=$this->input->post('lab');
		$nidn=$this->input->post('nidn');
		$query = $this->db->query("SELECT * FROM jam order by kode asc");
		// return $query;
		return $query->result();
		
	}
	
}
