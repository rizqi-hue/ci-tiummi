<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pinjam_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
		
	var $table = 'inventori';
	var $column_order = array('kode','nama','kategori','tgl'); //set column field database for datatable orderable
	var $column_search = array('kode','nama','kategori','tgl'); //set column field database for datatable searchable just firstname , lastname , address are searchable
	var $order = array('kode' => 'asc'); // default order 
	

	
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
	function get_datatables_temp()
	{
		$this->db->select('*');
		$this->db->from('temp_pinjam');
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}
	
	
	function get_mahasiswa()
	{
		$this->db->select('*');
		$this->db->from('mahasiswa');
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

	public function get_by_id($id)
	{
		$this->db->select('*,DATE_FORMAT(tgl,"%d/%m/%Y") as tglin');
		$this->db->from($this->table);
		$this->db->where('kode',$id);
		$query = $this->db->get();

		return $query->row();
	}
	public function temp_get_by_id($id)
	{
		$this->db->select('*');
		$this->db->from('temp_pinjam');
		$this->db->where('id',$id);
		$query = $this->db->get();

		return $query->row();
	}

	public function save($data)
	{
		$this->db->insert('temp_pinjam', $data);
		return $this->db->insert_id();
	}
	public function save_ph($data)
	{
		$this->db->insert('pinjam_h', $data);
		return $this->db->insert_id();
	}
	public function save_pd($data)
	{
		$this->db->insert('pinjam_d', $data);
		return $this->db->insert_id();
	}
	public function save_adjust($data)
	{
		$this->db->insert('adjust_inv', $data);
		return $this->db->insert_id();
	}
	public function update($where, $data)
	{
		$this->db->update('temp_pinjam', $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_by_id($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('temp_pinjam');
	}
	public function delete_temp($id)
	{
		$this->db->where('user_id', $id);
		$this->db->delete('temp_pinjam');
	}
	public function get_bukti_pinjam($id)
	{
		$this->db->select('*');
		$this->db->from('pinjam_h');
		$this->db->order_by('id','desc');
		// $this->db->where('user_id',$id);
		
		$query = $this->db->get();
		return $query->result();
	}
	
	public function kembalikan()
	{
		date_default_timezone_set("Asia/Jakarta");
		$now=date("Y-m-d");
		$id=$this->input->post('id',true);
		$q = $this->db->query("select *
			from pinjam_d where idh='$id'");	
		if($q->num_rows()>0){
			foreach($q->result() as $k){
				$id 	= $k->idh;
				$kode 	= $k->inv_kode;
				$qty 	= $k->qty;
				
				$this->db->insert('adjust_inv',array(
				'inv_kode'=>$kode,
				'tgl'	  =>$now,
				'qty'	=>$qty
				));
			}//jika ditemukan lakukan edit data 
			
			$this->db->where('id', $id);
			return $this->db->update('pinjam_h',array(
				'status'=>'1',
			));
			
		}else{
			//apabila tidak ditemukan maka lakukan entri data 
			return 0;
		}
		
		
		
	}
	

}
