       <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Bukti Peminjaman</h3>
              </div>

              <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                  <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search for...">
                    <span class="input-group-btn">
                      <button class="btn btn-default" type="button">Go!</button>
                    </span>
                  </div>
                </div>
              </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
              
			  
			  <!-- end panel --> 
			  <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
					<h2>Bukti Peminjaman <small>Barang</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <ul class="dropdown-menu" role="menu">
                          <li><a href="#">Settings 1</a>
                          </li>
                          <li><a href="#">Settings 2</a>
                          </li>
                        </ul>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
					<span id="loading"></span>
					<table id="datatable-buttons" class="table table-striped table-bordered">
						<thead>
							<tr>
								<th class="text-center" width="5%">#</th>
								<th class="text-center">BUKTI</th>
								<th class="text-center">NAMA PEMINJAM</th>
								<th class="text-center">PINJAM</th>
								<th class="text-center">KEMBALI</th>
								<th style="width:190px;" class="text-center">Action</th>
							</tr>
						</thead>
						<tbody>
							
							<?php 
							$no=1;
							foreach($bukti_pinjam as $d){$hasil[]=$d;
							echo"<tr>
									<td align='center'>".$no."</td>
									<td align='center'>".$d->id."</td>
									<td>".$this->app_model->find_nama($d->nim)."</td>
									<td align='center'>".$this->app_model->tgl_str2($d->tgl)."</td>
									<td align='center'>".$this->app_model->tgl_str2($d->tglkembali)."</td>
									<td><div class='text-center'><a class='btn btn-sm btn-success' href='javascript:void(0)' title='Tambahkan' onclick='cetak_bukti(".'"'.$d->id.'"'.")'><i class='glyphicon glyphicon-print'></i> Cetak</a> ";
									$status=$d->status;
									if($status=="0"){
									echo" <button type='button' id='btnSave' class='btn btn-success' onclick='kembalikan(".'"'.$d->id.'"'.")'><i class='glyphicon glyphicon-book'></i> Kembalikan</button>";
									}else{
										echo"<i class='glyphicon glyphicon-ok'>Dikembalikan";
									}
									echo"
									
									</div></td>
								</tr>";
							$no++;
							}
							?>
						</tbody>

						<tfoot>
						<tr>
							<th class="text-center" width="5%">#</th>
							<th class="text-center">BUKTI</th>
							<th class="text-center">NAMA PEMINJAM</th>
							<th class="text-center">TANGGAL</th>
							<th class="text-center">Action</th>
						</tr>
						</tfoot>
					</table>
					
					
                  </div>
                </div>
              </div>
			  
			  
            </div>

            
          </div>
        </div>
<script>
function cetak_bukti(id)
{
    window.open("<?php echo base_url()."cadmin/laporan/cetak_bukti_pinjam/";?>"+id);
}

function kembalikan(id) {
							
	var kode = {id:id};

	$('#loading').html("<img src='<?php echo base_url(); ?>assets/images/loading.gif' />");
	var loading = $("#loading");
	// alert('sukses'+id);
	$.ajax({
			type: "POST",
			url : "<?php echo site_url('cadmin/pinjam/kembalikan')?>",
			data: kode,
			beforeSend: function(){
			   // $("#loaderDiv").show();
			   loading.fadeIn();						
			},
			success: function(msg){
				alert('Semua item sukses dikembalikan');
				$('#btnSave').text('Dikembalikan'); //change button text
				$('#btnSave').attr('disabled',true); //set button enable 
				
				loading.fadeOut();
				loading.hide();
			}
	});
	
}
</script>