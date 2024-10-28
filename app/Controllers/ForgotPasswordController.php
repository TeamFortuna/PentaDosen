<?php

namespace App\Controllers;
use App\Models\RegisterLogin_Model;


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

    public function processOTP()
    {
        // Lakukan pengecekan validitas email dan kirim link reset password (jika menggunakan email).
        $userModel = new RegisterLogin_Model();
        $email = $this->request->getPost('email');
        $userEmail = $userModel->where('email', $email)->first();
        if ($userEmail) {
            $email = \Config\Services::email();
            $otp = $this->generateUniqueOTP($userModel); // Generate unique OTP
            $userModel->update($userEmail['id'], [
                'otp' => $otp,
            ]); 
            $emailMessage = 'Halo '.$userEmail['username'].'<br><br>'
                        . 'Anda sedang melakukan reset password<br><br>'
                        .'Kode OTP Anda '.$otp.''
                        .'<br>Silahkan klik link di bawah ini untuk reset password Anda !<br><br>'
                        .'<a href="'.base_url('password_baru').'">Klik di sini untuk reset password Anda</a><br><br>'                        
                        .'Terimakasih<br> Fortuna';                        
            $email->setTo($userEmail['email']);
            $email->setFrom('fortunateams3@gmail.com', 'Fortuna');
            $email->setSubject('Kode OTP');
            $email->setMessage($emailMessage);
            if($email->send()) {
                return redirect()->to(base_url('forgot_password'));
            } else {
                $data = $email->printDebugger(['headers']);
                print_r($data);
            }
        }
        // Jika tidak menggunakan email, langsung alihkan ke halaman password_baru.php

        // Redirect ke halaman password baru
        // return redirect()->to(base_url('forgot_password'));
    }

    private function generateUniqueOTP($userModel)
    {
    do {
        $otp = mt_rand(100000, 999999); // Generate new OTP
        $exists = $userModel->where('otp', $otp)->first(); // Check if OTP already exists
    } while ($exists); // Loop until a unique OTP is found
    
    return $otp;
    }

    public function processNewPassword() {
        $userModel = new RegisterLogin_Model();
        $kode_otp = $this->request->getPost('kode_otp');
        $new_password = $this->request->getPost('new_password');
        $confirm_password = $this->request->getPost('confirm_password');
        $email = session()->get('email');
        var_dump($email);

        $verify = $userModel->where('otp', $kode_otp)->first();

        if($verify) {
            // Pastikan array di dalam update() hanya berisi data yang akan diupdate
            $userModel->update($verify['id'], [
                'password' => password_hash($new_password, PASSWORD_DEFAULT),
                'otp' => NULL,
            ]);
    
            session()->remove('email');
            return redirect()->to(base_url('register_login'));
        } else {
            return redirect()->to(base_url('password_baru'))->with('error', 'Kode OTP salah atau email tidak ditemukan.');
        }
    }
}
