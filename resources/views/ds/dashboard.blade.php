@extends('layouts.app')

@section('title', 'DS Dashboard - Digital ID')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Simple Header -->
    <div class="bg-white shadow">
        <div class="max-w-6xl mx-auto px-4 py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">
                        Divisional Secretariat Dashboard
                    </h1>
                    <p class="text-gray-600">Final Digital ID Approvals • Welcome, {{ auth()->user()->name }}</p>
                </div>
                <a href="{{ route('ds.applications') }}"
                   class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Review Applications
                </a>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-6xl mx-auto px-4 py-8">
        <!-- Stats Cards - USING YOUR EXACT CONTROLLER DATA -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <!-- Pending Review (GS Approved) -->
            <div class="bg-white p-6 rounded shadow">
                <div class="flex items-center">
                    <div class="bg-yellow-100 p-3 rounded">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-600">Pending Final Review</p>
                        <p class="text-2xl font-bold">{{ $stats['pending_review'] }}</p>
                    </div>
                </div>
            </div>

            <!-- Approved by You -->
            <div class="bg-white p-6 rounded shadow">
                <div class="flex items-center">
                    <div class="bg-green-100 p-3 rounded">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-600">Approved by You</p>
                        <p class="text-2xl font-bold">{{ $stats['approved_by_me'] }}</p>
                    </div>
                </div>
            </div>

            <!-- Digital Cards Issued -->
            <div class="bg-white p-6 rounded shadow">
                <div class="flex items-center">
                    <div class="bg-blue-100 p-3 rounded">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V4a2 2 0 114 0v2m-4 0a2 2 0 104 0m-4 0v2m0 0v5" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-600">Digital Cards Issued</p>
                        <p class="text-2xl font-bold">{{ $stats['cards_issued'] }}</p>
                    </div>
                </div>
            </div>

            <!-- Today Processed -->
            <div class="bg-white p-6 rounded shadow">
                <div class="flex items-center">
                    <div class="bg-purple-100 p-3 rounded">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-600">Today Processed</p>
                        <p class="text-2xl font-bold">{{ $stats['today_processed'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Applications - USING YOUR CONTROLLER DATA -->
        <div class="bg-white rounded shadow">
            <div class="px-6 py-4 border-b">
                <div class="flex justify-between items-center">
                    <h2 class="text-lg font-bold">Pending Final Approval</h2>
                    <a href="{{ route('ds.applications') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        View All ({{ $stats['pending_review'] }})
                    </a>
                </div>
            </div>

            @if($pendingApplications && $pendingApplications->isNotEmpty())
                <div class="divide-y">
                    @foreach($pendingApplications as $application)
                        <div class="p-6 hover:bg-gray-50">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    <!-- Applicant Initial Only -->
                                    <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center">
                                        <span class="text-gray-600 font-medium">
                                            {{ substr($application->first_name, 0, 1) }}{{ substr($application->last_name, 0, 1) }}
                                        </span>
                                    </div>

                                    <div>
                                        <p class="font-medium text-gray-900">{{ $application->full_name }}</p>
                                        <p class="text-sm text-gray-600">
                                            Application #{{ $application->application_number }} •
                                            GS Approved {{ $application->gs_verified_at->diffForHumans() }}
                                        </p>
                                        <div class="text-xs text-gray-500 mt-1">
                                            {{ $application->user->email }} • {{ $application->phone }}
                                            @if($application->gsVerifier)
                                                • Approved by: {{ $application->gsVerifier->name }}
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="flex items-center space-x-3">
                                    <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">
                                        📋 Awaiting Final Approval
                                    </span>
                                    <a href="{{ route('ds.review', $application) }}"
                                       class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm">
                                        Review Now
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-12">
                    <div class="w-16 h-16 bg-gray-100 rounded-full mx-auto mb-4 flex items-center justify-center">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No applications for final approval</h3>
                    <p class="text-gray-600">All GS approved applications have been processed. Great work!</p>
                </div>
            @endif
        </div>

        <!-- Quick Actions -->
        <div class="mt-8 bg-white rounded shadow">
            <div class="px-6 py-4 border-b">
                <h2 class="text-lg font-bold">Quick Actions</h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- Review Applications -->
                    <a href="{{ route('ds.applications') }}"
                       class="p-4 border rounded hover:bg-gray-50">
                        <div class="w-8 h-8 bg-blue-100 rounded mb-3">
                            <svg class="w-8 h-8 p-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="font-medium">Final Approvals</h3>
                        <p class="text-sm text-gray-600">{{ $stats['pending_review'] }} applications pending</p>
                    </a>

                    <!-- View History -->
                    <a href="{{ route('ds.history') }}"
                       class="p-4 border rounded hover:bg-gray-50">
                        <div class="w-8 h-8 bg-green-100 rounded mb-3">
                            <svg class="w-8 h-8 p-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="font-medium">Approval History</h3>
                        <p class="text-sm text-gray-600">{{ $stats['approved_by_me'] }} cards issued by you</p>
                    </a>

                    <!-- Digital Cards -->
                    <div class="p-4 border rounded">
                        <div class="w-8 h-8 bg-purple-100 rounded mb-3">
                            <svg class="w-8 h-8 p-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V4a2 2 0 114 0v2m-4 0a2 2 0 104 0m-4 0v2m0 0v5" />
                            </svg>
                        </div>
                        <h3 class="font-medium">Digital Cards</h3>
                        <p class="text-sm text-gray-600">{{ $stats['cards_issued'] }} total cards issued</p>
                    </div>

                    <!-- Help -->
                    <a href="#" onclick="alert('Help coming soon!')"
                       class="p-4 border rounded hover:bg-gray-50">
                        <div class="w-8 h-8 bg-orange-100 rounded mb-3">
                            <svg class="w-8 h-8 p-2 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="font-medium">Help & Guidelines</h3>
                        <p class="text-sm text-gray-600">Final approval procedures</p>
                    </a>
                </div>
            </div>
        </div>

        <!-- Performance Summary -->
        @if($stats['approved_by_me'] > 0 || $stats['cards_issued'] > 0)
        <div class="mt-8 bg-white rounded shadow">
            <div class="px-6 py-4 border-b">
                <h2 class="text-lg font-bold">Your Performance Summary</h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-green-600">
                            {{ $stats['approved_by_me'] }}
                        </div>
                        <div class="text-sm text-gray-600">Applications Approved</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-blue-600">
                            {{ $stats['cards_issued'] }}
                        </div>
                        <div class="text-sm text-gray-600">Digital Cards Issued</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-purple-600">
                            {{ $stats['today_processed'] }}
                        </div>
                        <div class="text-sm text-gray-600">Processed Today</div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Recent System Activity -->
        @if($stats['today_processed'] > 0)
        <div class="mt-8 bg-green-50 border border-green-200 rounded p-6">
            <div class="flex">
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mr-4">
                    <span class="text-2xl">🎉</span>
                </div>
                <div>
                    <h3 class="text-lg font-medium text-green-900">Great Work Today!</h3>
                    <p class="text-green-800 mt-1">
                        You've processed {{ $stats['today_processed'] }} applications today.
                        @if($stats['cards_issued'] > 0)
                            Total of {{ $stats['cards_issued'] }} digital cards have been issued through your approvals.
                        @endif
                        Keep up the excellent work!
                    </p>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
