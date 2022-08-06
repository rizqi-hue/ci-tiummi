<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ModelInventori extends CI_Model {

	var $table = 'inventori';

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
					$this->db->like('nama', $q);
					$this->db->or_like('kode', $q);  // Produces: WHERE name != 'Joe' OR id > 50
					$this->db->or_like('kategori', $q);  // Produces: WHERE name != 'Joe' OR id > 50
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
		$path = base_url() . '/assets/images/inventori'; 

		$this->check_dir($path);

		$base64imagestring = json_decode($_POST['imagestring']);
		// foreach($base64imagestring as $index => $baseimage) {
			$fileName =  time().'-'.$this->input->post('kode').'.jpg';

			$base64Image = trim($base64imagestring[0]->src);
			$base64Image = str_replace('data:image/png;base64,', '', $base64Image);
			$base64Image = str_replace('data:image/jpg;base64,', '', $base64Image);
			$base64Image = str_replace('data:image/jpeg;base64,', '', $base64Image);
			$base64Image = str_replace('data:image/gif;base64,', '', $base64Image);
			$base64Image = str_replace(' ', '+', $base64Image);
		
			$imageData = base64_decode($base64Image);
			$filePath = 'assets/images/inventori/' . $fileName;
		
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
				$filepath = $this->insert_image($this->input->post('kode'));
			}

			$data = array(
				'id' => $this->input->post('id'),
				'no_pb' => $this->input->post('no_pb'),
				'kode' => $this->input->post('kode'),
				'nama' => $this->input->post('nama'),
				'kategori' => $this->input->post('kategori'),
				'harga' => $this->input->post('harga'),
				'qty' => $this->input->post('qty'),
				'sumber' => $this->input->post('sumber'),
				'keterangan' => $this->input->post('keterangan'),
				'tgl' => $this->input->post('tgl'),
				'image' => $filepath
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
				'kode' => $this->input->post('kode'),
				'nama' => $this->input->post('nama'),
				'no_pb' => $this->input->post('no_pb'),
				'kategori' => $this->input->post('kategori'),
				'harga' => $this->input->post('harga'),
				'qty' => $this->input->post('qty'),
				'sumber' => $this->input->post('sumber'),
				'keterangan' => $this->input->post('keterangan'),
				'tgl' => date("Y/m/d"),
				'image' => $filepath
			);

			$this->db->insert($this->table, $data);
			if ($this->db->insert_id()) {
				return $data = array(
						'id' => $this->db->insert_id(),
						'kode' => $this->input->post('kode'),
						'no_pb' => $this->input->post('no_pb'),
						'nama' => $this->input->post('nama'),
						'kategori' => $this->input->post('kategori'),
						'harga' => $this->input->post('harga'),
						'qty' => $this->input->post('qty'),
						'sumber' => $this->input->post('sumber'),
						'keterangan' => $this->input->post('keterangan'),
						'tgl' => date("Y/m/d"),
						'image' => $filepath
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
