<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
//dashboard
$route['counter']['get'] = 'api_admin/dashboard/select';


//pengguna
$route['users']['get'] = 'api_admin/users/select';
$route['users']['options'] = 'api_admin/users/select';
$route['users']['post'] = 'api_admin/users/store';
$route['users/(:any)']['get'] = 'api_admin/users/show/$1';
$route['users/(:any)']['delete'] = 'api_admin/users/delete/$1';
$route['users/(:any)']['options'] = 'api_admin/users/delete/$1';

//mahasiswa
$route['mahasiswa']['get'] = 'api_admin/mahasiswa/select';
$route['mahasiswa']['options'] = 'api_admin/mahasiswa/select';
$route['mahasiswa']['post'] = 'api_admin/mahasiswa/store';
$route['mahasiswa/(:any)']['get'] = 'api_admin/mahasiswa/show/$1';
$route['mahasiswa/(:any)']['delete'] = 'api_admin/mahasiswa/delete/$1';
$route['mahasiswa/(:any)']['options'] = 'api_admin/mahasiswa/delete/$1';

//dosen
$route['dosen']['get'] = 'api_admin/dosen/select';
$route['dosen']['options'] = 'api_admin/dosen/select';
$route['dosen']['post'] = 'api_admin/dosen/store';
$route['dosen/(:any)']['get'] = 'api_admin/dosen/show/$1';
$route['dosen/(:any)']['delete'] = 'api_admin/dosen/delete/$1';
$route['dosen/(:any)']['options'] = 'api_admin/dosen/delete/$1';

//kelas
$route['kelas']['get'] = 'api_admin/kelas/select';
$route['kelas']['options'] = 'api_admin/kelas/select';
$route['kelas']['post'] = 'api_admin/kelas/store';
$route['kelas/(:any)']['get'] = 'api_admin/kelas/show/$1';
$route['kelas/(:any)']['delete'] = 'api_admin/kelas/delete/$1';
$route['kelas/(:any)']['options'] = 'api_admin/dosen/delete/$1';

//jurusan
$route['jurusan']['get'] = 'api_admin/jurusan/select';
$route['jurusan']['options'] = 'api_admin/jurusan/select';
$route['jurusan']['post'] = 'api_admin/jurusan/store';
$route['jurusan/(:any)']['get'] = 'api_admin/jurusan/show/$1';
$route['jurusan/(:any)']['delete'] = 'api_admin/jurusan/delete/$1';
$route['jurusan/(:any)']['options'] = 'api_admin/jurusan/delete/$1';

//tempati kelas
$route['tempatikelas']['get'] = 'api_admin/tempatikelas/select';
$route['tempatikelas']['options'] = 'api_admin/tempatikelas/select';
$route['tempatikelas']['post'] = 'api_admin/tempatikelas/store';
$route['tempatikelas/(:any)']['get'] = 'api_admin/tempatikelas/show/$1';
$route['tempatikelas/(:any)']['delete'] = 'api_admin/tempatikelas/delete/$1';
$route['tempatikelas/(:any)']['options'] = 'api_admin/tempatikelas/delete/$1';

//soal
$route['soal']['get'] = 'api_admin/soal/select';
$route['soal']['options'] = 'api_admin/soal/select';
$route['soal']['post'] = 'api_admin/soal/store';
$route['soal/(:any)']['get'] = 'api_admin/soal/show/$1';
$route['soal/(:any)']['delete'] = 'api_admin/soal/delete/$1';
$route['soal/(:any)']['options'] = 'api_admin/soal/delete/$1';

//asisten
$route['asisten']['get'] = 'api_admin/asisten/select';
$route['asisten']['options'] = 'api_admin/asisten/select';
$route['asisten']['post'] = 'api_admin/asisten/store';
$route['asisten/(:any)']['get'] = 'api_admin/asisten/show/$1';
$route['asisten/(:any)']['delete'] = 'api_admin/asisten/delete/$1';
$route['asisten/(:any)']['options'] = 'api_admin/asisten/delete/$1';

//matakuliah
$route['matakul']['get'] = 'api_admin/matakul/select';
$route['matakul']['options'] = 'api_admin/matakul/select';
$route['matakul']['post'] = 'api_admin/matakul/store';
$route['matakul/(:any)']['get'] = 'api_admin/matakul/show/$1';
$route['matakul/(:any)']['delete'] = 'api_admin/matakul/delete/$1';
$route['matakul/(:any)']['options'] = 'api_admin/matakul/delete/$1';

// inventori
$route['inventori']['get'] = 'api_admin/inventori/select';
$route['inventori']['options'] = 'api_admin/inventori/select';
$route['inventori']['post'] = 'api_admin/inventori/store';
$route['inventori/(:any)']['get'] = 'api_admin/inventori/show/$1';
$route['inventori/(:any)']['delete'] = 'api_admin/inventori/delete/$1';
$route['inventori/(:any)']['options'] = 'api_admin/inventori/delete/$1';

