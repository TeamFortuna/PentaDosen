<?php

namespace App\Controllers;

use App\Database\Migrations\Penelitian;
use App\Models\RegisterLogin_Model;
use App\Models\Intersection_Dosen_Proposal;
use App\Models\Proposal_Model;
use App\Models\Anggota_Model;
use DateTime;
date_default_timezone_set('Asia/Jakarta');

class ProposalPenelitianController extends BaseController
{

    public function ProposalPenelitian()
    {
        if (session()->has('logged_in')) {
            $userModel = new RegisterLogin_Model();
            $proposalModel = new Proposal_Model();
            $userId = session()->get('user_id');
            $userData = $userModel->find($userId);

            // Mengambil data penelitian dari database
            $proposalsFinalFU = $proposalModel->getPenelitianWithDosenAndAnggotaFU($userId);
            $proposalsFinalFA = $proposalModel->getPenelitianWithDosenAndAnggotaFA();

            // Ambil data dosen dari database
            $dataDosen = $userModel->select('nama, nidn')->findAll();

            return view('proposal_penelitian', [
                'userData' => $userData,
                'proposalsFU' => $proposalsFinalFU,
                'proposalsFA' => $proposalsFinalFA,
                'dataDosenPP' => $dataDosen, // Data dosen untuk datalist
            ]);
        } else {
            return redirect()->back();
        }
    }


    public function uploadProposal()
    {
        $validation = \Config\Services::validation();
        $valid = $this->validate([
            'berkas_proposal' => [
                'rules' => 'uploaded[berkas_proposal]|max_size[berkas_proposal,10048]|ext_in[berkas_proposal,pdf]',
                'errors' => [
                    'uploaded' => 'File Tidak Boleh Kosong!',
                    'max_size' => 'Ukuran File Terlalu Besar!',
                    'ext_in' => 'File Harus Berformat PDF!',
                ],
            ]
            // 'nidn_anggota.*' => [
            //     'rules' => 'required|min_length[6]|is_unique[anggota_proposal.nidn_anggota]',
            //     'errors' => [
            //         'required' => 'NIDN tidak boleh kosong.',
            //         'min_length' => 'NIDN harus minimal 6 karakter.',
            //         'is_unique' => 'NIDN sudah terdaftar.',
            //     ],
            // ],
        ]);

        if (!$valid) {
            session()->setFlashdata('errFile', $validation->getError('berkas_proposal'));
            session()->setFlashdata('errProposal', 'Data yang Anda kirim ada yang salah !');
            return redirect()->back()->withInput();
        }

        $file = $this->request->getFile('berkas_proposal');
        $pattern = '/^.+\s-\s\d+$/'; // Pola untuk "Nama - NIDN"
        $userModel = new RegisterLogin_Model();
        $proposalModel = new Proposal_Model();
        $anggotaModel = new Anggota_Model();
        $dosen_id_model = new Intersection_Dosen_Proposal();

        if($this->request->getPost('nama_anggota') != null) {
            foreach ($this->request->getPost('nama_anggota') as $anggota) {
                if (!preg_match($pattern, $anggota)) {
                    session()->setFlashdata('errEmptyDosenAnggota', 'Dosen Yang Anda Input Tidak Valid !');
                    return redirect()->back()->withInput();
                }
                list($nama, $nidn) = explode(' - ', $anggota); // Pecah "Nama - NIDN"
                $dosen = $userModel->where('nama', trim($nama))->where('nidn', trim($nidn))->first();
                if (!$dosen) {
                    session()->setFlashdata('errEmptyDosenAnggota', 'Dosen Yang Anda Input Tidak Valid !');
                    return redirect()->back()->withInput();
                }
            }
        }   
        try {

            // Simpan Data Penelitian Ke Database
            $proposalData = [
                'judul_penelitian' => $this->request->getPost('judulPenelitian'),
                'skema' => $this->request->getPost('skema'),
                'skema_lainnya' => $this->request->getPost('skema_lainnya'),
                'biaya_diusulkan' => str_replace(['Rp.', '.'], '', $this->request->getPost('biayaDiusulkan')),
                'biaya_didanai' => str_replace(['Rp.', '.'], '', $this->request->getPost('biayaDidanai')),
                'sumber_dana' => $this->request->getPost('sumberDana'),
                'dana_lainnya' => $this->request->getPost('dana_lainnya'),
                'file_penelitian' => '',
                'tanggal_upload' => date('Y-m-d')
            ];

            $proposalModel->save($proposalData);
            $penelitian_id = $proposalModel->getInsertID();
            $id_dosen = session()->get('user_id');

            // **Buat nama file sesuai format**
            $newFileName = "{$penelitian_id}_proposal_" . date('Y-m-d') . ".pdf";

            // **Pindahkan file ke server dengan nama baru**
            $file->move('uploads', $newFileName);

            // **Update nama file di database**
            $proposalModel->update($penelitian_id, ['file_penelitian' => $newFileName]);

            // Menyimpan data anggota
            $namaAnggota = $this->request->getPost('nama_anggota');

            if ($this->request->getPost('nama_anggota') != null) {
                foreach ($namaAnggota as $dosen) {
                    list($nama, $nidn) = explode(' - ', $dosen);
                    $dataAnggota = $userModel->where('nama', $nama)->where('nidn', $nidn)->first();
                    $anggotaData = [
                        'penelitian_id' => $penelitian_id,
                        'nama_anggota' => $nama,
                        'nidn_anggota' => $dataAnggota['nidn'],
                        'jabatan_anggota' => $dataAnggota['jabatan_akademik'],
                        'perguruan_anggota' => $dataAnggota['perguruan_tinggi'],
                        'perguruan_lainnya' => null,
                        'fakultas_anggota' => $dataAnggota['fakultas'],
                        'fakultas_lainnya'  => null,
                        'prodi_anggota' => $dataAnggota['program_studi'],
                        'prodi_lainnya' => null

                    ];
                    $anggotaModel->save($anggotaData);
                }
            }    
            // Simpan Data ID Dosen dan ID Penelitian ke Tabel Intersection
            $dosen_id_model->save([
                'dosen_id' => $id_dosen,
                'penelitian_id' => $penelitian_id
            ]);
            
            // Lempar Jika Berhasil

            session()->setFlashdata('success', 'Penelitian Berhasil Diupload !');
            return redirect()->to('proposal_penelitian')->with('success', 'Penelitian berhasil diunggah!');
        } catch (\Exception $e) {
            dd('error');
        }
    }


