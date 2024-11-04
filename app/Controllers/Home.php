<?php

namespace App\Controllers;
use App\Models\M_rm;
use TCPDF;
class Home extends BaseController
{
	public function dashboard()
{
    $model = new M_rm();
    $where = array('id_setting' => '1');
    $data['yogi'] = $model->getWhere1('setting', $where)->getRow();

    // Ambil nama pengguna dari session
    $session = session();
    $data['username'] = $session->get('username');

    // Get current month and year
    $currentMonth = date('m');
    $currentYear = date('Y');

    // Fetch financial data for current month and year
    $data['chartData'] = $model->getFinancialData($currentMonth, $currentYear);

    $id_user = session()->get('id');
    $activityLog = [
        'id_user' => $id_user,
        'menu' => 'Masuk ke Dashboard',
        'time' => date('Y-m-d H:i:s')
    ];
    $model->logActivity($activityLog);
    echo view('header', $data);
    echo view('menu');
    echo view('dashboard', $data);
    echo view('footer');
}

// Di Controller
public function updateChart()
{
    if (!$this->request->isAJAX()) {
        return $this->response->setStatusCode(403)->setJSON(['error' => 'Forbidden']);
    }

    $month = $this->request->getPost('month');
    $year = $this->request->getPost('year');
    
    $model = new M_rm();
    $chartData = $model->getFinancialData($month, $year);
    
    if (empty($chartData)) {
        $chartData = [[
            'total_penjualan' => 0,
            'beban' => 0,
            'laba_bersih' => 0
        ]];
    }
    
    return $this->response->setJSON([
        'status' => 'success',
        'chartData' => $chartData
    ]);
}

