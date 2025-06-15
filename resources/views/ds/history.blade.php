@extends('layouts.app')

@section('title', 'Processing History - DS Dashboard')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-6xl mx-auto px-4">
        <!-- Simple Header -->
        <div class="mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Processing History</h1>
                    <p class="text-gray-600">Complete record of your digital ID decisions and issuances</p>
                </div>
                <div class="space-x-3">
                    <a href="{{ route('ds.applications') }}"
                       class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">
                        Review Applications
                    </a>
                    <a href="{{ route('ds.dashboard') }}"
                       class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        Back to Dashboard
                    </a>
                </div>
            </div>
        </div>

        <!-- Simple Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <!-- Total Processed -->
            <div class="bg-white p-6 rounded shadow">
                <div class="flex items-center">
                    <div class="bg-gray-100 p-3 rounded">
                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-600">Total Processed</p>
                        <p class="text-2xl font-bold">{{ $applications->total() ?? 0 }}</p>
                    </div>
                </div>
            </div>

            <!-- Digital IDs Issued -->
            <div class="bg-white p-6 rounded shadow">
                <div class="flex items-center">
                    <div class="bg-green-100 p-3 rounded">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V4a2 2 0 114 0v2m-4 0a2 2 0 104 0m-4 0v2m0 0v5" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-600">Digital IDs Issued</p>
                        <p class="text-2xl font-bold">{{ $applications->where('status', 'ds_approved')->count() }}</p>
                    </div>
                </div>
            </div>

            <!-- This Month -->
            <div class="bg-white p-6 rounded shadow">
                <div class="flex items-center">
                    <div class="bg-blue-100 p-3 rounded">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a4 4 0 118 0v4m-4 7h.01M3 7h18a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V9a2 2 0 012-2z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-600">This Month</p>
                        <p class="text-2xl font-bold">{{ $applications->where('ds_verified_at', '>=', now()->startOfMonth())->count() }}</p>
                    </div>
                </div>
            </div>

            <!-- Approval Rate -->
            <div class="bg-white p-6 rounded shadow">
                <div class="flex items-center">
                    <div class="bg-purple-100 p-3 rounded">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-600">Approval Rate</p>
                        <p class="text-2xl font-bold">
                            @if($applications->count() > 0)
                                {{ round(($applications->where('status', 'ds_approved')->count() / $applications->count()) * 100) }}%
                            @else
                                N/A
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Simple Search -->
        <div class="bg-white rounded shadow mb-6">
            <div class="px-6 py-4">
                <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <!-- Search -->
                    <div>
                        <input type="text"
                               name="search"
                               value="{{ request('search') }}"
                               placeholder="Search applications..."
                               class="w-full border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <!-- Status Filter -->
                    <div>
                        <select name="status"
                                class="w-full border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500">
                            <option value="">All Decisions</option>
                            <option value="ds_approved" {{ request('status') === 'ds_approved' ? 'selected' : '' }}>Approved & Issued</option>
                            <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                    </div>

                    <!-- Period Filter -->
                    <div>
                        <select name="period"
                                class="w-full border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500">
                            <option value="">All Time</option>
                            <option value="today" {{ request('period') === 'today' ? 'selected' : '' }}>Today</option>
                            <option value="week" {{ request('period') === 'week' ? 'selected' : '' }}>This Week</option>
                            <option value="month" {{ request('period') === 'month' ? 'selected' : '' }}>This Month</option>
                            <option value="quarter" {{ request('period') === 'quarter' ? 'selected' : '' }}>This Quarter</option>
                        </select>
                    </div>

                    <!-- Search Button -->
                    <div>
                        <button type="submit"
                                class="w-full bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700">
                            Apply Filters
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- History List -->
        <div class="bg-white rounded shadow">
            <div class="px-6 py-4 border-b">
                <div class="flex justify-between items-center">
                    <h2 class="text-lg font-bold">
                        Processing History
                        @if($applications->total() > 0)
                            <span class="ml-2 bg-gray-100 text-gray-800 px-2 py-1 rounded-full text-sm">
                                {{ $applications->total() }}
                            </span>
                        @endif
                    </h2>
                    <div class="text-sm text-gray-500">
                        Showing {{ $applications->firstItem() ?? 0 }} to {{ $applications->lastItem() ?? 0 }} of {{ $applications->total() ?? 0 }}
                    </div>
                </div>
            </div>

            @if($applications && $applications->isNotEmpty())
                <div class="divide-y">
                    @foreach($applications as $application)
                        <div class="p-6 hover:bg-gray-50">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-4 flex-1">
                                    <!-- Applicant Initial Only -->
                                    <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center">
                                        <span class="text-gray-600 font-medium">
                                            {{ substr($application->first_name, 0, 1) }}{{ substr($application->last_name, 0, 1) }}
                                        </span>
                                    </div>

                                    <!-- Application Info -->
                                    <div class="flex-1">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <p class="font-medium text-gray-900">{{ $application->full_name }}</p>
                                                <p class="text-sm text-gray-600">
                                                    Application #{{ $application->application_number }}
                                                </p>
                                                <p class="text-xs text-gray-500">
                                                    Decision made {{ $application->ds_verified_at ? $application->ds_verified_at->diffForHumans() : 'recently' }}
                                                </p>
                                            </div>

                                            <div class="text-right">
                                                @switch($application->status)
                                                    @case('ds_approved')
                                                        <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm">
                                                            ✅ Digital ID Issued
                                                        </span>
                                                        @break
                                                    @case('rejected')
                                                        <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm">
                                                            ❌ Rejected by You
                                                        </span>
                                                        @break
                                                @endswitch
                                            </div>
                                        </div>

                                        <div class="mt-2 grid grid-cols-2 gap-4 text-sm text-gray-600">
                                            <div>Age: {{ $application->date_of_birth->age }} years</div>
                                            <div>Submitted: {{ $application->created_at->format('M j, Y') }}</div>
                                            <div>Phone: {{ $application->phone }}</div>
                                            <div>
                                                Processing Time:
                                                @if($application->ds_verified_at && $application->gs_verified_at)
                                                    {{ $application->gs_verified_at->diffInDays($application->ds_verified_at) }} days
                                                @else
                                                    -
                                                @endif
                                            </div>
                                        </div>

                                        @if($application->ds_comments)
                                            <div class="mt-2 p-3 bg-blue-50 rounded">
                                                <p class="text-sm text-blue-700">
                                                    <strong>Your comments:</strong> {{ Str::limit($application->ds_comments, 150) }}
                                                </p>
                                            </div>
                                        @endif

                                        @if($application->rejection_reason)
                                            <div class="mt-2 p-3 bg-red-50 rounded">
                                                <p class="text-sm text-red-700">
                                                    <strong>Rejection reason:</strong> {{ Str::limit($application->rejection_reason, 150) }}
                                                </p>
                                            </div>
                                        @endif

                                        @if($application->status === 'ds_approved' && $application->digitalCard)
                                            <div class="mt-2 text-sm text-green-600">
                                                🎉 Digital ID Card: {{ $application->digitalCard->card_number }} •
                                                Expires {{ $application->digitalCard->expiry_date->format('M Y') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Actions -->
                                <div class="ml-6 space-x-3">
                                    <a href="{{ route('ds.review', $application) }}"
                                       class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">
                                        View Details
                                    </a>

                                    @if($application->status === 'ds_approved' && $application->digitalCard)
                                        <a href="{{ route('digital-card.show', $application->digitalCard) }}"
                                           class="bg-green-600 text-white px-3 py-2 rounded hover:bg-green-700 text-sm">
                                            Digital Card
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if($applications->hasPages())
                    <div class="px-6 py-4 border-t">
                        {{ $applications->appends(request()->query())->links() }}
                    </div>
                @endif
            @else
                <!-- Empty State -->
                <div class="text-center py-12">
                    <div class="w-16 h-16 bg-gray-100 rounded-full mx-auto mb-4 flex items-center justify-center">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No processing history found</h3>
                    <p class="text-gray-600 mb-4">
                        @if(request('search') || request('status') || request('period'))
                            No decisions match your search. Try adjusting your filters.
                        @else
                            You haven't processed any applications yet. Start by reviewing pending applications!
                        @endif
                    </p>
                    @if(request('search') || request('status') || request('period'))
                        <a href="{{ route('ds.history') }}"
                           class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                            Clear Filters
                        </a>
                    @else
                        <a href="{{ route('ds.applications') }}"
                           class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                            Start Processing
                        </a>
                    @endif
                </div>
            @endif
        </div>

        <!-- Simple Performance Summary -->
        @if($applications->isNotEmpty())
        <div class="mt-8 bg-white rounded shadow">
            <div class="px-6 py-4 border-b">
                <h2 class="text-lg font-bold">Your Performance Summary</h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-center">
                    <div>
                        <div class="text-2xl font-bold text-green-600">
                            {{ $applications->where('status', 'ds_approved')->count() }}
                        </div>
                        <div class="text-sm text-gray-600">Digital IDs Issued</div>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-red-600">
                            {{ $applications->where('status', 'rejected')->count() }}
                        </div>
                        <div class="text-sm text-gray-600">Applications Rejected</div>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-blue-600">
                            @if($applications->count() > 0)
                                {{ round(($applications->where('status', 'ds_approved')->count() / $applications->count()) * 100) }}%
                            @else
                                N/A
                            @endif
                        </div>
                        <div class="text-sm text-gray-600">Approval Rate</div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Simple Quick Actions -->
        <div class="mt-8 bg-white rounded shadow">
            <div class="px-6 py-4 border-b">
                <h2 class="text-lg font-bold">Quick Actions</h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- Export History -->
                    <button onclick="alert('Export feature coming soon!')"
                            class="p-4 border rounded hover:bg-gray-50">
                        <div class="w-8 h-8 bg-green-100 rounded mb-3">
                            <svg class="w-8 h-8 p-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <h3 class="font-medium">Export History</h3>
                        <p class="text-sm text-gray-600">Download processing history</p>
                    </button>

                    <!-- Performance Report -->
                    <button onclick="alert('Performance report coming soon!')"
                            class="p-4 border rounded hover:bg-gray-50">
                        <div class="w-8 h-8 bg-purple-100 rounded mb-3">
                            <svg class="w-8 h-8 p-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>
                        <h3 class="font-medium">Performance Report</h3>
                        <p class="text-sm text-gray-600">Generate analytics</p>
                    </button>

                    <!-- Digital Card Registry -->
                    <button onclick="alert('Card registry coming soon!')"
                            class="p-4 border rounded hover:bg-gray-50">
                        <div class="w-8 h-8 bg-blue-100 rounded mb-3">
                            <svg class="w-8 h-8 p-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                        </div>
                        <h3 class="font-medium">Digital Card Registry</h3>
                        <p class="text-sm text-gray-600">View all issued cards</p>
                    </button>

                    <!-- Pending Reviews -->
                    <a href="{{ route('ds.applications') }}"
                       class="p-4 border rounded hover:bg-gray-50">
                        <div class="w-8 h-8 bg-orange-100 rounded mb-3">
                            <svg class="w-8 h-8 p-2 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="font-medium">Pending Reviews</h3>
                        <p class="text-sm text-gray-600">Continue processing</p>
                    </a>
                </div>
            </div>
        </div>

        <!-- Achievement Recognition (Simple Version) -->
        @if($applications->count() > 20)
        <div class="mt-8 bg-green-50 border border-green-200 rounded p-6">
            <div class="flex">
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mr-4">
                    <span class="text-2xl">🌟</span>
                </div>
                <div>
                    <h3 class="text-lg font-medium text-green-900">Outstanding Performance!</h3>
                    <p class="text-green-800 mt-1">
                        You've successfully processed {{ $applications->count() }} applications with
                        @if($applications->count() > 0)
                            {{ round(($applications->where('status', 'ds_approved')->count() / $applications->count()) * 100) }}% approval rate.
                        @endif
                        Keep up the excellent work in serving citizens!
                    </p>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
