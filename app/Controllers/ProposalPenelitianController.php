<?php

namespace App\Controllers;

use App\Models\RegisterLogin_Model;
use App\Models\Proposal_Model;
use App\Models\Anggota_Model;

class ProposalPenelitianController extends BaseController
{
    public function ProposalPenelitian()
    {
        $userModel = new RegisterLogin_Model();
        $proposalModel = new Proposal_Model();

        $userId = session()->get('user_id');
        $userData = $userModel->find($userId);

        // Mengambil data proposal dari database
        $proposals = $proposalModel->where('id', $userId)->findAll();

        return view('proposal_penelitian', [
            'userData' => $userData,
            'proposals' => $proposals
        ]);
    }

    public function uploadProposal()
    {
        $proposalModel = new Proposal_Model();
        $anggotaModel = new Anggota_Model();

        // Validasi data yang diterima dari form
        $validation = \Config\Services::validation();

        // Validasi file
        $file = $this->request->getFile('berkas_proposal');
        if ($file->isValid() && !$file->hasMoved()) {
            // Pindahkan file ke folder 'uploads'
            $filePath = $file->store('uploads');
            $fileName = $file->getName();
        } else {
            // Error jika file gagal diupload
            return redirect()->back()->with('error', 'File upload gagal.');
        }

        // Ambil data form
        $data = [
            'judul_penelitian' => $this->request->getPost('judulPenelitian'),
            'skema' => $this->request->getPost('skema'),
            'skema_lainnya' => $this->request->getPost('skema_lainnya'),
            'biaya_diusulkan' => str_replace(['Rp.', '.'], '', $this->request->getPost('biayaDiusulkan')),
            'biaya_didanai' => str_replace(['Rp.', '.'], '', $this->request->getPost('biayaDidanai')),
            'sumber_dana' => $this->request->getPost('sumberDana'),
            'dana_lainnya' => $this->request->getPost('dana_lainnya'),
            'file_proposal' => $fileName,
            'tanggal_upload' => date('Y-m-d H:i:s')
        ];

        // Simpan data proposal dan anggota
        $anggota = [];
        $namaAnggota = $this->request->getPost('nama_anggota');
        $nidnAnggota = $this->request->getPost('nidn_anggota');
        $jabatanAnggota = $this->request->getPost('jabatan_anggota');
        $perguruanAnggota = $this->request->getPost('perguruan_anggota');
        $fakultasAnggota = $this->request->getPost('fakultas_anggota');
        $prodiAnggota = $this->request->getPost('prodi_anggota');

        foreach ($namaAnggota as $index => $nama) {
            $anggota[] = [
                'nama_anggota' => $nama,
                'nidn_anggota' => $nidnAnggota[$index],
                'jabatan_anggota' => $jabatanAnggota[$index],
                'perguruan_anggota' => $perguruanAnggota[$index],
                'fakultas_anggota' => $fakultasAnggota[$index],
                'prodi_anggota' => $prodiAnggota[$index]
            ];
        }

        // Simpan proposal dan anggota
        $proposal_id = $proposalModel->simpanProposal($data, $anggota);

        return redirect()->to('/proposal_penelitian')->with('message', 'Proposal berhasil diunggah!');
    }
}
