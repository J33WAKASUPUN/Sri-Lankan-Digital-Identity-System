@extends('layouts.app')

@section('title', 'Verify Digital ID Card - Sri Lankan Digital Identity')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 via-blue-50 to-purple-50 py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="flex justify-center items-center mb-4">
                <div class="h-12 w-12 bg-gradient-to-r from-green-600 to-green-700 rounded-full flex items-center justify-center mr-4">
                    <span class="text-white font-bold text-xl">🔍</span>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Digital ID Card Verification</h1>
                    <p class="text-sm text-gray-600 mt-1">Secure Verification System • Government of Sri Lanka</p>
                </div>
            </div>
            <p class="text-lg text-gray-700 max-w-3xl mx-auto">
                Instantly verify the authenticity of any Sri Lankan Digital Identity Card using our secure verification system
            </p>
        </div>

        <!-- Verification Methods -->
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3 mb-8">
            <!-- Card Number Verification -->
            <div class="bg-white shadow-xl rounded-lg overflow-hidden border-l-4 border-blue-500">
                <div class="bg-blue-50 px-6 py-4">
                    <h3 class="text-lg font-semibold text-blue-900">Card Number Verification</h3>
                    <p class="text-blue-700 text-sm">Enter the digital card number to verify authenticity</p>
                </div>
                <div class="p-6">
                    <form id="cardNumberForm" class="space-y-4">
                        <div>
                            <label for="card_number" class="block text-sm font-medium text-gray-700">Digital Card Number</label>
                            <input type="text"
                                   id="card_number"
                                   name="card_number"
                                   placeholder="DID-2025-001234"
                                   maxlength="15"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm font-mono">
                        </div>
                        <button type="button"
                                onclick="verifyCardNumber()"
                                class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                            <svg class="-ml-1 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                            Verify Card Number
                        </button>
                    </form>
                </div>
            </div>

            <!-- QR Code Verification -->
            <div class="bg-white shadow-xl rounded-lg overflow-hidden border-l-4 border-green-500">
                <div class="bg-green-50 px-6 py-4">
                    <h3 class="text-lg font-semibold text-green-900">QR Code Scanner</h3>
                    <p class="text-green-700 text-sm">Scan the QR code from the back of digital card</p>
                </div>
                <div class="p-6">
                    <div id="qr-scanner" class="hidden">
                        <video id="qr-video" class="w-full h-48 bg-gray-200 rounded-lg mb-4"></video>
                    </div>
                    <div id="qr-placeholder" class="w-full h-48 bg-gray-100 rounded-lg border-2 border-dashed border-gray-300 flex items-center justify-center mb-4">
                        <div class="text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 16h4m-4-4h4m-4-4h4m-4-4h4" />
                            </svg>
                            <p class="mt-2 text-sm text-gray-500">QR Scanner View</p>
                        </div>
                    </div>
                    <button type="button"
                            onclick="startQRScanner()"
                            class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                        <svg class="-ml-1 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v4H8V5z" />
                        </svg>
                        Start QR Scanner
                    </button>
                </div>
            </div>

            <!-- Batch Verification -->
            <div class="bg-white shadow-xl rounded-lg overflow-hidden border-l-4 border-purple-500">
                <div class="bg-purple-50 px-6 py-4">
                    <h3 class="text-lg font-semibold text-purple-900">Batch Verification</h3>
                    <p class="text-purple-700 text-sm">Verify multiple cards at once (for organizations)</p>
                </div>
                <div class="p-6">
                    <form id="batchForm" class="space-y-4">
                        <div>
                            <label for="batch_cards" class="block text-sm font-medium text-gray-700">Card Numbers (one per line)</label>
                            <textarea id="batch_cards"
                                      name="batch_cards"
                                      rows="4"
                                      placeholder="DID-2025-001234&#10;DID-2025-001235&#10;DID-2025-001236"
                                      class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500 sm:text-sm font-mono"></textarea>
                        </div>
                        <button type="button"
                                onclick="verifyBatch()"
                                class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-colors">
                            <svg class="-ml-1 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                            </svg>
                            Verify Batch
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Verification Results Section -->
        <div id="verificationResults" class="hidden mb-8">
            <!-- Results will be dynamically inserted here -->
        </div>

        <!-- Real-time Verification Dashboard -->
        <div class="bg-white shadow-xl rounded-lg overflow-hidden mb-8">
            <div class="bg-gradient-to-r from-green-600 to-green-700 px-6 py-4">
                <h3 class="text-lg leading-6 font-medium text-white">Real-time Verification Statistics</h3>
                <p class="text-green-100 text-sm">Live verification activity across Sri Lanka</p>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    <!-- Today's Verifications -->
                    <div class="text-center p-4 bg-green-50 rounded-lg border border-green-200">
                        <div class="text-3xl font-bold text-green-600" id="todayVerifications">1,247</div>
                        <div class="text-sm text-green-700">Verifications Today</div>
                        <div class="text-xs text-green-600 mt-1">+18% from yesterday</div>
                    </div>

                    <!-- Success Rate -->
                    <div class="text-center p-4 bg-blue-50 rounded-lg border border-blue-200">
                        <div class="text-3xl font-bold text-blue-600" id="successRate">99.7%</div>
                        <div class="text-sm text-blue-700">Success Rate</div>
                        <div class="text-xs text-blue-600 mt-1">Excellent accuracy</div>
                    </div>

                    <!-- Average Response Time -->
                    <div class="text-center p-4 bg-purple-50 rounded-lg border border-purple-200">
                        <div class="text-3xl font-bold text-purple-600" id="responseTime">0.3s</div>
                        <div class="text-sm text-purple-700">Avg Response Time</div>
                        <div class="text-xs text-purple-600 mt-1">Lightning fast</div>
                    </div>

                    <!-- Active Cards -->
                    <div class="text-center p-4 bg-yellow-50 rounded-lg border border-yellow-200">
                        <div class="text-3xl font-bold text-yellow-600" id="activeCards">847,293</div>
                        <div class="text-sm text-yellow-700">Active Digital IDs</div>
                        <div class="text-xs text-yellow-600 mt-1">In circulation</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Security Information -->
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2 mb-8">
            <!-- How Verification Works -->
            <div class="bg-white shadow-xl rounded-lg overflow-hidden">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">How Verification Works</h3>
                    <p class="text-sm text-gray-600">Understanding our secure verification process</p>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="h-8 w-8 bg-blue-100 rounded-full flex items-center justify-center">
                                    <span class="text-blue-600 font-bold text-sm">1</span>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-sm font-medium text-gray-900">Input Validation</h4>
                                <p class="text-sm text-gray-600">Card number or QR code is validated for correct format and structure</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="h-8 w-8 bg-blue-100 rounded-full flex items-center justify-center">
                                    <span class="text-blue-600 font-bold text-sm">2</span>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-sm font-medium text-gray-900">Cryptographic Check</h4>
                                <p class="text-sm text-gray-600">Digital signatures and security hashes are verified against blockchain records</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="h-8 w-8 bg-blue-100 rounded-full flex items-center justify-center">
                                    <span class="text-blue-600 font-bold text-sm">3</span>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-sm font-medium text-gray-900">Database Lookup</h4>
                                <p class="text-sm text-gray-600">Card details are cross-referenced with the secure government database</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="h-8 w-8 bg-blue-100 rounded-full flex items-center justify-center">
                                    <span class="text-blue-600 font-bold text-sm">4</span>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-sm font-medium text-gray-900">Status Verification</h4>
                                <p class="text-sm text-gray-600">Card status is checked for validity, expiry, and any security flags</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="h-8 w-8 bg-green-100 rounded-full flex items-center justify-center">
                                    <span class="text-green-600 font-bold text-sm">✓</span>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-sm font-medium text-gray-900">Instant Results</h4>
                                <p class="text-sm text-gray-600">Verification result is displayed with detailed card information</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Security Features -->
            <div class="bg-white shadow-xl rounded-lg overflow-hidden">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Security Features</h3>
                    <p class="text-sm text-gray-600">Advanced protection against fraud and tampering</p>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <div class="flex items-center">
                            <svg class="h-5 w-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            <div>
                                <h4 class="text-sm font-medium text-gray-900">256-bit Encryption</h4>
                                <p class="text-xs text-gray-600">Military-grade cryptographic protection</p>
                            </div>
                        </div>

                        <div class="flex items-center">
                            <svg class="h-5 w-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            <div>
                                <h4 class="text-sm font-medium text-gray-900">Blockchain Verification</h4>
                                <p class="text-xs text-gray-600">Immutable record verification</p>
                            </div>
                        </div>

                        <div class="flex items-center">
                            <svg class="h-5 w-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            <div>
                                <h4 class="text-sm font-medium text-gray-900">Real-time Database</h4>
                                <p class="text-xs text-gray-600">Live status checking</p>
                            </div>
                        </div>

                        <div class="flex items-center">
                            <svg class="h-5 w-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            <div>
                                <h4 class="text-sm font-medium text-gray-900">Anti-tampering Protection</h4>
                                <p class="text-xs text-gray-600">Detects any modifications</p>
                            </div>
                        </div>

                        <div class="flex items-center">
                            <svg class="h-5 w-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            <div>
                                <h4 class="text-sm font-medium text-gray-900">Audit Trail Logging</h4>
                                <p class="text-xs text-gray-600">All verifications are logged</p>
                            </div>
                        </div>

                        <div class="flex items-center">
                            <svg class="h-5 w-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            <div>
                                <h4 class="text-sm font-medium text-gray-900">Multi-factor Authentication</h4>
                                <p class="text-xs text-gray-600">Multiple verification layers</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- API Documentation for Developers -->
        <div class="bg-white shadow-xl rounded-lg overflow-hidden mb-8">
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Developer API Integration</h3>
                <p class="text-sm text-gray-600">Integrate digital ID verification into your applications</p>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                    <!-- API Endpoints -->
                    <div>
                        <h4 class="text-md font-medium text-gray-800 mb-4">API Endpoints</h4>
                        <div class="space-y-3">
                            <div class="bg-gray-50 p-3 rounded-lg border">
                                <div class="flex items-center mb-2">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800 mr-2">
                                        POST
                                    </span>
                                    <code class="text-sm font-mono text-gray-700">/api/v1/verify/card</code>
                                </div>
                                <p class="text-xs text-gray-600">Verify a single digital ID card</p>
                            </div>

                            <div class="bg-gray-50 p-3 rounded-lg border">
                                <div class="flex items-center mb-2">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800 mr-2">
                                        POST
                                    </span>
                                    <code class="text-sm font-mono text-gray-700">/api/v1/verify/batch</code>
                                </div>
                                <p class="text-xs text-gray-600">Verify multiple cards in batch</p>
                            </div>

                            <div class="bg-gray-50 p-3 rounded-lg border">
                                <div class="flex items-center mb-2">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-purple-100 text-purple-800 mr-2">
                                        GET
                                    </span>
                                    <code class="text-sm font-mono text-gray-700">/api/v1/status/{card_number}</code>
                                </div>
                                <p class="text-xs text-gray-600">Get card status and validity</p>
                            </div>
                        </div>
                    </div>

                    <!-- Sample Code -->
                    <div>
                        <h4 class="text-md font-medium text-gray-800 mb-4">Sample Integration</h4>
                        <div class="bg-gray-900 rounded-lg p-4 text-white text-xs font-mono overflow-x-auto">
                            <pre><code>// JavaScript Example
