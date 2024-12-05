<?php

namespace App\Controllers;

use App\Models\Publikasi_Model;
use App\Models\Intersection_Dosen_Publikasi;
use App\Models\Dosen_Penulis_Model;
use App\Models\RegisterLogin_Model;

class PublikasiController extends BaseController
{

    public function publikasi()
    {
        $userModel = new RegisterLogin_Model();
        $publikasiModel = new Publikasi_Model();
        $id_dosen = session()->get('user_id');
        $publikasiFinalUser = $publikasiModel->getPublikasiWithPenulisForUser($id_dosen);
        $publikasiFinalAdmin = $publikasiModel->getPublikasiWithPenulisForAdmin();
        $dataDosen = $userModel->select('nama, nidn')->findAll();
        return view('publikasi', [
            'dataDosen' => $dataDosen,
            'publikasiFU' => $publikasiFinalUser,
            'publikasiFA' => $publikasiFinalAdmin
        ]);
    }

    public function uploadPublikasi()
    {

        $validation = \Config\Services::validation();
        $valid = $this->validate([
            'judulPublikasi' => [
                'rules' => 'required|min_length[6]',
                'errors' => [
                    'required' => 'Judul Publikasi tidak boleh kosong !',
                    'min_length' => 'Judul Publikasi minimal 6 karakter !',
                ],
            ],
            'tanggalTerbit' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tanggal Terbit tidak boleh kosong !',
                ],
            ],
            'jumlahHalaman' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Jumlah Halaman tidak boleh kosong !',
                ],
            ],
            'penerbit' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Penerbit tidak boleh kosong !',
                ],
            ],
            'isbn' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'ISBN tidak boleh kosong !',
                ],
            ],
            'penulisDosen' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Dosen Penulis tidak boleh kosong !',
                ],
            ],
            'berkasPublikasi' => [
                'rules' => 'uploaded[berkasPublikasi]|max_size[berkasPublikasi,10048]|ext_in[berkasPublikasi,pdf]',
                'errors' => [
                    'uploaded' => 'File Tidak Boleh Kosong!',
                    'max_size' => 'Ukuran File Terlalu Besar!',
                    'ext_in' => 'File Harus Berformat PDF!',
                ],
            ],
        ]);

        if (!$valid) {
            session()->setFlashdata('errJudul', $validation->getError('judulPublikasi'));
            session()->setFlashdata('errTGlTerbt', $validation->getError('tanggalTerbit'));
            session()->setFlashdata('errJumlahHal', $validation->getError('jumlahHalaman'));
            session()->setFlashdata('errPenerbit', $validation->getError('penerbit'));
            session()->setFlashdata('errISBN', $validation->getError('isbn'));
            session()->setFlashdata('errDosenPenulis', $validation->getError('penulisDosen'));
            session()->setFlashdata('errBerkasPublikasi', $validation->getError('berkasPublikasi'));
            session()->setFlashdata('errPublikasi', 'Data yang Anda kirim ada yang salah !');
            return redirect()->back()->withInput();
        }

        $userModel = new RegisterLogin_Model();
        $publikasiModel = new Publikasi_Model();
        $id_dosen_publikasi = new Intersection_Dosen_Publikasi();
        $dosenPenulis = new Dosen_Penulis_Model();
        $file = $this->request->getFile('berkasPublikasi');
        $pattern = '/^.+\s-\s\d+$/'; // Pola untuk "Nama - NIDN"

        foreach ($this->request->getPost('penulisDosen') as $penulis) {
            if (!preg_match($pattern, $penulis)) {
                session()->setFlashdata('errEmptyDosenPenulis', 'Dosen Yang Anda Input Tidak Valid !');
                return redirect()->back()->withInput();
            }
            list($nama, $nidn) = explode(' - ', $penulis); // Pecah "Nama - NIDN"
            $dosen = $userModel->where('nama', trim($nama))->where('nidn', trim($nidn))->first();
            if (!$dosen) {
                session()->setFlashdata('errEmptyDosenPenulis', 'Dosen Yang Anda Input Tidak Valid !');
                return redirect()->back()->withInput();
            }
        }

        try {
            // Pindahkan file ke folder 'uploads/publikasi'
            $file->move('uploads/publikasi');
            $fileName = $file->getName();
            // Simpan data Publikasi Ke Database
            $publikasiModel->save([
                'kategori_kegiatan' => $this->request->getPost('kategoriKegiatan'),
                'jenis_publikasi' => $this->request->getPost('jenisPublikasi'),
                'judul_publikasi' => $this->request->getPost('judulPublikasi'),
                'tanggal_terbit' => $this->request->getPost('tanggalTerbit'),
                'jumlah_halaman' => $this->request->getPost('jumlahHalaman'),
                'penerbit' => $this->request->getPost('penerbit'),
                'isbn' => $this->request->getPost('isbn'),
                'file_publikasi' => $fileName,
                'tanggal_upload' => date('Y-m-d'),
            ]);
            // Ambil Data ID dari Dosen dan Publikasi
            $publikasi_id = $publikasiModel->getInsertID();
            $id_dosen = session()->get('user_id');
            $penulisDosen = $this->request->getPost('penulisDosen');

            // Jika Data Penulis Lebih Dari Satu
            foreach ($penulisDosen as $dosen) {
                list($nama, $nidn) = explode(' - ', $dosen);
                $dataDosenPenulis = $userModel->where('nama', $nama)->where('nidn', $nidn)->first();
                $penulisData = [
                    'publikasi_id' => $publikasi_id,
                    'nama_penulis' => $nama,
                    'nidn_penulis' => $dataDosenPenulis['nidn'],
                    'jabatan_penulis' => $dataDosenPenulis['jabatan_akademik'],
                    'perguruan_penulis' => $dataDosenPenulis['perguruan_tinggi'],
                    'perguruan_lainnya' => null,
                    'fakultas_penulis'  => $dataDosenPenulis['fakultas'],
                    'fakultas_lainnya'  => null,
                    'prodi_penulis' => $dataDosenPenulis['program_studi'],
                    'prodi_lainnya' => null
                ];
                $dosenPenulis->insert($penulisData);
            }

            // Simpan Data ID Dosen dan ID Publikasi ke Tabel Intersection
            $id_dosen_publikasi->save([
                'dosen_id' => $id_dosen,
                'publikasi_id' => $publikasi_id
            ]);

            // Lempar Jika Berhasil
            session()->setFlashdata('success', 'Publikasi Berhasil Diupload !');
            return redirect()->to('publikasi')->with('success', 'Publikasi berhasil diunggah!');
        } catch (\Exception $e) {
        }
    }
}
