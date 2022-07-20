<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jadwal extends CI_Controller { 
    
    public function __construct()
	{
		parent::__construct();
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: *");
        header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
        header('Content-Type: application/json');
        
        $this->load->model('ModelJadwal');
		$this->load->model('App_model');
	}
    
    public function select() {
        $data = $this->ModelJadwal->select();
        $total = $this->ModelJadwal->count_all();
        return $this->output->set_status_header(200)
            ->set_content_type('application/json')
            ->set_output(json_encode(['data' => $data, 'total' => $total, 'message' => 'success']));
    }

    public function show($id) {
        $data = $this->ModelJadwal->get_where(['id' => $id]);
        return $this->output->set_status_header(200)
            ->set_content_type('application/json')
            ->set_output(json_encode(['data' => $data, 'message' => 'success']));
    }

    public function store() {
        $data = $this->ModelJadwal->insert();
        return $this->output->set_status_header(200)
            ->set_content_type('application/json')
            ->set_output(json_encode(['data' => $data, 'message' => 'success']));
    } 
    
    public function cek_jadwal()
	{
		$hari=$this->input->post('hari_kode');
		$jam=$this->input->post('jam_kode');
		$smt=$this->input->post('smt');
		$kelas=$this->input->post('kelas_kode');
		$thpel=$this->input->post('thpel');
		$lab=$this->input->post('lab');
		$text 	= "SELECT * FROM jadwal 
					WHERE hari_kode='$hari'
					and jam_kode='$jam'
					
					and lab='$lab'
					and thpel='$thpel'
					and smt='$smt'
					
					";

		$q = $this->db->query($text); 
		if($q->num_rows()>0)
		{
			foreach($q->result() as $k)
			{
				$hari = $this->App_model->find_hari($k->hari_kode);
				$jam = $this->App_model->find_jam($k->jam_kode);
				$hasil ='Error, Jam '.$jam.' Hari: '.$hari.' sudah ada, ubah jam dan hari';
			}

            return $this->output->set_status_header(200)
            ->set_content_type('application/json')
            ->set_output(json_encode(['data' => null, 'message' => $hasil]));
		}
		else
		{
			$hasil = "Sukses, Jadwal Belum ada dan lanjutkan ke penyimpanan";

            return $this->output->set_status_header(200)
                ->set_content_type('application/json')
                ->set_output(json_encode(['data' => $hasil, 'message' => 'success']));
		}

	}

    public function tampilkan_jadwal() {
        $data = $this->ModelJadwal->tampilkan_jadwal();
        return $this->output->set_status_header(200)
        ->set_content_type('application/json')
        ->set_output(json_encode(['data' => $data, 'message' => 'success']));
    }


    public function delete($id) {
        $data = $this->ModelJadwal->delete($id);
        return $this->output->set_status_header(200)
            ->set_content_type('application/json')
            ->set_output(json_encode(['data' => $data, 'message' => 'success']));
    }

}
