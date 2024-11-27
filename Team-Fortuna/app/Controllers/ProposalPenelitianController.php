<?php

namespace App\Controllers;

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
        $userModel = new RegisterLogin_Model();
        $proposalModel = new Proposal_Model();

        $userId = session()->get('user_id');
        $userData = $userModel->find($userId);

        // Mengambil data penelitian dari database
        $proposalsFinal = $proposalModel->getPenelitianWithDosenAndAnggota();
        return view('proposal_penelitian', [
            'userData' => $userData,
            'proposals' => $proposalsFinal
        ]);
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
            session()->setFlashdata('errNIDN', $validation->getError('nidn_anggota.*'));
            session()->setFlashdata('errProposal', 'Data yang Anda kirim ada yang salah !');            
            return redirect()->back()->withInput();
        }

        $file = $this->request->getFile('berkas_proposal');

        // // Tambahkan pengecekan apakah file berhasil diunggah
        // if (!$file->isValid()) {
        //     session()->setFlashdata('errFile', 'Terjadi kesalahan saat mengunggah file!');
        //     return redirect()->back()->withInput();
        // }

        try {
            // Pindahkan file ke folder 'uploads'
            $file->move('uploads');
            $fileName = $file->getName();

            $proposalModel = new Proposal_Model();
            $anggotaModel = new Anggota_Model();
            $dosen_id_model = new Intersection_Dosen_Proposal();

            $proposalData = [
                'judul_penelitian' => $this->request->getPost('judulPenelitian'),
                'skema' => $this->request->getPost('skema'),
                'skema_lainnya' => $this->request->getPost('skema_lainnya'),
                'biaya_diusulkan' => str_replace(['Rp.', '.'], '', $this->request->getPost('biayaDiusulkan')),
                'biaya_didanai' => str_replace(['Rp.', '.'], '', $this->request->getPost('biayaDidanai')),
                'sumber_dana' => $this->request->getPost('sumberDana'),
                'dana_lainnya' => $this->request->getPost('dana_lainnya'),
                'file_penelitian' => $fileName,
                'tanggal_upload' => date('Y-m-d')
            ];

            $proposalModel->save($proposalData);
            $penelitian_id = $proposalModel->getInsertID();
            $id_dosen = session()->get('user_id');

            // Menyimpan data anggota
            $namaAnggota = $this->request->getPost('nama_anggota');
            $nidnAnggota = $this->request->getPost('nidn_anggota');
            $jabatanAnggota = $this->request->getPost('jabatan_anggota');
            $perguruanAnggota = $this->request->getPost('perguruan_anggota');
            $fakultasAnggota = $this->request->getPost('fakultas_anggota');
            $prodiAnggota = $this->request->getPost('prodi_anggota');

            foreach ($namaAnggota as $index => $nama) {
                $anggotaData = [
                    'penelitian_id' => $penelitian_id,
                    'nama_anggota' => $nama,
                    'nidn_anggota' => $nidnAnggota[$index],
                    'jabatan_anggota' => $jabatanAnggota[$index],
                    'perguruan_anggota' => $perguruanAnggota[$index],
                    'fakultas_anggota' => $fakultasAnggota[$index],
                    'prodi_anggota' => $prodiAnggota[$index]
                ];
                $anggotaModel->insert($anggotaData);
            }

            $dosen_id_model->save([
                'dosen_id' => $id_dosen,
                'penelitian_id' => $penelitian_id
            ]);

            session()->setFlashdata('success', 'Proposal Berhasil Diupload !');
            return redirect()->to('proposal_penelitian')->with('success', 'Proposal berhasil diunggah!');
        } catch (\Exception $e) {
          
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
}
