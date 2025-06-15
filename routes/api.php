<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Application;
use App\Models\DigitalCard;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Public API Routes
Route::prefix('v1')->group(function () {

    // System Status
    Route::get('/status', function () {
        return response()->json([
            'status' => 'online',
            'system' => 'Sri Lanka Digital ID System',
            'version' => '1.0.0',
            'timestamp' => now()->toISOString(),
        ]);
    });

    // Card Verification (Public)
    Route::get('/verify-card/{cardNumber}', function ($cardNumber) {
        $card = DigitalCard::where('card_number', $cardNumber)
            ->with('application:id,first_name,last_name,gender,nationality')
            ->first();

        if (!$card) {
            return response()->json([
                'valid' => false,
                'message' => 'Invalid card number',
            ], 404);
        }

        if ($card->status === 'expired' || $card->expiry_date < now()) {
            return response()->json([
                'valid' => false,
                'message' => 'Card has expired',
                'expiry_date' => $card->expiry_date->format('Y-m-d'),
            ], 400);
        }

        return response()->json([
            'valid' => true,
            'message' => 'Valid digital ID card',
            'card_number' => $card->card_number,
            'holder_name' => $card->application->first_name . ' ' . $card->application->last_name,
            'gender' => $card->application->gender,
            'nationality' => $card->application->nationality,
            'issue_date' => $card->issue_date->format('Y-m-d'),
            'expiry_date' => $card->expiry_date->format('Y-m-d'),
            'status' => $card->status,
        ]);
    });

    // Application Status Check (Public with application number)
    Route::get('/application-status/{applicationNumber}', function ($applicationNumber) {
        $application = Application::where('application_number', $applicationNumber)
            ->first(['id', 'application_number', 'status', 'submitted_at', 'gs_verified_at', 'ds_verified_at']);

        if (!$application) {
            return response()->json([
                'found' => false,
                'message' => 'Application not found',
            ], 404);
        }

        return response()->json([
            'found' => true,
            'application_number' => $application->application_number,
            'status' => $application->status,
            'status_description' => $this->getStatusDescription($application->status),
            'submitted_at' => $application->submitted_at?->format('Y-m-d H:i:s'),
            'gs_verified_at' => $application->gs_verified_at?->format('Y-m-d H:i:s'),
            'ds_verified_at' => $application->ds_verified_at?->format('Y-m-d H:i:s'),
        ]);
    });

});

// Protected API Routes (Require Authentication)
Route::middleware(['auth:sanctum', 'verified'])->prefix('v1')->group(function () {

    // User Profile
    Route::get('/user', function (Request $request) {
        return response()->json([
            'user' => $request->user()->only(['id', 'name', 'email', 'role', 'office_location']),
        ]);
    });

    // User Applications
    Route::get('/my-applications', function (Request $request) {
        $applications = $request->user()->applications()
            ->select(['id', 'application_number', 'status', 'submitted_at', 'created_at'])
            ->latest()
            ->get();

        return response()->json([
            'applications' => $applications,
            'total_count' => $applications->count(),
        ]);
    });

    // System Statistics (Admin only)
    Route::middleware(['role:admin'])->get('/statistics', function () {
        return response()->json([
            'total_applications' => Application::count(),
            'pending_applications' => Application::where('status', 'pending')->count(),
            'gs_approved' => Application::where('status', 'gs_approved')->count(),
            'ds_approved' => Application::where('status', 'ds_approved')->count(),
            'rejected_applications' => Application::where('status', 'rejected')->count(),
            'total_cards_issued' => DigitalCard::count(),
            'total_users' => User::count(),
            'total_gs_officers' => User::where('role', 'grama_sevaka')->count(),
            'total_ds_officers' => User::where('role', 'divisional_secretariat')->count(),
            'generated_at' => now()->toISOString(),
        ]);
    });

    // Notifications
    Route::get('/notifications', function (Request $request) {
        $notifications = $request->user()->notifications()
            ->latest()
            ->limit(20)
            ->get(['id', 'title', 'message', 'read_at', 'created_at']);

        return response()->json([
            'notifications' => $notifications,
            'unread_count' => $request->user()->notifications()->whereNull('read_at')->count(),
        ]);
    });

    // Mark notification as read
    Route::post('/notifications/{notification}/mark-read', function (Request $request, $notificationId) {
        $notification = $request->user()->notifications()->findOrFail($notificationId);
        $notification->markAsRead();

        return response()->json([
            'message' => 'Notification marked as read',
        ]);
    });

});

// Helper function for status descriptions
function getStatusDescription($status)
{
    $descriptions = [
        'pending' => 'Application submitted and pending Grama Sevaka review',
        'gs_approved' => 'Approved by Grama Sevaka, pending Divisional Secretariat review',
        'ds_approved' => 'Application approved and digital card generated',
        'rejected' => 'Application rejected',
    ];

    return $descriptions[$status] ?? 'Unknown status';
}
