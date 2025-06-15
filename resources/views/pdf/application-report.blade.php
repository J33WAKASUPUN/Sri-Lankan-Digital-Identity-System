<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Digital ID Application Report - {{ $reportTitle ?? 'System Report' }}</title>
    <style>
        @page {
            size: A4;
            margin: 20mm;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            font-size: 11px;
            line-height: 1.4;
            color: #333;
            background: #fff;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 3px solid #8B1538;
        }

        .logo-section {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
        }

        .logo {
            width: 60px;
            height: 60px;
            background: linear-gradient(45deg, #8B1538, #D4AF37);
            border-radius: 50%;
            margin-right: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: white;
            font-weight: bold;
        }

        .header-text {
            text-align: left;
        }

        .main-title {
            font-size: 24px;
            font-weight: bold;
            color: #8B1538;
            margin-bottom: 5px;
            text-transform: uppercase;
        }

        .sub-title {
            font-size: 16px;
            color: #666;
            margin-bottom: 3px;
        }

        .department {
            font-size: 12px;
            color: #888;
            font-style: italic;
        }

        .report-info {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 25px;
            border-left: 5px solid #8B1538;
        }

        .report-title {
            font-size: 18px;
            font-weight: bold;
            color: #8B1538;
            margin-bottom: 10px;
        }

        .report-meta {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-bottom: 15px;
        }

        .meta-item {
            background: white;
            padding: 12px;
            border-radius: 6px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            text-align: center;
        }

        .meta-label {
            font-size: 9px;
            color: #666;
            text-transform: uppercase;
            font-weight: bold;
            letter-spacing: 0.5px;
            margin-bottom: 3px;
        }

        .meta-value {
            font-size: 14px;
            font-weight: bold;
            color: #8B1538;
        }

        .summary-stats {
            background: white;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 25px;
        }

        .stats-title {
            font-size: 16px;
            font-weight: bold;
            color: #333;
            margin-bottom: 15px;
            text-align: center;
            padding-bottom: 10px;
            border-bottom: 2px solid #8B1538;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
        }

        .stat-card {
            text-align: center;
            padding: 15px;
            border-radius: 8px;
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            border: 1px solid #dee2e6;
        }

        .stat-number {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .stat-label {
            font-size: 10px;
            color: #666;
            text-transform: uppercase;
            font-weight: bold;
        }

        .stat-total { color: #6f42c1; }
        .stat-pending { color: #fd7e14; }
        .stat-approved { color: #198754; }
        .stat-rejected { color: #dc3545; }

        .applications-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
            background: white;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        .table-header {
            background: linear-gradient(135deg, #8B1538, #B91B47);
            color: white;
        }

        .applications-table th {
            padding: 12px 8px;
            text-align: left;
            font-weight: bold;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .applications-table td {
            padding: 10px 8px;
            border-bottom: 1px solid #e9ecef;
            font-size: 9px;
        }

        .applications-table tr:nth-child(even) {
            background: #f8f9fa;
        }

        .applications-table tr:hover {
            background: #e7f3ff;
        }

        .status-badge {
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 8px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .status-pending {
            background: #fff3cd;
            color: #856404;
            border: 1px solid #ffeaa7;
        }

        .status-gs-approved {
            background: #cff4fc;
            color: #055160;
            border: 1px solid #b8daff;
        }

        .status-ds-approved {
            background: #d1e7dd;
            color: #0a3622;
            border: 1px solid #b7e4c7;
        }

        .status-rejected {
            background: #f8d7da;
            color: #58151c;
            border: 1px solid #f1aeb5;
        }

        .processing-chart {
            background: white;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 25px;
        }

        .chart-title {
            font-size: 16px;
            font-weight: bold;
            color: #333;
            margin-bottom: 15px;
            text-align: center;
        }

        .timeline-item {
            display: flex;
            align-items: center;
            margin-bottom: 12px;
            padding: 10px;
            background: #f8f9fa;
            border-radius: 6px;
            border-left: 4px solid #8B1538;
        }

        .timeline-date {
            font-weight: bold;
            color: #8B1538;
            min-width: 80px;
            margin-right: 15px;
            font-size: 10px;
        }

        .timeline-content {
            flex: 1;
        }

        .timeline-title {
            font-weight: bold;
            margin-bottom: 2px;
            font-size: 11px;
        }

        .timeline-description {
            color: #666;
            font-size: 9px;
        }

        .performance-metrics {
            background: white;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 25px;
        }

        .metrics-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
        }

        .metric-item {
            text-align: center;
            padding: 15px;
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            border-radius: 8px;
            border: 1px solid #dee2e6;
        }

        .metric-value {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .metric-label {
            font-size: 10px;
            color: #666;
            text-transform: uppercase;
            font-weight: bold;
        }

        .metric-description {
            font-size: 8px;
            color: #888;
            margin-top: 3px;
        }

        .regional-breakdown {
            background: white;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 25px;
        }

        .regional-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 0;
            border-bottom: 1px solid #e9ecef;
        }

        .regional-item:last-child {
            border-bottom: none;
        }

        .region-name {
            font-weight: bold;
            color: #333;
        }

        .region-stats {
            display: flex;
            gap: 15px;
            font-size: 10px;
        }

        .region-stat {
            text-align: center;
        }

        .footer-section {
            background: #8B1538;
            color: white;
            padding: 20px;
            border-radius: 8px;
            margin-top: 30px;
            text-align: center;
        }

        .footer-title {
            font-size: 16px;
            font-weight: bold;
            color: #D4AF37;
            margin-bottom: 10px;
        }

        .footer-content {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            font-size: 10px;
        }

        .certification {
            background: #f8f9fa;
            border: 2px solid #8B1538;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 25px;
            text-align: center;
        }

        .cert-title {
            font-size: 14px;
            font-weight: bold;
            color: #8B1538;
            margin-bottom: 8px;
        }

        .cert-text {
            font-size: 10px;
            color: #666;
            line-height: 1.5;
        }

        .page-number {
            position: fixed;
            bottom: 10mm;
            right: 10mm;
            font-size: 9px;
            color: #666;
        }

        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 100px;
            color: rgba(139, 21, 56, 0.05);
            font-weight: bold;
            z-index: -1;
            pointer-events: none;
        }

        .page-break {
            page-break-before: always;
        }

        @media print {
            body {
                background: white !important;
            }
        }
    </style>
</head>
<body>
    <div class="watermark">CONFIDENTIAL</div>

    <!-- Header -->
    <div class="header">
        <div class="logo-section">
            <div class="logo">🇱🇰</div>
            <div class="header-text">
                <div class="main-title">Digital ID Application Report</div>
                <div class="sub-title">Government of Sri Lanka</div>
                <div class="department">Department of Digital Identity • Ministry of Technology</div>
            </div>
        </div>
    </div>

    <!-- Report Information -->
    <div class="report-info">
        <div class="report-title">📊 {{ $reportTitle ?? 'Application Processing Report' }}</div>

        <div class="report-meta">
            <div class="meta-item">
                <div class="meta-label">Report Period</div>
                <div class="meta-value">{{ $reportPeriod ?? 'June 1-14, 2025' }}</div>
            </div>

            <div class="meta-item">
                <div class="meta-label">Generated By</div>
                <div class="meta-value">J33WAKASUPUN</div>
            </div>

            <div class="meta-item">
                <div class="meta-label">Generated On</div>
                <div class="meta-value">{{ now()->format('Y-m-d H:i') }} UTC</div>
            </div>
        </div>

        <div style="font-size: 10px; color: #666; text-align: center;">
            This report contains confidential information. Distribution is restricted to authorized personnel only.
        </div>
    </div>

    <!-- Summary Statistics -->
    <div class="summary-stats">
        <div class="stats-title">📈 Executive Summary</div>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-number stat-total">{{ $totalApplications ?? 1247 }}</div>
                <div class="stat-label">Total Applications</div>
            </div>

            <div class="stat-card">
                <div class="stat-number stat-pending">{{ $pendingApplications ?? 145 }}</div>
                <div class="stat-label">Pending Review</div>
            </div>

            <div class="stat-card">
                <div class="stat-number stat-approved">{{ $approvedApplications ?? 987 }}</div>
                <div class="stat-label">Approved & Issued</div>
            </div>

            <div class="stat-card">
                <div class="stat-number stat-rejected">{{ $rejectedApplications ?? 115 }}</div>
                <div class="stat-label">Rejected</div>
            </div>
        </div>
    </div>

    <!-- Performance Metrics -->
    <div class="performance-metrics">
        <div class="stats-title">⚡ Performance Metrics</div>

        <div class="metrics-grid">
            <div class="metric-item">
                <div class="metric-value" style="color: #198754;">94.2%</div>
                <div class="metric-label">Processing Efficiency</div>
                <div class="metric-description">Above 90% target</div>
            </div>

            <div class="metric-item">
                <div class="metric-value" style="color: #0d6efd;">2.3 days</div>
                <div class="metric-label">Avg Processing Time</div>
                <div class="metric-description">Under 3-day target</div>
            </div>

            <div class="metric-item">
                <div class="metric-value" style="color: #6f42c1;">97.8%</div>
                <div class="metric-label">Citizen Satisfaction</div>
                <div class="metric-description">Excellent service</div>
            </div>
        </div>
    </div>

    <!-- Regional Breakdown -->
    <div class="regional-breakdown">
        <div class="stats-title">🌍 Regional Performance Analysis</div>

        @php
            $regions = [
                ['name' => 'Colombo District', 'total' => 356, 'approved' => 342, 'efficiency' => 96.1],
                ['name' => 'Kandy District', 'total' => 289, 'approved' => 274, 'efficiency' => 94.8],
                ['name' => 'Galle District', 'total' => 234, 'approved' => 221, 'efficiency' => 94.4],
                ['name' => 'Jaffna District', 'total' => 187, 'approved' => 175, 'efficiency' => 93.6],
                ['name' => 'Matara District', 'total' => 181, 'approved' => 169, 'efficiency' => 93.4]
            ];
        @endphp

        @foreach($regions as $region)
            <div class="regional-item">
                <div class="region-name">{{ $region['name'] }}</div>
                <div class="region-stats">
                    <div class="region-stat">
                        <strong style="color: #8B1538;">{{ $region['total'] }}</strong><br>
                        <span>Total</span>
                    </div>
                    <div class="region-stat">
                        <strong style="color: #198754;">{{ $region['approved'] }}</strong><br>
                        <span>Approved</span>
                    </div>
                    <div class="region-stat">
                        <strong style="color: #0d6efd;">{{ $region['efficiency'] }}%</strong><br>
                        <span>Efficiency</span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Page Break -->
    <div class="page-break"></div>

    <!-- Processing Timeline -->
    <div class="processing-chart">
        <div class="chart-title">📅 Recent Processing Timeline</div>

        @php
            $timeline = [
                ['date' => '2025-06-14', 'title' => 'Peak Processing Day', 'description' => '89 applications processed - highest daily volume this month'],
                ['date' => '2025-06-13', 'title' => 'System Optimization', 'description' => 'Improved processing speed by 15% through system updates'],
                ['date' => '2025-06-12', 'title' => 'Quality Control Review', 'description' => 'Enhanced verification procedures implemented'],
                ['date' => '2025-06-11', 'title' => 'Staff Training Completed', 'description' => 'Advanced training for DS and GS officers'],
                ['date' => '2025-06-10', 'title' => 'Digital Card Launch', 'description' => 'New digital card design officially launched'],
                ['date' => '2025-06-09', 'title' => 'Security Enhancement', 'description' => 'Added blockchain verification layer'],
                ['date' => '2025-06-08', 'title' => 'Mobile App Update', 'description' => 'Released mobile app v2.1 with improved scanning']
            ];
        @endphp

        @foreach($timeline as $item)
            <div class="timeline-item">
                <div class="timeline-date">{{ date('M j', strtotime($item['date'])) }}</div>
                <div class="timeline-content">
                    <div class="timeline-title">{{ $item['title'] }}</div>
                    <div class="timeline-description">{{ $item['description'] }}</div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Recent Applications Table -->
    <table class="applications-table">
        <thead class="table-header">
            <tr>
                <th>Application #</th>
                <th>Applicant Name</th>
                <th>Submission Date</th>
                <th>Status</th>
                <th>Processing Officer</th>
                <th>Processing Time</th>
                <th>Location</th>
            </tr>
        </thead>
        <tbody>
            @php
                $sampleApplications = [
                    ['id' => 'DID-2025-001234', 'name' => 'Priya Wickramasinghe', 'date' => '2025-06-14', 'status' => 'ds_approved', 'officer' => 'DS_Colombo_01', 'time' => '1.2 days', 'location' => 'Colombo'],
                    ['id' => 'DID-2025-001235', 'name' => 'Rajan Kumara Perera', 'date' => '2025-06-14', 'status' => 'gs_approved', 'officer' => 'GS_Kandy_05', 'time' => '0.8 days', 'location' => 'Kandy'],
                    ['id' => 'DID-2025-001236', 'name' => 'Kamala Fernando', 'date' => '2025-06-13', 'status' => 'ds_approved', 'officer' => 'DS_Galle_02', 'time' => '2.1 days', 'location' => 'Galle'],
                    ['id' => 'DID-2025-001237', 'name' => 'Sunil Rathnayake', 'date' => '2025-06-13', 'status' => 'pending', 'officer' => 'GS_Jaffna_03', 'time' => '1.5 days', 'location' => 'Jaffna'],
                    ['id' => 'DID-2025-001238', 'name' => 'Nilmini Silva', 'date' => '2025-06-12', 'status' => 'rejected', 'officer' => 'DS_Matara_01', 'time' => '1.9 days', 'location' => 'Matara'],
                    ['id' => 'DID-2025-001239', 'name' => 'Asanka Jayawardena', 'date' => '2025-06-12', 'status' => 'ds_approved', 'officer' => 'DS_Colombo_02', 'time' => '1.1 days', 'location' => 'Colombo'],
                    ['id' => 'DID-2025-001240', 'name' => 'Sanduni Gunasekara', 'date' => '2025-06-11', 'status' => 'ds_approved', 'officer' => 'DS_Kandy_01', 'time' => '2.3 days', 'location' => 'Kandy'],
                    ['id' => 'DID-2025-001241', 'name' => 'Nuwan Wijesinghe', 'date' => '2025-06-11', 'status' => 'gs_approved', 'officer' => 'GS_Galle_02', 'time' => '1.7 days', 'location' => 'Galle'],
                    ['id' => 'DID-2025-001242', 'name' => 'Madhavi Rajapakse', 'date' => '2025-06-10', 'status' => 'ds_approved', 'officer' => 'DS_Jaffna_01', 'time' => '2.8 days', 'location' => 'Jaffna'],
                    ['id' => 'DID-2025-001243', 'name' => 'Chaminda Senanayake', 'date' => '2025-06-10', 'status' => 'ds_approved', 'officer' => 'DS_Matara_02', 'time' => '1.6 days', 'location' => 'Matara']
                ];
            @endphp

            @foreach($sampleApplications as $app)
                <tr>
                    <td style="font-family: monospace; font-weight: bold;">{{ $app['id'] }}</td>
                    <td>{{ $app['name'] }}</td>
                    <td>{{ date('M j, Y', strtotime($app['date'])) }}</td>
                    <td>
                        @switch($app['status'])
                            @case('pending')
                                <span class="status-badge status-pending">Pending</span>
                                @break
                            @case('gs_approved')
                                <span class="status-badge status-gs-approved">GS Approved</span>
                                @break
                            @case('ds_approved')
                                <span class="status-badge status-ds-approved">ID Issued</span>
                                @break
                            @case('rejected')
                                <span class="status-badge status-rejected">Rejected</span>
                                @break
                        @endswitch
                    </td>
                    <td style="font-family: monospace;">{{ $app['officer'] }}</td>
                    <td>{{ $app['time'] }}</td>
                    <td>{{ $app['location'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Page Break -->
    <div class="page-break"></div>

    <!-- Certification -->
    <div class="certification">
        <div class="cert-title">🏛️ Official Certification</div>
        <div class="cert-text">
            This report has been generated by the Digital Identity Management System and contains official
            government data. The information presented herein is accurate as of the generation timestamp
            and is certified for official use by authorized personnel only.
        </div>
    </div>

    <!-- Footer -->
    <div class="footer-section">
        <div class="footer-title">🔒 Digital Identity Department</div>

        <div class="footer-content">
            <div>
                <strong>Generated By:</strong><br>
                J33WAKASUPUN<br>
                System Administrator<br>
                Digital ID Management System<br><br>

                <strong>Report Classification:</strong><br>
                CONFIDENTIAL<br>
                For Official Use Only<br>
                Distribution Restricted
            </div>

            <div>
                <strong>Contact Information:</strong><br>
                Email: admin@digitalid.gov.lk<br>
                Phone: +94 11 234 5678<br>
                Website: www.digitalid.gov.lk<br><br>

                <strong>Document Information:</strong><br>
                Version: 2.1.0<br>
                Format: Official PDF Report<br>
                Security Level: Government Grade
            </div>
        </div>

        <div style="margin-top: 15px; padding-top: 10px; border-top: 1px solid rgba(255,255,255,0.3); font-size: 9px;">
            © {{ date('Y') }} Government of Sri Lanka • Ministry of Technology • Department of Digital Identity<br>
            This document contains sensitive information and should be handled according to government data protection protocols.
        </div>
    </div>

    <div class="page-number">
        Page 1 of 1 • Generated: {{ now()->format('Y-m-d H:i:s') }} UTC
    </div>
</body>
</html>
