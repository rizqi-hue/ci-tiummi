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
		$this->SetFont('Arial','BI',11);
		$w = $this->GetStringWidth($title);
		$this->SetX(($lebar -$w)/2);
		$this->Cell($w,0.5,$title.'BUKTI PEMINJAMAN'   ,0,0,'R');
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
	$pdf->Image('./' . $bar,1.5,1.7,2.3);
	$pdf->Ln();
	$pdf->SetFont('Arial','',18); 
	$pdf->Cell(18,0.6,'BKT# '.$c->id,0,0,'R');
    $pdf->Ln();
	$pdf->SetFont('Arial','',10); 
	$pdf->Cell(18,0.6,'Tanggal Pinjam: '.$this->app_model->tgl_str($c->tgl),0,0,'R');
    $pdf->Ln(2);
	$pdf->SetFont('Arial','B',10); 
	$pdf->Cell(9,0.6,$nama_perusahaan,0,'L');
    $pdf->Ln();
	$pdf->SetFont('Arial','B',14);
	$pdf->Cell(9,0.6,$judul,0,'L');
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(9,0.6,'PEMINJAM: ',0,'L');
    $pdf->Ln();
	$pdf->SetFont('Arial','',10); 
	$pdf->MultiCell(9,0.6,$alamat_perusahaan,0,'L');
	$x=6.1;$y=10.5;
	$pdf->setXY($y,$x);
	$pdf->MultiCell(9,0.6,'NIM '.$c->nim,0,'L');
    $pdf->Ln();
	$pdf->MultiCell(9,0.6,$telp_perusahaan,0,'L');
	$pdf->setXY($y,$x+0.6);
	$pdf->MultiCell(9,0.6,$c->nama,0,'L');
    $pdf->Ln();
	$pdf->Cell(9,0.6,'',0,'L');
	$pdf->setXY($y,$x+1.2);
	$pdf->MultiCell(9,0.6,$c->alamat,0,'L');
    $pdf->Ln(0.5);
		
	//tabel pemesanan 
	$pdf->Cell(18,0.7,'','T',0,'L');
	$pdf->Ln(0);
	$pdf->SetLineWidth(0.04);
	$pdf->SetFont('Arial','B',9); 
	$pdf->Cell(1,0.7,'NO','B',0,'L');
	$pdf->Cell(4,0.7,'KODE','B',0,'L');
	$pdf->Cell(10,0.7,'URAIAN','B',0,'L');
	$pdf->Cell(3,0.7,'QTY','B',0,'C');

	$pdf->SetFont('Arial','',9); 
	$pdf->Ln();
	$pdf->SetLineWidth(0.01);
	$no=1;
	$qty=0;
	foreach($rs as $r){
		$pdf->Cell(1,0.7,$no,'BT',0,'C');
		$pdf->Cell(4,0.7,$r->inv_kode,'BT',0,'L');
		$pdf->Cell(10,0.7,$r->inventori,'B',0,'L');
		$pdf->Cell(3,0.7,$r->qty,'B',0,'C');
		
		$pdf->Ln();
		$qty=$qty+$r->qty;
		$no++;
	}
	$pdf->Ln(0.05);
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(1,0.7,'','BT',0,'L');
	$pdf->Cell(14,0.7,'TOTAL ','BT',0,'L');
	$pdf->Cell(3,0.7,$qty.' pcs','BT',0,'C');
	$pdf->Ln();
	$pdf->SetFont('Arial','I',9);
	$pdf->Cell(1,0.7,'ket: '.$c->ket,'',0,'L');
	$pdf->Ln();
	$pdf->SetFont('Arial','I',9);
	$pdf->Cell(1,0.7,'Peminjam berkewajiban mengembalikan barang yang dipinjamnya maksimal tanggal '.$this->app_model->tgl_str($c->tglkembali).'.','',0,'L');
	 //barcode-----------------------------
	
	
	include "./application/libraries/qrcode/qrlib.php";
	QRcode::png($c->id,'image.png','L', 1, 1);
	//echo"<img src=image.png>"; 
	$bar='image.png';
	$pdf->Image('./' . $bar,17,3.8,2.0); //kiri, atas, ukuran barcode 
	
	//titimangsa
	$pdf->Ln(1);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(11,0.6,'',0,0,'L');
	$pdf->Cell(7,0.6,' Sukabumi, '.date("d-m-Y"),0,'L');
	$pdf->Ln();
	$pdf->Cell(11,0.6,'',0,0,'L');
	$pdf->Cell(7,0.6,' Petugas Melati UMMI',0,'L');
	$pdf->Ln(2.5);
	$pdf->SetFont('Arial','BU',10);
	$pdf->Cell(11,0.6,'',0,0,'L');
	$pdf->Cell(7,0.6,''.$this->app_model->find_nama_admin($c->user_id),0,'L');
	
    $pdf->Output('BKT_'.$c->id.'.pdf','I');
?>