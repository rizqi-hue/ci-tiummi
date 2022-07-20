       <!-- page content -->
        <div class="right_col" role="main">
          
            <div class="page-title">
              <div class="title_left">
			  <?php
			  $level=$this->session->userdata('level');
						if($level=="admin" || $level=="dosen"){
							$id=$this->session->userdata('username');
							$nidn=$this->app_model->find_nidn($id);
			   ?>
                <h3><a href="<?php echo base_url().'cadmin/home/download/'.$nidn;?>">Download Materi</a></h3>
						<?php }else{?>
				<h3><a href="<?php echo base_url().'cadmin/home/download';?>">Download Materi</a></h3>		
						<?php }
						
						?>
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
								<th class="text-center">DOSEN </th>			
								<th class="text-center">MATAKUL </th>	
								<th class="text-center">JUDUL DOKUMEN</th>
								<th style="width:125px;" class="text-center">Action</th>
							</tr>
						</thead>
						<tbody>
							
							<?php 
							$no=1;
							$cek=$this->uri->segment(5);
							$cek1=$this->uri->segment(4);
							foreach($upload as $d){$hasil[]=$d;
							echo"<tr>
									<td align='center'>".$no."</td>
									<td><a href='".base_url().'cadmin/home/download/'.$d->nidn."'> <i class='fa fa-external-link'></i> ".$this->app_model->find_dosen($d->nidn)."</a></td>
									
									
									";
									if($cek1==""){
										echo"<td>".$this->app_model->find_jml_dok($d->nidn,$cek)." Dokumen</td>";
										echo"<td></td>";
										echo"<td></td>";
									}elseif($cek1!="" and $cek==""){
										echo"<td><a href='".base_url().'cadmin/home/download/'.$d->nidn.'/'.$d->kodemk."'> <i class='fa fa-external-link'></i> ".$this->app_model->find_matakul($d->kodemk)."</a> </td>";
										echo"<td>".$this->app_model->find_jml_dok($d->nidn,$d->kodemk)." Dokumen</td>";
										echo"<td></td>";
									}
									else{
										echo"<td><a href='".base_url().'cadmin/home/download/'.$d->nidn.'/'.$d->kodemk."'> <i class='fa fa-external-link'></i> ".$this->app_model->find_matakul($d->kodemk)."</a> </td>";
										echo"
									<td align='left'>".$d->nama."</td>
									<td><div class='text-center'>
									<a class='btn btn-sm btn-success' href='".base_url()."cadmin/home/download_materi/".$d->id."' title='download'><i class='glyphicon glyphicon-save'></i> Download</a>
									</div></td>";
									}echo"
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