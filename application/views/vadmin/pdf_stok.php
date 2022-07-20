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
	$pdf->SetMargins(1.5,0.8,2,1); //set margin kiri, atas, kanan, bawah 1cm
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
	 
	$mm=$this->uri->segment(4);
	$dd=$this->uri->segment(5);
	$yyyy=$this->uri->segment(6);
	
	$tgl=$yyyy.'-'.$mm.'-'.$dd;
	
	
	$pdf->SetFont('Arial','B',14); 
	$pdf->Cell(19,0.6,'DAFTAR STOK BARANG' ,0,0,'C');
	$pdf->Ln(0.7);	
	$pdf->SetFont('Arial','',10); 
	$pdf->Cell(3,0.5,'Tanggal ',0,0,'L');
	$pdf->Cell(3,0.5,': '.$tgl ,0,0,'L');
	
	$pdf->Ln(0.7);	
	
	//tabel pemesanan 
	$pdf->Cell(18,1.0,'','T',0,'L');
	$pdf->Ln(0);
	$pdf->SetLineWidth(0.01);
	$pdf->SetFont('Arial','B',9); 
	$pdf->Cell(1.0,0.5,'NO','BR',0,'C');
	$pdf->Cell(4.5,0.5,'BARCODE','BR',0,'C');
	$pdf->Cell(6,0.5,'NAMA BARANG','BR',0,'C');
	$pdf->Cell(4,0.5,'KATEGORI','BR',0,'C');
	$pdf->Cell(2.5,0.5,'QTY','B',0,'C');
	$pdf->Ln();
	$pdf->SetFont('Arial','',8); 
	$pdf->SetLineWidth(0.01);
	$no=1;
	$qty=0;
	$pdf->Ln(0.1);
	foreach($rs as $r){
		$pdf->Cell(1.0,0.7,$no,'BTR',0,'C');
		$pdf->Cell(4.5,0.7,$r->inv_kode,'BTR',0,'L');
		$pdf->Cell(6.0,0.7,$r->nama,'BTR',0,'L');
		$pdf->Cell(4,0.7,$r->kategori,'BTR',0,'L');
		$pdf->Cell(2.5,0.7,$r->jqty,'BT',0,'C');
		
		
		$pdf->Ln();
		$no++;
	}
	$pdf->Ln(0.05);
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(18,0.7,'','T',0,'L');

	 
		
	//titimangsa
	
    $pdf->Output('StokBarang_'.$tgl.'.pdf','I');
?>