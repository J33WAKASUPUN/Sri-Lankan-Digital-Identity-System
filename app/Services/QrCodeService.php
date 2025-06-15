<?php
// app/Services/QrCodeService.php
namespace App\Services;

use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\ImagickImageBackEnd;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use Illuminate\Support\Facades\Storage;

class QrCodeService
{
    public function generateQrCode($data, $filename = null)
    {
        try {
            // Create SVG renderer (no GD needed!)
            $renderer = new ImageRenderer(
                new RendererStyle(300, 2),
                new SvgImageBackEnd()
            );

            $writer = new Writer($renderer);
            $qrCodeString = $writer->writeString($data);

            // Generate filename if not provided
            if (!$filename) {
                $filename = 'qr_' . uniqid() . '.svg';
            } else {
                // Change extension to svg
                $filename = pathinfo($filename, PATHINFO_FILENAME) . '.svg';
            }

            $path = 'qr-codes/' . $filename;

            // Store in public disk
            Storage::disk('public')->put($path, $qrCodeString);

            return $path;
        } catch (\Exception $e) {
            throw new \Exception('Failed to generate QR code: ' . $e->getMessage());
        }
    }

    public function generateCardQrCode($digitalCard)
    {
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

        return $this->generateQrCode(
            json_encode($qrData),
            'card_' . $digitalCard->card_number . '.svg'
        );
    }

    /**
     * Generate verification QR code for digital card
     */
    public function generateVerificationQrCode($cardNumber)
    {
        $verifyUrl = route('card.verify', $cardNumber);

        return $this->generateQrCode(
            $verifyUrl,
            'verify_' . $cardNumber . '.svg'
        );
    }

    /**
     * Generate QR code as raw SVG string for inline display
     */
    public function generateQrCodeSvg($data)
    {
        try {
            $renderer = new ImageRenderer(
                new RendererStyle(200, 1),
                new SvgImageBackEnd()
            );

            $writer = new Writer($renderer);
            return $writer->writeString($data);
        } catch (\Exception $e) {
            throw new \Exception('Failed to generate QR code: ' . $e->getMessage());
        }
    }

    /**
     * Delete QR code file
     */
    public function deleteQrCode($path)
    {
        try {
            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
                return true;
            }
            return false;
        } catch (\Exception $e) {
            throw new \Exception('Failed to delete QR code: ' . $e->getMessage());
        }
    }
}
