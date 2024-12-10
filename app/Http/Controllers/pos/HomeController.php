<?php

namespace App\Http\Controllers\pos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('check.permission:view,pos');
    }

    public function index()
    {
        return view('pos.home');
    }
}
