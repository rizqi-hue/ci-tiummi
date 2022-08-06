<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ModelJadwal extends CI_Model {

	var $table = 'jadwal';
	
	public function __construct()
	{
		parent::__construct();
	}

	private function _get_query()
	{
		
		$this->db->select('jadwal.*, matakul.matakul, jam.jam, hari.hari, dosen.nama, ruangan.nama as nama_ruangan, kelas.kelas');
		$this->db->from($this->table);
		
		$this->db->join('matakul', 'jadwal.matakul_kode = matakul.kode');
		$this->db->join('hari', 'hari.kode = jadwal.hari_kode');
		$this->db->join('jam', 'jam.kode = jadwal.jam_kode');
		$this->db->join('dosen', 'dosen.nidn = jadwal.nidn');
		$this->db->join('ruangan', 'ruangan.id = jadwal.lab');
		$this->db->join('kelas', 'kelas.kode = jadwal.kelas_kode');
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
				'matakul_kode' => $this->input->post('matakul_kode'),
				'nidn' 		=> $this->input->post('nidn'),
				'hari_kode' => $this->input->post('hari_kode'),
				'jam_kode' 	=> $this->input->post('jam_kode'),
				'kelas_kode'=> $this->input->post('kelas_kode'),
				'smt' 		=> $this->input->post('smt'),
				'thpel' 	=> $this->input->post('thpel'),
				'lab' 		=> $this->input->post('lab'),				
			);

			if ($this->db->update($this->table, $data, ['id' => $this->input->post('id')])) {
				return $data;
			} else {
				return null;
			}

		} else {
			$kode = $this->input->post('matakul_kode');
			$q = $this->db->query("select *	from matakul where kode ='$kode'");
			
			if($q->num_rows()>0){
				foreach($q->result() as $k){
					$sks 		= $k->sks;
				}
			}
			
			$jam=$this->input->post('jam_kode');
			$x=1;


			while($x <= $sks) {
				$x++;
				$this->db->insert($this->table, array(
					'matakul_kode' => $this->input->post('matakul_kode'),
					'nidn' 		=> $this->input->post('nidn'),
					'hari_kode' => $this->input->post('hari_kode'),
					'jam_kode' 	=> $jam,
					'kelas_kode'=> $this->input->post('kelas_kode'),
					'smt' 		=> $this->input->post('smt'),
					'thpel' 	=> $this->input->post('thpel'),
					'lab' 		=> $this->input->post('lab'),				
				));
				$jam++;
			} 

			return $data = array(
				'id' => $this->db->insert_id(),
				'matakul_kode' => $this->input->post('matakul_kode'),
				'nidn' 		=> $this->input->post('nidn'),
				'hari_kode' => $this->input->post('hari_kode'),
				'jam_kode' 	=> $jam,
				'kelas_kode'=> $this->input->post('kelas_kode'),
				'smt' 		=> $this->input->post('smt'),
				'thpel' 	=> $this->input->post('thpel'),
				'lab' 		=> $this->input->post('lab'),				
			);
		}
    }

	// public function cek_jadwal()
	// {
	// 	$hari=$this->input->post('hari');
	// 	$jam=$this->input->post('jam');
	// 	$smt=$this->input->post('smt');
	// 	$kelas=$this->input->post('kelas');
	// 	$thpel=$this->input->post('thpel');
	// 	$lab=$this->input->post('lab');
	// 	$text 	= "SELECT * FROM jadwal 
	// 				WHERE hari_kode='$hari'
	// 				and jam_kode='$jam'
	// 				and lab='$lab'
	// 				-- and thpel='$thpel'
	// 				-- and smt='$smt'
	// 				";
	// 	$q = $this->db->query($text); 
	// 	if($q->num_rows()>0)
	// 	{
	// 		foreach($q->result() as $k)
	// 		{
	// 			$hari = $this->app_model->find_hari($k->hari_kode);
	// 			$jam = $this->app_model->find_jam($k->jam_kode);
	// 			$hasil ='Error, Jam '.$jam.' Hari: '.$hari.' sudah ada, ubah jam dan hari';
	// 		}

	// 		$hasil = $hasil;
	// 	}
	// 	else
	// 	{
	// 		$hasil = "Sukses, Jadwal Belum ada dan lajutkan ke penyimpanan";
	// 	}

	// 	return $hasil;
	// }

	public function tampilkan_jadwal() {
		$smt=$this->input->post('smt');
		$kelas=$this->input->post('kelas');
		$thpel=$this->input->post('thpel');
		$lab=$this->input->post('lab');
		
		// $smt = 'Ganjil';
		// $kelas = 'TI_A_2017';
		// $thpel = '2018/2019';
		// $lab = 3;

		$haris = $this->db->get('hari')->result();
		$jams = $this->db->get('jam')->result();

		$new_jams = array();
		foreach($jams as $key_jam=>$jam){
			$looping_haris = $haris;
			$new_jams[$key_jam] = ['jam' => $jam->jam, 'kode' => $jam->kode, 'hari' => $looping_haris];
		}

		$data = array();
		foreach($new_jams as $key_new_jam => $new_jam ) {
			$data_hari = array();
			foreach($new_jam["hari"] as $key_hari => $hari) {
				$where = ['smt' => $smt, 'kelas_kode' => $kelas, 'thpel' => $thpel, 'lab' => $lab, 'jam_kode' => $new_jam["kode"], 'hari_kode' => $hari->kode];
				$this->db->join('kelas', 'kelas.kode = jadwal.kelas_kode');
				$this->db->join('matakul', 'matakul.kode = jadwal.matakul_kode');
				$this->db->join('dosen', 'dosen.nidn = jadwal.nidn');
				$x = array('kode' => $hari->kode,'hari' =>$hari->hari, 'detail'=> $this->db->get_where($this->table, $where)->row()  );
				$data_hari[$key_hari] = $x;
			}
			$data[$key_new_jam] = ['jam' => $new_jam["jam"], 'hari' => $data_hari];
		}

		return $data;
	}

	public function delete($id) {
		$this->db->where('id',  $id);
		return $this->db->delete($this->table);
	}

	public function get_where($array = array()) {
		return $this->db->get_where($this->table, $array)->row();
	}

}