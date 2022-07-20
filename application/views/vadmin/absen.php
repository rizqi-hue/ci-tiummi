       <!-- page content -->
        <div class="right_col" role="main">
          
            <div class="page-title">
              <div class="title_left">
                <h3>Absen Lab TI</h3>
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
              <div class="col-md-3 col-sm-3 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
					
                    <h2>Tampilkan<small>Mhs</small></h2>
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
					
                    <div id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
						<div class="form-body">
						<div class="form-group">
							<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Kelas
								</label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
									<select class="form-control" name="kelas_kode">
										<option value=""> Pilih Kelas </option>
										<?php foreach($kelas as $ck){$hasil[]=$ck;
										echo"<option value='".$ck->kode."'>".$ck->kelas."</option>";
										}?>
									</select>
							</div>
						</div>
						<div class="form-group">
                            <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Semester 
								</label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
								
									<select class="form-control" name="smt">
										<option value=""> Pilih Semester </option>
										<option value="Ganjil"> Ganjil </option>
										<option value="Genap"> Genap </option>
										
									</select>
								
							</div>
                        </div>
						<div class="form-group">
                            <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Th. Pel.
								</label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
									<input type="text" name="thpel" class="form-control" placeholder=" 20xx/20xx" required data-inputmask="'mask':'9999/9999'" >
									<span class="fa fa-calendar form-control-feedback right" aria-hidden="true"></span>
							</div>
                        </div>
						<div class="form-group">
                            <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Lab <span class="required">*</span>
								</label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
								
									<select class="form-control" name="lab">
										<option value=""> Pilih Lab </option>
										<option value="1"> Lab Software </option>
										<option value="2"> Lab Hardware </option>
										<option value="3"> Lab Komputer </option>
									</select>
									
							</div>
                        </div>
						<div class="form-group">
                            <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">MataKul<span class="required">*</span>
								</label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
								<div class="input-group">
									<input type="text" name="matakul_kode" class="form-control" placeholder=" Cari Kode Mata Kuliah" required >
									
									<span class="input-group-btn">
										<button type="button" class="btn btn-success" id="cari" onclick="cari_matakul()"><i class="glyphicon glyphicon-search"></i></button>
									</span>
								  </div>
							</div>
                        </div>
						<div class="form-group">
                            <div class="col-md-12 col-sm-12 col-xs-12 col-md-offset-4">
							<button type="button" class="btn btn-primary" onclick="view_absen()"><i class="glyphicon glyphicon-eye-open"></i> View</button>
							
							
							</div>
						</div>
						
						</div><!-- end form body-->
						<script type="text/javascript">
							function cetak_absen(){
								var kelas_kode	=$('[name="kelas_kode"]').val();
								var smt			=$('[name="smt"]').val();
								var lab			=$('[name="lab"]').val();
								var thpel		=$('[name="thpel"]').val();
								if(kelas_kode == 0 || kelas_kode==""){
								   var error = true;
								   alert("Maaf, Field masih kosong");
								   return (false);
								}else{
									window.open('<?php echo base_url()."cadmin/laporan/cetak_absen/";?>'+kelas_kode+'/'+smt+'/'+lab+'/'+thpel);
								}
								
							}
							function view_absen() {
								
								var kelas_kode	=$('[name="kelas_kode"]').val();
								var smt			=$('[name="smt"]').val();
								var lab			=$('[name="lab"]').val();
								var thpel		=$('[name="thpel"]').val();
								var matakul_kode=$('[name="matakul_kode"]').val();
								
								if(lab == 0 || lab==""){
								   var error = true;
								   alert("Maaf, Field masih kosong");
								   return (false);
								}
								
								$('#loading').html("<img src='<?php echo base_url(); ?>assets/images/loading.gif' />");
								var tampilkan = $("#info");
								var loading = $("#loading");
								tampilkan.hide();
								
								var kode = {kelas:kelas_kode, smt:smt,lab:lab,thpel:thpel,matakul:matakul_kode};
								$.ajax({
										type: "POST",
										url : "<?php echo site_url('cadmin/absen/view_absen')?>",
										data: kode,
										beforeSend: function(){
										   // $("#loaderDiv").show();
										   loading.fadeIn();						
										},
										success: function(msg){
											// $('#info').html(msg);
											  loading.fadeOut();
											  tampilkan.html(msg);
											  loading.hide();
											  tampilkan.fadeIn(1000);
										}
								});
							}
							
							//table delte 
			
							function absen_h(id,nim,smt,matakul) {
							
								var kode = {hadir:id,nim:nim,smt:smt,matakul};
								var table = $('#myTable').DataTable();
								$('#loading').html("<img src='<?php echo base_url(); ?>assets/images/loading.gif' />");
								var loading = $("#loading");
								// alert('sukses'+id);
								$.ajax({
										type: "POST",
										url : "<?php echo site_url('cadmin/absen/add_absen')?>",
										data: kode,
										beforeSend: function(){
										   // $("#loaderDiv").show();
										   loading.fadeIn();						
										},
										success: function(msg){
											alert('sukses diabsen');
											$(this).removeClass('selected');
											table.row('.selected').remove().draw( false );
											loading.fadeOut();
											loading.hide();
										}
								});
								
							}
							
						</script>  
						
                  </div>
                </div>
              </div>
            </div>
			<div class="col-md-9 col-sm-9 col-xs-12">
			<div class="x_panel">
                  <div class="x_title">
                    <h2>Formulir Absen Mahasiswa</h2>
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
                    <!-- hasilnya ditampilkan disini -->
						<span id="loading"></span>
						<div id="info"></div>
                  </div>
                </div>
			</div><!-- col8 -->
			
            </div><!-- /end row -->
          </div>
        </div>
        <!-- /page content -->
