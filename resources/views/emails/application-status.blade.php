<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Status Update - Sri Lanka Digital ID System</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 0; background-color: #f4f4f4; }
        .container { max-width: 600px; margin: 0 auto; background-color: #ffffff; padding: 20px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        .header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 30px; text-align: center; border-radius: 10px 10px 0 0; margin: -20px -20px 20px -20px; }
        .header h1 { margin: 0; font-size: 24px; }
        .content { padding: 20px 0; }
        .status-card { background-color: #f8f9fa; border-left: 5px solid #28a745; padding: 20px; margin: 20px 0; border-radius: 5px; }
        .status-rejected { border-left-color: #dc3545; background-color: #f8d7da; }
        .status-pending { border-left-color: #ffc107; background-color: #fff3cd; }
        .status-approved { border-left-color: #28a745; background-color: #d4edda; }
        .btn { display: inline-block; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; text-decoration: none; padding: 15px 30px; border-radius: 5px; font-weight: bold; margin: 20px 0; }
        .btn:hover { background: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%); }
        .btn-success { background: linear-gradient(135deg, #28a745 0%, #20c997 100%); }
        .footer { background-color: #f8f9fa; padding: 20px; text-align: center; border-radius: 0 0 10px 10px; margin: 20px -20px -20px -20px; font-size: 12px; color: #666; }
        .info-table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        .info-table th, .info-table td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        .info-table th { background-color: #f8f9fa; font-weight: bold; }
        .timeline { margin: 20px 0; }
        .timeline-item { margin: 10px 0; padding: 10px; border-left: 3px solid #e9ecef; }
        .timeline-completed { border-left-color: #28a745; background-color: #d4edda; }
        .timeline-current { border-left-color: #ffc107; background-color: #fff3cd; }
        .logo { font-size: 16px; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">🇱🇰 Sri Lanka Digital ID System</div>
            <h1>Application Status Update</h1>
        </div>

        <div class="content">
            <h2>Dear {{ $application->user->name }},</h2>

            @if($status === 'ds_approved')
                <div class="status-card status-approved">
                    <h3 style="margin-top: 0; color: #155724;">🎉 Congratulations! Your Digital ID Card is Ready!</h3>
                    <p><strong>{{ $statusMessage }}</strong></p>
                </div>
            @elseif($status === 'rejected')
                <div class="status-card status-rejected">
                    <h3 style="margin-top: 0; color: #721c24;">❌ Application Status Update</h3>
                    <p><strong>{{ $statusMessage }}</strong></p>
                </div>
            @elseif($status === 'gs_approved')
                <div class="status-card status-approved">
                    <h3 style="margin-top: 0; color: #155724;">✅ Application Approved by Grama Sevaka</h3>
                    <p><strong>{{ $statusMessage }}</strong></p>
                </div>
            @else
                <div class="status-card status-pending">
                    <h3 style="margin-top: 0; color: #856404;">📋 Application Submitted</h3>
                    <p><strong>{{ $statusMessage }}</strong></p>
                </div>
            @endif

            <h3>Application Details</h3>
            <table class="info-table">
                <tr>
                    <th>Application Number</th>
                    <td><strong>{{ $application->application_number }}</strong></td>
                </tr>
                <tr>
                    <th>Applicant Name</th>
                    <td>{{ $application->first_name }} {{ $application->last_name }}</td>
                </tr>
                <tr>
                    <th>Current Status</th>
                    <td>
                        @if($status === 'pending')
                            <span style="color: #856404;">⏳ Pending Review</span>
                        @elseif($status === 'gs_approved')
                            <span style="color: #155724;">✅ GS Approved</span>
                        @elseif($status === 'ds_approved')
                            <span style="color: #155724;">🎉 Approved & Card Ready</span>
                        @elseif($status === 'rejected')
                            <span style="color: #721c24;">❌ Rejected</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Submitted Date</th>
                    <td>{{ $application->submitted_at ? $application->submitted_at->format('F j, Y \a\t g:i A') : 'Not submitted' }}</td>
                </tr>
                @if($application->gs_verified_at)
                <tr>
                    <th>GS Review Date</th>
                    <td>{{ $application->gs_verified_at->format('F j, Y \a\t g:i A') }}</td>
                </tr>
                @endif
                @if($application->ds_verified_at)
                <tr>
                    <th>DS Approval Date</th>
                    <td>{{ $application->ds_verified_at->format('F j, Y \a\t g:i A') }}</td>
                </tr>
                @endif
            </table>

            @if($status !== 'rejected')
            <h3>Application Progress</h3>
            <div class="timeline">
                <div class="timeline-item timeline-completed">
                    ✅ <strong>Application Submitted</strong><br>
                    <small>{{ $application->submitted_at ? $application->submitted_at->format('M j, Y') : 'Completed' }}</small>
                </div>

                <div class="timeline-item {{ $application->gs_verified_at ? 'timeline-completed' : ($status === 'pending' ? 'timeline-current' : '') }}">
                    {{ $application->gs_verified_at ? '✅' : ($status === 'pending' ? '⏳' : '⭕') }} <strong>Grama Sevaka Review</strong><br>
                    <small>{{ $application->gs_verified_at ? $application->gs_verified_at->format('M j, Y') : ($status === 'pending' ? 'In Progress' : 'Pending') }}</small>
                </div>

                <div class="timeline-item {{ $application->ds_verified_at ? 'timeline-completed' : ($status === 'gs_approved' ? 'timeline-current' : '') }}">
                    {{ $application->ds_verified_at ? '✅' : ($status === 'gs_approved' ? '⏳' : '⭕') }} <strong>Divisional Secretariat Review</strong><br>
                    <small>{{ $application->ds_verified_at ? $application->ds_verified_at->format('M j, Y') : ($status === 'gs_approved' ? 'In Progress' : 'Pending') }}</small>
                </div>

                <div class="timeline-item {{ $status === 'ds_approved' ? 'timeline-completed' : '' }}">
                    {{ $status === 'ds_approved' ? '🎉' : '⭕' }} <strong>Digital ID Card Generated</strong><br>
                    <small>{{ $status === 'ds_approved' ? 'Ready for Download!' : 'Pending' }}</small>
                </div>
            </div>
            @endif

            @if($application->gs_comments || $application->ds_comments)
            <h3>Official Comments</h3>
            <div style="background-color: #f8f9fa; padding: 15px; border-radius: 5px; margin: 15px 0;">
                @if($application->gs_comments)
                    <p><strong>Grama Sevaka:</strong> {{ $application->gs_comments }}</p>
                @endif
                @if($application->ds_comments)
                    <p><strong>Divisional Secretariat:</strong> {{ $application->ds_comments }}</p>
                @endif
            </div>
            @endif

            <div style="text-align: center; margin: 30px 0;">
                @if($status === 'ds_approved')
                    <a href="{{ $loginUrl }}" class="btn btn-success">Download Your Digital ID Card</a>
                @else
                    <a href="{{ $loginUrl }}" class="btn">Check Application Status</a>
                @endif
            </div>

            <h3>Need Help?</h3>
            <p>If you have any questions about your application or need assistance:</p>
            <ul>
                <li>📧 Email: <strong>support@digitalid.gov.lk</strong></li>
                <li>📞 Phone: <strong>+94-11-1234567</strong></li>
                <li>🌐 Website: <strong>{{ config('app.url') }}</strong></li>
                <li>⏰ Office Hours: Monday to Friday, 8:30 AM to 4:30 PM</li>
            </ul>
        </div>

        <div class="footer">
            <p><strong>Sri Lanka Digital ID System</strong><br>
            Ministry of Digital Technology and Enterprise Development<br>
            Government of Sri Lanka</p>

            <p style="margin-top: 15px;">
                This is an automated message. Please do not reply to this email.<br>
                © {{ date('Y') }} Government of Sri Lanka. All rights reserved.
            </p>

            <p style="margin-top: 10px; font-size: 11px;">
                You are receiving this email because you have an active application with the Sri Lanka Digital ID System.<br>
                Application Number: {{ $application->application_number }}
            </p>
        </div>
    </div>
</body>
</html>