// peminjaman
$route['peminjaman']['get'] = 'api_admin/peminjaman/select';
$route['peminjaman']['options'] = 'api_admin/peminjaman/select';
$route['peminjaman']['post'] = 'api_admin/peminjaman/store';
$route['peminjaman/(:any)']['get'] = 'api_admin/peminjaman/show/$1';
$route['peminjaman/(:any)']['delete'] = 'api_admin/peminjaman/delete/$1';
$route['peminjaman/(:any)']['options'] = 'api_admin/peminjaman/delete/$1';

//materi
$route['materi']['get'] = 'api_admin/materi/select';
$route['materi']['options'] = 'api_admin/materi/select';
$route['materi']['post'] = 'api_admin/materi/store';
$route['materi/(:any)']['get'] = 'api_admin/materi/show/$1';
$route['materi/(:any)']['delete'] = 'api_admin/materi/delete/$1';
$route['materi/(:any)']['options'] = 'api_admin/materi/delete/$1';

//
$route['profile']['get'] = 'api_admin/profile/select';
$route['profile']['options'] = 'api_admin/profile/select';
$route['profile']['post'] = 'api_admin/profile/store';
$route['profile/(:any)']['get'] = 'api_admin/profile/show/$1';
// $route['profile/(:any)']['delete'] = 'api_admin/profile/delete/$1';
// $route['profile/(:any)']['options'] = 'api_admin/profile/delete/$1';


//pengajuan
$route['inventoripengajuan']['get'] = 'api_admin/inventoripengajuan/select';
$route['inventoripengajuan']['options'] = 'api_admin/inventoripengajuan/select';
$route['inventoripengajuan']['post'] = 'api_admin/inventoripengajuan/store';
$route['inventoripengajuan/(:any)']['get'] = 'api_admin/inventoripengajuan/show/$1';
$route['inventoripengajuan/(:any)']['delete'] = 'api_admin/inventoripengajuan/delete/$1';
$route['inventoripengajuan/(:any)']['options'] = 'api_admin/inventoripengajuan/delete/$1';

//maintenacne
$route['maintenance']['get'] = 'api_admin/maintenance/select';
$route['maintenance']['options'] = 'api_admin/maintenance/select';
$route['maintenance']['post'] = 'api_admin/maintenance/store';
$route['maintenance/(:any)']['get'] = 'api_admin/maintenance/show/$1';
$route['maintenance/(:any)']['delete'] = 'api_admin/maintenance/delete/$1';
$route['maintenance/(:any)']['options'] = 'api_admin/maintenance/delete/$1';

//pengajuan
$route['ruangan']['get'] = 'api_admin/ruangan/select';
$route['ruangan']['options'] = 'api_admin/ruangan/select';
$route['ruangan']['post'] = 'api_admin/ruangan/store';
$route['ruangan/(:any)']['get'] = 'api_admin/ruangan/show/$1';
$route['ruangan/(:any)']['delete'] = 'api_admin/ruangan/delete/$1';
$route['ruangan/(:any)']['options'] = 'api_admin/ruangan/delete/$1';

// peminjaman
$route['pinjamruangan']['get'] = 'api_admin/pinjamruangan/select';
$route['pinjamruangan']['options'] = 'api_admin/pinjamruangan/select';
$route['pinjamruangan']['post'] = 'api_admin/pinjamruangan/store';
$route['pinjamruangan/(:any)']['get'] = 'api_admin/pinjamruangan/show/$1';
$route['pinjamruangan/(:any)']['delete'] = 'api_admin/pinjamruangan/delete/$1';
$route['pinjamruangan/(:any)']['options'] = 'api_admin/pinjamruangan/delete/$1';

//jadwal
$route['jam']['get'] = 'api_admin/jam/select';
$route['hari']['get'] = 'api_admin/hari/select';
$route['jadwal']['get'] = 'api_admin/jadwal/select';
$route['jadwal']['options'] = 'api_admin/jadwal/select';
$route['jadwal']['post'] = 'api_admin/jadwal/store';
$route['jadwal/(:any)']['get'] = 'api_admin/jadwal/show/$1';
$route['jadwal/(:any)']['delete'] = 'api_admin/jadwal/delete/$1';
$route['jadwal/(:any)']['options'] = 'api_admin/jadwal/delete/$1';

// peminjaman
$route['survei']['get'] = 'api_admin/survei/select';
$route['survei']['options'] = 'api_admin/survei/select';
$route['survei']['post'] = 'api_admin/survei/store';
$route['survei/(:any)']['get'] = 'api_admin/survei/show/$1';
$route['survei/(:any)']['delete'] = 'api_admin/survei/delete/$1';
$route['survei/(:any)']['options'] = 'api_admin/survei/delete/$1';

$route['default_controller'] = 'person';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
