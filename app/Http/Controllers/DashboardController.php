<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('pages.home');
    }
    public function subscribe()
    {
        return view('pages.subscribe');
    }
    public function ResetPassword()
    {
        return view('pages.changePassword');
    }
}
