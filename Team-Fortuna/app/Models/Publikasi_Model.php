<?php

namespace App\Models;

use CodeIgniter\Model;

class Publikasi_Model extends Model
{
    protected $table = 'publikasi';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'kategori_kegiatan',
        'jenis_publikasi',
        'judul_publikasi',
        'tanggal_terbit',
        'jumlah_halaman',
        'penerbit',
        'isbn',
        'penulis_dosen',
        'file_publikasi',
        'tanggal_upload',
        'created_at',
        'updated_at'
    ];
    protected $useTimestamps = true; // Aktifkan fitur timestamps otomatis

    public function getPublikasiWithPenulisForUser($id_dosen)
{
    return $this->select('publikasi.*, akundosen.*, id_dosen_publikasi.*, 
                          GROUP_CONCAT(dosen_penulis.nama_penulis SEPARATOR ", ") AS nama_penulis')
                ->join('id_dosen_publikasi', 'id_dosen_publikasi.publikasi_id = publikasi.id', 'left')
                ->join('akundosen', 'akundosen.id = id_dosen_publikasi.dosen_id', 'left')
                ->join('dosen_penulis', 'dosen_penulis.publikasi_id = publikasi.id', 'left')
                ->where('akundosen.id', $id_dosen)
                ->groupBy('publikasi.id')
                ->findAll();
}

public function getPublikasiWithPenulisForAdmin()
{
    return $this->select('publikasi.*, akundosen.*, id_dosen_publikasi.*, 
                          GROUP_CONCAT(dosen_penulis.nama_penulis SEPARATOR ", ") AS nama_penulis')
                ->join('id_dosen_publikasi', 'id_dosen_publikasi.publikasi_id = publikasi.id', 'left')
                ->join('akundosen', 'akundosen.id = id_dosen_publikasi.dosen_id', 'left')
                ->join('dosen_penulis', 'dosen_penulis.publikasi_id = publikasi.id', 'left')
                ->groupBy('publikasi.id')
                ->findAll();
}


}
