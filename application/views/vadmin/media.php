<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Melati UMMI</title>
	<link href="<?php echo base_url().'assets/images/logo.png' ?>" rel="shortcut icon" type="image/ico" />
    <!-- Bootstrap -->
    <link href="<?php echo base_url().'' ?>assets/gentelella/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?php echo base_url().'' ?>assets/gentelella/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="<?php echo base_url().'' ?>assets/gentelella/vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="<?php echo base_url().'' ?>assets/gentelella/vendors/iCheck/skins/flat/green.css" rel="stylesheet">
	<!--  autocomplite -->
	<link href="<?php echo base_url().'' ?>assets/js/bootcomplete.css" rel="stylesheet">
	
    <!-- bootstrap-progressbar -->
    <link href="<?php echo base_url().'' ?>assets/gentelella/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
    <!-- JQVMap -->
    <link href="<?php echo base_url().'' ?>assets/gentelella/vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet"/>
    <!-- bootstrap-daterangepicker -->
    <link href="<?php echo base_url().'' ?>assets/gentelella/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
	<!-- Datatables -->
    <link href="<?php echo base_url().'' ?>assets/gentelella/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url().'' ?>assets/gentelella/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url().'' ?>assets/gentelella/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url().'' ?>assets/gentelella/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url().'' ?>assets/gentelella/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
	
	
    <!-- Custom Theme Style -->
    <link href="<?php echo base_url().'' ?>assets/gentelella/build/css/custom.min.css" rel="stylesheet">
	
	<script type="text/javascript" src="<?php echo base_url().'' ?>assets/jquery/jquery.min.js"></script>
	<!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script> -->
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="<?php echo base_url().'cadmin/home';?>" class="site_title"><i class="fa fa-building"></i> <span>Melati UMMI</span></a>
            </div>

            <div class="clearfix"></div>
			<?php foreach($record as $c){$hasil[]=$c;}?>
            <!-- menu profile quick info -->
            <div class="profile clearfix">
              <div class="profile_pic">
				<?php
				$foto=$c->foto;
				if($foto=="" || $foto=="-"){
					echo "<img src='".base_url()."assets/images/avatar_2x.png' width='165px'  alt='Foto Profile' class='img-circle profile_img'>";
				}else{
					echo "<img src='".base_url()."assets/upload/".$c->foto."' width='165px'  alt='Foto Profile' class='img-circle profile_img'>";
				}
				?>
                <!-- <img src="<?php echo base_url().'' ?>assets/gentelella/production/images/img.jpg" alt="..." class="img-circle profile_img"> -->
              </div>
              <div class="profile_info">
                <span>Selamat Datang,</span>
                <h2>
				<?php 
				$username=$this->session->userdata('username');
				echo $this->app_model->find_nama_admin($username);
				?></h2>
              </div>
            </div>
            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3>Admin Menu</h3>
                <ul class="nav side-menu">
                  <li><a><i class="fa fa-home"></i> Home <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="<?php echo base_url().'cadmin/home';?>">Dashboard</a></li>
                      <li><a href="<?php echo base_url().'cadmin/home/profile';?>">Profile</a></li>
                      <li><a href="<?php echo base_url().'cadmin/password';?>">Password</a></li>
                      <li><a href="<?php echo base_url().'cadmin/home/logout';?>">Log Out</a></li>
                    </ul>
                  </li>
				  <li><a><i class="fa fa-envelope-o"></i> SMS <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="<?php echo base_url().'cadmin/inbox';?>">Inbox SMS</a></li>
                      <li><a href="<?php echo base_url().'cadmin/sent';?>">Sent SMS</a></li>
                      <li><a href="<?php echo base_url().'cadmin/pending';?>">Pending SMS</a></li>
                    </ul>
                  </li>
				  <?php 
					$level=$this->session->userdata('level');
					if($level=="mhs" || $level=="dosen"){
						echo"";
					}else{
				  ?>
				  
                  <li><a><i class="fa fa-database"></i> Bank Data <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li><a href="<?php echo base_url().'cadmin/users';?>">Data Pengguna</a></li>
                        <li><a href="<?php echo base_url().'cadmin/mahasiswa';?>">Data Mahasiswa</a></li>
                        <li><a href="<?php echo base_url().'cadmin/dosen';?>">Data Dosen</a></li>
                        <li><a href="<?php echo base_url().'cadmin/kelas';?>">Data Kelas</a></li>
                        <li><a href="<?php echo base_url().'cadmin/jurusan';?>">Data Jurusan</a></li>
                        <li><a href="<?php echo base_url().'cadmin/tempati_kelas';?>">Mhs Tempati Kelas</a></li>
                        <li><a href="<?php echo base_url().'cadmin/home/listcontent/2';?>">Organigram</a></li>
                        
                    </ul>
                  </li>
				  <li><a><i class="fa fa-edit"></i> Survei <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li><a href="<?php echo base_url().'cadmin/soal';?>">Data Soal</a></li>
                        <li><a href="<?php echo base_url().'cadmin/assisten';?>">Data Assisten</a></li>
                        <li><a href="<?php echo base_url().'cadmin/survey';?>">Survei</a></li>
                        
                        
                    </ul>
                  </li>
				  <?php } ?>
                  <li><a><i class="fa fa-book"></i> Jadwal Lab<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
					<?php 
						$level=$this->session->userdata('level');
						if($level=="admin"){
					?>
					  <li><a href="<?php echo base_url().'cadmin/matakul';?>">Set Mata Kuliah</a></li>
					  <li><a href="<?php echo base_url().'cadmin/jadwal';?>">Buat Jadwal</a></li>
					  <li><a href="<?php echo base_url().'cadmin/jadwal/lihat';?>">Lihat Jadwal</a></li>
					<?php }else{ ?>
						<li><a href="<?php echo base_url().'cadmin/jadwal/lihat';?>">Lihat Jadwal</a></li>
					<?php }?>
                    </ul>
                  </li>
				  <li><a><i class="fa fa-cubes"></i> Inventory <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
					<?php 
						$level=$this->session->userdata('level');
						if($level=="admin"){
					?>
                      <li><a href="<?php echo base_url().'cadmin/inventori';?>">Entri Inventory</a></li>
                      <li><a href="<?php echo base_url().'cadmin/adjust_inv';?>">Penyesuaian Inventory</a></li>
                      <li><a href="<?php echo base_url().'cadmin/pinjam';?>">Peminjaman Inventory</a></li>
                      <li><a href="<?php echo base_url().'cadmin/pinjam/bukti';?>">Lap Bukti Pinjam</a></li>
					  <li><a href="<?php echo base_url().'cadmin/inventori/stok';?>">Daftar Stok Inventori</a></li>
					<?php }else{ ?>
						<li><a href="<?php echo base_url().'cadmin/inventori/stok';?>">Daftar Stok Inventori</a></li>
					<?php }?>	
                    </ul>
                  </li>
                  <li><a><i class="fa fa-clone"></i> Materi <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
					<?php 
						$level=$this->session->userdata('level');
						if($level=="admin" || $level=="dosen"){
							$id=$this->session->userdata('username');
							$nidn=$this->app_model->find_nidn($id);
					?>
                      <li><a href="<?php echo base_url().'cadmin/home/upload';?>">Upload Materi</a></li>
                      <li><a href="<?php echo base_url().'cadmin/home/download/'.$nidn;?>">Download Materi</a></li>
					<?php }else{ ?>
						<li><a href="<?php echo base_url().'cadmin/home/download';?>">Download Materi</a></li>
					<?php }?>		
                    </ul>
                  </li>
				  <li><a><i class="fa fa-table"></i>Absen<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
					<?php 
						$level=$this->session->userdata('level');
						if($level=="admin" || $level=="dosen"){
					?>
					  <li><a href="<?php echo base_url().'cadmin/home/koneksi_mesin';?>">Absen dr Mesin</a></li>
                      <li><a href="<?php echo base_url().'cadmin/absen';?>">Entri Absen</a></li>
                      <li><a href="<?php echo base_url().'cadmin/absen/lihat';?>">Lihat Absen</a></li>
                    <?php }else{ ?>  
					<li><a href="<?php echo base_url().'cadmin/absen/lihat';?>">Lihat Absen</a></li>
					<li><a href="<?php echo base_url().'cadmin/absen/cek_kuliah';?>">Cek Perkuliahan</a></li>
					<?php }?>
                    </ul>
                  </li>
                  
                </ul>
             
              
              </div>

            </div>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
            <div class="sidebar-footer hidden-small">
              <a data-toggle="tooltip" data-placement="top" title="Settings" href="<?php echo base_url().'cadmin/home/profile';?> ">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="FullScreen" class="open">
                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Lock">
                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Logout" href="<?php echo base_url().'cadmin/home/logout';?>">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
              </a>
            </div>
            <!-- /menu footer buttons -->
          </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
          <div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>

              <ul class="nav navbar-nav navbar-right">
                <li class="">
                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <?php 
					$foto=$c->foto;
					if($foto=="" || $foto=="-"){
						echo "<img src='".base_url()."assets/images/avatar_2x.png' width='20px'  alt='Foto Profile' >";
					}else{
						echo "<img src='".base_url()."assets/upload/".$c->foto."' width='20px'  alt='Foto Profile' >";
					}
					?>
					<!-- <img src="<?php echo base_url().'assets/gentelella/production/';?>images/img.jpg" alt=""> -->
					
					<?php echo $this->app_model->find_nama_admin($username);?>
                    <span class=" fa fa-angle-down"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <li><a href="<?php echo base_url().'cadmin/home/profile';?>"> 
					<i class="fa fa-user pull-right"></i>
					Profile</a></li>
                    <li>
                      <a href="<?php echo base_url().'cadmin/password';?>">
                        <i class="fa fa-bullseye pull-right"></i>
                        <span>Password</span>
                      </a>
                    </li>
                    <li><a href="<?php echo base_url().'cadmin/home/logout';?>"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                  </ul>
                </li>

                <li role="presentation" class="dropdown">
                  <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-envelope-o"></i>
                    <span class="badge bg-green"><?php 
					$level=$this->session->userdata('level');
					echo $this->app_model->jml_complaint($level);?></span>
                  </a>
                  <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                    <?php
					foreach($com as $c){
						echo"
					<li>
                      <a>
                        <span class='image'><img src='".base_url()."assets/images/avatar_2x.png' alt='Profile Image' /></span>
                        
						<span>
                          <span>".$c->nama."</span>
                          <span class=\"time\">".$c->tgl."</span>
                        </span>
                        <span class=\"message\">
                          ".substr($c->pesan,0,100)."
                        </span>
                      </a>
                    </li>";
					}
                    ?>
                    <li>
                      <div class="text-center">
                        <a href="<?php echo base_url().'cadmin/home/ecomplaint';?>">
                          <strong>See All Complaint</strong>
                          <i class="fa fa-angle-right"></i>
                        </a>
                      </div>
                    </li>
                  </ul>
                </li>
				<!-- cart pinjam -->
				<li role="presentation" class="dropdown">
                  <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-shopping-cart"></i>
                    <span class="badge bg-red">
						<?php echo $this->app_model->find_cart_pinjam();?>
					</span>
                  </a>
                  <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
					<?php foreach($temp_pinjam as $t){$hasil[]=$t;?>
                    <li>
                      <a>
                        <span class="image"><img src="<?php echo base_url().'assets/';?>images/goods.ico" alt="Profile Image" /></span>
                        <span>
                          <span><?php echo $t->kode;?></span>
                          <span class="time"><?php echo $t->qty;?> pcs</span>
                        </span>
                        <span class="message">
                           <strong><?php echo $t->nama;?></strong>
                        </span>
                      </a>
                    </li>
                    <?php } ?>
                    <li>
                      <div class="text-center">
                        <a>
                          <strong>See All Alerts</strong>
                          <i class="fa fa-angle-right"></i>
                        </a>
                      </div>
                    </li>
                  </ul>
                </li>
				<!-- end cart pinjam -->
				
              </ul>
            </nav>
          </div>
        </div>
        <!-- /top navigation -->

        <!-- page content -->
        <?php echo $isi;?>
		<!-- /page content -->

        <!-- footer content -->
        <footer>
          <div class="pull-right">
            By: entaraza@gmail.com alumni ti 2011, Theme Gentelella - Bootstrap | 
			<?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?>
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
      </div>
    </div>

     <!-- jQuery -->
    <script src="<?php echo base_url().'' ?>assets/gentelella/vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="<?php echo base_url().'' ?>assets/gentelella/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
	<script src="<?php echo base_url().'' ?>assets/js/typeahead.js"></script>
    <!-- FastClick -->
    <script src="<?php echo base_url().'' ?>assets/gentelella/vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="<?php echo base_url().'' ?>assets/gentelella/vendors/nprogress/nprogress.js"></script>
    <!-- Chart.js -->
    <script src="<?php echo base_url().'' ?>assets/gentelella/vendors/Chart.js/dist/Chart.min.js"></script>
    <!-- gauge.js -->
    <script src="<?php echo base_url().'' ?>assets/gentelella/vendors/gauge.js/dist/gauge.min.js"></script>
    <!-- bootstrap-progressbar -->
    <script src="<?php echo base_url().'' ?>assets/gentelella/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <!-- iCheck -->
    <script src="<?php echo base_url().'' ?>assets/gentelella/vendors/iCheck/icheck.min.js"></script>
    <!-- Skycons -->
    <script src="<?php echo base_url().'' ?>assets/gentelella/vendors/skycons/skycons.js"></script>
    <!-- Flot -->
    <script src="<?php echo base_url().'' ?>assets/gentelella/vendors/Flot/jquery.flot.js"></script>
    <script src="<?php echo base_url().'' ?>assets/gentelella/vendors/Flot/jquery.flot.pie.js"></script>
    <script src="<?php echo base_url().'' ?>assets/gentelella/vendors/Flot/jquery.flot.time.js"></script>
    <script src="<?php echo base_url().'' ?>assets/gentelella/vendors/Flot/jquery.flot.stack.js"></script>
    <script src="<?php echo base_url().'' ?>assets/gentelella/vendors/Flot/jquery.flot.resize.js"></script>
    <!-- Flot plugins -->
    <script src="<?php echo base_url().'' ?>assets/gentelella/vendors/flot.orderbars/js/jquery.flot.orderBars.js"></script>
    <script src="<?php echo base_url().'' ?>assets/gentelella/vendors/flot-spline/js/jquery.flot.spline.min.js"></script>
    <script src="<?php echo base_url().'' ?>assets/gentelella/vendors/flot.curvedlines/curvedLines.js"></script>
    <!-- DateJS -->
    <script src="<?php echo base_url().'' ?>assets/gentelella/vendors/DateJS/build/date.js"></script>
    <!-- JQVMap -->
    <script src="<?php echo base_url().'' ?>assets/gentelella/vendors/jqvmap/dist/jquery.vmap.js"></script>
    <script src="<?php echo base_url().'' ?>assets/gentelella/vendors/jqvmap/dist/maps/jquery.vmap.world.js"></script>
    <script src="<?php echo base_url().'' ?>assets/gentelella/vendors/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="<?php echo base_url().'' ?>assets/gentelella/vendors/moment/min/moment.min.js"></script>
    <script src="<?php echo base_url().'' ?>assets/gentelella/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
	 <!-- jquery.inputmask -->
    <script src="<?php echo base_url().''?>assets/gentelella/vendors/jquery.inputmask/dist/min/jquery.inputmask.bundle.min.js"></script>
    <!-- Custom Theme Scripts -->
    <script src="<?php echo base_url().'' ?>assets/gentelella/build/js/custom.min.js"></script>
	<!-- message alert bootbox -->
	<script src="<?php echo base_url('assets/js/bootbox.min.js')?>"></script>
	
	<script src="<?php echo base_url('assets/js/jquery.fullscreen.min.js')?>"></script>
