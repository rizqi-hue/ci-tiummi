       <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Form Ganti Password</h3>
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
                    <h2>Ganti Password <small> berikut langkahnya..!</small></h2>
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
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Ganti Passoword <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          
						  <input type="password" required="required" name="password_1" id="password_1" placeholder="Password" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Ulangi Password  <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
						  <input type="password" name="password_2" id="password_2" placeholder="Ulangi password" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>
                      
                      
                      
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                          <button class="btn btn-success" onclick="simpan()"> <i class=" fa fa-save"></i> Update</button>
						  <button class="btn btn-danger" type="reset">Reset</button>
                        </div>
                      </div>

                    </div>
                  </div>
                </div>
              </div>
            </div>

            
          </div>
        </div>
        <!-- /page content -->

<script type="text/javascript">
function simpan(){
	var pwd_1 = $("#password_1").val();
	var pwd_2 = $("#password_2").val();
	
	if(!$("#password_1").val()){
		bootbox.alert('Password tidak boleh kosong');
		$("#password_1").focus();
		return false();
	}
	if(!$("#password_2").val()){
		bootbox.alert('Password tidak boleh kosong');
		$("#password_2").focus();
		return false();
	}
	if(pwd_1 != pwd_2){
		bootbox.alert('Maaf, Password tidak sama');
		return false();
	}
	//alert('Simpan');
	
	$.ajax({
		type	: 'POST',
		url		: "<?php echo site_url(); ?>cadmin/password/simpan",
		data	: "pwd_1="+pwd_1,
		//cache	: false,
		success	: function(data){
			bootbox.alert('Info '+data);
			//window.parent.location.reload(true);
			
		},
		error : function(xhr, teksStatus, kesalahan) {
			bootbox.alert('Error '+kesalahan);
		}
	});	
}
</script>
