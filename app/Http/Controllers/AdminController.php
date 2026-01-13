<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\User;
use App\Models\UserRole;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class AdminController extends Controller
{

  public function dashboard(Request $request)
  {
    //Modules Tab
    $moduleQuery = Module::with(['teacher', 'enrollments']);
    if ($request->filled('module_search')) {
      $moduleQuery->where('module', 'like', '%' . $request->module_search . '%');
    }
    $moduleSort = $request->get('module_sort', 'created_at');
    $moduleOrder = $request->get('module_order', 'desc');
    $modules = $moduleQuery->orderBy($moduleSort, $moduleOrder)
      ->paginate(6, ['*'], 'module_page') // Unique page name
      ->withQueryString();

    // Students Tab
    $studentQuery = User::with(['userRole', 'enrollments'])
      ->whereHas('userRole', fn($q) => $q->where('role', 'student'));
    if ($request->filled('student_search')) {
      $studentQuery->where('name', 'like', '%' . $request->student_search . '%')
        ->orWhere('email', 'like', '%' . $request->student_search . '%');
    }
    $studentSort = $request->get('student_sort', 'name');
    $studentOrder = $request->get('student_order', 'asc');
    $students = $studentQuery->orderBy($studentSort, $studentOrder)
      ->paginate(10, ['*'], 'student_page') // Unique page name
      ->withQueryString();

    // Teachers Tab (for listing)
    $teacherQuery = User::with('userRole')
      ->whereHas('userRole', fn($q) => $q->where('role', 'teacher'));
    if ($request->filled('teacher_search')) {
      $teacherQuery->where('name', 'like', '%' . $request->teacher_search . '%')
        ->orWhere('email', 'like', '%' . $request->teacher_search . '%');
    }
    $teacherSort = $request->get('teacher_sort', 'name');
    $teacherOrder = $request->get('teacher_order', 'asc');
    $paginatedTeachers = $teacherQuery->orderBy($teacherSort, $teacherOrder)
      ->paginate(10, ['*'], 'teacher_page') // Unique page name
      ->withQueryString();

    //Users Tab
    $userQuery = User::with('userRole');
    if ($request->filled('user_search')) {
      $userQuery->where('name', 'like', '%' . $request->user_search . '%')
        ->orWhere('email', 'like', '%' . $request->user_search . '%');
    }
    $userSort = $request->get('user_sort', 'name');
    $userOrder = $request->get('user_order', 'asc');
    $users = $userQuery->orderBy($userSort, $userOrder)
      ->paginate(10, ['*'], 'user_page') // Unique page name
      ->withQueryString();

    // Full list of teachers for the assignment dropdown (NOT paginated) 
    $allTeachers = User::whereHas('userRole', fn($q) => $q->where('role', 'teacher'))
      ->orderBy('name')
      ->get();

    return view('admin.dashboard', compact(
      'modules',
      'students',
      'paginatedTeachers',
      'users',
      'allTeachers'
    ));
  }



  // Add new module
  public function storeModule(Request $request)
  {
    $request->validate(['module' => 'required|string|max:255']);
    Module::create(['module' => $request->module, 'active' => true]);
    return back()->with('success', 'Module added successfully');
  }


  // Create new teacher
  public function storeTeacher(Request $request)
  {
    $request->validate([
      'name' => 'required|string|max:255',
      'email' => 'required|email|unique:users,email',
      'password' => 'required|min:8|confirmed',
    ]);

    $teacherRole = UserRole::where('role', 'teacher')->firstOrFail();

    User::create([
      'name' => $request->name,
      'email' => $request->email,
      'password' => Hash::make($request->password),
      'user_role_id' => $teacherRole->id,
    ]);

    return back()->with('success', 'Teacher created successfully');
  }

  // Remove teacher
  public function destroyTeacher($id)
  {
    $teacher = User::findOrFail($id);
    if ($teacher->userRole->role !== 'teacher') {
      abort(403, 'This user is not a teacher.');
    }
    $teacher->delete();
    return back()->with('success', 'Teacher removed successfully');
  }

  public function assignTeacher(Request $request, Module $module)
  {
    $request->validate(['teacher_id' => 'nullable|exists:users,id']);
    $module->teacher_id = $request->teacher_id;

    // Set teacher_name
    $module->teacher_name = $request->teacher_id ? User::find($request->teacher_id)->name : null;
    $module->save();

    return back()->with('success', 'Teacher assigned successfully');
  }

  // Remove student from module
  public function removeStudent($id)
  {
    $enrollment = Enrollment::findOrFail($id);
    $enrollment->delete();
    return back()->with('success', 'Student removed from module');
  }


  // Change user role
  public function changeRole(Request $request, $id)
  {
    $request->validate(['role' => 'required|in:admin,teacher,student,old_student']);
    $user = User::findOrFail($id);

    $roleRecord = UserRole::where('role', $request->role)->firstOrFail();

    $user->user_role_id = $roleRecord->id;
    $user->role = $request->role;  // role column saves the user roles
    $user->save();

    return back()->with('success', 'User role updated successfully');
  }


  // Toggle module active/inactive
  public function toggleActive(Module $module)
  {
    $module->update(['active' => !$module->active]);
    return back()->with('success', 'Module status updated');
  }
}