const verifyCard = async (cardNumber) => {
  const response = await fetch('/api/v1/verify/card', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'Authorization': 'Bearer YOUR_API_KEY'
    },
    body: JSON.stringify({
      card_number: cardNumber
    })
  });

  const result = await response.json();
  return result;
};

// Usage
verifyCard('DID-2025-001234')
  .then(result => {
    if (result.valid) {
      console.log('Card is valid:', result.holder_name);
    } else {
      console.log('Invalid card:', result.error);
    }
  });</code></pre>
                        </div>
                        <div class="mt-3">
                            <a href="#" class="text-sm text-blue-600 hover:text-blue-500">
                                📚 View Full API Documentation →
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Important Notice -->
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-yellow-800">
                        Verification Service Notice
                    </h3>
                    <div class="mt-2 text-sm text-yellow-700">
                        <ul class="list-disc pl-5 space-y-1">
                            <li>This verification service is operated by the Government of Sri Lanka</li>
                            <li>All verification requests are logged for security and audit purposes</li>
                            <li>Only enter card numbers you are authorized to verify</li>
                            <li>For API access, contact the Digital Identity Department for authentication keys</li>
                            <li>Report any suspicious or fraudulent cards to the authorities immediately</li>
                            <li>Service availability: 24/7 with 99.9% uptime guarantee</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Auto-update statistics every 10 seconds
