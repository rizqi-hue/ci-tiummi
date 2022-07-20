<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	public function lap_bukti_pinjam_pdf() 
	{
		$id = urldecode($this->uri->segment(4));
		
		define('FPDF_FONTPATH',$this->config->item('fonts_path'));
				
		$q = $this->db->query("SELECT 
					a.nim, a.tgl, a.tglkembali, a.id,a.ket,b.nama,b.alamat,c.inv_kode,d.nama as inventori,c.qty, a.user_id
					FROM pinjam_h as a 
					inner join mahasiswa as b 
					on a.nim=b.nim 
					inner join pinjam_d as c 
					on c.idh=a.id 
					inner join inventori as d 
					on d.kode=c.inv_kode 
					where a.id='$id'
						")->result();
						
		$d['rs'] = $q;
		$d['judul'] 			= $this->config->item('judul');
		$d['nama_perusahaan'] 	= $this->config->item('nama_perusahaan');
		$d['alamat_perusahaan'] = $this->config->item('alamat_perusahaan');
		$d['telp_perusahaan'] 	= $this->config->item('telp_perusahaan');
		$d['lisensi']			= $this->config->item('lisensi_app');
			
		// Load view “pdf_report” untuk menampilkan hasilnya
		$this->load->view('vadmin/pdf_bukti_pinjam', $d);
	}
	public function cetak_jadwal_pdf() 
	{
		$id = urldecode($this->uri->segment(4));
		
		define('FPDF_FONTPATH',$this->config->item('fonts_path'));
				
		$q = $this->db->query("SELECT * FROM jam order by kode asc
						")->result();
		$d['rs'] = $q;
		$kelas=$this->uri->segment(4);
		$smt=$this->uri->segment(5);
		$lab=$this->uri->segment(6);
		$th=$this->uri->segment(7);
		$pel=$this->uri->segment(8);
		$nidn=$this->uri->segment(9);
		$thpel=$th.'/'.$pel;
		
		if($kelas=="0"){
			// $qk="and kelas_kode in('A1','A2','A3')";
			$qk="";
		}else{
			$qk="and kelas_kode='$kelas'";
		}
		
		$q2 = $this->db->query("SELECT  distinct(matakul_kode) as kode, nidn FROM jadwal 
		where lab='$lab' $qk and smt='$smt' and thpel='$thpel'
		order by matakul_kode asc
						")->result();
		$d['dos'] = $q2;
		$d['nidn']=$nidn;
		$d['judul'] 			= $this->config->item('judul');
		$d['nama_perusahaan'] 	= $this->config->item('nama_perusahaan');
		$d['alamat_perusahaan'] = $this->config->item('alamat_perusahaan');
		$d['telp_perusahaan'] 	= $this->config->item('telp_perusahaan');
		$d['lisensi']			= $this->config->item('lisensi_app');
			
		// Load view “pdf_report” untuk menampilkan hasilnya
		$this->load->view('vadmin/pdf_jadwal', $d);
	}
	public function cetak_absen_pdf() 
	{
		$id = urldecode($this->uri->segment(4));
		
		define('FPDF_FONTPATH',$this->config->item('fonts_path'));
				
		
		$kelas=$this->uri->segment(4);
		$smt=$this->uri->segment(5);
		$matakul=$this->uri->segment(6);
		$th=$this->uri->segment(7);
		$pel=$this->uri->segment(8);
		$thpel=$th.'/'.$pel;
		
		$q = $this->db->query("SELECT 
				distinct(d.nim),
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
				order by a.nama asc
						")->result();
		$d['rs'] = $q;
		
		$d['judul'] 			= $this->config->item('judul');
		$d['nama_perusahaan'] 	= $this->config->item('nama_perusahaan');
		$d['alamat_perusahaan'] = $this->config->item('alamat_perusahaan');
		$d['telp_perusahaan'] 	= $this->config->item('telp_perusahaan');
		$d['lisensi']			= $this->config->item('lisensi_app');
			
		// Load view “pdf_report” untuk menampilkan hasilnya
		$this->load->view('vadmin/pdf_absen', $d);
	}
	public function cetak_stok_pdf() 
	{
		$id = urldecode($this->uri->segment(4));
		
		define('FPDF_FONTPATH',$this->config->item('fonts_path'));
				
		
		$mm=$this->uri->segment(4);
		$dd=$this->uri->segment(5);
		$yyyy=$this->uri->segment(6);
		
		$tgl=$yyyy.'-'.$mm.'-'.$dd;
		$q = $this->db->query("SELECT a.inv_kode, sum(a.qty) as jqty, b.nama, b.kategori FROM adjust_inv as a 
		inner join inventori as b 
		on a.inv_kode=b.kode 
		where a.tgl<='$tgl'
		group by a.inv_kode
						")->result();
		$d['rs'] = $q;
		
		$d['judul'] 			= $this->config->item('judul');
		$d['nama_perusahaan'] 	= $this->config->item('nama_perusahaan');
		$d['alamat_perusahaan'] = $this->config->item('alamat_perusahaan');
		$d['telp_perusahaan'] 	= $this->config->item('telp_perusahaan');
		$d['lisensi']			= $this->config->item('lisensi_app');
			
		// Load view “pdf_report” untuk menampilkan hasilnya
		$this->load->view('vadmin/pdf_stok', $d);
	}
	
}
