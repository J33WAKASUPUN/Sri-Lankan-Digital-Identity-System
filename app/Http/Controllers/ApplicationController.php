<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\DigitalCard;
use App\Services\ApplicationService;
use App\Services\PdfService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;

class ApplicationController extends Controller
{
    protected $applicationService;
    protected $pdfService;

    public function __construct(ApplicationService $applicationService, PdfService $pdfService)
    {
        $this->applicationService = $applicationService;
        $this->pdfService = $pdfService;
    }

    // Applicant Dashboard
    public function dashboard()
    {
        $user = Auth::user();
        $applications = $user->applications()->latest()->get();
        $notifications = $user->notifications()->unread()->latest()->limit(5)->get();

        return view('applicant.dashboard', compact('applications', 'notifications'));
    }

    // Show application form
    public function create()
    {
        // Check if user already has a pending/approved application
        $existingApp = Auth::user()->applications()
            ->whereIn('status', ['pending', 'gs_approved', 'ds_approved'])
            ->first();

        if ($existingApp) {
            return redirect()->route('applications.show', $existingApp)
                ->with('info', 'You already have an active application.');
        }

        return view('applications.create');
    }

    // Store new application
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date|before:today',
            'gender' => 'required|in:male,female',
            'nationality' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'phone' => 'required|string|max:20',
            'birth_certificate' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'photo' => 'required|file|mimes:jpg,jpeg,png|max:1024'
        ]);

        try {
            $application = $this->applicationService->createApplication(
                Auth::id(),
                $request->all(),
                $request->only(['birth_certificate', 'photo'])
            );

            return redirect()->route('applications.show', $application)
                ->with('success', 'Application submitted successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to submit application: ' . $e->getMessage());
        }
    }

    // Show application details
    public function show(Application $application)
    {
        // Check authorization
        if (Auth::user()->role === 'applicant' && $application->user_id !== Auth::id()) {
            abort(403);
        }

        return view('applications.show', compact('application'));
    }

    // Show application status
    public function status(Application $application)
    {
        if (Auth::user()->role === 'applicant' && $application->user_id !== Auth::id()) {
            abort(403);
        }

        return view('applications.status', compact('application'));
    }

    // Download digital card
    public function downloadCard(Application $application)
    {
        if (Auth::user()->role === 'applicant' && $application->user_id !== Auth::id()) {
            abort(403);
        }

        if (!$application->digitalCard || $application->status !== 'ds_approved') {
            return back()->with('error', 'Digital card not available.');
        }

        try {
            $pdf = $this->pdfService->generateDigitalCard($application->digitalCard);
            return $pdf->download("digital-card-{$application->application_number}.pdf");
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to generate card: ' . $e->getMessage());
        }
    }

    // Optional: Add this method to ApplicationController for debugging
    public function debugApplication(Application $application)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        return response()->json([
            'application' => $application->load('user', 'digitalCard'),
            'qr_code_path' => $application->digitalCard?->qr_code_path,
            'status_history' => [
                'submitted' => $application->created_at,
                'gs_reviewed' => $application->gs_verified_at,
                'ds_reviewed' => $application->ds_verified_at,
            ]
        ]);
    }
}
