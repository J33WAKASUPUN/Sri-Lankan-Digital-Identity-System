@extends('layouts.app')

@section('title', 'Review Application - GS Dashboard')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-6xl mx-auto px-4">
        <!-- Simple Header -->
        <div class="mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">
                        Review Application #{{ $application->application_number }}
                    </h1>
                    <p class="text-gray-600">Submitted {{ $application->created_at->diffForHumans() }}</p>
                </div>
                <a href="{{ route('gs.applications') }}"
                   class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">
                    Back to Applications
                </a>
            </div>
        </div>

        <!-- Status Badge -->
        <div class="mb-6">
            @switch($application->status)
                @case('pending')
                    <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm font-medium">
                        ⏳ Pending Your Review
                    </span>
                    @break
                @case('gs_approved')
                    <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium">
                        ✅ Approved by You
                    </span>
                    @break
                @case('ds_approved')
                    <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium">
                        🏆 Fully Approved
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
                        <div class="flex items-start space-x-6">
                            <!-- Photo -->
                            <div class="flex-shrink-0">
                                @if($application->photo_path)
                                    <img class="h-24 w-24 rounded-lg object-cover border-2 border-gray-200"
                                         src="{{ asset('storage/' . $application->photo_path) }}"
                                         alt="{{ $application->full_name }}">
                                @else
                                    <div class="h-24 w-24 bg-gray-200 rounded-lg flex items-center justify-center border-2 border-gray-200">
                                        <span class="text-gray-600 font-medium text-2xl">
                                            {{ substr($application->first_name, 0, 1) }}{{ substr($application->last_name, 0, 1) }}
                                        </span>
                                    </div>
                                @endif
                            </div>

                            <!-- Details -->
                            <div class="flex-1">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-sm text-gray-600">Full Name</p>
                                        <p class="font-medium">{{ $application->full_name }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Date of Birth</p>
                                        <p class="font-medium">{{ $application->date_of_birth->format('F j, Y') }} ({{ $application->date_of_birth->age }} years)</p>
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
                                    <div>
                                        <p class="text-sm text-gray-600">Email</p>
                                        <p class="font-medium">{{ $application->user->email }}</p>
                                    </div>
                                    <div class="sm:col-span-2">
                                        <p class="text-sm text-gray-600">Address</p>
                                        <p class="font-medium">{{ $application->address }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Documents -->
                <div class="bg-white rounded shadow">
                    <div class="px-6 py-4 border-b">
                        <h3 class="text-lg font-bold">Submitted Documents</h3>
                    </div>
                    <div class="px-6 py-4">
                        <div class="space-y-4">
                            <!-- Birth Certificate -->
                            <div class="border rounded-lg p-4">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-4">
                                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <h4 class="font-medium">Birth Certificate</h4>
                                            <p class="text-sm text-gray-500">{{ Str::limit(basename($application->birth_certificate_path), 40) }}</p>
                                        </div>
                                    </div>
                                    <a href="{{ asset('storage/' . $application->birth_certificate_path) }}"
                                       target="_blank"
                                       class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                                        View Document
                                    </a>
                                </div>
                            </div>

                            <!-- Passport Photo -->
                            <div class="border rounded-lg p-4">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-4">
                                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <h4 class="font-medium">Passport Photo</h4>
                                            <p class="text-sm text-gray-500">{{ Str::limit(basename($application->photo_path), 40) }}</p>
                                        </div>
                                    </div>
                                    <a href="{{ asset('storage/' . $application->photo_path) }}"
                                       target="_blank"
                                       class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                                        View Photo
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Review Actions -->
                @if($application->status === 'pending')
                <div class="bg-white rounded shadow">
                    <div class="px-6 py-4 border-b">
                        <h3 class="text-lg font-bold">Review Decision</h3>
                        <p class="text-gray-600">Make your verification decision for this application</p>
                    </div>
                    <div class="px-6 py-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Approve Form -->
                            <form method="POST" action="{{ route('gs.approve', $application) }}" class="space-y-4">
                                @csrf
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Comments (Optional)
                                    </label>
                                    <textarea name="comments"
                                              rows="4"
                                              class="w-full border-gray-300 rounded focus:ring-green-500 focus:border-green-500"
                                              placeholder="Add any comments about your approval..."></textarea>
                                </div>
                                <button type="submit"
                                        onclick="return confirm('Are you sure you want to approve this application?')"
                                        class="w-full bg-green-600 text-white py-3 px-4 rounded hover:bg-green-700 font-medium">
                                    ✅ Approve Application
                                </button>
                            </form>

                            <!-- Reject Form -->
                            <form method="POST" action="{{ route('gs.reject', $application) }}" class="space-y-4">
                                @csrf
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Reason for Rejection *
                                    </label>
                                    <textarea name="comments"
                                              rows="4"
                                              required
                                              class="w-full border-gray-300 rounded focus:ring-red-500 focus:border-red-500"
                                              placeholder="Please provide a detailed reason..."></textarea>
                                </div>
                                <button type="submit"
                                        onclick="return confirm('Are you sure you want to reject this application? This cannot be undone.')"
                                        class="w-full bg-red-600 text-white py-3 px-4 rounded hover:bg-red-700 font-medium">
                                    ❌ Reject Application
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Previous Comments -->
                @if($application->gs_comments || $application->rejection_reason)
                <div class="bg-white rounded shadow">
                    <div class="px-6 py-4 border-b">
                        <h3 class="text-lg font-bold">Your Review Comments</h3>
                    </div>
                    <div class="px-6 py-4 space-y-4">
                        @if($application->gs_comments)
                            <div class="border-l-4 border-green-400 pl-4 bg-green-50 p-4 rounded-r">
                                <h4 class="font-medium text-green-900">Approval Comments</h4>
                                <p class="text-green-800 mt-1">{{ $application->gs_comments }}</p>
                                @if($application->gs_verified_at)
                                    <p class="text-xs text-green-600 mt-2">
                                        Approved on {{ $application->gs_verified_at->format('F j, Y \a\t g:i A') }}
                                    </p>
                                @endif
                            </div>
                        @endif

                        @if($application->rejection_reason)
                            <div class="border-l-4 border-red-400 pl-4 bg-red-50 p-4 rounded-r">
                                <h4 class="font-medium text-red-900">Rejection Reason</h4>
                                <p class="text-red-800 mt-1">{{ $application->rejection_reason }}</p>
                            </div>
                        @endif
                    </div>
                </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Application Info -->
                <div class="bg-white rounded shadow">
                    <div class="px-6 py-4 border-b">
                        <h3 class="text-lg font-bold">Application Info</h3>
                    </div>
                    <div class="px-6 py-4 space-y-3">
                        <div>
                            <p class="text-sm text-gray-600">Application Number</p>
                            <p class="font-mono text-sm bg-gray-100 p-2 rounded">{{ $application->application_number }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Submitted</p>
                            <p class="text-sm">{{ $application->created_at->format('F j, Y \a\t g:i A') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Applicant Email</p>
                            <p class="text-sm">{{ $application->user->email }}</p>
                        </div>
                        @if($application->gs_verified_at)
                        <div>
                            <p class="text-sm text-gray-600">Review Time</p>
                            <p class="text-sm">{{ $application->created_at->diffInHours($application->gs_verified_at) }} hours</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Simple Timeline -->
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
                                    <p class="font-medium text-sm">Your Review</p>
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
                                @else
                                    <div class="w-8 h-8 bg-gray-400 rounded-full mr-3"></div>
                                @endif
                                <div>
                                    <p class="font-medium text-sm">Final Review</p>
                                    @if($application->ds_verified_at)
                                        <p class="text-xs text-gray-600">{{ $application->ds_verified_at->format('M j, Y') }}</p>
                                    @else
                                        <p class="text-xs text-gray-600">Pending</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Review Guidelines -->
                <div class="bg-white rounded shadow">
                    <div class="px-6 py-4 border-b">
                        <h3 class="text-lg font-bold">Review Guidelines</h3>
                    </div>
                    <div class="px-6 py-4">
                        <div class="space-y-3 text-sm">
                            <div class="flex items-start">
                                <span class="text-green-500 mr-2">✓</span>
                                <p class="text-gray-700">Verify personal information matches birth certificate</p>
                            </div>
                            <div class="flex items-start">
                                <span class="text-green-500 mr-2">✓</span>
                                <p class="text-gray-700">Check photo quality and clarity</p>
                            </div>
                            <div class="flex items-start">
                                <span class="text-green-500 mr-2">✓</span>
                                <p class="text-gray-700">Ensure applicant is 18+ years old</p>
                            </div>
                            <div class="flex items-start">
                                <span class="text-green-500 mr-2">✓</span>
                                <p class="text-gray-700">Verify address is in your jurisdiction</p>
                            </div>
                            <div class="flex items-start">
                                <span class="text-green-500 mr-2">✓</span>
                                <p class="text-gray-700">All documents are clear and legible</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Help -->
                <div class="bg-blue-50 border border-blue-200 rounded p-4">
                    <div class="flex">
                        <svg class="w-5 h-5 text-blue-400 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div>
                            <h3 class="text-sm font-medium text-blue-800">Need Help?</h3>
                            <div class="mt-1 text-sm text-blue-700 space-y-1">
                                <p>📞 DS Office: +94 11 234 5678</p>
                                <p>📧 support@digitalid.gov.lk</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
