    <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Content Post</h3>
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
					    <strong>Form Posting Content</strong>
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
						<div class="row">
							<div class="col-lg-12">
							<?php echo form_open_multipart('cadmin/home/content_add') ?>
								<div class="form-group">
									<label>Judul Content</label>
									<input style="width: 100%;" name="judul" type="text" class="form-control" required="">
								</div>
								<div class="form-group">
									<label>Menu </label>
									<input type="hidden" name="idmenu" value="2">
									<input style="width: 100%;" name="menu" type="text" class="form-control" required="" 
									value="Organigram">
								</div>
								<div class="form-group">
									<label>Isi Content</label>
									<textarea name="isi" class="form-control" rows="6"></textarea>
								</div>
								
								<button name="simpan" type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-send"></i> Post Content</button> | <button type="reset" class="btn btn-danger">Reset</button>
							</form>

							
							</div>
						</div>
					
                  </div>
                </div>
              </div>
			  <!-- /.panel-body -->
			</div>
		</div>
    </div>
        <!-- /page content -->	


   <!-- tiny_mce bootbox -->
	
<script type="text/javascript" src="<?php echo base_url().'assets/tinymce/'?>js/tinymce/tinymce.min.js"></script>
<script type="text/javascript" src="<?php echo base_url().'assets/tinymce/'?>js/tinymce/plugins/jbimages/plugin.js"></script>
<script type="text/javascript">
 
tinymce.init({
  selector: "textarea",
  theme:"modern",
  
  // ===========================================
  // INCLUDE THE PLUGIN
  // ===========================================
	
  plugins: [
    "advlist autolink lists link image charmap print preview anchor",
    "searchreplace visualblocks code fullscreen",
    "insertdatetime media table contextmenu paste jbimages filemanager"
  ],
	
  // ===========================================
  // PUT PLUGIN'S BUTTON on the toolbar
  // ===========================================
	
  toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image jbimages media print preview table",
	
  // ===========================================
  // SET RELATIVE_URLS to FALSE (This is required for images to display properly)
  // ===========================================
	
  relative_urls: false
	
});
 
</script>
<!-- /TinyMCE -->