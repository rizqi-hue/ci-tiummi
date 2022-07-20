<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Login Sistem </title>
	<link href="<?php echo base_url().'assets/images/logo.png' ?>" rel="shortcut icon" type="image/ico" />
    <!-- Bootstrap -->
    <link href="<?php echo base_url().'assets/gentelella';?>/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?php echo base_url().'assets/gentelella';?>/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="<?php echo base_url().'assets/gentelella';?>/vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="<?php echo base_url().'assets/gentelella';?>/vendors/animate.css/animate.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="<?php echo base_url().'assets/gentelella';?>/build/css/custom.min.css" rel="stylesheet">
  </head>

  <body class="login">
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
             <form class="form-signin" action="<?php echo base_url('person/login')?>" method="post">
              <h1>Login Sistem</h1>
              <div>
                <input type="text" id="inputUser" name="inputUser" class="form-control" placeholder="Masukan Username" required="" />
              </div>
              <div>
                <input type="password" id="inputPassword" name="inputPassword" class="form-control" placeholder="Masukan Password" required="" />
              </div>
              <div>
				<?php echo $this->session->flashdata('result_login'); ?>
                
				<button class="btn btn-default submit" type="submit">Sign in</button>
                <a class="reset_pass" href="#">Lupa password?</a>
              </div>

              <div class="clearfix"></div>

              <div class="separator">
                <p class="change_link">Belum terdaftar?
                  <a href="#signup" class="to_register"> Buat Akun</a><a href="<?php echo base_url().'./';?>">Home</a>
                </p>

                <div class="clearfix"></div>
                <br />

                <div>
                  <h1><i class="fa fa-home"></i> Melati UMMI</h1>
                  <p>©2017 All Rights Reserved Aplikasi Manajemen Laboratorium TI UMMI, Pengembang TIM IT UMMI</p>
                </div>
              </div>
            </form>
          </section>
        </div>

<script>
function save()
{
    $('#btnSave').text('saving...'); //change button text
    $('#btnSave').attr('disabled',true); //set button disable 
    var url;
	var user_id		=$('[name="user_id"]').val();
	var password	=$('[name="password"]').val();
	var nim			=$('[name="nim"]').val();
	var level		=$('[name="level"]').val();
	var namalengkap	=$('[name="namalengkap"]').val();
	
	if(user_id == "" || password==""){
	   var error = true;
	   alert("Maaf, Field masih kosong");
	   $('#btnSave').text('Buat Akun'); //change button text
       $('#btnSave').attr('disabled',false); //set button enable 
	   return (false);
	}

    url = "<?php echo site_url('person/buat_akun')?>";
   

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
                $('#info').html('Bukat Akun Sukses silahkan <a href="#signin" class="to_register"> Login </a>!');
            }else{
				$('#info').html('<font-color="red">Buat akun gagal, NIM/NIDN Sudah terdaftar!</font>');
			}
            $('#btnSave').text('Buat Akun'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error UserID sudah ada yang menggunakan/data tidak lengkap','Error');
            $('#btnSave').text('Buat Akun'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 

        }
    });
}
</script>
        <div id="register" class="animate form registration_form">
          <section class="login_content">
            <form action="#" id="form">
              <h1>Buat Akun Baru</h1>
              <div>
                <input type="text" class="form-control" name="user_id" placeholder="Username" required="" />
              </div>
              <div>
                <input type="password" class="form-control" name="password" placeholder="Password" required="" />
              </div>
			  <div>
                <input type="text" class="form-control" placeholder="NIM/NIDN" name="nim" required="" />
              </div>
			  <div>
                <input type="text" class="form-control" placeholder="Nama Lengkap" name="namalengkap"required="" />
              </div>
			  <div>
				<select name="level" class="form-control" placeholder="Pilih Opsi" required>
					<option value="mhs">Mahasiswa</option>
					<option value="dosen">Dosen</option>
				</select>
              </div>
			  </form>
			  
              <div>
                <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Buat Akun</button>
              </div>
			  </section>
			<section class="login_content">	
				<span id="info"></span>
              <div class="clearfix"></div>

              <div class="separator">
                <p class="change_link">Sudah terdaftar di Melati?
                  <a href="#signin" class="to_register"> Login </a>| <a href="<?php echo base_url().'./';?>">Home</a>
                </p>

                <div class="clearfix"></div>
                <br />

                <div>
                  <h1><i class="fa fa-home"></i> Melati UMMI</h1>
                  <p>©2016 All Rights Reserved. TIM Melati UMMI</p>
                </div>
              </div>
            
			</section>
		  
        </div>
      </div>
    </div>
  </body>
</html>

<script src="<?php echo base_url().'' ?>assets/gentelella/vendors/jquery/dist/jquery.min.js"></script>

   
	