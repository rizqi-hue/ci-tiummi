       <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Peminjaman Inventori</h3>
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
					
				  <h3>Transaksi Peminjaman</h3>
				  <div class="clearfix"></div>
                  
				  </div>
                  
				  <div class="x_content">
					
					<!-- Smart Wizard -->
                    <p>Ikuti langkah-langkah berikut untuk menyelesaikan transaksi peminjaman barang</p>
                    <div id="wizard" class="form_wizard wizard_horizontal">
                      <ul class="wizard_steps">
                        <li>
                          <a href="#step-1">
                            <span class="step_no">1</span>
                            <span class="step_descr">
                                              Step 1<br />
                                              <small>Pilih Barang</small>
                                          </span>
                          </a>
                        </li>
                        <li>
                          <a href="#step-2">
                            <span class="step_no">2</span>
                            <span class="step_descr">
                                              Step 2<br />
                                              <small>Keranjang (cart) Pinjam</small>
                                          </span>
                          </a>
                        </li>
                        <li>
                          <a href="#step-3">
                            <span class="step_no">3</span>
                            <span class="step_descr">
                                              Step 3<br />
                                              <small>Identitas Peminjam</small>
                                          </span>
                          </a>
                        </li>
                        
                      </ul>
                      <div id="step-1" style="height:400px;">
					
						<table id="table" class="table table-striped table-bordered" width="100%" >
							<thead>
								<tr>
									<th class="text-center" width="10%">NO</th>
									<th class="text-center">BARCODE</th>
									<th class="text-center">BARANG</th>
									<th class="text-center">QTY STOK</th>
									
									<th style="width:125px;" class="text-center">Action</th>
								</tr>
							</thead>
							<tbody>
							</tbody>

							<tfoot>
							<tr>
								<th class="text-center">NO</th>
								<th class="text-center">BARCODE</th>
								<th class="text-center">BARANG</th>
								<th class="text-center">QTY STOK</th>
								
								<th class="text-center">Action</th>
							</tr>
							</tfoot>
						</table>
					
                        

                      </div>
                      <div id="step-2">
                        <h2 class="StepTitle">Step 2 Keranjang Peminjaman</h2>
                        <p>
                          Berikut adalah daftar barang yang akan dipinjaman oleh Mahasiswa atau dosen
                        </p>
                        <p>
                          <table id="table2" class="table table-striped table-bordered" width="100%" >
							<thead>
								<tr>
									<th class="text-center" width="10%">#</th>
									<th class="text-center">BARCODE</th>
									<th class="text-center">BARANG</th>
									<th class="text-center">QTY PINJAM</th>
									
									<th width="15%" class="text-center">Action</th>
								</tr>
							</thead>
							<tbody>
							</tbody>

							<tfoot>
							<tr>
								<th class="text-center">#</th>
								<th class="text-center">BARCODE</th>
								<th class="text-center">BARANG</th>
								<th class="text-center">QTY PINJAM</th>
								
								<th class="text-center" >Action</th>
							</tr>
							</tfoot>
						</table>
                        </p>
                      </div>
                      <div id="step-3">
                        <h2 class="StepTitle">Step 3 Identitas Peminjam</h2>
                        <p>
                          Untuk menyelesaikan transaksi silahkan lengkapi formulir dibawah ini
                        </p>
						
                        <form class="form-horizontal form-label-left" data-parsley-validate action="#" id="form_finish">

							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">NIM <span class="required">*</span>
								</label>
								<div class="col-md-9 col-sm-9 col-xs-12">
								  <div class="input-group">
									<input type="text" name="nim" class="form-control" placeholder=" Cari NIM" required >
									
									<span class="input-group-btn">
										<button type="button" class="btn btn-success" id="cari" onclick="cari_mhs()"><i class="glyphicon glyphicon-search"></i> Cari NIM</button>
									</span>
								  </div>
								</div>
							</div>
							
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Pinjam dari Tgl - sampai dengan <span class="required">*</span>
								</label>
								<div class="col-md-9 col-sm-9 col-xs-12">
									 <div class="controls">
										<div class="input-prepend input-group">
										  <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
										  <input type="text" name="tgl" style="width: 200px" name="reservation" id="reservation" class="form-control" value="<?php echo date("m-d-Y");?> - 01/25/2016" />
										</div>
									  </div>
							   </div>
							 </div>
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Keterangan <span class="required">*</span>
								</label>
								<div class="col-md-9 col-sm-9 col-xs-12">
									<input type="text" class="form-control has-feedback-left" name="ket" id="inputSuccess3" placeholder="Keterangan transaksi">
									<span class="fa fa-comment form-control-feedback left" aria-hidden="true"></span>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
								</label>
								<button type="button" id="btnSave_cart" onclick="save_cart()" class="btn btn-primary"><i class="glyphicon glyphicon-send"></i> Simpan Transaksi</button>
							</div>
							
                        </form>
						
                      </div>

                    </div>
                    <!-- End SmartWizard Content -->

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
var table2;
var table3;

