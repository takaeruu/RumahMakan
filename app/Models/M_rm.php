<?php

namespace App\Models;

use CodeIgniter\Model;

class M_rm extends Model
{

    public function tambah($table, $isi)
    {
        return $this->db->table($table)
            ->insert($isi);
    }
public function tampil($yoga)
    {
        return $this->db->table($yoga)
            ->get()
            ->getResult();
    }

    public function tampilrestore($yoga)
    {
        return $this->db->table($yoga)
            ->where('deleted_at IS NOT NULL') // Menambahkan kondisi deleted_at IS NOT NULL
            ->get()
            ->getResult();
    }

    public function tampilActive($tableName)
{
    return $this->db->table($tableName)
        ->where('deleted_at', null) // Filtering records where deleted_at is null
        ->get()
        ->getResult();
}

public function getAllUsers()
{
    // Fetch all users for the dropdown filter
    return $this->db->table('user')->select('id_user, username')->get()->getResultArray();
}

public function getLogsByUser($userId)
    {
        $builder = $this->db->table('user_activity');
        $builder->join('user', 'user.id_user = user_activity.id_user');
        $builder->select('user_activity.*, user.username');
        $builder->where('user_activity.id_user', $userId);  // Filter by user ID
        $builder->orderBy('time', 'DESC');
        
        $query = $builder->get();
    
        if ($query === false) {
            $error = $this->db->error();
            log_message('error', 'Query error: ' . $error['message']);
            return [];
        }
    
        return $query->getResultArray();
    }

    public function getLogs()
{
    $builder = $this->db->table('user_activity');  // Pastikan nama tabel benar
    $builder->join('user', 'user.id_user = user_activity.id_user');
    $builder->select('user_activity.*, user.username');
    $builder->orderBy('time', 'DESC');
    
    $query = $builder->get();

    if ($query === false) {
        // Log the error for debugging
        $error = $this->db->error();
        log_message('error', 'Query error: ' . $error['message']);
        return [];
    }

    return $query->getResultArray();
}

public function logActivity($data)
{
    return $this->db->table('user_activity')->insert($data);
}
public function saveToBackup($table, $data)
    {
        return $this->db->table($table)->insert($data);
    }

    public function restoreProduct($mainTable, $column, $id, $data)
{
    if ($data) {
        // Restore data in the main table
        $updated = $this->db->table($mainTable)->where($column, $id)->update($data);
        return $updated; // Pastikan ada return value
    }
    return false; // Jika $data kosong, return false
}

        public function getBackupData1($table, $id)
    {
        // Fetch the backup data for the given ID
        return $this->db->table($table)->where('id_menu', $id)->get()->getRowArray();
    }
    public function deleteBackupData($table, $column, $id)
{
    return $this->db->table($table)->where($column, $id)->delete();
}

    
    public function backupData($mainTable, $id) {
        // Fetch the current data from the main table
        $currentData = $this->db->table($mainTable)->where('id_menu', $id)->get()->getRowArray();
        
        if ($currentData) {
            // Insert the current data into the backup table
            $this->db->table('menu_backup')->insert($currentData);
        }
    }
    

    
    public function getWhere1($table, $where)
    {
        return $this->db->table($table)->where($where)->get();
    }
    public function getWhere($tabel,$where){
        return $this->db->table($tabel)
                        ->getwhere($where)
                        ->getRow();
    }
    public function getWhere2($table, $where)
    {
        return $this->db->table($table)->where($where)->get()->getRow();  // Mengambil single row
    }

    public function join($tabel1, $tabel2, $on)
    {
        return $this->db->table($tabel1)
            ->join($tabel2, $on, 'inner')
            ->get()
            ->getResult();
    }


    public function restoreFromBackup($id_menu)
    {
        // Ambil data dari tabel menu_backup berdasarkan id_menu
        $backupData = $this->db->table('menu_backup')->where('id_menu', $id_menu)->get()->getRowArray();

        if (!$backupData) {
            return false; // Data tidak ditemukan
        }

        // Hapus data di menu jika ada
        $this->where('id_menu', $id_menu)->delete();

        // Masukkan data dari menu_backup ke menu
        $backupData['deleted_at'] = null; // Pastikan deleted_at kosong
        $backupData['deleted_by'] = null; // Pastikan deleted_by kosong
        $backupData['updated_at'] = date('Y-m-d H:i:s'); // Waktu sekarang
        $backupData['updated_by'] = session()->get('user_id'); // Ganti dengan id user yang sesuai

        return $this->insert($backupData);
    }

   

