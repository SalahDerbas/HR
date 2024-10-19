<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthinticateController extends Controller
{
    public function forget()
    {
        return view('auth.forget_password');
    }
}