<style>
	.image-preview-input {
    position: relative;
	overflow: hidden;
	margin: 0px;    
    color: #333;
    background-color: #fff;
    border-color: #ccc;    
}
.image-preview-input input[type=file] {
	position: absolute;
	top: 0;
	right: 0;
	margin: 0;
	padding: 0;
	font-size: 20px;
	cursor: pointer;
	opacity: 0;
	filter: alpha(opacity=0);
}
.image-preview-input-title {
    margin-left:2px;
}
	</style>
<script>
function cari_matakul()
{
    // save_method = 'add_matakul';
    $('#form_matakul')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('#modal_form_matakul').modal('show'); // show bootstrap modal
    $('.modal-title-matakul').text('Daftar Mata Kuliah'); // Set Title to Bootstrap modal title
}
function add_matkul(id)
{
    // ajax delete data to database
	$('[name="matakul_kode"]').val(id);
    $('#modal_form_matakul').modal('hide');
}
</script>
<!-- Bootstrap modal matakul-->
<div class="modal fade" id="modal_form_matakul" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title-matakul">Form Daftar Mata Kuliah</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form_matakul" class="form-horizontal">
                   <div class="x_content">
					<table id="datatable-keytable" class="table table-striped table-bordered" width="100%">
					
						<thead>
							<tr>
								
								<th class="text-center">KODE</th>
								<th class="text-center">MATA KULIAH</th>
								<th class="text-center">SKS</th>								
								<th class="text-center">ACT</th>
							</tr>
						</thead>
						<tbody>
						<?php 
						foreach($matakul as $cm){
							echo"<tr>
									<td align='center'>".$cm->kode."</td>
									<td>".$cm->matakul."</td>
									<td align='center'>".$cm->sks."</td>
									<td align='center'><a class='btn btn-sm btn-success' href='javascript:void(0)' title='Tambah' onclick='add_matkul(".'"'.$cm->kode.'"'.")'><i class='glyphicon glyphicon-plus'></i> Add </a></td>
								</tr>";
						};
						?>
						
						</tbody>
						
					</table>
                  </div>
                   
                </form>
            </div>
            <div class="modal-footer">
               
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->