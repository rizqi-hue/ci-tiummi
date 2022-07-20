<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AuthAdmin extends CI_Controller { 
    
    public function __construct()
	{
		parent::__construct();
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: DELETE, POST, GET, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
        header("Content-Type: application/json");
        $this->load->model('Users_model');
        $this->load->model('Mahasiswa_model');
        $this->load->model('ModelDosen');
	}

    public function select()
    {
        $data = $this->Users_model->select();
        return $this->output->set_status_header(200)
            ->set_content_type('application/json')
            ->set_output(json_encode(['data' => $data, 'message' => 'success']));   
    }

    public function delete()
    {
        $data = $this->Users_model->delete();
        return $this->output->set_status_header(200)
            ->set_content_type('application/json')
            ->set_output(json_encode(['data' => $data, 'message' => 'success']));   
    }

    public function store()
    {
        $data = $this->Users_model->store();
        return $this->output->set_status_header(200)
            ->set_content_type('application/json')
            ->set_output(json_encode(['data' => $data, 'message' => 'success']));   
    }

    
    public function update()
    {
        $data = $this->Users_model->update();
        return $this->output->set_status_header(200)
            ->set_content_type('application/json')
            ->set_output(json_encode(['data' => $data, 'message' => 'success']));   
    }

    public function get()
    {
        $data = $this->Users_model->get_where(['id' => $this->input->post('user_id')]);
        return $this->output->set_status_header(200)
            ->set_content_type('application/json')
            ->set_output(json_encode(['data' => $data, 'message' => 'success']));   
    }

    public function change_password() {
        $id = $this->input->post('id');
        $password = $this->input->post('password');
        $data = $this->Users_model->update(['id' => $id], ['password' => $password]);
        
        return $this->output->set_status_header(200)
        ->set_content_type('application/json')
        ->set_output(json_encode(['data' => $data, 'message' => 'success']));
    }

    public function login() {
        
        $jwt = new JWT();
        $jwtsecreetkey = "mysecreetview";

        $username = $this->input->post('email');
        $password = $this->input->post('password');

        $user = $this->Users_model->get_where(['user_id' => $username, 'password' => $password, 'level' => 'superadmin']);
        
        if ($user)
        {
            $data = array(
                'id' => $user->id,
                'user_id' => $user->user_id,
                'email' => $user->user_id,
                'displayName' => $user->namalengkap,
                'nama' => $user->namalengkap,
                'password' => $user->password,
                'registered' => true,
                'permission' => array('superadmin')
            );
    
            $token = $jwt->encode($data, $jwtsecreetkey, 'HS256');

            $result = array(
                'data' => array(
                    'id' => $user->id,
                    'user_id' => $user->user_id,
                    'email' => $user->user_id,
                    'displayName' => $user->namalengkap,
                    'nama' => $user->namalengkap,
                    'password' => $user->password,
                    'registered' => true,
                    'token' => $token,
                    'permission' => array('superadmin')
                )
            );

            return $this->output->set_status_header(200)
                ->set_content_type('application/json')
                ->set_output(json_encode($result));
        }

        $mahasiswa = $this->Mahasiswa_model->get_where(['nim' => $username, 'password' => $password]);

        if ($mahasiswa)
        {
            $data = array(
                'id' => $mahasiswa->id,
                'user_id' => $mahasiswa->nim,
                'email' => '',
                'displayName' => $mahasiswa->nama,
                'nama' => $mahasiswa->nama,
                'password' => $mahasiswa->password,
                'registered' => true,
                'permission' => array('mahasiswa')
            );
    
            $token = $jwt->encode($data, $jwtsecreetkey, 'HS256');

            $result = array(
                'data' => array(
                    'id' => $mahasiswa->id,
                    'user_id' => $mahasiswa->nim,
                    'email' => '',
                    'displayName' => $mahasiswa->nama,
                    'nama' => $mahasiswa->nama,
                    'password' => $mahasiswa->password,
                    'registered' => true,
                    'token' => $token,
                    'permission' => array('mahasiswa')
                )
            );

            return $this->output->set_status_header(200)
                ->set_content_type('application/json')
                ->set_output(json_encode($result));
        }

        $dosen = $this->ModelDosen->get_where(['nidn' => $username, 'password' => $password]);

        if ($dosen)
        {
            $data = array(
                'id' => $dosen->id,
                'user_id' => $dosen->nidn,
                'email' => '',
                'displayName' => $dosen->nama,
                'nama' => $dosen->nama,
                'password' => $dosen->password,
                'registered' => true,
                'permission' => array('dosen')
            );
    
            $token = $jwt->encode($data, $jwtsecreetkey, 'HS256');

            $result = array(
                'data' => array(
                    'id' => $dosen->id,
                    'user_id' => $dosen->nidn,
                    'email' => '',
                    'displayName' => $dosen->nama,
                    'nama' => $dosen->nama,
                    'password' => $dosen->password,
                    'registered' => true,
                    'token' => $token,
                    'permission' => array('dosen')
                )
            );

            return $this->output->set_status_header(200)
                ->set_content_type('application/json')
                ->set_output(json_encode($result));
        }

        $array_error = array(
            "domain" => "global",
            "message" => "EMAIL_NOT_FOUND",
            "reason" => "invalid"
        );

        $array_reponse = array(
            'error' => array(
                'code' => 400, 'error' => $array_error
            )
        );
                
        return $this->output
            ->set_status_header(400)
            ->set_content_type('application/json')
            ->set_output(json_encode($array_reponse));
    }

    public function decode_token($token) {
        $jwt = new JWT();
        $jwtsecreetkey = "mysecreetview";

        $decode_token = $jwt->decode($token, $jwtsecreetkey, 'HS256');

        $data = $jwt->jsonEncode($decode_token);
        return $this->output->set_status_header(200)
        ->set_content_type('application/json')
        ->set_output(json_encode(['data' => $data, 'message' => 'success']));
    }
}