	public function login()
	{
		$model= new M_rm();
		$where = array('id_setting' => '1');
		$data['yogi'] = $model->getWhere1('setting', $where)->getRow();
        $id_user = session()->get('id');
    $activityLog = [
        'id_user' => $id_user,
        'menu' => 'Masuk ke Login',
        'time' => date('Y-m-d H:i:s')
    ];
    $model->logActivity($activityLog);
	echo view('header', $data);
	echo view('login');
	}




public function aksi_login()
{
    // Periksa koneksi internet
    if (!$this->checkInternetConnection()) {
        // Jika tidak ada koneksi, cek CAPTCHA gambar
        $captcha_code = $this->request->getPost('captcha_code');
        if (session()->get('captcha_code') !== $captcha_code) {
            session()->setFlashdata('toast_message', 'Invalid CAPTCHA');
            session()->setFlashdata('toast_type', 'danger');
            return redirect()->to('home/login');
        }
    } else {
        // Jika ada koneksi, cek Google reCAPTCHA
        $recaptchaResponse = trim($this->request->getPost('g-recaptcha-response'));
        $secret = '6LcpI2MqAAAAAJTX8Er6sD6VwS_bGwkJl75Onlo9'; // Ganti dengan Secret Key Anda
        $credential = array(
            'secret' => $secret,
            'response' => $recaptchaResponse
        );

        $verify = curl_init();
        curl_setopt($verify, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
        curl_setopt($verify, CURLOPT_POST, true);
        curl_setopt($verify, CURLOPT_POSTFIELDS, http_build_query($credential));
        curl_setopt($verify, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($verify, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($verify);
        curl_close($verify);

        $status = json_decode($response, true);

        if (!$status['success']) {
            session()->setFlashdata('toast_message', 'Captcha validation failed');
            session()->setFlashdata('toast_type', 'danger');
            return redirect()->to('home/login');
        }
    }

    // Proses login seperti biasa
    $u = $this->request->getPost('username');
    $p = $this->request->getPost('password');

    $where = array(
        'username' => $u,
        'password' => md5($p),
    );
    $model = new M_rm;
    $cek = $model->getWhere('user', $where);

    if ($cek) {
        session()->set('nama', $cek->username);
        session()->set('id', $cek->id_user);
        session()->set('status', $cek->status);
        return redirect()->to('home/dashboard');
    } else {
        session()->setFlashdata('toast_message', 'Invalid login credentials');
        session()->setFlashdata('toast_type', 'danger');
        return redirect()->to('home/login');
    }
}



public function generateCaptcha()
{
    // Create a string of possible characters
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    $captcha_code = '';
    
    // Generate a random CAPTCHA code with letters and numbers
    for ($i = 0; $i < 6; $i++) {
        $captcha_code .= $characters[rand(0, strlen($characters) - 1)];
    }
    
    // Store CAPTCHA code in session
    session()->set('captcha_code', $captcha_code);
    
    // Create an image for CAPTCHA
    $image = imagecreate(120, 40); // Increased size for better readability
    $background = imagecolorallocate($image, 200, 200, 200);
    $text_color = imagecolorallocate($image, 0, 0, 0);
    $line_color = imagecolorallocate($image, 64, 64, 64);
    
    imagefilledrectangle($image, 0, 0, 120, 40, $background);
    
    // Add some random lines to the CAPTCHA image for added complexity
    for ($i = 0; $i < 5; $i++) {
        imageline($image, rand(0, 120), rand(0, 40), rand(0, 120), rand(0, 40), $line_color);
    }
    
    // Add the CAPTCHA code to the image
    imagestring($image, 5, 20, 10, $captcha_code, $text_color);
    
    // Output the CAPTCHA image
    header('Content-type: image/png');
    imagepng($image);
    imagedestroy($image);
}




public function checkInternetConnection()
{
    $connected = @fsockopen("www.google.com", 80);
    if ($connected) {
        fclose($connected);
        return true;
    } else {
        return false;
    }
}



public function makanan(){

    $model = new M_rm;
    $data['oke'] = $model->tampilActive('menu');
    $where = array('id_setting' => '1');
    $data['yogi'] = $model->getWhere1('setting', $where)->getRow();

    $id_user = session()->get('id');
    $activityLog = [
        'id_user' => $id_user,
        'menu' => 'Masuk ke Makanan',
        'time' => date('Y-m-d H:i:s')
    ];
    $model->logActivity($activityLog);
    echo view('header', $data);
    echo view('menu');
    echo view('makanan', $data);
    echo view('footer');
}




public function t_menu(){

    $model = new M_rm;
    $data['yoga'] = $model->join('kategori', 'menu', 'kategori.id_kategori=menu.id_menu');
    $where = array('id_setting' => '1');
    $data['yogi'] = $model->getWhere1('setting', $where)->getRow();
    $id_user = session()->get('id');
    $activityLog = [
        'id_user' => $id_user,
        'menu' => 'Masuk ke Tambah Menu',
        'time' => date('Y-m-d H:i:s')
    ];
    $model->logActivity($activityLog);

    echo view('header', $data);
    echo view('menu');
    echo view('t_menu', $data);
    echo view('footer');
}




public function aksi_t_menu()
{
    $yoga = $this->request->getPost('namamenu');
    $cahya = $this->request->getPost('kategorimenu');
    $cahya1 = $this->request->getPost('hargamenu');
    $cahya2 = $this->request->getPost('stokmenu');

    // Ambil kode menu terakhir dari tabel
    $model = new M_rm();
    $lastMenu = $model->getLastMenu();

    // Generate kode menu baru
    if ($lastMenu) {
        // Ambil nomor urut terakhir dari kode menu, misalnya 'M-001'
        $lastCode = $lastMenu['kode_menu'];
        $number = (int) substr($lastCode, 2); // Ambil angka dari 'M-001' => 1
        $newCode = 'M-' . str_pad($number + 1, 3, '0', STR_PAD_LEFT); // Buat 'M-002'
    } else {
        // Jika belum ada data, kode pertama adalah 'M-001'
        $newCode = 'M-001';
    }

    $yogurt = array(
        'kode_menu'   => $newCode,  // Simpan kode menu yang baru
        'nama_menu'   => $yoga,
        'id_kategori' => $cahya,
        'harga_menu'  => $cahya1,
        'stok'        => $cahya2,
    );

    // Tambahkan data ke database
    $model->tambah('menu', $yogurt);

    // Redirect ke halaman yang diinginkan
    return redirect()->to('home/makanan');
}



public function edit_menu($id)
{
    $model = new M_rm();

    // Ambil data menu berdasarkan ID menu
    $where = array('id_menu' => $id);
    $data['yoga'] = $model->getWhere('menu', $where);  // Ambil satu baris data menu sebagai objek
    
    // Ambil semua kategori untuk dropdown
    $data['yogurt'] = $model->getAllKategori();  // Ambil semua kategori
    $where = array('id_setting' => '1');
    $data['yogi'] = $model->getWhere1('setting', $where)->getRow();

    // Cek apakah data menu ditemukan
    if (!$data['yoga']) {
        throw new \CodeIgniter\Exceptions\PageNotFoundException('Menu tidak ditemukan');
    }
    $id_user = session()->get('id');
    $activityLog = [
        'id_user' => $id_user,
        'menu' => 'Masuk ke Edit Menu',
        'time' => date('Y-m-d H:i:s')
    ];
    $model->logActivity($activityLog);
    // Kirim data ke view
    echo view('header', $data);
    echo view('menu');  // Asumsi ini untuk menampilkan menu navigasi atau lainnya
    echo view('e_menu', $data);  // Mengirim data ke view e_menu untuk form edit
    echo view('footer');
}




public function aksi_e_menu()
	{
		$yoga = $this -> request ->getPost('namamenu');
		$cahya = $this -> request ->getPost('kategorimenu');
        $cahya1 = $this -> request ->getPost('hargamenu');
        $cahya2 = $this -> request ->getPost('stokmenu');
		$id = $this -> request ->getPost('id');


        $model = new M_rm(); 

		$oldData = $model->getWhere1('menu', ['id_menu' => $id])->getRow();

    if ($oldData) {
        // Backup data lama
        $backupData = [
            'id_menu' => $oldData->id_menu,
            'id_kategori' => $oldData->id_kategori,
            'kode_menu' => $oldData->kode_menu,
            'nama_menu' => $oldData->nama_menu,
            'harga_menu' => $oldData->harga_menu,
            'stok' => $oldData->stok,
            'backup_at' => date('Y-m-d H:i:s'),
            'backup_by' => session()->get('id'), // ID pengguna yang membuat backup
        ];
		
        if ($model->saveToBackup('menu_backup', $backupData)) {
            // Update data kelas
            $oke = [
                'nama_menu' => $yoga,
                'id_kategori' => $cahya,
                'harga_menu' => $cahya1,
                'stok' => $cahya2,
                'updated_by' => session()->get('id'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            $where = array('id_menu'=>$id);
            $model->edit('menu', $oke, $where);

		return redirect()->to('home/makanan');

	    }
    }
}


    public function hapus_menu($id)
    {
        $model = new M_rm();
        $where = array('id_menu' => $id);
        $array = array(
            'deleted_at' => date('Y-m-d H:i:s'),
        );
        $model->edit('menu', $array, $where);
        // $this->logUserActivity('Menghapus Pemesanan');

        return redirect()->to('Home/makanan');
    }

    public function restore_menu($id)
    {
        $model = new M_rm();
        $where = array('id_menu' => $id);
        $array = array(
            'deleted_at' => NULL, // Mengatur deleted_at menjadi null
        );
        $model->edit('menu', $array, $where);
    
        return redirect()->to('Home/makanan');
    }

    


    public function pemesanan(){

        $model = new M_rm;
        $data['oke'] = $model->tampil('menu');
        $where = array('id_setting' => '1');
        $data['yogi'] = $model->getWhere1('setting', $where)->getRow();
        $id_user = session()->get('id');
    $activityLog = [
        'id_user' => $id_user,
        'menu' => 'Masuk ke Pemesanan',
        'time' => date('Y-m-d H:i:s')
    ];
    $model->logActivity($activityLog);
        echo view('header', $data);
        echo view('menu');
        echo view('pemesanan', $data);
        echo view('footer');
    }


    public function aksi_t_pemesanan()
{
    if (session()->get('id') > 0) {
        // Retrieve form data
        $nama_pelanggan = $this->request->getPost('nama_pelanggan');
        $nomor_pemesanan = $this->request->getPost('nomor_pemesanan');
        $menu_items = $this->request->getPost('menu');
        $total = $this->request->getPost('total');
        $bayar = $this->request->getPost('bayar');
        $kembalian = $this->request->getPost('kembalian');
        $tanggal = date('Y-m-d H:i:s');

        // Initialize model
        $model = new M_rm();

        // Validate if menu_items is not empty
        if (empty($menu_items)) {
            return redirect()->to('home/pemesanan')->with('error', 'Tidak ada menu yang dipilih.');
        }

        // Insert transaksi data
        $dataTransaksi = [
            'nomor_pemesanan' => $nomor_pemesanan,
            'tanggal' => $tanggal,
            'total' => $total,
            'bayar' => $bayar,
            'kembalian' => $kembalian,
        ];

        // Save transaction
        if ($model->tambah('transaksi', $dataTransaksi)) {
            // Save pemesanan items and update stock
            foreach ($menu_items as $item) {
                // Fetch current stock of the menu item
                $menu = $model->getWhere1('menu', ['id_menu' => $item['id_menu']])->getRow(); // Fix: Directly get the object

                // Check if menu data is found
                if ($menu) {
                    $currentStock = $menu->stok; // Assuming 'stok' column exists in 'menu' table

                    // Check if stock is sufficient
                    if ($currentStock >= $item['jumlah']) {
                        // Save pemesanan
                        $pemesanan = [
                            'nama_pelanggan' => $nama_pelanggan,
                            'id_menu' => $item['id_menu'],
                            'nomor_pemesanan' => $nomor_pemesanan,
                            'jumlah' => $item['jumlah'],
                        ];
                        $model->tambah('pemesanan', $pemesanan);

                        // Update stock in menu using the edit function
                        $newStock = $currentStock - $item['jumlah'];
                        $model->edit('menu', ['stok' => $newStock], ['id_menu' => $item['id_menu']]);
                    } else {
                        // If stock is not enough, rollback transaction and return an error
                        return redirect()->to('home/pemesanan')->with('error', 'Stok untuk menu ' . $menu->nama_menu . ' tidak mencukupi.');
                    }
                } else {
                    // If menu not found, show an error
                    return redirect()->to('home/pemesanan')->with('error', 'Menu dengan ID ' . $item['id_menu'] . ' tidak ditemukan.');
                }
            }

            // Redirect to the print nota page
            return redirect()->to('home/printnota/' . $nomor_pemesanan);
        } else {
            // If saving fails, redirect back with error
            return redirect()->to('home/pemesanan')->with('error', 'Gagal menyimpan transaksi.');
        }
    } else {
        // If user not logged in
        return redirect()->to('home/login')->with('error', 'Silakan login untuk melanjutkan.');
    }
}


public function printnota($nomor_pemesanan) {
    $model = new M_rm();
    if (session()->get('id') > 0) {
        // Retrieve user and setting information
        $data['dua'] = $model->getWhere('user', ['id_user' => session()->get('id')]);
        $data['setting'] = $model->getWhere('setting', ['id_setting' => 1]);
        
        // Retrieve transaksi data
        $data['transaksi'] = $model->getWhere('transaksi', ['nomor_pemesanan' => $nomor_pemesanan]);
        
        // Retrieve pemesanan data including the customer name
        $data['pemesanan'] = $model->joinresult('pemesanan', 'menu', 'pemesanan.id_menu=menu.id_menu', ['nomor_pemesanan' => $nomor_pemesanan]);

        // Check if the transaction exists
        if (empty($data['transaksi'])) {
            return redirect()->to('home/pemesanan')->with('error', 'Transaksi tidak ditemukan.');
        }

        // Extract the customer name from the transaksi data
        $data['transaksi']->nama_pelanggan = $data['pemesanan'][0]->nama_pelanggan ?? 'N/A'; // Assuming nama_pelanggan is in the pemesanan table
        $id_user = session()->get('id');
        $activityLog = [
            'id_user' => $id_user,
            'menu' => 'Masuk ke Print Nota',
            'time' => date('Y-m-d H:i:s')
        ];
        $model->logActivity($activityLog);
        // Load the view for printing nota
        return view('print_nota', $data);
    } else {
        return redirect()->to('login')->with('error', 'Silakan login untuk melanjutkan.');
    }
}




public function histroy_transaksi() {
    $model = new M_rm;

    // Ambil nilai filter dari input GET
    $startDate = $this->request->getGet('start_date');
    $endDate = $this->request->getGet('end_date');

    // Pagination
    $limit = 20; // Jumlah data per halaman
    $page = $this->request->getGet('page') ? (int)$this->request->getGet('page') : 1;
    $offset = ($page - 1) * $limit;

    // Ambil data transaksi berdasarkan filter tanggal
    $data['oke'] = $model->tampilWithPagination('transaksi', $startDate, $endDate, $limit, $offset);
    $data['total'] = $model->countData('transaksi', $startDate, $endDate);

    // Hitung jumlah halaman
    $data['total_pages'] = ceil($data['total'] / $limit);
    // Kirim variabel ke view
    $data['page'] = $page;
    $data['limit'] = $limit; // Tambahkan limit ke data yang dikirim ke view

    $where = array('id_setting' => '1');
    $data['yogi'] = $model->getWhere1('setting', $where)->getRow();
    $id_user = session()->get('id');
    $activityLog = [
        'id_user' => $id_user,
        'menu' => 'Masuk ke History Transaksi',
        'time' => date('Y-m-d H:i:s')
    ];
    $model->logActivity($activityLog);
    echo view('header', $data);
    echo view('menu');
    echo view('transaksi', $data);
    echo view('footer');
}



// public function modal() {
//     $model = new M_rm;

//     // Tangkap filter id_menu dan tahun dari GET request
//     $id_menu = $this->request->getGet('id_menu');
//     $tahun = $this->request->getGet('tahun'); // Format tahun (YYYY)

//     // Mulai membangun query dengan join modal dan menu
//     $builder = $model->db->table('modal')
//                          ->select('modal.*, menu.nama_menu')
//                          ->join('menu', 'modal.id_menu = menu.id_menu');

//     // Jika ada filter id_menu
//     if (!empty($id_menu)) {
//         $builder->where('modal.id_menu', $id_menu);
//     }

//     // Jika ada filter tahun
//     if (!empty($tahun)) {
//         // Filter berdasarkan tahun
//         $builder->where('YEAR(modal.tanggal)', $tahun);
//     }

//     // Eksekusi query
//     $data['oke'] = $builder->get()->getResult();

//     // Mengambil data kategori menu untuk dropdown
//     $data['kategori_menu'] = $model->tampil('menu'); // Ambil semua kategori menu

//     // Mengambil data setting
//     $where = array('id_setting' => '1');
//     $data['yogi'] = $model->getWhere1('setting', $where)->getRow();

//     // Load views
//     echo view('header', $data);
//     echo view('menu');
//     echo view('modal', $data);
//     echo view('footer');
// }

public function modal_produksi() {
    $model = new M_rm;

    // Tangkap filter id_menu, bulan, dan tahun dari GET request
    $id_menu = $this->request->getGet('id_menu');
    $bulan = $this->request->getGet('bulan');
    $tahun = $this->request->getGet('tahun');

    // Mulai membangun query dengan join modal dan menu
    $builder = $model->db->table('modal')
                         ->select('modal.*, menu.nama_menu')
                         ->join('menu', 'modal.id_menu = menu.id_menu');

    // Jika ada filter id_menu
    if (!empty($id_menu)) {
        $builder->where('modal.id_menu', $id_menu);
    }

    // Jika ada filter bulan dan tahun
    if (!empty($bulan) && !empty($tahun)) {
        $builder->where('MONTH(modal.tanggal)', $bulan);
        $builder->where('YEAR(modal.tanggal)', $tahun);
    } elseif (!empty($tahun)) {
        // Jika hanya ada filter tahun
        $builder->where('YEAR(modal.tanggal)', $tahun);
    }

    // Eksekusi query
    $data['oke'] = $builder->get()->getResult();

    // Mengambil data kategori menu untuk dropdown
    $data['kategori_menu'] = $model->tampil('menu');

    // Mengambil data setting
    $where = array('id_setting' => '1');
    $data['yogi'] = $model->getWhere1('setting', $where)->getRow();

    $id_user = session()->get('id');
    $activityLog = [
        'id_user' => $id_user,
        'menu' => 'Masuk ke Modal Produksi',
        'time' => date('Y-m-d H:i:s')
    ];
    $model->logActivity($activityLog);

    // Load views
    echo view('header', $data);
    echo view('menu');
    echo view('modal_produksi', $data);
    echo view('footer');
}







public function t_modal_produksi() {
    $model = new M_rm;
    
    // Mengambil data setting
    $where = array('id_setting' => '1');
    $data['yogi'] = $model->getWhere1('setting', $where)->getRow();

    // Mengambil data kategori modal dengan fungsi tampil
    $data['kategori_menu'] = $model->tampil('menu'); // Ambil semua kategori dari tabel 'kategori'

    // Mengambil data modal dengan fungsi tampil
    $data['oke'] = $model->tampil('modal'); // Ambil semua data dari tabel 'modal'
    $id_user = session()->get('id');
    $activityLog = [
        'id_user' => $id_user,
        'menu' => 'Masuk ke Tambah Modal Produksi',
        'time' => date('Y-m-d H:i:s')
    ];
    $model->logActivity($activityLog);
    echo view('header', $data);
    echo view('menu');
    echo view('t_modal_produksi', $data);
    echo view('footer');
}



public function aksi_t_modal_produksi() 
{
    $model = new M_rm();
    
    // Retrieve posted data
    $kategoriIds = $this->request->getPost('kategori');
    $descriptions = $this->request->getPost('deskripsi');
    $hargaSatuan = $this->request->getPost('harga_satuan');
    $jumlahs = $this->request->getPost('jumlah');
    $satuans = $this->request->getPost('unit');
    $totalBahan = $this->request->getPost('total_bahan');
    
    // Current timestamp
    $tanggal = date('Y-m-d H:i:s');
    
    // Loop through the data and insert each record
    for ($i = 0; $i < count($kategoriIds); $i++) {
        // Remove currency formatting from total_bahan
        $totalBahanClean = str_replace(['Rp ', '.'], '', $totalBahan[$i]);
        
        $data = [
            'id_menu' => $kategoriIds[$i],
            'tanggal' => $tanggal,
            'deskripsi' => $descriptions[$i],
            'jumlah' => $jumlahs[$i],
            'satuan' => $satuans[$i],
            'harga_satuan' => $hargaSatuan[$i],
            'total_bahan' => $totalBahanClean
        ];
        
        // Insert data
        $model->tambah('modal', $data);
    }
    
    // Set flash message
    session()->setFlashdata('success', 'Data modal berhasil ditambahkan');
    
    // Redirect
    return redirect()->to('home/modal_produksi');
}


public function edit_modal_produksi($id)
	{
		if(session()->get('id')>0){
		$model = new M_rm();
		$where=array('id_modal'=>$id);
		
		$data['satu']=$model->getWhere('modal',$where);

        $data['menu'] = $model->tampil('menu');
        $where = array('id_setting' => '1');
    $data['yogi'] = $model->getWhere1('setting', $where)->getRow();
    $id_user = session()->get('id');
    $activityLog = [
        'id_user' => $id_user,
        'menu' => 'Masuk ke Edit Modal Produksi',
        'time' => date('Y-m-d H:i:s')
    ];
    $model->logActivity($activityLog);
		echo view ('header', $data);
		echo view ('menu');
		echo view('e_modal_produksi',$data);
		echo view('footer');
		}else{
		return redirect()->to('home/login');
		}
	}


    public function aksi_e_modal_produksi()
    {
        $model = new M_rm();
        $menu = $this->request->getPost('menu');
        $tanggal = $this->request->getPost('tanggal');
        $deskripsi = $this->request->getPost('deskripsi');
        $satuan = $this->request->getPost('satuan');
        $jumlah = $this->request->getPost('jumlah');
        $harga_satuan = $this->request->getPost('harga_satuan');
        $total_bahan = $this->request->getPost('total_bahan');
        $id = $this->request->getPost('id_modal');
    
        // Pastikan total_bahan dalam format yang benar
        if (!preg_match('/^Rp\.\s?[\d\.]+$/', $total_bahan)) {
            $total_bahan = "Rp. " . number_format((float)str_replace(['Rp. ', '.'], '', $total_bahan), 0, ',', '.');
        }
    
        $where = array('id_modal' => $id);
    
        $isi = array(
            'id_menu' => $menu,
            'tanggal' => $tanggal,
            'deskripsi' => $deskripsi,
            'satuan' => $satuan,
            'jumlah' => $jumlah,
            'harga_satuan' => $harga_satuan,
            'total_bahan' => $total_bahan, // Sekarang ini akan berformat "Rp. 10.000"
        );
    
        $model->edit('modal', $isi, $where);
    
        return redirect()->to('home/modal_produksi');
    }


    public function hapus_modal_produksi($id)
{
    $model = new M_rm();
    // $this->logUserActivity('Menghapus Pemesanan Permanent');
    $where = array('id_modal' => $id);
    $model->hapus('modal', $where);

    return redirect()->to('Home/modal_produksi');
}

public function penjualan_produk() {
    $model = new M_rm;

    // Tangkap filter dari GET request
    $id_menu = $this->request->getGet('id_menu');
    $bulan = $this->request->getGet('bulan');
    $tahun = $this->request->getGet('tahun');

    // Mulai membangun query dengan join penjualan_produk dan menu
    $builder = $model->db->table('penjualan_produk')
                         ->select('penjualan_produk.*, menu.nama_menu')
                         ->join('menu', 'penjualan_produk.id_menu = menu.id_menu');

    // Terapkan filter
    if (!empty($id_menu)) {
        $builder->where('penjualan_produk.id_menu', $id_menu);
    }

    if (!empty($bulan) && !empty($tahun)) {
        $builder->where('MONTH(penjualan_produk.tanggal)', $bulan);
        $builder->where('YEAR(penjualan_produk.tanggal)', $tahun);
    } elseif (!empty($tahun)) {
        $builder->where('YEAR(penjualan_produk.tanggal)', $tahun);
    }

    // Tambahkan pengurutan berdasarkan tanggal terbaru
    $builder->orderBy('penjualan_produk.tanggal', 'DESC');

    // Eksekusi query
    $data['oke'] = $builder->get()->getResult();

    // Mengambil data kategori menu untuk dropdown
    $data['kategori_menu'] = $model->tampil('menu');

    // Mengambil data setting
    $where = array('id_setting' => '1');
    $data['yogi'] = $model->getWhere1('setting', $where)->getRow();
    $id_user = session()->get('id');
    $activityLog = [
        'id_user' => $id_user,
        'menu' => 'Masuk ke Penjualan Produk',
        'time' => date('Y-m-d H:i:s')
    ];
    $model->logActivity($activityLog);
    // Load views
    echo view('header', $data);
    echo view('menu');
    echo view('penjualan_produk', $data);
    echo view('footer');
}


public function t_penjualan_produk() {
    $model = new M_rm;
    
    // Mengambil data setting
    $where = array('id_setting' => '1');
    $data['yogi'] = $model->getWhere1('setting', $where)->getRow();

    // Mengambil data kategori modal dengan fungsi tampil
    $data['kategori_menu'] = $model->tampil('menu'); // Ambil semua kategori dari tabel 'kategori'

    // Mengambil data modal dengan fungsi tampil
    $data['oke'] = $model->tampil('modal'); // Ambil semua data dari tabel 'modal'
    $id_user = session()->get('id');
    $activityLog = [
        'id_user' => $id_user,
        'menu' => 'Masuk ke Tambah Penjualan Produk',
        'time' => date('Y-m-d H:i:s')
    ];
    $model->logActivity($activityLog);
    echo view('header', $data);
    echo view('menu');
    echo view('t_penjualan_produk', $data);
    echo view('footer');
}


public function aksi_t_penjualan_produk() 
{
    // Retrieve posted data from the form
    $kategoriIds = $this->request->getPost('kategori');
    $tanggals = $this->request->getPost('tanggal');
    $hargaSatuan = $this->request->getPost('harga_satuan');
    $jumlahs = $this->request->getPost('jumlah_jual');

    // Load the model
    $model = new M_rm();

    // Loop through each entry and insert the data
    for ($i = 0; $i < count($kategoriIds); $i++) {
        // Ensure that we only proceed if the necessary fields are filled
        if (!empty($kategoriIds[$i]) && !empty($tanggals[$i]) && !empty($hargaSatuan[$i]) && !empty($jumlahs[$i])) {
            $totalHarga = $hargaSatuan[$i] * $jumlahs[$i]; // Calculate total price
            
            // Format total dengan Rp dan titik sebagai pemisah ribuan
            $formattedTotal = 'Rp ' . number_format($totalHarga, 0, ',', '.');
            
            $data = [
                'id_menu' => $kategoriIds[$i],
                'tanggal' => $tanggals[$i],
                'jumlah_jual' => $jumlahs[$i],
                'harga_satuan' => $hargaSatuan[$i],
                'total' => $formattedTotal, // Now includes 'Rp' and formatted number
            ];

            // Attempt to insert the data
            if (!$model->tambah('penjualan_produk', $data)) {
                // Log any errors if the insert fails
                log_message('error', 'Failed to insert data: ' . json_encode($data));
            }
        }
    }

    // Set flash message
    session()->setFlashdata('success', 'Data penjualan produk berhasil ditambahkan');

    // Redirect after processing
    return redirect()->to('home/penjualan_produk'); 
}


public function edit_penjualan_produk($id)
{
    if(session()->get('id')>0){
        $model = new M_rm();
        $where = array('id_penjualan_produk' => $id);
        
        $data['satu'] = $model->getWhere('penjualan_produk', $where);
        
        // Pastikan data numerik tidak memiliki format
        $data['satu']->harga_satuan = str_replace(['Rp. ', '.'], '', $data['satu']->harga_satuan);
        $data['satu']->total = str_replace(['Rp. ', '.'], '', $data['satu']->total);

        $data['menu'] = $model->tampil('menu');
        $where = array('id_setting' => '1');
        $data['yogi'] = $model->getWhere1('setting', $where)->getRow();
        $id_user = session()->get('id');
        $activityLog = [
            'id_user' => $id_user,
            'menu' => 'Masuk ke Edit Penjualan Produk',
            'time' => date('Y-m-d H:i:s')
        ];
        $model->logActivity($activityLog);
        echo view ('header', $data);
        echo view ('menu');
        echo view('e_penjualan_produk',$data);
        echo view('footer');
    } else {
        return redirect()->to('home/login');
    }
}


public function aksi_e_penjualan_produk()
    {
        $model = new M_rm();
        $menu = $this->request->getPost('menu');
        $tanggal = $this->request->getPost('tanggal');
        $jumlah_jual = $this->request->getPost('jumlah_jual');
        $harga_satuan = $this->request->getPost('harga_satuan');
        $total = $this->request->getPost('total');
        $id = $this->request->getPost('id_penjualan_produk');
    
        // Pastikan total_bahan dalam format yang benar
        if (!preg_match('/^Rp\.\s?[\d\.]+$/', $total)) {
            $total = "Rp. " . number_format((float)str_replace(['Rp. ', '.'], '', $total), 0, ',', '.');
        }
    
        $where = array('id_penjualan_produk' => $id);
    
        $isi = array(
            'id_menu' => $menu,
            'tanggal' => $tanggal,
            'jumlah_jual' => $jumlah_jual,
            'harga_satuan' => $harga_satuan,
            'total' => $total, // Sekarang ini akan berformat "Rp. 10.000"
        );
    
        $model->edit('penjualan_produk', $isi, $where);
    
        return redirect()->to('home/penjualan_produk');
    }


    public function hapus_penjualan_produk($id)
    {
        $model = new M_rm();
        // $this->logUserActivity('Menghapus Pemesanan Permanent');
        $where = array('id_penjualan_produk' => $id);
        $model->hapus('penjualan_produk', $where);
    
        return redirect()->to('Home/penjualan_produk');
    }



    public function pengeluaran(){

        $model = new M_rm;
        $data['yoga'] = $model->tampil('pengeluaran');
        $where = array('id_setting' => '1');
        $data['yogi'] = $model->getWhere1('setting', $where)->getRow();

        $id_user = session()->get('id');
    $activityLog = [
        'id_user' => $id_user,
        'menu' => 'Masuk ke Pengeluaran',
        'time' => date('Y-m-d H:i:s')
    ];
    $model->logActivity($activityLog);
        echo view('header', $data);
        echo view('menu');
        echo view('pengeluaran', $data);
        echo view('footer');
    }
    public function t_pengeluaran(){

        $model = new M_rm;
        $where = array('id_setting' => '1');
        $data['yogi'] = $model->getWhere1('setting', $where)->getRow();
        $id_user = session()->get('id');
    $activityLog = [
        'id_user' => $id_user,
        'menu' => 'Masuk ke Tambah Pengeluaran',
        'time' => date('Y-m-d H:i:s')
    ];
    $model->logActivity($activityLog);
        echo view('header', $data);
        echo view('menu');
        echo view('t_pengeluaran', $data);
        echo view('footer');
    }


    public function aksi_t_pengeluaran()
	{
		if(session()->get('id')>0){
		$tanggal = $this -> request ->getPost('tanggal');
		$kategori = $this -> request ->getPost('kategori');
		$nama_pengeluaran = $this -> request ->getPost('nama_pengeluaran');
		$total_pengeluaran = $this -> request ->getPost('total_pengeluaran');
		

		$darren=array(
			'tanggal'=>$tanggal,
			'kategori_pengeluaran'=>$kategori,
			'nama_pengeluaran'=>$nama_pengeluaran,
			'total_pengeluaran'=>$total_pengeluaran,
		);

		$model=new M_rm;
		$model->tambah('pengeluaran',$darren);
		return redirect()->to('home/pengeluaran');
	}else{
		return redirect()->to('home/login');
		}
	}

    public function edit_pengeluaran($id)
	{
		if(session()->get('id')>0){
		$model = new M_rm();
		$where=array('id_pengeluaran'=>$id);
		
		$data['satu']=$model->getWhere('pengeluaran',$where);

        $where = array('id_setting' => '1');
    $data['yogi'] = $model->getWhere1('setting', $where)->getRow();
    $id_user = session()->get('id');
    $activityLog = [
        'id_user' => $id_user,
        'menu' => 'Masuk ke Edit Pengeluaran',
        'time' => date('Y-m-d H:i:s')
    ];
    $model->logActivity($activityLog);
		echo view ('header', $data);
		echo view ('menu');
		echo view('e_pengeluaran',$data);
		echo view('footer');
		}else{
		return redirect()->to('home/login');
		}
	}


    public function aksi_e_pengeluaran()
	{
		if(session()->get('id')>0){
		$model = new M_rm();
		$yoga = $this -> request ->getPost('tanggal');
		$cahya = $this -> request ->getPost('kategori');
        $cahya1 = $this -> request ->getPost('nama_pengeluaran');
        $cahya2 = $this -> request ->getPost('total_pengeluaran');
		$id = $this -> request ->getPost('id');

		$where = array('id_pengeluaran'=>$id);

		$isi = array(

			'tanggal'=>$yoga,
			'kategori_pengeluaran'=>$cahya,
            'nama_pengeluaran'=>$cahya1,
            'total_pengeluaran'=>$cahya2,
			
		);
		
		$model->edit('pengeluaran', $isi, $where);

		return redirect()->to('home/pengeluaran');
		}else{
		return redirect()->to('home/login');
		}

	}


    public function hapus_pengeluaran($id)
    {
        $model = new M_rm();
        // $this->logUserActivity('Menghapus Pemesanan Permanent');
        $where = array('id_pengeluaran' => $id);
        $model->hapus('pengeluaran', $where);
    
        return redirect()->to('Home/pengeluaran');
    }

public function laporan_keuangan() {
    $model = new M_rm;

    // Ambil tanggal awal dan tanggal akhir dari GET parameter
    $tanggal_awal = $this->request->getGet('tanggal_awal');
    $tanggal_akhir = $this->request->getGet('tanggal_akhir');
    
    // Buat kondisi untuk filter berdasarkan tanggal
    $where = [];
    
    if (!empty($tanggal_awal) && !empty($tanggal_akhir)) {
        // Filter berdasarkan rentang tanggal
        $where['tanggal >='] = $tanggal_awal;
        $where['tanggal <='] = $tanggal_akhir;
    }

    // Ambil data dari tabel modal_produksi dengan filter tanggal
    $where = array('id_setting' => '1');
    $data['yogi'] = $model->getWhere1('setting', $where)->getRow();
    $id_user = session()->get('id');
    $activityLog = [
        'id_user' => $id_user,
        'menu' => 'Masuk ke Laporan Keuangan',
        'time' => date('Y-m-d H:i:s')
    ];
    $model->logActivity($activityLog);
    // Load views
    echo view('header', $data);
    echo view('menu');
    echo view('laporan_keuangan', $data); // Pastikan view menerima data produksi
    echo view('footer');
}



public function soft_delete(){

    $model = new M_rm;
    $data['oke'] = $model->tampilrestore('menu');
    $where = array('id_setting' => '1');
    $data['yogi'] = $model->getWhere1('setting', $where)->getRow();
    $id_user = session()->get('id');
    $activityLog = [
        'id_user' => $id_user,
        'menu' => 'Masuk ke Soft Delete',
        'time' => date('Y-m-d H:i:s')
    ];
    $model->logActivity($activityLog);
    echo view('header', $data);
    echo view('menu');
    echo view('soft_delete', $data);
    echo view('footer');
}

public function restore_edit_menu(){

    $model = new M_rm;
    $data['oke'] = $model->tampil('menu_backup');
    $where = array('id_setting' => '1');
    $data['yogi'] = $model->getWhere1('setting', $where)->getRow();
    $id_user = session()->get('id');
    $activityLog = [
        'id_user' => $id_user,
        'menu' => 'Masuk ke Restore Edit Menu',
        'time' => date('Y-m-d H:i:s')
    ];
    $model->logActivity($activityLog);
    echo view('header', $data);
    echo view('menu');
    echo view('restore_menu', $data);
    echo view('footer');
}

// public function aksi_restore_edit_menu($id)
// {
//     $model = new M_rm();
    
//     // Check if the backup data exists
//     $backupData = $model->getBackupData1('menu_backup', $id);
    
//     if ($backupData) {
//         $restoreSuccess = $model->restoreProduct('menu', 'id_menu', $id, $backupData);
    
//         if ($restoreSuccess) {
//             // Delete the backup data after successful restore
//             $deleteSuccess = $model->deleteBackupData('menu_backup', 'id_menu', $id);
//             if ($deleteSuccess) {
//                 return redirect()->to('home/makanan')->with('success', 'Data restored and backup deleted successfully!');
//             } else {
//                 return redirect()->to('home/makanan')->with('error', 'Data restoration succeeded but failed to delete backup!');
//             }
//         } else {
//             return redirect()->to('home/makanan')->with('error', 'Data restoration failed!');
//         }
//     } else {
//         // Handle the case when there's no backup data
//         return redirect()->to('home/makanan')->with('error', 'Backup data not found!');
//     }
// }

public function aksi_restore_edit_menu($id)
{
    $model = new M_rm();
    
    $backupData = $model->getWhere('menu_backup', ['id_menu' => $id]);

    if ($backupData) {
       
        $restoreData = [
            'nama_menu' => $backupData->nama_menu,
            'harga_menu' => $backupData->harga_menu,
            'id_kategori' => $backupData->id_kategori,
            'stok' => $backupData->stok,
            // tambahkan field lainnya sesuai dengan struktur tabel menu
        ];
        unset($restoreData['id_menu']);
        $model->edit('menu', $restoreData, ['id_menu' => $id]);
    }
    
    return redirect()->to('home/makanan');
}


public function log_activity(){

    $model = new M_rm;
    $data['oke'] = $model->tampil('menu');
    $data['users'] = $model->getAllUsers();

    $userId = $this->request->getGet('user_id');

    // Fetch logs with optional filtering
    if (!empty($userId)) {
        $data['logs'] = $model->getLogsByUser($userId);
    } else {
        $data['logs'] = $model->getLogs();
    }
    $where = array('id_setting' => '1');
    $data['yogi'] = $model->getWhere1('setting', $where)->getRow();
    $id_user = session()->get('id');
    $activityLog = [
        'id_user' => $id_user,
        'menu' => 'Masuk ke Log Activity',
        'time' => date('Y-m-d H:i:s')
    ];
    $model->logActivity($activityLog);
    echo view('header', $data);
    echo view('menu');
    echo view('log_activity', $data);
    echo view('footer');
}


public function print_laporan_keuangan() {
    $model = new M_rm();

    if (session()->get('id') > 0) {
        $data['dua'] = $model->getWhere('user', ['id_user' => session()->get('id')]);
        $data['setting'] = $model->getWhere('setting', ['id_setting' => 1]);
        $data['produksi'] = $model->getAllModalData();
        $data['penjualan_produk'] = $model->getAllPenjualanData();
        $data['pengeluaran'] = $model->getAllPengeluaranData(); // Fetch expenses data

        // Ensure no output before generating the PDF
        ob_clean();

        // Calculate totals
        $totalBahanSum = $this->calculateTotalBahan($data['produksi']);
        $totalPenjualanSum = $this->calculateTotalPenjualan($data['penjualan_produk']);
        $totalPengeluaranSum = $this->calculateTotalPengeluaran($data['pengeluaran']);
        $labaKotor = abs($totalPenjualanSum - $totalBahanSum);
        $pendapatanBersih = abs($labaKotor - $totalPengeluaranSum);

        // Prepare data for insertion into laporan_keuangan table
        $laporanKeuanganData = [
            'tanggal' => date('Y-m-d'), // Set to current date
            'total_bahan' => $totalBahanSum,
            'total_penjualan' => $totalPenjualanSum,
            'beban' => $totalPengeluaranSum,
            'laba_bersih' => $pendapatanBersih,
        ];

        // Insert data into laporan_keuangan table using the existing tambah method
        $model->tambah('laporan_keuangan', $laporanKeuanganData);

        // Set the correct header
        header('Content-Type: application/pdf');
        
        // Load view that generates PDF
        return view('print_laporan_keuangan', $data);
    } else {
        return redirect()->to('home/login')->with('error', 'Silakan login untuk melanjutkan.');
    }
}

private function calculateTotalBahan($produksi) {
    $total = 0;
    foreach ($produksi as $row) {
        $total += is_numeric($row['total_bahan']) ? floatval($row['total_bahan']) : 0;
    }
    return $total;
}

private function calculateTotalPenjualan($penjualan_produk) {
    $total = 0;
    foreach ($penjualan_produk as $row) {
        $total += is_numeric($row['total']) ? floatval($row['total']) : 0;
    }
    return $total;
}

private function calculateTotalPengeluaran($pengeluaran) {
    $total = 0;
    foreach ($pengeluaran as $row) {
        $total += is_numeric(trim(str_replace(['Rp ', '.', ' '], '', $row['total_pengeluaran']))) 
            ? floatval(trim(str_replace(['Rp ', '.', ' '], '', $row['total_pengeluaran']))) 
            : 0;
    }
    return $total;
}



	public function setting()
    {
      
                $model = new M_rm;
                $where = array('id_setting' => '1');
                $data['yogi'] = $model->getWhere1('setting', $where)->getRow();

                $id_user = session()->get('id');
    $activityLog = [
        'id_user' => $id_user,
        'menu' => 'Masuk ke Setting',
        'time' => date('Y-m-d H:i:s')
    ];
    $model->logActivity($activityLog);
                echo view('header', $data);
                echo view('menu');
                echo view('setting', $data);
                echo view('footer');
           
    }

    public function aksi_e_setting()
    {
        $model = new M_rm();
        // $this->logUserActivity('Melakukan Setting');
        $namaWebsite = $this->request->getPost('namawebsite');
        $id = $this->request->getPost('id');
        $id_user = session()->get('id');
        $where = array('id_setting' => '1');

        $data = array(
            'nama_website' => $namaWebsite,
            'update_by' => $id_user,
            'update_at' => date('Y-m-d H:i:s')
        );

        // Cek apakah ada file yang diupload untuk favicon
        $favicon = $this->request->getFile('img');
        if ($favicon && $favicon->isValid() && !$favicon->hasMoved()) {
            // Beri nama file unik
            $faviconNewName = $favicon->getRandomName();
            // Pindahkan file ke direktori public/images
            $favicon->move(WRITEPATH . '../public/images', $faviconNewName);

            // Tambahkan nama file ke dalam array data
            $data['tab_icon'] = $faviconNewName;
        }

        // Cek apakah ada file yang diupload untuk logo
        $logo = $this->request->getFile('logo');
        if ($logo && $logo->isValid() && !$logo->hasMoved()) {
            // Beri nama file unik
            $logoNewName = $logo->getRandomName();
            // Pindahkan file ke direktori public/images
            $logo->move(WRITEPATH . '../public/images', $logoNewName);

            // Tambahkan nama file ke dalam array data
            $data['logo_website'] = $logoNewName;
        }

        // Cek apakah ada file yang diupload untuk logo
        $login = $this->request->getFile('login');
        if ($login && $login->isValid() && !$login->hasMoved()) {
            // Beri nama file unik
            $loginNewName = $login->getRandomName();
            // Pindahkan file ke direktori public/images
            $login->move(WRITEPATH . '../public/images', $loginNewName);

            // Tambahkan nama file ke dalam array data
            $data['login_icon'] = $loginNewName;
        }

        $model->edit('setting', $data, $where);

        // Optionally set a flash message here
        return redirect()->to('home/setting');
    }

    
}
