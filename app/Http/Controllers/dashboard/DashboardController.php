<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('check.permission:view,dashboard')->only(['index']);
    }

    public function index()
    {
        return view('dashboard.dashboard');
    }
}
