<div class="x_content">
<h2>DAFTAR STOK BARANG/INVENTORI</h2>
<table id="myTable" class="table table-striped table-hover table-bordered">
	<thead>
		<tr>
			<th class="text-center">#</th>
			<th class="text-center">BARCODE</th>
			<th class="text-center">NAMA BARANG</th>
			<th class="text-center">KATEGORI</th>
			<th class="text-center">QTY</th>


		</tr>
	</thead>
	<tbody>
	<?php
		$no=1;
		foreach($kata as $r){//waktu
			echo"<tr>";
				echo "<td align='center'>".$no."</td>";
				echo"<td align='center'>".$r->inv_kode." </td>";
				echo"<td align='left'>".$r->nama." </td>";
				echo"<td align='left'>".$r->kategori." </td>";
				echo"<td align='center'>".$r->jqty." </td>";
				
				
			echo"</tr>";
			$no++;
		}
	?>
	</tbody>

</table>
<hr/>
<i>Ket:<br/>
Perhatikan stok barang tidak boleh munus</i>
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