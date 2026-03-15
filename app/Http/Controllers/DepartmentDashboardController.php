<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DepartmentDashboardController extends Controller
{
    public function index()
    {
        return view('department.dashboard');
    }
}
