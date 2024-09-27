<?php

use App\Http\Middleware\Admin;
use App\Http\Middleware\Instructor;
use App\Http\Middleware\Staff;
use App\Http\Middleware\Student;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
        $middleware->alias([
            'instructor'=>Instructor::class,
            'student'=>Student::class,
            'admin'=>Admin::class,
            'staff'=>Staff::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
