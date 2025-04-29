<?php

namespace App\Controllers;

class HomepageController extends BaseController
{
    public function index()
    {
        return view('homepage');
    }
}
