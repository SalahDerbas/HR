<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WebsiteController extends Controller
{
    public function index()
    {
        return view('Website.home');
    }

    public function contact_us()
    {
        return view('Website.Pages.contact');
    }
}
