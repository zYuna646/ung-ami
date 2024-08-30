<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Faculty;
use App\Models\Program;
use App\Models\Unit;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $counts = (object) [
            'units' => Unit::count(),
            'faculties' => Faculty::count(),
            'departments' => Department::count(),
            'programs' => Program::count(),
        ];

        return view('pages.dashboard.index', compact('counts'));
    }
}
