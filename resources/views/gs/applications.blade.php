@extends('layouts.app')

@section('title', 'Applications Review - GS Dashboard')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-6xl mx-auto px-4">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Applications for Review</h1>
                    <p class="text-gray-600">Digital ID applications pending your verification</p>
                </div>
                <div class="space-x-3">
                    <a href="{{ route('gs.history') }}"
                       class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">
                        View History
                    </a>
                    <a href="{{ route('gs.dashboard') }}"
                       class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        Back to Dashboard
                    </a>
                </div>
            </div>
        </div>

        <!-- Applications List -->
        <div class="bg-white rounded shadow">
            <div class="px-6 py-4 border-b">
                <div class="flex justify-between items-center">
                    <h2 class="text-lg font-bold">
                        Pending Applications
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
                                                    {{ $application->user->email }}
                                                </p>
                                            </div>

                                            <div class="text-right">
                                                <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm">
                                                    ⏳ Awaiting Review
                                                </span>
                                            </div>
                                        </div>

                                        <div class="mt-2 grid grid-cols-2 gap-4 text-sm text-gray-600">
                                            <div>DOB: {{ $application->date_of_birth->format('M j, Y') }}</div>
                                            <div>Gender: {{ ucfirst($application->gender) }}</div>
                                            <div>Phone: {{ $application->phone }}</div>
                                            <div>Submitted: {{ $application->created_at->diffForHumans() }}</div>
                                        </div>

                                        <div class="mt-2">
                                            <p class="text-sm text-gray-600">
                                                <strong>Address:</strong> {{ Str::limit($application->address, 100) }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Actions -->
                                <div class="ml-6">
                                    <a href="{{ route('gs.review', $application) }}"
                                       class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                                        Review Now
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if($applications->hasPages())
                    <div class="px-6 py-4 border-t">
                        {{ $applications->links() }}
                    </div>
                @endif
            @else
                <!-- Empty State -->
                <div class="text-center py-12">
                    <div class="w-16 h-16 bg-gray-100 rounded-full mx-auto mb-4 flex items-center justify-center">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No applications to review</h3>
                    <p class="text-gray-600">All applications have been processed. Great work!</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
