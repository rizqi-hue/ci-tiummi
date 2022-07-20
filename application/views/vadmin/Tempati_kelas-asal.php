       <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Data Mahasiswa Tempati Kelas</h3>
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
					<button class="btn btn-success" onclick="add_tempati_kelas()"><i class="glyphicon glyphicon-plus"></i> Add Mahasiswa</button>
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
								<th class="text-center">KELAS</th>
								<th class="text-center">NIM</th>
								<th class="text-center">MAHASISWA</th>
								<th class="text-center">TAHUN PELAJARAN</th>
								
								<th style="width:125px;" class="text-center">Action</th>
							</tr>
						</thead>
						<tbody>
						</tbody>

						<tfoot>
						<tr>
							<th class="text-center">NO</th>
							<th class="text-center">KELAS</th>
							<th class="text-center">NIM</th>
							<th class="text-center">MAHASISWA</th>
							<th class="text-center">TAHUN PELAJARAN</th>
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
            "url": "<?php echo site_url('cadmin/tempati_kelas/ajax_list')?>",
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



function add_tempati_kelas()
{
    save_method = 'add';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('#modal_form').modal('show'); // show bootstrap modal
    $('.modal-title').text('Tambah Mahasiswa'); // Set Title to Bootstrap modal title
}
function cari_nim()
{
    // save_method = 'add_dosen';
    $('#form_mhs')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('#modal_form_mhs').modal('show'); // show bootstrap modal
    $('.modal-title-mhs').text('Daftar Mahasiswa'); // Set Title to Bootstrap modal title
}

function edit_tempati_kelas(id)
{
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error strin	g

    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('cadmin/tempati_kelas/ajax_edit/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {

            $('[name="nim"]').val(data.nim);
            $('[name="kelas_kode"]').val(data.kelas_kode);
            $('[name="id"]').val(data.id);
            $('[name="thpel"]').val(data.thpel);
           
            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit Kelas Mahasiswa'); // Set title to Bootstrap modal title

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
	var  nim=$('[name="nim"]').val();
    var url;
	if(nim == 0 || nim==""){
	   var error = true;
	   alert("Maaf, Field masih kosong");
		$('#btnSave').text('Tambahkan'); //change button text
		$('#btnSave').attr('disabled',false); //set button disable 
	   return (false);
	}else{
		if(save_method == 'add') {
			url = "<?php echo site_url('cadmin/tempati_kelas/ajax_add')?>";
		} else {
			url = "<?php echo site_url('cadmin/tempati_kelas/ajax_update')?>";
		}
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
            $('#btnSave').text('Tambahkan'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 

        }
    });
}

function delete_tempati_kelas(id)
{
    if(confirm('Are you sure delete this data?'))
    {
        // ajax delete data to database
        $.ajax({
            url : "<?php echo site_url('cadmin/tempati_kelas/ajax_delete')?>/"+id,
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
function tambah_mhs(id)
{
    // ajax delete data to database
	$('[name="nim"]').val(id);
    $('#modal_form_mhs').modal('hide');
	
}
function cek_kelas()
{
    // ajax delete data to database

    var nim			=$('[name="nim"]').val();
    var kelas_kode	=$('[name="kelas_kode"]').val();
    var thpel		=$('[name="thpel"]').val();

	// alert(thpel);
		var kode = {kelas:kelas_kode, nim:nim, thpel:thpel};
		$.ajax({
            url : "<?php echo site_url('cadmin/tempati_kelas/ajax_cek_kelas')?>",
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
					$('#btnSave').text('Simpan Data'); //change button text
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

<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Form Entri tempati_kelas</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="id"/> 
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">N I M <span class="required">*</span>
								</label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
								  <div class="input-group">
									<input type="text" name="nim" class="form-control" placeholder=" Cari NIM" required >
									
									<span class="input-group-btn">
										<button type="button" class="btn btn-success" id="cari" onclick="cari_nim()"><i class="glyphicon glyphicon-search"></i> Cari</button>
									</span>
								  </div>
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
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Tempati Kelas <span class="required">*</span>
								</label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
									<select class="form-control" name="kelas_kode" onchange="cek_kelas()">
										<option value=""> Pilih Kelas </option>
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
                <button type="button" id="btnSave" onclick="save()" class="btn btn-primary"> <i class="glyphicon glyphicon-floppy-save"></i> Tambahkan</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="glyphicon glyphicon-floppy-remove"></i> Cancel</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Bootstrap modal mhs-->
<div class="modal fade" id="modal_form_mhs" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title-mhs">Form Daftar mhs</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form_mhs" class="form-horizontal">
                   <div class="x_content">
					<table id="datatable-buttons" class="table table-striped table-bordered" width="100%">
					
						<thead>
							<tr>
								<th><input type="checkbox" name="select_all" value="1" id="example-select-all"></th>
								<th class="text-center">NIM</th>
								<th class="text-center">NAMA MAHASISWA</th>
								<th class="text-center">ALAMAT</th>								
								<th class="text-center">ACT</th>
							</tr>
						</thead>
						<tbody>
						<?php 
						foreach($mhs as $c){$hasil[]=$c;
							echo"<tr>
									<td></td>
									<td align='center'>".$c->nim."</td>
									<td>".$c->nama."</td>
									<td>".$c->alamat."</td>
									<td align='center'><a class='btn btn-sm btn-success' href='javascript:void(0)' title='Tambah' onclick='tambah_mhs(".'"'.$c->nim.'"'.")'><i class='glyphicon glyphicon-plus'></i> Add </a></td>
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

<script>
$(document).ready(function (){
   var table = $('#datatable-buttons').DataTable({
      'ajax': {
         'url': '/lab/articles/jquery-datatables-how-to-add-a-checkbox-column/ids-arrays.txt'
      },
      'columnDefs': [{
         'targets': 0,
         'searchable': false,
         'orderable': false,
         'className': 'dt-body-center',
         'render': function (data, type, full, meta){
             return '<input type="checkbox" name="id[]" value="' + $('<div/>').text(data).html() + '">';
         }
      }],
      'order': [[1, 'asc']]
   });

   // Handle click on "Select all" control
   $('#example-select-all').on('click', function(){
      // Get all rows with search applied
      var rows = table.rows({ 'search': 'applied' }).nodes();
      // Check/uncheck checkboxes for all rows in the table
      $('input[type="checkbox"]', rows).prop('checked', this.checked);
   });

   // Handle click on checkbox to set state of "Select all" control
   $('#example tbody').on('change', 'input[type="checkbox"]', function(){
      // If checkbox is not checked
      if(!this.checked){
         var el = $('#example-select-all').get(0);
         // If "Select all" control is checked and has 'indeterminate' property
         if(el && el.checked && ('indeterminate' in el)){
            // Set visual state of "Select all" control
            // as 'indeterminate'
            el.indeterminate = true;
         }
      }
   });

   // Handle form submission event
   $('#frm-example').on('submit', function(e){
      var form = this;

      // Iterate over all checkboxes in the table
      table.$('input[type="checkbox"]').each(function(){
         // If checkbox doesn't exist in DOM
         if(!$.contains(document, this)){
            // If checkbox is checked
            if(this.checked){
               // Create a hidden element
               $(form).append(
                  $('<input>')
                     .attr('type', 'hidden')
                     .attr('name', this.name)
                     .val(this.value)
               );
            }
         }
      });
   });

});
</script>
