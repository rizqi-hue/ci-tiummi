       <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Data Mahasiswa</h3>
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
					<button class="btn btn-success" onclick="add_mahasiswa()"><i class="glyphicon glyphicon-plus"></i> Add Mahasiswa</button>
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
								<th class="text-center">NO</th>
								<th class="text-center">NIM</th>
								<th class="text-center">ID MESIN</th>
								<th class="text-center">NAMA MAHASISWA</th>
								<th class="text-center">TEMPAT TGL LAHIR</th>
								<th class="text-center">JURUSAN/PRODI</th>
								<th class="text-center">ALAMAT</th>
								<th class="text-center">HP ORTU</th>
								<th style="width:125px;" class="text-center">Action</th>
							</tr>
						</thead>
						<tbody>
						</tbody>

						<tfoot>
						<tr>
							<th class="text-center">NO</th>
							<th class="text-center">NIM</th>
							<th class="text-center">ID MESIN</th>
							<th class="text-center">NAMA MAHASISWA</th>
							<th class="text-center">TEMPAT TGL LAHIR</th>
							<th class="text-center">JURUSAN</th>
							<th class="text-center">ALAMAT</th>
							<th class="text-center">HP ORTU</th>
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
            "url": "<?php echo site_url('cadmin/mahasiswa/ajax_list')?>",
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



function add_mahasiswa()
{
    save_method = 'add';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('#modal_form').modal('show'); // show bootstrap modal
    $('.modal-title').text('Tambah Mahasiswa'); // Set Title to Bootstrap modal title
}

function edit_mahasiswa(id)
{
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string

    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('cadmin/mahasiswa/ajax_edit/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {

            $('[name="nim"]').val(data.nim);
            $('[name="nama"]').val(data.nama);
            $('[name="gender"]').val(data.jk);
            $('[name="Badgenumb"]').val(data.Badgenumb);
            $('[name="tlahir"]').val(data.tlahir);
            $('[name="tgllahir"]').val(data.tgl);
            $('[name="alamat"]').val(data.alamat);
            $('[name="jurusan"]').val(data.jurusan);
            $('[name="telp"]').val(data.telp);
            $('[name="telp_ortu"]').val(data.telp_ortu);
           
            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit Mahasiswa'); // Set title to Bootstrap modal title

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
        url = "<?php echo site_url('cadmin/mahasiswa/ajax_add')?>";
    } else {
        url = "<?php echo site_url('cadmin/mahasiswa/ajax_update')?>";
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

function delete_mahasiswa(id)
{
    if(confirm('Are you sure delete this data?'))
    {
        // ajax delete data to database
        $.ajax({
            url : "<?php echo site_url('cadmin/mahasiswa/ajax_delete')?>/"+id,
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

</script>

<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Form Entri Mahasiswa</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="id"/> 
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Nomor Induk Mhs</label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <input name="nim" placeholder="Nomor Induk Mahasiswa" class="form-control col-md-7 col-xs-12" type="text" required="required">
                                <span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
                            </div>
                        </div>
						<div class="form-group">
                            <label class="control-label col-md-3">ID Mesin</label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <input name="Badgenumb" placeholder="ID Mesin" class="form-control col-md-7 col-xs-12" type="text" required="required">
                                <span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
                            </div>
                        </div>
						<div class="form-group">
                            <label class="control-label col-md-3">Nama Lengkap</label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <input name="nama" placeholder="Nama Lengkap" class="form-control col-md-7 col-xs-12" type="text" required="required">
								<span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
                            </div>
                        </div>
						<div class="form-group">
                            <label class="control-label col-md-3">Jenis Kelamin</label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <select name="gender" class="form-control">
                                    <option value="">--Pilih--</option>
                                    <option value="L">Laki-laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>
						<div class="form-group">
                            <label class="control-label col-md-3">Tempat Lahir</label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <input name="tlahir" placeholder="Tempat Lahir" class="form-control col-md-7 col-xs-12" type="text" required="required">
                                <span class="fa fa-tags form-control-feedback right" aria-hidden="true"></span>
                            </div>
                        </div>
						<div class="form-group">
                            <label class="control-label col-md-3">Tanggal Lahir</label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <input type="text" class="form-control" name="tgllahir" data-inputmask="'mask':'99/99/9999'">
								<span class="fa fa-calendar form-control-feedback right" aria-hidden="true"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Jurusan</label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <select name="jurusan" class="form-control">
                                    <option value="">--Select--</option>
									<?php foreach($jurusan as $d){$hasil[]=$d;
										echo"<option value='".$d->jurusan."'>".$d->jurusan."</option>";
									}
							
									?>
                                    
                                </select>
                                <span class="help-block"></span>
                            </div>
							
							
                        </div>
						
						<div class="form-group">
                            <label class="control-label col-md-3">Alamat</label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <input name="alamat" placeholder="Alamat Tinggal" class="form-control col-md-7 col-xs-12" type="text" required="required">
                                <span class="fa fa-tags form-control-feedback right" aria-hidden="true"></span>
                            </div>
                        </div>
						<div class="form-group">
                            <label class="control-label col-md-3">Telp/HP Mhs</label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <input type="text" class="form-control" name="telp" placeholder="Nomor HP Mahasiswa Aktif" >
								<span class="fa fa-calendar form-control-feedback right" aria-hidden="true"></span>
                            </div>
                        </div>
						<div class="form-group">
                            <label class="control-label col-md-3">HP Ortu/wali</label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <input type="text" class="form-control" name="telp_ortu" placeholder="Nomor HP Orangtua/wali Aktif" >
								<span class="fa fa-calendar form-control-feedback right" aria-hidden="true"></span>
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

