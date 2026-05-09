<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

Route::get('/login', fn() => view('login'))->name('login');

Route::post('/login', function (Request $request) {
    if (Auth::attempt($request->only('email', 'password'))) {
        return redirect('/admin/dashboard');
    }
    return back()->withErrors(['email' => 'Invalid credentials.']);
});

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {

    Route::get('/dashboard',                      [AdminController::class, 'dashboard']);
    Route::get('/users',                          [AdminController::class, 'users']);
    Route::get('/users/{user}/tasks',             [AdminController::class, 'userTasks'])->name('admin.user.tasks');
    Route::get('/tasks',                          [AdminController::class, 'tasks']);
    Route::delete('/tasks/{task}/delete',         [AdminController::class, 'softDelete'])->name('admin.tasks.delete');
    Route::get('/tasks/export',                   [AdminController::class, 'export'])->name('admin.tasks.export');
});