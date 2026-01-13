<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Api\AdminApiController;

require __DIR__ . '/auth.php';

// //Public welcome page
// Route::get('/', function () {
//   return view('welcome');
// })->name('home');

Route::get('/', function () {
  return view('index');
})->name('home');


// Authenticated routes
Route::middleware(['auth', 'verified'])->group(function () {
  // Profile routes (from Breeze)
  Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
  Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
  Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

  // Central dashboard redirect
  Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


  //// Admin routes (protected by role middleware)
  Route::prefix('admin')->middleware('role:admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::post('/modules', [AdminController::class, 'storeModule'])->name('admin.modules.store');
    Route::patch('/modules/{module:slug}/toggle', [AdminController::class, 'toggleActive'])->name('admin.modules.toggle');
    Route::post('/modules/{module:slug}/assign-teacher', [AdminController::class, 'assignTeacher'])->name('admin.modules.assign');
    Route::post('/teachers', [AdminController::class, 'storeTeacher'])->name('admin.teachers.store');
    Route::delete('/teachers/{id}', [AdminController::class, 'destroyTeacher'])->name('admin.teachers.destroy');
    Route::delete('/enrollments/{id}', [AdminController::class, 'removeStudent'])->name('admin.enrollments.remove');
    Route::post('/users/{id}/change-role', [AdminController::class, 'changeRole'])->name('admin.users.change-role');
  });


  // Teacher routes
  Route::prefix('teacher')->middleware('role:teacher')->group(function () {
    Route::get('/dashboard', [TeacherController::class, 'dashboard'])->name('teacher.dashboard');
    Route::post('/enrollments/{id}/grade', [TeacherController::class, 'grade'])->name('teacher.grade');
  });

  // Student routes (Old Students can access but not enroll)
  Route::prefix('student')->middleware('role:student|old_student')->group(function () {
    Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('student.dashboard');
    // Only current students can enroll
    Route::post('/enrol/{module}', [StudentController::class, 'enrol'])
      ->name('student.enrol')
      ->middleware('role:student');
  });
});





//API routes
//for the API connection using POSTMAN

Route::prefix('api')->group(function () {

  Route::get('/test', fn() => response()->json(['message' => 'API works']));

  // Modules
  Route::get('/modules', [AdminApiController::class, 'modules']);
  Route::post('/modules', [AdminApiController::class, 'storeModule']);
  Route::patch('/modules/{module}/toggle', [AdminApiController::class, 'toggleModule']);

  // Teachers
  Route::get('/teachers', [AdminApiController::class, 'teachers']);
  Route::post('/teachers', [AdminApiController::class, 'storeTeacher']);
  Route::delete('/teachers/{id}', [AdminApiController::class, 'destroyTeacher']);

  // Assign teacher
  Route::post('/modules/{module}/assign-teacher', [AdminApiController::class, 'assignTeacher']);

  // Enrollments / students
  Route::get('/enrollments', [AdminApiController::class, 'enrollments']);
  Route::delete('/enrollments/{id}', [AdminApiController::class, 'removeStudent']);

  // Users
  Route::get('/users', [AdminApiController::class, 'users']);
  Route::post('/users/{id}/change-role', [AdminApiController::class, 'changeRole']);
});
