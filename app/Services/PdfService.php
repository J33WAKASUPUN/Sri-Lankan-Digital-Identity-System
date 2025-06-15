<?php
// app/Services/PdfService.php
namespace App\Services;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\DigitalCard;
use App\Models\Application;
use App\Services\QrCodeService; // 💖 ADD THIS!

class PdfService
{
    protected $qrCodeService; // 💖 ADD THIS!

    public function __construct(QrCodeService $qrCodeService) // 💖 INJECT QR SERVICE!
    {
        $this->qrCodeService = $qrCodeService;
    }

    public function generateDigitalCard(DigitalCard $digitalCard)
    {
        try {
            // Generate QR code as base64 SVG for PDF embedding
            $qrData = [
                'card_number' => $digitalCard->card_number,
                'name' => $digitalCard->application->full_name,
                'dob' => $digitalCard->application->date_of_birth->format('Y-m-d'),
                'gender' => $digitalCard->application->gender,
                'nationality' => $digitalCard->application->nationality,
                'issued_date' => $digitalCard->issue_date->format('Y-m-d'),
                'expiry_date' => $digitalCard->expiry_date->format('Y-m-d'),
                'verify_url' => route('card.verify', $digitalCard->card_number),
                'hash' => hash('sha256', $digitalCard->card_number . $digitalCard->application->full_name)
            ];

            $qrCodeSvg = $this->qrCodeService->generateQrCodeSvg(json_encode($qrData));

            // Convert SVG to base64 for PDF
            $qrCodeBase64 = 'data:image/svg+xml;base64,' . base64_encode($qrCodeSvg);

            $data = [
                'card' => $digitalCard,
                'application' => $digitalCard->application,
                'qrCodeBase64' => $qrCodeBase64, // 💖 New QR code format!
                'generated_at' => now()->format('Y-m-d H:i:s')
            ];

            $pdf = PDF::loadView('pdf.digital-card', $data);
            $pdf->setPaper([0, 0, 323.15, 204.09], 'portrait'); // Credit card size in points

            return $pdf;
        } catch (\Exception $e) {
            throw new \Exception('Failed to generate digital card PDF: ' . $e->getMessage());
        }
    }

    public function generateApplicationReport($applications)
    {
        try {
            $data = [
                'applications' => $applications,
                'generated_at' => now(),
                'total_count' => $applications->count(),
                'report_title' => 'Digital ID Application Report'
            ];

            $pdf = PDF::loadView('pdf.application-report', $data);
            $pdf->setPaper('A4', 'landscape');

            return $pdf;
        } catch (\Exception $e) {
            throw new \Exception('Failed to generate application report: ' . $e->getMessage());
        }
    }

    public function generateSystemStats()
    {
        try {
            $stats = [
                'total_applications' => Application::count(),
                'pending_applications' => Application::where('status', 'pending')->count(),
                'gs_approved' => Application::where('status', 'gs_approved')->count(),
                'ds_approved' => Application::where('status', 'ds_approved')->count(),
                'rejected' => Application::where('status', 'rejected')->count(),
                'total_cards' => DigitalCard::count(),
                'monthly_stats' => $this->getMonthlyStats(),
                'generated_at' => now()
            ];

            $pdf = PDF::loadView('pdf.system-stats', ['stats' => $stats]);
            $pdf->setPaper('A4', 'portrait');

            return $pdf;
        } catch (\Exception $e) {
            throw new \Exception('Failed to generate system stats: ' . $e->getMessage());
        }
    }

    private function getMonthlyStats()
    {
        $months = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $months[] = [
                'month' => $date->format('M Y'),
                'applications' => Application::whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->count(),
                'approved' => Application::where('status', 'ds_approved')
                    ->whereYear('ds_verified_at', $date->year)
                    ->whereMonth('ds_verified_at', $date->month)
                    ->count()
            ];
        }
        return $months;
    }

    /**
     * Generate certificate of authenticity for digital card
     */
    public function generateCertificate(DigitalCard $digitalCard)
    {
        try {
            $data = [
                'card' => $digitalCard,
                'application' => $digitalCard->application,
                'issued_date' => now(),
                'certificate_number' => 'CERT-' . strtoupper(uniqid())
            ];

            $pdf = PDF::loadView('pdf.certificate', $data);
            $pdf->setPaper('A4', 'portrait');

            return $pdf;
        } catch (\Exception $e) {
            throw new \Exception('Failed to generate certificate: ' . $e->getMessage());
        }
    }
}
