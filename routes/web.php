<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClassScheduleController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\InvoiceController;
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

// staff routes
Route::middleware(['auth', 'verified', 'staff'])->prefix('staff')->group(function () {
    Route::get('/dashboard', [ProfileController::class, 'showDashboard'])->name('staff.dashboard');
    
    Route::put('/staff/{id}', [StaffController::class, 'profileUpdate'])->name('staff.profile.update');

    Route::get('/new-users', [StaffController::class, 'showUserList'])->name('staff.user-verify.index');
    Route::put('/new-users/verify/{id}', [StaffController::class, 'updateVerify'])->name('staff.user.verify');

    // Instructor Management
    Route::get('/instructor', [InstructorController::class, 'index'])->name('staff.instructor.index');
    Route::post('/instructor', [InstructorController::class, 'store'])->name('staff.instructor.store');
    Route::get('/instructor/create', [InstructorController::class, 'create'])->name('staff.instructor.create');
    Route::get('/instructor/{id}/edit', [InstructorController::class, 'edit'])->name('staff.instructor.edit');
    Route::put('/instructor/{id}', [InstructorController::class, 'update'])->name('staff.instructor.update');
    Route::delete('/instructor/{id}', [InstructorController::class, 'destroy'])->name('staff.instructor.destroy');

    // Student Management
    Route::get('/student', [StudentController::class, 'index'])->name('staff.student.index');
    Route::get('/student/create', [StudentController::class, 'create'])->name('staff.student.create');
    Route::post('/student', [StudentController::class, 'store'])->name('staff.student.store');
    Route::get('/student/{id}/edit', [StudentController::class, 'edit'])->name('staff.student.edit');
    Route::put('/student/{id}', [StudentController::class, 'update'])->name('staff.student.update');
    Route::delete('/student/{id}', [StudentController::class, 'destroy'])->name('staff.student.destroy');


    //Invoice
    Route::get('/invoice', [InvoiceController::class, 'index'])->name('staff.invoice.index');
    Route::post('/invoice', [InvoiceController::class, 'store'])->name('staff.invoice.store');
    Route::get('/invoice/create', [InvoiceController::class, 'create'])->name('staff.invoice.create');
    Route::get('/invoice/{id}/edit', [InvoiceController::class, 'edit'])->name('staff.invoice.edit');
    Route::put('/invoice/{id}', [InvoiceController::class, 'update'])->name('staff.invoice.update');
    Route::delete('/invoice/{id}', [InvoiceController::class, 'destroy'])->name('staff.invoice.destroy');

    //Course
    Route::get('/course', [CourseController::class, 'index'])->name('staff.course.index');
    Route::post('/course', [CourseController::class, 'store'])->name('staff.course.store');
    Route::get('/course/create', [CourseController::class, 'create'])->name('staff.course.create');
    Route::get('/course/{id}/edit', [CourseController::class, 'edit'])->name('staff.course.edit');
    Route::put('/course/{id}', [CourseController::class, 'update'])->name('staff.course.update');
    Route::delete('/course/{id}', [CourseController::class, 'destroy'])->name('staff.course.destroy');

    //CLass Schedules
    Route::get('/time-table', [ClassScheduleController::class, 'index'])->name('staff.classSchedule.index');
    Route::get('/class-schedules', [ClassScheduleController::class, 'getAppointments'])->name('class-schedules');
    Route::post('/class-schedule', [ClassScheduleController::class, 'store'])->name('staff.classSchedule.store');
    Route::get('/class-schedule/create', [ClassScheduleController::class, 'create'])->name('staff.classSchedule.create');
    Route::put('/class-schedule/{id}', [ClassScheduleController::class, 'update'])->name('staff.classSchedule.update');
    Route::get('/class-schedule/{id}/edit-form', [ClassScheduleController::class, 'editForm'])->name('staff.classSchedule.editForm');
    Route::get('/class-schedule/{id}/edit', [ClassScheduleController::class, 'edit'])->name('staff.classSchedule.edit');
    Route::delete('/class-schedule/destroy/{id}', [ClassScheduleController::class, 'destroy'])->name('staff.classSchedule.destroy');
    
    Route::get('/{id}/edit', [ProfileController::class, 'edit'])->name('admin.profile.edit');
});
Route::middleware(['auth', 'verified', 'student'])->prefix('student')->group(function () {
    Route::get('/dashboard', [ProfileController::class, 'showDashboard'])->name('student.dashboard');

    //time table
    Route::get('/time-table', [TimetableScheduler::class, 'index'])->name('student.time-table.index');
    Route::post('/time-table', [TimetableScheduler::class, 'store'])->name('student.classSchedule.store');
    Route::get('/time-table/{id}/edit', [TimetableScheduler::class, 'edit'])->name('instructor.classSchedule.edit');
    
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

    Route::get('/check-appointment', [TimetableScheduler::class, 'index'])->name('instructor.time-table.index');

    Route::get('/appointment-list', [TimetableScheduler::class, 'appointmentIndex'])->name('instructor.check-appointment.index');
    Route::put('/appointment-list/{id}/confirm', [TimetableScheduler::class, 'confirmStatus'])->name('instructor.status-confirm');
    Route::put('/appointment-list/{id}', [TimetableScheduler::class, 'cancleStatus'])->name('instructor.status.cancel');   


    Route::get('/time-table/{id}/edit', [TimetableScheduler::class, 'edit'])->name('instructor.classSchedule.edit');
    //profile update
    Route::put('/instructor/{id}', [InstructorController::class, 'profileUpdate'])->name('instructor.profileupdate');
});

// Profile Routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
require __DIR__.'/auth.php';
