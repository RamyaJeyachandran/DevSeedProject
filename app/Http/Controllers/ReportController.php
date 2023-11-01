<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use config\constants;

class ReportController extends Controller
{
    public function index()
    {
        return View("pages.patientCycleReport");
    }
}
