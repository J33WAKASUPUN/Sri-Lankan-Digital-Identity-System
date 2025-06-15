@extends('layouts.app')

@section('title', 'My Dashboard - Digital ID')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Simple Header -->
    <div class="bg-white shadow">
        <div class="max-w-6xl mx-auto px-4 py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">
                        Welcome, {{ auth()->user()->name }}!
                    </h1>
                    <p class="text-gray-600">Digital ID System Dashboard</p>
                </div>
                <a href="{{ route('applications.create') }}"
                   class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                    New Application
                </a>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-6xl mx-auto px-4 py-8">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Total Applications -->
            <div class="bg-white p-6 rounded shadow">
                <div class="flex items-center">
                    <div class="bg-blue-100 p-3 rounded">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-600">My Applications</p>
                        <p class="text-2xl font-bold">{{ $applications->count() }}</p>
                    </div>
                </div>
            </div>

            <!-- Digital Cards -->
            <div class="bg-white p-6 rounded shadow">
                <div class="flex items-center">
                    <div class="bg-green-100 p-3 rounded">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V4a2 2 0 114 0v2m-4 0a2 2 0 104 0m-4 0v2m0 0v5" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-600">Digital Cards</p>
                        <p class="text-2xl font-bold">{{ $applications->where('status', 'ds_approved')->count() }}</p>
                    </div>
                </div>
            </div>

            <!-- Notifications -->
            <div class="bg-white p-6 rounded shadow">
                <div class="flex items-center">
                    <div class="bg-yellow-100 p-3 rounded">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-600">New Notifications</p>
                        <p class="text-2xl font-bold">{{ $notifications->count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Applications List -->
        <div class="bg-white rounded shadow">
            <div class="px-6 py-4 border-b">
                <div class="flex justify-between items-center">
                    <h2 class="text-lg font-bold">Your Applications</h2>
                    @if($applications->isEmpty())
                        <a href="{{ route('applications.create') }}" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                            Start First Application
                        </a>
                    @endif
                </div>
            </div>

            @if($applications->isEmpty())
                <!-- Empty State -->
                <div class="text-center py-12">
                    <div class="w-16 h-16 bg-gray-100 rounded-full mx-auto mb-4 flex items-center justify-center">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No applications yet</h3>
                    <p class="text-gray-600 mb-6">Get started by creating your first digital ID application.</p>
                    <a href="{{ route('applications.create') }}"
                       class="bg-red-600 text-white px-6 py-3 rounded hover:bg-red-700">
                        Create Application
                    </a>
                </div>
            @else
                <!-- Applications Table -->
                <div class="divide-y">
                    @foreach($applications as $application)
                        <div class="p-6 hover:bg-gray-50">
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <!-- Status Badge -->
                                    <div class="mb-2">
                                        @switch($application->status)
                                            @case('pending')
                                                <span class="inline-block bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm">
                                                    ⏳ Pending Review
                                                </span>
                                                @break
                                            @case('gs_approved')
                                                <span class="inline-block bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">
                                                    📋 GS Approved
                                                </span>
                                                @break
                                            @case('ds_approved')
                                                <span class="inline-block bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm">
                                                    ✅ Card Ready
                                                </span>
                                                @break
                                            @case('rejected')
                                                <span class="inline-block bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm">
                                                    ❌ Rejected
                                                </span>
                                                @break
                                        @endswitch
                                    </div>

                                    <p class="font-medium text-gray-900">Application #{{ $application->application_number }}</p>
                                    <p class="text-sm text-gray-600">
                                        Submitted {{ $application->created_at->format('M j, Y') }} • {{ $application->created_at->diffForHumans() }}
                                    </p>
                                </div>

                                <div class="flex space-x-2">
                                    <!-- View Details -->
                                    <a href="{{ route('applications.show', $application->id) }}"
                                       class="text-red-600 hover:text-red-800 text-sm font-medium">
                                        View Details
                                    </a>

                                    <!-- Download Card if approved -->
                                    @if($application->status === 'ds_approved')
                                        <a href="{{ route('applications.downloadCard', $application->id) }}"
                                           class="bg-green-600 text-white px-3 py-1 rounded text-sm hover:bg-green-700">
                                            Download Card
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Recent Notifications -->
        @if($notifications->isNotEmpty())
        <div class="mt-8 bg-white rounded shadow">
            <div class="px-6 py-4 border-b">
                <div class="flex justify-between items-center">
                    <h2 class="text-lg font-bold">Recent Notifications</h2>
                    <a href="{{ route('notifications.index') }}" class="text-red-600 hover:text-red-800 text-sm font-medium">
                        View All
                    </a>
                </div>
            </div>
            <div class="divide-y">
                @foreach($notifications->take(3) as $notification)
                    <div class="p-4 hover:bg-gray-50">
                        <div class="flex">
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="font-medium text-gray-900">{{ $notification->title }}</p>
                                <p class="text-sm text-gray-600">{{ $notification->message }}</p>
                                <p class="text-xs text-gray-400 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Quick Actions -->
        <div class="mt-8 bg-white rounded shadow">
            <div class="px-6 py-4 border-b">
                <h2 class="text-lg font-bold">Quick Actions</h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- New Application -->
                    <a href="{{ route('applications.create') }}"
                       class="p-4 border rounded hover:bg-gray-50">
                        <div class="w-8 h-8 bg-red-100 rounded mb-3">
                            <svg class="w-8 h-8 p-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                        </div>
                        <h3 class="font-medium">New Application</h3>
                        <p class="text-sm text-gray-600">Start a new ID application</p>
                    </a>

                    <!-- Verify Card -->
                    <a href="{{ route('card.verify.form') }}"
                       class="p-4 border rounded hover:bg-gray-50">
                        <div class="w-8 h-8 bg-green-100 rounded mb-3">
                            <svg class="w-8 h-8 p-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="font-medium">Verify Card</h3>
                        <p class="text-sm text-gray-600">Check card authenticity</p>
                    </a>

                    <!-- Help -->
                    <a href="#" onclick="alert('Help section coming soon!')"
                       class="p-4 border rounded hover:bg-gray-50">
                        <div class="w-8 h-8 bg-blue-100 rounded mb-3">
                            <svg class="w-8 h-8 p-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="font-medium">Help & Support</h3>
                        <p class="text-sm text-gray-600">Get help with applications</p>
                    </a>

                    <!-- Contact -->
                    <a href="#" onclick="alert('📧 support@digitalid.gov.lk | 📞 +94 11 123 4567')"
                       class="p-4 border rounded hover:bg-gray-50">
                        <div class="w-8 h-8 bg-purple-100 rounded mb-3">
                            <svg class="w-8 h-8 p-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                        </div>
                        <h3 class="font-medium">Contact Us</h3>
                        <p class="text-sm text-gray-600">Get in touch</p>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
