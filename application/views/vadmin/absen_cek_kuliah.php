       <!-- page content -->
        <div class="right_col" role="main">
          
            <div class="page-title">
              <div class="title_left">
                <h3>Cek Perkuliahan</h3>
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
             
			<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
                  <div class="x_title">
                    <h2>Informasi Perkuliahan</h2>
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
					<h2>
					<?php
					date_default_timezone_set('Asia/Jakarta'); // PHP 6 mengharuskan penyebutan timezone.
					$hari=date("Y-m-d");
					echo $this->app_model->Hari_Bulan_Indo();
					?>
					
					<?php
					echo" ";
					echo $this->app_model->tgl_now_indo();
					?>
					
					<?php 
						echo $this->app_model->Jam_Now();
					?>
					
					</h2>
						<table id="table" class="table table-striped table-bordered">
					
						<thead>
							<tr>
								<th class="text-center">MATA KULIAH</th>
								<th class="text-center">PERKULIAHAN</th>
							</tr>
						</thead>
						<tbody>
						<?php foreach($kuliah  as $r){
							echo"<tr>
									<td>".$this->app_model->find_matakul($r->matakul)."</td>
									<td>".$r->tgl."</td>
								</tr>";
						}
						?>
						</tbody>
						</table>
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