    protected $table = 'menu';
    public function getLastMenu()
    {
        return $this->orderBy('kode_menu', 'DESC')
                    ->limit(1)
                    ->get()
                    ->getRowArray();
    }

    public function getAllKategori()
    {
        return $this->db->table('kategori')->get()->getResult();  // Mengembalikan array objek
    }


    public function edit($tabel, $isi, $where)
    {
        return $this->db->table($tabel)
            ->update($isi, $where);
    }

    public function joinresult($pil,$tabel1,$on,$where)
    {
        return $this->db->table($pil)
                        ->join($tabel1,$on,"right")
                        ->getWhere($where)->getResult();
                        // return $this->db->query('select * from brg_msk join barang on brg_msk.id_brg=barang.id_brg')
                        // ->getResult();
    }

    public function tampil1($table, $startDate = null, $endDate = null) {
        $builder = $this->db->table($table);
    
        if ($startDate && $endDate) {
            // Menggunakan fungsi DATE() untuk membandingkan hanya tanggal
            return $builder
                ->where('DATE(tanggal) >=', $startDate)
                ->where('DATE(tanggal) <=', $endDate)
                ->get()->getResult();
        }
    
        return $builder->get()->getResult();
    }
    public function tampilWithPagination($table, $startDate = null, $endDate = null, $limit = 20, $offset = 0) {
        $builder = $this->db->table($table);
    
        if ($startDate && $endDate) {
            return $builder
            ->where('DATE(tanggal) >=', $startDate)
            ->where('DATE(tanggal) <=', $endDate)
                ->limit($limit, $offset)
                ->get()->getResult();
        }
    
        return $builder->limit($limit, $offset)->get()->getResult();
    }
    
    public function countData($table, $startDate = null, $endDate = null) {
        $builder = $this->db->table($table);
    
        if ($startDate && $endDate) {
            return $builder
                ->where('tanggal >=', $startDate)
                ->where('tanggal <=', $endDate)
                ->countAllResults();
        }
    
        return $builder->countAllResults();
    }
        
    public function getDataProduksi($tanggalAwal, $tanggalAkhir)
    {
        return $this->where('tanggal >=', $tanggalAwal)
                    ->where('tanggal <=', $tanggalAkhir)
                    ->findAll(); // Mengambil semua data berdasarkan tanggal
    }

    
    public function getAllModalData() {
        return $this->db->table('modal')
                        ->select('id_modal, deskripsi, jumlah, satuan, harga_satuan, (jumlah * harga_satuan) as total_bahan')
                        ->get()
                        ->getResultArray();
    }

    public function getAllPenjualanData() {
        return $this->db->table('penjualan_produk')
            ->select('penjualan_produk.id_penjualan_produk, 
                      penjualan_produk.tanggal, 
                      penjualan_produk.jumlah_jual, 
                      penjualan_produk.harga_satuan, 
                      (penjualan_produk.jumlah_jual * penjualan_produk.harga_satuan) as total, 
                      menu.nama_menu') // Include the nama_menu from the menu table
            ->join('menu', 'penjualan_produk.id_menu = menu.id_menu', 'left') // Using left join for safety
            ->get()
            ->getResultArray();
    }
    public function getAllPengeluaranData() {
        return $this->db->table('pengeluaran')
            ->select('id_pengeluaran, tanggal, nama_pengeluaran, total_pengeluaran')
            ->get()
            ->getResultArray();
    }
        
            
    // Di M_rm.php (Model)
    public function getFinancialData($month = null, $year = null) 
    {
        $builder = $this->db->table('laporan_keuangan');
        $builder->select('
            COALESCE(SUM(total_penjualan), 0) as total_penjualan,
            COALESCE(SUM(beban), 0) as beban,
            COALESCE(SUM(laba_bersih), 0) as laba_bersih
        ');
        
        if ($month && $year) {
            $builder->where('MONTH(tanggal)', $month);
            $builder->where('YEAR(tanggal)', $year);
        }
        
        $result = $builder->get()->getResultArray();
        
        return $result;
    }
    
    public function getAll($table)
{
    return $this->db->table($table)->get()->getResult();
}


public function hapus($table, $where)
    {
        return $this->db->table($table)
            ->delete($where);
    }

}