<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller { 
    
    public function __construct()
	{
		parent::__construct();
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: *");
        header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
        header('Content-Type: application/json');
        
        $this->load->model('ModelKelas');
        $this->load->model('Mahasiswa_model');
        $this->load->model('ModelDosen');
        $this->load->model('ModelInventori');
        $this->load->model('ModelPinjam');
	}
    
    public function select() {
        $total_kelas = $this->ModelKelas->count_all();
        $total_mahasiswa = $this->Mahasiswa_model->count_all();
        $total_dosen = $this->ModelDosen->count_all();
        $total_inventori = $this->ModelInventori->count_all();
        $total_pinjam_inventori = $this->ModelPinjam->count_all();
        $total_inventori_by_kategori = $this->ModelInventori->select_count_kategori();

        $array = array(
            'total_kelas' => $total_kelas,
            'total_mahasiswa' => $total_mahasiswa,
            'total_dosen' => $total_dosen,
            'total_inventori' => $total_inventori,
            'total_pinjam_inventori' => $total_pinjam_inventori,
            'total_inventori_by_kategori' =>  $total_inventori_by_kategori
        );

        return $this->output->set_status_header(200)
            ->set_content_type('application/json')
            ->set_output(json_encode(['data' => $array, 'message' => 'success']));
    }

}