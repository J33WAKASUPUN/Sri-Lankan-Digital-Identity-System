@extends('layouts.app')

@section('title', 'Admin Dashboard - Digital ID System')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="md:flex md:items-center md:justify-between">
                <div class="flex-1 min-w-0">
                    <h1 class="text-2xl font-bold text-gray-900">🇱🇰 Admin Dashboard</h1>
                    <p class="text-gray-600">Digital Identity Management System</p>
                    <p class="text-sm text-gray-500">Welcome back, {{ auth()->user()->name }}</p>
                </div>
                <div class="mt-4 flex md:mt-0 md:ml-4 space-x-3">
                    <a href="{{ route('admin.reports') }}"
                       class="bg-white border border-gray-300 rounded-md px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
                        📊 Reports
                    </a>
                    <a href="{{ route('admin.applications') }}"
                       class="bg-purple-600 text-white rounded-md px-4 py-2 text-sm font-medium hover:bg-purple-700">
                        🏢 Manage System
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- System Status -->
        <div class="mb-8">
            <div class="bg-green-500 rounded-lg shadow p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold">🟢 System Status: Operational</h3>
                        <p class="text-green-100">All services running normally</p>
                    </div>
                    <div class="text-2xl">✅</div>
                </div>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4 mb-8">
            <!-- Total Applications -->
            <div class="bg-white shadow rounded-lg border-l-4 border-purple-600">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="h-10 w-10 bg-purple-100 rounded-full flex items-center justify-center">
                                <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <dt class="text-sm font-medium text-gray-500">Total Applications</dt>
                            <dd class="text-2xl font-bold text-purple-600">{{ $stats['total'] ?? 0 }}</dd>
                        </div>
                    </div>
                </div>
                <div class="bg-purple-50 px-6 py-3">
                    <a href="{{ route('admin.applications') }}" class="text-sm font-medium text-purple-700 hover:text-purple-900">
                        Manage →
                    </a>
                </div>
            </div>

            <!-- Pending Applications -->
            <div class="bg-white shadow rounded-lg border-l-4 border-yellow-600">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="h-10 w-10 bg-yellow-100 rounded-full flex items-center justify-center">
                                <svg class="h-6 w-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <dt class="text-sm font-medium text-gray-500">Pending</dt>
                            <dd class="text-2xl font-bold text-yellow-600">{{ $stats['pending'] ?? 0 }}</dd>
                        </div>
                    </div>
                </div>
                <div class="bg-yellow-50 px-6 py-3">
                    <a href="{{ route('admin.applications', ['status' => 'pending']) }}" class="text-sm font-medium text-yellow-700 hover:text-yellow-900">
                        Review →
                    </a>
                </div>
            </div>

            <!-- Approved Applications -->
            <div class="bg-white shadow rounded-lg border-l-4 border-green-600">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="h-10 w-10 bg-green-100 rounded-full flex items-center justify-center">
                                <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <dt class="text-sm font-medium text-gray-500">Approved</dt>
                            <dd class="text-2xl font-bold text-green-600">{{ $stats['ds_approved'] ?? 0 }}</dd>
                        </div>
                    </div>
                </div>
                <div class="bg-green-50 px-6 py-3">
                    <a href="{{ route('admin.applications', ['status' => 'ds_approved']) }}" class="text-sm font-medium text-green-700 hover:text-green-900">
                        View →
                    </a>
                </div>
            </div>

            <!-- Total Users -->
            <div class="bg-white shadow rounded-lg border-l-4 border-blue-600">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center">
                                <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <dt class="text-sm font-medium text-gray-500">System Users</dt>
                            <dd class="text-2xl font-bold text-blue-600">{{ $systemStats['total_users'] ?? 0 }}</dd>
                        </div>
                    </div>
                </div>
                <div class="bg-blue-50 px-6 py-3">
                    <a href="{{ route('admin.users') }}" class="text-sm font-medium text-blue-700 hover:text-blue-900">
                        Manage →
                    </a>
                </div>
            </div>
        </div>

        <!-- Recent Applications & Quick Actions -->
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
            <!-- Recent Applications -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Recent Applications</h3>
                    <p class="text-sm text-gray-600">Latest 10 application submissions</p>
                </div>
                <div class="overflow-hidden">
                    <ul class="divide-y divide-gray-200">
                        @forelse($recentApplications as $application)
                            <li class="px-6 py-4 hover:bg-gray-50">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">
                                            {{ $application->application_number }}
                                        </p>
                                        <p class="text-sm text-gray-500">
                                            {{ $application->full_name }}
                                        </p>
                                    </div>
                                    <div class="text-right">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            @if($application->status === 'ds_approved') bg-green-100 text-green-800
                                            @elseif($application->status === 'gs_approved') bg-blue-100 text-blue-800
                                            @elseif($application->status === 'pending') bg-yellow-100 text-yellow-800
                                            @else bg-red-100 text-red-800 @endif">
                                            {{ ucfirst(str_replace('_', ' ', $application->status)) }}
                                        </span>
                                        <p class="text-xs text-gray-500 mt-1">
                                            {{ $application->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                </div>
                            </li>
                        @empty
                            <li class="px-6 py-4 text-center text-gray-500">
                                No recent applications
                            </li>
                        @endforelse
                    </ul>
                </div>
                <div class="bg-gray-50 px-6 py-3">
                    <a href="{{ route('admin.applications') }}" class="text-sm font-medium text-purple-700 hover:text-purple-900">
                        View all applications →
                    </a>
                </div>
            </div>

            <!-- Admin Actions -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Admin Actions</h3>
                    <p class="text-sm text-gray-600">System management functions</p>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 gap-4">
                        <!-- User Management -->
                        <a href="{{ route('admin.users') }}"
                           class="group flex items-center p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors">
                            <div class="flex-shrink-0">
                                <div class="h-8 w-8 bg-purple-600 rounded-lg flex items-center justify-center group-hover:bg-purple-700">
                                    <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4 flex-1">
                                <h3 class="text-sm font-medium text-gray-900">User Management</h3>
                                <p class="text-sm text-gray-600">{{ $systemStats['total_users'] ?? 0 }} users total</p>
                            </div>
                            <svg class="h-5 w-5 text-gray-400 group-hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>

                        <!-- Application Management -->
                        <a href="{{ route('admin.applications') }}"
                           class="group flex items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                            <div class="flex-shrink-0">
                                <div class="h-8 w-8 bg-green-600 rounded-lg flex items-center justify-center group-hover:bg-green-700">
                                    <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4 flex-1">
                                <h3 class="text-sm font-medium text-gray-900">Application Management</h3>
                                <p class="text-sm text-gray-600">{{ $stats['total'] ?? 0 }} applications total</p>
                            </div>
                            <svg class="h-5 w-5 text-gray-400 group-hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>

                        <!-- Reports -->
                        <a href="{{ route('admin.reports') }}"
                           class="group flex items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                            <div class="flex-shrink-0">
                                <div class="h-8 w-8 bg-blue-600 rounded-lg flex items-center justify-center group-hover:bg-blue-700">
                                    <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4 flex-1">
                                <h3 class="text-sm font-medium text-gray-900">System Reports</h3>
                                <p class="text-sm text-gray-600">Generate analytics & reports</p>
                            </div>
                            <svg class="h-5 w-5 text-gray-400 group-hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>

                        <!-- Digital Cards -->
                        <a href="{{ route('admin.digital-cards') }}"
                           class="group flex items-center p-4 bg-indigo-50 rounded-lg hover:bg-indigo-100 transition-colors">
                            <div class="flex-shrink-0">
                                <div class="h-8 w-8 bg-indigo-600 rounded-lg flex items-center justify-center group-hover:bg-indigo-700">
                                    <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V4a2 2 0 114 0v2m-4 0a2 2 0 104 0m-4 0v2m0 0v5" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4 flex-1">
                                <h3 class="text-sm font-medium text-gray-900">Digital Card Registry</h3>
                                <p class="text-sm text-gray-600">Manage issued digital IDs</p>
                            </div>
                            <svg class="h-5 w-5 text-gray-400 group-hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- System Information -->
        <div class="mt-8">
            <div class="bg-gray-800 rounded-lg shadow p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold">🇱🇰 Sri Lankan Digital Identity System</h3>
                        <p class="text-gray-300">Administrator Control Panel - Government of Sri Lanka</p>
                        <p class="text-sm text-gray-400 mt-2">
                            GS Officers: {{ $systemStats['total_gs'] ?? 0 }} •
                            DS Officers: {{ $systemStats['total_ds'] ?? 0 }} •
                            System Uptime: 99.9%
                        </p>
                    </div>
                    <div class="text-3xl">🏛️</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
