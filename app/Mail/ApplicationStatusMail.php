<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Application;

class ApplicationStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public $application;
    public $status;

    /**
     * Create a new message instance.
     */
    public function __construct(Application $application, $status)
    {
        $this->application = $application;
        $this->status = $status;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subjects = [
            'submitted' => 'Application Submitted Successfully',
            'gs_approved' => 'Application Approved by Grama Sevaka',
            'ds_approved' => 'Digital ID Card Ready for Download!',
            'rejected' => 'Application Status Update',
        ];

        return new Envelope(
            from: config('mail.from.address', 'supunprabodha789@gmail.com'),
            subject: $subjects[$this->status] ?? 'Application Status Update',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            html: 'emails.application-status',
            text: 'emails.application-status-text',
            with: [
                'application' => $this->application,
                'status' => $this->status,
                'statusMessage' => $this->getStatusMessage(),
                'loginUrl' => route('login'),
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }

    private function getStatusMessage()
    {
        $messages = [
            'submitted' => 'Your application has been submitted successfully and is now under review by the Grama Sevaka.',
            'gs_approved' => 'Your application has been approved by the Grama Sevaka and forwarded to the Divisional Secretariat for final review.',
            'ds_approved' => 'Congratulations! Your application has been approved and your digital ID card is now ready for download.',
            'rejected' => 'We regret to inform you that your application has been rejected. Please check the comments for more details.',
        ];

        return $messages[$this->status] ?? 'Your application status has been updated.';
    }
}
