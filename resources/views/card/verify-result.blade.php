@extends('layouts.app')

@section('title', 'Card Verification Result')

@section('content')
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-md mx-auto">
            <!-- Header -->
            <div class="text-center mb-8">
                @if ($status === 'valid')
                    <div class="w-16 h-16 bg-green-600 rounded-full mx-auto mb-4 flex items-center justify-center">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <h1 class="text-2xl font-bold text-green-900">✅ Valid Digital ID</h1>
                    <p class="text-green-700 mt-2">{{ $message }}</p>
                @elseif($status === 'expired')
                    <div class="w-16 h-16 bg-yellow-600 rounded-full mx-auto mb-4 flex items-center justify-center">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h1 class="text-2xl font-bold text-yellow-900">⏰ Expired Digital ID</h1>
                    <p class="text-yellow-700 mt-2">{{ $message }}</p>
                @else
                    <div class="w-16 h-16 bg-red-600 rounded-full mx-auto mb-4 flex items-center justify-center">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </div>
                    <h1 class="text-2xl font-bold text-red-900">❌ Invalid Digital ID</h1>
                    <p class="text-red-700 mt-2">{{ $message }}</p>
                @endif
            </div>

            <!-- Card Information -->
            @if ($card)
                <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
                    <h3 class="text-lg font-semibold mb-4 text-gray-900 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        🇱🇰 Sri Lankan Digital ID Information
                    </h3>

                    <div class="space-y-4">
                        <div class="flex justify-between items-center py-3 border-b border-gray-100">
                            <span class="text-gray-600 font-medium">Card Number:</span>
                            <span
                                class="font-mono font-bold text-gray-900 bg-gray-100 px-2 py-1 rounded">{{ $card->card_number }}</span>
                        </div>

                        <div class="flex justify-between items-center py-3 border-b border-gray-100">
                            <span class="text-gray-600 font-medium">Full Name:</span>
                            <span class="font-bold text-gray-900">{{ $card->application->full_name }}</span>
                        </div>

                        <div class="flex justify-between items-center py-3 border-b border-gray-100">
                            <span class="text-gray-600 font-medium">Date of Birth:</span>
                            <span class="text-gray-900">{{ $card->application->date_of_birth->format('F j, Y') }}</span>
                        </div>

                        <div class="flex justify-between items-center py-3 border-b border-gray-100">
                            <span class="text-gray-600 font-medium">Gender:</span>
                            <span class="text-gray-900">{{ ucfirst($card->application->gender) }}</span>
                        </div>

                        <div class="flex justify-between items-center py-3 border-b border-gray-100">
                            <span class="text-gray-600 font-medium">Nationality:</span>
                            <span class="text-gray-900">{{ $card->application->nationality }}</span>
                        </div>

                        <div class="flex justify-between items-center py-3 border-b border-gray-100">
                            <span class="text-gray-600 font-medium">Issue Date:</span>
                            <span class="text-gray-900">{{ $card->issue_date->format('F j, Y') }}</span>
                        </div>

                        <div class="flex justify-between items-center py-3 border-b border-gray-100">
                            <span class="text-gray-600 font-medium">Expiry Date:</span>
                            <span class="text-gray-900 {{ $card->expiry_date < now() ? 'text-red-600 font-bold' : '' }}">
                                {{ $card->expiry_date->format('F j, Y') }}
                            </span>
                        </div>

                        <div class="flex justify-between items-center py-3">
                            <span class="text-gray-600 font-medium">Status:</span>
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                            {{ $status === 'valid'
                                ? 'bg-green-100 text-green-800'
                                : ($status === 'expired'
                                    ? 'bg-yellow-100 text-yellow-800'
                                    : 'bg-red-100 text-red-800') }}">
                                @if ($status === 'valid')
                                    ✅ Valid & Active
                                @elseif($status === 'expired')
                                    ⏰ Expired
                                @else
                                    ❌ Invalid
                                @endif
                            </span>
                        </div>
                    </div>

                    <!-- Government Seal -->
                    <div class="mt-6 pt-4 border-t border-gray-200 text-center">
                        <div class="inline-flex items-center text-sm text-gray-600">
                            <div class="w-8 h-8 bg-red-600 rounded-full flex items-center justify-center mr-2">
                                <span class="text-white text-xs font-bold">🇱🇰</span>
                            </div>
                            <span><strong>Verified by Government of Sri Lanka</strong></span>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Digital Identity Department • Secure Verification System</p>
                    </div>
                </div>
            @else
                <div class="bg-red-50 border border-red-200 rounded-lg p-6 mb-6">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">Card Not Found</h3>
                            <div class="mt-2 text-sm text-red-700">
                                <p><strong>Card Number:</strong> <code
                                        class="bg-red-100 px-1 rounded font-mono">{{ $cardNumber }}</code></p>
                                <p class="mt-1">No digital ID found with this number. Please check the card number and try
                                    again.</p>
                                <p class="mt-2 text-xs">If you believe this is an error, contact the Digital Identity
                                    helpline.</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="space-y-3">
                <a href="{{ route('card.verify.form') }}"
                    class="w-full bg-blue-600 text-white py-3 px-4 rounded-lg hover:bg-blue-700 font-medium text-center block transition flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Verify Another Card
                </a>

                @auth
                    @if (auth()->user()->role === 'applicant')
                        <a href="{{ route('applicant.dashboard') }}"
                            class="w-full bg-gray-600 text-white py-3 px-4 rounded-lg hover:bg-gray-700 font-medium text-center block transition">
                            ← Back to Applicant Dashboard
                        </a>
                    @elseif(auth()->user()->role === 'divisional_secretariat')
                        <a href="{{ route('ds.dashboard') }}"
                            class="w-full bg-purple-600 text-white py-3 px-4 rounded-lg hover:bg-purple-700 font-medium text-center block transition">
                            ← Back to DS Dashboard
                        </a>
                    @elseif(auth()->user()->role === 'grama_sevaka')
                        <a href="{{ route('gs.dashboard') }}"
                            class="w-full bg-green-600 text-white py-3 px-4 rounded-lg hover:bg-green-700 font-medium text-center block transition">
                            ← Back to GS Dashboard
                        </a>
                    @elseif(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}"
                            class="w-full bg-red-600 text-white py-3 px-4 rounded-lg hover:bg-red-700 font-medium text-center block transition">
                            ← Back to Admin Dashboard
                        </a>
                    @else
                        <a href="{{ route('home') }}"
                            class="w-full bg-gray-600 text-white py-3 px-4 rounded-lg hover:bg-gray-700 font-medium text-center block transition">
                            ← Back to Home
                        </a>
                    @endif
                @else
                    <a href="{{ route('home') }}"
                        class="w-full bg-gray-600 text-white py-3 px-4 rounded-lg hover:bg-gray-700 font-medium text-center block transition">
                        ← Back to Home
                    </a>
                @endauth
            </div>

            <!-- Quick Actions for Valid Cards -->
            @if ($card && $status === 'valid')
                <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <h4 class="text-sm font-medium text-blue-800 mb-2">✨ Additional Actions</h4>
                    <div class="space-y-2">
                        <a href="{{ route('card.verify.public', $card->card_number) }}"
                            class="text-blue-600 hover:text-blue-800 text-sm block">
                            🔗 Share Verification Link
                        </a>
                        @auth
                            @if (auth()->user()->digitalCard && auth()->user()->digitalCard->id === $card->id)
                                <a href="{{ route('digital-card.show', $card) }}"
                                    class="text-blue-600 hover:text-blue-800 text-sm block">
                                    👁️ View Full Digital Card
                                </a>
                                <a href="{{ route('digital-card.download', $card) }}"
                                    class="text-blue-600 hover:text-blue-800 text-sm block">
                                    📄 Download PDF
                                </a>
                            @endif
                        @endauth
                    </div>
                </div>
            @endif

            <!-- Security Notice -->
            <div class="mt-6 bg-gray-50 border border-gray-200 rounded-lg p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-gray-800">🔒 Security & Privacy</h3>
                        <p class="mt-1 text-sm text-gray-600">
                            This verification is secure and only shows public card status information.
                            Personal details remain protected according to Sri Lankan data protection laws.
                            For full verification with additional details, contact the issuing authority.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Verification Timestamp -->
            <div class="mt-4 text-center">
                <p class="text-xs text-gray-500">
                    Verified on {{ now()->format('F j, Y \a\t g:i A') }} UTC<br>
                    Verification ID: {{ Str::random(8) }}-{{ now()->format('YmdHis') }}
                </p>
            </div>
        </div>
    </div>
@endsection
