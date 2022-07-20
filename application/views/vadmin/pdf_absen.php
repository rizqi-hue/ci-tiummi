<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
set_time_limit(36000);

class Pdf extends FPDF{

	function __construct($orientation='P', $unit='cm', $size='A4')
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
	$pdf->Cell(9,0.7,$judul,0,'L');
	
    $pdf->Ln();
	$pdf->SetFont('Arial','',9); 
	$pdf->Cell(3.0,0.5);
	$pdf->MultiCell(9,0.5,$alamat_perusahaan,0,'L');
	$pdf->Ln();
	 
	$kelas=$this->uri->segment(4);
	$smt=$this->uri->segment(5);
	$matakul=$this->uri->segment(6);
	$th=$this->uri->segment(7);
	$pel=$this->uri->segment(8);
	$thpel=$th.'/'.$pel;
	
	
	$pdf->SetFont('Arial','B',14); 
	$pdf->Cell(19,0.6,'DAFTAR ABSEN MAHASISWA ' ,0,0,'C');
	$pdf->Ln(0.7);	
	$pdf->SetFont('Arial','',10); 
	$pdf->Cell(3,0.5,'Mata Kuliah ',0,0,'L');
	$pdf->Cell(3,0.5,': '.$this->app_model->find_matakul($matakul) ,0,0,'L');
	$pdf->Cell(8,0.5,'',0,0,'L');
	$pdf->Cell(3,0.5,'Semester ',0,0,'L');
	$pdf->Cell(3,0.5,': '.$smt,0,0,'L');
	$pdf->Ln();
	$pdf->Cell(3,0.5,'Kelas ',0,0,'L');
	$pdf->Cell(3,0.5,': '.strtoupper($kelas) ,0,0,'L');
	$pdf->Cell(8,0.5,'',0,0,'L');
	$pdf->Cell(3,0.5,'Tahun Pelajaran ',0,0,'L');
	$pdf->Cell(3,0.5,': '.$thpel,0,0,'L');
	$pdf->Ln(0.7);	
	
	//tabel pemesanan 
	$pdf->Cell(19,1.0,'','T',0,'L');
	$pdf->Ln(0);
	$pdf->SetLineWidth(0.01);
	$pdf->SetFont('Arial','B',9); 
	$pdf->Cell(1.0,1.0,'NO','BR',0,'C');
	$pdf->Cell(4.5,1.0,'NIM','BR',0,'C');
	$pdf->Cell(6,1.0,'NAMA MAHASISWA','BR',0,'C');
	$pdf->Cell(1.5,1.0,'L/P','BR',0,'C');
	$pdf->Cell(6,0.5,'KEHADIRAN','B',0,'C');
	$pdf->Ln();
	$pdf->setX(14);
	$pdf->Cell(1.5,0.5,'H','BR',0,'C');
	$pdf->Cell(1.5,0.5,'S','BR',0,'C');
	$pdf->Cell(1.5,0.5,'I','BR',0,'C');
	$pdf->Cell(1.5,0.5,'A','B',0,'C');

	$pdf->Ln(0.08);
	$pdf->Cell(19,0.5,'','B',0,'L');

	$pdf->SetFont('Arial','',8); 
	$pdf->Ln();
	$pdf->SetLineWidth(0.01);
	$no=1;
	$qty=0;
	foreach($rs as $r){
		$pdf->Cell(1.0,0.7,$no,'BTR',0,'C');
		$pdf->Cell(4.5,0.7,$r->nim,'BTR',0,'L');
		$pdf->Cell(6.0,0.7,$r->nama,'BTR',0,'L');
		$pdf->Cell(1.5,0.7,$this->app_model->find_jk($r->nim),'BTR',0,'C');
		$j_h=$this->app_model->jml_h($r->nim,1,$smt,$matakul);
		$j_s=$this->app_model->jml_h($r->nim,2,$smt,$matakul);
		$j_i=$this->app_model->jml_h($r->nim,3,$smt,$matakul);
		$j_a=$this->app_model->jml_h($r->nim,4,$smt,$matakul);
		$pdf->Cell(1.5,0.7,$j_h,'BTR',0,'C');
		$pdf->Cell(1.5,0.7,$j_s,'BTR',0,'C');
		$pdf->Cell(1.5,0.7,$j_i,'BTR',0,'C');
		$pdf->Cell(1.5,0.7,$j_a,'BT',0,'C');
		
		$pdf->Ln();
		$no++;
	}
	$pdf->Ln(0.05);
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(19,0.7,'','T',0,'L');
	$pdf->SetFont('Arial','',9);
	$pdf->Ln();
	$pdf->Cell(13,0.5,'',0,'L');
	$pdf->Cell(4,0.5,'Sukabumi, '.date('m-d-Y'),'',0,'L');	
	$pdf->Ln();
	$pdf->Cell(13,0.5,'',0,'L');
	$pdf->Cell(4,0.5,'Dosen Pemgampu','',0,'L');
	$pdf->Ln(3);
	$pdf->Cell(13,0.5,'',0,'L');
	$pdf->Cell(4,0.5,''.$this->app_model->find_ttd_dosen($kelas,$smt,$thpel,$matakul),'',0,'L');	
	
	//titimangsa
	
    $pdf->Output('Absen_'.$matakul.'.pdf','I');
?>