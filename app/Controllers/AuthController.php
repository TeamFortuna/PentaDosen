<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class AuthController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        helper(['form', 'url']);
    }



    public function register()
    {
        $data = [
            'title' => 'Registrasi Akun'
        ];
        return view('registerpage', $data);
    }

    // Proses registrasi
    public function processRegister()
    {
        // Validasi input
        $rules = [
            'nama' => 'required|min_length[3]|max_length[255]',
            'nidn' => 'required|min_length[5]|max_length[50]|is_unique[users.nidn]',
            'nip' => 'required|min_length[5]|max_length[50]|is_unique[users.nip]',
            'inisial' => 'required|max_length[10]',
            'jabatan' => 'required|in_list[Asisten Ahli,Lektor,Lektor Kepala,Guru Besar]',
            'universitas' => 'required',
            'fakultas' => 'required',
            'jurusan' => 'required',
            'email' => 'required|valid_email|is_unique[users.email]',
            'username' => 'required|min_length[3]|max_length[50]|is_unique[users.username]',
            'password' => 'required|min_length[8]',
            'confirmPassword' => 'required|matches[password]'
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Jika universitas adalah "Other", gunakan nilai dari otherUniv
        $universitas = $this->request->getPost('universitas');
        if ($universitas === 'Other') {
            $universitas = $this->request->getPost('otherUniv');
        }

        // Simpan data user
        $userData = [
            'nama' => $this->request->getPost('nama'),
            'nidn' => $this->request->getPost('nidn'),
            'nip' => $this->request->getPost('nip'),
            'inisial' => $this->request->getPost('inisial'),
            'jabatan' => $this->request->getPost('jabatan'),
            'universitas' => $universitas,
            'fakultas' => $this->request->getPost('fakultas'),
            'jurusan' => $this->request->getPost('jurusan'),
            'email' => $this->request->getPost('email'),
            'username' => $this->request->getPost('username'),
            'password' => $this->request->getPost('password')
        ];

        $this->userModel->save($userData);

        // Set session dan redirect ke dashboard
        $user = $this->userModel->where('email', $userData['email'])->first();
        $this->setUserSession($user);

        return redirect()->to('/login')->with('success', 'Registrasi berhasil!');
    }

    public function login()
    {

        $data = [
            'title' => 'Login'
        ];
        return view('loginpage', $data);
    }

    // Proses login
    public function processLogin()
    {
        $rules = [
            'usernameOrEmail' => 'required',
            'password' => 'required'
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $usernameOrEmail = $this->request->getPost('usernameOrEmail');
        $password = $this->request->getPost('password');

        $user = $this->userModel->getUserByUsernameOrEmail($usernameOrEmail);

        if (!$user || !password_verify($password, $user['password'])) {
            return redirect()->back()->withInput()->with('error', 'Username/email atau password salah');
        }

        $this->setUserSession($user);
        return redirect()->to('/dashboard')->with('success', 'Login berhasil!');
    }

    // Logout
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login')->with('success', 'Anda telah logout');
    }

    // Set session user
    private function setUserSession($user)
    {
        $data = [
            'user_id' => $user['id'],
            'id' => $user['id'],
            'nama' => $user['nama'],
            'nidn' => $user['nidn'],
            'nip' => $user['nip'],
            'inisial' => $user['inisial'],
            'jabatan' => $user['jabatan'],
            'universitas' => $user['universitas'],
            'fakultas' => $user['fakultas'],
            'jurusan' => $user['jurusan'],
            'email' => $user['email'],
            'username' => $user['username'],
            'isLoggedIn' => true
        ];

        session()->set($data);
    }

    public function forgotpassword()
    {
        return view('forgotpasswordpage');
    }
}
