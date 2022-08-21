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
		$this->API = "http://siak.ummi.ac.id/api/index.php/";
		$this->load->library('rest');

	}

    function rest_config($server){
		// $config =  array(
		// 	'server' => $this->API.'/'.$server,
		// 	'api_name' => 'SIAK-API-KEY',
		// 	'api_key' => 'SILATY5u0v7ZqFYUrFKaOPIbrSBlNHuaGk8Hp',
		// 	'http_user' => 'silat-ti',
		// 	'http_pass' => 'SILATY5u0v7ZqFYUrFKaOPIbrSBlNHuaGk8Hp',
		// 	'http_auth' => 'digest'
		// );

        $config =  array(
			'server' => $this->API.'/'.$server,
			'api_name' => 'SIAK-API-KEY',
			'api_key' => 'WEBMAIL147b3597yd08678af167e9b1455',
			'http_user' => 'mail@ummi.ac.id',
			'http_pass' => '3m41lTea',
			'http_auth' => 'digest'
		);

		return $this->rest->initialize($config);
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

    public function cek_login_admin() {
        
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

    public function cek_login_mahasiswa(){
        $jwt = new JWT();
        $jwtsecreetkey = "mysecreetview";

        $username = $this->input->post('email');
        $password = $this->input->post('password');
        
        $this->rest_config('mahasiswa/login');

		$data = array(
			'nim'   => $username,
			'password'    => $password
		);

		$mahasiswa = $this->rest->get('mahasiswa', $data, 'json');

        if (isset($mahasiswa->message)) {

            $array_reponse = array(
                'error' => array(
                    'code' => 400, 'error' => $mahasiswa->message
                )
            );
                    
            return $this->output
                ->set_status_header(400)
                ->set_content_type('application/json')
                ->set_output(json_encode($array_reponse));

        } else if (isset($mahasiswa->error)) {

            $array_reponse = array(
                'error' => array(
                    'code' => 400, 'error' => $mahasiswa->error
                )
            );
                    
            return $this->output
                ->set_status_header(400)
                ->set_content_type('application/json')
                ->set_output(json_encode($array_reponse));

        } else if ($mahasiswa === NULL) {
        
            $array_reponse = array(
                'error' => array(
                    'code' => 400, 'error' => 'Terjadi kesalahan'
                )
            );
                    
            return $this->output
                ->set_status_header(400)
                ->set_content_type('application/json')
                ->set_output(json_encode($array_reponse));

		} else {

			foreach ($mahasiswa as $dsn) {
			    $cek_data = $this->db->get_where('mahasiswa', array('nim' => $dsn->nim_mahasiswa ));
                
                $data = array(
                    'nim' 	=> $dsn->nim_mahasiswa,
                    'nama'  => $dsn->nama_lengkap,
                    'jk'  => $dsn->jk,
                    'email' => $dsn->email_mhs,
                    'tgllahir' => $dsn->tanggal_lahir,
                    'jurusan' => $dsn->nama_prodi,
                    'alamat' => $dsn->alamat_rumah,
                    'telp'  => $dsn->hp_pribadi,
                    'tahun_masuk'  => $dsn->tahun_masuk,
                );

			    if ($cek_data->num_rows() <= 0) {
			        $this->db->insert('mahasiswa', $data);
                } else {
                    $this->db->update('mahasiswa', $data, ['nim' => $dsn->nim_mahasiswa]);
                }

			    $user = $this->db->get_where('mahasiswa', array('nim' => $dsn->nim_mahasiswa ))->row();

                $data = array(
                    'id' => $user->id,
                    'user_id' => $user->nim,
                    'email' => $user->email,
                    'displayName' => $user->nama,
                    'nama' => $user->nama,
                    'registered' => true,
                    'permission' => array('mahasiswa')
                );
        
                $token = $jwt->encode($data, $jwtsecreetkey, 'HS256');
    
                $result = array(
                    'data' => array(
                        'id' => $user->id,
                        'user_id' => $user->nim,
                        'email' => '',
                        'displayName' => $user->nama,
                        'nama' => $user->nama,
                        'registered' => true,
                        'token' => $token,
                        'permission' => array('mahasiswa')
                    )
                );
    
                return $this->output->set_status_header(200)
                    ->set_content_type('application/json')
                    ->set_output(json_encode($result));

            }

        }	
	}

    public function cek_login_dosen() {

        $jwt = new JWT();
        $jwtsecreetkey = "mysecreetview";

        $username = $this->input->post('email');
        $password = $this->input->post('password');
        
        $this->rest_config('dosen/login');

        $data = array(
            'kode_dosen'   => $username,
            'password'    => $password
        );
        // cek ke server
        $dosen = $this->rest->get('dosen',$data, 'json');

        if (isset($dosen->message)) {

            $array_reponse = array(
                'error' => array(
                    'code' => 400, 'error' => $dosen->message
                )
            );
                    
            return $this->output
                ->set_status_header(400)
                ->set_content_type('application/json')
                ->set_output(json_encode($array_reponse));

        } else if (isset($dosen->error)) {

            $array_reponse = array(
                'error' => array(
                    'code' => 400, 'error' => $dosen->error
                )
            );
                    
            return $this->output
                ->set_status_header(400)
                ->set_content_type('application/json')
                ->set_output(json_encode($array_reponse));

        } else if ($dosen === NULL) {
        
            $array_reponse = array(
                'error' => array(
                    'code' => 400, 'error' => 'Terjadi kesalahan'
                )
            );
                    
            return $this->output
                ->set_status_header(400)
                ->set_content_type('application/json')
                ->set_output(json_encode($array_reponse));

		} else {

			foreach ($dosen as $dsn) {

			    $cek_data = $this->db->get_where('dosen', array('kode_dosen' => $dsn->kode_dosen ));
                
                $data = array(
                    'nidn' 	        => $dsn->nidn,
                    'kode_dosen' 	=> $dsn->kode_dosen,
                    'nama'          => $dsn->gelar_depan . ' ' . $dsn->nama_dosen . ' ' . $dsn->gelar_belakang,
                    'jk'            => $dsn->jenis_kelamin == 1 ? 'L' : 'P' ,
                    'email'         => $dsn->email,
                    'tlahir'        => $dsn->tempat_lahir,
                    'tgllahir'      => $dsn->tgl_lahir,
                    'alamat'        => $dsn->alamat,
                    'telp'          => $dsn->telp,
                );

			    if ($cek_data->num_rows() <= 0) {
			        $this->db->insert('dosen', $data);
                } else {
                    $this->db->update('dosen', $data, ['kode_dosen' => $dsn->kode_dosen]);
                }

			    $user = $this->db->get_where('dosen', array('kode_dosen' => $dsn->kode_dosen ))->row();

                $data = array(
                    'id' => $user->id,
                    'user_id' => $user->nidn,
                    'email' => $user->email,
                    'displayName' => $user->nama,
                    'nama' => $user->nama,
                    'registered' => true,
                    'permission' => array('dosen')
                );
        
                $token = $jwt->encode($data, $jwtsecreetkey, 'HS256');
    
                $result = array(
                    'data' => array(
                        'id' => $user->id,
                        'user_id' => $user->nidn,
                        'email' => '',
                        'displayName' => $user->nama,
                        'nama' => $user->nama,
                        'registered' => true,
                        'token' => $token,
                        'permission' => array('dosen')
                    )
                );
    
                return $this->output->set_status_header(200)
                    ->set_content_type('application/json')
                    ->set_output(json_encode($result));
            }

        }	
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