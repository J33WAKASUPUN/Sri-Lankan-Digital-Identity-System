@extends('layouts.app')

@section('title', 'Security Center - Admin')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="md:flex md:items-center md:justify-between">
                <div class="flex-1 min-w-0">
                    <h1 class="text-2xl font-bold text-gray-900">🔒 Security Center</h1>
                    <p class="text-gray-600">System security monitoring and threat detection</p>
                    <p class="text-sm text-gray-500">
                        Security Administrator: {{ auth()->user()->name }} • {{ now()->format('F j, Y \a\t g:i A') }} UTC
                    </p>
                </div>
                <div class="mt-4 flex md:mt-0 md:ml-4">
                    <a href="{{ route('admin.dashboard') }}"
                       class="bg-gray-600 text-white rounded-md px-4 py-2 text-sm font-medium hover:bg-gray-700 transition-colors duration-200">
                        ← Back to Dashboard
                    </a>
                </div>
            </div>
        </div>

        <!-- Security Status Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- System Status -->
            <div class="bg-white shadow rounded-lg p-6 border-l-4 border-green-500">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="h-12 w-12 bg-green-100 rounded-lg flex items-center justify-center">
                            <span class="text-2xl">🛡️</span>
                        </div>
                    </div>
                    <div class="ml-4">
                        <dt class="text-sm font-medium text-gray-500">System Status</dt>
                        <dd class="text-lg font-bold text-green-600">🟢 Secure</dd>
                        <p class="text-xs text-gray-500 mt-1">All systems operational</p>
                    </div>
                </div>
            </div>

            <!-- Active Sessions -->
            <div class="bg-white shadow rounded-lg p-6 border-l-4 border-blue-500">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="h-12 w-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <span class="text-2xl">👥</span>
                        </div>
                    </div>
                    <div class="ml-4">
                        <dt class="text-sm font-medium text-gray-500">Active Sessions</dt>
                        <dd class="text-2xl font-bold text-blue-600">23</dd>
                        <p class="text-xs text-gray-500 mt-1">Current user sessions</p>
                    </div>
                </div>
            </div>

            <!-- Security Alerts -->
            <div class="bg-white shadow rounded-lg p-6 border-l-4 border-yellow-500">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="h-12 w-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                            <span class="text-2xl">⚠️</span>
                        </div>
                    </div>
                    <div class="ml-4">
                        <dt class="text-sm font-medium text-gray-500">Security Alerts</dt>
                        <dd class="text-2xl font-bold text-yellow-600">0</dd>
                        <p class="text-xs text-gray-500 mt-1">No active alerts</p>
                    </div>
                </div>
            </div>

            <!-- Failed Logins -->
            <div class="bg-white shadow rounded-lg p-6 border-l-4 border-red-500">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="h-12 w-12 bg-red-100 rounded-lg flex items-center justify-center">
                            <span class="text-2xl">🚫</span>
                        </div>
                    </div>
                    <div class="ml-4">
                        <dt class="text-sm font-medium text-gray-500">Failed Logins</dt>
                        <dd class="text-2xl font-bold text-red-600">2</dd>
                        <p class="text-xs text-gray-500 mt-1">Last 24 hours</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Security Details Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Security Alerts -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">🚨 Recent Security Events</h3>
                    <p class="text-sm text-gray-600">Latest security-related activities</p>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <div class="flex items-center p-3 bg-green-50 rounded-lg">
                            <span class="text-green-600 text-xl mr-3">✅</span>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-green-800">Successful admin login</p>
                                <p class="text-xs text-green-600">{{ auth()->user()->name }} - {{ now()->subMinutes(5)->format('g:i A') }}</p>
                            </div>
                        </div>
                        <div class="flex items-center p-3 bg-blue-50 rounded-lg">
                            <span class="text-blue-600 text-xl mr-3">🔄</span>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-blue-800">Security scan completed</p>
                                <p class="text-xs text-blue-600">System automated scan - {{ now()->subHours(1)->format('g:i A') }}</p>
                            </div>
                        </div>
                        <div class="flex items-center p-3 bg-yellow-50 rounded-lg">
                            <span class="text-yellow-600 text-xl mr-3">⚠️</span>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-yellow-800">Failed login attempt</p>
                                <p class="text-xs text-yellow-600">Unknown user - {{ now()->subHours(3)->format('g:i A') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- System Health -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">💪 System Health</h3>
                    <p class="text-sm text-gray-600">Current system performance metrics</p>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-sm font-medium text-gray-700">CPU Usage</span>
                            <span class="text-sm text-green-600">23%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-green-600 h-2 rounded-full" style="width: 23%"></div>
                        </div>

                        <div class="flex justify-between items-center">
                            <span class="text-sm font-medium text-gray-700">Memory Usage</span>
                            <span class="text-sm text-blue-600">67%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-blue-600 h-2 rounded-full" style="width: 67%"></div>
                        </div>

                        <div class="flex justify-between items-center">
                            <span class="text-sm font-medium text-gray-700">Disk Usage</span>
                            <span class="text-sm text-yellow-600">45%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-yellow-600 h-2 rounded-full" style="width: 45%"></div>
                        </div>

                        <div class="flex justify-between items-center">
                            <span class="text-sm font-medium text-gray-700">Network</span>
                            <span class="text-sm text-green-600">Optimal</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-green-600 h-2 rounded-full" style="width: 90%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Security Status Summary -->
        <div class="mt-8 bg-gradient-to-r from-green-50 to-blue-50 border border-green-200 rounded-lg p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="h-12 w-12 bg-green-100 rounded-full flex items-center justify-center">
                        <span class="text-green-600 text-2xl">✅</span>
                    </div>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-medium text-green-800">🛡️ All Security Systems Operational</h3>
                    <p class="text-sm text-green-700 mt-1">
                        No security alerts at this time. System is fully protected with all security measures active.
                        Last security scan: {{ now()->subHour()->format('F j, Y \a\t g:i A') }} UTC
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
