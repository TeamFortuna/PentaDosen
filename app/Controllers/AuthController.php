<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;
use CodeIgniter\Email\Email;
use App\Models\ActivityLogModel;

class AuthController extends BaseController
{
    protected $userModel;
    protected $activityLogModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->activityLogModel = new ActivityLogModel(); // Tambahkan inisialisasi ini
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
            'password' => $this->request->getPost('password'),
            'role' => 'dosen' // Default role untuk registrasi baru
        ];

        $this->userModel->save($userData);

        // Redirect ke login dengan pesan sukses
        return redirect()->to('/login')->with('success', 'Registrasi berhasil! Silakan login dengan akun Anda.');
    }

    public function login()
    {
        // Jika sudah login, redirect ke dashboard
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/dashboard');
        }

        $data = [
            'title' => 'Login'
        ];
        return view('loginpage', $data);
    }

    // Proses login
    public function processLogin()
    {
        // Validasi input
        $rules = [
            'usernameOrEmail' => 'required',
            'password' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $usernameOrEmail = $this->request->getPost('usernameOrEmail');
        $password = $this->request->getPost('password');

        // Cari user by username atau email
        $user = $this->userModel->where('username', $usernameOrEmail)
            ->orWhere('email', $usernameOrEmail)
            ->first();

        if (!$user || !password_verify($password, $user['password'])) {
            return redirect()->back()->withInput()->with('error', 'Username/email atau password salah');
        }

        // Set session
        $this->setUserSession($user);

        // Redirect berdasarkan role
        if ($user['role'] === 'admin') {
            return redirect()->to('/dashboard')->with('success', 'Login berhasil!');
        } else {
            return redirect()->to('/kalender')->with('success', 'Login berhasil!');
        }
    }

    // Logout
    public function logout()
    {
        // Load helper manual jika belum ter-load
        helper('activity');

        if (session()->get('isLoggedIn')) {
            try {
                log_activity(
                    session()->get('id'),
                    'Logout',
                    'User logged out'
                );
            } catch (\Exception $e) {
                log_message('error', 'Gagal mencatat aktivitas logout: ' . $e->getMessage());
            }
        }

        session()->destroy();
        return redirect()->to('/login')->with('success', 'Anda telah logout');
    }

    // Set session user
    private function setUserSession($user)
    {
        $data = [
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
            'role' => $user['role'],
            'logged_in' => true,
            'user_id' => $user['id']
        ];

        session()->set($data);
    }

    public function forgotpassword()
    {
        return view('forgotpasswordpage');
    }

    public function processForgotPassword()
    {
        $email = $this->request->getPost('email');

        // Validasi email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return redirect()->back()->with('error', 'Email tidak valid');
        }

        // Cek apakah email terdaftar
        $user = $this->userModel->where('email', $email)->first();
        if (!$user) {
            return redirect()->back()->with('error', 'Email tidak terdaftar');
        }

        // Generate OTP (6 digit angka)
        $otp = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
        $otpExpiry = date('Y-m-d H:i:s', strtotime('+15 minutes')); // OTP berlaku 15 menit

        // Simpan OTP ke database
        $this->userModel->update($user['id'], [
            'reset_token' => $otp,
            'reset_expiry' => $otpExpiry
        ]);

        // Kirim email OTP
        $this->sendOtpEmail($email, $otp, $user['nama']);

        // Simpan email di session untuk verifikasi selanjutnya
        session()->set('reset_email', $email);

        return redirect()->to('/verify-otp')->with('success', 'Kode OTP telah dikirim ke email Anda');
    }

    public function verifyOtp()
    {
        // Jika tidak ada email di session, redirect ke forgot password
        if (!session()->get('reset_email')) {
            return redirect()->to('/forgotpassword');
        }

        return view('verify_otp_page');
    }

    public function processVerifyOtp()
    {
        $otp = $this->request->getPost('otp');
        $email = session()->get('reset_email');

        // Validasi OTP
        if (strlen($otp) != 6 || !is_numeric($otp)) {
            return redirect()->back()->with('error', 'Kode OTP harus 6 digit angka');
        }

        // Cek user dan OTP
        $user = $this->userModel->where('email', $email)->first();
        if (!$user || $user['reset_token'] !== $otp) {
            return redirect()->back()->with('error', 'Kode OTP tidak valid');
        }

        // Cek expiry OTP
        if (strtotime($user['reset_expiry']) < time()) {
            return redirect()->back()->with('error', 'Kode OTP sudah kadaluarsa');
        }

        // Simpan verifikasi OTP berhasil di session
        session()->set('otp_verified', true);

        return redirect()->to('/reset-password');
    }

    public function resetPassword()
    {
        // Jika OTP belum diverifikasi, redirect ke forgot password
        if (!session()->get('otp_verified')) {
            return redirect()->to('/forgotpassword');
        }

        return view('reset_password_page');
    }

    public function processResetPassword()
    {
        $email = session()->get('reset_email');
        $password = $this->request->getPost('password');
        $confirmPassword = $this->request->getPost('confirm_password');

        // Validasi password
        if ($password !== $confirmPassword) {
            return redirect()->back()->with('error', 'Password dan konfirmasi password tidak sama');
        }

        if (strlen($password) < 8) {
            return redirect()->back()->with('error', 'Password minimal 8 karakter');
        }

        // Update password
        $this->userModel->where('email', $email)->set([
            'password' => $this->request->getPost('password'),
            'reset_token' => null,
            'reset_expiry' => null
        ])->update();

        // Clear session
        session()->remove(['reset_email', 'otp_verified']);

        return redirect()->to('/login')->with('success', 'Password berhasil direset. Silakan login dengan password baru Anda');
    }

    private function sendOtpEmail($email, $otp, $name)
    {
        $emailService = \Config\Services::email();

        $emailService->setTo($email);
        $emailService->setSubject('Reset Password - Kode OTP');

        $message = view('emails/otp_email', [
            'name' => $name,
            'otp' => $otp
        ]);

        $emailService->setMessage($message);

        if (!$emailService->send()) {
            log_message('error', 'Email Error: ' . $emailService->printDebugger(['headers']));
            return false;
        }

        log_message('info', 'Email OTP berhasil dikirim ke: ' . $email);
        return true;
    }
}
