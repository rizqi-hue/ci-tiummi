<label for="desa">Desa/Kelurahan</label>
    <?php
       echo form_dropdown("desa_idds",$idds,'','id="desa_idds", class="form-control"');
    ?>

<script type="text/javascript">
$("#desa_idds").change(function(){
		var desa_idds = {desa_idds:$("#desa_idds").val()};
		$.ajax({
			type	: "POST",
			url 	: "<?php echo site_url('c_kab/laporan/cek_desa')?>",
			data	: desa_idds,
			success	: function(data){
				// $("#info").html('error'+data);
				 if(data==0){
					bootbox.alert('Error: Data tidak ada');
					$('#tampil').attr("disabled",true);
				 }else{
					 $('#tampil').attr("disabled",false);
				 }
			}

		});
		
});
</script>