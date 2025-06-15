<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Digital ID Card - {{ $application->full_name }}</title>
    <style>
        @page {
            size: A4;
            margin: 20px;
        }

        body {
            font-family: Arial, sans-serif;
            line-height: 1.4;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Header Section */
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #dc2626;
            padding-bottom: 20px;
        }

        .flag {
            font-size: 32px;
            margin-bottom: 10px;
        }

        .country-name {
            font-size: 24px;
            font-weight: bold;
            color: #dc2626;
            margin: 10px 0;
        }

        .subtitle {
            font-size: 12px;
            color: #666;
            margin: 5px 0;
        }

        /* Digital Card Section */
        .digital-card {
            background: linear-gradient(135deg, #dc2626, #991b1b);
            color: white;
            border-radius: 15px;
            padding: 30px;
            margin: 30px 0;
            position: relative;
        }

        .card-header {
            text-align: center;
            margin-bottom: 25px;
        }

        .card-title {
            font-size: 20px;
            font-weight: bold;
            margin: 10px 0;
        }

        .card-subtitle {
            font-size: 12px;
            opacity: 0.8;
        }

        /* Personal Information */
        .person-name {
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            margin: 20px 0;
            padding: 10px;
            background: rgba(255,255,255,0.1);
            border-radius: 8px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin: 20px 0;
        }

        .info-item {
            background: rgba(255,255,255,0.1);
            padding: 10px;
            border-radius: 5px;
        }

        .info-label {
            font-size: 10px;
            text-transform: uppercase;
            margin-bottom: 3px;
            opacity: 0.8;
        }

        .info-value {
            font-size: 14px;
            font-weight: bold;
        }

        .card-number {
            color: #fbbf24;
            font-family: monospace;
        }

        .address-full {
            grid-column: 1 / -1;
            text-align: center;
        }

        .validity-dates {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-top: 20px;
        }

        /* QR Code Section */
        .qr-section {
            text-align: center;
            margin: 30px 0;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 10px;
        }

        .qr-code {
            width: 120px;
            height: 120px;
            background: white;
            border: 2px solid #dc2626;
            border-radius: 8px;
            margin: 0 auto 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .qr-code img {
            width: 110px;
            height: 110px;
        }

        /* Verification Section */
        .verification {
            background: #f0f9ff;
            border: 1px solid #0ea5e9;
            border-radius: 10px;
            padding: 20px;
            margin: 20px 0;
        }

        .verification h3 {
            color: #0ea5e9;
            margin-bottom: 15px;
            font-size: 16px;
        }

        .verification-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin: 15px 0;
        }

        .verification-item {
            text-align: center;
            padding: 10px;
            background: white;
            border-radius: 5px;
        }

        .verification-item strong {
            display: block;
            color: #dc2626;
            margin-bottom: 5px;
        }

        .verification-item span {
            font-size: 11px;
            color: #666;
        }

        /* Security Features */
        .security {
            background: #f0fdf4;
            border: 1px solid #22c55e;
            border-radius: 10px;
            padding: 20px;
            margin: 20px 0;
        }

        .security h3 {
            color: #22c55e;
            margin-bottom: 15px;
            font-size: 16px;
        }

        .security-list {
            list-style: none;
            padding: 0;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
        }

        .security-list li {
            font-size: 12px;
            padding: 5px 0;
            position: relative;
            padding-left: 15px;
        }

        .security-list li:before {
            content: "✓";
            position: absolute;
            left: 0;
            color: #22c55e;
            font-weight: bold;
        }

        /* Hash Section */
        .hash {
            background: #1f2937;
            color: #10b981;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
            font-family: monospace;
        }

        .hash h4 {
            margin-bottom: 10px;
            font-size: 12px;
        }

        .hash-value {
            font-size: 10px;
            word-break: break-all;
            background: rgba(16,185,129,0.1);
            padding: 8px;
            border-radius: 4px;
        }

        /* Footer */
        .footer {
            background: #dc2626;
            color: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            margin-top: 30px;
        }

        .footer h3 {
            color: #fbbf24;
            margin-bottom: 15px;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            font-size: 11px;
            text-align: left;
        }

        .important-notice {
            background: #fef3c7;
            border: 1px solid #f59e0b;
            border-radius: 8px;
            padding: 15px;
            margin: 20px 0;
            font-size: 11px;
        }

        .page-break {
            page-break-before: always;
        }

        /* Clean table for better organization */
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }

        .info-table td {
            padding: 8px;
            border-bottom: 1px solid rgba(255,255,255,0.2);
        }

        .info-table .label {
            width: 30%;
            font-size: 11px;
            opacity: 0.8;
        }

        .info-table .value {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Clean Header -->
        <div class="header">
            {{-- <div class="flag">🇱🇰</div> --}}
            <div class="country-name">SRI LANKAN DIGITAL IDENTITY CARD</div>
            <div class="subtitle">Democratic Socialist Republic of Sri Lanka</div>
            <div class="subtitle">Generated on {{ $generated_at }}</div>
        </div>

        <!-- Simplified Digital Card -->
        {{-- <div class="digital-card">
            <div class="card-header">
                <div style="color: #fbbf24; font-weight: bold; font-size: 16px;">DEMOCRATIC SOCIALIST REPUBLIC OF SRI LANKA</div>
                <div class="card-title">DIGITAL IDENTITY CARD</div>
                <div class="card-subtitle">ඩිජිටල් හැඳුනුම්පත | டிஜிட்டல் அடையாள அட்டை</div>
            </div>

            <!-- Person Name -->
            <div class="person-name">{{ $application->full_name }}</div>

            <!-- Organized Information Table -->
            <table class="info-table">
                <tr>
                    <td class="label">CARD NUMBER</td>
                    <td class="value card-number">{{ $card->card_number }}</td>
                </tr>
                <tr>
                    <td class="label">DATE OF BIRTH</td>
                    <td class="value">{{ $application->date_of_birth->format('F j, Y') }}</td>
                </tr>
                <tr>
                    <td class="label">GENDER</td>
                    <td class="value">{{ ucfirst($application->gender) }}</td>
                </tr>
                <tr>
                    <td class="label">NATIONALITY</td>
                    <td class="value">{{ $application->nationality }}</td>
                </tr>
                <tr>
                    <td class="label">ADDRESS</td>
                    <td class="value">{{ $application->address }}</td>
                </tr>
                <tr>
                    <td class="label">ISSUE DATE</td>
                    <td class="value">{{ $card->issue_date->format('F j, Y') }}</td>
                </tr>
                <tr>
                    <td class="label">EXPIRY DATE</td>
                    <td class="value" style="color: #fbbf24;">{{ $card->expiry_date->format('F j, Y') }}</td>
                </tr>
            </table>

            <!-- Card Footer -->
            <div style="text-align: center; margin-top: 20px; font-size: 11px; opacity: 0.8;">
                Authorized by DS Office • Government of Sri Lanka
            </div>
        </div> --}}

        <!-- QR Code Section -->
        <div class="qr-section">
            <h3 style="margin-bottom: 15px;">🔍 Verification QR Code</h3>
            <div class="qr-code">
                @if(isset($qrCodeBase64))
                    <img src="{{ $qrCodeBase64 }}" alt="QR Code">
                @else
                    <div style="font-size: 10px;">QR Code</div>
                @endif
            </div>
            <p style="font-size: 12px; color: #666; margin-top: 10px;">Scan to verify authenticity</p>
        </div>

        <!-- Verification Information -->
        <div class="verification">
            <h3>📋 Card Verification Information</h3>
            <div class="verification-grid">
                <div class="verification-item">
                    <strong>{{ $card->card_number }}</strong>
                    <span>Digital Card Number</span>
                </div>
                <div class="verification-item">
                    <strong>{{ $application->application_number }}</strong>
                    <span>Application Reference</span>
                </div>
                <div class="verification-item">
                    <strong>{{ $card->issue_date->format('Y-m-d') }}</strong>
                    <span>Issue Date</span>
                </div>
            </div>
            <p style="font-size: 12px; margin-top: 15px;">
                <strong>Verification:</strong> Visit <strong>https://digitalid.gov.lk/verify</strong>
                and enter the card number, or scan the QR code above.
                Valid until {{ $card->expiry_date->format('F j, Y') }}.
            </p>
        </div>

        <!-- Security Features -->
        <div class="security">
            <h3>🔒 Security Features</h3>
            <ul class="security-list">
                <li>256-bit Encryption</li>
                <li>Digital Signatures</li>
                <li>Real-time Validation</li>
                <li>Government Verified</li>
                <li>Anti-tampering Protection</li>
                <li>Secure QR Code</li>
                <li>Audit Trail Logging</li>
                <li>Legal Validity</li>
            </ul>
        </div>

        <!-- Security Hash -->
        <div class="hash">
            <h4>🔐 CRYPTOGRAPHIC SECURITY HASH (SHA-256)</h4>
            <div class="hash-value">
                {{ hash('sha256', $card->card_number . $application->full_name . $card->issue_date->format('Y-m-d')) }}
            </div>
        </div>

        <!-- Government Footer -->
        <div class="footer">
            <h3>🏛️ Government Certification</h3>
            <div class="footer-grid">
                <div>
                    <strong>Issuing Authority:</strong><br>
                    Department of Digital Identity<br>
                    Ministry of Technology<br>
                    Government of Sri Lanka
                </div>
                <div>
                    <strong>Contact Information:</strong><br>
                    Helpline: +94 11 234 5678<br>
                    Email: support@digitalid.gov.lk<br>
                    Website: www.digitalid.gov.lk
                </div>
            </div>
        </div>

        <!-- Important Notice -->
        <div class="important-notice">
            <strong>⚠️ Important:</strong> This is an official government document.
            Unauthorized reproduction, modification, or use is prohibited by law.
        </div>

        <!-- Document Footer -->
        <div style="text-align: center; font-size: 10px; color: #666; margin-top: 20px;">
            <p>🔒 Protected by advanced cryptographic security measures</p>
            <p>© {{ date('Y') }} Government of Sri Lanka • All Rights Reserved</p>
        </div>
    </div>
</body>
</html>
