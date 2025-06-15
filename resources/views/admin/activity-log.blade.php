@extends('layouts.app')

@section('title', 'Activity Log - Admin')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="md:flex md:items-center md:justify-between">
                <div class="flex-1 min-w-0">
                    <h1 class="text-2xl font-bold text-gray-900">📋 System Activity Log</h1>
                    <p class="text-gray-600">Complete system activity and user action history</p>
                    <p class="text-sm text-gray-500">
                        Log Administrator: {{ auth()->user()->name }} • {{ now()->format('F j, Y \a\t g:i A') }} UTC
                    </p>
                </div>
                <div class="mt-4 flex md:mt-0 md:ml-4 space-x-3">
                    <button class="bg-blue-600 text-white rounded-md px-4 py-2 text-sm font-medium hover:bg-blue-700 transition-colors duration-200">
                        📥 Export Log
                    </button>
                    <button class="bg-green-600 text-white rounded-md px-4 py-2 text-sm font-medium hover:bg-green-700 transition-colors duration-200">
                        🔍 Filter Activities
                    </button>
                    <a href="{{ route('admin.dashboard') }}"
                       class="bg-gray-600 text-white rounded-md px-4 py-2 text-sm font-medium hover:bg-gray-700 transition-colors duration-200">
                        ← Back to Dashboard
                    </a>
                </div>
            </div>
        </div>

        <!-- Activity Statistics -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Today's Activities -->
            <div class="bg-white shadow rounded-lg p-6 border-l-4 border-blue-500">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="h-12 w-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <span class="text-2xl">📅</span>
                        </div>
                    </div>
                    <div class="ml-4">
                        <dt class="text-sm font-medium text-gray-500">Today's Activities</dt>
                        <dd class="text-2xl font-bold text-blue-600">142</dd>
                        <p class="text-xs text-gray-500 mt-1">User actions logged</p>
                    </div>
                </div>
            </div>

            <!-- User Logins -->
            <div class="bg-white shadow rounded-lg p-6 border-l-4 border-green-500">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="h-12 w-12 bg-green-100 rounded-lg flex items-center justify-center">
                            <span class="text-2xl">🔑</span>
                        </div>
                    </div>
                    <div class="ml-4">
                        <dt class="text-sm font-medium text-gray-500">User Logins</dt>
                        <dd class="text-2xl font-bold text-green-600">34</dd>
                        <p class="text-xs text-gray-500 mt-1">Successful logins today</p>
                    </div>
                </div>
            </div>

            <!-- System Events -->
            <div class="bg-white shadow rounded-lg p-6 border-l-4 border-purple-500">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="h-12 w-12 bg-purple-100 rounded-lg flex items-center justify-center">
                            <span class="text-2xl">⚙️</span>
                        </div>
                    </div>
                    <div class="ml-4">
                        <dt class="text-sm font-medium text-gray-500">System Events</dt>
                        <dd class="text-2xl font-bold text-purple-600">8</dd>
                        <p class="text-xs text-gray-500 mt-1">Automated processes</p>
                    </div>
                </div>
            </div>

            <!-- Security Events -->
            <div class="bg-white shadow rounded-lg p-6 border-l-4 border-yellow-500">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="h-12 w-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                            <span class="text-2xl">🛡️</span>
                        </div>
                    </div>
                    <div class="ml-4">
                        <dt class="text-sm font-medium text-gray-500">Security Events</dt>
                        <dd class="text-2xl font-bold text-yellow-600">2</dd>
                        <p class="text-xs text-gray-500 mt-1">Security-related actions</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">🕒 Recent System Activity</h3>
                <p class="text-sm text-gray-600">Latest user actions and system events</p>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @php
                        $activities = [
                            ['time' => '2 minutes ago', 'user' => 'DS Officer - Colombo', 'action' => 'Approved application #DID-2025-001234', 'type' => 'success', 'ip' => '192.168.1.45'],
                            ['time' => '15 minutes ago', 'user' => 'GS Officer - Kandy', 'action' => 'Reviewed application #DID-2025-001233', 'type' => 'info', 'ip' => '192.168.1.67'],
                            ['time' => '1 hour ago', 'user' => 'Admin - Central', 'action' => 'Created new GS user account', 'type' => 'admin', 'ip' => '192.168.1.10'],
                            ['time' => '2 hours ago', 'user' => 'Applicant - Gampaha', 'action' => 'Submitted new application', 'type' => 'application', 'ip' => '203.94.94.15'],
                            ['time' => '4 hours ago', 'user' => 'System', 'action' => 'Daily backup completed successfully', 'type' => 'system', 'ip' => 'localhost'],
                            ['time' => '5 hours ago', 'user' => 'DS Officer - Galle', 'action' => 'Generated digital card #DC-789012', 'type' => 'success', 'ip' => '192.168.1.89'],
                            ['time' => '6 hours ago', 'user' => 'Admin - Central', 'action' => 'Updated system security settings', 'type' => 'security', 'ip' => '192.168.1.10'],
                            ['time' => '8 hours ago', 'user' => 'GS Officer - Matara', 'action' => 'Rejected incomplete application', 'type' => 'warning', 'ip' => '192.168.1.123'],
                        ];
                    @endphp

                    @foreach($activities as $activity)
                        <div class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                            <div class="flex-shrink-0">
                                @if($activity['type'] === 'success')
                                    <div class="h-10 w-10 bg-green-100 rounded-full flex items-center justify-center">
                                        <span class="text-green-600 text-lg">✅</span>
                                    </div>
                                @elseif($activity['type'] === 'info')
                                    <div class="h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center">
                                        <span class="text-blue-600 text-lg">ℹ️</span>
                                    </div>
                                @elseif($activity['type'] === 'admin')
                                    <div class="h-10 w-10 bg-purple-100 rounded-full flex items-center justify-center">
                                        <span class="text-purple-600 text-lg">👑</span>
                                    </div>
                                @elseif($activity['type'] === 'application')
                                    <div class="h-10 w-10 bg-yellow-100 rounded-full flex items-center justify-center">
                                        <span class="text-yellow-600 text-lg">📄</span>
                                    </div>
                                @elseif($activity['type'] === 'security')
                                    <div class="h-10 w-10 bg-red-100 rounded-full flex items-center justify-center">
                                        <span class="text-red-600 text-lg">🛡️</span>
                                    </div>
                                @elseif($activity['type'] === 'warning')
                                    <div class="h-10 w-10 bg-orange-100 rounded-full flex items-center justify-center">
                                        <span class="text-orange-600 text-lg">⚠️</span>
                                    </div>
                                @else
                                    <div class="h-10 w-10 bg-gray-100 rounded-full flex items-center justify-center">
                                        <span class="text-gray-600 text-lg">⚙️</span>
                                    </div>
                                @endif
                            </div>
                            <div class="ml-4 flex-1">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="font-semibold text-gray-900">{{ $activity['user'] }}</p>
                                        <p class="text-gray-600">{{ $activity['action'] }}</p>
                                        <p class="text-xs text-gray-500 mt-1">IP: {{ $activity['ip'] }}</p>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-sm text-gray-500">{{ $activity['time'] }}</div>
                                        <div class="text-xs text-gray-400">{{ now()->format('M j, Y') }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-6 flex justify-between items-center">
                    <p class="text-sm text-gray-500">
                        Showing 8 of 1,247 total activities from today
                    </p>
                    <div class="flex space-x-2">
                        <button class="bg-gray-300 text-gray-700 px-3 py-2 rounded-md text-sm hover:bg-gray-400 transition-colors duration-200">
                            Previous
                        </button>
                        <button class="bg-purple-600 text-white px-3 py-2 rounded-md text-sm hover:bg-purple-700 transition-colors duration-200">
                            Next
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
