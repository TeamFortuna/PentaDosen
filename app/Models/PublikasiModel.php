<?php

namespace App\Models;

use CodeIgniter\Model;

class PublikasiModel extends Model
{
    protected $table = 'publikasi';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'judul',
        'kategori',
        'jenis',
        'tanggal_terbit',
        'jumlah_halaman',
        'penerbit',
        'isbn',
        'file_path',
        'file_size',
        'created_by'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Dapatkan publikasi berdasarkan ID user (baik sebagai penulis atau pembuat)
    public function getPublikasiByDosen($userId)
    {
        $builder = $this->db->table('publikasi');
        $builder->select('publikasi.*, GROUP_CONCAT(DISTINCT users.nama SEPARATOR ", ") as penulis, creator.nama as creator_name')
            ->join('publikasi_penulis', 'publikasi_penulis.publikasi_id = publikasi.id', 'left')
            ->join('users', 'users.id = publikasi_penulis.dosen_id', 'left')
            ->join('users as creator', 'creator.id = publikasi.created_by', 'left')
            ->groupBy('publikasi.id')
            ->where('publikasi.created_by', $userId)
            ->orWhere('publikasi_penulis.dosen_id', $userId);

        return $builder->get()->getResultArray();
    }

    // Tambahkan publikasi beserta penulisnya
    public function addPublikasiWithPenulis($dataPublikasi, $penulisIds)
    {
        $this->db->transStart();

        // Simpan data publikasi
        $this->insert($dataPublikasi);
        $publikasiId = $this->insertID();

        // Simpan relasi penulis
        $penulisData = [];
        foreach ($penulisIds as $dosenId) {
            $penulisData[] = [
                'publikasi_id' => $publikasiId,
                'dosen_id' => $dosenId
            ];
        }

        if (!empty($penulisData)) {
            $this->db->table('publikasi_penulis')->insertBatch($penulisData);
        }

        $this->db->transComplete();

        return $this->db->transStatus();
    }

    // Update publikasi beserta penulisnya
    public function updatePublikasiWithPenulis($id, $dataPublikasi, $penulisIds = null)
    {
        $this->db->transStart();

        try {
            // Update data publikasi hanya jika ada perubahan
            if (!empty($dataPublikasi)) {
                $this->update($id, $dataPublikasi);
            }

            // Update penulis hanya jika diisi
            if ($penulisIds !== null) {
                // Hapus semua relasi penulis yang ada
                $this->db->table('publikasi_penulis')->where('publikasi_id', $id)->delete();

                // Tambahkan kembali penulis
                $penulisData = [];
                foreach ($penulisIds as $dosenId) {
                    $penulisData[] = [
                        'publikasi_id' => $id,
                        'dosen_id' => $dosenId
                    ];
                }

                if (!empty($penulisData)) {
                    $this->db->table('publikasi_penulis')->insertBatch($penulisData);
                }
            }

            $this->db->transComplete();

            return $this->db->transStatus();
        } catch (\Exception $e) {
            $this->db->transRollback();
            log_message('error', 'Error in updatePublikasiWithPenulis: ' . $e->getMessage());
            return false;
        }
    }

    // Hapus publikasi beserta relasi penulisnya
    public function deletePublikasiWithPenulis($id)
    {
        $this->db->transStart();

        // Hapus relasi penulis
        $this->db->table('publikasi_penulis')->where('publikasi_id', $id)->delete();

        // Hapus publikasi
        $this->delete($id);

        $this->db->transComplete();

        return $this->db->transStatus();
    }

    // Dapatkan daftar penulis untuk publikasi tertentu
    public function getPenulisByPublikasi($publikasiId)
    {
        return $this->db->table('publikasi_penulis')
            ->select('users.id, users.nama')
            ->join('users', 'users.id = publikasi_penulis.dosen_id')
            ->where('publikasi_penulis.publikasi_id', $publikasiId)
            ->get()
            ->getResultArray();
    }

    public function getAllPublikasiWithPenulis()
    {
        return $this->db->table('publikasi')
            ->select('publikasi.*, GROUP_CONCAT(users.nama SEPARATOR ", ") as penulis, creator.nama as creator_name')
            ->join('publikasi_penulis', 'publikasi_penulis.publikasi_id = publikasi.id', 'left')
            ->join('users', 'users.id = publikasi_penulis.dosen_id', 'left')
            ->join('users as creator', 'creator.id = publikasi.created_by', 'left')
            ->groupBy('publikasi.id')
            ->get()
            ->getResultArray();
    }

    public function isUserPenulis($publikasiId, $userId)
    {
        return $this->db->table('publikasi_penulis')
            ->where('publikasi_id', $publikasiId)
            ->where('dosen_id', $userId)
            ->countAllResults() > 0;
    }
}
