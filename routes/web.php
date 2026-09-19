<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\RoleController as AdminRoleController;
use App\Http\Controllers\Admin\StudentController as AdminStudentController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Telecaller\DashboardController as TelecallerDashboardController;
use App\Http\Controllers\Telecaller\StudentController as TelecallerStudentController;
use Illuminate\Support\Facades\Route;

// Root redirect
Route::get('/', function () {
    if (auth()->check()) {
        if (auth()->user()->hasRole(['Super Admin', 'Admin'])) {
            return redirect()->route('admin.dashboard');
        }
        if (auth()->user()->hasRole('Telecaller')) {
            return redirect()->route('telecaller.dashboard');
        }
    }
    return redirect()->route('login');
});

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// ==========================================
// Admin Module Routes
// ==========================================
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'role:Super Admin|Admin'])
    ->group(function () {
        // Dashboard
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Roles & Permissions Management
        Route::resource('roles', AdminRoleController::class)->except(['create', 'show', 'edit']);

        // User Management
        Route::resource('users', AdminUserController::class)->except(['create', 'show', 'edit']);

        // Students Management
        Route::get('/students/sample-csv', [AdminStudentController::class, 'downloadSampleCsv'])->name('students.sample-csv');
        Route::post('/students/bulk-upload', [AdminStudentController::class, 'bulkUpload'])->name('students.bulk-upload');
        Route::post('/students/bulk-assign', [AdminStudentController::class, 'bulkAssign'])->name('students.bulk-assign');
        Route::post('/students/{student}/remark', [AdminStudentController::class, 'addRemark'])->name('students.add-remark');
        Route::resource('students', AdminStudentController::class);
    });

// ==========================================
// Telecaller Module Routes
// ==========================================
Route::prefix('telecaller')
    ->name('telecaller.')
    ->middleware(['auth', 'role:Telecaller|Super Admin|Admin'])
    ->group(function () {
        // Telecaller Dashboard
        Route::get('/dashboard', [TelecallerDashboardController::class, 'index'])->name('dashboard');

        // My Assigned Students
        Route::get('/students', [TelecallerStudentController::class, 'index'])->name('students.index');
        Route::get('/students/{student}', [TelecallerStudentController::class, 'show'])->name('students.show');
        Route::post('/students/{student}/remark', [TelecallerStudentController::class, 'storeRemark'])->name('students.store-remark');
    });
