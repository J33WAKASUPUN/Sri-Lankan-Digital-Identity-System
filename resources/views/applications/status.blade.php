@extends('layouts.app')

@section('title', 'Application Status - Digital ID')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4">
        <!-- Simple Header -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Application Status</h1>
            <p class="text-gray-600 mt-2">Track your application progress</p>
            <p class="text-sm text-gray-500">Application #{{ $application->application_number }}</p>
        </div>

        <!-- Current Status Card -->
        <div class="bg-white rounded shadow mb-8">
            <div class="bg-red-600 text-white p-6 rounded-t">
                <div class="flex justify-between items-center">
                    <div>
                        <h2 class="text-xl font-bold">
                            Current Status:
                            @switch($application->status)
                                @case('pending')
                                    Pending Review
                                    @break
                                @case('gs_approved')
                                    GS Approved
                                    @break
                                @case('ds_approved')
                                    Approved ✅
                                    @break
                                @case('rejected')
                                    Rejected ❌
                                    @break
                            @endswitch
                        </h2>
                        <p class="mt-1">Submitted {{ $application->created_at->format('F j, Y') }}</p>
                    </div>
                    @if($application->status === 'ds_approved' && $application->digitalCard)
                        <a href="{{ route('applications.downloadCard', $application->id) }}"
                           class="bg-white text-red-600 px-4 py-2 rounded font-medium hover:bg-gray-100">
                            Download Card
                        </a>
                    @endif
                </div>
            </div>

            <!-- Progress Bar -->
            <div class="p-4 bg-gray-50">
                <div class="flex justify-between text-sm mb-2">
                    <span>Progress</span>
                    <span>
                        @switch($application->status)
                            @case('pending') Step 1 of 3 @break
                            @case('gs_approved') Step 2 of 3 @break
                            @case('ds_approved') Complete @break
                            @case('rejected') Rejected @break
                        @endswitch
                    </span>
                </div>
                <div class="w-full bg-gray-200 rounded h-2">
                    <div class="bg-red-600 h-2 rounded" style="width:
                        @switch($application->status)
                            @case('pending') 33% @break
                            @case('gs_approved') 66% @break
                            @case('ds_approved') 100% @break
                            @case('rejected') 0% @break
                        @endswitch
                    "></div>
                </div>
            </div>
        </div>

        <!-- Timeline -->
        <div class="bg-white rounded shadow">
            <div class="p-6 border-b">
                <h3 class="text-lg font-bold">Application Timeline</h3>
            </div>
            <div class="p-6">
                <div class="space-y-6">
                    <!-- Step 1: Submitted -->
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h4 class="font-medium">Application Submitted ✅</h4>
                            <p class="text-sm text-gray-600">{{ $application->created_at->format('F j, Y \a\t g:i A') }}</p>
                            <p class="text-sm text-gray-500">Your application has been received</p>
                        </div>
                    </div>

                    <!-- Step 2: GS Review -->
                    <div class="flex">
                        <div class="flex-shrink-0">
                            @if($application->gs_verified_at)
                                <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            @elseif($application->status === 'pending')
                                <div class="w-8 h-8 bg-yellow-500 rounded-full flex items-center justify-center animate-pulse">
                                    <span class="text-white text-sm">⏳</span>
                                </div>
                            @elseif($application->status === 'rejected')
                                <div class="w-8 h-8 bg-red-500 rounded-full flex items-center justify-center">
                                    <span class="text-white text-sm">❌</span>
                                </div>
                            @else
                                <div class="w-8 h-8 bg-gray-400 rounded-full"></div>
                            @endif
                        </div>
                        <div class="ml-4">
                            <h4 class="font-medium">
                                Grama Sevaka Review
                                @if($application->gs_verified_at) ✅
                                @elseif($application->status === 'pending') 🔄
                                @elseif($application->status === 'rejected') ❌
                                @endif
                            </h4>
                            @if($application->gs_verified_at)
                                <p class="text-sm text-green-600">Approved on {{ $application->gs_verified_at->format('F j, Y') }}</p>
                                @if($application->gs_comments)
                                    <div class="mt-2 p-3 bg-blue-50 rounded">
                                        <p class="text-sm text-blue-800"><strong>GS Comments:</strong> {{ $application->gs_comments }}</p>
                                    </div>
                                @endif
                            @elseif($application->status === 'pending')
                                <p class="text-sm text-yellow-600">Currently under review</p>
                                <p class="text-sm text-gray-500">Expected: 3-5 business days</p>
                            @elseif($application->status === 'rejected')
                                <p class="text-sm text-red-600">Application rejected at this stage</p>
                                @if($application->gs_comments)
                                    <div class="mt-2 p-3 bg-red-50 rounded">
                                        <p class="text-sm text-red-800"><strong>Reason:</strong> {{ $application->gs_comments }}</p>
                                    </div>
                                @endif
                            @else
                                <p class="text-sm text-gray-500">Waiting for review</p>
                            @endif
                        </div>
                    </div>

                    <!-- Step 3: DS Review -->
                    <div class="flex">
                        <div class="flex-shrink-0">
                            @if($application->ds_verified_at)
                                <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            @elseif($application->status === 'gs_approved')
                                <div class="w-8 h-8 bg-yellow-500 rounded-full flex items-center justify-center animate-pulse">
                                    <span class="text-white text-sm">⏳</span>
                                </div>
                            @else
                                <div class="w-8 h-8 bg-gray-400 rounded-full"></div>
                            @endif
                        </div>
                        <div class="ml-4">
                            <h4 class="font-medium">
                                Divisional Secretariat Review
                                @if($application->ds_verified_at) ✅
                                @elseif($application->status === 'gs_approved') 🔄
                                @endif
                            </h4>
                            @if($application->ds_verified_at)
                                <p class="text-sm text-green-600">Approved on {{ $application->ds_verified_at->format('F j, Y') }}</p>
                                @if($application->ds_comments)
                                    <div class="mt-2 p-3 bg-green-50 rounded">
                                        <p class="text-sm text-green-800"><strong>DS Comments:</strong> {{ $application->ds_comments }}</p>
                                    </div>
                                @endif
                            @elseif($application->status === 'gs_approved')
                                <p class="text-sm text-yellow-600">Currently under final review</p>
                                <p class="text-sm text-gray-500">Expected: 5-7 business days</p>
                            @else
                                <p class="text-sm text-gray-500">Waiting for Grama Sevaka approval</p>
                            @endif
                        </div>
                    </div>

                    <!-- Step 4: Card Ready -->
                    @if($application->status === 'ds_approved')
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                                    <span class="text-white text-sm">🎉</span>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h4 class="font-medium">Digital ID Card Ready! 🎉</h4>
                                <p class="text-sm text-green-600">Your digital card is ready for download</p>
                                @if($application->digitalCard)
                                    <div class="mt-2 p-3 bg-green-50 rounded">
                                        <p class="text-sm text-green-800">
                                            <strong>Card Number:</strong> {{ $application->digitalCard->card_number }}<br>
                                            <strong>Valid Until:</strong> {{ $application->digitalCard->expiry_date->format('F j, Y') }}
                                        </p>
                                    </div>
                                @endif
                                <div class="mt-3">
                                    <a href="{{ route('applications.downloadCard', $application->id) }}"
                                       class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                                        Download Digital Card
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Status Info Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
            <!-- Processing Time -->
            <div class="bg-white p-6 rounded shadow">
                <h4 class="font-medium text-gray-900 mb-2">Processing Time</h4>
                <p class="text-2xl font-bold">
                    @if($application->status === 'ds_approved')
                        {{ $application->created_at->diffInDays($application->ds_verified_at) }} days
                    @else
                        {{ $application->created_at->diffInDays(now()) }} days
                    @endif
                </p>
                <p class="text-sm text-gray-500">
                    @if($application->status === 'ds_approved')
                        Total time taken
                    @else
                        So far (Expected: 7-14 days)
                    @endif
                </p>
            </div>

            <!-- Current Stage -->
            <div class="bg-white p-6 rounded shadow">
                <h4 class="font-medium text-gray-900 mb-2">Current Stage</h4>
                <p class="text-2xl font-bold">
                    @switch($application->status)
                        @case('pending') GS Review @break
                        @case('gs_approved') DS Review @break
                        @case('ds_approved') Complete @break
                        @case('rejected') Rejected @break
                    @endswitch
                </p>
                <p class="text-sm text-gray-500">
                    @switch($application->status)
                        @case('pending') Awaiting local verification @break
                        @case('gs_approved') Awaiting final approval @break
                        @case('ds_approved') Application approved @break
                        @case('rejected') See details above @break
                    @endswitch
                </p>
            </div>

            <!-- Next Steps -->
            <div class="bg-white p-6 rounded shadow">
                <h4 class="font-medium text-gray-900 mb-2">Next Steps</h4>
                <p class="text-2xl font-bold">
                    @switch($application->status)
                        @case('pending') Wait @break
                        @case('gs_approved') Wait @break
                        @case('ds_approved') Download @break
                        @case('rejected') Reapply @break
                    @endswitch
                </p>
                <p class="text-sm text-gray-500">
                    @switch($application->status)
                        @case('pending') No action required @break
                        @case('gs_approved') No action required @break
                        @case('ds_approved') Your card is ready! @break
                        @case('rejected') Contact support if needed @break
                    @endswitch
                </p>
            </div>
        </div>

        <!-- Actions -->
        <div class="text-center mt-8 space-x-4">
            <a href="{{ route('applications.show', $application->id) }}"
               class="bg-gray-600 text-white px-6 py-3 rounded hover:bg-gray-700">
                View Full Details
            </a>
            <a href="{{ route('applicant.dashboard') }}"
               class="bg-red-600 text-white px-6 py-3 rounded hover:bg-red-700">
                Back to Dashboard
            </a>
        </div>

        <!-- Help Section -->
        <div class="mt-8 bg-blue-50 border border-blue-200 rounded p-6">
            <h3 class="font-medium text-blue-900 mb-2">Need Help?</h3>
            <div class="text-sm text-blue-800">
                <p>Contact our support team if you have questions:</p>
                <ul class="mt-2 space-y-1">
                    <li>📧 Email: support@digitalid.gov.lk</li>
                    <li>📞 Phone: +94 11 123 4567</li>
                    <li>🕒 Hours: Monday - Friday, 8:00 AM - 5:00 PM</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
