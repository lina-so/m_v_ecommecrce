<?php

namespace App\Http\Controllers\Dashboard\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminLoginController extends Controller
{
    public function login()
    {
        return view('dashboard.admin.auth.login');
    }
    public function checkLogin()
    {
       // logic
    }
}
