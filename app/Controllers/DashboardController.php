<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\RegisterLogin_Model;
use App\Models\Proposal_Model;

class DashboardController extends BaseController
{
    public function index()
    {
        $proposalModel = new Proposal_Model();
        $userId = session()->get('user_id');
        $proposalsFinalFA = $proposalModel->getPenelitianWithDosenAndAnggotaFA();
        $proposalsFinalFU = $proposalModel->getPenelitianWithDosenAndAnggotaFU($userId);

        return view("dashboard", [
            'proposalsFA' => $proposalsFinalFA,
            'proposalsFU' => $proposalsFinalFU,
        ]);
    }

    // public function logout() {
    //     session()->remove('logged_in');
    //     session()->remove('username');
    //     session()->remove('user_type');
    //     return redirect()->to(base_url('register_login'));
    // }
}
