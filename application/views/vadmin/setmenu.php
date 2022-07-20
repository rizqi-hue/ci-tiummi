    <div class="container-fluid">
        <!-- Page Heading -->
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">
					Setting <small>Menu</small>
				</h1>
				<ol class="breadcrumb">
					<li class="active">
					   <i class="fa fa-dashboard"></i>  <a href="<?php echo base_url().'cadmin/home' ?>">Dashboard</a>
					</li>
					<li class="active">
						<i class="fa fa-fw fa-th-large"></i> Setting Menu
					</li>
				</ol>
			</div>
		</div>
		<div class="row">		
        <button class="btn btn-success" onclick="add_menu()"><i class="glyphicon glyphicon-plus"></i> Add </button>
        <button class="btn btn-default" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Reload</button>
        <br />
        <br />
        <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Menu</th>
                    <th>URL</th>
                    <th>HEAD</th>
                    <th>SUB</th>
                    <th>Y/N</th>
                    <th style="width:125px;">Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>

            <tfoot>
            <tr>
                <th>ID</th>
				<th>Menu</th>
				<th>URL</th>
				<th>HEAD</th>
				<th>SUB</th>
				<th>Y/N</th>
                <th>Action</th>
            </tr>
            </tfoot>
        </table>
		<style>
			th{
				text-align: center !important;
			}
		</style>
		</div>
		<!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            <small>Hotek Cek Ombak</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="<?php echo base_url().'./cadmin/media' ?>">Dashboard</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-home"></i> entar
                            </li>
                        </ol>
                    </div>
                </div>
		
    </div>

<script type="text/javascript">

var save_method; //for save method string
var table;

$(document).ready(function() {

    //datatables
    table = $('#table').DataTable({ 

        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.

        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('cadmin/setmenu/ajax_list')?>",
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

    //datepicker
    $('.datepicker').datepicker({
        autoclose: true,
        format: "yyyy-mm-dd",
        todayHighlight: true,
        orientation: "top auto",
        todayBtn: true,
        todayHighlight: true,  
    });

});



function add_menu()
{
    save_method = 'add';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('#modal_form').modal('show'); // show bootstrap modal
    $('.modal-title').text('Add menu'); // Set Title to Bootstrap modal title
}

function edit_menu(id)
{
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string

    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('cadmin/setmenu/ajax_edit/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {

            $('[name="id"]').val(data.id);
            $('[name="menu"]').val(data.menu);
            $('[name="url"]').val(data.url);
            $('[name="head"]').val(data.head);
            $('[name="idh"]').val(data.idh);
            $('[name="icon"]').val(data.icon);
            $('[name="enabled"]').val(data.enabled);
            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit menu'); // Set title to Bootstrap modal title

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
        url = "<?php echo site_url('cadmin/setmenu/ajax_add')?>";
    } else {
        url = "<?php echo site_url('cadmin/setmenu/ajax_update')?>";
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

function delete_menu(id)
{
    if(confirm('Are you sure delete this data?'))
    {
        // ajax delete data to database
        $.ajax({
            url : "<?php echo site_url('cadmin/setmenu/ajax_delete')?>/"+id,
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
                <h3 class="modal-title">Form Setting Menu</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="id"/> 
                    <div class="form-body">
                        <!--
						<div class="form-group">
                            <label class="control-label col-md-3">ID</label>
                            <div class="col-md-9">
                                <input name="id" placeholder="ID" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
						-->
                        <div class="form-group">
                            <label class="control-label col-md-3">Menu</label>
                            <div class="col-md-9">
                                <input name="menu" placeholder="menu" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
						 <div class="form-group">
                            <label class="control-label col-md-3">URL</label>
                            <div class="col-md-9">
                                <input name="url" placeholder="URL" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Header Menu</label>
                            <div class="col-md-9">
                                <select name="head" class="form-control">
                                    <option value="">--Select--</option>
                                    <option value="0">Utama</option>
                                    <option value="1">Sub 1</option>
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>
						<div class="form-group">
                            <label class="control-label col-md-3">ID Header</label>
                            <div class="col-md-9">
                                <input name="idh" placeholder="ID Header" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Icon Bootstrap</label>
                            <div class="col-md-9">
                                <input name="icon" placeholder="icon bootstrap" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Enabled</label>
                            <div class="col-md-9">
                                <select name="enabled" class="form-control">
                                    <option value="">--Select--</option>
                                    <option value="Y">Ya</option>
                                    <option value="N">Tidak</option>
                                </select>
                                <span class="help-block"></span>
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
