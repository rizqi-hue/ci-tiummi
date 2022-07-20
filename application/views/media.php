<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Lab UMMI</title>
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
                        <a href="#about">Home</a>
                    </li>
					<li>
                        <a href="<?php echo base_url().'person/login_view';?>">Login</a>
                    </li>
					<li>
                        <a href="<?php echo base_url().'person/login_view#signup';?>">Daftar</a>
                    </li>
					<li>
                        <a href="#ecomplaint">e-Complaint</a>
                    </li>
                    <li>
                        <a href="#contact">Contact</a>
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


    <!-- Header -->
    <a name="about"></a>
    <div class="intro-header">
        <div class="container">

            <div class="row">
                <div class="col-lg-12">
                    <div class="intro-message">
                        <h1>Melati</h1>
                        <h3>Univ. Muhammadiyah Sukabumi</h3>
                        <hr class="intro-divider">
                        <ul class="list-inline intro-social-buttons">
                            <li>
                                <a href="https://twitter.com/ummisukabumi" class="btn btn-info btn-lg"><i class="fa fa-twitter fa-fw"></i> <span class="network-name">Twitter</span></a>
                            </li>
                            <li>
                                <a href="<?php echo base_url().'person/login_view';?>" class="btn btn-success btn-lg"><i class="fa fa-key fa-fw"></i> <span class="network-name">Login</span></a>
                            </li>
							<li>
                                <a href="<?php echo base_url().'#ecomplaint';?>" class="btn btn-warning btn-lg"><i class="fa fa-comment fa-fw"></i> <span class="network-name">e-Complaint</span></a>
                            </li>
                            <li>
                                <a href="#" class="btn btn-primary btn-lg"><i class="fa fa-facebook fa-fw"></i> <span class="network-name">Facebook</span></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
        <!-- /.container -->

    </div>
    <!-- /.intro-header -->
	
	 <!-- Header -->
    <a name="ecomplaint"></a>
    <div class="content-section-a">
        <div class="container">

            <div class="row">
                <div class="col-lg-6">
                    <div class="intro-message">
                        <h1>e-Complaint</h1>
                        <h3>Univ. Muhammadiyah Sukabumi</h3>
                    </div>
                </div>
				<div class="col-lg-6">
                    <!--  Formulir komplain -->
					 <!-- form input mask -->
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Formulir e-Complaint</h2>
                    
                    <div class="clearfix"></div>
					
                  </div>
                  <div class="x_content">
                    <br />
                    <form class="form-horizontal form-label-left" id="form" method="get" action="<?php base_url().'person/add_complaint';?>">

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3">Nama Lengkap*</label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                          <input type="text" class="form-control" name="nama">
                        </div>
                      </div>
					  <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3">NIM/NIP/NIK*</label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                          <input type="text" class="form-control" name="nim">
                        </div>
                      </div>
					  <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3">E-Mail*</label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                          <input type="text" class="form-control" name="email">
                        </div>
                      </div>
					  <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3">Nomor HP*</label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                          <input type="text" class="form-control" name="hp">
                        </div>
                      </div>
					  <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3">Subyek*</label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                          <input type="text" class="form-control" name="subject">
                        </div>
                      </div>

					  <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3">Isi Komplen*</label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                          <textarea name="pesan" id="pesan" class="form-control" rows="4"></textarea>
                        </div>
                      </div>
					  
                      <div class="ln_solid"></div>

                      <div class="form-group">
                        <div class="col-md-9 col-md-offset-3">
                          <button type="button" onclick="save()" id="btnSave" class="btn btn-primary">Kirim Pesan</button>
						  <button type="reset" class="btn btn-danger">Cancel</button>
						  
                           
							<span id="info" onclick="new PNotify({
                                  title: 'Pesan Success',
                                  text: 'Pesan berhasil dikirim dan akan segera dintidak lanjuti, terima kasih',
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
                        </div>
                      </div>

                    </form>
                  </div>
                </div>
              
			  </div>
              <!-- /form input mask -->
                </div>
            </div>

        </div>
        <!-- /.container -->

    </div>
    <!-- /.intro-header -->

<script>
function save()
{
    $('#btnSave').text('saving...'); //change button text
    $('#btnSave').attr('disabled',true); //set button disable 
    var url;
	var nama		=$('[name="nama"]').val();
	var nim			=$('[name="nim"]').val();
	var email		=$('[name="email"]').val();
	var hp			=$('[name="hp"]').val();
	var subject		=$('[name="subject"]').val();
	// var pesan		=$('[name="pesan"]').val();
	var pesan 	=$('#pesan').val();
	
	if(nama == "" || nim=="" || email=="" || hp=="" || subject=="" || pesan==""){
	   var error = true;
	   // alert("Maaf, Field masih kosong");
	   $('#error').click();
	   $('#btnSave').text('Kirim Pesan'); //change button text
       $('#btnSave').attr('disabled',false); //set button enable 
	   return (false);
	}

    url = "<?php echo site_url('person/add_complaint')?>";
   

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
				$('#info').html('<font-color="red">Pesan Gagal terkirim</font>');
			}
            $('#btnSave').text('Simpan'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error Pesan gagal terkirim','Error');
            $('#btnSave').text('Kirim Pesan'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 

        }
    });
}
</script>


   
    <!-- /.content-section-b -->

    <div class="content-section-a">

        <div class="container">

            <div class="row">
                <div class="col-lg-5 col-sm-6">
                    <hr class="section-heading-spacer">
                    <div class="clearfix"></div>
                    <h2 class="section-heading">KAMPUS<br>Univ. Muhammadiyah Sukabumi</h2>
                    <p class="lead">Program Studi Teknik Informatika <br/> Manajemen Laboratorium Teknik Informatika (Melati)</p>
                </div>
                <div class="col-lg-5 col-lg-offset-2 col-sm-6">
                    <img class="img-responsive" src="<?php echo base_url().'assets/sb-landing-page';?>/img/Lab.jpg" alt="">
                </div>
            </div>

        </div>
        <!-- /.container -->

    </div>
    <!-- /.content-section-a -->

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
