    <div class="container-fluid" style="padding-left:0px; padding-right:0px;">
        <!-- Page Heading -->
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">
					Download<small>Dokumen</small>
				</h1>
				<ol class="breadcrumb">
					<li class="active">
					   <i class="fa fa-dashboard"></i>  <a href="<?php echo base_url().'person' ?>">Dashboard</a>
					</li>
					
					<li class="active">
						<i class="fa fa-fw fa-download"></i> Download Dokumen
					</li>
				</ol>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading">
					 DAFTAR DOKUMEN YANG DAPAT DI DOWNLOAD
					</div>
					<div class="panel-body">
						<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
						<thead>
							<tr>
								
								<th>Judul</th>
								<th>File</th>
								<th style="width:8%">Act</th>
							</tr>
						</thead>
						<tbody>
							<?php
								// $query = $this->db->query("SELECT * FROM content where idmenu='$idmenu' order by id asc")->result();
								
								foreach($record  as $row){
									echo"<tr>";
									echo"<td>".$row->nama."</td>";
									echo"<td>".$row->berkas."</td>";
									echo'<td align="center"><a class="btn btn-sm btn-primary" href="'.base_url().'/cmain/home/download_berkas/'.$row->id.'" title="Save" ><i class="glyphicon glyphicon-save"></i></a></td>';
									echo"</tr>";
								}
								
							?>
						</tbody>
						</table>
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
		
   


