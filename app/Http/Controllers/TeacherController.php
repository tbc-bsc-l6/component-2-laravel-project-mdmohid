<?php

/*
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TeacherController extends Controller
{
    //
    public function dashboard(){
      
      return view('teacher.dashboard');
    }
    
}
*/



namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Module;

class TeacherController extends Controller
{
  public function dashboard()
  {
    $teacher = auth()->user();
    $modules = $teacher->taughtModules()->with('enrollments.student')->get();

    return view('teacher.dashboard', compact('modules'));
  }

  public function grade(Request $request, $enrollmentId)
  {
    $request->validate(['pass' => 'required|boolean']);

    $enrollment = Enrollment::findOrFail($enrollmentId);
    $module = $enrollment->module;

    // Ensure the teacher owns this module
    if ($module->teacher_id !== auth()->id()) {
      abort(403, 'You are not the teacher for this module.');
    }

    // Update pass/fail and timestamp
    $enrollment->pass = $request->pass;
    $enrollment->completed_at = now();
    $enrollment->save();

    return back()->with('success', 'Grade set successfully');
  }
}
