       <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Penyesuaian Inventori</h3>
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
					<button class="btn btn-success" onclick="add_adjust_inv()"><i class="glyphicon glyphicon-plus"></i> Tambah Penyesuaian</button>
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
								<th class="text-center" width="10%">NO</th>
								<th class="text-center">BARCODE</th>
								<th class="text-center">QTY</th>
								<th class="text-center">HARGA</th>
								<th class="text-center">JUMLAH</th>
								<th class="text-center">SUMBER</th>
								<th class="text-center">TANGGAL</th>
								
								<th style="width:125px;" class="text-center">Action</th>
							</tr>
						</thead>
						<tbody>
						</tbody>

						<tfoot>
						<tr>
							<th class="text-center">NO</th>
							<th class="text-center">BARCODE</th>
							<th class="text-center">QTY</th>
							<th class="text-center">HARGA</th>
							<th class="text-center">JUMLAH</th>
							<th class="text-center">SUMBER</th>
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
            "url": "<?php echo site_url('cadmin/adjust_inv/ajax_list')?>",
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

$(document).ready(function() {

    //datatables datar inventori modal 
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
            "url": "<?php echo site_url('cadmin/inventori/ajax_list2')?>",
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
function reload_table_inv()
{
    table2.ajax.reload(null,false); //reload datatable ajax 
}
function add_adjust_inv()
{
    save_method = 'add';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('#modal_form').modal('show'); // show bootstrap modal
    $('.modal-title').text('Penyesuaian Inventori'); // Set Title to Bootstrap modal title
}

function cari_inv()
{
    $('#form_inv')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('#modal_form_inv').modal('show'); // show bootstrap modal
    $('.modal-title-inv').text('Cari Barang'); // Set Title to Bootstrap modal title
}
function edit_adjust_inv(id)
{
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error strin	g

    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('cadmin/adjust_inv/ajax_edit/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            $('[name="kode"]').val(data.inv_kode);
            $('[name="id"]').val(data.id);
            $('[name="harga"]').val(data.harga);
            $('[name="qty"]').val(data.qty);
            $('[name="tglin"]').val(data.tglin);
            $('[name="sumber"]').val(data.sumber);
           
            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit Penyesuaian'); // Set title to Bootstrap modal title

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
        url = "<?php echo site_url('cadmin/adjust_inv/ajax_add')?>";
    } else {
        url = "<?php echo site_url('cadmin/adjust_inv/ajax_update')?>";
    }
	
	if($('[name="kode"]').val()=='' || $('[name="qty"]').val()=='' || $('[name="harga"]').val()=='' || $('[name="tglin"]').val()==''){
		alert('Data kosong','Error');
		$('#btnSave').text('Save'); //change button text
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

function delete_adjust_inv(id)
{
    if(confirm('Are you sure delete this data?'))
    {
        // ajax delete data to database
        $.ajax({
            url : "<?php echo site_url('cadmin/adjust_inv/ajax_delete')?>/"+id,
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

function tambah_inv(id)
{
    
    // ajax delete data to database
	$('[name="kode"]').val(id);
    $('#modal_form_inv').modal('hide');
	// $('#modal_form_inv').modal('show'); // show bootstrap modal
    
}

</script>

<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Form Entri adjust_inv</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal" data-parsley-validate>
                    <input type="hidden" value="" name="id"/> 
                    <div class="form-body">
						
                        <label class="col-sm-3 control-label">Barcode <span class="required">*</span></label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <div class="input-group">
                            <input type="text" name="kode" class="form-control" required>
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-primary" id="cari" onclick="cari_inv()">Cari</button>
							</span>
                          </div>
                        </div>
						
				
						<div class="form-group">
                            <label class="col-sm-3 control-label">Qty</label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <input name="qty" placeholder="Number" class="form-control col-md-7 col-xs-12" type="text" required="required" maxlength="9">
                                <span class="fa fa-calculator form-control-feedback right" aria-hidden="true"></span>
                            </div>
                        </div>
						<div class="form-group">
                            <label class="col-sm-3 control-label">Harga Perolehan</label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <input name="harga" placeholder="Harga Perolehan" class="form-control col-md-7 col-xs-12" type="text" required="required" maxlength="9">
                                <span class="fa fa-dollar form-control-feedback right" aria-hidden="true"></span>
                            </div>
                        </div>
						<div class="form-group">
                            <label class="col-sm-3 control-label">Sumber dari </label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <select name="sumber" class="form-control col-md-7 col-xs-12">
									<option value="1" >Prodi TI</option>
									<option value="2" >Bagian Umum</option>
								</select>
                               
                            </div>
                        </div>
						<div class="form-group">
                            <label class="col-sm-3 control-label">Tanggal</label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <input type="text" class="form-control has-feedback-left" id="single_cal4" name="tglin" placeholder="dd/mm/yyyy" aria-describedby="inputSuccess2Status4">
                                <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                                <span id="inputSuccess2Status4" class="sr-only">(success)</span>
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

<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form_inv" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title-inv">Form Entri adjust_inv</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form_inv" class="form-horizontal">
                   <div class="x_content">
					<table id="table2" class="table table-striped table-bordered" width="100%">
					
						<thead>
							<tr>
								
								<th class="text-center">BARCODE</th>
								<th class="text-center">NAMA BARANG</th>
								<th class="text-center">QTY</th>								
								<th class="text-center">ACT</th>
							</tr>
						</thead>
						<tbody>
						
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