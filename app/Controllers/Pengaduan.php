<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Pengaduan extends BaseController
{
    public function index()
    {
        return view('pengaduan/get');
    }
}
