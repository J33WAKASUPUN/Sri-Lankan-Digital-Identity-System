<?php
namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Notification;
use App\Services\ApplicationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;use Illuminate\Routing\Controller;

class GramaSevakaDashboardController extends Controller
{
    protected $applicationService;

    public function __construct(ApplicationService $applicationService)
    {
        $this->middleware(function ($request, $next) {
            if (Auth::user()->role !== 'grama_sevaka') {
                abort(403, 'Access denied. Grama Sevaka role required.');
            }
            return $next($request);
        });

        $this->applicationService = $applicationService;
    }

    // GS Dashboard
    public function dashboard()
    {
        $stats = [
            'pending_review' => Application::where('status', 'pending')->count(),
            'approved_by_me' => Application::where('gs_verified_by', Auth::id())->count(),
            'rejected_by_me' => Application::where('status', 'rejected')
                ->where('gs_verified_by', Auth::id())->count(),
            'today_processed' => Application::where('gs_verified_by', Auth::id())
                ->whereDate('gs_verified_at', today())->count()
        ];

        $pendingApplications = Application::where('status', 'pending')
            ->with('user')
            ->latest()
            ->limit(10)
            ->get();

        return view('gs.dashboard', compact('stats', 'pendingApplications'));
    }

    // List all pending applications
    public function applications()
    {
        $applications = Application::where('status', 'pending')
            ->with('user')
            ->latest()
            ->paginate(20);

        return view('gs.applications', compact('applications'));
    }

    // Show application for review
    public function review(Application $application)
    {
        if ($application->status !== 'pending') {
            return redirect()->route('gs.applications')
                ->with('error', 'This application is not available for review.');
        }

        return view('gs.review', compact('application'));
    }

    // Approve application
    public function approve(Request $request, Application $application)
    {
        $request->validate([
            'comments' => 'nullable|string|max:500'
        ]);

        if ($application->status !== 'pending') {
            return back()->with('error', 'Application cannot be approved.');
        }

        try {
            $this->applicationService->approveByGS(
                $application->id,
                Auth::id(),
                $request->comments
            );

            return redirect()->route('gs.applications')
                ->with('success', 'Application approved and forwarded to Divisional Secretariat.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to approve application: ' . $e->getMessage());
        }
    }

    // Reject application
    public function reject(Request $request, Application $application)
    {
        $request->validate([
            'comments' => 'required|string|max:500'
        ]);

        if ($application->status !== 'pending') {
            return back()->with('error', 'Application cannot be rejected.');
        }

        try {
            $this->applicationService->rejectApplication(
                $application->id,
                Auth::id(),
                $request->comments
            );

            return redirect()->route('gs.applications')
                ->with('success', 'Application rejected successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to reject application: ' . $e->getMessage());
        }
    }

    // View processing history
    public function history()
    {
        $applications = Application::where('gs_verified_by', Auth::id())
            ->with('user')
            ->latest('gs_verified_at')
            ->paginate(20);

        return view('gs.history', compact('applications'));
    }
}
