🇱🇰 SRI LANKA DIGITAL ID SYSTEM
================================

Dear {{ $application->user->name }},

APPLICATION STATUS UPDATE

{{ strtoupper($statusMessage) }}

APPLICATION DETAILS:
- Application Number: {{ $application->application_number }}
- Applicant: {{ $application->first_name }} {{ $application->last_name }}
- Current Status: {{ ucfirst(str_replace('_', ' ', $status)) }}
- Submitted: {{ $application->submitted_at ? $application->submitted_at->format('F j, Y \a\t g:i A') : 'Not submitted' }}

@if($application->gs_verified_at)
- GS Review: {{ $application->gs_verified_at->format('F j, Y \a\t g:i A') }}
@endif

@if($application->ds_verified_at)
- DS Approval: {{ $application->ds_verified_at->format('F j, Y \a\t g:i A') }}
@endif

APPLICATION PROGRESS:
@if($status === 'pending')
⏳ Grama Sevaka Review (Current Step)
⭕ Divisional Secretariat Review
⭕ Digital ID Card Generation
@elseif($status === 'gs_approved')
✅ Grama Sevaka Review (Completed)
⏳ Divisional Secretariat Review (Current Step)
⭕ Digital ID Card Generation
@elseif($status === 'ds_approved')
✅ Grama Sevaka Review (Completed)
✅ Divisional Secretariat Review (Completed)
🎉 Digital ID Card Generated (Ready!)
@elseif($status === 'rejected')
❌ Application Rejected
@endif

@if($application->gs_comments || $application->ds_comments)
OFFICIAL COMMENTS:
@if($application->gs_comments)
Grama Sevaka: {{ $application->gs_comments }}
@endif
@if($application->ds_comments)
Divisional Secretariat: {{ $application->ds_comments }}
@endif
@endif

@if($status === 'ds_approved')
🎉 CONGRATULATIONS! Your digital ID card is ready for download.
Login to your account to download: {{ $loginUrl }}
@else
Check your application status: {{ $loginUrl }}
@endif

NEED HELP?
📧 Email: support@digitalid.gov.lk
📞 Phone: +94-11-1234567
🌐 Website: {{ config('app.url') }}
⏰ Office Hours: Monday to Friday, 8:30 AM to 4:30 PM

Best regards,
Sri Lanka Digital ID System
Ministry of Digital Technology and Enterprise Development

---
This is an automated message. Please do not reply to this email.
© {{ date('Y') }} Government of Sri Lanka. All rights reserved.
Application Number: {{ $application->application_number }}
