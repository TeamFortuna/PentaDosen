<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\RegisterLogin_Model;

class DashboardController extends BaseController
{
    public function index()
    {    
        // helper('form');
        // Load the registration form view
        return view('dashboard');
    }
}