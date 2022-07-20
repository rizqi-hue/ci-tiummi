<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AuthMahasiswa extends CI_Controller { 
    
    public function __construct()
	{
		parent::__construct();
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: *");
        header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
        header('Content-Type: application/json');
        
        $this->load->model('Mahasiswa_model');
	}

    public function getAll()
    {
        $data = $this->Mahasiswa_model->get_where(['nim' => $this->input->post('nim')]);
        return $this->output->set_status_header(200)
            ->set_content_type('application/json')
            ->set_output(json_encode(['data' => $data, 'message' => 'success']));   
    }

    public function get()
    {
        $data = $this->Mahasiswa_model->get_where(['nim' => $this->input->post('nim')]);
        return $this->output->set_status_header(200)
            ->set_content_type('application/json')
            ->set_output(json_encode(['data' => $data, 'message' => 'success']));   
    }

    public function change_password() {
        $id = $this->input->post('id');
        $password = $this->input->post('password');
        $data = $this->Mahasiswa_model->update(['id' => $id], ['password' => $password]);
        
        return $this->output->set_status_header(200)
        ->set_content_type('application/json')
        ->set_output(json_encode(['data' => $data, 'message' => 'success']));
    }

    public function login() {
        $jwt = new JWT();
        $jwtsecreetkey = "mysecreetview";

        $username = $this->input->post('username');
        $password = $this->input->post('password');

        $mahasiswa = $this->Mahasiswa_model->get_where(['nim' => $username, 'password' => $password]);
        
        if ($mahasiswa)
        {
            $data = array(
                'id' => $mahasiswa->id,
                'nim' => $mahasiswa->nim,
                'nama' => $mahasiswa->nama,
                'password' => $mahasiswa->password,
            );
    
            $token = $jwt->encode($data, $jwtsecreetkey, 'HS256');
    
            $result = array(
               'user' => array(
                    'id' => $mahasiswa->id,
                    'nim' => $mahasiswa->nim,
                    'nama' => $mahasiswa->nama,
                    'password' => $mahasiswa->password,
               ),
               'token' => $token
            );


            return $this->output->set_status_header(200)
                ->set_content_type('application/json')
                ->set_output(json_encode(['data' => $result, 'message' => 'success']));
        }
        else
        {
            return $this->output->set_status_header(401)
                ->set_content_type('application/json')
                ->set_output(json_encode(['data'=> null, 'message' => "Error"]));
        }
    }

    public function decode_token() {
        $token = $this->uri->segment(4);
        $jwt = new JWT();
        $jwtsecreetkey = "mysecreetview";

        $decode_token = $jwt->decode($token, $jwtsecreetkey, 'HS256');

        $data = $jwt->jsonEncode($decode_token);
        echo $data;
    }
}