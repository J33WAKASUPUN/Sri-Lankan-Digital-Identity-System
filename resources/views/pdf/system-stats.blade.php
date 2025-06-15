<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Digital ID System Statistics - {{ $reportPeriod ?? 'Q2 2025' }}</title>
    <style>
        @page {
            size: A4;
            margin: 15mm;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            font-size: 10px;
            line-height: 1.3;
            color: #333;
            background: #fff;
        }

        .header {
            text-align: center;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 4px solid #8B1538;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 20px;
            border-radius: 8px;
        }

        .logo-section {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 12px;
        }

        .logo {
            width: 50px;
            height: 50px;
            background: linear-gradient(45deg, #8B1538, #D4AF37);
            border-radius: 50%;
            margin-right: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            color: white;
            font-weight: bold;
        }

        .header-text {
            text-align: left;
        }

        .main-title {
            font-size: 20px;
            font-weight: bold;
            color: #8B1538;
            margin-bottom: 4px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .sub-title {
            font-size: 14px;
            color: #666;
            margin-bottom: 2px;
        }

        .timestamp {
            font-size: 9px;
            color: #888;
            font-style: italic;
        }

        .report-overview {
            background: linear-gradient(135deg, #8B1538 0%, #B91B47 100%);
            color: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 4px 8px rgba(139, 21, 56, 0.3);
        }

        .overview-title {
            font-size: 16px;
            font-weight: bold;
            color: #D4AF37;
            margin-bottom: 12px;
            text-align: center;
        }

        .overview-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
        }

        .overview-item {
            text-align: center;
            background: rgba(255,255,255,0.1);
            padding: 12px;
            border-radius: 8px;
            border: 1px solid rgba(255,255,255,0.2);
        }

        .overview-number {
            font-size: 18px;
            font-weight: bold;
            color: #D4AF37;
            margin-bottom: 3px;
        }

        .overview-label {
            font-size: 8px;
            color: rgba(255,255,255,0.9);
            text-transform: uppercase;
            font-weight: bold;
        }

        .kpi-dashboard {
            background: white;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 18px;
            margin-bottom: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .kpi-title {
            font-size: 14px;
            font-weight: bold;
            color: #333;
            margin-bottom: 12px;
            text-align: center;
            padding-bottom: 8px;
            border-bottom: 2px solid #8B1538;
        }

        .kpi-grid {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 10px;
        }

        .kpi-card {
            text-align: center;
            padding: 12px;
            border-radius: 8px;
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            border: 1px solid #dee2e6;
            transition: all 0.3s ease;
        }

        .kpi-value {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 3px;
        }

        .kpi-label {
            font-size: 7px;
            color: #666;
            text-transform: uppercase;
            font-weight: bold;
            line-height: 1.2;
        }

        .kpi-trend {
            font-size: 6px;
            margin-top: 2px;
            font-weight: bold;
        }

        .trend-up { color: #28a745; }
        .trend-down { color: #dc3545; }
        .trend-stable { color: #6c757d; }

        .charts-section {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 20px;
        }

        .chart-container {
            background: white;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 15px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .chart-title {
            font-size: 12px;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
            text-align: center;
        }

        .chart-bars {
            height: 120px;
            display: flex;
            align-items: end;
            justify-content: space-around;
            margin-bottom: 8px;
            background: #f8f9fa;
            border-radius: 4px;
            padding: 8px;
        }

        .chart-bar {
            width: 15px;
            background: linear-gradient(to top, #8B1538, #D4AF37);
            border-radius: 2px;
            position: relative;
            margin: 0 2px;
        }

        .chart-bar:nth-child(1) { height: 80%; }
        .chart-bar:nth-child(2) { height: 65%; }
        .chart-bar:nth-child(3) { height: 90%; }
        .chart-bar:nth-child(4) { height: 70%; }
        .chart-bar:nth-child(5) { height: 85%; }
        .chart-bar:nth-child(6) { height: 95%; }
        .chart-bar:nth-child(7) { height: 88%; }

        .chart-labels {
            display: flex;
            justify-content: space-around;
            font-size: 7px;
            color: #666;
        }

        .pie-chart {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: conic-gradient(
                #28a745 0deg 252deg,
                #ffc107 252deg 288deg,
                #dc3545 288deg 360deg
            );
            margin: 0 auto 8px;
            position: relative;
        }

        .pie-center {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 60px;
            height: 60px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 8px;
            font-weight: bold;
            color: #333;
        }

        .pie-legend {
            display: flex;
            justify-content: center;
            gap: 8px;
            font-size: 7px;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 2px;
        }

        .legend-color {
            width: 8px;
            height: 8px;
            border-radius: 2px;
        }

        .performance-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background: white;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            border-radius: 8px;
            overflow: hidden;
            font-size: 8px;
        }

        .table-header {
            background: linear-gradient(135deg, #8B1538, #B91B47);
            color: white;
        }

        .performance-table th {
            padding: 8px 6px;
            text-align: left;
            font-weight: bold;
            font-size: 7px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .performance-table td {
            padding: 6px;
            border-bottom: 1px solid #e9ecef;
            font-size: 7px;
        }

        .performance-table tr:nth-child(even) {
            background: #f8f9fa;
        }

        .performance-table tr:hover {
            background: #e7f3ff;
        }

        .status-indicator {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 4px;
        }

        .status-excellent { background: #28a745; }
        .status-good { background: #28a745; }
        .status-warning { background: #ffc107; }
        .status-critical { background: #dc3545; }

        .regional-analysis {
            background: white;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 20px;
        }

        .regional-title {
            font-size: 12px;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
            text-align: center;
        }

        .regional-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
        }

        .regional-card {
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            border: 1px solid #dee2e6;
            border-radius: 6px;
            padding: 10px;
            text-align: center;
        }

        .regional-name {
            font-size: 9px;
            font-weight: bold;
            color: #8B1538;
            margin-bottom: 5px;
        }

        .regional-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 5px;
            font-size: 7px;
        }

        .regional-stat {
            text-align: center;
        }

        .regional-stat-value {
            font-weight: bold;
            font-size: 10px;
            margin-bottom: 1px;
        }

        .regional-stat-label {
            color: #666;
            font-size: 6px;
        }

        .security-metrics {
            background: linear-gradient(135deg, #dc3545, #c82333);
            color: white;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .security-title {
            font-size: 12px;
            font-weight: bold;
            color: #fff;
            margin-bottom: 10px;
            text-align: center;
        }

        .security-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 8px;
        }

        .security-item {
            text-align: center;
            background: rgba(255,255,255,0.1);
            padding: 8px;
            border-radius: 6px;
            border: 1px solid rgba(255,255,255,0.2);
        }

        .security-value {
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 2px;
        }

        .security-label {
            font-size: 6px;
            color: rgba(255,255,255,0.9);
            text-transform: uppercase;
        }

        .trends-analysis {
            background: white;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 20px;
        }

        .trend-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 6px 0;
            border-bottom: 1px solid #e9ecef;
        }

        .trend-item:last-child {
            border-bottom: none;
        }

        .trend-metric {
            font-weight: bold;
            color: #333;
            font-size: 9px;
        }

        .trend-values {
            display: flex;
            gap: 10px;
            font-size: 8px;
        }

        .trend-current {
            font-weight: bold;
            color: #8B1538;
        }

        .trend-previous {
            color: #666;
        }

        .trend-change {
            font-weight: bold;
            padding: 2px 4px;
            border-radius: 3px;
            font-size: 7px;
        }

        .footer-stats {
            background: #8B1538;
            color: white;
            padding: 15px;
            border-radius: 8px;
            margin-top: 20px;
            text-align: center;
        }

        .footer-title {
            font-size: 12px;
            font-weight: bold;
            color: #D4AF37;
            margin-bottom: 8px;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            font-size: 8px;
        }

        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 80px;
            color: rgba(139, 21, 56, 0.03);
            font-weight: bold;
            z-index: -1;
            pointer-events: none;
        }

        .page-break {
            page-break-before: always;
        }

        .classification {
            position: fixed;
            top: 10mm;
            right: 10mm;
            background: #dc3545;
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 8px;
            font-weight: bold;
            transform: rotate(45deg);
        }

        .page-number {
            position: fixed;
            bottom: 10mm;
            right: 10mm;
            font-size: 8px;
            color: #666;
        }

        @media print {
            body {
                background: white !important;
            }

            .chart-container {
                break-inside: avoid;
            }
        }
    </style>
</head>
<body>
    <div class="watermark">STATISTICS</div>
    <div class="classification">CONFIDENTIAL</div>

    <!-- Header -->
    <div class="header">
        <div class="logo-section">
            <div class="logo">📊</div>
            <div class="header-text">
                <div class="main-title">Digital ID System Statistics</div>
                <div class="sub-title">Comprehensive Analytics Dashboard</div>
                <div class="timestamp">Generated: 2025-06-14 23:52:15 UTC by J33WAKASUPUN</div>
            </div>
        </div>
    </div>

    <!-- Executive Overview -->
    <div class="report-overview">
        <div class="overview-title">🎯 Executive Dashboard Overview</div>

        <div class="overview-grid">
            <div class="overview-item">
                <div class="overview-number">1,247,893</div>
                <div class="overview-label">Total Digital IDs</div>
            </div>

            <div class="overview-item">
                <div class="overview-number">98.7%</div>
                <div class="overview-label">System Uptime</div>
            </div>

            <div class="overview-item">
                <div class="overview-number">94.2%</div>
                <div class="overview-label">Processing Efficiency</div>
            </div>

            <div class="overview-item">
                <div class="overview-number">2.1s</div>
                <div class="overview-label">Avg Response Time</div>
            </div>
        </div>
    </div>

    <!-- Key Performance Indicators -->
    <div class="kpi-dashboard">
        <div class="kpi-title">📈 Key Performance Indicators (KPIs)</div>

        <div class="kpi-grid">
            <div class="kpi-card">
                <div class="kpi-value" style="color: #28a745;">24,567</div>
                <div class="kpi-label">Daily Applications</div>
                <div class="kpi-trend trend-up">↑ 18.2%</div>
            </div>

            <div class="kpi-card">
                <div class="kpi-value" style="color: #0d6efd;">97.8%</div>
                <div class="kpi-label">Approval Rate</div>
                <div class="kpi-trend trend-up">↑ 2.1%</div>
            </div>

            <div class="kpi-card">
                <div class="kpi-value" style="color: #6f42c1;">1.8 days</div>
                <div class="kpi-label">Avg Processing</div>
                <div class="kpi-trend trend-down">↓ 0.3 days</div>
            </div>

            <div class="kpi-card">
                <div class="kpi-value" style="color: #fd7e14;">12,345</div>
                <div class="kpi-label">Active Users</div>
                <div class="kpi-trend trend-up">↑ 5.7%</div>
            </div>

            <div class="kpi-card">
                <div class="kpi-value" style="color: #20c997;">99.1%</div>
                <div class="kpi-label">Security Score</div>
                <div class="kpi-trend trend-stable">→ 0.0%</div>
            </div>

            <div class="kpi-card">
                <div class="kpi-value" style="color: #e83e8c;">847,293</div>
                <div class="kpi-label">Verifications Today</div>
                <div class="kpi-trend trend-up">↑ 12.4%</div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="charts-section">
        <!-- Daily Processing Volume -->
        <div class="chart-container">
            <div class="chart-title">📊 Daily Processing Volume (Last 7 Days)</div>
            <div class="chart-bars">
                <div class="chart-bar"></div>
                <div class="chart-bar"></div>
                <div class="chart-bar"></div>
                <div class="chart-bar"></div>
                <div class="chart-bar"></div>
                <div class="chart-bar"></div>
                <div class="chart-bar"></div>
            </div>
            <div class="chart-labels">
                <span>Jun 8</span>
                <span>Jun 9</span>
                <span>Jun 10</span>
                <span>Jun 11</span>
                <span>Jun 12</span>
                <span>Jun 13</span>
                <span>Jun 14</span>
            </div>
        </div>

        <!-- Application Status Distribution -->
        <div class="chart-container">
            <div class="chart-title">🎯 Application Status Distribution</div>
            <div class="pie-chart">
                <div class="pie-center">
                    Status<br>
                    Overview
                </div>
            </div>
            <div class="pie-legend">
                <div class="legend-item">
                    <div class="legend-color" style="background: #28a745;"></div>
                    <span>Approved (70%)</span>
                </div>
                <div class="legend-item">
                    <div class="legend-color" style="background: #ffc107;"></div>
                    <span>Pending (20%)</span>
                </div>
                <div class="legend-item">
                    <div class="legend-color" style="background: #dc3545;"></div>
                    <span>Rejected (10%)</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Regional Performance Analysis -->
    <div class="regional-analysis">
        <div class="regional-title">🌍 Regional Performance Analysis</div>

        <div class="regional-grid">
            @php
                $regions = [
                    ['name' => 'Western Province', 'applications' => 456789, 'efficiency' => 96.2, 'satisfaction' => 97.8],
                    ['name' => 'Central Province', 'applications' => 234567, 'efficiency' => 94.8, 'satisfaction' => 96.4],
                    ['name' => 'Southern Province', 'applications' => 198765, 'efficiency' => 93.9, 'satisfaction' => 95.7],
                    ['name' => 'Northern Province', 'applications' => 156789, 'efficiency' => 92.1, 'satisfaction' => 94.8],
                    ['name' => 'Eastern Province', 'applications' => 134567, 'efficiency' => 91.6, 'satisfaction' => 93.9],
                    ['name' => 'North Western', 'applications' => 123456, 'efficiency' => 90.8, 'satisfaction' => 93.2]
                ];
            @endphp

            @foreach($regions as $region)
                <div class="regional-card">
                    <div class="regional-name">{{ $region['name'] }}</div>
                    <div class="regional-stats">
                        <div class="regional-stat">
                            <div class="regional-stat-value" style="color: #8B1538;">{{ number_format($region['applications']) }}</div>
                            <div class="regional-stat-label">Applications</div>
                        </div>
                        <div class="regional-stat">
                            <div class="regional-stat-value" style="color: #0d6efd;">{{ $region['efficiency'] }}%</div>
                            <div class="regional-stat-label">Efficiency</div>
                        </div>
                        <div class="regional-stat">
                            <div class="regional-stat-value" style="color: #28a745;">{{ $region['satisfaction'] }}%</div>
                            <div class="regional-stat-label">Satisfaction</div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- System Performance Table -->
    <table class="performance-table">
        <thead class="table-header">
            <tr>
                <th>Service Component</th>
                <th>Uptime</th>
                <th>Response Time</th>
                <th>Error Rate</th>
                <th>Throughput</th>
                <th>Status</th>
                <th>Last Check</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Application Processing Engine</td>
                <td>99.97%</td>
                <td>1.2s</td>
                <td>0.03%</td>
                <td>2,847 req/min</td>
                <td><span class="status-indicator status-excellent"></span>Excellent</td>
                <td>23:52:10</td>
            </tr>
            <tr>
                <td>Digital Card Generator</td>
                <td>99.94%</td>
                <td>2.1s</td>
                <td>0.06%</td>
                <td>1,234 req/min</td>
                <td><span class="status-indicator status-excellent"></span>Excellent</td>
                <td>23:52:05</td>
            </tr>
            <tr>
                <td>Verification Service</td>
                <td>99.99%</td>
                <td>0.8s</td>
                <td>0.01%</td>
                <td>5,678 req/min</td>
                <td><span class="status-indicator status-excellent"></span>Excellent</td>
                <td>23:52:15</td>
            </tr>
            <tr>
                <td>Biometric Database</td>
                <td>99.92%</td>
                <td>1.7s</td>
                <td>0.08%</td>
                <td>987 req/min</td>
                <td><span class="status-indicator status-good"></span>Good</td>
                <td>23:52:00</td>
            </tr>
            <tr>
                <td>Document Storage</td>
                <td>99.89%</td>
                <td>3.2s</td>
                <td>0.11%</td>
                <td>654 req/min</td>
                <td><span class="status-indicator status-warning"></span>Warning</td>
                <td>23:51:45</td>
            </tr>
            <tr>
                <td>Mobile API Gateway</td>
                <td>99.95%</td>
                <td>1.5s</td>
                <td>0.05%</td>
                <td>3,456 req/min</td>
                <td><span class="status-indicator status-excellent"></span>Excellent</td>
                <td>23:52:12</td>
            </tr>
        </tbody>
    </table>

    <!-- Page Break -->
    <div class="page-break"></div>

    <!-- Security Metrics -->
    <div class="security-metrics">
        <div class="security-title">🔒 Security & Compliance Metrics</div>

        <div class="security-grid">
            <div class="security-item">
                <div class="security-value">99.1%</div>
                <div class="security-label">Security Score</div>
            </div>

            <div class="security-item">
                <div class="security-value">0</div>
                <div class="security-label">Critical Alerts</div>
            </div>

            <div class="security-item">
                <div class="security-value">3</div>
                <div class="security-label">Minor Warnings</div>
            </div>

            <div class="security-item">
                <div class="security-value">2,847,593</div>
                <div class="security-label">Blocks Prevented</div>
            </div>

            <div class="security-item">
                <div class="security-value">100%</div>
                <div class="security-label">Compliance Rate</div>
            </div>
        </div>
    </div>

    <!-- Trends Analysis -->
    <div class="trends-analysis">
        <div class="kpi-title">📊 Performance Trends Analysis</div>

        @php
            $trends = [
                ['metric' => 'Daily Application Volume', 'current' => '24,567', 'previous' => '20,834', 'change' => '+17.9%', 'trend' => 'up'],
                ['metric' => 'Average Processing Time', 'current' => '1.8 days', 'previous' => '2.1 days', 'change' => '-14.3%', 'trend' => 'down'],
                ['metric' => 'System Response Time', 'current' => '2.1s', 'previous' => '2.4s', 'change' => '-12.5%', 'trend' => 'down'],
                ['metric' => 'User Satisfaction Rate', 'current' => '97.8%', 'previous' => '96.4%', 'change' => '+1.4%', 'trend' => 'up'],
                ['metric' => 'Digital Card Issuance', 'current' => '18,945', 'previous' => '16,234', 'change' => '+16.7%', 'trend' => 'up'],
                ['metric' => 'Verification Requests', 'current' => '847,293', 'previous' => '756,134', 'change' => '+12.1%', 'trend' => 'up'],
                ['metric' => 'Security Incidents', 'current' => '0', 'previous' => '2', 'change' => '-100%', 'trend' => 'down'],
                ['metric' => 'System Uptime', 'current' => '99.97%', 'previous' => '99.94%', 'change' => '+0.03%', 'trend' => 'up']
            ];
        @endphp

        @foreach($trends as $trend)
            <div class="trend-item">
                <div class="trend-metric">{{ $trend['metric'] }}</div>
                <div class="trend-values">
                    <div class="trend-current">{{ $trend['current'] }}</div>
                    <div class="trend-previous">({{ $trend['previous'] }})</div>
                    <div class="trend-change {{ $trend['trend'] === 'up' ? 'trend-up' : 'trend-down' }}"
                         style="background: {{ $trend['trend'] === 'up' ? '#d4edda' : '#f8d7da' }}; color: {{ $trend['trend'] === 'up' ? '#155724' : '#721c24' }};">
                        {{ $trend['change'] }}
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- System Health Summary -->
    <div class="kpi-dashboard">
        <div class="kpi-title">💊 System Health Summary</div>

        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px;">
            <div style="text-align: center; padding: 10px; background: #d4edda; border: 1px solid #c3e6cb; border-radius: 6px;">
                <div style="font-size: 14px; font-weight: bold; color: #155724;">Operational</div>
                <div style="font-size: 8px; color: #155724;">All systems running normally</div>
            </div>

            <div style="text-align: center; padding: 10px; background: #cce7ff; border: 1px solid #b3d9ff; border-radius: 6px;">
                <div style="font-size: 14px; font-weight: bold; color: #004085;">Optimized</div>
                <div style="font-size: 8px; color: #004085;">Performance within targets</div>
            </div>

            <div style="text-align: center; padding: 10px; background: #fff3cd; border: 1px solid #ffeaa7; border-radius: 6px;">
                <div style="font-size: 14px; font-weight: bold; color: #856404;">Monitoring</div>
                <div style="font-size: 8px; color: #856404;">Minor issues being tracked</div>
            </div>

            <div style="text-align: center; padding: 10px; background: #e2e3e5; border: 1px solid #d1d3d4; border-radius: 6px;">
                <div style="font-size: 14px; font-weight: bold; color: #383d41;">Scheduled</div>
                <div style="font-size: 8px; color: #383d41;">Maintenance Sunday 02:00</div>
            </div>
        </div>
    </div>

    <!-- Footer Statistics -->
    <div class="footer-stats">
        <div class="footer-title">🏛️ Digital Identity Department</div>

        <div class="footer-grid">
            <div>
                <strong>Report Classification:</strong><br>
                CONFIDENTIAL<br>
                For Official Use Only<br>
                Distribution Restricted<br><br>

                <strong>Generated By:</strong><br>
                J33WAKASUPUN<br>
                System Administrator<br>
                Digital ID Management System
            </div>

            <div>
                <strong>Data Sources:</strong><br>
                • Application Processing Engine<br>
                • Biometric Database<br>
                • Verification Service<br>
                • Security Monitoring<br><br>

                <strong>Update Frequency:</strong><br>
                Real-time (Auto-refresh: 30s)<br>
                Report Generation: On-demand<br>
                Archive Retention: 7 years
            </div>

            <div>
                <strong>Contact Information:</strong><br>
                Email: stats@digitalid.gov.lk<br>
                Phone: +94 11 234 5678<br>
                Emergency: +94 11 987 6543<br><br>

                <strong>System Information:</strong><br>
                Version: v2.1.0 Production<br>
                Build: 2025.06.14.2352<br>
                Environment: AWS Asia Pacific
            </div>
        </div>

        <div style="margin-top: 12px; padding-top: 8px; border-top: 1px solid rgba(255,255,255,0.3); font-size: 7px;">
            © 2025 Government of Sri Lanka • Ministry of Technology • Department of Digital Identity<br>
            This document contains sensitive operational data and should be handled according to government data classification protocols.
        </div>
    </div>

    <div class="page-number">
        Page 1 of 1 • Generated: 2025-06-14 23:52:15 UTC • Next Update: 2025-06-15 00:22:15 UTC
    </div>
</body>
</html>
