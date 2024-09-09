<?php

use App\Http\Controllers\InstructorController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TrainerController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
    // return view('welcome');
});

// Ensure that these routes are accessible only to authenticated and verified users
Route::middleware(['auth', 'verified'])->prefix('admin')->group(function () {
    // Admin Dashboard
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    // Admin Trainer List
    Route::get('/instructor', [InstructorController::class, 'index'])->name('admin.instructor.index');

    // Instructor CRUDE
    Route::post('/instructor', [InstructorController::class, 'store'])->name('admin.instructor.store');
    Route::get('/instructor/create', [InstructorController::class, 'create'])->name('admin.instructor.create');
    Route::get('/instructor/{id}/edit', [InstructorController::class, 'edit'])->name('admin.instructor.edit');
    Route::put('/instructor/{id}', [InstructorController::class, 'update'])->name('admin.instructor.update');
    Route::delete('/instructor/{id}', [InstructorController::class, 'destroy'])->name('admin.instructor.destroy');

    // Student CRUDE
    Route::get('/student', [StudentController::class, 'index'])->name('admin.student.index');
    Route::get('/student/create', [StudentController::class, 'create'])->name('admin.student.create');
    Route::post('/student', [StudentController::class, 'store'])->name('admin.student.store');
    Route::get('/student/{id}/edit', [StudentController::class, 'edit'])->name('admin.student.edit');
    Route::put('/student/{id}', [StudentController::class, 'update'])->name('admin.student.update');
    Route::delete('/student/{id}', [StudentController::class, 'destroy'])->name('admin.student.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
require __DIR__.'/auth.php';
