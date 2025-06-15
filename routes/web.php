<?php
// routes/web.php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\GramaSevakaDashboardController;
use App\Http\Controllers\DivisionalSecretariatDashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DigitalCardController;

// ================================
// PUBLIC ROUTES
// ================================

// Home page
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Authentication routes
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Email verification
Route::get('/verify-email/{token}', [AuthController::class, 'verifyEmail'])->name('verify.email');

// Public digital card verification - FIXED ROUTES!
Route::get('/verify-card', [DigitalCardController::class, 'showVerifyForm'])->name('card.verify.form');
Route::post('/verify-card', [DigitalCardController::class, 'verifyCard'])->name('card.verify');
Route::get('/card/verify/{cardNumber}', [DigitalCardController::class, 'verify'])->name('card.verify.public');

// ================================
// AUTHENTICATED ROUTES
// ================================

Route::middleware(['auth', 'verified'])->group(function () {

    // ================================
    // APPLICANT ROUTES
    // ================================
    Route::middleware(['role:applicant'])->group(function () {

        // Dashboard
        Route::get('/dashboard', [ApplicationController::class, 'dashboard'])->name('applicant.dashboard');

        // Application management
        Route::prefix('applications')->name('applications.')->group(function () {
            Route::get('/create', [ApplicationController::class, 'create'])->name('create');
            Route::post('/', [ApplicationController::class, 'store'])->name('store');
            Route::get('/{application}', [ApplicationController::class, 'show'])->name('show');
            Route::get('/{application}/status', [ApplicationController::class, 'status'])->name('status');
            Route::get('/{application}/download-card', [ApplicationController::class, 'downloadCard'])->name('downloadCard');
        });
    });

    // ================================
    // GRAMA SEVAKA ROUTES
    // ================================
    Route::middleware(['role:grama_sevaka'])->prefix('gs')->name('gs.')->group(function () {
        Route::get('/dashboard', [GramaSevakaDashboardController::class, 'dashboard'])->name('dashboard');
        Route::get('/applications', [GramaSevakaDashboardController::class, 'applications'])->name('applications');
        Route::get('/applications/{application}/review', [GramaSevakaDashboardController::class, 'review'])->name('review');
        Route::post('/applications/{application}/approve', [GramaSevakaDashboardController::class, 'approve'])->name('approve');
        Route::post('/applications/{application}/reject', [GramaSevakaDashboardController::class, 'reject'])->name('reject');
        Route::get('/history', [GramaSevakaDashboardController::class, 'history'])->name('history');
    });

    // ================================
    // DIVISIONAL SECRETARIAT ROUTES
    // ================================
    Route::middleware(['role:divisional_secretariat'])->prefix('ds')->name('ds.')->group(function () {
        Route::get('/dashboard', [DivisionalSecretariatDashboardController::class, 'dashboard'])->name('dashboard');
        Route::get('/applications', [DivisionalSecretariatDashboardController::class, 'applications'])->name('applications');
        Route::get('/applications/{application}/review', [DivisionalSecretariatDashboardController::class, 'review'])->name('review');
        Route::post('/applications/{application}/approve', [DivisionalSecretariatDashboardController::class, 'approve'])->name('approve');
        Route::post('/applications/{application}/reject', [DivisionalSecretariatDashboardController::class, 'reject'])->name('reject');
        Route::get('/history', [DivisionalSecretariatDashboardController::class, 'history'])->name('history');
    });

    // ================================
    // ADMIN ROUTES
    // ================================
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/applications', [AdminController::class, 'applications'])->name('applications');
        Route::post('/applications/{application}/force-status', [AdminController::class, 'forceStatusChange'])->name('force.status');

        Route::get('/digital-cards', function () {
            return view('admin.digital-cards');
        })->name('digital-cards');

        Route::get('/security', function () {
            return view('admin.security');
        })->name('security');

        Route::get('/activity-log', function () {
            return view('admin.activity-log');
        })->name('activity-log');

        Route::get('/system-settings', function () {
            return view('admin.system-settings');
        })->name('system-settings');

        Route::get('/users', [AdminController::class, 'users'])->name('users');
        Route::get('/users/create', [AdminController::class, 'createUser'])->name('users.create');
        Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');

        Route::get('/reports', [AdminController::class, 'reports'])->name('reports');
        Route::get('/reports/applications', [AdminController::class, 'downloadApplicationReport'])->name('reports.applications');
        Route::get('/reports/statistics', [AdminController::class, 'downloadSystemStats'])->name('reports.statistics');
        Route::get('/digital-cards', [AdminController::class, 'digitalCards'])->name('digital-cards');
    });

    // ================================
    // DIGITAL CARD ROUTES (All authenticated users)
    // ================================
    Route::prefix('digital-card')->name('digital-card.')->group(function () {
        Route::get('/{digitalCard}', [DigitalCardController::class, 'show'])->name('show');
        Route::get('/{digitalCard}/download', [DigitalCardController::class, 'download'])->name('download');
    });

    // ================================
    // NOTIFICATIONS
    // ================================
    Route::get('/notifications', function () {
        $notifications = Auth::user()->notifications()
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('notifications.index', compact('notifications'));
    })->name('notifications.index');

    Route::post('/notifications/{notification}/mark-read', function ($id) {
        try {
            $notification = Auth::user()->notifications()->findOrFail($id);

            if (is_null($notification->read_at)) {
                $notification->markAsRead();
            }

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => 'Notification not found'], 404);
        }
    })->name('notifications.mark-read');

    Route::post('/notifications/mark-all-read', function () {
        try {
            Auth::user()->unreadNotifications->markAsRead();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => 'Failed to mark all as read'], 500);
        }
    })->name('notifications.mark-all-read');
});

// ================================
// FALLBACK ROUTES
// ================================
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});
