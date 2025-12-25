<?php

namespace App\Http\Controllers;

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
