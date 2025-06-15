<?php
namespace App\Services;

use App\Models\EmailVerification;
use App\Models\User;
use App\Mail\EmailVerificationMail;
use App\Mail\ApplicationStatusMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class EmailService
{
    public function sendVerificationEmail($email)
    {
        try {
            // Create verification token
            $token = Str::random(60);

            EmailVerification::create([
                'email' => $email,
                'token' => $token,
                'expires_at' => now()->addHours(24)
            ]);

            // Send email
            Mail::to($email)->send(new EmailVerificationMail($token));

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function verifyEmail($token)
    {
        $verification = EmailVerification::where('token', $token)
            ->where('expires_at', '>', now())
            ->whereNull('verified_at')
            ->first();

        if (!$verification) {
            return false;
        }

        // Mark as verified
        $verification->markAsVerified();

        // Update user
        User::where('email', $verification->email)
            ->update(['email_verified_at' => now()]);

        return true;
    }

    public function sendApplicationStatusUpdate($application, $status)
    {
        try {
            Mail::to($application->user->email)
                ->send(new ApplicationStatusMail($application, $status));
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function sendDigitalCardReady($application)
    {
        try {
            $user = $application->user;
            $subject = 'Your Digital ID Card is Ready!';
            $message = "Dear {$user->name},\n\nYour application {$application->application_number} has been approved and your digital ID card is now ready for download.\n\nPlease login to your account to download your card.\n\nBest regards,\nSri Lanka Digital ID System";

            Mail::raw($message, function ($mail) use ($user, $subject) {
                $mail->to($user->email)
                     ->subject($subject);
            });

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
