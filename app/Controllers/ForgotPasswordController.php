<?php

namespace App\Controllers;

class ForgotPasswordController extends BaseController
{

    // Fungsi untuk menampilkan halaman forgot password
    public function forgotPassword()
    {
        return view('forgot_password');
    }

    public function newPassword()
    {
        return view('password_baru');
    }

    public function processForgotPassword()
    {
        $email = $this->request->getPost('email');

        // Lakukan pengecekan validitas email dan kirim link reset password (jika menggunakan email).
        // Jika tidak menggunakan email, langsung alihkan ke halaman password_baru.php

        // Redirect ke halaman password baru
        return redirect()->to('/password_baru');
    }
}
