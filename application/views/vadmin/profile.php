       <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Profile Pengguna</h3>
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
					<?php foreach($record as $c){$hasil[]=$c;}?>
                    <h2>Profile  <small><?php echo $c->namalengkap;?></small></h2>
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
						<div class="form-group">
						<center>
							<?php
							$foto=$c->foto;
							if($foto=="" || $foto=="-"){
								echo "<img src='".base_url()."assets/images/avatar_2x.png' width='165px'  class='img-circle img-responsive'>";
							}else{
								echo "<img src='".base_url()."assets/upload/".$c->foto."' width='165px'  class='img-circle img-responsive'>";
							}
							?>
						</div>
							</center>	
                      <?php echo form_open_multipart('cadmin/home/upload_add') ?>
					  <input type="hidden" name="user_id" value="<?php echo $c->user_id;?>">
                      
                        <!-- image-preview-filename input [CUT FROM HERE]-->
						<div class="input-group image-preview">
							<input type="text" class="form-control image-preview-filename" disabled="disabled"> <!-- don't give a name === doesn't send on POST/GET -->
							<span class="input-group-btn">
								<!-- image-preview-clear button -->
								<button type="button" class="btn btn-default image-preview-clear" style="display:none;">
									<span class="glyphicon glyphicon-remove"></span> Clear
								</button>
								<!-- image-preview-input -->
								<div class="btn btn-default image-preview-input">
									<span class="glyphicon glyphicon-folder-open"></span>
									<span class="image-preview-input-title">Browse</span>
									<input type="file" accept="image/png, image/jpeg, image/gif" name="input-file-preview"/> <!-- rename it -->
								</div>
								
								<button name="upload" type="submit" class="btn btn-success"><span class="glyphicon glyphicon-upload"></span> Upload</button>
							</span>
						</div><!-- /input-group image-preview [TO HERE]--> 
                      
          
                     
						</form>
                    </div>
                  </div>
                </div>
              </div>
			  
			  <!-- end panel --> 
			  <div class="col-md-8 col-sm-8 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
					
                    <h2>Detail<small><?php echo $c->namalengkap;?></small></h2>
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
					<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
						<thead>
							<tr>
								<th colspan='2'>PROFILE AKUN</th>
							   
							</tr>
						</thead>
						<?php foreach($record  as $row){?>
						<tbody>
							<tr class="odd gradeX">
								<td width="40%">Nama Lengkap</td>
								<td><?php echo $row->namalengkap;?></td>                                      
							</tr>
							<tr class="even gradeC">
								<td>Username</td>
								<td><?php echo $row->user_id;?></td>                                      
							</tr>
							<tr class="even gradeC">
								<td>Password</td>
								<td><?php echo "<i>encrypted</i>";?></td>                                      
							</tr>
							<tr class="even gradeC">
								<td>Level</td>
								<td><?php echo $row->level;?></td>                                      
							</tr>
							<?php
							$level=$this->session->userdata('level');
							if($level=="mhs"){
								echo"<tr>
										<td>NIM / NIDN</td>
										<td>".$row->nim."</td>
									</tr>";
							}
							?>
						</tbody>
						<?php }?>
					</table>
					<?php 
					$level = $this->session->userdata('level');
					if($level=="mhs")
					{
					?>
					<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
						<thead>
							<tr>
								<th colspan='2'>IDENTITAS <?php echo strtoupper($level);?></th>
							   
							</tr>
						</thead>
						<tbody>
							<?php foreach($mhs  as $rm){
							echo"<tr>
									<td width='40%'>NIM </td>
									<td>".$rm->nim." </td>
								</tr>";	
							echo"<tr>
									<td>Nama Mahasiswa </td>
									<td>".$rm->nama." </td>
								</tr>";
							echo"<tr>
									<td>Jenis Kelamin </td>
									<td>".$this->app_model->jk($rm->jk)." </td>
								</tr>";
							echo"<tr>
									<td>Tempat Tgl Lahir </td>
									<td>".$rm->tlahir.', '.$this->app_model->tgl_str($rm->tgllahir)." </td>
								</tr>";
							echo"<tr>
									<td>Jurusan/Prodi </td>
									<td>".$rm->jurusan." </td>
								</tr>";
							echo"<tr>
									<td>Alamat </td>
									<td>".$rm->alamat." </td>
								</tr>";
							echo"<tr>
									<td>Telpn/HP </td>
									<td>".$rm->telp." </td>
								</tr>";
							}
							?>
						</tbody>
					</table>
					<?php }elseif($level=="dosen")
					{
					?>
					<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
						<thead>
							<tr>
								<th colspan='2'>IDENTITAS <?php echo strtoupper($level);?></th>
							   
							</tr>
						</thead>
						<tbody>
							<?php foreach($mhs  as $rm){
							echo"<tr>
									<td width='40%'>NIM </td>
									<td>".$rm->nidn." </td>
								</tr>";	
							echo"<tr>
									<td>Nama Mahasiswa </td>
									<td>".$rm->nama." </td>
								</tr>";
							echo"<tr>
									<td>Jenis Kelamin </td>
									<td>".$this->app_model->jk($rm->jk)." </td>
								</tr>";
							echo"<tr>
									<td>Jurusan/Prodi </td>
									<td>".$rm->jabatan." </td>
								</tr>";
							echo"<tr>
									<td>Tempat Tgl Lahir </td>
									<td>".$rm->tlahir.', '.$this->app_model->tgl_str($rm->tgllahir)." </td>
								</tr>";
							echo"<tr>
									<td>Alamat </td>
									<td>".$rm->alamat." </td>
								</tr>";
							
							}
							?>
						</tbody>
					</table>
					<?php }?>
                  </div>
                </div>
              </div>
			  
			  
            </div>

            
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
</script>