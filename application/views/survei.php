<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Survei Service</title>
	<link href="<?php echo base_url().'assets/images/logo.png' ?>" rel="shortcut icon" type="image/ico" />
    <!-- Bootstrap Core CSS -->
    <link href="<?php echo base_url().'assets/sb-landing-page';?>/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?php echo base_url().'assets/sb-landing-page';?>/css/landing-page.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="<?php echo base_url().'assets/sb-landing-page';?>/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">
	 <!-- PNotify -->
    <link href="<?php echo base_url().'assets/gentelella'?>/vendors/pnotify/dist/pnotify.css" rel="stylesheet">
    <link href="<?php echo base_url().'assets/gentelella'?>/vendors/pnotify/dist/pnotify.buttons.css" rel="stylesheet">
    <link href="<?php echo base_url().'assets/gentelella'?>/vendors/pnotify/dist/pnotify.nonblock.css" rel="stylesheet">
	
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-fixed-top topnav" role="navigation">
        <div class="container topnav">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand topnav" href="#">Manajemen Lab TI (Melati) UMMI</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="<?php echo base_url().'';?>#about">Home</a>
                    </li>
					<li>
                        <a href="<?php echo base_url().'person/login_view';?>">Login</a>
                    </li>
					<li>
                        <a href="<?php echo base_url().'person/login_view#signup';?>">Daftar</a>
                    </li>
					<li>
                        <a href="<?php echo base_url().'';?>#ecomplaint">e-Complaint</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url().'';?>#contact">Contact</a>
                    </li>
					<li>
                        <a href="<?php echo base_url().'survei';?>">Survei</a>
                    </li>
					<li>
                        <a href="<?php echo base_url().'person/organigram/1';?>">Organigram</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>


    

    <!-- /.content-section-b -->

    <div class="content-section-a">

        <div class="container">

            <div class="row">
            <div class="col-lg-12">
				<h3>KUESIONER KEPUASAN PENGGUNA LABORATORIUM 
				PRODI TEKNIK INFORMATIKA 
				UMMI
				</h3>
			</div>
			</div>
			<div class="row">
			 <form class="form-horizontal form-label-left" id="form" method="post" action="<?php base_url().'survei/add_nilai';?>">
            <div class="col-lg-5">
			<div class="x_panel">
                  <div class="x_title">
                    <h2>Biodata</h2>
                    
                    <div class="clearfix"></div>
					
                  </div>
                  <div class="x_content">
                    <br />

                      <div class="form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-4">Nama Lengkap*</label>
                        <div class="col-md-8 col-sm-8 col-xs-8">
                          <input type="text" class="form-control" name="nama">
                        </div>
                      </div>
					  <div class="form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-4">NIM/NIP/NIK*</label>
                        <div class="col-md-8 col-sm-8 col-xs-8">
                          <input type="text" class="form-control" name="nim">
                        </div>
                      </div>
					 

					  <div class="form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-4">Keperluan*</label>
                        <div class="col-md-8 col-sm-8 col-xs-8">
                          <textarea name="keperluan" id="keperluan" class="form-control" rows="2"></textarea>
                        </div>
                      </div>
					  
                      <div class="ln_solid"></div>

                    

                  </div>
            </div>
              
			</div>
			
			<!-- col kedua -->
			<div class="col-lg-7">
			<div class="x_panel">
                  <div class="x_title">
                    <h2>Form Survey</h2>
                    
                    <div class="clearfix"></div>
					
                  </div>
                  <div class="x_content">
                    <br />
					<?php 
					$n=1;
					foreach ($soal as $s){
						if($s->id=="4"){
							echo"<div class='form-group'>";
							echo"<label>".$n.'. '.$s->soal."</label>";
								
								foreach($ass as $a){
									echo"<div class='form-group'>";
									echo"<label class='control-label col-md-3 col-sm-3 col-xs-3'>".$a->nama." <br/>(".$a->jab.")</label>";
									echo"<input type='hidden' name='soal_".$s->id."' value='".$s->id."'>";
									echo"<div class='col-md-9 col-sm-9 col-xs-12'>";
										echo"<input type='radio' name='as".$a->id."' value='100'>100 ";
										echo"<input type='radio' name='as".$a->id."' value='95'>95 ";
										echo"<input type='radio' name='as".$a->id."' value='90'>90 ";
										echo"<input type='radio' name='as".$a->id."' value='85'>85 ";
										echo"<input type='radio' name='as".$a->id."' value='80'>80 ";
										echo"<input type='radio' name='as".$a->id."' value='75'>75 ";
										echo"<input type='radio' name='as".$a->id."' value='70'>70 ";
										echo"<input type='radio' name='as".$a->id."' value='65'>65 ";
										echo"<input type='radio' name='as".$a->id."' value='60'>60 ";
										echo"<input type='radio' name='as".$a->id."' value='50'><=50 ";
									echo"</div>";
									echo"</div>";
								}
								
							echo"</div>";
						}else{
							echo"<div class='form-group'>";
							echo"<label>".$n.'. '.$s->soal."</label>";
							echo"<input type='hidden' name='soal_".$s->id."' value='".$s->id."'>";
							echo"<div class='col-md-9 col-sm-9 col-xs-12'>
									<input type='radio' name='op".$s->id."' value='1' >Sangat Puas<br/>
									<input type='radio' name='op".$s->id."' value='2'>Cukup Puas<br/>
									<input type='radio' name='op".$s->id."' value='3'>Biasa saja<br/>
									<input type='radio' name='op".$s->id."' value='4'>Tidak Puas<br/>
								</div>";
							echo"</div>";
						}
					$n++;
					}
					?>
					
                    <div class="form-group">
                        <div class="col-md-9 col-md-offset-3">
                         <button type="button" onclick="save()" id="btnSave" class="btn btn-primary">Kirim Pesan</button>
						  <button type="reset" class="btn btn-danger">Cancel</button>
						<span id="info" onclick="new PNotify({
                                  title: 'Survey Success',
                                  text: 'Data survey telah berhasil dikirim ke Server, Terima kasih',
                                  type: 'success',
                                  hide: false,
                                  styling: 'bootstrap3'
                              });"></span>
							  <span id="error" onclick="new PNotify({
                                  title: 'Pesan Error',
                                  text: 'Formulir masih ada yang kosong.',
                                  type: 'error',
                                  hide: false,
                                  styling: 'bootstrap3'
                              });"></span>
							  <span id="error2" onclick="new PNotify({
                                  title: 'Pesan Error',
                                  text: 'Anda telah melakukan posting survey sebelumnya, silahkan isi survey kembali 1 bulan kedepan.',
                                  type: 'error',
                                  hide: false,
                                  styling: 'bootstrap3'
                              });"></span>
							  
                        </div>
                    </div>

                  </div>
            </div>
			</div>
			</form>
            </div>  <!-- /.end row -->

        </div>
        <!-- /.container -->

    </div>
    <!-- /.content-section-a -->
