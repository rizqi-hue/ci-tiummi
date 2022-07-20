<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Absen_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
		
	var $table = 'absen';
	var $column_order = array('id'); //set column field database for datatable orderable
	var $column_search = array('id'); //set column field database for datatable searchable just firstname , lastname , address are searchable
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
	public function cek_absen()
	{
		$hari=$this->input->post('hari');
		$jam=$this->input->post('jam');
		$smt=$this->input->post('smt');
		$kelas=$this->input->post('kelas');
		$thpel=$this->input->post('thpel');
		$lab=$this->input->post('lab');
		$text 	= "SELECT * FROM absen 
					WHERE hari_kode='$hari'
					and jam_kode='$jam'
					and kelas_kode='$kelas'
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
			$hasil = "Sukses, absen Belum ada dan lajutkan ke penyimpanan";
		}	
		return $hasil;
	}
	
	public function view_absen() 
	{ //okey ini mah
		
		$smt=$this->input->post('smt');
		$kelas=$this->input->post('kelas');
		$thpel=$this->input->post('thpel');
		$lab=$this->input->post('lab');
		$query = $this->db->query("SELECT 
				a.nim,a.nama,
				b.kelas_kode,
				c.kelas
				FROM mahasiswa as a
				inner join tempati as b 
				on a.nim=b.nim
				inner join kelas as c 
				on b.kelas_kode=c.kode
				where b.kelas_kode='$kelas'
				and b.thpel='$thpel'
				order by a.nama asc");
		// return $query;
		return $query->result();
		
	}
	public function view_lihat_absen() 
	{ //okey ini mah
		
		$smt=$this->input->post('smt');
		$kelas=$this->input->post('kelas');
		$thpel=$this->input->post('thpel');
		$matakul=$this->input->post('matakul');
		
		$query = $this->db->query("SELECT 
				distinct(d.nim) as nim,
				a.nama,
				b.kelas_kode,
				c.kelas
				FROM mahasiswa as a
				inner join tempati as b 
				on a.nim=b.nim
				inner join kelas as c 
				on b.kelas_kode=c.kode
				inner join absen as d 
				on a.nim=d.nim
				where b.kelas_kode='$kelas'
				and b.thpel='$thpel'
				and d.smt='$smt'
				and d.matakul='$matakul'
				group by d.nim
				order by a.nama asc");
		// return $query;
		return $query->result();
		
	}
	public function get_kuliah($id)
	{
		$this->db->select('matakul,DATE_FORMAT(tgl,"%d-%m-%Y %H:%i:%s") as tgl');
		$this->db->from('absen');
		$this->db->where('nim',$id);
		$this->db->where('DATE_FORMAT(tgl,"%Y-%m-%d")=DATE_FORMAT(NOW(),"%Y-%m-%d")');
		$query = $this->db->get();
		return $query->result();
	}
	public function add_absen()
	{
		date_default_timezone_set("Asia/Jakarta");
		$nim=$this->input->post('nim',true);
		$h=$this->input->post('hadir',true);
		$smt=$this->input->post('smt',true);
		$matakul=$this->input->post('matakul',true);
		$hadir=$this->app_model->hadir($h);
		$q = $this->db->query("select *
			from absen
			WHERE nim='$nim' 
			and smt='$smt'
			and matakul='$matakul'
			and 
			DATE_FORMAT(tgl,'%Y-%m-%d') = DATE_FORMAT(NOW(),'%Y-%m-%d')
			
			ORDER BY nim ASC limit 1");
		
		include'./application/models/smsc.php';
		// $mysqli = new mysqli("localhost", "root", "", "db_melati");
		/* check connection */
		$nomor=$this->app_model->find_nohp($nim);
		$nomor_ortu=$this->app_model->find_nohp_ortu($nim);
		$nama=$this->app_model->find_nama($nim);
		
		$pesan="NIM ".$nim." an. ".$nama." dinyatakan ".$hadir." pada Mata Kuliah ".$this->app_model->find_matakul($matakul).". Absensi pada ".date('d-m-Y h:i:s').". Melati UMMI";
		
		$pesan_ortu="Anak Bapak/Ibu bernama ".$nama." dinyatakan ".$hadir." pada Mata Kuliah ".$this->app_model->find_matakul($matakul).". Absensi pada ".date('d-m-Y h:i:s').". Melati UMMI";
		
		//kirim pesan kepada mahasiswa 
		if($nomor!="0" or $nomor!="" or $nomor="-"){
		$mysqli->query("INSERT INTO outbox(DestinationNumber, TextDecoded, CreatorID)VALUES('$nomor','$pesan','Melati UMMI')");
		}
		if($nomor_ortu!="0" or $nomor_ortu!="" or $nomor_ortu="-"){
			//kirim pesan kepada orang tua 
			$mysqli->query("INSERT INTO outbox(DestinationNumber, TextDecoded, CreatorID)VALUES('$nomor_ortu','$pesan_ortu','Melati UMMI')");
		}
		
		if($q->num_rows()>0){
			foreach($q->result() as $k){
				$id = $k->id;
			}//jika ditemukan lakukan edit data 
			$this->db->where('id', $id);
			return $this->db->update('absen',array(
				'hadir'=>$this->input->post('hadir',true),
				'nim'=>$this->input->post('nim',true),
				'smt'=>$this->input->post('smt',true),
				'matakul'=>$this->input->post('matakul',true),
				'tgl'=>date('Y-m-d h:i:s'),
			));
			
		}else{
			//jumlah pertemuan masimal 16kali 
			$nim=$this->input->post('nim',true);
			$smt=$this->input->post('smt',true);
			$matakul=$this->input->post('matakul',true);
			
			$j_h=$this->app_model->jml_h($r->nim,1,$smt,$matakul);
			$j_s=$this->app_model->jml_h($r->nim,2,$smt,$matakul);
			$j_i=$this->app_model->jml_h($r->nim,3,$smt,$matakul);
			$j_a=$this->app_model->jml_h($r->nim,4,$smt,$matakul);
			//setting jumlah pertemuan 
			$temu=$j_h+$j_i+$j_a+$j_s;
			$jml_temu=$this->app_model->find_jml_temu($matakul);
			if($temu>=16){
				return "error";
			}else{
				//apabila tidak ditemukan maka lakukan entri data 
				return $this->db->insert('absen',array(
					'hadir'=>$this->input->post('hadir',true),
					'nim'=>$this->input->post('nim',true),
					'smt'=>$this->input->post('smt',true),
					'matakul'=>$this->input->post('matakul',true),
					'tgl'=>date('Y-m-d h:i:s'),
				));
		}

		
	}
	}
	public function simpan_absen()
	{
		date_default_timezone_set("Asia/Jakarta");
		$kelas	=$this->input->post('kelas',true);
		$smt	=$this->input->post('smt',true);
		$lab	=$this->input->post('lab',true);
		$thpel	=$this->input->post('thpel',true);
		$matakul=$this->input->post('matakul',true);
		include'./application/models/smsc.php';
		//$mysqli = new mysqli("localhost", "root", "", "db_upknagrak");
		/* check connection */
		
		$q = $this->db->query("SELECT c.Badgenumb, c.nama, c.nim, a.CHECKTIME as tgl FROM checkinout as a 
								inner join userinfo as b 
								on a.USERID=b.USERID
								inner join mahasiswa as  c 
								on b.Badgenumb=c.Badgenumb
								ORDER BY a.ID DESC
								LIMIT 0,100");
		if($q->num_rows()>0){
			foreach($q->result() as $k){
				$nim = $k->nim;
				$tgl = $k->tgl;
				$hadir="1";
				//posting ke table absen 
				$this->db->insert('absen',array(
					'hadir'	=>$hadir,
					'nim'	=>$nim,
					'smt'	=>$smt,
					'matakul'=>$matakul,
					'tgl'	=>$tgl,
				));
				
				$nomor		=$this->app_model->find_nohp($nim);
				$nomor_ortu =$this->app_model->find_nohp_ortu($nim);
				$nama		=$this->app_model->find_nama($nim);
				
				$pesan="NIM ".$nim." an. ".$nama." dinyatakan ".$hadir." pada Mata Kuliah ".$this->app_model->find_matakul($matakul).". Absensi pada ".date('d-m-Y h:i:s').". Melati UMMI";
				
				$pesan_ortu="Anak Bapak/Ibu bernama ".$nama." dinyatakan ".$hadir." pada Mata Kuliah ".$this->app_model->find_matakul($matakul).". Absensi pada ".date('d-m-Y h:i:s').". Melati UMMI";
				
				//kirim pesan kepada mahasiswa 
				if($nomor!="0" or $nomor!="" or $nomor="-"){
				$mysqli->query("INSERT INTO outbox(DestinationNumber, TextDecoded, CreatorID)VALUES('$nomor','$pesan','Melati UMMI')");
				}
				if($nomor_ortu!="0" or $nomor_ortu!="" or $nomor_ortu="-"){
					//kirim pesan kepada orang tua 
					$mysqli->query("INSERT INTO outbox(DestinationNumber, TextDecoded, CreatorID)VALUES('$nomor_ortu','$pesan_ortu','Melati UMMI')");
				}
				
			}
			//hapus checkinout 
			$this->db->query("DELETE FROM checkinout");
			
			$hasil=1;
		}else{
			$hasil = "0";
		}
		
		
		return $hasil;

		
	}
	
}
