<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ModelComplaint extends CI_Model {

	var $table = 'complaint';
	
	public function __construct()
	{
		parent::__construct();
	}

    public function select() {
        return $this->db->get_where($this->table, ['nim' => $this->input->post('nim', true)])->result();
    }

	public function select_admin() {
        // $num_row = $this->db->get($this->table)->num_rows();

		// $config['base_url'] =  base_url() . 'complaint/page/';
		// $config['total_rows'] = $num_row;
		// $config['per_page'] = 2;

		// $this->pagination->initialize($config);
		// // return $this->pagination->create_links();
        return $this->db->get($this->table)->result();
    }

	public function getWhere($array) {
        return $this->db->get_where($this->table, $array)->row();
    }

    public function insert()
    {
        return $this->db->insert($this->table,array(
			'nim'	=>$this->input->post('nim',true),
			'nama'	=>$this->input->post('nama',true),
			'email'	=> '-',
			'hp'	=> '-',
			'subject'=>$this->input->post('subject',true),
			'pesan'	=>$this->input->post('message',true),
			'tgl'	=>date("Y-m-d")
		));
    }

	public function delete() {
		$id = $this->input->post('id', true);

		$this->db->where('id', $id);
		return $this->db->delete($this->table);
	}
}