<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $role = auth()->user()->userRole()->role;

        if ($role === 'Admin') {
            return redirect()->route('admin.dashboard');
        }

        if ($role === 'Teacher') {
            return redirect()->route('teacher.dashboard');
        }

        // Student and Old Student both go to student dashboard
        return redirect()->route('student.dashboard');
    }
}
