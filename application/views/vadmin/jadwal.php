       <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Pembuatan Jadwal Perkuliahan</h3>
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
					<button class="btn btn-success" onclick="add_jadwal()"><i class="glyphicon glyphicon-plus"></i> Add jadwal</button>
					<button class="btn btn-default" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Reload</button>
                    
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
					<table id="table" class="table table-striped table-bordered">
					
						<thead>
							<tr>
								<th class="text-center" width="5%">#</th>
								<th class="text-center">HARI</th>
								<th class="text-center">JAM</th>
								<th class="text-center">MATA KULIAH</th>
								<th class="text-center">DOSEN</th>
								<th class="text-center">LAB/SMT</th>
								<th class="text-center">KELAS</th>
								<th style="width:125px;" class="text-center">Action</th>
							</tr>
						</thead>
						<tbody>
						</tbody>

						<tfoot>
							<tr>
								<th class="text-center">#</th>
								<th class="text-center">HARI</th>
								<th class="text-center">JAM</th>
								<th class="text-center">MATA KULIAH</th>
								<th class="text-center">DOSEN</th>
								<th class="text-center">LAB/SMT</th>
								<th class="text-center">KELAS</th>
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
<!-- /page content -->

<script type="text/javascript">

var save_method; //for save method string
var table;

$(document).ready(function() {

    //datatables
    table = $('#table').DataTable({ 
		 
		dom: 'Bfrtip',
		buttons: [
			'copy', 'csv', 'excel', 
			{
                extend: 'pdf',
                orientation: 'landscape',
                pageSize: 'A4'
            },'print'
		],
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.

        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('cadmin/jadwal/ajax_list')?>",
            "type": "POST"
        },

        //Set column definition initialisation properties.
        "columnDefs": [
        { 
            "targets": [ -1 ], //last column
            "orderable": false, //set not orderable
        },
        ],


    });
});

function add_jadwal()
{
    save_method = 'add';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('#modal_form').modal('show'); // show bootstrap modal
    $('.modal-title').text('Tambah Jadwal'); // Set Title to Bootstrap modal title
}

