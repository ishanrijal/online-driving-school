<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClassScheduleController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudentInvoiceController;
use App\Http\Controllers\TimetableScheduler;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

// Ensure that these routes are accessible only to authenticated and verified users
Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->group(function () {
    Route::get('/new-users', [AdminController::class, 'showUserList'])->name('admin.user-verify.index');
    Route::put('/new-users/verify/{id}', [AdminController::class, 'updateVerify'])->name('admin.user.verify');

    Route::get('/dashboard', [ProfileController::class, 'showDashboard'])->name('admin.dashboard');
    Route::put('/admin/{id}', [AdminController::class, 'update'])->name('admin.profile.update');

    // Admin Trainer List
    Route::get('/instructor', [InstructorController::class, 'index'])->name('admin.instructor.index');

    // Instructor CRUD
    Route::post('/instructor', [InstructorController::class, 'store'])->name('admin.instructor.store');
    Route::get('/instructor/create', [InstructorController::class, 'create'])->name('admin.instructor.create');
    Route::get('/instructor/{id}/edit', [InstructorController::class, 'edit'])->name('admin.instructor.edit');
    Route::put('/instructor/{id}', [InstructorController::class, 'update'])->name('admin.instructor.update');
    Route::delete('/instructor/{id}', [InstructorController::class, 'destroy'])->name('admin.instructor.destroy');
    
    //Invoice
    Route::get('/invoice', [InvoiceController::class, 'index'])->name('admin.invoice.index');
    Route::post('/invoice', [InvoiceController::class, 'store'])->name('admin.invoice.store');
    Route::get('/invoice/create', [InvoiceController::class, 'create'])->name('admin.invoice.create');
    Route::get('/invoice/{id}/edit', [InvoiceController::class, 'edit'])->name('admin.invoice.edit');
    Route::put('/invoice/{id}', [InvoiceController::class, 'update'])->name('admin.invoice.update');
    Route::delete('/invoice/{id}', [InvoiceController::class, 'destroy'])->name('admin.invoice.destroy');

    //Payment
    Route::get('/payment', [PaymentController::class, 'index'])->name('admin.payment.index');
    Route::post('/payment', [PaymentController::class, 'store'])->name('admin.payment.store');
    Route::get('/payment/create', [PaymentController::class, 'create'])->name('admin.payment.create');
    Route::get('/payment/{id}/edit', [PaymentController::class, 'edit'])->name('admin.payment.edit');
    Route::put('/payment/{id}', [PaymentController::class, 'update'])->name('admin.payment.update');
    Route::delete('/payment/{id}', [PaymentController::class, 'destroy'])->name('admin.payment.destroy');

    //Course
    Route::get('/course', [CourseController::class, 'index'])->name('admin.course.index');
    Route::post('/course', [CourseController::class, 'store'])->name('admin.course.store');
    Route::get('/course/create', [CourseController::class, 'create'])->name('admin.course.create');
    Route::get('/course/{id}/edit', [CourseController::class, 'edit'])->name('admin.course.edit');
    Route::put('/course/{id}', [CourseController::class, 'update'])->name('admin.course.update');
    Route::delete('/course/{id}', [CourseController::class, 'destroy'])->name('admin.course.destroy');

    //CLass Schedules
    Route::get('/time-table', [ClassScheduleController::class, 'index'])->name('admin.classSchedule.index');
    Route::get('/class-schedules', [ClassScheduleController::class, 'getAppointments'])->name('class-schedules');
    Route::post('/class-schedule', [ClassScheduleController::class, 'store'])->name('admin.classSchedule.store');
    Route::get('/class-schedule/create', [ClassScheduleController::class, 'create'])->name('admin.classSchedule.create');
    Route::put('/class-schedule/{id}', [ClassScheduleController::class, 'update'])->name('admin.classSchedule.update');
    Route::get('/class-schedule/{id}/edit-form', [ClassScheduleController::class, 'editForm'])->name('admin.classSchedule.editForm');
    Route::get('/class-schedule/{id}/edit', [ClassScheduleController::class, 'edit'])->name('admin.classSchedule.edit');
    Route::delete('/class-schedule/destroy/{id}', [ClassScheduleController::class, 'destroy'])->name('admin.classSchedule.destroy');

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
});
Route::middleware(['auth', 'verified', 'student'])->prefix('student')->group(function () {
    Route::get('/dashboard', [ProfileController::class, 'showDashboard'])->name('student.dashboard');

    //time table
    Route::get('/time-table', [TimetableScheduler::class, 'index'])->name('student.time-table.index');
    Route::post('/time-table', [TimetableScheduler::class, 'store'])->name('student.classSchedule.store');
    
    Route::get('/courses', [CourseController::class, 'studentCourse'])->name('student.courses');
    Route::get('/courses-list', [CourseController::class, 'studentCourseList'])->name('student.courses.list');

    // Route to show the payment form
    Route::get('/payment/{courseID}', [InvoiceController::class, 'showPaymentForm'])->name('payment.show');
    // Route to handle payment submission
    Route::post('/payment', [InvoiceController::class, 'processPayment'])->name('payment.process');

    Route::get('/invoice', [StudentInvoiceController::class, 'index'])->name('student.invoice.index');
    Route::put('/invoice/{id}', [StudentInvoiceController::class, 'update'])->name('student.invoice.update');
});
Route::middleware(['auth', 'verified', 'instructor'])->prefix('instructor')->group(function () {
    Route::get('/dashboard', [ProfileController::class, 'showDashboard'])->name('instructor.dashboard');
    Route::get('/time-table', [TimetableScheduler::class, 'index'])->name('instructor.time-table.index');
    Route::get('/time-table/{id}/edit', [TimetableScheduler::class, 'edit'])->name('instructor.classSchedule.edit');

    //profile update
    Route::put('/instructor/{id}', [InstructorController::class, 'update'])->name('instructor.update');
});

// Profile Routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
require __DIR__.'/auth.php';
