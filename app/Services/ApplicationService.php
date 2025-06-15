<?php
namespace App\Services;

use App\Models\Application;
use App\Models\DigitalCard;
use App\Models\Notification;
use Illuminate\Support\Facades\Storage;

class ApplicationService
{
    protected $qrCodeService;
    protected $emailService;

    public function __construct(QrCodeService $qrCodeService, EmailService $emailService)
    {
        $this->qrCodeService = $qrCodeService;
        $this->emailService = $emailService;
    }

    public function createApplication($userId, $data, $files)
    {
        try {
            // Handle file uploads
            $birthCertPath = $files['birth_certificate']->store('documents', 'public');
            $photoPath = $files['photo']->store('photos', 'public');

            // Create application
            $application = Application::create([
                'user_id' => $userId,
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'date_of_birth' => $data['date_of_birth'],
                'gender' => $data['gender'],
                'nationality' => $data['nationality'],
                'address' => $data['address'],
                'phone' => $data['phone'],
                'birth_certificate_path' => $birthCertPath,
                'photo_path' => $photoPath,
                'status' => 'pending',
                'submitted_at' => now()
            ]);

            // Create notification
            Notification::notifyApplicationUpdate(
                $userId,
                $application->application_number,
                'pending'
            );

            // Send email
            $this->emailService->sendApplicationStatusUpdate($application, 'submitted');

            return $application;
        } catch (\Exception $e) {
            throw new \Exception('Failed to create application: ' . $e->getMessage());
        }
    }

    public function approveByGS($applicationId, $gsUserId, $comments = null)
    {
        try {
            $application = Application::findOrFail($applicationId);

            $application->update([
                'status' => 'gs_approved',
                'gs_verified_by' => $gsUserId,
                'gs_verified_at' => now(),
                'gs_comments' => $comments
            ]);

            // Create notification
            Notification::notifyApplicationUpdate(
                $application->user_id,
                $application->application_number,
                'gs_approved'
            );

            // Send email
            $this->emailService->sendApplicationStatusUpdate($application, 'gs_approved');

            return $application;
        } catch (\Exception $e) {
            throw new \Exception('Failed to approve application: ' . $e->getMessage());
        }
    }

    public function approveByDS($applicationId, $dsUserId, $comments = null)
    {
        try {
            $application = Application::findOrFail($applicationId);

            $application->update([
                'status' => 'ds_approved',
                'ds_verified_by' => $dsUserId,
                'ds_verified_at' => now(),
                'ds_comments' => $comments
            ]);

            // Generate digital card
            $digitalCard = $this->generateDigitalCard($application);

            // Create notification
            Notification::notifyApplicationUpdate(
                $application->user_id,
                $application->application_number,
                'ds_approved'
            );

            // Send email
            $this->emailService->sendDigitalCardReady($application);

            return $application;
        } catch (\Exception $e) {
            throw new \Exception('Failed to approve application: ' . $e->getMessage());
        }
    }

    public function rejectApplication($applicationId, $userId, $comments)
    {
        try {
            $application = Application::findOrFail($applicationId);

            $application->update([
                'status' => 'rejected',
                'gs_verified_by' => $userId,
                'gs_verified_at' => now(),
                'gs_comments' => $comments
            ]);

            // Create notification
            Notification::notifyApplicationUpdate(
                $application->user_id,
                $application->application_number,
                'rejected'
            );

            // Send email
            $this->emailService->sendApplicationStatusUpdate($application, 'rejected');

            return $application;
        } catch (\Exception $e) {
            throw new \Exception('Failed to reject application: ' . $e->getMessage());
        }
    }

    private function generateDigitalCard($application)
    {
        // Create card number
        $cardNumber = 'DID-' . date('Y') . '-' . str_pad($application->id, 8, '0', STR_PAD_LEFT);

        // Create digital card
        $digitalCard = DigitalCard::create([
            'application_id' => $application->id,
            'card_number' => $cardNumber,
            'qr_code_data' => [],
            'qr_code_path' => '',
            'issue_date' => now(),
            'expiry_date' => now()->addYears(2),
            'status' => 'active'
        ]);

        // Generate QR code
        $qrPath = $this->qrCodeService->generateCardQrCode($digitalCard);

        // Update card with QR data and path
        $digitalCard->update([
            'qr_code_path' => $qrPath,
            'qr_code_data' => [
                'card_number' => $cardNumber,
                'name' => $application->full_name,
                'issued_date' => now()->format('Y-m-d'),
                'expiry_date' => now()->addYears(2)->format('Y-m-d')
            ]
        ]);

        return $digitalCard;
    }

    public function getApplicationStats()
    {
        return [
            'total' => Application::count(),
            'pending' => Application::where('status', 'pending')->count(),
            'gs_approved' => Application::where('status', 'gs_approved')->count(),
            'ds_approved' => Application::where('status', 'ds_approved')->count(),
            'rejected' => Application::where('status', 'rejected')->count(),
            'cards_issued' => DigitalCard::count()
        ];
    }
}
