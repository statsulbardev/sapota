<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

class InfographicController extends Controller
{
    public function index()
    {
        return view('frontend.infographic');
    }
}