<?php

namespace App\Http\Controllers\Dashboard\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminRegisterController extends Controller
{
    public function register()
    {
        return view('dashboard.admin.auth.register');
    }
    public function store()
    {
       // logic
    }
}
