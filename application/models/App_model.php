<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class App_Model extends CI_Model {

	/**
	
	 * @keterangan : Model untuk menangani semua query database aplikasi
	 **/
	
	public function getAllData($table)
	{
		return $this->db->get($table);
	}
	
	public function getAllDataLimited($table,$limit,$offset)
	{
		return $this->db->get($table, $limit, $offset);
	}
	
	public function getSelectedDataLimited($table,$data,$limit,$offset)
	{
		return $this->db->get_where($table, $data, $limit, $offset);
	}	
	//select table
	public function getSelectedData($table,$data)
	{
		return $this->db->get_where($table, $data);
	}
	//update table
	function updateData($table,$data,$field_key)
	{
		$this->db->update($table,$data,$field_key);
	}
	function deleteData($table,$data)
	{
		$this->db->delete($table,$data);
	}
	
	function insertData($table,$data)
	{
		$this->db->insert($table,$data);
	}
	//Query manual
	function manualQuery($q)
	{
		return $this->db->query($q);
	}
	
	//Konversi tanggal------------------------------
	public function tgl_sql($date){
		$exp = explode('-',$date);
		if(count($exp) == 3) {
			$date = $exp[2].'-'.$exp[1].'-'.$exp[0];
		}
		return $date;
	}
	public function tgl_sql2($date){
		$exp = explode('/',$date);
		if(count($exp) == 3) {
			$date = $exp[2].'-'.$exp[0].'-'.$exp[1];
		}
		return $date;
	}
	public function tgl_str($date){
		$exp = explode('-',$date);
		if(count($exp) == 3) {
			$date = $exp[2].'-'.$exp[1].'-'.$exp[0];
		}
		return $date;
	}
	public function tgl_str2($date){
		$exp = explode('-',$date);
		if(count($exp) == 3) {
			$date = $exp[2].'/'.$exp[1].'/'.$exp[0];
		}
		return $date;
	}
	
	
	/* Tanggal dan Jam */
	public function Jam_Now(){
		date_default_timezone_set("Asia/Jakarta");
   		$jam = date("H:i:s"); 
   		
		return $jam;
		//echo "$jam WIB";
	}
	
	public function Hari_Bulan_Indo(){
		date_default_timezone_set('Asia/Jakarta'); // PHP 6 mengharuskan penyebutan timezone.
		$seminggu = array("Minggu","Senin","Selasa","Rabu","Kamis","Jum"."'"."at","Sabtu");
		$hari = date("w");
		$hari_ini = $seminggu[$hari];
		
		return $hari_ini;
	}
	
	public function cari_hari($tgl_lahir)
	{
		$query="SELECT datediff('$tgl_lahir', CURDATE()) as selisih";
		$hasil=mysql_query($query);
	
		$data=mysql_fetch_array($hasil);
		$selisih=$data['selisih'];
		$x=mktime(0,0,0, date("m"),date("d")+$selisih,date("Y"));
		$namahari=date("w",$x);
		
		date_default_timezone_set('Asia/Jakarta'); // PHP 6 mengharuskan penyebutan timezone.
		$seminggu = array("Minggu","Senin","Selasa","Rabu","Kamis","Jum\'at","Sabtu");
		//$hari = date("w");
		$hari_ini = $seminggu[$namahari];
		
		return $hari_ini;
		
	}
	public function tgl_now_indo(){
			date_default_timezone_set('Asia/Jakarta'); // PHP 6 mengharuskan penyebutan timezone.
			$tgl = date("Y m d");
			$tanggal = substr($tgl,8,2);
			$bulan = $this->app_model->getBulan(substr($tgl,5,2));
			$tahun = substr($tgl,0,4);
			return $tanggal.' '.$bulan.' '.$tahun;		 
	}
	public function tgl_indo($tgl){
			date_default_timezone_set('Asia/Jakarta'); // PHP 6 mengharuskan penyebutan timezone.
			//$tgl = date("Y m d");
			$tanggal = substr($tgl,8,2);
			$bulan = $this->app_model->getBulan(substr($tgl,5,2));
			$tahun = substr($tgl,0,4);
			return $tanggal.' '.$bulan.' '.$tahun;		 
	}
	function buangspasi($teks){
		$teks= trim($teks);
		while( strpos($teks, '%') ){
		$hasil= str_replace('%', '', $teks);
		}
		return $teks;
	}
	
	public function getBulan($bln){
		switch ($bln){
			case 1: 
				return "Januari";
				break;
			case 2:
				return "Februari";
				break;
			case 3:
				return "Maret";
				break;
			case 4:
				return "April";
				break;
			case 5:
				return "Mei";
				break;
			case 6:
				return "Juni";
				break;
			case 7:
				return "Juli";
				break;
			case 8:
				return "Agustus";
				break;
			case 9:
				return "September";
				break;
			case 10:
				return "Oktober";
				break;
			case 11:
				return "November";
				break;
			case 12:
				return "Desember";
				break;
		}
	} 
	public function getLoginData($usr,$psw)
	{
		// $link=mysqli_connect();
		// include'./application/models/inc.php';
		
		// $u=mysqli_real_escape_string($link, $usr);
		// // $u =mysqli_real_escape_string($db,$usr);
		// $p = mysqli_real_escape_string($link,$psw);

		$q_cek_login = $this->db->get_where('users', array('user_id' => $usr, 'password' => $psw));
		// echo json_encode($q_cek_login->result());
		if(count($q_cek_login->result())>0)
		{
			foreach($q_cek_login->result() as $qck)
			{
					foreach($q_cek_login->result() as $qad){
						if($qad->level=="super admin"){
							$sess_data['logged_in'] = 'yesGetMeLogin';
							$sess_data['username'] = $qad->user_id;
							$sess_data['nama_pengguna'] = $qad->namalengkap;
							$sess_data['level'] = 'admin';
							$sess_data['logdate'] = date("Y-m-d H:i:s");
							$this->session->set_userdata($sess_data);
							header('location:'.base_url().'cadmin/media');
							//$this->load->cont('content');	
						}elseif($qad->level=="admin"){
							$sess_data['logged_in'] = 'yesGetMeLogin';
							$sess_data['username'] = $qad->user_id;
							$sess_data['nama_pengguna'] = $qad->namalengkap;
							$sess_data['level'] = 'admin';
							$sess_data['logdate'] = date("Y-m-d H:i:s");
							$this->session->set_userdata($sess_data);
							header('location:'.base_url().'cadmin/media');
							//$this->load->cont('content');	
						}elseif($qad->level=="mhs"){
							$sess_data['logged_in'] = 'yesGetMeLoginMhs';
							$sess_data['username'] = $qad->user_id;
							$sess_data['nama_pengguna'] = $qad->namalengkap;
							$sess_data['level'] = 'mhs';
							$sess_data['nim'] = $qad->nim;
							$this->session->set_userdata($sess_data);
							header('location:'.base_url().'cadmin/media');
						}elseif($qad->level=="dosen"){
							$sess_data['logged_in'] = 'yesGetMeLoginDosen';
							$sess_data['username'] = $qad->user_id;
							$sess_data['nama_pengguna'] = $qad->namalengkap;
							$sess_data['level'] = 'dosen';
							$sess_data['nim'] = $qad->nim;
							$this->session->set_userdata($sess_data);
							header('location:'.base_url().'cadmin/media');
						}
						
					}
			}
		}else{
			
			$this->session->set_flashdata('result_login', '<font color="red">Username atau Password yang anda masukkan salah.</font>');
				//header('location:'.base_url());
				redirect('/person/login_view','refresh');
		}
		
	}
	/*fungsi terbilang*/
	public function bilang($x) {
		$x = abs($x);
		$angka = array("", "satu", "dua", "tiga", "empat", "lima",
		"enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
		$result = "";
		if ($x <12) {
			$result = " ". $angka[$x];
		} else if ($x <20) {
			$result = $this->app_model->bilang($x - 10). " belas";
		} else if ($x <100) {
			$result = $this->app_model->bilang($x/10)." puluh". $this->app_model->bilang($x % 10);
		} else if ($x <200) {
			$result = " seratus" . $this->app_model->bilang($x - 100);
		} else if ($x <1000) {
			$result = $this->app_model->bilang($x/100) . " ratus" . $this->app_model->bilang($x % 100);
		} else if ($x <2000) {
			$result = " seribu" . $this->app_model->bilang($x - 1000);
		} else if ($x <1000000) {
			$result = $this->app_model->bilang($x/1000) . " ribu" . $this->app_model->bilang($x % 1000);
		} else if ($x <1000000000) {
			$result = $this->app_model->bilang($x/1000000) . " juta" . $this->app_model->bilang($x % 1000000);
		} else if ($x <1000000000000) {
			$result = $this->app_model->bilang($x/1000000000) . " milyar" . $this->app_model->bilang(fmod($x,1000000000));
		} else if ($x <1000000000000000) {
			$result = $this->app_model->bilang($x/1000000000000) . " trilyun" . $this->app_model->bilang(fmod($x,1000000000000));
		}      
			return $result;
	}
	public function terbilang($x, $style=4) {
		if($x<0) {
			$hasil = "minus ". trim($this->app_model->bilang($x));
		} else {
			$hasil = trim($this->app_model->bilang($x));
		}      
		switch ($style) {
			case 1:
				$hasil = strtoupper($hasil);
				break;
			case 2:
				$hasil = strtolower($hasil);
				break;
			case 3:
				$hasil = ucwords($hasil);
				break;
			default:
				$hasil = ucfirst($hasil);
				break;
		}      
		return $hasil;
	}
	
	
public function money_format($format, $number)
{
    $regex  = '/%((?:[\^!\-]|\+|\(|\=.)*)([0-9]+)?'.
              '(?:#([0-9]+))?(?:\.([0-9]+))?([in%])/';
    if (setlocale(LC_MONETARY, 0) == 'C') {
        setlocale(LC_MONETARY, '');
    }
    $locale = localeconv();
    preg_match_all($regex, $format, $matches, PREG_SET_ORDER);
    foreach ($matches as $fmatch) {
        $value = floatval($number);
        $flags = array(
            'fillchar'  => preg_match('/\=(.)/', $fmatch[1], $match) ?
                           $match[1] : ' ',
            'nogroup'   => preg_match('/\^/', $fmatch[1]) > 0,
            'usesignal' => preg_match('/\+|\(/', $fmatch[1], $match) ?
                           $match[0] : '+',
            'nosimbol'  => preg_match('/\!/', $fmatch[1]) > 0,
            'isleft'    => preg_match('/\-/', $fmatch[1]) > 0
        );
        $width      = trim($fmatch[2]) ? (int)$fmatch[2] : 0;
        $left       = trim($fmatch[3]) ? (int)$fmatch[3] : 0;
        $right      = trim($fmatch[4]) ? (int)$fmatch[4] : $locale['int_frac_digits'];
        $conversion = $fmatch[5];

        $positive = true;
        if ($value < 0) {
            $positive = false;
            $value  *= -1;
        }
        $letter = $positive ? 'p' : 'n';

        $prefix = $suffix = $cprefix = $csuffix = $signal = '';

        $signal = $positive ? $locale['positive_sign'] : $locale['negative_sign'];
        switch (true) {
            case $locale["{$letter}_sign_posn"] == 1 && $flags['usesignal'] == '+':
                $prefix = $signal;
                break;
            case $locale["{$letter}_sign_posn"] == 2 && $flags['usesignal'] == '+':
                $suffix = $signal;
                break;
            case $locale["{$letter}_sign_posn"] == 3 && $flags['usesignal'] == '+':
                $cprefix = $signal;
                break;
            case $locale["{$letter}_sign_posn"] == 4 && $flags['usesignal'] == '+':
                $csuffix = $signal;
                break;
            case $flags['usesignal'] == '(':
            case $locale["{$letter}_sign_posn"] == 0:
                $prefix = '(';
                $suffix = ')';
                break;
        }
        if (!$flags['nosimbol']) {
            $currency = $cprefix .
                        ($conversion == 'i' ? $locale['int_curr_symbol'] : $locale['currency_symbol']) .
                        $csuffix;
        } else {
            $currency = 'Rp';
        }
        $space  = $locale["{$letter}_sep_by_space"] ? ' ' : '';

        $value = number_format($value, $right, $locale['mon_decimal_point'],
                 $flags['nogroup'] ? '' : $locale['mon_thousands_sep']);
        $value = @explode($locale['mon_decimal_point'], $value);

        $n = strlen($prefix) + strlen($currency) + strlen($value[0]);
        if ($left > 0 && $left > $n) {
            $value[0] = str_repeat($flags['fillchar'], $left - $n) . $value[0];
        }
        $value = implode($locale['mon_decimal_point'], $value);
        if ($locale["{$letter}_cs_precedes"]) {
            $value = $prefix . $currency . $space . $value . $suffix;
        } else {
            $value = $prefix . $value . $space . $currency . $suffix;
        }
        if ($width > 0) {
            $value = str_pad($value, $width, $flags['fillchar'], $flags['isleft'] ?
                     STR_PAD_RIGHT : STR_PAD_LEFT);
        }

        $format = str_replace($fmatch[0], $value, $format);
    }
    return $format;
}

	public function find_menu($id){
		$q = $this->db->query("select *
			from menu
			WHERE id='$id'
			ORDER BY id ASC LIMIT 1");
		if($q->num_rows()>0){
			foreach($q->result() as $k){
				$hasil = $k->menu;
			}
		}else{
			$hasil = 0;
		}
		return $hasil;
	}
	public function find_sumber($id)
	{
		if($id=="1"){
			$com="Prodi TI";
		}else{
			$com="Bag Umum";
		}
		return $com;
	}
	public function find_nama_admin($id){
		$q = $this->db->query("select *
			from users
			WHERE user_id='$id'
			ORDER BY user_id ASC LIMIT 1");
		if($q->num_rows()>0){
			foreach($q->result() as $k){
				$hasil = $k->namalengkap;
			}
		}else{
			$hasil = 0;
		}
		return $hasil;
	}
	public function find_ttd_dosen($kelas,$smt,$thpel,$matakul){
		$q = $this->db->query("select nidn
			from jadwal
			WHERE kelas_kode='$kelas' 
			and smt like '$smt'
			and matakul_kode = '$matakul'
			");
		if($q->num_rows()>0){
			foreach($q->result() as $k){
				$nama = $k->nidn;
				$hasil=$this->app_model->find_dosen($nama);
			}
		}else{
			$hasil = "___________________";
		}
		return $hasil;
	}
	public function find_jk($id){
		$q = $this->db->query("select *
			from mahasiswa
			WHERE nim='$id'
			ORDER BY nim ASC LIMIT 1");
		if($q->num_rows()>0){
			foreach($q->result() as $k){
				$hasil = $k->jk;
			}
		}else{
			$hasil = 0;
		}
		return $hasil;
	}
	public function find_jml_temu($id){
		$q = $this->db->query("select *
			from matakul
			WHERE kode='$id'
			ORDER BY kode ASC LIMIT 1");
		if($q->num_rows()>0){
			foreach($q->result() as $k){
				$hasil = $k->temu;
			}
		}else{
			$hasil = 0;
		}
		return $hasil;
	}
	public function find_nama($id){
		$q = $this->db->query("select *
			from mahasiswa
			WHERE nim='$id'
			ORDER BY nim ASC LIMIT 1");
		if($q->num_rows()>0){
			foreach($q->result() as $k){
				$hasil = $k->nama;
			}
		}else{
			$hasil = 0;
		}
		return $hasil;
	}
	public function find_nidn($id){
		$q = $this->db->query("select *
			from users
			WHERE user_id='$id'
			ORDER BY nim ASC LIMIT 1");
		if($q->num_rows()>0){
			foreach($q->result() as $k){
				$hasil = $k->nim;
			}
		}else{
			$hasil = "";
		}
		return $hasil;
	}
	public function find_nohp($id){
		$q = $this->db->query("select *
			from mahasiswa
			WHERE nim='$id'
			ORDER BY nim ASC LIMIT 1");
		if($q->num_rows()>0){
			foreach($q->result() as $k){
				$hasil = $k->telp;
			}
		}else{
			$hasil = 0;
		}
		return $hasil;
	}
	public function find_nohp_ortu($id){
		$q = $this->db->query("select *
			from mahasiswa
			WHERE nim='$id'
			ORDER BY nim ASC LIMIT 1");
		if($q->num_rows()>0){
			foreach($q->result() as $k){
				$hasil = $k->telp_ortu;
			}
		}else{
			$hasil = 0;
		}
		return $hasil;
	}
	public function jml_complaint($id){
		$q = $this->db->query("select count(id) as jml from complaint
			WHERE buka='0'
			");
		if($q->num_rows()>0){
			foreach($q->result() as $k){
				$hasil = $k->jml;
			}
		}else{
			$hasil = 0;
		}
		if($id=="admin"){
			return $hasil;
		}else{
			return 0;
		}
	}
	public function get_users($id)
	{
		$this->db->limit(1);
		$this->db->from('users');
		$this->db->where('user_id',$id);
		
		$query = $this->db->get();
		return $query->result();
	}
	public function get_kelas()
	{
		$this->db->order_by('kode','ASC');
		$this->db->from('kelas');
		$query = $this->db->get();
		return $query->result();
	}
	public function hadir($id)
	{
		if($id=="1"){
			$hasil="Hadir";
		}elseif($id=="2"){
			$hasil="Sakit";
		}elseif($id=="3"){
			$hasil="Izin";
		}elseif($id=="4"){
			$hasil="Alpa";
		}
		return $hasil;
	}
	
	public function jk($id)
	{
		if($id=="L"){
			$hasil="Laki-laki";
		}else{
			$hasil="Perempuan";
		}
		return $hasil;
	}
	public function get_jurusan()
	{
		$this->db->select('*');
		$this->db->from('jurusan');
		$this->db->order_by('id','asc');
		// $this->db->where('user_id',$id);
		
		$query = $this->db->get();
		return $query->result();
	}
	function upload_add(){
		if(isset($_POST['upload'])){
			if ($_FILES['input-file-preview']['error'] <> 4) {

	            $config['upload_path'] = './assets/upload';
	            $config['allowed_types'] = 'jpg|png|gif|bmp|zip|doc|xls|docx|xlsx|ppt|pptx|rar|pdf';
	            $this->load->library('upload', $config);
				$this->upload->set_allowed_types('*');
	            if (!$this->upload->do_upload('input-file-preview')) {
	                $error = array('error' => $this->upload->display_errors());
	                $this->index($error);
	            } else {
	                $hasil 	= $this->upload->data();
					$data = array(
						'foto'	=> $hasil['file_name']);
					$this->db->where('user_id',$this->input->post('user_id',true));
					$this->db->update('users',$data);
					redirect('cadmin/home/profile');
		        }
	        } else {
				redirect('cadmin/home/profile/err');
	        }
		}
	}
	function add_complaint(){
		date_default_timezone_set('Asia/Jakarta'); // PHP 6 mengharuskan penyebutan timezone.
		return $this->db->insert('complaint',array(
			'nim'	=>$this->input->post('nim',true),
			'nama'	=>$this->input->post('nama',true),
			'email'	=>$this->input->post('email',true),
			'hp'	=>$this->input->post('hp',true),
			'subject'=>$this->input->post('subject',true),
			'pesan'	=>$this->input->post('pesan',true),
			'tgl'	=>date("Y-m-d")
		));
	}
	function upload_dokumen(){
		if(isset($_POST['upload'])){
			if ($_FILES['input-file-preview']['error'] <> 4) {

	            $config['upload_path'] = './assets/upload';
	            $config['allowed_types'] = 'jpg|png|gif|bmp|zip|doc|xls|docx|xlsx|ppt|pptx|rar|pdf';
	            $this->load->library('upload', $config);
				$this->upload->set_allowed_types('*');
				date_default_timezone_set('Asia/Jakarta'); // PHP 6 mengharuskan penyebutan timezone.
	            if (!$this->upload->do_upload('input-file-preview')) {
	                $error = array('error' => $this->upload->display_errors());
	                $this->index($error);
	            } else {
	                $hasil 	= $this->upload->data();
					$data = array(
						'berkas'	=> $hasil['file_name'],
						'nama'		=> $this->input->post('judul',true),
						'nidn'		=> $this->input->post('nidn',true),
						'kodemk'	=> $this->input->post('kodemk',true),
						'tgl'		=>date("Y-m-d")
						);
					$this->db->insert('berkas',$data);
					redirect('cadmin/home/upload');
		        }
	        } else {
				redirect('cadmin/home/upload/err');
	        }
		}
	}
	public function nidn_auto(){
	$keyword=$this->input->post('query',true);
	
	$q = $this->db->query("SELECT * FROM dosen WHERE nidn LIKE '%$keyword%'");
		if($q->num_rows()>0){
			foreach($q->result() as $k){
				$Result[] = $k->nidn;
			}
			return ($Result);
		}
	}
	public function find_jml_mhs(){
		$q = $this->db->query("select count(nim) as jml
			from mahasiswa
			");
		if($q->num_rows()>0){
			foreach($q->result() as $k){
				$hasil = $k->jml;
			}
		}else{
			$hasil = 0;
		}
		return $hasil;
	}
	public function find_qty($id){
		$q = $this->db->query("select SUM(qty) as jml
			from adjust_inv where inv_kode='$id'
			");
		if($q->num_rows()>0){
			foreach($q->result() as $k){
				$hasil = $k->jml;
			}
		}else{
			$hasil = 0;
		}
		return $hasil;
	}
	public function find_jml_inv(){
		$q = $this->db->query("select count(kode) as jml
			from inventori
			");
		if($q->num_rows()>0){
			foreach($q->result() as $k){
				$hasil = $k->jml;
			}
		}else{
			$hasil = 0;
		}
		return $hasil;
	}
	public function find_jml_kelas(){
		$q = $this->db->query("select count(kode) as jml
			from kelas
			");
		if($q->num_rows()>0){
			foreach($q->result() as $k){
				$hasil = $k->jml;
			}
		}else{
			$hasil = 0;
		}
		return $hasil;
	}
	public function find_jml_users(){
		$q = $this->db->query("select count(user_id) as jml
			from users
			");
		if($q->num_rows()>0){
			foreach($q->result() as $k){
				$hasil = $k->jml;
			}
		}else{
			$hasil = 0;
		}
		return $hasil;
	}
	public function find_jml_dosen(){
		$q = $this->db->query("select count(nidn) as jml
			from dosen
			");
		if($q->num_rows()>0){
			foreach($q->result() as $k){
				$hasil = $k->jml;
			}
		}else{
			$hasil = 0;
		}
		return $hasil;
	}
	public function find_cart_pinjam(){
		$q = $this->db->query("select count(kode) as jml
			from temp_pinjam
			");
		if($q->num_rows()>0){
			foreach($q->result() as $k){
				$hasil = $k->jml;
			}
		}else{
			$hasil = 0;
		}
		return $hasil;
	}
	public function get_temp_pinjam($id)
	{
		$this->db->select('*');
		$this->db->from('temp_pinjam');
		$this->db->where('user_id',$id);
		
		$query = $this->db->get();
		return $query->result();
	}
	public function get_complaint($id)
	{
		
		$this->db->select('*');
		$this->db->from('complaint');
		$this->db->where('buka','0');
		$this->db->order_by('id','desc');
		if($id=="dosen" || $id=="mhs"){
		$this->db->where('buka','2');
		}else{
		$this->db->limit(0,10);
		}
		$query = $this->db->get();
		return $query->result();
	}
	
	//----start complaint ----------------------------
	
	var $column_order_com = array('id','nama','pesan','tgl'); 
	var $column_search_com = array('id','nama','pesan','tgl'); 
	var $order = array('id' => 'desc'); 
	private function _get_datatables_query_complaint()
	{
		
		$this->db->from('complaint');
		$i = 0;
		foreach ($this->column_search_com as $item) // loop column 
		{
			if($_POST['search']['value']) // if datatable send POST for search
			{
				
				if($i===0) // first loop
				{
					$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$this->db->like($item, $_POST['search']['value']);
				}
				else
				{
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if(count($this->column_search_com) - 1 == $i) //last loop
					$this->db->group_end(); //close bracket
			}
			$i++;
		}
		
		if(isset($_POST['order'])) // here order processing
		{
			$this->db->order_by($this->column_order_com[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->order))
		{
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}
	function get_datatables_complaint()
	{
		$this->_get_datatables_query_complaint();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}
	function count_filtered_complaint()
	{
		$this->_get_datatables_query_complaint();
		$query = $this->db->get();
		return $query->num_rows();
	}
	public function count_all_complaint()
	{
		$this->db->from('complaint');
		return $this->db->count_all_results();
	}
	
	//end complaint ---------------------------
	
	public function get_ci_sesi($id)
	{
		$this->db->select('*');
		$this->db->from('ci_sessions');
		$this->db->where('session_id',$id);
		$query = $this->db->get();
		return $query->result();
	}
	public function GetID_temp_pinjam()
	{
		$q = $this->db->query("select MAX(id) as ID from temp_pinjam");
		$kd="";
		if($q->num_rows()>0)
		{
			foreach($q->result() as $k)
			{
				$kode = $k->ID; //substr($k->ID,0,1);
				$tmp = ((int)$kode)+1;
				$kd = sprintf("%05s", $tmp);
			}
		}
		else
		{
			$kd = "00001";
		}	
		return $kd;
	}
	public function GetID_pinjam_h()
	{
		$id=date("Ym");
		$q = $this->db->query("select MAX(substr(id,7,11)) as ID from pinjam_h");
		$kd="";
		if($q->num_rows()>0)
		{
			foreach($q->result() as $k)
			{
				$kode = $k->ID; //substr($k->ID,0,1);
				$tmp = ((int)$kode)+1;
				$kd = $id.sprintf("%05s", $tmp);
			}
		}
		else
		{
			$kd = $id."00001";
		}	
		return $kd;
	}
	public function GetID_pinjam_d()
	{
		// $id=date("Ym");
		$q = $this->db->query("select MAX(id) as ID from pinjam_d");
		$kd="";
		if($q->num_rows()>0)
		{
			foreach($q->result() as $k)
			{
				$kode = $k->ID; //substr($k->ID,0,1);
				$tmp = ((int)$kode)+1;
				$kd = sprintf("%05s", $tmp);
			}
		}
		else
		{
			$kd = "00001";
		}	
		return $kd;
	}
	public function get_berkas($id)
	{
		if($id!=""){
			$this->db->where('nidn',$id);
		}
		$this->db->select('*');
		$this->db->from('berkas');
		// $this->db->where('user_id',$id);
		$this->db->order_by('id','DESC');
		$query = $this->db->get();
		return $query->result();
	}
	public function get_berkas_download($nidn,$kodemk)
	{
		$level=$this->session->userdata('level');
		if($level=="admin" || $level=="dosen"){
							
			if($nidn!="" and $kodemk==""){
				$this->db->where('nidn',$nidn);
				$this->db->group_by('kodemk');
			}elseif($kodemk!=""){
				$this->db->where('nidn',$nidn);
				$this->db->where('kodemk',$kodemk);
			}elseif($nidn!=""){
				$this->db->where('nidn',$nidn);
			}
			else{
			$this->db->group_by('nidn');
			}
		}else{
			$nidn=$this->uri->segment(4);
			$kodemk=$this->uri->segment(5);
			if($nidn!="" and $kodemk==""){
				$this->db->where('nidn',$nidn);
				$this->db->group_by('kodemk');
			}elseif($kodemk!=""){
				$this->db->where('nidn',$nidn);
				$this->db->where('kodemk',$kodemk);
			}elseif($nidn!=""){
				$this->db->where('nidn',$nidn);
			}
			else{
			$this->db->group_by('nidn');
			}
		}
		$this->db->select('*');
		$this->db->from('berkas');
		// $this->db->where('user_id',$id);
		$this->db->order_by('id','DESC');
		$query = $this->db->get();
		return $query->result();
	}
	public function get_berkas_id($id)
	{
		$q = $this->db->query("select * from berkas
			WHERE id='$id'
			group by id");
		if($q->num_rows()>0){
			foreach($q->result() as $k){
				$hasil = $k->berkas;
			}
		}else{
			$hasil = 0;
		}
		return $hasil;
	}
	public function find_jml_dok($nidn,$kodemk)
	{
		
		if($nidn=="" and $kodemk==""){
			 $q = $this->db->query("select COUNT(id) as jml from berkas where nidn='$nidn'");
			
		}elseif($nidn!="" and $kodemk!="" ){
			$q = $this->db->query("select COUNT(id) as jml from berkas where nidn='$nidn' and kodemk='$kodemk' ");
		}
		else{
			$q = $this->db->query("select COUNT(id) as jml from berkas where nidn='$nidn'");
		}
		
		if($q->num_rows()>0){
			foreach($q->result() as $k){
				$hasil = $k->jml;
			}
		}else{
			$hasil = 0;
		}
		return $hasil;
	}
	public function berkas_delete($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('berkas');
		
	}
	public function get_hari()
	{
		$this->db->select('*');
		$this->db->from('hari');
		$this->db->order_by('kode','ASC');
		// $this->db->where('id',$id);
		
		$query = $this->db->get();
		return $query->result();
	}
	public function get_jam()
	{
		$this->db->select('*');
		$this->db->from('jam');
		$this->db->order_by('kode','ASC');
		// $this->db->where('id',$id);
		$query = $this->db->get();
		return $query->result();
	}
	public function getID_jadwal()
	{
		// $id=date("Ym");
		$q = $this->db->query("select MAX(id) as ID from jadwal");
		$kd="";
		if($q->num_rows()>0)
		{
			foreach($q->result() as $k)
			{
				$kode = $k->ID; //substr($k->ID,0,1);
				$tmp = ((int)$kode)+1;
				$kd = sprintf("%05s", $tmp);
			}
		}
		else
		{
			$kd = "00001";
		}	
		return $kd;
	}
	public function get_IDSurvei()
	{
		// $id=date("Ym");
		$q = $this->db->query("select MAX(id) as ID from survei_head");
		$kd="";
		if($q->num_rows()>0)
		{
			foreach($q->result() as $k)
			{
				$jml = $k->ID;
			}
		}
		else
		{
			$jml = 0;
		}	
		return $jml;
	}
	public function find_hari($id)
	{
		$q = $this->db->query("select * from hari
			WHERE kode='$id'
			group by kode");
		if($q->num_rows()>0){
			foreach($q->result() as $k){
				$hasil = $k->hari;
			}
		}else{
			$hasil = "";
		}
		return $hasil;
	}
	public function find_lab($lab)
	{
		if($lab=="1"){
			$hasil="SOFTWARE";
		}elseif($lab=="2"){
			$hasil="HARDWARE";
		}elseif($lab=="3"){
			$hasil="KOMPUTER";
		}
		return $hasil;
	}
	public function find_jam($id)
	{
		$q = $this->db->query("select * from jam
			WHERE kode='$id'
			group by kode");
		if($q->num_rows()>0){
			foreach($q->result() as $k){
				$hasil = $k->jam;
			}
		}else{
			$hasil = "";
		}
		return $hasil;
	}
	public function find_matakul($id)
	{
		$q = $this->db->query("select * from matakul
			WHERE kode='$id'
			group by kode");
		if($q->num_rows()>0){
			foreach($q->result() as $k){
				$hasil = $k->matakul;
			}
		}else{
			$hasil = "";
		}
		return $hasil;
	}
	public function find_dosen($id)
	{
		$q = $this->db->query("select * from dosen
			WHERE nidn='$id'
			group by nidn");
		if($q->num_rows()>0){
			foreach($q->result() as $k){
				$hasil = $k->nama;
			}
		}else{
			$hasil = "";
		}
		return $hasil;
	}
	public function find_kelas($id)
	{
		$q = $this->db->query("select * from kelas
			WHERE kode='$id'
			group by kode");
		if($q->num_rows()>0){
			foreach($q->result() as $k){
				$hasil = $k->kelas;
			}
		}else{
			$hasil = "";
		}
		return $hasil;
	}
	public function find_sks($id)
	{
		$q = $this->db->query("select * from matakul
			WHERE kode='$id'
			");
		if($q->num_rows()>0){
			foreach($q->result() as $k){
				$hasil = $k->sks;
			}
		}else{
			$hasil = "";
		}
		return $hasil;
	}
	public function find_jadwal_matakul($jam,$kelas,$smt,$thpel,$lab,$hari,$nidn)
	{
		if($kelas=="0"){$qk="";}else{ $qk="and kelas_kode='$kelas'";}
		if($nidn==""){$qn="";}else{ $qn="and nidn='$nidn'";}
		
		$q = $this->db->query("select * from jadwal
			WHERE jam_kode='$jam'
			$qk
			and lab='$lab'
			and thpel='$thpel'
			and smt='$smt'
			and hari_kode='$hari'
			$qn
			");
		if($q->num_rows()>0){
			foreach($q->result() as $k){
				$hasil = $k->matakul_kode;
			}
		}else{
			$hasil = "";
		}
		return $hasil;
	}
	public function find_jadwal_kelas($jam,$kelas,$smt,$thpel,$lab,$hari,$nidn)
	{
		if($kelas=="0"){
			// $qk="and kelas_kode in('A1','A2','A3')";
			$qk="";
		}else{
			$qk="and kelas_kode='$kelas'";
		}
		if($nidn==""){$qn="";}else{ $qn="and nidn='$nidn'";}
		
		$q = $this->db->query("select * from jadwal
			WHERE jam_kode='$jam'
			$qk
			and lab='$lab'
			and thpel='$thpel'
			and smt='$smt'
			and hari_kode='$hari'
			$qn
			");
		if($q->num_rows()>0){
			foreach($q->result() as $k){
				$hasil = $k->kelas_kode;
			}
		}else{
			$hasil = "";
		}
		return $hasil;
	}
	public function find_jadwal_dosen($jam,$kelas,$smt,$thpel,$lab,$hari,$nidn)
	{
		if($kelas=="0"){$qk="";	}else{$qk="and kelas_kode='$kelas'";}
		if($nidn==""){$qn="";}else{ $qn="and nidn='$nidn'";}
		$q = $this->db->query("select * from jadwal
			WHERE jam_kode='$jam'
			$qk
			and lab='$lab'
			and thpel='$thpel'
			and smt='$smt'
			and hari_kode='$hari'
			$qn
			");
		if($q->num_rows()>0){
			foreach($q->result() as $k){
				$hasil = $k->nidn;
			}
		}else{
			$hasil = "";
		}
		return $hasil;
	}
	public function get_mhs()
	{
		$this->db->select('*');
		$this->db->from('mahasiswa');
		$this->db->order_by('nama','ASC');
		// $this->db->where('id',$id);
		$query = $this->db->get();
		return $query->result();
	}
	public function get_mhs_id($id)
	{
		$this->db->select('*');
		$this->db->from('mahasiswa');
		$this->db->order_by('nama','ASC');
		$this->db->where('nim',$id);
		$query = $this->db->get();
		return $query->result();
	}
	public function get_dosen_id($id)
	{
		$this->db->select('*');
		$this->db->from('dosen');
		$this->db->order_by('nama','ASC');
		$this->db->where('nidn',$id);
		$query = $this->db->get();
		return $query->result();
	}
	public function cek_hadir($id,$h,$smt,$matakul){
		date_default_timezone_set("Asia/Jakarta");
		$q = $this->db->query("select *
			from absen
			WHERE nim='$id' and 
			DATE_FORMAT(tgl,'%Y-%m-%d') = DATE_FORMAT(NOW(),'%Y-%m-%d')
			and hadir='$h'
			and smt='$smt'
			and matakul='$matakul'
			ORDER BY nim ASC ");
		if($q->num_rows()>0){
			foreach($q->result() as $k){
				$hasil = $k->nim;
				$hasil="disabled";
			}
		}else{
			$hasil = "";
		}
		return $hasil;
	}
	public function cek_survei($nim){		
		$q = $this->db->query("select  id, nim, DATEDIFF(NOW(),tgl) as sel
			from survei_head
			where nim='$nim'
			order by id desc
			limit 0,1");
		if($q->num_rows()>0){
			foreach($q->result() as $k){
				$sel = $k->sel;
				$hasil=$sel;
			}
			
		}else{
			$hasil = 30;
		}
		return $hasil;
	}
	public function find_assisten($id){		
		$q = $this->db->query("select * 
			from assisten
			where id='$id'
			order by id desc
			limit 0,1");
		if($q->num_rows()>0){
			foreach($q->result() as $k){
				$sel = $k->nama;
				$hasil=$sel;
			}
			
		}else{
			$hasil = 30;
		}
		return $hasil;
	}
	public function find_ketsoal($id)
	{
		switch ($id) {
			case 1:
				$hasil = "Layanan";
				break;
			case 2:
				$hasil = "Fasilitas";
				break;
			case 3:
				$hasil = "Disiplin Assisten";
				break;
			case 4:
				$hasil = "Petugas";
				break;
			case 5:
				$hasil = "Tjwb Laboran/Prodi";
				break;
			case 6:
				$hasil = "Tjwb Dosen";
				break;
			default:
				$hasil = "Lainnya";
				break;
		}      
		return $hasil;
	}
	public function jml_h($id,$h,$smt,$matakul){
		date_default_timezone_set("Asia/Jakarta");
		$q = $this->db->query("select 
			SUM(IF(hadir='$h',1,0)) as h 
			from absen
			WHERE nim='$id'
			and hadir='$h'
			and smt='$smt'
			and matakul='$matakul'
			ORDER BY nim ASC ");
		if($q->num_rows()>0){
			foreach($q->result() as $k){
				$hasil = $k->h;
				
			}
		}else{
			$hasil = "0";
		}
		return $hasil;
	}
	public function ambildata()
	{
		date_default_timezone_set("Asia/Jakarta");
		// $mysqli = new mysqli("localhost", "root", "", "db_melati");
		/* check connection */
		$koneksi = odbc_connect("att", "att2000" , "");
		$hasil = odbc_exec($koneksi, "SELECT * FROM USERINFO");
		while ($data = odbc_fetch_array($hasil))
		{
			$dat = array(
                'Badgenumb'=>$data['Badgenumber'],
                'USERID'=>$data['USERID'],
            );
			
			
            $insert_query = $this->db->insert_string('userinfo', $dat);  // QUERY RUNS ONCE
			$insert_query = str_replace('INSERT INTO','INSERT IGNORE INTO',$insert_query);
			$this->db->query($insert_query); 
		}
		//
		$hasil = odbc_exec($koneksi, "SELECT * FROM CHECKINOUT order by CHECKTIME ASC ");
		while ($data = odbc_fetch_array($hasil))
		{
			$dat = array(
                'CHECKTIME'=>$data['CHECKTIME'],
                'USERID'=>$data['USERID'],
            );
			
				$insert_query = $this->db->insert_string('checkinout', $dat);  // QUERY RUNS ONCE
				$insert_query = str_replace('INSERT INTO','INSERT IGNORE INTO',$insert_query);
				$this->db->query($insert_query); 
		
		}
		//tampilkan hasil 
		$hapus = odbc_exec($koneksi, "DELETE * FROM CHECKINOUT");
		$query = $this->db->query("SELECT c.Badgenumb, c.nama, a.CHECKTIME FROM checkinout as a 
								inner join userinfo as b 
								on a.USERID=b.USERID
								inner join mahasiswa as  c 
								on b.Badgenumb=c.Badgenumb
								ORDER BY a.ID DESC
								LIMIT 0,100");
		// return $query;
		return $query->result();
		
	}
	
}
	
/* End of file app_model.php */
/* Location: ./application/models/app_model.php */