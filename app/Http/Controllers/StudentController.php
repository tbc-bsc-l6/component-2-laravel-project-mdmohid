<?php

/*namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentController extends Controller
{
    //
    public function dashboard(){

      return view('student.dashboard');
    }
}
*/



namespace App\Http\Controllers;

//use Illuminate\Support\Facades\Auth;
use App\Models\Module;
use App\Models\Enrollment;
use App\Models\User;
use Illuminate\Http\Request;

class StudentController extends Controller
{
  public function dashboard()
  {
    $user = auth()->user();


    // Active (current) enrollments
    $activeEnrollments = $user->enrollments()
      ->whereNull('completed_at')
      ->with('module')
      ->get();

    // Completed enrollments (history)
    $completedEnrollments = $user->enrollments()
      ->whereNotNull('completed_at')
      ->with('module')
      ->get();

    // Available modules (only for current students)
    $availableModules = [];
    if ($user->role === 'student') {
      $availableModules = Module::where('active', true)
        ->whereDoesntHave('enrollments', fn($q) => $q->where('user_id', $user->id))
        ->get();
    }

    return view('student.dashboard', compact('activeEnrollments', 'completedEnrollments', 'availableModules'));
  }

  public function enrol(Request $request, $moduleId)
  {
    $user = auth()->user();
    $module = Module::findOrFail($moduleId);

    // Only current students can enroll
    if ($user->role !== 'student') {
      return back()->withErrors('Only current students can enroll.');
    }

    // Module must be available
    if (!$module->active) {
      return back()->withErrors('This module is not available.');
    }

    // Max 4 active modules
    if ($user->enrollments()->whereNull('completed_at')->count() >= 4) {
      return back()->withErrors('You can only enroll in a maximum of 4 current modules.');
    }

    // Module max 10 students
    if ($module->enrollments()->whereNull('completed_at')->count() >= 10) {
      return back()->withErrors('This module is full (maximum 10 students).');
    }

    // Already enrolled?
    if ($user->enrollments()->where('module_id', $moduleId)->exists()) {
      return back()->withErrors('You are already enrolled in this module.');
    }

    Enrollment::create([
      'user_id' => $user->id,
      'module_id' => $moduleId,
      'enrolled_at' => now(),
    ]);

    return back()->with('success', 'Enrolled successfully!');
  }
}
