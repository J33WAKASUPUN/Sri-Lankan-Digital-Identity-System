@extends('layouts.app')

@section('title', 'Verify Digital ID Card')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-md mx-auto">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-green-600 rounded-full mx-auto mb-4 flex items-center justify-center">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-gray-900">🇱🇰 Verify Digital ID Card</h1>
            <p class="text-gray-600 mt-2">Check if a digital ID card is authentic and valid</p>
        </div>

        <!-- Debug Info -->
        <div class="bg-blue-50 border border-blue-200 rounded p-4 mb-6 text-sm">
            <h3 class="font-bold mb-2">🔧 Debug Information</h3>
            <p><strong>Form Action:</strong> {{ route('card.verify') }}</p>
            <p><strong>Expected URL:</strong> http://127.0.0.1:8000/verify-card</p>
            <p><strong>Method:</strong> POST</p>
            <p><strong>Current Time:</strong> {{ now() }}</p>
            <p><strong>User:</strong> {{ Auth::check() ? Auth::user()->username : 'Guest' }}</p>
        </div>

        <!-- Verification Form -->
        <div class="bg-white rounded-lg shadow p-6">
            <form action="{{ route('card.verify') }}" method="POST" id="verifyForm">
                @csrf

                <div class="mb-6">
                    <label for="card_number" class="block text-sm font-medium text-gray-700 mb-2">
                        Digital ID Card Number *
                    </label>
                    <input type="text"
                           id="card_number"
                           name="card_number"
                           value="DID-2025-00000001"
                           required
                           maxlength="50"
                           class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 text-center font-mono text-lg py-3"
                           placeholder="DID-2025-00000001">

                    @error('card_number')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror

                    <p class="mt-2 text-xs text-gray-500">
                        📱 Enter the card number found on the digital ID card
                    </p>
                </div>

                <button type="submit"
                        id="submitBtn"
                        class="w-full bg-green-600 text-white py-3 px-4 rounded-md hover:bg-green-700 font-medium transition duration-200">
                    <span id="submitText">🔍 Verify Card Now</span>
                    <span id="loadingText" class="hidden">
                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Verifying...
                    </span>
                </button>
            </form>
        </div>

        <!-- Test Cards -->
        <div class="mt-6 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
            <h3 class="text-sm font-medium text-yellow-800 mb-2">🧪 Test Card Numbers</h3>
            <div class="space-y-2">
                <button onclick="setCard('DID-2025-00000001')"
                        class="w-full text-left p-2 hover:bg-yellow-100 rounded text-sm">
                    <code class="bg-yellow-100 px-2 py-1 rounded font-mono">DID-2025-00000001</code> - Your Current Card
                </button>
            </div>
        </div>

        <!-- Direct URL Test -->
        <div class="mt-4 bg-purple-50 border border-purple-200 rounded-lg p-4">
            <h3 class="text-sm font-medium text-purple-800 mb-2">🔗 Direct URL Test</h3>
            <a href="{{ route('card.verify.public', 'DID-2025-00000001') }}"
               target="_blank"
               class="w-full bg-purple-600 text-white py-2 px-4 rounded text-center block hover:bg-purple-700">
                Test Direct Verification URL
            </a>
        </div>

        <!-- Navigation -->
        <div class="mt-8 text-center">
            @auth
                <a href="{{ route('applicant.dashboard') }}"
                   class="text-gray-600 hover:text-gray-800 text-sm font-medium">
                    ← Back to Dashboard
                </a>
            @else
                <a href="{{ route('home') }}"
                   class="text-gray-600 hover:text-gray-800 text-sm font-medium">
                    ← Back to Home
                </a>
            @endauth
        </div>
    </div>
</div>

<script>
// Set card number
function setCard(cardNumber) {
    document.getElementById('card_number').value = cardNumber;
    document.getElementById('card_number').focus();
}

// Handle form submission
document.getElementById('verifyForm').addEventListener('submit', function(e) {
    console.log('Form submission started');
    console.log('Form action:', this.action);
    console.log('Form method:', this.method);

    const submitBtn = document.getElementById('submitBtn');
    const submitText = document.getElementById('submitText');
    const loadingText = document.getElementById('loadingText');

    // Show loading state
    submitBtn.disabled = true;
    submitText.classList.add('hidden');
    loadingText.classList.remove('hidden');

    // Log form data
    const formData = new FormData(this);
    console.log('Form data:');
    for (let [key, value] of formData.entries()) {
        console.log(key + ':', value);
    }

    // Allow form to submit normally
    console.log('Allowing form submission...');
});

// Debug logging
console.log('Verify form page loaded');
console.log('Route URL:', '{{ route("card.verify") }}');
console.log('CSRF Token:', '{{ csrf_token() }}');
</script>
@endsection
