<div class="x_content">
<h2>DATA YANG BERHASIL DI AMBIL</h2>
<table id="myTable" class="table table-striped table-hover table-bordered">
					
	<thead>
		<tr>
			<th class="text-center">#</th>
			<th class="text-center">ID MESIN</th>
			<th class="text-center">MAHASISWA</th>
			<th class="text-center">CHECKTIME</th>
		</tr>
	</thead>
	<tbody>
	<?php
		$no=1;
		foreach($kata as $r){//waktu
			echo"<tr>";
				echo "<td align='center'>".$no."</td>";
				echo"<td align='center'>".$r->Badgenumb." </td>";
				echo"<td align='left'>".$r->nama." </td>";
				echo"<td align='center'>".$r->CHECKTIME." </td>";
				
				
			echo"</tr>";
			$no++;
		}
	?>
	</tbody>

</table>
<h2>Silahkan lanjutkan ke proses absen, dengan klik <b>Next!</b></h2>
</div>

<script>
$(document).ready(function() {
    var table = $('#myTable').DataTable();
} );
</script>