<?php if(!defined('BASEPATH')) exit('No direct script acces allowed');
	
class ModelCart extends CI_Model {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	public function chart_survey()
	{
		$result = array(); 
		$rs = $this->db->query("SELECT soal_id, 
		SUM(IF(opsi='1', 1,0)) AS nilai1,
		SUM(IF(opsi='2', 1,0)) AS nilai2,
		SUM(IF(opsi='3', 1,0)) AS nilai3,
		SUM(IF(opsi='4', 1,0)) AS nilai4
		from survei_detail
		where soal_id<>'4'
		group by soal_id");
		foreach($rs->result_array() as $data)
		{	
			
			$row[] = array(
				'soal'	=>$this->app_model->find_ketsoal($data['soal_id']),
				'nilai1'=>$data['nilai1'],
				'nilai2'=>$data['nilai2'],
				'nilai3'=>$data['nilai3'],
				'nilai4'=>$data['nilai4'],
			);
		}
		$result=array_merge($result,$row);
		return $result;	
	}


	public function chart_survey_assisten()
	{
		$result = array(); 
		$rs = $this->db->query("SELECT ass_id, 
		AVG(IF(soal_id='4', ass_nil,0)) AS nilai
		from survei_detail
		where soal_id='4'
		group by ass_id");
		foreach($rs->result_array() as $data)
		{	
			
			$row[] = array(
				'label'	=>$this->app_model->find_assisten($data['ass_id']),
				'value'=>number_format($data['nilai'],2),
			);
		}
		$result=array_merge($result,$row);
		return json_encode($result);	
	}
	public function chart_hadir()
	{
		$result = array(); 
		$rs = $this->db->query("SELECT a.nim, a.nama,
	SUM(IF(b.hadir='a',1,0)) as a,
	SUM(IF(b.hadir='3',1,0)) as i,
	SUM(IF(b.hadir='2',1,0)) as s,
	SUM(IF(b.hadir='1',1,0)) as h
	from mahasiswa as a
	inner join absen as b
	on a.nim=b.nim 
	group by a.nim
			");
		foreach($rs->result_array() as $data)
		{	
			
			$row[] = array(
				'nim'=>substr($data['nama'],0,5),
				'H'=>$data['h'],
				'S'=>$data['s'],
				'I'=>$data['i'],
				'A'=>$data['a']
			);
		}
		$result=array_merge($result,$row);
		return json_encode($result);	
	}
}

/* end of file crud_model
Location: ./aplication/model/kec_model.php */
?>