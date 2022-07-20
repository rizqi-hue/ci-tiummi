<!-- page content -->
        <div class="right_col" role="main">
          
          <div class="row">

			<!-- bar chart -->
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel tile fixed_height_580 overflow_hidden">
					<div class="x_title">
                    <h2>Survey<small>Chart</small></h2>
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
                    <div id="hadir-chart-bar" style="width:100%; height:440px;"></div>
                  </div>
                </div>
              </div>
			  <script>
			  $(document).ready(function() {
					$.getJSON("<?php echo site_url('cadmin/survey/chart_survey'); ?>", function (json) { 
						var acctregs = new Morris.Bar({
									// ID of the element in which to draw the chart.
									element: 'hadir-chart-bar',
									// Chart data records -- each entry in this array corresponds to a point on
									// the chart.
									data: json,
									xkey: 'soal',
									ykeys: ['nilai1','nilai2','nilai3','nilai4'],
									labels: ['Puas','Cukup','Biasa','Jelek'],
									barRatio: 0.4,
									xLabelAngle: 35,
									hideHover: 'auto',
									resize: true
								});
					});
			  });
				</script>
              <!-- /bar charts -->
   
          </div>

<div class="row">

			<!-- bar chart -->
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel tile fixed_height_580 overflow_hidden">
					<div class="x_title">
                    <h2>Survey Chart <small> Penilaian Petugas Laboran</small></h2>
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
                    <div id="hadir-chart-bar-assisten" style="width:100%; height:440px;"></div>
                  </div>
                </div>
              </div>
			  <script>
			   $(document).ready(function() {
					$.getJSON("<?php echo site_url('cadmin/survey/chart_survey_assisten'); ?>", function (json) { 
						var acctregs = new Morris.Donut({
									// ID of the element in which to draw the chart.
									element: 'hadir-chart-bar-assisten',
									// Chart data records -- each entry in this array corresponds to a point on
									// the chart.
									data: json,
									xkey: 'label',
									ykeys: ['value'],
									labels: ['Nilai'],
									barRatio: 0.4,
									xLabelAngle: 35,
									hideHover: 'auto',
									resize: true
								});
					});
			   });
				</script>
              <!-- /bar charts -->
   
          </div>


         
		</div>
        <!-- /page content -->