       <!-- page content -->
        <div class="right_col" role="main">
          
            <div class="page-title">
              <div class="title_left">
                <h3>Upload Materi</h3>
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
					
                    <h2>Upload<small>Documen</small></h2>
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
					
                    <br />
                    <div id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
						<?php echo form_open_multipart('cadmin/home/upload_dokumen') ?>
						<div class="form-group">
							<div class="input-group  col-md-12 col-sm-12 col-xs-12">
								<input type="text" class="form-control has-feedback-right" id="inputSuccess2" placeholder="Judul Dokumen" name="judul">
								<span class="fa fa-tags form-control-feedback right" aria-hidden="true"></span>
							</div>
						</div>
						<div class="form-group">
							
                            <div class="input-group col-md-12 col-sm-12 col-xs-12">
									<select class="form-control" name="kodemk">
										<option value=""> Pilih Kelas </option>
										<?php foreach($matakul as $ck){$hasil[]=$ck;
										echo"<option value='".$ck->kode."'>".$ck->matakul."</option>";
										}?>
									</select>
							</div>
						</div>
						<div class="form-group">
							<div class="input-group  col-md-12 col-sm-12 col-xs-12">
								<input type="text" class="form-control has-feedback-right typeahead" id="btn-input" placeholder="NIDN" name="nidn" value="<?php echo $nidn;?>">
								<span class="fa fa-barcode form-control-feedback right" aria-hidden="true"></span>
							</div>
						</div>
                        <!-- image-preview-filename input [CUT FROM HERE]-->
						<div class="input-group image-preview">
							<input type="text" class="form-control image-preview-filename" disabled="disabled" placeholder="Cari File"> <!-- don't give a name === doesn't send on POST/GET -->
							<span class="input-group-btn">
								<!-- image-preview-clear button -->
								<button type="button" class="btn btn-default image-preview-clear" style="display:none;">
									<span class="glyphicon glyphicon-remove"></span> Clear
								</button>
								<!-- image-preview-input -->
								<div class="btn btn-default image-preview-input">
									<span class="glyphicon glyphicon-folder-open"></span>
									<span class="image-preview-input-title">Browse</span>
									<input type="file" accept="image/png, image/jpeg, image/gif, application/pdf,application/vnd.ms-excel" name="input-file-preview"/> <!-- rename it -->
								</div>
								
								<button name="upload" type="submit" class="btn btn-success"><span class="glyphicon glyphicon-upload"></span> Upload</button>
							</span>
						</div><!-- /input-group image-preview [TO HERE]--> 
                      
						
                     
					</form>
                    
                  </div>
                </div>
              </div>
            </div>
			<div class="col-md-8 col-sm-8 col-xs-12">
			<div class="x_panel">
                  <div class="x_title">
                    <h2>Daftar Dokumen </h2>
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
                    <table id="datatable-checkbox" class="table table-striped table-bordered">
					
						<thead>
							<tr>
								<th class="text-center" width="5%">#</th>
								<th class="text-center">JUDUL DOKUMEN</th>
								<th class="text-center">MATAKUL/DOSEN</th>				
								<th style="width:80px;" class="text-center">Action</th>
							</tr>
						</thead>
						<tbody>
							
							<?php 
							$no=1;
							
							
							foreach($upload as $d){$hasil[]=$d;
							echo"<tr>
									<td align='center'>".$no."</td>
									<td align='left'>".$d->nama."</td>
									<td>".$this->app_model->find_matakul($d->kodemk)." | ".$this->app_model->find_dosen($d->nidn)."</td>
									
									<td><div class='text-center'>
									<a class='btn btn-sm btn-success' href='".base_url()."cadmin/home/download_materi/".$d->id."' title='download'><i class='glyphicon glyphicon-save'></i> </a>
									
									<a class='btn btn-sm btn-danger' href='javascript:void(0)' title='Hapus' onclick='delete_berkas(".'"'.$d->id.'"'.")'><i class='glyphicon glyphicon-trash'></i></a>
									</div></td>
								</tr>";
							$no++;
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
	$(document).on('click', '#close-preview', function(){ 
    $('.image-preview').popover('hide');
    // Hover befor close the preview
    $('.image-preview').hover(
        function () {
           $('.image-preview').popover('show');
        }, 
         function () {
           $('.image-preview').popover('hide');
        }
    );    
});

$(function() {
    // Create the close button
    var closebtn = $('<button/>', {
        type:"button",
        text: 'x',
        id: 'close-preview',
        style: 'font-size: initial;',
    });
    closebtn.attr("class","close pull-right");
    // Set the popover default content
    $('.image-preview').popover({
        trigger:'manual',
        html:true,
        title: "<strong>Preview</strong>"+$(closebtn)[0].outerHTML,
        content: "There's no image",
        placement:'bottom'
    });
    // Clear event
    $('.image-preview-clear').click(function(){
        $('.image-preview').attr("data-content","").popover('hide');
        $('.image-preview-filename').val("");
        $('.image-preview-clear').hide();
        $('.image-preview-input input:file').val("");
        $(".image-preview-input-title").text("Browse"); 
    }); 
    // Create the preview image
    $(".image-preview-input input:file").change(function (){     
        var img = $('<img/>', {
            id: 'dynamic',
            width:250,
            height:200
        });      
        var file = this.files[0];
        var reader = new FileReader();
        // Set preview image into the popover data-content
        reader.onload = function (e) {
            $(".image-preview-input-title").text("Change");
            $(".image-preview-clear").show();
            $(".image-preview-filename").val(file.name);            
            img.attr('src', e.target.result);
            $(".image-preview").attr("data-content",$(img)[0].outerHTML).popover("show");
        }        
        reader.readAsDataURL(file);
    });  
});
function delete_berkas(id)
{
    if(confirm('Are you sure delete this data?'))
    {
        // ajax delete data to database
        $.ajax({
            url : "<?php echo site_url('cadmin/home/hapus_berkas')?>/"+id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
                //if success reload ajax table
               alert('Sukses terhapus','Info');
			    location.reload();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error deleting data');
            }
        });

    }
}


</script>

<script type="text/javascript">
    $(document).ready(function () {
        $('#btn-input').typeahead({
            source: function (query, result) {
                $.ajax({
                    url: "<?php echo base_url().'cadmin/home/nidn_auto';?>",
					data: 'query=' + query,            
                    dataType: "json",
                    type: "POST",
                    success: function (data) {
						result($.map(data, function (item) {
							return item;
                        }));
                    }
                });
            }
        });
    });
</script>
<style>
	.typeahead { border: 1px solid #ccc;border-radius: 4px;padding: 8px 12px;max-width: 300px;min-width: 100%;background: #fff;color: #000;}
	.tt-menu { width:100%; }
	ul.typeahead{margin:0px;padding:10px 0px;}
	ul.typeahead.dropdown-menu li a {padding: 10px !important;	border-bottom:#CCC 1px solid;color:#000;}
	ul.typeahead.dropdown-menu li:last-child a { border-bottom:0px !important; }
	.bgcolor {max-width: 100%;min-width: 100%;max-height:340px;background:url("world-contries.jpg") no-repeat center center;padding: 100px 10px 130px;border-radius:4px;text-align:center;margin:10px;}
	.demo-label {font-size:1.5em;color: #686868;font-weight: 500;color:#000;}
	.dropdown-menu>.active>a, .dropdown-menu>.active>a:focus, .dropdown-menu>.active>a:hover {
		text-decoration: none;
		background-color: #778899;
		outline: 0;
	}
	</style>	