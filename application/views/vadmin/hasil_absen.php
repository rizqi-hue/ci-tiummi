<div class="x_content">
<h2>Jadwal Lab <?php echo $lab.' Semester '.$smt.', Mata Kuliah '.$this->app_model->find_matakul($matakul);?></h2>
<table id="myTable" class="table table-striped table-hover table-bordered">
					
	<thead>
		<tr>
			<th class="text-center">#</th>
			<th class="text-center">N I M</th>
			<th class="text-center">MAHASISWA</th>
			<th class="text-center">KLS</th>
			<th class="text-center">KETERANGAN_KEHADIRAN_MHS</th>
		</tr>
	</thead>
	<tbody>
	<?php
		$no=1;
		foreach($kata as $r){//waktu
			echo"<tr>";
				echo "<td align='center'>".$no."</td>";
				echo"<td align='center'>".$r->nim." </td>";
				echo"<td align='left'>".$r->nama." </td>";
				echo"<td align='center'>".$r->kelas_kode." </td>";
				$cek_h1=$this->app_model->cek_hadir($r->nim,1,$smt,$matakul);
				$cek_h2=$this->app_model->cek_hadir($r->nim,2,$smt,$matakul);
				$cek_h3=$this->app_model->cek_hadir($r->nim,3,$smt,$matakul);
				$cek_h4=$this->app_model->cek_hadir($r->nim,4,$smt,$matakul);
				echo"<td align='center'>
				<button type='button' class='btn btn-success' onclick='absen_h(".'1'.",
				".'"'.$r->nim.'"'.",
				".'"'.$smt.'"'.",
				".'"'.$matakul.'"'.")' ".$cek_h1."><i class='glyphicon glyphicon-ok-sign'></i> H</button>
				<button type='button' class='btn btn-info' onclick='absen_h(".'2'.",".'"'.$r->nim.'"'.",".'"'.$smt.'"'.",".'"'.$matakul.'"'.")' ".$cek_h2."><i class='glyphicon glyphicon-info-sign'></i> S</button>
				<button type='button' class='btn btn-warning' onclick='absen_h(".'3'.",".'"'.$r->nim.'"'.",".'"'.$smt.'"'.",".'"'.$matakul.'"'.")' ".$cek_h3."><i class='glyphicon glyphicon-minus-sign'></i> I</button>
				<button type='button' class='btn btn-danger' onclick='absen_h(".'4'.",".'"'.$r->nim.'"'.",".'"'.$smt.'"'.",".'"'.$matakul.'"'.")' ".$cek_h4."><i class='glyphicon glyphicon-question-sign'></i> A</button>
				</td>";
				
			echo"</tr>";
			$no++;
		}
	?>
	</tbody>

</table>
<hr/>
<i>Ket:<br/>
H: Hadir; S: Sakit;  I: Izin; A: Alpa</i>
</div>

<script>
$(document).ready(function() {
    var table = $('#myTable').DataTable();
	
		
    $('#myTable tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
        }
        else {
            table.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
    } );
 
    $('#button').click( function () {
        table.row('.selected').remove().draw( false );
    } );
} );
</script>