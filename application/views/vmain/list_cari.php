<?php

if($kata->num_rows()>=1){
	foreach($kata->result() as $rk){
		echo"
		<div class=\"alert alert-success\">
		<li><a href='".base_url()."cmain/home/contentshow/".$rk->id."'><i class=\"fa fa-check fa-fw\"></i> ".$rk->judul_content."</a></li>
		</div>";
	}
		}else{
			echo"
			<div class=\"alert alert-danger\">
			<li><a href='#'><i class=\"fa fa-times fa-fw\"></i> Tidak Ada</a></li>
			</div>";
		}
	
?>