    public function download($id)
    {
        $proposalModel = new Proposal_Model();
        $nama_file = $proposalModel->find($id);
        return $this->response->download('uploads/' . $nama_file['file_penelitian'], null);
    }

    public function deleteProposal($id)
    {
        $proposalModel = new Proposal_Model();
        $anggotaModel = new Anggota_Model();

        // Hapus data anggota terkait proposal terlebih dahulu
        if ($anggotaModel->where('penelitian_id', $id)->delete()) {
            // Hapus proposal berdasarkan ID
            if ($proposalModel->delete($id)) {
                return $this->response->setJSON(['success' => true]);
            } else {
                // Debug atau log jika penghapusan proposal gagal
                log_message('error', 'Gagal menghapus proposal dengan ID ' . $id);
                return $this->response->setJSON(['success' => false, 'error' => 'Failed to delete proposal']);
            }
        } else {
            // Debug atau log jika penghapusan anggota terkait gagal
            log_message('error', 'Gagal menghapus anggota terkait proposal dengan ID ' . $id);
            return $this->response->setJSON(['success' => false, 'error' => 'Failed to delete related members']);
        }
    }

    public function getProposalById($id)
    {
        $proposalModel = new Proposal_Model();
        $anggotaModel = new Anggota_Model();
        $dosenModel = new RegisterLogin_Model();

        // Ambil data proposal
        $proposal = $proposalModel->find($id);

        // Ambil data anggota terkait
        $anggota = $anggotaModel->where('penelitian_id', $id)->findAll();

        $dosen = $dosenModel->findAll();

        if (!$proposal) {
            return $this->response->setJSON(['error' => 'Proposal not found']);
        }

        return $this->response->setJSON([
            'id' => $proposal['id'],
            'judul_penelitian' => $proposal['judul_penelitian'],
            'skema' => $proposal['skema'],
            'skema_lainnya' => $proposal['skema_lainnya'],
            'biaya_diusulkan' => $proposal['biaya_diusulkan'],
            'biaya_didanai' => $proposal['biaya_didanai'],
            'sumber_dana' => $proposal['sumber_dana'],
            'dana_lainnya' => $proposal['dana_lainnya'],
            'file_penelitian' => $proposal['file_penelitian'],
            'anggota_kegiatan' => $anggota, // Kirim data anggota
            'data_dosen' => $dosen // Kirim data anggota
        ]);
    }


