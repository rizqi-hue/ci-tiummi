<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
set_time_limit(36000);

class Pdf extends FPDF{

	function __construct($orientation='L', $unit='cm', $size='A4')
	{
		parent::__construct($orientation,$unit,$size);
		
	}


	function Header(){  
		
		global $title ;
		$lebar = $this->w;
		$this->SetFont('Arial','BI',10);
		$w = $this->GetStringWidth($title);
		$this->SetX(($lebar -$w)/2);
		$this->Cell($w,0.5,$title.'MANAJEMEN LAB TI (MELATI) UMMI '   ,0,0,'R');
		$this->Ln();
		
		$this->line($this->GetX(), $this->GetY(), $this->GetX()+$lebar -2.0, $this->GetY());
		$this->Ln(0.3);
	
		// $this->Image('./' . $bar,1.5,0.25,1.3);	
	}                


	function Footer() {               
		$this->SetY(-1.5);   
		$lebar = $this->w;   
		$this->SetFont('Arial','I',8);           
		$this->line($this->GetX(), $this->GetY(), $this->GetX()+$lebar-2.5, $this->GetY());
		$this->SetY(-1.5);
		$this->SetX(0);       
		$this->Ln(0.1);
		$hal = 'Page : '.$this->PageNo().'/{nb}' ;
		$this->Cell($this->GetStringWidth($hal ),1.0,$hal );   
		$datestring = "Year: %Y Month: %m Day: %d - %h:%i %a";
		$tanggal  = 'Printed : '.date('d-m-Y  h:i-a').' ';
		$this->Cell($lebar-$this->GetStringWidth($hal )-$this->GetStringWidth($tanggal)-2.5);   
		$this->Cell($this->GetStringWidth($tanggal),1.0,$tanggal );   
	}               

}
  
   /* setting zona waktu */
	$pdf = new PDF();
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetMargins(1.0,0.8,2,1); //set margin kiri, atas, kanan, bawah 1cm
	date_default_timezone_set('Asia/Jakarta');
    $tgl = DATE('Y-m-d'); //panggil param tanggal
	
	foreach($rs as $c){$hasil[]=$c;} //panggil database 
	$bar='./assets/images/logo.png';
	$pdf->Image('./' . $bar,1.0,1.7,2.5);
	$pdf->Ln(0.07);
	
	$pdf->SetFont('Arial','B',12); 
	$pdf->Cell(3.0,0.6);
	$pdf->Cell(9,0.6,$nama_perusahaan,0,'L');
    $pdf->Ln();
	$pdf->Cell(3.0,0.7);
	$pdf->SetFont('Arial','B',14);
	$pdf->Cell(9,0.5,$judul,0,'L');
	
    $pdf->Ln();
	$pdf->SetFont('Arial','',9); 
	$pdf->Cell(3.0,0.5);
	$pdf->MultiCell(9,0.5,$alamat_perusahaan,0,'L');
	$pdf->Ln(0);
	 
	$kelas=$this->uri->segment(4);
	$smt=$this->uri->segment(5);
	$lab=$this->uri->segment(6);
	$th=$this->uri->segment(7);
	$pel=$this->uri->segment(8);
	$thpel=$th.'/'.$pel;
	
	
	$pdf->SetFont('Arial','B',14); 
	$pdf->Cell(27.2,0.6,'JADWAL LAB '.$lab ,0,1,'C');
	$pdf->Ln(0.1);	
	
	//tabel pemesanan 
	$pdf->Cell(27.2,0.5,'','T',0,'L');
	$pdf->Ln(0);
	$pdf->SetLineWidth(0.01);
	$pdf->SetFont('Arial','B',9); 
	$pdf->Cell(2.0,0.5,'JAM','BR',0,'C');
	$pdf->Cell(3.6,0.5,'SENIN','BR',0,'C');
	$pdf->Cell(3.6,0.5,'SELASA','BR',0,'C');
	$pdf->Cell(3.6,0.5,'RABU','BR',0,'C');
	$pdf->Cell(3.6,0.5,'KAMIS','BR',0,'C');
	$pdf->Cell(3.6,0.5,'JUMAT','B',0,'C');
	$pdf->Cell(3.6,0.5,'SABTU','B',0,'C');
	$pdf->Cell(3.6,0.5,'MINGGU','B',0,'C');
	$pdf->Ln(0.1);
	$pdf->Cell(19,0.5,'','B',0,'L');

	$pdf->SetFont('Arial','',8); 
	$pdf->Ln();
	$pdf->SetLineWidth(0.01);
	$no=1;
	$qty=0;
	foreach($rs as $r){
		$pdf->Cell(2.0,0.5,$r->jam,'BTR',0,'L');
		$hari=2;//hari senin 
			$matakul=$this->app_model->find_jadwal_matakul($r->kode,$kelas,$smt,$thpel,$lab,$hari);
			$dosen=$this->app_model->find_jadwal_dosen($r->kode,$kelas,$smt,$thpel,$lab,$hari);
			$this->app_model->find_dosen($dosen);
		$pdf->MultiCell(3.6,0.5,$this->app_model->find_matakul($matakul).'/'.$dosen,'BTR',1);
		$hari=3;//hari senin 
			$matakul=$this->app_model->find_jadwal_matakul($r->kode,$kelas,$smt,$thpel,$lab,$hari);
			$dosen=$this->app_model->find_jadwal_dosen($r->kode,$kelas,$smt,$thpel,$lab,$hari);
			$this->app_model->find_dosen($dosen);
		$pdf->Cell(3.6,0.5,$this->app_model->find_matakul($matakul).'/'.$dosen,'BTR',0,'L');
		$hari=4;//hari senin 
			$matakul=$this->app_model->find_jadwal_matakul($r->kode,$kelas,$smt,$thpel,$lab,$hari);
			$dosen=$this->app_model->find_jadwal_dosen($r->kode,$kelas,$smt,$thpel,$lab,$hari);
			$this->app_model->find_dosen($dosen);
		$pdf->Cell(3.6,0.5,$this->app_model->find_matakul($matakul).'/'.$dosen,'BTR',0,'L');
		$hari=5;//hari senin 
			$matakul=$this->app_model->find_jadwal_matakul($r->kode,$kelas,$smt,$thpel,$lab,$hari);
			$dosen=$this->app_model->find_jadwal_dosen($r->kode,$kelas,$smt,$thpel,$lab,$hari);
			$this->app_model->find_dosen($dosen);
		$pdf->Cell(3.6,0.5,$this->app_model->find_matakul($matakul).'/'.$dosen,'BTR',0,'L');
		$hari=6;//hari senin 
			$matakul=$this->app_model->find_jadwal_matakul($r->kode,$kelas,$smt,$thpel,$lab,$hari);
			$dosen=$this->app_model->find_jadwal_dosen($r->kode,$kelas,$smt,$thpel,$lab,$hari);
			$this->app_model->find_dosen($dosen);
		$pdf->Cell(3.6,0.5,$this->app_model->find_matakul($matakul).'/'.$dosen,'BTR',0,'L');
		$hari=7;//hari senin 
			$matakul=$this->app_model->find_jadwal_matakul($r->kode,$kelas,$smt,$thpel,$lab,$hari);
			$dosen=$this->app_model->find_jadwal_dosen($r->kode,$kelas,$smt,$thpel,$lab,$hari);
			$this->app_model->find_dosen($dosen);
		$pdf->Cell(3.6,0.5,$this->app_model->find_matakul($matakul).'/'.$dosen,'BTR',0,'L');
		$hari=1;//hari senin 
			$matakul=$this->app_model->find_jadwal_matakul($r->kode,$kelas,$smt,$thpel,$lab,$hari);
			$dosen=$this->app_model->find_jadwal_dosen($r->kode,$kelas,$smt,$thpel,$lab,$hari);
			$this->app_model->find_dosen($dosen);
		$pdf->Cell(3.6,0.5,$this->app_model->find_matakul($matakul).'/'.$dosen,'BT',0,'L');
		
		
		$pdf->Ln();
		$no++;
	}
	$pdf->Ln(0.05);
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(27.2,0.5,'','T',0,'L');

	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(5.5,0.5,'DAFTAR DOSEN PENGAMPUH','',0,'L');
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	foreach($dos as $d){
		$pdf->Cell(5,0.5,'- '.$this->app_model->find_matakul($d->kode),'',0,'L');
		$pdf->Cell(4,0.5,$this->app_model->find_dosen($d->nidn),'',0,'L');
		$pdf->Ln();
	}
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(5.5,0.5,'Ketua Prodi TI','',0,'L');
	$pdf->Ln();
	$pdf->Ln();
	$pdf->Ln();
	$pdf->Ln();
	$pdf->Cell(5.5,0.5,'Moh. Ridwan, M.T.','',0,'L');
	
	
	//titimangsa
	
    $pdf->Output('Jadwal_Lab_'.$lab.'.pdf','I');
?>