<?php
/*
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php'; */




use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ProfileController;

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
  // Route::prefix('admin')->middleware('role:admin')->group(function () {
  //     Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
  //     // Add more admin routes later (add module, etc.)
  // });

  //   Route::prefix('admin')->middleware('role:admin')->group(function () {
  //   Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

  //   // Add this line for creating teachers
  //   Route::post('/teachers', [AdminController::class, 'storeTeacher'])->name('admin.teachers.store');

  //   // Add other admin routes as needed later
  //  });

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
