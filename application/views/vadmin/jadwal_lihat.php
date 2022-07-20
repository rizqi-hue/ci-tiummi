       <!-- page content -->
        <div class="right_col" role="main">
          
            <div class="page-title">
              <div class="title_left">
                <h3>Lihat Jadwal</h3>
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
              <div class="col-md-4 col-sm-4 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
					
                    <h2>Tampilkan Jadwal<small>Detail</small></h2>
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
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Kelas
								</label>
								<input type="hidden" name="nidn" value="<?php echo $nidn;?>">
                            <div class="col-md-9 col-sm-9 col-xs-12">
									<select class="form-control" name="kelas_kode">
										<option value=""> Pilih Kelas </option>
										<option value="0">All Kelas </option>
										<?php foreach($kelas as $ck){$hasil[]=$ck;
										echo"<option value='".$ck->kode."'>".$ck->kelas."</option>";
										}?>
									</select>
							</div>
						</div>
						<div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Semester 
								</label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
								
									<select class="form-control" name="smt">
										<option value=""> Pilih Semester </option>
										<option value="Ganjil"> Ganjil </option>
										<option value="Genap"> Genap </option>
										
									</select>
								
							</div>
                        </div>
						<div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Th. Pel.
								</label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
									<input type="text" name="thpel" class="form-control" placeholder=" Tahun Pelajaran" required data-inputmask="'mask':'9999/9999'" >
									<span class="fa fa-calendar form-control-feedback right" aria-hidden="true"></span>
							</div>
                        </div>
						<div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Lab <span class="required">*</span>
								</label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
								
									<select class="form-control" name="lab">
										<option value=""> Pilih Lab </option>
										<option value="1"> LAB Kom Lanjut </option>
										<option value="2"> LAB Kom Hardware & Jaringan</option>
										<option value="3"> LAB Kom Dasar </option>
									</select>
									
							</div>
                        </div>
						<div class="form-group">
                            <div class="col-md-12 col-sm-12 col-xs-12 col-md-offset-3">
							<button type="button" class="btn btn-success" onclick="view_jadwal()"><i class="glyphicon glyphicon-eye-open"></i> Tampilkan</button>
							
							<button type="button" class="btn btn-primary" onclick="cetak_jadwal()"><i class="glyphicon glyphicon-print"></i> Cetak</button>
							</div>
						</div>
						
						</div><!-- end form body-->
						<script type="text/javascript">
							function cetak_jadwal(){
								var kelas_kode	=$('[name="kelas_kode"]').val();
								var smt			=$('[name="smt"]').val();
								var lab			=$('[name="lab"]').val();
								var thpel		=$('[name="thpel"]').val();
								var nidn		=$('[name="nidn"]').val();
								if(thpel == 0 || kelas_kode==""){
								   var error = true;
								   alert("Maaf, Field masih kosong");
								   return (false);
								}else{
									window.open('<?php echo base_url()."cadmin/laporan/cetak_jadwal/";?>'+kelas_kode+'/'+smt+'/'+lab+'/'+thpel+'/'+nidn);
								}
								
							}
							function view_jadwal() {
								
								var kelas_kode	=$('[name="kelas_kode"]').val();
								var smt			=$('[name="smt"]').val();
								var lab			=$('[name="lab"]').val();
								var thpel		=$('[name="thpel"]').val();
								var nidn		=$('[name="nidn"]').val();
								
								if(lab == 0 || lab==""){
								   var error = true;
								   alert("Maaf, Field masih kosong");
								   return (false);
								}
								
								$('#loading').html("<img src='<?php echo base_url(); ?>assets/images/loading.gif' />");
								var tampilkan = $("#info");
								var loading = $("#loading");
								tampilkan.hide();
								
								var kode = {kelas:kelas_kode, smt:smt,lab:lab,thpel:thpel,nidn:nidn};
								$.ajax({
										type: "POST",
										url : "<?php echo site_url('cadmin/jadwal/view_jadwal')?>",
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
						</script>  
						
                  </div>
                </div>
              </div>
            </div>
			<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
                  <div class="x_title">
                    <h2>Jadwal Lengkap </h2>
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

<script type="text/javascript">

</script>