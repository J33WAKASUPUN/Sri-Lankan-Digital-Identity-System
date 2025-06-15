<?php
// app/Http/Controllers/DigitalCardController.php
namespace App\Http\Controllers;

use App\Models\DigitalCard;
use App\Models\Application;
use App\Services\PdfService;
use App\Services\QrCodeService;
use Illuminate\Http\Request;

class DigitalCardController extends Controller
{
    protected $pdfService;
    protected $qrCodeService;

    public function __construct(PdfService $pdfService, QrCodeService $qrCodeService)
    {
        $this->pdfService = $pdfService;
        $this->qrCodeService = $qrCodeService;
    }

    // Show digital card
    public function show(DigitalCard $digitalCard)
    {
        // Generate QR code SVG for display
        $qrCodeSvg = $this->qrCodeService->generateQrCodeSvg(
            json_encode([
                'card_number' => $digitalCard->card_number,
                'verify_url' => route('card.verify.public', $digitalCard->card_number),
                'name' => $digitalCard->application->full_name
            ])
        );

        return view('digital-card.show', compact('digitalCard', 'qrCodeSvg'));
    }

    // Download card as PDF
    public function download(DigitalCard $digitalCard)
    {
        try {
            $pdf = $this->pdfService->generateDigitalCard($digitalCard);
            return $pdf->download("digital-card-{$digitalCard->card_number}.pdf");
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to generate card: ' . $e->getMessage());
        }
    }

    // 🆕 NEW: Show verification form (GET request)
    public function showVerifyForm()
    {
        return view('card.verify-form');
    }

    // 🆕 NEW: Handle verification form submission (POST request)
    public function verifyCard(Request $request)
    {
        // ADD EXTENSIVE DEBUG LOGGING
        \Log::info('=== VERIFY CARD METHOD CALLED ===');
        \Log::info('Request Method: ' . $request->method());
        \Log::info('Request URL: ' . $request->fullUrl());
        \Log::info('All Input: ', $request->all());
        \Log::info('Card Number Input: ' . $request->input('card_number'));
        \Log::info('Has CSRF Token: ' . ($request->hasHeader('X-CSRF-TOKEN') ? 'Yes' : 'No'));

        try {
            $request->validate([
                'card_number' => 'required|string|max:50'
            ]);

            $cardNumber = trim($request->input('card_number'));

            \Log::info('Validation passed, card number: ' . $cardNumber);
            \Log::info('About to call performVerification');

            $result = $this->performVerification($cardNumber);

            \Log::info('performVerification completed');

            return $result;
        } catch (\Exception $e) {
            \Log::error('Error in verifyCard: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            throw $e;
        }
    }

    // 🔄 UPDATED: Verify card by URL parameter (GET request with card number)
    public function verify($cardNumber)
    {
        return $this->performVerification($cardNumber);
    }

    // Common verification logic
    private function performVerification($cardNumber)
    {
        \Log::info('=== PERFORM VERIFICATION CALLED ===');
        \Log::info('Card Number: ' . $cardNumber);

        try {
            $digitalCard = DigitalCard::where('card_number', $cardNumber)
                ->with('application')
                ->first();

            \Log::info('Database query completed');
            \Log::info('Card found: ' . ($digitalCard ? 'Yes' : 'No'));

            if (!$digitalCard) {
                \Log::info('Returning invalid card view');
                return view('card.verify-result', [
                    'card' => null,
                    'cardNumber' => $cardNumber,
                    'message' => 'Invalid card number. No digital ID found with this number.',
                    'status' => 'invalid'
                ]);
            }

            if ($digitalCard->status === 'expired' || $digitalCard->expiry_date < now()) {
                \Log::info('Returning expired card view');
                return view('card.verify-result', [
                    'card' => $digitalCard,
                    'cardNumber' => $cardNumber,
                    'message' => 'This digital ID card has expired.',
                    'status' => 'expired'
                ]);
            }

            \Log::info('Returning valid card view');
            return view('card.verify-result', [
                'card' => $digitalCard,
                'cardNumber' => $cardNumber,
                'message' => 'Valid digital ID card. This card is authentic and active.',
                'status' => 'valid'
            ]);
        } catch (\Exception $e) {
            \Log::error('Error in performVerification: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Generate QR code for existing card (admin function)
     */
    public function regenerateQrCode(DigitalCard $digitalCard)
    {
        try {
            $qrCodePath = $this->qrCodeService->generateCardQrCode($digitalCard);
            $digitalCard->update(['qr_code_path' => $qrCodePath]);

            return back()->with('success', 'QR code regenerated successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to regenerate QR code: ' . $e->getMessage());
        }
    }
}
