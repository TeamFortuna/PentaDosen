<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\PenelitianModel;
use App\Models\AnggotaPenelitianModel;
use CodeIgniter\Controller;

class PenelitianController extends Controller
{
    protected $userModel;
    protected $penelitianModel;
    protected $anggotaPenelitianModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->penelitianModel = new PenelitianModel();
        $this->anggotaPenelitianModel = new AnggotaPenelitianModel();
    }

    public function showpenelitian()
    {
        $data['user'] = [
            'id' => session()->get('id'),
            'nama' => session()->get('nama'),
            'nidn' => session()->get('nidn'),
            'nip' => session()->get('nip'),
            'jabatan' => session()->get('jabatan'),
            'universitas' => session()->get('universitas'),
            'fakultas' => session()->get('fakultas'),
            'jurusan' => session()->get('jurusan'),
            'email' => session()->get('email'),
        ];

        $data['users'] = $this->userModel->where('id !=', session()->get('id'))->findAll();
        
        // Ambil data penelitian dengan join ke tabel users untuk mendapatkan nama ketua
        $data['penelitian'] = $this->penelitianModel
            ->select('penelitian.*, users.nama as ketua_nama, COUNT(anggota_penelitian.id) as jumlah_anggota')
            ->join('users', 'users.id = penelitian.ketua_id')
            ->join('anggota_penelitian', 'anggota_penelitian.penelitian_id = penelitian.id', 'left')
            ->where('penelitian.ketua_id', session()->get('id'))
            ->groupBy('penelitian.id')
            ->findAll();

        return view('penelitian', $data);
    }

    public function save()
    {
        try {
            // Validasi input
            if (!$this->validate([
                'judul' => 'required',
                'skema' => 'required',
                'sumber_dana' => 'required',
                'biaya_diusulkan' => 'required|numeric',
                'biaya_didanai' => 'required|numeric',
                'file_proposal' => 'uploaded[file_proposal]|mime_in[file_proposal,application/pdf]|max_size[file_proposal,10240]'
            ])) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => $this->validator->getErrors()
                ]);
            }

            // Ambil file proposal dari request
            $fileProposal = $this->request->getFile('file_proposal');
            if (!$fileProposal->isValid()) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'File proposal tidak valid: ' . $fileProposal->getErrorString()
                ]);
            }

            // Nama file random dan path temporary
            $fileName = $fileProposal->getRandomName();
            $filePath = $fileProposal->getTempName();

            // Nama bucket GCS (sesuaikan dengan bucket kamu)
            $bucketName = 'pentadosen-bucket';

            // Inisialisasi Google Cloud Storage tanpa putenv (Cloud Run otomatis handle)
            $storage = new \Google\Cloud\Storage\StorageClient();

            // Ambil bucket dari StorageClient
            $bucket = $storage->bucket($bucketName);

            // Upload file proposal ke bucket GCS dengan path 'penelitian/filename'
            $bucket->upload(
                fopen($filePath, 'r'),
                ['name' => 'penelitian/' . $fileName]
            );

            // Buat URL file yang diupload
            $fileUrl = 'https://storage.googleapis.com/' . $bucketName . '/penelitian/' . $fileName;

            // Data penelitian untuk disimpan ke DB
            $dataPenelitian = [
                'judul' => $this->request->getPost('judul'),
                'ketua_id' => session()->get('id'),
                'skema' => $this->request->getPost('skema'),
                'sumber_dana' => $this->request->getPost('sumber_dana'),
                'biaya_diusulkan' => $this->request->getPost('biaya_diusulkan'),
                'biaya_didanai' => $this->request->getPost('biaya_didanai'),
                'status' => 'submitted',
                'tanggal' => date('Y-m-d'),
                'file_proposal' => $fileUrl // simpan URL file proposal
            ];

            // Insert ke database menggunakan model penelitian
            $penelitianId = $this->penelitianModel->insert($dataPenelitian);
            if (!$penelitianId) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Gagal menyimpan data penelitian'
                ]);
            }

            // TODO: Simpan anggota internal dan eksternal sesuai kebutuhan kamu di sini

            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Penelitian berhasil disimpan'
            ]);
        } catch (\Exception $e) {
            log_message('error', '[PenelitianController::save] ' . $e->getMessage());
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }

    public function update($id)
    {
        // Validasi input
        $validationRules = [
            'judul' => 'required',
            'skema' => 'required',
            'sumber_dana' => 'required',
            'biaya_diusulkan' => 'required|numeric',
            'biaya_didanai' => 'required|numeric'
        ];

        if (!$this->validate($validationRules)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => $this->validator->getErrors()
            ]);
        }

        // Update data penelitian
        $dataPenelitian = [
            'judul' => $this->request->getPost('judul'),
            'skema' => $this->request->getPost('skema'),
            'sumber_dana' => $this->request->getPost('sumber_dana'),
            'biaya_diusulkan' => $this->request->getPost('biaya_diusulkan'),
            'biaya_didanai' => $this->request->getPost('biaya_didanai')
        ];

        // Upload file proposal baru ke GCS jika ada
        $fileProposal = $this->request->getFile('file_proposal');
        if ($fileProposal && $fileProposal->isValid()) {
            $fileName = $fileProposal->getRandomName();
            $filePath = $fileProposal->getTempName();

            // Inisialisasi GCS
            putenv('GOOGLE_APPLICATION_CREDENTIALS=C:\\cloudsql\\duk-cloud-cd3821dca7b2.json');
            $storage = new \Google\Cloud\Storage\StorageClient();
            $bucketName = 'pentadosen-bucket'; // ganti dengan nama bucket di GCS
            $bucket = $storage->bucket($bucketName);

            // Upload file baru ke GCS
            $bucket->upload(
                fopen($filePath, 'r'),
                ['name' => 'penelitian/' . $fileName]
            );

            // Update URL file_proposal dengan yang baru
            $dataPenelitian['file_proposal'] = 'https://storage.googleapis.com/' . $bucketName . '/penelitian/' . $fileName;

            // Hapus file proposal lama dari GCS (jika ada)
            $penelitian = $this->penelitianModel->find($id);
            if ($penelitian && isset($penelitian['file_proposal'])) {
                $oldFilePath = str_replace('https://storage.googleapis.com/', '', $penelitian['file_proposal']);
                $bucket->object($oldFilePath)->delete();
            }
        }

        $this->penelitianModel->update($id, $dataPenelitian);

        // Update anggota internal dan eksternal (seperti yang ada di kode Anda)

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Penelitian berhasil diperbarui'
        ]);
    }


    public function delete($id)
    {
        // Cek apakah penelitian ada
        $penelitian = $this->penelitianModel->find($id);
        if (!$penelitian) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Penelitian tidak ditemukan'
            ]);
        }

        // Hapus file-file terkait jika ada
        if ($penelitian['file_proposal']) {
            $proposalPath = FCPATH . 'uploads/proposal/' . $penelitian['file_proposal'];
            if (file_exists($proposalPath)) {
                unlink($proposalPath);
            }
        }
        if ($penelitian['file_laporan_kemajuan']) {
            $laporanKemajuanPath = FCPATH . 'uploads/laporan/' . $penelitian['file_laporan_kemajuan'];
            if (file_exists($laporanKemajuanPath)) {
                unlink($laporanKemajuanPath);
            }
        }
        if ($penelitian['file_laporan_akhir']) {
            $laporanAkhirPath = FCPATH . 'uploads/laporan/' . $penelitian['file_laporan_akhir'];
            if (file_exists($laporanAkhirPath)) {
                unlink($laporanAkhirPath);
            }
        }

        // Hapus data anggota penelitian
        $this->anggotaPenelitianModel->where('penelitian_id', $id)->delete();

        // Hapus penelitian
        $this->penelitianModel->delete($id);

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Penelitian berhasil dihapus'
        ]);
    }

    public function uploadLaporan($id)
    {
        $type = $this->request->getPost('type'); // 'progress' atau 'final'
        $file = $this->request->getFile('file');

        if (!$file || !$file->isValid()) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'File tidak valid'
            ]);
        }

        if ($file->getSize() > 10240 * 1024) { // 10MB
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Ukuran file maksimal 10MB'
            ]);
        }

        if ($file->getClientMimeType() !== 'application/pdf') {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Hanya file PDF yang diizinkan'
            ]);
        }

        $fileName = $file->getRandomName();
        $file->move('uploads/laporan', $fileName);

        $data = [];
        if ($type === 'progress') {
            $data['file_laporan_kemajuan'] = $fileName;
        } else {
            $data['file_laporan_akhir'] = $fileName;
        }

        $this->penelitianModel->update($id, $data);

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Laporan berhasil diupload'
        ]);
    }

    public function getDetail($id)
    {
        $penelitian = $this->penelitianModel->find($id);
        if (!$penelitian) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Penelitian tidak ditemukan'
            ]);
        }

        // Ambil data ketua penelitian
        $ketua = $this->userModel->find($penelitian['ketua_id']);
        $penelitian['ketua'] = $ketua;

        // Ambil data anggota penelitian
        $anggota = $this->anggotaPenelitianModel->where('penelitian_id', $id)->findAll();
        $penelitian['anggota'] = $anggota;

        return $this->response->setJSON([
            'status' => 'success',
            'data' => $penelitian
        ]);
    }
}
