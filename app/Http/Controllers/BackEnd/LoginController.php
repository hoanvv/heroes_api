<?php

namespace App\Http\Controllers\BackEnd;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    public function index()
    {
        return view('back-end.login');
    }

    public function login()
    {
        return redirect()->route('admin.home');
    }
}
