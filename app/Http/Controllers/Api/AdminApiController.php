<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Module;
use App\Models\User;
use App\Models\UserRole;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminApiController extends Controller
{
  // MODULES 

  public function modules()
  {
    return response()->json(Module::with('teacher')->get());
  }

  public function storeModule(Request $request)
  {
    $request->validate([
      'module' => 'required|string|max:255',
    ]);

    $module = Module::create([
      'module' => $request->module,
      'active' => true,
    ]);

    return response()->json($module, 201);
  }

  public function toggleModule(Module $module)
  {
    $module->update(['active' => !$module->active]);
    return response()->json($module);
  }

  // TEACHERS

  public function teachers()
  {
    return response()->json(
      User::whereHas('userRole', fn($q) => $q->where('role', 'teacher'))->get()
    );
  }

  public function storeTeacher(Request $request)
  {
    $request->validate([
      'name' => 'required|string|max:255',
      'email' => 'required|email|unique:users,email',
      'password' => 'required|min:8',
    ]);

    $teacherRole = UserRole::where('role', 'teacher')->firstOrFail();

    $teacher = User::create([
      'name' => $request->name,
      'email' => $request->email,
      'password' => Hash::make($request->password),
      'user_role_id' => $teacherRole->id,
    ]);

    return response()->json($teacher, 201);
  }

  public function destroyTeacher($id)
  {
    $teacher = User::findOrFail($id);

    if ($teacher->userRole->role !== 'teacher') {
      return response()->json(['error' => 'Not a teacher'], 403);
    }

    $teacher->delete();
    return response()->json(['message' => 'Teacher deleted']);
  }

  // ASSIGN TEACHER

  public function assignTeacher(Request $request, Module $module)
  {
    $request->validate([
      'teacher_id' => 'nullable|exists:users,id',
    ]);

    $module->teacher_id = $request->teacher_id;
    $module->teacher_name = $request->teacher_id
      ? User::find($request->teacher_id)->name
      : null;

    $module->save();

    return response()->json($module);
  }

  //  STUDENTS / ENROLLMENTS 

  public function enrollments()
  {
    return response()->json(
      Enrollment::with(['student', 'module'])->get()
    );
  }

  public function removeStudent($id)
  {
    Enrollment::findOrFail($id)->delete();
    return response()->json(['message' => 'Student removed']);
  }

  //  USERS 

  public function users()
  {
    return response()->json(User::with('userRole')->get());
  }

  public function changeRole(Request $request, $id)
  {
    $request->validate([
      'role' => 'required|in:admin,teacher,student,old_student',
    ]);

    $user = User::findOrFail($id);
    $role = UserRole::where('role', $request->role)->firstOrFail();

    $user->user_role_id = $role->id;
    $user->role = $request->role;
    $user->save();

    return response()->json($user);
  }
}
