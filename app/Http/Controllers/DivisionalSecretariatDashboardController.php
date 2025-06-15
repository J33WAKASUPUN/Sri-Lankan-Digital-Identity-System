<?php
namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\DigitalCard;
use App\Services\ApplicationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;

class DivisionalSecretariatDashboardController extends Controller
{
    protected $applicationService;

    public function __construct(ApplicationService $applicationService)
    {
        $this->middleware(function ($request, $next) {
            if (Auth::user()->role !== 'divisional_secretariat') {
                abort(403, 'Access denied. Divisional Secretariat role required.');
            }
            return $next($request);
        });

        $this->applicationService = $applicationService;
    }

    // DS Dashboard
    public function dashboard()
    {
        $stats = [
            'pending_review' => Application::where('status', 'gs_approved')->count(),
            'approved_by_me' => Application::where('ds_verified_by', Auth::id())->count(),
            'cards_issued' => DigitalCard::whereHas('application', function($q) {
                $q->where('ds_verified_by', Auth::id());
            })->count(),
            'today_processed' => Application::where('ds_verified_by', Auth::id())
                ->whereDate('ds_verified_at', today())->count()
        ];

        $pendingApplications = Application::where('status', 'gs_approved')
            ->with(['user', 'gsVerifier'])
            ->latest()
            ->limit(10)
            ->get();

        return view('ds.dashboard', compact('stats', 'pendingApplications'));
    }

    // List all GS approved applications
    public function applications()
    {
        $applications = Application::where('status', 'gs_approved')
            ->with(['user', 'gsVerifier'])
            ->latest()
            ->paginate(20);

        return view('ds.applications', compact('applications'));
    }

    // Show application for final review
    public function review(Application $application)
    {
        if ($application->status !== 'gs_approved') {
            return redirect()->route('ds.applications')
                ->with('error', 'This application is not available for review.');
        }

        return view('ds.review', compact('application'));
    }

    // Final approval and card generation
    public function approve(Request $request, Application $application)
    {
        $request->validate([
            'comments' => 'nullable|string|max:500'
        ]);

        if ($application->status !== 'gs_approved') {
            return back()->with('error', 'Application cannot be approved.');
        }

        try {
            $this->applicationService->approveByDS(
                $application->id,
                Auth::id(),
                $request->comments
            );

            return redirect()->route('ds.applications')
                ->with('success', 'Application approved and digital card generated successfully!');
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

        if ($application->status !== 'gs_approved') {
            return back()->with('error', 'Application cannot be rejected.');
        }

        try {
            $this->applicationService->rejectApplication(
                $application->id,
                Auth::id(),
                $request->comments
            );

            return redirect()->route('ds.applications')
                ->with('success', 'Application rejected successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to reject application: ' . $e->getMessage());
        }
    }

    // View processing history
    public function history()
    {
        $applications = Application::where('ds_verified_by', Auth::id())
            ->with(['user', 'gsVerifier', 'digitalCard'])
            ->latest('ds_verified_at')
            ->paginate(20);

        return view('ds.history', compact('applications'));
    }
}