function cari_dsn()
{
    // save_method = 'add_dosen';
    $('#form_dosen')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('#modal_form_dosen').modal('show'); // show bootstrap modal
    $('.modal-title-dosen').text('Daftar Dosen'); // Set Title to Bootstrap modal title
}
function cari_matakul()
{
    // save_method = 'add_matakul';
    $('#form_matakul')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('#modal_form_matakul').modal('show'); // show bootstrap modal
    $('.modal-title-matakul').text('Daftar Mata Kuliah'); // Set Title to Bootstrap modal title
}
function edit_jadwal(id)
{
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error strin	g

    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('cadmin/jadwal/ajax_edit/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {

            $('[name="id"]').val(data.id);
            $('[name="nidn"]').val(data.nidn);
            $('[name="matakul_kode"]').val(data.matakul_kode);
            $('[name="jam_kode"]').val(data.jam_kode);
            $('[name="hari_kode"]').val(data.hari_kode);
            $('[name="kelas_kode"]').val(data.kelas_kode);
            $('[name="smt"]').val(data.smt);
            $('[name="thpel"]').val(data.thpel);
            $('[name="lab"]').val(data.lab);
           
            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit Jadwal'); // Set title to Bootstrap modal title

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}

function reload_table()
{
    table.ajax.reload(null,false); //reload datatable ajax 
}

function save()
{
    $('#btnSave').text('saving...'); //change button text
    $('#btnSave').attr('disabled',true); //set button disable 
    var url;

    if(save_method == 'add') {
        url = "<?php echo site_url('cadmin/jadwal/ajax_add')?>";
    } else {
        url = "<?php echo site_url('cadmin/jadwal/ajax_update')?>";
    }

    // ajax adding data to database
    $.ajax({
        url : url,
        type: "POST",
        data: $('#form').serialize(),
        dataType: "JSON",
        success: function(data)
        {

            if(data.status) //if success close modal and reload ajax table
            {
                $('#modal_form').modal('hide');
                reload_table();
            }
            $('#btnSave').text('save'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
            $('#btnSave').text('save'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 

        }
    });
}

function delete_jadwal(id)
{
    if(confirm('Are you sure delete this data?'))
    {
        // ajax delete data to database
        $.ajax({
            url : "<?php echo site_url('cadmin/jadwal/ajax_delete')?>/"+id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
                //if success reload ajax table
                $('#modal_form').modal('hide');
                reload_table();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error deleting data');
            }
        });

    }
}

function tambah_dosen(id)
{
    // ajax delete data to database
	$('[name="nidn"]').val(id);
    $('#modal_form_dosen').modal('hide');
	// $('#modal_form_inv').modal('show'); // show bootstrap modal   
}
function add_matkul(id)
{
    // ajax delete data to database
	$('[name="matakul_kode"]').val(id);
    $('#modal_form_matakul').modal('hide');
}
function cek_jadwal_ada()
{
    // ajax delete data to database
	var matakul_kode=$('[name="matakul_kode"]').val();
    var nidn		=$('[name="nidn"]').val();
    var kelas_kode	=$('[name="kelas_kode"]').val();
    var smt			=$('[name="smt"]').val();
    var lab			=$('[name="lab"]').val();
    var thpel		=$('[name="thpel"]').val();
    var hari_kode	=$('[name="hari_kode"]').val();
    var jam_kode	=$('[name="jam_kode"]').val();
	// alert(thpel);
		var kode = {jam:jam_kode, hari:hari_kode, kelas:kelas_kode, smt:smt, thpel:thpel, lab:lab};
		$.ajax({
            url : "<?php echo site_url('cadmin/jadwal/ajax_cek_jadwal')?>",
            type: "POST",
			data: kode,
            dataType: "JSON",
            success: function(data)
            {
                //if success reload ajax table
				var result=data.split(',');
				// alert(result[0]);
				if(result[0]=="Error"){
					alert(data);
					$('#btnSave').text('Simpan Data'); //change button text
					$('#btnSave').attr('disabled',true); //set button disable 
                }else{
					alert(data);
					$('#btnSave').text('Simpan Jadwal'); //change button text
					$('#btnSave').attr('disabled',false); //set button disable 
				}
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error view data');
            }
        });
}

</script>

<!-- Bootstrap modal jadwal-->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Form Entri jadwal</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal form-label-left">
                    <input type="hidden" value="" name="id"/> 
                    <div class="form-body">
                       <div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Dosen <span class="required">*</span>
								</label>
								<div class="col-md-9 col-sm-9 col-xs-12">
								  <div class="input-group">
									<input type="text" name="nidn" class="form-control" placeholder=" Cari Kode Dosen" required >
									
									<span class="input-group-btn">
										<button type="button" class="btn btn-success" id="cari" onclick="cari_dsn()"><i class="glyphicon glyphicon-search"></i> Cari</button>
									</span>
								  </div>
								</div>
							</div>
						<div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Mata Kuliah <span class="required">*</span>
								</label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
								  <div class="input-group">
									<input type="text" name="matakul_kode" class="form-control" placeholder=" Cari Kode Mata Kuliah" required >
									
									<span class="input-group-btn">
										<button type="button" class="btn btn-success" id="cari" onclick="cari_matakul()"><i class="glyphicon glyphicon-search"></i> Cari</button>
									</span>
								  </div>
								</div>
                        </div>
						
						<div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Semester <span class="required">*</span>
								</label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
								
									<select class="form-control" name="smt">
										<option> Pilih Semester </option>
										<option value="Ganjil"> Ganjil </option>
										<option value="Genap"> Genap </option>
										
									</select>
								
							</div>
                        </div>
						<div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Tahun Pelajaran <span class="required">*</span>
								</label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
									<input type="text" name="thpel" class="form-control" placeholder=" tahun pelajaran" required data-inputmask="'mask':'9999/9999'" >
									<span class="fa fa-calendar form-control-feedback right" aria-hidden="true"></span>
							</div>
                        </div>
						<div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Lab <span class="required">*</span>
								</label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
								
									<select class="form-control" name="lab">
										<option> Pilih Lab </option>
										<option value="1"> LAB Kom Lanjut </option>
										<option value="2"> LAB Kom Hardware & Jaringan</option>
										<option value="3"> Lab Kom Dasar</option>
									</select>
									
							</div>
                        </div>
						<div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Hari <span class="required">*</span>
								</label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
									<select class="form-control" name="hari_kode">
										<option> Pilih Hari </option>
										<?php foreach($hari as $cr){$hasil[]=$cr;
										echo"<option value='".$cr->kode."'>".$cr->hari."</option>";
										}?>
									</select>
							</div>
                        </div>
						<div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Mulai dari jam <span class="required">*</span>
								</label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
									<select class="form-control" name="jam_kode" onchange="cek_jadwal_ada()">
										<option> Pilih Jam </option>
										<?php foreach($jam as $cj){
										echo"<option value='".$cj->kode."'>".$cj->jam."</option>";
										}?>
									</select>
							</div>
                        </div>
						<div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Kelas <span class="required">*</span>
								</label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
									<select class="form-control" name="kelas_kode">
										<option> Pilih Kelas </option>
										<?php foreach($kelas as $ck){$hasil[]=$ck;
										echo"<option value='".$ck->kode."'>".$ck->kelas."</option>";
										}?>
									</select>
							</div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Bootstrap modal dosen-->
<div class="modal fade" id="modal_form_dosen" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title-dosen">Form Daftar Dosen</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form_dosen" class="form-horizontal">
                   <div class="x_content">
					<table id="datatable-buttons" class="table table-striped table-bordered" width="100%">
					
						<thead>
							<tr>
								
								<th class="text-center">NIDN</th>
								<th class="text-center">NAMA DOSEN</th>
								<th class="text-center">ALAMAT</th>								
								<th class="text-center">ACT</th>
							</tr>
						</thead>
						<tbody>
						<?php 
						foreach($dosen as $cd){$hasil[]=$cd;
							echo"<tr>
									<td align='center'>".$cd->nidn."</td>
									<td>".$cd->nama."</td>
									<td>".$cd->alamat."</td>
									<td align='center'><a class='btn btn-sm btn-success' href='javascript:void(0)' title='Tambah' onclick='tambah_dosen(".'"'.$cd->nidn.'"'.")'><i class='glyphicon glyphicon-plus'></i> Add </a></td>
								</tr>";
						}
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