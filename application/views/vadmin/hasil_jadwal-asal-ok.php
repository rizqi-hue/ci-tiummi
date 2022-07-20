<div class="x_content">
<h2>Jadwal Lab <?php echo $lab;?></h2>
<table id="myTable" class="table table-striped table-bordered">
					
	<thead>
		<tr>
			<th class="text-center" width="13%">JAM</th>
			<th class="text-center" width="13%">SENIN</th>
			<th class="text-center" width="13%">SELASA</th>
			<th class="text-center" width="13%">RABU</th>
			<th class="text-center" width="13%">KAMIS</th>
			<th class="text-center" width="13%">JUMAT</th>
			<th class="text-center" width="13%">SABTU</th>
			<th class="text-center" width="13%">MINGGU</th>
		</tr>
	</thead>
	<tbody>
	<?php
		foreach($kata as $r){//waktu
			echo"<tr>";
				echo"<td align='center'>".$r->jam." </td>";
				
				$hari=2;//hari senin 
				$matakul=$this->app_model->find_jadwal_matakul($r->kode,$kelas,$smt,$thpel,$lab,$hari);
				$dosen=$this->app_model->find_jadwal_dosen($r->kode,$kelas,$smt,$thpel,$lab,$hari);
				echo"<td>".$this->app_model->find_jadwal_kelas($r->kode,$kelas,$smt,$thpel,$lab,$hari)."<br/>
				".$this->app_model->find_matakul($matakul)."<br/>
				<b>".$this->app_model->find_dosen($dosen)."<b>
				</td>";
				$hari=3;//hari selasa
				$matakul=$this->app_model->find_jadwal_matakul($r->kode,$kelas,$smt,$thpel,$lab,$hari);
				$dosen=$this->app_model->find_jadwal_dosen($r->kode,$kelas,$smt,$thpel,$lab,$hari);
				echo"<td>".$this->app_model->find_jadwal_kelas($r->kode,$kelas,$smt,$thpel,$lab,$hari)."<br/>".$this->app_model->find_matakul($matakul)."<br/>
				<b>".$this->app_model->find_dosen($dosen)."<b></td>";
				$hari=4;//hari rabu
				$matakul=$this->app_model->find_jadwal_matakul($r->kode,$kelas,$smt,$thpel,$lab,$hari);
				$dosen=$this->app_model->find_jadwal_dosen($r->kode,$kelas,$smt,$thpel,$lab,$hari);
				echo"<td>".$this->app_model->find_jadwal_kelas($r->kode,$kelas,$smt,$thpel,$lab,$hari)."<br/>".$this->app_model->find_matakul($matakul)."<br/>
				<b>".$this->app_model->find_dosen($dosen)."<b></td>";
				$hari=5;//hari kamis
				$matakul=$this->app_model->find_jadwal_matakul($r->kode,$kelas,$smt,$thpel,$lab,$hari);
				$dosen=$this->app_model->find_jadwal_dosen($r->kode,$kelas,$smt,$thpel,$lab,$hari);
				echo"<td>".$this->app_model->find_jadwal_kelas($r->kode,$kelas,$smt,$thpel,$lab,$hari)."<br/>".$this->app_model->find_matakul($matakul)."<br/>
				<b>".$this->app_model->find_dosen($dosen)."<b></td>";
				$hari=6;//hari jumat
				$matakul=$this->app_model->find_jadwal_matakul($r->kode,$kelas,$smt,$thpel,$lab,$hari);
				$dosen=$this->app_model->find_jadwal_dosen($r->kode,$kelas,$smt,$thpel,$lab,$hari);
				echo"<td>".$this->app_model->find_jadwal_kelas($r->kode,$kelas,$smt,$thpel,$lab,$hari)."<br/>".$this->app_model->find_matakul($matakul)."<br/>
				<b>".$this->app_model->find_dosen($dosen)."<b></td>";
				$hari=7;//hari jumat
				$matakul=$this->app_model->find_jadwal_matakul($r->kode,$kelas,$smt,$thpel,$lab,$hari);
				$dosen=$this->app_model->find_jadwal_dosen($r->kode,$kelas,$smt,$thpel,$lab,$hari);
				echo"<td>".$this->app_model->find_jadwal_kelas($r->kode,$kelas,$smt,$thpel,$lab,$hari)."<br/>".$this->app_model->find_matakul($matakul)."<br/>
				<b>".$this->app_model->find_dosen($dosen)."<b></td>";
				$hari=1;//hari jumat
				$matakul=$this->app_model->find_jadwal_matakul($r->kode,$kelas,$smt,$thpel,$lab,$hari);
				$dosen=$this->app_model->find_jadwal_dosen($r->kode,$kelas,$smt,$thpel,$lab,$hari);
				echo"<td>".$this->app_model->find_jadwal_kelas($r->kode,$kelas,$smt,$thpel,$lab,$hari)."<br/>".$this->app_model->find_matakul($matakul)."<br/>
				<b>".$this->app_model->find_dosen($dosen)."<b></td>";
			echo"</tr>";
		}
	?>
	</tbody>

</table>

</div>
