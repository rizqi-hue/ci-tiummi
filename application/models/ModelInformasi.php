<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ModelInformasi extends CI_Model {

	var $table = 'informasi';

	public function __construct()
	{
		parent::__construct();
	}

	private function _get_query()
	{
		$this->db->select('*');
		$this->db->from($this->table);

		if (isset($_GET['filter'])) {
			$filter = json_decode($this->input->get('filter'));
			if (isset($filter->q)) {
				$q = $filter->q;
				if ($q != '' || $q != null) {
					$this->db->like('title', $q);
					$this->db->like('type', $q);
					$this->db->or_like('kategori', $q);  // Produces: WHERE name != 'Joe' OR id > 50
				}
			}

			if (isset($filter->type)) {
				$type = $filter->type;
				if ($type != '' || $type != null) {
					$this->db->where('type', $type);  // Produces: WHERE name != 'Joe' OR id > 50
				}
			}
		}

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

	public function select_count_kategori() 
	{
// 		SELECT country,COUNT(*)
// FROM author      
// GROUP BY country;

		$this->db->select('kategori, count(*) as jumlah');
		$this->db->from($this->table);
		$this->db->group_by('kategori');
		return $this->db->get()->result_array();
	}

	public function check_dir($path){
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
            return true;
        }
        return true;
    }

	public function insert_image($foreign) {
		$path = base_url() . '/assets/images/informasi'; 

		$this->check_dir($path);

		$base64imagestring = json_decode($_POST['imagestring']);
		// foreach($base64imagestring as $index => $baseimage) {
			$fileName =  time().'-'.url_title($this->input->post('title')).'.jpg';

			$base64Image = trim($base64imagestring[0]->src);
			$base64Image = str_replace('data:image/png;base64,', '', $base64Image);
			$base64Image = str_replace('data:image/jpg;base64,', '', $base64Image);
			$base64Image = str_replace('data:image/jpeg;base64,', '', $base64Image);
			$base64Image = str_replace('data:image/gif;base64,', '', $base64Image);
			$base64Image = str_replace(' ', '+', $base64Image);
		
			$imageData = base64_decode($base64Image);
			$filePath = 'assets/images/informasi/' . $fileName;
		
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
				$filepath = $this->insert_image($this->input->post('title'));
			}

			$data = array(
				'id' => $this->input->post('id'),
				'title' => $this->input->post('title'),
				'slug' => url_title($this->input->post('title')),
				'content' => $this->input->post('content'),
				'image' => $filepath,
				'kategori' => $this->input->post('kategori'),
				'type' => $this->input->post('type'),
				'user' => $this->input->post('user'),
			);

			if ($this->db->update($this->table, $data, ['id' => $this->input->post('id')])) {
				return $data;
			} else {
				return null;
			}

		} else {

			$filepath = '';
			if ($this->input->post('imagestring') != null && $this->input->post('imagestring') != '') {
				$filepath = $this->insert_image($this->input->post('title'));
			}

			$data = array(
				'title' => $this->input->post('title'),
				'slug' => url_title($this->input->post('title')),
				'content' => $this->input->post('content'),
				'image' => $filepath,
				'kategori' => $this->input->post('kategori'),
				'type' => $this->input->post('type'),
				'user' => $this->input->post('user'),
			);

			$this->db->insert($this->table, $data);
			if ($this->db->insert_id()) {
				return $data = array(
						'id' => $this->db->insert_id(),
						'title' => $this->input->post('title'),
						'slug' => url_title($this->input->post('title')),
						'content' => $this->input->post('content'),
						'image' => $filepath,
						'kategori' => $this->input->post('kategori'),
						'type' => $this->input->post('type'),
						'user' => $this->input->post('user'),
					);
			} else {
				return null;
			}
		}
    }

	public function delete($id) {
		$data = $this->db->get_where($this->table, ['id' => $id])->row();
		if ($data) {
			unlink($data->image);
		}

		$this->db->where('id',  $id);
		return $this->db->delete($this->table);
	}

	public function get_where($array = array())
	{
		return $this->db->get_where($this->table, $array)->row();
	}
}