<script type="text/javascript">
function save()
{
    $('#btnSave').text('saving...'); //change button text
    $('#btnSave').attr('disabled',true); //set button disable 
    var url;
	var nama		=$('[name="nama"]').val();
	var nim			=$('[name="nim"]').val();
	var keperluan	=$('[name="keperluan"]').val();
	
	if(nama == "" || nim=="" || keperluan==""){
	   var error = true;
	   // alert("Maaf, Field masih kosong");
	  $('#error').click();
	  
	   $('#btnSave').text('Posting Survey'); //change button text
       $('#btnSave').attr('disabled',false); //set button enable 
	   return (false);
	}

    url = "<?php echo site_url('survei/add_nilai')?>";
   

    // ajax adding data to database
    $.ajax({
        url : url,
        type: "POST",
        data: $('#form').serialize(),
        dataType: "JSON",
        success: function(data)
        {

            if(data.status) //if success 
            {
                $('#form')[0].reset(); // reset form on moda
                $('#info').click();
            }else{
				$('#error2').click();
			}
            $('#btnSave').text('Posting Survey'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error Pesan gagal terkirim','Error');
            $('#btnSave').text('Ulang Posting Survey'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 

        }
    });
}
</script>


	<a  name="contact"></a>
    <div class="banner">

        <div class="container">

            <div class="row">
                <div class="col-lg-6">
                    <h2>Available in GooglePlay</h2>
                </div>
                <div class="col-lg-6">
                    <ul class="list-inline banner-social-buttons">
                        <li>
                                <a href="https://twitter.com/ummisukabumi" class="btn btn-default btn-lg"><i class="fa fa-twitter fa-fw"></i> <span class="network-name">Twitter</span></a>
                            </li>
                            <li>
                                <a href="<?php echo base_url().'person/login_view';?>" class="btn btn-default btn-lg"><i class="fa fa-key fa-fw"></i> <span class="network-name">Login</span></a>
                            </li>
                            <li>
                                <a href="#" class="btn btn-default btn-lg"><i class="fa fa-facebook fa-fw"></i> <span class="network-name">Facebook</span></a>
                            </li>
                    </ul>
                </div>
            </div>

        </div>
        <!-- /.container -->

    </div>
    <!-- /.banner -->

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <ul class="list-inline">
                        <li>
                            <a href="#">Home</a>
                        </li>
                        <li class="footer-menu-divider">&sdot;</li>
                        <li>
                            <a href="#about">About</a>
                        </li>
                        <li class="footer-menu-divider">&sdot;</li>
                        <li>
                            <a href="#services">Services</a>
                        </li>
                        <li class="footer-menu-divider">&sdot;</li>
                        <li>
                            <a href="#contact">Contact</a>
                        </li>
                    </ul>
                    <p class="copyright text-muted small">Copyright &copy; Prodi TI Univ. Muhammadiyah Sukabumi All Rights Reserved</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- jQuery -->
    <script src="<?php echo base_url().'assets/sb-landing-page';?>/js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo base_url().'assets/sb-landing-page';?>/js/bootstrap.min.js"></script>
	<!-- PNotify -->
    <script src="<?php echo base_url().'assets/gentelella'?>/vendors/pnotify/dist/pnotify.js"></script>
    <script src="<?php echo base_url().'assets/gentelella'?>/vendors/pnotify/dist/pnotify.buttons.js"></script>
    <script src="<?php echo base_url().'assets/gentelella'?>/vendors/pnotify/dist/pnotify.nonblock.js"></script>
	
</body>

</html>
