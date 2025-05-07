<?php

namespace App\Controllers;

use App\Models\HkiModel;
use App\Models\UserModel;

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
        $data['users'] = $this->userModel->findAll();
        $data['hkis'] = $this->hkiModel->getHkiWithUsers();
        return view('hki', $data);
    }

    public function save()
    {
        $id = $this->request->getPost('id');
        $isUpdate = !empty($id);

        // Validasi input
        $rules = [
            'judul' => 'required',
            'jenis' => 'required',
            'nomor_permohonan' => 'required',
            'tanggal_permohonan' => 'required|valid_date',
            'tempat_diumumkan' => 'required',
            'tanggal_diumumkan' => 'required|valid_date',
            'status' => 'required',
            'pencipta_id' => 'required|numeric',
            'pemegang_id' => 'required|numeric',
        ];

        // Untuk tambah, file wajib. Untuk edit, file opsional.
        if ($isUpdate) {
            if ($this->request->getFile('file')->isValid() && !$this->request->getFile('file')->hasMoved()) {
                $rules['file'] = 'uploaded[file]|max_size[file,10240]|ext_in[file,pdf,doc,docx,jpg,jpeg,png]';
            }
        } else {
            $rules['file'] = 'uploaded[file]|max_size[file,10240]|ext_in[file,pdf,doc,docx,jpg,jpeg,png]';
        }

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => $this->validator->getErrors()
            ]);
        }

        // Siapkan data untuk disimpan
        $data = [
            'judul' => $this->request->getPost('judul'),
            'jenis' => $this->request->getPost('jenis'),
            'nomor_permohonan' => $this->request->getPost('nomor_permohonan'),
            'tanggal_permohonan' => $this->request->getPost('tanggal_permohonan'),
            'tempat_diumumkan' => $this->request->getPost('tempat_diumumkan'),
            'tanggal_diumumkan' => $this->request->getPost('tanggal_diumumkan'),
            'nomor_pencatatan' => $this->request->getPost('nomor_pencatatan'),
            'status' => $this->request->getPost('status'),
            'pencipta_id' => $this->request->getPost('pencipta_id'),
            'pemegang_id' => $this->request->getPost('pemegang_id'),
        ];

        // Handle file upload
        $file = $this->request->getFile('file');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $fileName = $file->getRandomName();
            $file->move('uploads/hki', $fileName);
            $data['file_path'] = 'uploads/hki/' . $fileName;

            // Jika update, hapus file lama
            if ($isUpdate) {
                $old = $this->hkiModel->find($id);
                if ($old && !empty($old['file_path']) && file_exists($old['file_path'])) {
                    @unlink($old['file_path']);
                }
            }
        } else if ($isUpdate) {
            // Jika tidak upload file baru saat edit, jangan ubah file_path
            unset($data['file_path']);
        }

        try {
            if ($isUpdate) {
                $this->hkiModel->update($id, $data);
                $msg = 'Data HKI berhasil diperbarui';
            } else {
                $this->hkiModel->insert($data);
                $msg = 'Data HKI berhasil disimpan';
            }
            return $this->response->setJSON([
                'status' => 'success',
                'message' => $msg
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Gagal menyimpan data HKI: ' . $e->getMessage()
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
