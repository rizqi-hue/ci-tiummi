<!-- page content -->
        <div class="right_col" role="main">
          <!-- top tiles -->
          <div class="row tile_count">
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> Total Users</span>
              <div class="count">
				<?php 
					echo number_format($this->app_model->find_jml_users());
				?>
			  </div>
              <span class="count_bottom"><i class="green">4% </i> Minggu Trakhir</span>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-users"></i> Jumlah Mahsiswa</span>
              <div class="count red">
				<?php 
				echo number_format($this->app_model->find_jml_mhs());
				?>
			  </div>
              <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i></i> Berhasil di entri</span>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> Jumlah Dosen</span>
              <div class="count green">
				<?php 
					echo number_format($this->app_model->find_jml_dosen());
				?>
			  </div>
              <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>100% </i> Data Masuk</span>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-tags"></i> Jenis Inventori</span>
              <div class="count">
				<?php 
					echo number_format($this->app_model->find_jml_inv());
				?>
			  </div>
              <span class="count_bottom"><i class="red"><i class="fa fa-sort-desc"></i>100% </i> Data Masuk</span>
            </div>
			<div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-building-o"></i> Jumlah Kelas</span>
              <div class="count red">
				<?php 
					echo number_format($this->app_model->find_jml_kelas());
				?>
			  </div>
              <span class="count_bottom"><i class="red"><i class="fa fa-sort-desc"></i>100% </i> Data Masuk</span>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-users"></i> Jumlah Peminjam</span>
              <div class="count blue">
				<?php 
					echo number_format($this->app_model->find_jml_kelas());
				?>
			  </div>
              <span class="count_bottom"><i class="red"><i class="fa fa-sort-desc"></i>100% </i> Data Masuk</span>
            </div>
          </div>
          <!-- /top tiles -->

          <br/>

          <div class="row">

			<!-- bar chart -->
              <div class="col-md-4 col-sm-4 col-xs-12">
                <div class="x_panel tile fixed_height_320 overflow_hidden">
					<div class="x_title">
                    <h2>Kehadiran<small>Mahasiswa</small></h2>
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
                    <div id="hadir-chart-bar" style="width:100%; height:280px;"></div>
                  </div>
                </div>
              </div>
			  <script>
			   $(document).ready(function() {
					$.getJSON("<?php echo site_url('cadmin/home/chart_hadir'); ?>", function (json) { 
						var acctregs = new Morris.Bar({
									// ID of the element in which to draw the chart.
									element: 'hadir-chart-bar',
									// Chart data records -- each entry in this array corresponds to a point on
									// the chart.
									data: json,
									xkey: 'nim',
									ykeys: ['H','S','I','A'],
									labels: ['H','S','I','A'],
									barRatio: 0.4,
									xLabelAngle: 35,
									hideHover: 'auto',
									resize: true
								});
					});
			   });
				</script>
              <!-- /bar charts -->
            
            <div class="col-md-4 col-sm-4 col-xs-12">
              <div class="x_panel tile fixed_height_320 overflow_hidden">
                <div class="x_title">
                  <h2>Kategori Inventori</h2>
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
                  <table class="" style="width:100%">
                    <tr>
                      <th style="width:37%;">
                        <p>Top 4</p>
                      </th>
                      <th>
                        <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                          <p class="">Kategori</p>
                        </div>
                        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                          <p class="">Prosentase</p>
                        </div>
                      </th>
                    </tr>
                    <tr>
                      <td>
                        <canvas class="canvasDoughnut" height="140" width="140" style="margin: 15px 10px 10px 0"></canvas>
                      </td>
                      <td>
                        <table class="tile_info">
                          <tr>
                            <td>
                              <p><i class="fa fa-square blue"></i>Komputer</p>
                            </td>
                            <td>30%</td>
                          </tr>
                          <tr>
                            <td>
                              <p><i class="fa fa-square green"></i>Jaringan</p>
                            </td>
                            <td>10%</td>
                          </tr>
                          <tr>
                            <td>
                              <p><i class="fa fa-square purple"></i>Meubel</p>
                            </td>
                            <td>20%</td>
                          </tr>
                          <tr>
                            <td>
                              <p><i class="fa fa-square aero"></i>Lainya </p>
                            </td>
                            <td>15%</td>
                          </tr>
                          
                        </table>
                      </td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>


            <div class="col-md-4 col-sm-4 col-xs-12">
              <div class="x_panel tile fixed_height_320">
                <div class="x_title">
                  <h2>Entri progress</h2>
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
                  <div class="dashboard-widget-content">
                    <ul class="quick-list">
                      <li><i class="fa fa-calendar-o"></i><a href="#">Mahasiswa</a>
                      </li>
                      <li><i class="fa fa-bars"></i><a href="#">Dosen</a>
                      </li>
                      <li><i class="fa fa-bar-chart"></i><a href="#">Inventori</a> </li>
                      <li><i class="fa fa-line-chart"></i><a href="#">Jadwal</a></li>
                      <li><i class="fa fa-area-chart"></i><a href="#">Logout</a>
                      </li>
                    </ul>

                    <div class="sidebar-widget">
                        <h4>Progress entri data</h4>
                        <canvas width="150" height="80" id="chart_gauge_01" class="" style="width: 160px; height: 100px;"></canvas>
                        <div class="goal-wrapper">
                          <span id="gauge-text" class="gauge-value pull-left">0</span>
                          <span class="gauge-value pull-left">%</span>
                          <span id="goal-text" class="goal-value pull-right">100%</span>
                        </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>


          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2>Riwayat Aktivitas <small></small></h2>
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
                  <div class="dashboard-widget-content">

                    <ul class="list-unstyled timeline widget">
                      <li>
                        <div class="block">
                          <div class="block_content">
							<?php foreach($sesi as $ses){$hasil[]=$ses;}?>
                            <h2 class="title">
                                              <a>Login </a>
                                          </h2>
                            <div class="byline">
                              <span><?php 
								echo "Session ID: ".$ses->session_id."<br/>";
								echo "IP Address: ".$ses->ip_address."<br/>";
								echo "User Agent: ".$ses->user_agent."<br/>";
								$hasil=explode(';',$ses->user_data);
								echo $hasil[10].':'.$hasil[11];
							
							  ?></span> 
                            </div>
                            <p class="excerpt"><a></a>
                            </p>
                          </div>
                        </div>
                      </li>
                      
                    </ul>
                  </div>
                </div>
              </div>
            </div>
			
			
              <!-- /bar charts -->

            
		  </div>
        </div>
        <!-- /page content -->