setInterval(updateStatistics, 10000);

function updateStatistics() {
    // Simulate real-time updates
    const todayEl = document.getElementById('todayVerifications');
    const currentValue = parseInt(todayEl.textContent.replace(',', ''));
    const newValue = currentValue + Math.floor(Math.random() * 5);
    todayEl.textContent = newValue.toLocaleString();
}

function verifyCardNumber() {
    const cardNumber = document.getElementById('card_number').value.trim();

    if (!cardNumber) {
        showError('Please enter a card number');
        return;
    }

    if (!isValidCardFormat(cardNumber)) {
        showError('Invalid card number format. Expected format: DID-YYYY-XXXXXX');
        return;
    }

    showLoading('Verifying card number...');

    // Simulate API call
    setTimeout(() => {
        const isValid = Math.random() > 0.1; // 90% success rate simulation

        if (isValid) {
            showVerificationResult({
                valid: true,
                cardNumber: cardNumber,
                holderName: 'Priya Wickramasinghe',
                issueDate: '2025-06-10',
                expiryDate: '2030-06-10',
                status: 'Active',
                verificationTime: new Date().toISOString()
            });
        } else {
            showVerificationResult({
                valid: false,
                cardNumber: cardNumber,
                error: 'Card not found in database or has been revoked',
                verificationTime: new Date().toISOString()
            });
        }
    }, 2000);
}

