@extends('layouts.app')

@section('title', 'Final Approvals - DS Dashboard')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-6xl mx-auto px-4">
        <!-- Simple Header -->
        <div class="mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Applications for Final Approval</h1>
                    <p class="text-gray-600">GS approved applications awaiting your final decision</p>
                </div>
                <div class="space-x-3">
                    <a href="{{ route('ds.history') }}"
                       class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">
                        View History
                    </a>
                    <a href="{{ route('ds.dashboard') }}"
                       class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        Back to Dashboard
                    </a>
                </div>
            </div>
        </div>

        <!-- Simple Stats Summary -->
        <div class="bg-white rounded shadow mb-6">
            <div class="px-6 py-4 border-l-4 border-blue-500">
                <div class="flex justify-between items-center">
                    <div class="flex space-x-8">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-blue-600">{{ $applications->total() ?? 0 }}</div>
                            <div class="text-sm text-gray-600">Awaiting Decision</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-green-600">{{ $todayApproved ?? 0 }}</div>
                            <div class="text-sm text-gray-600">Approved Today</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-purple-600">{{ $avgProcessingTime ?? '1.8' }} days</div>
                            <div class="text-sm text-gray-600">Avg. Processing</div>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="text-sm text-gray-500">Target Response</div>
                        <div class="text-lg font-semibold text-blue-600">< 3 days</div>
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

                    <!-- Priority Filter -->
                    <div>
                        <select name="priority"
                                class="border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500">
                            <option value="">All Priorities</option>
                            <option value="urgent" {{ request('priority') === 'urgent' ? 'selected' : '' }}>Urgent (>5 days)</option>
                            <option value="normal" {{ request('priority') === 'normal' ? 'selected' : '' }}>Normal</option>
                            <option value="recent" {{ request('priority') === 'recent' ? 'selected' : '' }}>Recent (Today)</option>
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

        <!-- Applications List -->
        <div class="bg-white rounded shadow">
            <div class="px-6 py-4 border-b">
                <div class="flex justify-between items-center">
                    <h2 class="text-lg font-bold">
                        Pending Final Approval
                        @if($applications->total() > 0)
                            <span class="ml-2 bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-sm">
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
                                    <!-- Priority Indicator + Initial -->
                                    <div class="flex items-center space-x-3">
                                        @php
                                            $daysSinceGSApproval = $application->gs_verified_at ? $application->gs_verified_at->diffInDays(now()) : 0;
                                            $isUrgent = $daysSinceGSApproval > 5;
                                            $isRecent = $application->gs_verified_at?->isToday() ?? false;
                                        @endphp

                                        <!-- Priority Indicator -->
                                        <div class="flex flex-col items-center">
                                            @if($isUrgent)
                                                <div class="h-3 w-3 bg-red-500 rounded-full animate-pulse"></div>
                                            @elseif($isRecent)
                                                <div class="h-3 w-3 bg-green-500 rounded-full"></div>
                                            @else
                                                <div class="h-3 w-3 bg-yellow-500 rounded-full"></div>
                                            @endif
                                        </div>

                                        <!-- Applicant Initial Only -->
                                        <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center">
                                            <span class="text-gray-600 font-medium">
                                                {{ substr($application->first_name, 0, 1) }}{{ substr($application->last_name, 0, 1) }}
                                            </span>
                                        </div>
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
                                                    {{ $application->user->email }}
                                                </p>
                                            </div>

                                            <div class="text-right">
                                                @if($isUrgent)
                                                    <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm">
                                                        🚨 Urgent - {{ $daysSinceGSApproval }} days
                                                    </span>
                                                @elseif($isRecent)
                                                    <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm">
                                                        ✨ New Today
                                                    </span>
                                                @else
                                                    <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm">
                                                        ⏳ {{ $daysSinceGSApproval }} days pending
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="mt-2 grid grid-cols-2 gap-4 text-sm text-gray-600">
                                            <div>Age: {{ $application->date_of_birth->age }} years</div>
                                            <div>Gender: {{ ucfirst($application->gender) }}</div>
                                            <div>Phone: {{ $application->phone }}</div>
                                            <div>GS Approved: {{ $application->gs_verified_at ? $application->gs_verified_at->format('M j, Y') : 'Unknown' }}</div>
                                        </div>

                                        <div class="mt-2">
                                            <p class="text-sm text-gray-600">
                                                <strong>Address:</strong> {{ Str::limit($application->address, 100) }}
                                            </p>
                                        </div>

                                        @if($application->gs_comments)
                                            <div class="mt-2 p-3 bg-blue-50 rounded">
                                                <p class="text-sm text-blue-700">
                                                    <strong>GS Comments:</strong> {{ Str::limit($application->gs_comments, 150) }}
                                                </p>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Actions -->
                                <div class="ml-6 space-x-3">
                                    <a href="{{ route('ds.review', $application) }}"
                                       class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                                        Final Review
                                    </a>

                                    <!-- Quick Approve for Simple Cases -->
                                    @if(!$isUrgent && $application->gs_comments)
                                        <form method="POST" action="{{ route('ds.approve', $application) }}" class="inline">
                                            @csrf
                                            <button type="submit"
                                                    onclick="return confirm('Are you sure you want to approve this application and issue a digital ID card?')"
                                                    class="bg-green-600 text-white px-3 py-2 rounded hover:bg-green-700 text-sm">
                                                ✓ Quick Approve
                                            </button>
                                        </form>
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
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No applications for final approval</h3>
                    <p class="text-gray-600 mb-4">
                        @if(request('search') || request('priority'))
                            No applications match your search. Try adjusting your filters.
                        @else
                            All applications have been processed. Great work!
                        @endif
                    </p>
                    @if(request('search') || request('priority'))
                        <a href="{{ route('ds.applications') }}"
                           class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                            Clear Filters
                        </a>
                    @else
                        <a href="{{ route('ds.history') }}"
                           class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                            View History
                        </a>
                    @endif
                </div>
            @endif
        </div>

        <!-- Simple Bulk Actions -->
        @if($applications && $applications->isNotEmpty())
        <div class="mt-6 bg-white rounded shadow p-6">
            <h3 class="text-lg font-bold mb-4">Quick Actions</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <button onclick="alert('Feature coming soon!')"
                        class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">
                    📋 Select Simple Cases
                </button>

                <button onclick="alert('Bulk approval coming soon!')"
                        class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                    ✅ Bulk Approve
                </button>

                <button onclick="alert('Export coming soon!')"
                        class="bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700">
                    📊 Export Report
                </button>
            </div>
            <p class="mt-2 text-sm text-gray-500">
                Bulk actions help you process multiple applications efficiently.
            </p>
        </div>
        @endif
    </div>
</div>
@endsection