$(document).ready(function() {

    //datatables
    table = $('#table').DataTable({ 
		 
		dom: 'Bfrtip',
		buttons: [
        {
            text: 'Reload',
            action: function ( e, dt, node, config ) {
                dt.ajax.reload();
            }
        }
		],
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.

        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('cadmin/pinjam/ajax_list')?>",
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
//table cart / keranjang
$(document).ready(function() {

    //datatables
    table2 = $('#table2').DataTable({ 
		 
		dom: 'Bfrtip',
		buttons: [
        {
            text: 'Reload',
            action: function ( e, dt, node, config ) {
                dt.ajax.reload();
            }
        }
		],
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.

        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('cadmin/pinjam/ajax_list2')?>", //temp_pinjam
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

function add_cart(id)
{
    save_method = 'add_temp';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error strin	g

    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('cadmin/pinjam/ajax_edit/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {

            $('[name="nama"]').val(data.nama);
            $('[name="kode"]').val(data.kode);
            $('[name="id"]').val(data.kode);
           
            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Add to Cart (Pinjam)'); // Set title to Bootstrap modal title

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}
function edit_cart(id)
{
    save_method = 'edit_temp';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error strin	g

    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('cadmin/pinjam/temp_ajax_edit/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {

            $('[name="nama"]').val(data.nama);
            $('[name="kode"]').val(data.kode);
            $('[name="id"]').val(data.id);
            $('[name="qty"]').val(data.qty);
			$('#btnSave').text('Update'); //change button text
            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit Cart (Pinjam)'); // Set title to Bootstrap modal title

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
function reload_table2()
{
    table2.ajax.reload(null,false); //reload datatable ajax 
}

function save()
{
    $('#btnSave').text('saving...'); //change button text
    $('#btnSave').attr('disabled',true); //set button disable 
    var url;

    if(save_method == 'add_temp') {
        url = "<?php echo site_url('cadmin/pinjam/ajax_add_temp')?>";
    } else {
        url = "<?php echo site_url('cadmin/pinjam/ajax_update_temp')?>";
    }
	
	if($('[name="qty"]').val()==''){
		alert('Data masih kosong, jumlah pinjam belum diisi','Eroor');
		$('#btnSave').text('Add to cart'); //change button text
		$('#btnSave').attr('disabled',false); //set button disable 
	}else{
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
					reload_table2();
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
}

function hapus_temp(id)
{
    if(confirm('Are you sure delete this data?'))
    {
        // ajax delete data to database
        $.ajax({
            url : "<?php echo site_url('cadmin/pinjam/temp_ajax_delete')?>/"+id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
                //if success reload ajax table
                $('#modal_form').modal('hide');
                reload_table2();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error deleting data');
            }
        });

    }
}

function cari_mhs()
{
    save_method = 'add_mhs';
    $('#form_mhs')[0].reset(); // reset form on modals
    $('#modal_form_mhs').modal('show'); // show bootstrap modal
    $('.modal-title-mhs').text('Daftar Mahasiswa'); // Set Title to Bootstrap modal title
}

function add_mhs(id)
{
    // $('#form_mhs')[0].reset(); // reset form on modals
	$('[name="nim"]').val(id);
    $('#modal_form_mhs').modal('hide'); // show bootstrap modal
    // $('.modal-title-mhs').text('Daftar Mahasiswa'); // Set Title to Bootstrap modal title
}

function save_cart()
{
    $('#btnSave').text('saving...'); //change button text
    $('#btnSave').attr('disabled',true); //set button disable 
    var url;

   
    url = "<?php echo site_url('cadmin/pinjam/ajax_add_cart')?>";
   
	
	if($('[name="ket"]').val()==''){
		alert('Data masih kosong','Eroor');
		$('#btnSave_cart').text('Kirim '); //change button text
		$('#btnSave_cart').attr('disabled',false); //set button disable 
	}else{
    // ajax adding data to database
		$.ajax({
			url : url,
			type: "POST",
			data: $('#form_finish').serialize(),
			dataType: "JSON",
			success: function(data)
			{

				if(data.status) //if success close modal and reload ajax table
				{
					alert('data sukses terkirim','Ok');
					window.location.replace("<?php echo base_url()."cadmin/pinjam/bukti";?>");
				}
				$('#btnSave').text('save'); //change button text
				$('#btnSave').attr('disabled',false); //set button enable 

			},
			error: function (jqXHR, textStatus, errorThrown)
			{
				alert('Error Saving');
				$('#btnSave').text('save'); //change button text
				$('#btnSave').attr('disabled',false); //set button enable 

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
                <h3 class="modal-title">Form Entri pinjam</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="id"/> 
                    <div class="form-body">
                        <div class="form-group">
                            <label class="col-md-3 col-sm-3 col-xs-12">Barcode</label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
								<input type="hidden" name="id">
                                <input name="kode" placeholder="Barcode" class="form-control col-md-7 col-xs-12" type="text" required="required">
                                <span class="fa fa-barcode form-control-feedback right" aria-hidden="true"></span>
                            </div>
                        </div>
						<div class="form-group">
                            <label class="col-md-3 col-sm-3 col-xs-12">Nama Barang</label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <input name="nama" placeholder="Nama Barang" class="form-control col-md-7 col-xs-12" type="text" required="required">
                                <span class="fa fa-cube form-control-feedback right" aria-hidden="true"></span>
                            </div>
                        </div>
						<div class="form-group">
                            <label class="col-md-3 col-sm-3 col-xs-12">Qty Pinjam</label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <input name="qty" placeholder="Qty/Jumlah Pinjam" class="form-control col-md-7 col-xs-12" type="text" required="required">
                                <span class="fa fa-tags form-control-feedback right" aria-hidden="true"></span>
                            </div>
                        </div>
						
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Add to cart</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form_mhs" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title-mhs">Form Daftar Mahasiswa</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form_mhs" class="form-horizontal">
                   <div class="x_content">
					<table id="datatable" class="table table-striped table-bordered" width="100%">
					
						<thead>
							<tr>
								
								<th class="text-center">NIM</th>
								<th class="text-center">MAHASISWA</th>
								<th class="text-center">ALAMAT</th>								
								<th class="text-center">ACT</th>
							</tr>
						</thead>
						
						<tbody>
							<?php foreach($mhs as $d){$hasil[]=$d;
								echo"<tr>
										<td>".$d->nim."</td>
										<td>".$d->nama."</td>
										<td>".$d->alamat."</td>
										<td><div class='text-center'><a class='btn btn-sm btn-success' href='javascript:void(0)' title='Tambahkan' onclick='add_mhs(".'"'.$d->nim.'"'.")'><i class='glyphicon glyphicon-plus-sign'></i> Pilih</a></div></td>
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