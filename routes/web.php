<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TimetableScheduler;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
    // return view('welcome');
});

// Ensure that these routes are accessible only to authenticated and verified users
Route::middleware(['auth', 'verified'])->prefix('admin')->group(function () {
    Route::get('/new-users', [AdminController::class, 'showUserList'])->name('admin.user-verify.index');
    Route::put('/new-users/verify/{id}', [AdminController::class, 'updateVerify'])->name('admin.user.verify');

    Route::get('/dashboard', [ProfileController::class, 'showDashboard'])->name('admin.dashboard');

    // Admin Trainer List
    Route::get('/instructor', [InstructorController::class, 'index'])->name('admin.instructor.index');

    // Instructor CRUD
    Route::post('/instructor', [InstructorController::class, 'store'])->name('admin.instructor.store');
    Route::get('/instructor/create', [InstructorController::class, 'create'])->name('admin.instructor.create');
    Route::get('/instructor/{id}/edit', [InstructorController::class, 'edit'])->name('admin.instructor.edit');
    Route::put('/instructor/{id}', [InstructorController::class, 'update'])->name('admin.instructor.update');
    Route::delete('/instructor/{id}', [InstructorController::class, 'destroy'])->name('admin.instructor.destroy');
    

    // Student CRUD
    Route::get('/student', [StudentController::class, 'index'])->name('admin.student.index');
    Route::get('/student/create', [StudentController::class, 'create'])->name('admin.student.create');
    Route::post('/student', [StudentController::class, 'store'])->name('admin.student.store');
    Route::get('/student/{id}/edit', [StudentController::class, 'edit'])->name('admin.student.edit');
    Route::put('/student/{id}', [StudentController::class, 'update'])->name('admin.student.update');
    Route::delete('/student/{id}', [StudentController::class, 'destroy'])->name('admin.student.destroy');

    // Staff CRUD
    Route::get('/staff', [StaffController::class, 'index'])->name('admin.staff.index');
    Route::get('/staff/create', [StaffController::class, 'create'])->name('admin.staff.create');
    Route::post('/staff', [StaffController::class, 'store'])->name('admin.staff.store');
    Route::get('/staff/{id}/edit', [StaffController::class, 'edit'])->name('admin.staff.edit');
    Route::put('/staff/{id}', [StaffController::class, 'update'])->name('admin.staff.update');
    Route::delete('/staff/{id}', [StaffController::class, 'destroy'])->name('admin.staff.destroy');
    Route::get('/{id}/edit', [ProfileController::class, 'edit'])->name('admin.profile.edit');

    Route::get('/time-table', [TimetableScheduler::class, 'index'])->name('admin.time-table.index');
});
Route::middleware(['auth', 'verified'])->prefix('student')->group(function () {
    Route::get('/dashboard', [ProfileController::class, 'showDashboard'])->name('student.dashboard');
    Route::get('/time-table', [TimetableScheduler::class, 'index'])->name('student.time-table.index');
    // Route::get('/dashboard', [StudentController::class, 'index'])->name('student.dashboard');
});

// Profile Routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
require __DIR__.'/auth.php';
