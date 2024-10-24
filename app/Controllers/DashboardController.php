<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\RegisterLogin_Model;

class DashboardController extends BaseController
{
    public function index()
    {

        return view('dashboard');
    }

    // public function logout() {
    //     session()->remove('logged_in');
    //     session()->remove('username');
    //     session()->remove('user_type');
    //     return redirect()->to(base_url('register_login'));
    // }
}
