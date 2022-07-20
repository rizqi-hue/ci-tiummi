    <div class="container-fluid" style="padding-left:0px; padding-right:0px;">
        <!-- Page Heading -->
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">
					<small><?php echo $record['judul_content'];?></small>
				</h1>
				<ol class="breadcrumb">
					<li class="active">
					   <i class="fa fa-dashboard"></i>  <a href="<?php echo base_url().'person' ?>">Dashboard</a>
					</li>
					<li class="active">
						<i class="fa fa-fw fa-user"></i> <a href="<?php echo base_url().'cmain/home/listcontent/'.$idmenu.'/'; ?>">List Content</a>
					</li>
					<li class="active">
						<i class="fa fa-fw fa-user"></i> Detail Content
					</li>
				</ol>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading">
					   <?php 
						echo date('d M Y', strtotime($record['tanggal'])); echo " Jam: ".date('H:m:s', strtotime($record['tanggal']));
					   ?>
					</div>
					<div class="panel-body">

					<?php 
					echo $record["isi_content"];
					?>
					 
					
					</div>
                            <!-- /.panel-body -->
				</div>
			</div>
		</div>
	</div>
	
		<!-- Page footer -->
		<?php 
		$this->load->view('vmain/footer');
		?>
		
    </div>


