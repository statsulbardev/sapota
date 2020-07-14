<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

class LandingPageController extends Controller
{
    public function index()
    {
        return view('frontend.index');
    }
}