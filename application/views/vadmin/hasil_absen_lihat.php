<div class="x_content">
<h2>Daftar Absen Mahasiswa <?php echo $lab.' Semester '.$smt.', Mata Kuliah '.$this->app_model->find_matakul($matakul);?></h2>
<table id="myTable" class="table table-striped table-hover table-bordered">
					
	<thead>
		<tr>
			<th class="text-center">#</th>
			<th class="text-center">N I M</th>
			<th class="text-center">MAHASISWA</th>
			<th class="text-center">KLS</th>
			<th class="text-center">H</th>
			<th class="text-center">S</th>
			<th class="text-center">I</th>
			<th class="text-center">A</th>
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
				//jml kehadiran 
				$j_h=$this->app_model->jml_h($r->nim,1,$smt,$matakul);
				$j_s=$this->app_model->jml_h($r->nim,2,$smt,$matakul);
				$j_i=$this->app_model->jml_h($r->nim,3,$smt,$matakul);
				$j_a=$this->app_model->jml_h($r->nim,4,$smt,$matakul);
				echo"<td align='center'>
					".$j_h."
					</td>";
				echo"<td align='center'>
					".$j_s."
					</td>";
				echo"<td align='center'>
					".$j_i."
					</td>";
				echo"<td align='center'>
					".$j_a."
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