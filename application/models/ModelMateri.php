<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ModelMateri extends CI_Model {

	var $table = 'berkas';
	
	public function __construct()
	{
		parent::__construct();
	}

	private function _get_query()
	{
		$this->db->select('berkas.*, dosen.nama as nama_dosen, matakul.matakul');
		$this->db->from($this->table);
		
		$this->db->join('dosen', 'dosen.nidn = berkas.nidn');
		$this->db->join('matakul', 'matakul.kode = berkas.kode');
		$this->db->order_by('id', 'DESC');
	}

	function count_filtered()
	{
		$this->_get_query();
		$query = $this->db->get();
		return $query->num_rows();
	}
	
	public function count_all()
	{
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}
	
	public function select()
	{
		$this->_get_query();
		if(isset($_GET['pagination'])) {
			$pagination = json_decode($this->input->get('pagination'));
			$length = $pagination->perPage;
			$start = ($pagination->perPage * $pagination->page) - $pagination->perPage;
			$this->db->limit($length, $start);
		}
		$query = $this->db->get()->result_array();
		return $query;
	}

    public function check_dir($path){
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
            return true;
        }
        return true;
    }

	public function insert_image($foreign) {
		$path = base_url() . '/assets/materi'; 

		$this->check_dir($path);

		$base64imagestring = json_decode($_POST['imagestring']);
		// foreach($base64imagestring as $index => $baseimage) {
            $mime_type =  explode('/', mime_content_type($base64imagestring[0]->src))[1];
			$fileName =  time().'-'.$this->input->post('nama').'.'.$mime_type;

			$base64Image = trim($base64imagestring[0]->src);
			$base64Image = str_replace('data:image/png;base64,', '', $base64Image);
			$base64Image = str_replace('data:image/jpg;base64,', '', $base64Image);
			$base64Image = str_replace('data:image/jpeg;base64,', '', $base64Image);
			$base64Image = str_replace('data:image/gif;base64,', '', $base64Image);
			$base64Image = str_replace('data:application/pdf;base64,', '', $base64Image);
			$base64Image = str_replace('data:application/doc;base64,', '', $base64Image);
			$base64Image = str_replace('data:application/docs;base64,', '', $base64Image);
			$base64Image = str_replace('data:application/xlsx;base64,', '', $base64Image);
			$base64Image = str_replace('data:application/xls;base64,', '', $base64Image);
			$base64Image = str_replace(' ', '+', $base64Image);
		
			$imageData = base64_decode($base64Image);
			$filePath = 'assets/materi/' . $fileName;
		
		   	file_put_contents($filePath, $imageData);
			
			// array_push($returnimage, array(
			// 	'kode' => $foreign,
			// 	'src' => 'assets/images/inventori/' . $fileName
			// ));

		// }
		// $this->db->insert_batch('inventori_image', $returnimage);
		return $filePath;
	}

    public function insert()
    {
		if ($this->input->post('id')) {
            $filepath = $this->input->post('image');
			if ($this->input->post('imagestring') != null && $this->input->post('imagestring') != '') {
				unlink($filepath);
				$filepath = $this->insert_image($this->input->post('nama'));
			}

			$data = array(
				'id' => $this->input->post('id'),
				'nama'	=>$this->input->post('nama',true),
				'berkas' => $filepath,
				'nidn' => $this->input->post('nidn'),
				'kode' => $this->input->post('kode'),
				'tgl' => $this->input->post('tgl'),
			);

			if ($this->db->update($this->table, $data, ['id' => $this->input->post('id')])) {
				return $data;
			} else {
				return null;
			}

		}else {
            $filepath = '';
			if ($this->input->post('imagestring') != null && $this->input->post('imagestring') != '') {
				$filepath = $this->insert_image($this->input->post('kode'));
			}

			$data = array(
				'nama'	=>$this->input->post('nama',true),
				'berkas' => $filepath,
				'nidn' => $this->input->post('nidn'),
				'kode' => $this->input->post('kode'),
				'tgl' => $this->input->post('tgl'),
			);

			$this->db->insert($this->table, $data);
			if ($this->db->insert_id()) {
				return $data = array(
						'id' => $this->db->insert_id(),
						'nama'	=>$this->input->post('nama',true),
        				'berkas' => $filepath,
                        'nidn' => $this->input->post('nidn'),
                        'kode' => $this->input->post('kode'),
                        'tgl' => $this->input->post('tgl'),
					);
			} else {
				return null;
			}

		}
       
    }


	public function delete($id) {
		$data = $this->db->get_where($this->table, ['id' => $id])->row();
		if ($data) {
			unlink($data->berkas);
		}

		$this->db->where('id',  $id);
		return $this->db->delete($this->table);
	}

	public function get_where($array = array())
	{
		return $this->db->get_where($this->table, $array)->row();
	}
}