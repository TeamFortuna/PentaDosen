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

        // Mengambil data proposal dari database
        $proposals = $proposalModel->getProposalsWithAnggota();
        $proposalsFinal = $proposalModel->getProposalsWithDosenAndAnggota();
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
                    'max_size' => 'Ukuran File Besar!',
                    'ext_in' => 'File Harus Berformat PDF!',
                ],
            ],
        ]);

        if (!$valid) {
            session()->setFlashdata('errFile', $validation->getError('berkas_proposal'));
            session()->setFlashdata('errProposal', 'Data yang Anda kirim ada yang salah !');
            return redirect()->back()->withInput();
        }
        $proposalModel = new Proposal_Model();
        $anggotaModel = new Anggota_Model();
        $dosen_id_model = new Intersection_Dosen_Proposal();

        // Validasi data yang diterima dari form

        // Validasi file
        $file = $this->request->getFile('berkas_proposal');
        // Pindahkan file ke folder 'uploads'
        $file->move('uploads');
        $fileName = $file->getName();

        $result = $proposalModel->save([
            'judul_penelitian' => $this->request->getPost('judulPenelitian'),
            'skema' => $this->request->getPost('skema'),
            'skema_lainnya' => $this->request->getPost('skema_lainnya'),
            'biaya_diusulkan' => str_replace(['Rp.', '.'], '', $this->request->getPost('biayaDiusulkan')),
            'biaya_didanai' => str_replace(['Rp.', '.'], '', $this->request->getPost('biayaDidanai')),
            'sumber_dana' => $this->request->getPost('sumberDana'),
            'dana_lainnya' => $this->request->getPost('dana_lainnya'),
            'file_proposal' => $fileName,
            'tanggal_upload' => date('Y-m-d')
        ]);

        // Mendapatkan ID proposal terakhir yang disimpan
        $proposal_id = $proposalModel->getInsertID();
        $id_dosen = session()->get('user_id');
        // Menyimpan data anggota ke tabel anggota_proposal
        $namaAnggota = $this->request->getPost('nama_anggota');
        $nidnAnggota = $this->request->getPost('nidn_anggota');
        $jabatanAnggota = $this->request->getPost('jabatan_anggota');
        $perguruanAnggota = $this->request->getPost('perguruan_anggota');
        $fakultasAnggota = $this->request->getPost('fakultas_anggota');
        $prodiAnggota = $this->request->getPost('prodi_anggota');

        foreach ($namaAnggota as $index => $nama) {
            $anggotaData = [
                'proposal_id' => $proposal_id,
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
            'proposal_id' => $proposal_id
        ]);

        if ($result === false) {
            echo "Data gagal disimpan. Kesalahan: " . implode(', ', $proposalModel->errors());
        } else {
            echo "Data berhasil disimpan!";
            // Redirect ke halaman login setelah sukses
            session()->setFlashdata('success', 'Proposal Berhasil Diupload !');
            return redirect()->to('proposal_penelitian')->with('success', 'Proposal berhasil diunggah!');
        }
    }

    public function download($id)
    {
        $proposalModel = new Proposal_Model();
        $nama_file = $proposalModel->find($id);
        return $this->response->download('uploads/' . $nama_file['file_proposal'], null);
    }
}
