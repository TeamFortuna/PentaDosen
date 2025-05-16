<?php

namespace App\Controllers;

use App\Models\HkiModel;
use App\Models\UserModel;
use CodeIgniter\Controller;

class HkiController extends BaseController
{
    protected $hkiModel;
    protected $userModel;

    public function __construct()
    {
        $this->hkiModel = new HkiModel();
        $this->userModel = new UserModel();
    }

    public function showhki()
    {
        // Cek session login terlebih dahulu
        if (!session()->get('logged_in')) {
            return redirect()->to('login')->with('error', 'Silakan login terlebih dahulu');
        }

        $data['users'] = $this->userModel->findAll();

        // Ambil user ID dari session
        $userId = session()->get('id');
        
        // Debug untuk melihat user_id
        log_message('debug', 'User ID from session: ' . $userId);

        // Ambil data HKI berdasarkan user yang login
        $data['hkis'] = $this->hkiModel->getHkiWithUsersByUser($userId);
        log_message('debug', 'Filtering HKI for user ID: ' . $userId);
        log_message('debug', 'Number of HKI found: ' . count($data['hkis']));

        // Tambahkan data user untuk debug
        $data['debug'] = [
            'user_id' => $userId,
            'logged_in' => session()->get('logged_in'),
            'session_data' => session()->get()
        ];

        return view('hki', $data);
    }

    public function save()
    {
        try {
            // Logging awal
            log_message('debug', '[HKIController::save] Memulai proses simpan HKI');

            // Log isi $_FILES
            log_message('debug', 'Isi $_FILES: ' . print_r($_FILES, true));
            log_message('debug', 'Temp dir: ' . sys_get_temp_dir());

            // Validasi input
            if (!$this->validate([
                'judul' => 'required',
                'nomor_permohonan' => 'required',
                'tanggal_permohonan' => 'required|valid_date',
                'file_hki' => 'uploaded[file_hki]|max_size[file_hki,10240]|ext_in[file_hki,pdf,doc,docx]'
            ])) {
                $errors = $this->validator->getErrors();
                log_message('debug', 'Validation errors: ' . json_encode($errors));
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => $errors
                ]);
            }

            // Ambil file
            $fileHki = $this->request->getFile('file_hki');

            // Validasi file
            if (!$fileHki || !$fileHki->isValid()) {
                $error = $fileHki ? $fileHki->getErrorString() : 'File tidak ditemukan';
                log_message('debug', 'File HKI tidak valid: ' . $error);
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'File HKI tidak valid: ' . $error
                ]);
            }

            // Debug info file
            log_message('debug', 'Nama asli: ' . $fileHki->getClientName());
            log_message('debug', 'Tipe mime: ' . $fileHki->getClientMimeType());
            log_message('debug', 'Ukuran: ' . $fileHki->getSize());
            log_message('debug', 'Tipe valid? ' . ($fileHki->isValid() ? 'ya' : 'tidak'));

            // Siapkan nama dan path
            $fileName = $fileHki->getRandomName();
            $filePath = $fileHki->getTempName();

            // Upload ke GCS
            $storage = new \Google\Cloud\Storage\StorageClient();
            $bucketName = 'pentadosen-bucket';
            $bucket = $storage->bucket($bucketName);
            $folder = 'hki';
            $objectName = $folder . '/' . $fileName;

            $bucket->upload(
                fopen($filePath, 'r'),
                ['name' => $objectName]
            );
            log_message('debug', 'Upload ke GCS berhasil: ' . $objectName);

            // Simpan DB
            $data = [
                'judul' => $this->request->getPost('judul'),
                'nomor_permohonan' => $this->request->getPost('nomor_permohonan'),
                'tanggal_permohonan' => $this->request->getPost('tanggal_permohonan'),
                'file_path' => $objectName,
                'file_url' => 'https://storage.googleapis.com/' . $bucketName . '/' . $objectName,
                'created_by' => session()->get('id')
            ];

            if ($this->hkiModel->insert($data)) {
                log_message('debug', 'Data HKI berhasil disimpan ke DB');
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'HKI berhasil disimpan'
                ]);
            }

            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Gagal menyimpan data HKI'
            ]);

        } catch (\Exception $e) {
            log_message('error', '[HKIController::save] Exception: ' . $e->getMessage());
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }




    public function delete($id)
    {
        $hki = $this->hkiModel->find($id);
        if (!$hki) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Data HKI tidak ditemukan'
            ]);
        }

        // Hapus file jika ada
        if (!empty($hki['file_path']) && file_exists($hki['file_path'])) {
            @unlink($hki['file_path']);
        }

        try {
            $this->hkiModel->delete($id);
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Data HKI berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Gagal menghapus data HKI: ' . $e->getMessage()
            ]);
        }
    }

    public function detail($id)
    {
        $hki = $this->hkiModel
            ->select('hki.*, pencipta.nama as nama_pencipta, pemegang.nama as nama_pemegang')
            ->join('users as pencipta', 'pencipta.id = hki.pencipta_id')
            ->join('users as pemegang', 'pemegang.id = hki.pemegang_id')
            ->where('hki.id', $id)
            ->first();

        if (!$hki) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Data HKI tidak ditemukan'
            ]);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'data' => $hki
        ]);
    }
}
