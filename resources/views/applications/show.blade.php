@extends('layouts.app')

@section('title', 'Application Details - Digital ID')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex justify-between items-start">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">
                        Application #{{ $application->application_number }}
                    </h1>
                    <p class="text-gray-600 mt-1">
                        Submitted {{ $application->created_at->format('F j, Y') }} • {{ $application->created_at->diffForHumans() }}
                    </p>
                </div>
                <div class="space-x-3">
                    <a href="{{ route('applications.status', $application->id) }}"
                       class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">
                        Track Status
                    </a>
                    @if($application->status === 'ds_approved' && $application->digitalCard)
                        <a href="{{ route('applications.downloadCard', $application->id) }}"
                           class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                            Download Card
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Status Badge -->
        <div class="mb-6">
            @switch($application->status)
                @case('pending')
                    <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm font-medium">
                        ⏳ Pending Review
                    </span>
                    @break
                @case('gs_approved')
                    <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium">
                        📋 Grama Sevaka Approved
                    </span>
                    @break
                @case('ds_approved')
                    <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium">
                        ✅ Approved - Card Ready
                    </span>
                    @break
                @case('rejected')
                    <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm font-medium">
                        ❌ Rejected
                    </span>
                    @break
            @endswitch
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Personal Information -->
                <div class="bg-white rounded shadow">
                    <div class="px-6 py-4 border-b">
                        <h3 class="text-lg font-bold">Personal Information</h3>
                    </div>
                    <div class="px-6 py-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-600">Full Name</p>
                                <p class="font-medium">{{ $application->full_name }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Date of Birth</p>
                                <p class="font-medium">{{ $application->date_of_birth->format('F j, Y') }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Gender</p>
                                <p class="font-medium">{{ ucfirst($application->gender) }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Nationality</p>
                                <p class="font-medium">{{ $application->nationality }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Phone Number</p>
                                <p class="font-medium">{{ $application->phone }}</p>
                            </div>
                            <div class="sm:col-span-2">
                                <p class="text-sm text-gray-600">Address</p>
                                <p class="font-medium">{{ $application->address }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Documents - IMPROVED LAYOUT! -->
                <div class="bg-white rounded shadow">
                    <div class="px-6 py-4 border-b">
                        <h3 class="text-lg font-bold">Submitted Documents</h3>
                    </div>
                    <div class="px-6 py-4">
                        <div class="space-y-4">
                            <!-- Birth Certificate -->
                            <div class="border rounded-lg p-4 hover:bg-gray-50 transition-colors">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-4 flex-1 min-w-0">
                                        <!-- Document Icon -->
                                        <div class="flex-shrink-0">
                                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                            </div>
                                        </div>
                                        <!-- Document Info -->
                                        <div class="flex-1 min-w-0">
                                            <h4 class="font-medium text-gray-900">Birth Certificate</h4>
                                            <p class="text-sm text-gray-500 truncate" title="{{ basename($application->birth_certificate_path) }}">
                                                {{ Str::limit(basename($application->birth_certificate_path), 40) }}
                                            </p>
                                            <div class="flex items-center mt-1">
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-green-100 text-green-800">
                                                    ✓ Uploaded
                                                </span>
                                                <span class="ml-2 text-xs text-gray-500">
                                                    {{ strtoupper(pathinfo($application->birth_certificate_path, PATHINFO_EXTENSION)) }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Action Buttons -->
                                    <div class="flex space-x-2 ml-4">
                                        <a href="{{ asset('storage/' . $application->birth_certificate_path) }}"
                                           target="_blank"
                                           class="inline-flex items-center px-3 py-2 border border-gray-300 rounded text-sm text-gray-700 bg-white hover:bg-gray-50">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            View
                                        </a>
                                        <a href="{{ asset('storage/' . $application->birth_certificate_path) }}"
                                           download
                                           class="inline-flex items-center px-3 py-2 border border-blue-300 rounded text-sm text-blue-700 bg-blue-50 hover:bg-blue-100">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            Download
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Photo -->
                            <div class="border rounded-lg p-4 hover:bg-gray-50 transition-colors">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-4 flex-1 min-w-0">
                                        <!-- Document Icon -->
                                        <div class="flex-shrink-0">
                                            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        </div>
                                        <!-- Document Info -->
                                        <div class="flex-1 min-w-0">
                                            <h4 class="font-medium text-gray-900">Passport Photo</h4>
                                            <p class="text-sm text-gray-500 truncate" title="{{ basename($application->photo_path) }}">
                                                {{ Str::limit(basename($application->photo_path), 40) }}
                                            </p>
                                            <div class="flex items-center mt-1">
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-green-100 text-green-800">
                                                    ✓ Uploaded
                                                </span>
                                                <span class="ml-2 text-xs text-gray-500">
                                                    {{ strtoupper(pathinfo($application->photo_path, PATHINFO_EXTENSION)) }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Action Buttons -->
                                    <div class="flex space-x-2 ml-4">
                                        <a href="{{ asset('storage/' . $application->photo_path) }}"
                                           target="_blank"
                                           class="inline-flex items-center px-3 py-2 border border-gray-300 rounded text-sm text-gray-700 bg-white hover:bg-gray-50">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            View
                                        </a>
                                        <a href="{{ asset('storage/' . $application->photo_path) }}"
                                           download
                                           class="inline-flex items-center px-3 py-2 border border-green-300 rounded text-sm text-green-700 bg-green-50 hover:bg-green-100">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            Download
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Comments -->
                @if($application->gs_comments || $application->ds_comments)
                <div class="bg-white rounded shadow">
                    <div class="px-6 py-4 border-b">
                        <h3 class="text-lg font-bold">Review Comments</h3>
                    </div>
                    <div class="px-6 py-4 space-y-4">
                        @if($application->gs_comments)
                            <div class="border-l-4 border-blue-400 pl-4 bg-blue-50 p-4 rounded-r">
                                <h4 class="font-medium text-blue-900 flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    Grama Sevaka Comments
                                </h4>
                                <p class="text-blue-800 mt-2">{{ $application->gs_comments }}</p>
                                @if($application->gs_verified_at)
                                    <p class="text-xs text-blue-600 mt-2">Reviewed on {{ $application->gs_verified_at->format('F j, Y') }}</p>
                                @endif
                            </div>
                        @endif

                        @if($application->ds_comments)
                            <div class="border-l-4 border-green-400 pl-4 bg-green-50 p-4 rounded-r">
                                <h4 class="font-medium text-green-900 flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                    Divisional Secretariat Comments
                                </h4>
                                <p class="text-green-800 mt-2">{{ $application->ds_comments }}</p>
                                @if($application->ds_verified_at)
                                    <p class="text-xs text-green-600 mt-2">Reviewed on {{ $application->ds_verified_at->format('F j, Y') }}</p>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Quick Timeline -->
                <div class="bg-white rounded shadow">
                    <div class="px-6 py-4 border-b">
                        <h3 class="text-lg font-bold">Timeline</h3>
                    </div>
                    <div class="px-6 py-4">
                        <div class="space-y-4">
                            <!-- Submitted -->
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center mr-3">
                                    <span class="text-white text-sm">✓</span>
                                </div>
                                <div>
                                    <p class="font-medium text-sm">Submitted</p>
                                    <p class="text-xs text-gray-600">{{ $application->created_at->format('M j, Y') }}</p>
                                </div>
                            </div>

                            <!-- GS Review -->
                            <div class="flex items-center">
                                @if($application->gs_verified_at)
                                    <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center mr-3">
                                        <span class="text-white text-sm">✓</span>
                                    </div>
                                @elseif($application->status === 'pending')
                                    <div class="w-8 h-8 bg-yellow-500 rounded-full flex items-center justify-center mr-3 animate-pulse">
                                        <span class="text-white text-sm">⏳</span>
                                    </div>
                                @else
                                    <div class="w-8 h-8 bg-gray-400 rounded-full mr-3"></div>
                                @endif
                                <div>
                                    <p class="font-medium text-sm">GS Review</p>
                                    @if($application->gs_verified_at)
                                        <p class="text-xs text-gray-600">{{ $application->gs_verified_at->format('M j, Y') }}</p>
                                    @elseif($application->status === 'pending')
                                        <p class="text-xs text-yellow-600">In progress...</p>
                                    @else
                                        <p class="text-xs text-gray-600">Pending</p>
                                    @endif
                                </div>
                            </div>

                            <!-- DS Review -->
                            <div class="flex items-center">
                                @if($application->ds_verified_at)
                                    <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center mr-3">
                                        <span class="text-white text-sm">✓</span>
                                    </div>
                                @elseif($application->status === 'gs_approved')
                                    <div class="w-8 h-8 bg-yellow-500 rounded-full flex items-center justify-center mr-3 animate-pulse">
                                        <span class="text-white text-sm">⏳</span>
                                    </div>
                                @else
                                    <div class="w-8 h-8 bg-gray-400 rounded-full mr-3"></div>
                                @endif
                                <div>
                                    <p class="font-medium text-sm">DS Review</p>
                                    @if($application->ds_verified_at)
                                        <p class="text-xs text-gray-600">{{ $application->ds_verified_at->format('M j, Y') }}</p>
                                    @elseif($application->status === 'gs_approved')
                                        <p class="text-xs text-yellow-600">In progress...</p>
                                    @else
                                        <p class="text-xs text-gray-600">Pending</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Digital Card -->
                @if($application->digitalCard)
                <div class="bg-white rounded shadow">
                    <div class="px-6 py-4 border-b">
                        <h3 class="text-lg font-bold">Digital ID Card</h3>
                    </div>
                    <div class="px-6 py-4">
                        <div class="space-y-3">
                            <div>
                                <p class="text-sm text-gray-600">Card Number</p>
                                <p class="font-mono text-sm bg-gray-100 p-2 rounded">{{ $application->digitalCard->card_number }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Issue Date</p>
                                <p class="text-sm">{{ $application->digitalCard->issue_date->format('F j, Y') }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Expiry Date</p>
                                <p class="text-sm">{{ $application->digitalCard->expiry_date->format('F j, Y') }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Status</p>
                                <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs font-medium">✓ Active</span>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('applications.downloadCard', $application->id) }}"
                               class="w-full bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 text-center block font-medium">
                                📥 Download Digital Card
                            </a>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Actions -->
                <div class="bg-white rounded shadow">
                    <div class="px-6 py-4 border-b">
                        <h3 class="text-lg font-bold">Actions</h3>
                    </div>
                    <div class="px-6 py-4 space-y-3">
                        <a href="{{ route('applications.status', $application->id) }}"
                           class="w-full bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700 text-center block">
                            📊 View Status Details
                        </a>
                        <a href="{{ route('applicant.dashboard') }}"
                           class="w-full bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-center block">
                            🏠 Back to Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
