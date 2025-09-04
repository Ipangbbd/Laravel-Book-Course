<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Display the student dashboard.
     */
    public function index(): View
    {
        return view('student.dashboard');
    }
}
