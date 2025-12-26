<?php

/*namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\UserRole;
use Illuminate\Support\Facades\Hash;


class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');  
    }

    public function storeTeacher(Request $request)
   {
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:8|confirmed',
    ]);

    $teacherRole = UserRole::where('role', 'teacher')->first();

    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'user_role_id' => $teacherRole->id,
    ]);

    return back()->with('success', 'Teacher created');
  }
}
*/



namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\User;
use App\Models\UserRole;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function dashboard()
    {
        $modules = Module::all();
        $teachers = User::whereHas('userRole', fn($q) => $q->where('role', 'teacher'))->get();
        $users = User::all();
        $enrollments = Enrollment::with(['user', 'module'])->get(); // For removing students

        return view('admin.dashboard', compact('modules', 'teachers', 'users', 'enrollments'));
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

    // Attach teacher to module
    public function assignTeacher(Request $request, $id)
    {
        $request->validate(['teacher_id' => 'nullable|exists:users,id']);
        $module = Module::findOrFail($id);
        $module->teacher_id = $request->teacher_id;
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
        $roleId = UserRole::where('role', $request->role)->firstOrFail()->id;
        $user->user_role_id = $roleId;
        $user->save();
        return back()->with('success', 'User role updated successfully');
    }


    // Toggle module active/inactive
    public function toggleActive($id)
    {
        $module = Module::findOrFail($id);
        $module->update(['active' => !$module->active]);
        return back()->with('success', 'Module status updated');
    }
}