function startQRScanner() {
    const scanner = document.getElementById('qr-scanner');
    const placeholder = document.getElementById('qr-placeholder');

    // Simulate QR scanner activation
    placeholder.classList.add('hidden');
    scanner.classList.remove('hidden');

    showLoading('Starting QR scanner...');

    // Simulate QR code detection after 3 seconds
    setTimeout(() => {
        const simulatedCardNumber = 'DID-2025-001234';
        document.getElementById('card_number').value = simulatedCardNumber;

        scanner.classList.add('hidden');
        placeholder.classList.remove('hidden');

        showSuccess('QR code detected! Verifying card...');

        setTimeout(() => {
            verifyCardNumber();
        }, 1000);
    }, 3000);
}

function verifyBatch() {
    const batchInput = document.getElementById('batch_cards').value.trim();

    if (!batchInput) {
        showError('Please enter card numbers to verify');
        return;
    }

    const cardNumbers = batchInput.split('\n').filter(line => line.trim());

    if (cardNumbers.length === 0) {
        showError('No valid card numbers found');
        return;
    }

    showLoading(`Verifying ${cardNumbers.length} cards...`);

    // Simulate batch verification
    setTimeout(() => {
        const results = cardNumbers.map(cardNumber => {
            const isValid = Math.random() > 0.15; // 85% success rate for batch
            return {
                cardNumber: cardNumber.trim(),
                valid: isValid,
                holderName: isValid ? generateRandomName() : null,
                status: isValid ? 'Active' : 'Invalid'
            };
        });

        showBatchResults(results);
    }, 3000);
}

function isValidCardFormat(cardNumber) {
    const pattern = /^DID-\d{4}-\d{6}$/;
    return pattern.test(cardNumber);
}

function generateRandomName() {
    const firstNames = ['Priya', 'Rajan', 'Kamala', 'Sunil', 'Nilmini', 'Asanka', 'Sanduni', 'Nuwan'];
    const lastNames = ['Perera', 'Silva', 'Fernando', 'Wickramasinghe', 'Rathnayake', 'Jayawardena', 'Gunasekara'];

    return `${firstNames[Math.floor(Math.random() * firstNames.length)]} ${lastNames[Math.floor(Math.random() * lastNames.length)]}`;
}

function showLoading(message) {
    const resultsDiv = document.getElementById('verificationResults');
    resultsDiv.classList.remove('hidden');
    resultsDiv.innerHTML = `
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="animate-spin h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-blue-800 font-medium">${message}</p>
                </div>
            </div>
        </div>
    `;
}

function showError(message) {
    const resultsDiv = document.getElementById('verificationResults');
    resultsDiv.classList.remove('hidden');
    resultsDiv.innerHTML = `
        <div class="bg-red-50 border border-red-200 rounded-lg p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-red-800 font-medium">${message}</p>
                </div>
            </div>
        </div>
    `;
}

function showSuccess(message) {
    const resultsDiv = document.getElementById('verificationResults');
    resultsDiv.classList.remove('hidden');
    resultsDiv.innerHTML = `
        <div class="bg-green-50 border border-green-200 rounded-lg p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-green-800 font-medium">${message}</p>
                </div>
            </div>
        </div>
    `;
}

