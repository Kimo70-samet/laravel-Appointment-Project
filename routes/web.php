<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AppointmentController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Auth::routes();

Route::middleware(['auth', 'check.user.status'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
    
    Route::resource('appointments', AppointmentController::class);
    Route::get('/calendar', [AppointmentController::class, 'calendar'])->name('appointments.calendar');
    
    Route::post('/logout', function () {
        auth()->logout();
        return redirect('/');
    })->name('logout');
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [App\Http\Controllers\AdminController::class, 'index'])->name('dashboard');
    Route::get('/users', [App\Http\Controllers\AdminController::class, 'users'])->name('users');
    
    // User management actions
    Route::post('/users/{user}/approve', [App\Http\Controllers\AdminController::class, 'approveUser'])->name('users.approve');
    Route::post('/users/{user}/reject', [App\Http\Controllers\AdminController::class, 'rejectUser'])->name('users.reject');
    Route::delete('/users/{user}', [App\Http\Controllers\AdminController::class, 'deleteUser'])->name('users.delete');
    Route::post('/users/{user}/promote', [App\Http\Controllers\AdminController::class, 'promoteUser'])->name('users.promote');
    Route::post('/users/{user}/demote', [App\Http\Controllers\AdminController::class, 'demoteUser'])->name('users.demote');
});
