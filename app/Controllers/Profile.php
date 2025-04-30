<?php

namespace App\Controllers;

use App\Models\UserModel;

class Profile extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Profile',
            'user' => $this->userModel->find(session()->get('user_id'))
        ];

        return view('profilepage', $data);
    }

    public function edit()
    {
        $data = [
            'title' => 'Edit Profile',
            'user' => $this->userModel->find(session()->get('user_id'))
        ];

        return view('editprofilepage', $data);
    }

    public function update()
    {
        $userId = session()->get('user_id');
        $user = $this->userModel->find($userId);

        $rules = [
            'nama' => 'required',
            'nidn' => "required|is_unique[users.nidn,id,$userId]",
            'nip' => "required|is_unique[users.nip,id,$userId]",
            'inisial' => 'required',
            'jabatan' => 'required',
            'universitas' => 'required',
            'fakultas' => 'required',
            'jurusan' => 'required',
            'email' => "required|valid_email|is_unique[users.email,id,$userId]",
            'username' => "required|is_unique[users.username,id,$userId]"
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'nama' => $this->request->getPost('nama'),
            'nidn' => $this->request->getPost('nidn'),
            'nip' => $this->request->getPost('nip'),
            'inisial' => $this->request->getPost('inisial'),
            'jabatan' => $this->request->getPost('jabatan'),
            'universitas' => $this->request->getPost('universitas'),
            'fakultas' => $this->request->getPost('fakultas'),
            'jurusan' => $this->request->getPost('jurusan'),
            'email' => $this->request->getPost('email'),
            'username' => $this->request->getPost('username')
        ];

        if ($this->request->getPost('password')) {
            $data['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        $this->userModel->update($userId, $data);

        return redirect()->to('/profile')->with('message', 'Profile berhasil diperbarui');
    }

    public function delete()
    {
        $userId = session()->get('user_id');
        
        // Hapus akun dari database dengan force delete
        $this->userModel->delete($userId, true);
        
        // Hapus session
        session()->destroy();
        
        // Redirect ke homepage dengan pesan
        return redirect()->to('/')->with('message', 'Akun Anda telah berhasil dihapus');
    }
} 