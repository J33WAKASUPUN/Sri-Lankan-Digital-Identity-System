<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\User;
use App\Models\DigitalCard;
use App\Models\Notification;
use App\Services\ApplicationService;
use App\Services\PdfService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Routing\Controller;

class AdminController extends Controller
{
    protected $applicationService;
    protected $pdfService;

    public function __construct(ApplicationService $applicationService, PdfService $pdfService)
    {
        $this->middleware(function ($request, $next) {
            if (Auth::user()->role !== 'admin') {
                abort(403, 'Access denied. Admin role required.');
            }
            return $next($request);
        });

        $this->applicationService = $applicationService;
        $this->pdfService = $pdfService;
    }

    // Admin Dashboard
    public function dashboard()
    {
        $stats = $this->applicationService->getApplicationStats();

        $recentApplications = Application::with(['user', 'gsVerifier', 'dsVerifier'])
            ->latest()
            ->limit(10)
            ->get();

        $systemStats = [
            'total_users' => User::count(),
            'total_gs' => User::where('role', 'grama_sevaka')->count(),
            'total_ds' => User::where('role', 'divisional_secretariat')->count(),
            'unread_notifications' => Notification::whereNull('read_at')->count()
        ];

        // Make sure to pass ALL variables to the view
        return view('admin.dashboard', compact('stats', 'recentApplications', 'systemStats'));
    }

    // Manage all applications
    public function applications(Request $request)
    {
        $query = Application::with(['user', 'gsVerifier', 'dsVerifier', 'digitalCard']);

        // Filter by status
        if ($request->status) {
            $query->where('status', $request->status);
        }

        // Search by application number or name
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('application_number', 'like', '%' . $request->search . '%')
                    ->orWhere('first_name', 'like', '%' . $request->search . '%')
                    ->orWhere('last_name', 'like', '%' . $request->search . '%');
            });
        }

        $applications = $query->latest()->paginate(20);

        return view('admin.applications', compact('applications'));
    }

    // Manage users
    public function users()
    {
        $users = User::latest()->paginate(20);
        return view('admin.users', compact('users'));
    }

    // Create new user form
    public function createUser()
    {
        return view('admin.create-user');
    }

    // Store new user
    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:applicant,grama_sevaka,divisional_secretariat,admin',
            'office_location' => 'required_if:role,grama_sevaka,divisional_secretariat|string|max:255'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'office_location' => $request->office_location,
            'email_verified_at' => now() // Auto-verify admin created users
        ]);

        return redirect()->route('admin.users')
            ->with('success', 'User created successfully.');
    }

    // Generate reports view
    public function reportsView()
    {
        return view('admin.reports');
    }

    // Download application report
    public function downloadApplicationReport(Request $request)
    {
        $request->validate([
            'status' => 'nullable|in:pending,gs_approved,ds_approved,rejected',
            'date_from' => 'nullable|date',
            'date_to' => 'nullable|date|after_or_equal:date_from'
        ]);

        $query = Application::with(['user', 'gsVerifier', 'dsVerifier']);

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->date_from && $request->date_to) {
            $query->whereBetween('created_at', [$request->date_from, $request->date_to]);
        }

        $applications = $query->get();

        try {
            $pdf = $this->pdfService->generateApplicationReport($applications);
            return $pdf->download('application-report-' . date('Y-m-d') . '.pdf');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to generate report: ' . $e->getMessage());
        }
    }

    // Download system statistics
    public function downloadSystemStats()
    {
        try {
            $pdf = $this->pdfService->generateSystemStats();
            return $pdf->download('system-statistics-' . date('Y-m-d') . '.pdf');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to generate statistics: ' . $e->getMessage());
        }
    }

    // Force change application status (emergency)
    public function forceStatusChange(Request $request, Application $application)
    {
        $request->validate([
            'status' => 'required|in:pending,gs_approved,ds_approved,rejected',
            'reason' => 'required|string|max:500'
        ]);

        $oldStatus = $application->status;

        $application->update([
            'status' => $request->status
        ]);

        // Create notification
        Notification::createForUser(
            $application->user_id,
            'Application Status Changed',
            "Your application {$application->application_number} status has been changed from {$oldStatus} to {$request->status} by administrator. Reason: {$request->reason}"
        );

        return back()->with('success', 'Application status changed successfully.');
    }

    public function digitalCards()
    {
        // Get real statistics from database
        $totalCards = DigitalCard::count();
        $activeCards = DigitalCard::where('status', 'active')->count();
        $expiredCards = DigitalCard::where('status', 'expired')
            ->orWhere('expiry_date', '<', now())
            ->count();
        $suspendedCards = DigitalCard::where('status', 'suspended')->count();
        $issuedToday = DigitalCard::whereDate('created_at', today())->count();

        // Get recent cards with real data
        $recentCards = DigitalCard::with('application')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('admin.digital-cards', compact(
            'totalCards',
            'activeCards',
            'expiredCards',
            'suspendedCards',
            'issuedToday',
            'recentCards'
        ));
    }

    // Detailed reports with statistics
    public function reports()
    {
        // Get real statistics from database
        $totalApplications = Application::count();

        $approvedApplications = Application::where('status', 'ds_approved')->count();
        $pendingApplications = Application::where('status', 'pending')->count();
        $gsApprovedApplications = Application::where('status', 'gs_approved')->count();
        $rejectedApplications = Application::where('status', 'rejected')->count();

        // Calculate processing efficiency (approved vs total)
        $processingEfficiency = $totalApplications > 0
            ? round(($approvedApplications / $totalApplications) * 100, 1)
            : 0;

        // Calculate average processing time for approved applications
        $avgProcessingTime = Application::where('status', 'ds_approved')
            ->selectRaw('AVG(DATEDIFF(updated_at, created_at)) as avg_days')
            ->value('avg_days');
        $avgProcessingTime = round($avgProcessingTime ?? 0, 1);

        // Recent applications for trends
        $recentApplications = Application::with(['user', 'gsVerifier', 'dsVerifier'])
            ->latest()
            ->limit(10)
            ->get();

        // Today's statistics
        $todayApplications = Application::whereDate('created_at', today())->count();
        $todayApproved = Application::where('status', 'ds_approved')
            ->whereDate('updated_at', today())
            ->count();

        // This week's statistics
        $weekApplications = Application::whereBetween('created_at', [
            now()->startOfWeek(),
            now()->endOfWeek()
        ])->count();

        // This month's statistics
        $monthApplications = Application::whereBetween('created_at', [
            now()->startOfMonth(),
            now()->endOfMonth()
        ])->count();

        // System uptime (you can make this dynamic or keep as estimate)
        $systemUptime = 99.9; // You could integrate with your monitoring system

        $data = [
            'totalApplications' => $totalApplications,
            'approvedApplications' => $approvedApplications,
            'pendingApplications' => $pendingApplications,
            'gsApprovedApplications' => $gsApprovedApplications,
            'rejectedApplications' => $rejectedApplications,
            'processingEfficiency' => $processingEfficiency,
            'avgProcessingTime' => $avgProcessingTime,
            'systemUptime' => $systemUptime,
            'todayApplications' => $todayApplications,
            'todayApproved' => $todayApproved,
            'weekApplications' => $weekApplications,
            'monthApplications' => $monthApplications,
            'recentApplications' => $recentApplications,
        ];

        return view('admin.reports', $data);
    }
}
