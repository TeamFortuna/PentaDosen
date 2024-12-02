<?php

namespace App\Controllers;
use App\Models\HAKI_Model;
use App\Models\Intersection_Dosen_HAKI;
use App\Models\Dosen_Pencipta_Model;
use App\Models\Dosen_Pemegang_Model;
use App\Models\RegisterLogin_Model;

class HakiController extends BaseController
{

    public function Haki()
    {
        $userModel = new RegisterLogin_Model();
        $hakiModel = new HAKI_Model();
        $id_dosen = session()->get('user_id');
        $hakiFinalUser = $hakiModel->getHakiWithPenciptaAndPemegangForUser($id_dosen);
        $hakiFinalAdmin = $hakiModel->getHakiWithPenciptaAndPemegangForAdmin();
        $dataDosen = $userModel->select('nama, nidn')->findAll();
        return view('haki', [
            'dataDosenPP' => $dataDosen,
            'hakiFU' => $hakiFinalUser,
            'hakiFA' => $hakiFinalAdmin
        ]);
    }

    public function uploadHAKI() {
        
        $validation = \Config\Services::validation();
        $valid = $this->validate([
            'judulCiptaan' => [
                'rules' => 'required|min_length[6]',
                'errors' => [
                    'required' => 'Judul Ciptaan tidak boleh kosong !',
                    'min_length' => 'Judul Ciptaan minimal 6 karakter !',
                ],
            ],
            'jenisCiptaan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Jenis Ciptaan tidak boleh kosong !',
                ],
            ],
            'nomorPermohonan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nomor Permohonan tidak boleh kosong !',
                ],
            ],
            'tanggalPermohonan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tanggal Permohonan tidak boleh kosong !',
                ],
            ],
            'tanggalDiumumkan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tanggal Diumumkan tidak boleh kosong !',
                ],
            ],
            'tempatDiumumkan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tempat Diumumkan tidak boleh kosong !',
                ],
            ],
            'nomorPencatatan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tempat Diumumkan tidak boleh kosong !',
                ],
            ],
            'statusHaki' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Status Haki tidak boleh kosong !',
                ],
            ],
            'namaPencipta' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama Pencipta tidak boleh kosong !',
                ],
            ],
            'namaPemegang' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama Pemegang tidak boleh kosong !',
                ],
            ],
            'berkasHAKI' => [
                'rules' => 'uploaded[berkasHAKI]|max_size[berkasHAKI,10048]|ext_in[berkasHAKI,pdf]',
                'errors' => [
                    'uploaded' => 'File HAKI Tidak Boleh Kosong!',
                    'max_size' => 'Ukuran File HAKI Terlalu Besar!',
                    'ext_in' => 'File HAKI Harus Berformat PDF!',
                ],
            ],
        ]);

        if (!$valid) {
            session()->setFlashdata('errJudul', $validation->getError('judulCiptaan'));
            session()->setFlashdata('errJenis', $validation->getError('jenisCiptaan'));
            session()->setFlashdata('errNomorP', $validation->getError('nomorPermohonan'));
            session()->setFlashdata('errTGLP', $validation->getError('tanggalPermohonan'));
            session()->setFlashdata('errTGLD', $validation->getError('tanggalDiumumkan'));
            session()->setFlashdata('errTempat', $validation->getError('tempatDiumumkan'));
            session()->setFlashdata('errNomorPC', $validation->getError('nomorPencatatan'));
            session()->setFlashdata('errStatusHAKI', $validation->getError('statusHaki'));
            session()->setFlashdata('errNamaPencipta', $validation->getError('namaPencipta'));
            session()->setFlashdata('errNamaPemegang', $validation->getError('namaPemegang'));
            session()->setFlashdata('errBerkasHAKI', $validation->getError('berkasHAKI'));
            session()->setFlashdata('errHAKI', 'Data yang Anda kirim ada yang salah !');            
            return redirect()->back()->withInput();
        }
        
        $userModel = new RegisterLogin_Model();
        $hakiModel = new HAKI_Model();
        $id_dosen_haki = new Intersection_Dosen_HAKI();
        $dosenPencipta = new Dosen_Pencipta_Model();
        $dosenPemegang = new Dosen_Pemegang_Model();
        $file = $this->request->getFile('berkasHAKI');

        try {
            // Pindahkan file ke folder 'uploads/publikasi'
            $file->move('uploads/HAKI');
            $fileName = $file->getName();
            // Simpan data Publikasi Ke Database
            $hakiModel->save([
                'judul_ciptaan' => $this->request->getPost('judulCiptaan'),
                'jenis_ciptaan' => $this->request->getPost('jenisCiptaan'),
                'nomor_permohonan' => $this->request->getPost('nomorPermohonan'),
                'tanggal_permohonan' => $this->request->getPost('tanggalPermohonan'),
                'tanggal_diumumkan' => $this->request->getPost('tanggalDiumumkan'),
                'tempat_diumumkan' => $this->request->getPost('tempatDiumumkan'),
                'nomor_pencatatan' => $this->request->getPost('nomorPencatatan'),
                'status_haki' => $this->request->getPost('statusHaki'),
                'file_haki' => $fileName,
                'tanggal_upload' => date('Y-m-d'),
            ]);
            // Ambil Data ID dari Dosen dan Publikasi
            $haki_id = $hakiModel->getInsertID();
            $id_dosen = session()->get('user_id');
            $namaPencipta = $this->request->getPost('namaPencipta');
            $namaPemegang = $this->request->getPost('namaPemegang');
            
            // Jika Data Dosen Pencipta Lebih Dari Satu
            foreach ($namaPencipta as $dosenPenciptaI) {
                list($nama, $nidn) = explode(' - ', $dosenPenciptaI);
                $dataDosenPencipta = $userModel->where('nama', $nama)->where('nidn', $nidn)->first();
                $dataPencipta = [
                    'haki_id' => $haki_id,
                    'nama_pencipta' => $nama,
                    'nidn_pencipta' => $dataDosenPencipta['nidn'],
                    'jabatan_pencipta' => $dataDosenPencipta['jabatan_akademik'],
                    'perguruan_pencipta' => $dataDosenPencipta['perguruan_tinggi'],
                    'perguruan_lainnya' => null,
                    'fakultas_pencipta'  => $dataDosenPencipta['fakultas'],
                    'fakultas_lainnya'  => null,
                    'prodi_pencipta' => $dataDosenPencipta['program_studi'],
                    'prodi_lainnya' => null
                ];
                $dosenPencipta->insert($dataPencipta); 
            }

            // Jika Data Dosen Pemegang Lebih Dari Satu
            foreach ($namaPemegang as $dosenPemegangI) {
                list($nama, $nidn) = explode(' - ', $dosenPemegangI);
                $dataDosenPemegang = $userModel->where('nama', $nama)->where('nidn', $nidn)->first();
                $dataPemegang = [
                    'haki_id' => $haki_id,
                    'nama_pemegang' => $nama,
                    'nidn_pemegang' => $dataDosenPemegang['nidn'],
                    'jabatan_pemegang' => $dataDosenPemegang['jabatan_akademik'],
                    'perguruan_pemegang' => $dataDosenPemegang['perguruan_tinggi'],
                    'perguruan_lainnya' => null,
                    'fakultas_pemegang'  => $dataDosenPemegang['fakultas'],
                    'fakultas_lainnya'  => null,
                    'prodi_pemegang' => $dataDosenPemegang['program_studi'],
                    'prodi_lainnya' => null
                ];
                $dosenPemegang->insert($dataPemegang);
            }

            // Simpan Data ID Dosen dan ID HAKI ke Tabel Intersection
            $id_dosen_haki->save([
                'dosen_id' => $id_dosen,
                'haki_id' => $haki_id
            ]);

            // Lempar Jika Berhasil
            session()->setFlashdata('success', 'HAKI Berhasil Diupload !');
            return redirect()->to('haki')->with('success', 'HAKI berhasil diunggah!');
        } catch (\Exception $e) {
          
        }

    }

}
