@extends('layouts.app')

@section('title', 'Review History - GS Dashboard')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-6xl mx-auto px-4">
        <!-- Simple Header -->
        <div class="mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Review History</h1>
                    <p class="text-gray-600">Applications you have processed</p>
                </div>
                <div class="space-x-3">
                    <a href="{{ route('gs.applications') }}"
                       class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">
                        Review Applications
                    </a>
                    <a href="{{ route('gs.dashboard') }}"
                       class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        Back to Dashboard
                    </a>
                </div>
            </div>
        </div>

        <!-- Simple Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <!-- Total Reviewed -->
            <div class="bg-white p-6 rounded shadow">
                <div class="flex items-center">
                    <div class="bg-gray-100 p-3 rounded">
                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-600">Total Reviewed</p>
                        <p class="text-2xl font-bold">{{ $applications->total() ?? 0 }}</p>
                    </div>
                </div>
            </div>

            <!-- Approved -->
            <div class="bg-white p-6 rounded shadow">
                <div class="flex items-center">
                    <div class="bg-green-100 p-3 rounded">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-600">Approved</p>
                        <p class="text-2xl font-bold">{{ $applications->where('status', 'gs_approved')->count() + $applications->where('status', 'ds_approved')->count() }}</p>
                    </div>
                </div>
            </div>

            <!-- Rejected -->
            <div class="bg-white p-6 rounded shadow">
                <div class="flex items-center">
                    <div class="bg-red-100 p-3 rounded">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-600">Rejected</p>
                        <p class="text-2xl font-bold">{{ $applications->where('status', 'rejected')->count() }}</p>
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
                        <p class="text-2xl font-bold">{{ $applications->where('gs_verified_at', '>=', now()->startOfMonth())->count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Simple Search -->
        <div class="bg-white rounded shadow mb-6">
            <div class="px-6 py-4">
                <form method="GET" class="flex space-x-4">
                    <!-- Search -->
                    <div class="flex-1">
                        <input type="text"
                               name="search"
                               value="{{ request('search') }}"
                               placeholder="Search by name or application number..."
                               class="w-full border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <!-- Status Filter -->
                    <div>
                        <select name="status"
                                class="border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500">
                            <option value="">All Reviews</option>
                            <option value="gs_approved" {{ request('status') === 'gs_approved' ? 'selected' : '' }}>Approved</option>
                            <option value="ds_approved" {{ request('status') === 'ds_approved' ? 'selected' : '' }}>Fully Approved</option>
                            <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                    </div>

                    <!-- Search Button -->
                    <button type="submit"
                            class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                        Search
                    </button>
                </form>
            </div>
        </div>

        <!-- History List -->
        <div class="bg-white rounded shadow">
            <div class="px-6 py-4 border-b">
                <div class="flex justify-between items-center">
                    <h2 class="text-lg font-bold">
                        Review History
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

            @if($applications->isNotEmpty())
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
                                                    Reviewed {{ $application->gs_verified_at->diffForHumans() }}
                                                </p>
                                            </div>

                                            <div class="text-right">
                                                @switch($application->status)
                                                    @case('gs_approved')
                                                        <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm">
                                                            ✅ Approved by You
                                                        </span>
                                                        @break
                                                    @case('ds_approved')
                                                        <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">
                                                            🏆 Fully Approved
                                                        </span>
                                                        @break
                                                    @case('rejected')
                                                        <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm">
                                                            ❌ Rejected
                                                        </span>
                                                        @break
                                                @endswitch
                                            </div>
                                        </div>

                                        <div class="mt-2 grid grid-cols-2 gap-4 text-sm text-gray-600">
                                            <div>Submitted: {{ $application->created_at->format('M j, Y') }}</div>
                                            <div>
                                                Review Time:
                                                @if($application->gs_verified_at)
                                                    {{ $application->created_at->diffInHours($application->gs_verified_at) }}h
                                                @else
                                                    -
                                                @endif
                                            </div>
                                        </div>

                                        @if($application->gs_comments)
                                            <div class="mt-2 p-3 bg-gray-50 rounded">
                                                <p class="text-sm text-gray-700">
                                                    <strong>Your comments:</strong> {{ $application->gs_comments }}
                                                </p>
                                            </div>
                                        @endif

                                        @if($application->status === 'ds_approved' && $application->digitalCard)
                                            <div class="mt-2 text-sm text-green-600">
                                                🎉 Digital card issued: {{ $application->digitalCard->card_number }}
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Actions -->
                                <div class="ml-6">
                                    <a href="{{ route('gs.review', $application) }}"
                                       class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">
                                        View Details
                                    </a>
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No review history yet</h3>
                    <p class="text-gray-600 mb-4">
                        @if(request('search') || request('status'))
                            No reviews match your search. Try adjusting your filters.
                        @else
                            Start reviewing applications to see your history here.
                        @endif
                    </p>
                    @if(request('search') || request('status'))
                        <a href="{{ route('gs.history') }}"
                           class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                            Clear Filters
                        </a>
                    @else
                        <a href="{{ route('gs.applications') }}"
                           class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                            Start Reviewing
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
                            {{ $applications->whereIn('status', ['gs_approved', 'ds_approved'])->count() }}
                        </div>
                        <div class="text-sm text-gray-600">Applications Approved</div>
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
                                {{ round(($applications->whereIn('status', ['gs_approved', 'ds_approved'])->count() / $applications->count()) * 100) }}%
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
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <!-- Review Pending -->
                    <a href="{{ route('gs.applications') }}"
                       class="p-4 border rounded hover:bg-gray-50">
                        <div class="w-8 h-8 bg-blue-100 rounded mb-3">
                            <svg class="w-8 h-8 p-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                            </svg>
                        </div>
                        <h3 class="font-medium">Review Applications</h3>
                        <p class="text-sm text-gray-600">Continue reviewing pending applications</p>
                    </a>

                    <!-- Export History -->
                    <a href="#" onclick="alert('Export feature coming soon!')"
                       class="p-4 border rounded hover:bg-gray-50">
                        <div class="w-8 h-8 bg-green-100 rounded mb-3">
                            <svg class="w-8 h-8 p-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <h3 class="font-medium">Export History</h3>
                        <p class="text-sm text-gray-600">Download your review history</p>
                    </a>

                    <!-- Help -->
                    <a href="#" onclick="alert('Guidelines coming soon!')"
                       class="p-4 border rounded hover:bg-gray-50">
                        <div class="w-8 h-8 bg-purple-100 rounded mb-3">
                            <svg class="w-8 h-8 p-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="font-medium">Guidelines</h3>
                        <p class="text-sm text-gray-600">Review policies and procedures</p>
                    </a>
                </div>
            </div>
        </div>

        <!-- Celebration for Good Performance -->
        @if($applications->count() > 10 && $applications->whereIn('status', ['gs_approved', 'ds_approved'])->count() / $applications->count() > 0.9)
        <div class="mt-8 bg-green-50 border border-green-200 rounded p-6">
            <div class="flex">
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mr-4">
                    <span class="text-2xl">🌟</span>
                </div>
                <div>
                    <h3 class="text-lg font-medium text-green-900">Excellent Performance!</h3>
                    <p class="text-green-800 mt-1">
                        You've maintained a {{ round(($applications->whereIn('status', ['gs_approved', 'ds_approved'])->count() / $applications->count()) * 100) }}% approval rate with {{ $applications->count() }} reviews. Keep up the great work!
                    </p>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