function showVerificationResult(result) {
    const resultsDiv = document.getElementById('verificationResults');
    resultsDiv.classList.remove('hidden');

    if (result.valid) {
        resultsDiv.innerHTML = `
            <div class="bg-green-50 border border-green-200 rounded-lg overflow-hidden">
                <div class="bg-green-500 px-6 py-4">
                    <h3 class="text-lg font-medium text-white">✅ Card Verification Successful</h3>
                    <p class="text-green-100 text-sm">Digital ID card is valid and active</p>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <dt class="text-sm font-medium text-gray-600">Card Number</dt>
                            <dd class="text-lg font-mono font-bold text-gray-900">${result.cardNumber}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-600">Cardholder Name</dt>
                            <dd class="text-lg font-semibold text-gray-900">${result.holderName}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-600">Issue Date</dt>
                            <dd class="text-sm text-gray-900">${result.issueDate}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-600">Expiry Date</dt>
                            <dd class="text-sm text-gray-900">${result.expiryDate}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-600">Status</dt>
                            <dd>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <div class="h-1.5 w-1.5 bg-green-400 rounded-full mr-1.5 animate-pulse"></div>
                                    ${result.status}
                                </span>
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-600">Verified At</dt>
                            <dd class="text-sm text-gray-900">${new Date(result.verificationTime).toLocaleString()}</dd>
                        </div>
                    </div>
                    <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <div class="flex items-center">
                            <svg class="h-5 w-5 text-blue-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                            </svg>
                            <span class="text-sm font-medium text-blue-800">
                                This verification confirms the card is genuine and issued by the Government of Sri Lanka
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        `;
    } else {
        resultsDiv.innerHTML = `
            <div class="bg-red-50 border border-red-200 rounded-lg overflow-hidden">
                <div class="bg-red-500 px-6 py-4">
                    <h3 class="text-lg font-medium text-white">❌ Card Verification Failed</h3>
                    <p class="text-red-100 text-sm">Digital ID card is invalid or not found</p>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <dt class="text-sm font-medium text-gray-600">Card Number</dt>
                            <dd class="text-lg font-mono font-bold text-gray-900">${result.cardNumber}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-600">Error</dt>
                            <dd class="text-sm text-red-600 font-medium">${result.error}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-600">Verified At</dt>
                            <dd class="text-sm text-gray-900">${new Date(result.verificationTime).toLocaleString()}</dd>
                        </div>
                    </div>
                    <div class="mt-6 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                        <div class="flex items-center">
                            <svg class="h-5 w-5 text-yellow-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                            <span class="text-sm font-medium text-yellow-800">
                                If you believe this is an error, please contact the Digital Identity helpline at +94 11 234 5678
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        `;
    }
}

function showBatchResults(results) {
    const resultsDiv = document.getElementById('verificationResults');
    resultsDiv.classList.remove('hidden');

    const validCount = results.filter(r => r.valid).length;
    const invalidCount = results.length - validCount;

    let html = `
        <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
            <div class="bg-purple-500 px-6 py-4">
                <h3 class="text-lg font-medium text-white">📊 Batch Verification Results</h3>
                <p class="text-purple-100 text-sm">${results.length} cards processed • ${validCount} valid • ${invalidCount} invalid</p>
            </div>
            <div class="p-6">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Card Number</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Holder Name</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
    `;

    results.forEach(result => {
        html += `
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-gray-900">${result.cardNumber}</td>
                <td class="px-6 py-4 whitespace-nowrap">
                    ${result.valid ?
                        '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">✅ Valid</span>' :
                        '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">❌ Invalid</span>'
                    }
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${result.holderName || 'N/A'}</td>
            </tr>
        `;
    });

    html += `
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    `;

    resultsDiv.innerHTML = html;
}

// Format card number input
document.getElementById('card_number').addEventListener('input', function(e) {
    let value = e.target.value.replace(/[^a-zA-Z0-9-]/g, '').toUpperCase();

    // Format as DID-YYYY-XXXXXX
    if (value.length <= 3) {
        value = value;
    } else if (value.length <= 8) {
        value = value.slice(0, 3) + '-' + value.slice(3);
    } else if (value.length <= 15) {
        value = value.slice(0, 3) + '-' + value.slice(3, 7) + '-' + value.slice(7);
    }

    e.target.value = value;
});
</script>
@endsection
