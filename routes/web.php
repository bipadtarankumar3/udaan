<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\RoleController as AdminRoleController;
use App\Http\Controllers\Admin\StudentController as AdminStudentController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Telecaller\DashboardController as TelecallerDashboardController;
use App\Http\Controllers\Telecaller\StudentController as TelecallerStudentController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\FrontendController;

// ==========================================
// Frontend Public Routes
// ==========================================
Route::name('frontend.')->group(function () {
    Route::get('/', [FrontendController::class, 'index'])->name('index');
    Route::get('/apply', [FrontendController::class, 'apply'])->name('apply');
    Route::post('/apply', [FrontendController::class, 'storeApply'])->name('apply.submit');
    Route::get('/confirmation', [FrontendController::class, 'confirmation'])->name('confirmation');
    Route::get('/courses', [FrontendController::class, 'courses'])->name('courses');
    Route::get('/process', [FrontendController::class, 'process'])->name('process');
    Route::get('/enrollment', [FrontendController::class, 'enrollment'])->name('enrollment');
    Route::get('/news', [FrontendController::class, 'news'])->name('news');
    Route::get('/videos', [FrontendController::class, 'videos'])->name('videos');
    Route::get('/partners', [FrontendController::class, 'partners'])->name('partners');
    Route::get('/contact', [FrontendController::class, 'contact'])->name('contact');
    Route::post('/contact', [FrontendController::class, 'storeContact'])->name('contact.submit');
    Route::get('/services', [FrontendController::class, 'services'])->name('services');
    Route::get('/programs', [FrontendController::class, 'programs'])->name('programs');
});

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest')->name('login.submit');
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
        Route::post('/users/{user}/impersonate', [AdminUserController::class, 'impersonate'])->name('users.impersonate');
        Route::resource('users', AdminUserController::class)->except(['create', 'show', 'edit']);

        // Students Management
        Route::get('/students/sample-csv', [AdminStudentController::class, 'downloadSampleCsv'])->name('students.sample-csv');
        Route::post('/students/bulk-upload', [AdminStudentController::class, 'bulkUpload'])->name('students.bulk-upload');
        Route::post('/students/bulk-assign', [AdminStudentController::class, 'bulkAssign'])->name('students.bulk-assign');
        Route::post('/students/{student}/remark', [AdminStudentController::class, 'addRemark'])->name('students.add-remark');
        Route::resource('students', AdminStudentController::class);
    });

// Leave Staff Impersonation Mode
Route::match(['get', 'post'], '/impersonate/leave', [AdminUserController::class, 'leaveImpersonation'])
    ->middleware('auth')
    ->name('impersonate.leave');

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