<!-- fullscreen -->
<script type="text/javascript">
$(function() {
    $('.open').click(function() {
        $('body').fullscreen();
        return false;
    });
    $('.close').click(function() {
        $.fullscreen.exit();
        return false;
    });
});
</script>

	<!-- Datatables -->
    <script src="<?php echo base_url().'' ?>assets/gentelella/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url().'' ?>assets/gentelella/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="<?php echo base_url().'' ?>assets/gentelella/vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="<?php echo base_url().'' ?>assets/gentelella/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
    <script src="<?php echo base_url().'' ?>assets/gentelella/vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="<?php echo base_url().'' ?>assets/gentelella/vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="<?php echo base_url().'' ?>assets/gentelella/vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="<?php echo base_url().'' ?>assets/gentelella/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
    <script src="<?php echo base_url().'' ?>assets/gentelella/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <script src="<?php echo base_url().'' ?>assets/gentelella/vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="<?php echo base_url().'' ?>assets/gentelella/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
    <script src="<?php echo base_url().'' ?>assets/gentelella/vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
    <script src="<?php echo base_url().'' ?>assets/gentelella/vendors/jszip/dist/jszip.min.js"></script>
    <script src="<?php echo base_url().'' ?>assets/gentelella/vendors/pdfmake/build/pdfmake.min.js"></script>
    <script src="<?php echo base_url().'' ?>assets/gentelella/vendors/pdfmake/build/vfs_fonts.js"></script>
	<!-- end datatable-->
	<!-- jQuery Smart Wizard -->
    <script src="<?php echo base_url().'' ?>assets/gentelella/vendors/jQuery-Smart-Wizard/js/jquery.smartWizard.js"></script>
	
	<!-- morris.js -->
    <script src="<?php echo base_url().'' ?>assets/gentelella/vendors/raphael/raphael.min.js"></script>
    <script src="<?php echo base_url().'' ?>assets/gentelella/vendors/morris.js/morris.min.js"></script>

 
	</body>
</html>
