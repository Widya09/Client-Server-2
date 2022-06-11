<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Verifikasi extends BaseController
{
    public function index()
    {
        return view('verifikasi/get');
    }
}