    public function updateProposal()
    {
        $userModel = new RegisterLogin_Model();
        $proposalModel = new Proposal_Model();
        $anggotaModel = new Anggota_Model();
        $id = $this->request->getPost('id');
        $anggotaPenelitian = $this->request->getPost('nama_dosen_kegiatan');
        $anggotaDihapus = $this->request->getPost('anggota_dihapus'); // Data yang dihapus
        $file = $this->request->getFile('berkas_proposal');

        // Ambil data anggota lama dari database
        $anggotaLama = $anggotaModel->where('penelitian_id', $id)->findAll();


        $updatedData = [
            'judul_penelitian' => $this->request->getPost('judulPenelitian'),
            'skema' => $this->request->getPost('skema'),
            'skema_lainnya' => $this->request->getPost('skema_lainnya'),
            'biaya_diusulkan' => str_replace(['Rp.', '.'], '', $this->request->getPost('biayaDiusulkan')),
            'biaya_didanai' => str_replace(['Rp.', '.'], '', $this->request->getPost('biayaDidanai')),
            'sumber_dana' => $this->request->getPost('sumberDana'),
            'dana_lainnya' => $this->request->getPost('dana_lainnya'),
        ];
        
        if ($file && $file->isValid()) {
            // Hapus file lama jika ada
            $existingProposal = $proposalModel->find($id);
            if ($existingProposal && file_exists("uploads/" . $existingProposal['file_penelitian'])) {
                unlink("uploads/" . $existingProposal['file_penelitian']);
            }
            // Simpan file baru
            // **Buat nama file sesuai format**
            $newFileName = "{$id}_file_penelitian_" . date('Y-m-d') . ".pdf";

            // **Pindahkan file ke server dengan nama baru**
            $file->move('uploads', $newFileName);

            // **Update nama file di database**
            $proposalModel->update($id, ['file_penelitian' => $newFileName]);
        }

        try {

            // Update proposal dengan data yang baru
            $proposalModel->update($id, $updatedData);
            /// Proses anggota yang dihapus
            if ($anggotaDihapus && is_array($anggotaDihapus)) {
                foreach ($anggotaDihapus as $index => $dihapus) {
                    if ($dihapus === 'true') {
                        list($nama, $nidn) = explode(' - ', $anggotaPenelitian[$index]);
                        $anggotaModel->where('penelitian_id', $id)
                        ->where('nama_anggota', $nama)
                        ->where('nidn_anggota', $nidn)
                        ->delete();
                        session()->setFlashdata('successIF2', 'Ini masuk ke kondisi dimana tombol remove dipencet!');
                    }
                }
                // session()->setFlashdata('successIF1', 'Ini masuk ke kondisi pertama !');
            }
            
            print_r($anggotaDihapus);
            // print_r($anggotaPenelitian);
            
            // Update Anggota Penelitian
            // **Tambahkan anggota baru atau perbarui anggota lama**
            if ($anggotaPenelitian && is_array($anggotaPenelitian)) {
                $validAnggotaIds = [];
                foreach ($anggotaPenelitian as $dosenBaru) {
                    if (!empty($dosenBaru) && (!isset($anggotaDihapus[$index]) || $anggotaDihapus[$index] !== 'true')) {
                        // Pecah nama dan NIDN
                        preg_match('/^(.*?) - (\d+)$/', $dosenBaru, $matches);
                        $namaBaru = $matches[1]; // Nama dosen
                        $nidnBaru = $matches[2]; // NIDN dosen
                        // Cek apakah anggota sudah ada
                        // print_r("Nama = $namaBaru NIDN = $nidnBaru ");

                        // $anggota = $anggotaModel
                        // ->where('penelitian_id', $id)
                        // ->where('nama_anggota', $namaBaru)
                        // ->where('nidn_anggota', $nidnBaru)
                        // ->first();

                        // $dataDosen = $userModel->where('nama', $namaBaru)->where('nidn', $nidnBaru)->first();

                        // Cari anggota lama berdasarkan NIDN dan Nama
                            $anggotaLama = $anggotaModel->where('penelitian_id', $id)
                            ->where('nidn_anggota', $nidnBaru)
                            ->where('nama_anggota', $namaBaru)
                            ->first();

                        if ($anggotaLama) {
                            // Tandai anggota ini sebagai valid (tidak akan dihapus)
                            $validAnggotaIds[] = $anggotaLama['id'];
                        } else {
                            // Data baru, tambahkan ke database
                            $dataDosen = $userModel->where('nama', $namaBaru)
                                ->where('nidn', $nidnBaru)
                                ->first();
                            if ($dataDosen) {
                                $newId = $anggotaModel->insert([
                                    'penelitian_id' => $id,
                                    'nama_anggota' => $dataDosen['nama'],
                                    'nidn_anggota' => $dataDosen['nidn'],
                                    'jabatan_anggota' => $dataDosen['jabatan_akademik'],
                                    'perguruan_anggota' => $dataDosen['perguruan_tinggi'],
                                    'fakultas_anggota' => $dataDosen['fakultas'],
                                    'prodi_anggota' => $dataDosen['program_studi'],
                                ]);
                                $validAnggotaIds[] = $newId;
                            }
                        }


                        // // Cek data lama dengan data baru
                        // $isUpdated = false;
                        // foreach ($anggotaLama as $anggota) {
                        //     if ($anggota['nama_anggota'] === $namaBaru && $anggota['nidn_anggota'] === $nidnBaru) {
                        //         $isUpdated = true; // Data tidak berubah, tidak perlu diupdate
                        //         print_r($anggotaModel->db->getLastQuery());
                        //         session()->setFlashdata('successDataSama', 'Ini masuk ke kondisi dimana data tidak diubah !');

                        //         break;
                        //     }

                        //     if ($anggota['nidn_anggota'] !== $nidnBaru && $anggota['nama_anggota'] !== $namaBaru && $isUpdated == false) {
                        //         // Hapus data lama
                        //         $anggotaModel->delete($anggota['id']);
                        //         session()->setFlashdata('successRL', 'Ini masuk ke kondisi dimana data lama diubah dengan baru !');
                        //     }
                        // }
                        
                        // // $anggotaModel->db->getLastQuery();
                        // if (!$isUpdated) {
                        //     // Tambahkan data baru
                        //     $dataDosen = $userModel->where('nama', $namaBaru)->where('nidn', $nidnBaru)->first();
                        //     if ($dataDosen) {
                        //         $anggotaModel->insert([
                        //             'penelitian_id' => $id,
                        //             'nama_anggota' => $dataDosen['nama'],
                        //             'nidn_anggota' => $dataDosen['nidn'],
                        //             'jabatan_anggota' => $dataDosen['jabatan_akademik'],
                        //             'perguruan_anggota' => $dataDosen['perguruan_tinggi'],
                        //             'fakultas_anggota' => $dataDosen['fakultas'],
                        //             'prodi_anggota' => $dataDosen['program_studi'],
                        //         ]);
                        //     session()->setFlashdata('successBA', 'Ini kondisi dimana user memasukkan nama anggota baru di db !');
                        //     }
                        // }


                            // if (!$anggota) {
                        //     // Jika anggota sudah ada, perbarui
                        //     print_r($anggotaModel->db->getLastQuery());
                        //     session()->setFlashdata('successU1', 'Ini kondisi dimana user memperbarui mengganti nama anggota yg sudah terdaftar di db !');
                        //     $anggotaModel->update($anggota['id'], [
                        //         'penelitian_id' => $id,
                        //         'nama_anggota' => $dataDosen['nama'],
                        //         'nidn_anggota' => $dataDosen['nidn'],
                        //         'jabatan_anggota' => $dataDosen['jabatan_akademik'],
                        //         'perguruan_anggota' => $dataDosen['perguruan_tinggi'],
                        //         'perguruan_lainnya' => null,
                        //         'fakultas_anggota' => $dataDosen['fakultas'],
                        //         'fakultas_lainnya'  => null,
                        //         'prodi_anggota' => $dataDosen['program_studi'],
                        //         'prodi_lainnya' => null
                        //     ]);
                        // } else {
                        //     // Jika anggota belum ada, tambahkan
                        //     session()->setFlashdata('successBA', 'Ini kondisi dimana user memasukkan nama anggota baru di db !');
                        //     $anggotaModel->insert([
                        //         'penelitian_id' => $id,
                        //         'nama_anggota' => $dataDosen['nama'],
                        //         'nidn_anggota' => $$dataDosen['nidn'],
                        //         'jabatan_anggota' => $$dataDosen['jabatan_akademik'],
                        //         'perguruan_anggota' => $$dataDosen['perguruan_tinggi'],
                        //         'fakultas_anggota' => $$dataDosen['fakultas'],
                        //         'prodi_anggota' => $$dataDosen['program_studi'],
                        //     ]);
                        // }
                    }
                }
                // Hapus anggota lama yang tidak ada dalam input baru
                if (!empty($validAnggotaIds)) {
                    $anggotaModel->where('penelitian_id', $id)
                        ->whereNotIn('id', $validAnggotaIds)
                        ->delete();
                }
                        }
            // return redirect()->to('/proposal_penelitian')->with('success', 'Proposal berhasil diperbarui!');
        } catch (\Exception $e) {
            log_message('error', 'Error: ' . $e->getMessage());
            // return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function uploadLaporanKemajuan($id)
    {
        $proposalModel = new Proposal_Model();
        $file = $this->request->getFile('laporan_kemajuan');

        try {
        // **Buat nama file sesuai format**
        $newFileName = "{$id}_laporankemajuan_" . date('Y-m-d') . ".pdf";

        // **Pindahkan file ke server dengan nama baru**
        $file->move('uploads', $newFileName);

        // **Update nama file di database**
        $proposalModel->update($id, ['file_laporan_kemajuan' => $newFileName]);

        return redirect()->back()->with('message', 'Laporan kemajuan berhasil diunggah!');
        } catch (\Exception $e) {
            dd($e);
        }            
            

        // return redirect()->back()->with('error', 'Gagal mengunggah laporan kemajuan.');
    }
    
    public function uploadLaporanAkhir($id)
    {
        $proposalModel = new Proposal_Model();
        $file = $this->request->getFile('laporan_akhir');

        if ($file && $file->isValid() && !$file->hasMoved()) {

            // **Buat nama file sesuai format**
            $newFileName = "{$id}_laporanakhir_" . date('Y-m-d') . ".pdf";

            // **Pindahkan file ke server dengan nama baru**
            $file->move('uploads', $newFileName);

            // **Update nama file di database**
            $proposalModel->update($id, ['file_laporan_akhir' => $newFileName]);

            return redirect()->back()->with('message', 'Laporan akhir berhasil diunggah!');
        }

        return redirect()->back()->with('error', 'Gagal mengunggah laporan akhir.');
    }
}
