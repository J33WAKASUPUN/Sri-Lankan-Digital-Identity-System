@extends('layouts.app')

@section('title', 'Digital ID Card - Sri Lankan Digital Identity')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-purple-50 to-pink-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="flex justify-center items-center mb-4">
                <div class="h-12 w-12 bg-gradient-to-r from-red-700 to-red-800 rounded-full flex items-center justify-center mr-4">
                    <span class="text-yellow-400 font-bold text-xl">🇱🇰</span>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Sri Lankan Digital Identity Card</h1>
                    <p class="text-sm text-gray-600 mt-1">Democratic Socialist Republic of Sri Lanka</p>
                </div>
            </div>
            <p class="text-lg text-gray-700 max-w-2xl mx-auto">
                Your official digital identity card issued by the Government of Sri Lanka
            </p>
        </div>

        <!-- Digital Card Display -->
        <div class="relative mb-8">
            <!-- Card Front -->
            <div id="cardFront" class="bg-gradient-to-br from-red-700 via-red-800 to-red-900 rounded-2xl shadow-2xl p-8 text-white relative overflow-hidden transform transition-all duration-700 hover:scale-105">
                <!-- Background Pattern -->
                <div class="absolute inset-0 opacity-10">
                    <svg class="w-full h-full" viewBox="0 0 400 240" fill="none">
                        <path d="M50 50L350 50L350 190L50 190Z" stroke="currentColor" stroke-width="2" fill="none" opacity="0.3"/>
                        <circle cx="100" cy="100" r="30" stroke="currentColor" stroke-width="1" fill="none" opacity="0.2"/>
                        <circle cx="300" cy="140" r="40" stroke="currentColor" stroke-width="1" fill="none" opacity="0.2"/>
                        <path d="M200 60L220 80L200 100L180 80Z" stroke="currentColor" stroke-width="1" fill="none" opacity="0.3"/>
                    </svg>
                </div>

                <!-- Sri Lankan Government Logo -->
                <div class="absolute top-4 right-4">
                    <div class="h-16 w-16 bg-yellow-400 rounded-full flex items-center justify-center shadow-lg">
                        <span class="text-red-800 font-bold text-2xl">🏛️</span>
                    </div>
                </div>

                <!-- Card Header -->
                <div class="relative z-10">
                    <div class="flex items-center mb-6">
                        <div class="mr-4">
                            <h2 class="text-xl font-bold text-yellow-400">Democratic Socialist Republic of Sri Lanka</h2>
                            <p class="text-red-200 text-sm">ශ්‍රී ලංකා ප්‍රජාතාන්ත්‍රික සමාජවාදී ජනරජය</p>
                            <p class="text-red-200 text-sm">இலங்கை ஜனநாயக சோசலிசக் குடியரசு</p>
                        </div>
                    </div>

                    <div class="text-center mb-6">
                        <h3 class="text-2xl font-bold text-white">DIGITAL IDENTITY CARD</h3>
                        <p class="text-red-200">ඩිජිටල් හැඳුනුම්පත | டிஜிட்டல் அடையாள அட்டை</p>
                    </div>

                    <!-- Cardholder Information (No Photo) -->
                    <div class="grid grid-cols-1 gap-6">
                        <!-- Personal Details Only -->
                        <div class="space-y-4">
                            <div class="text-center mb-6">
                                <label class="text-red-200 text-xs uppercase tracking-wide">Full Name</label>
                                <p class="text-white text-2xl font-bold">{{ $digitalCard->application->full_name }}</p>
                            </div>

                            <div class="grid grid-cols-2 gap-6">
                                <div class="text-center">
                                    <label class="text-red-200 text-xs uppercase tracking-wide">Card Number</label>
                                    <p class="text-yellow-400 text-lg font-mono font-bold">{{ $digitalCard->card_number }}</p>
                                </div>
                                <div class="text-center">
                                    <label class="text-red-200 text-xs uppercase tracking-wide">Date of Birth</label>
                                    <p class="text-white text-lg">{{ $digitalCard->application->date_of_birth->format('F j, Y') }}</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-6">
                                <div class="text-center">
                                    <label class="text-red-200 text-xs uppercase tracking-wide">Gender</label>
                                    <p class="text-white text-lg">{{ ucfirst($digitalCard->application->gender) }}</p>
                                </div>
                                <div class="text-center">
                                    <label class="text-red-200 text-xs uppercase tracking-wide">Nationality</label>
                                    <p class="text-white text-lg">{{ $digitalCard->application->nationality }}</p>
                                </div>
                            </div>

                            <div class="text-center">
                                <label class="text-red-200 text-xs uppercase tracking-wide">Address</label>
                                <p class="text-white text-sm">{{ Str::limit($digitalCard->application->address, 100) }}</p>
                            </div>

                            <div class="grid grid-cols-2 gap-6">
                                <div class="text-center">
                                    <label class="text-red-200 text-xs uppercase tracking-wide">Issue Date</label>
                                    <p class="text-white text-sm">{{ $digitalCard->issue_date->format('M j, Y') }}</p>
                                </div>
                                <div class="text-center">
                                    <label class="text-red-200 text-xs uppercase tracking-wide">Expiry Date</label>
                                    <p class="text-yellow-400 text-sm font-semibold">{{ $digitalCard->expiry_date->format('M j, Y') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card Footer -->
                <div class="absolute bottom-4 left-4 right-4 flex justify-between items-center">
                    <div class="text-red-200 text-xs">
                        <p>Authorized by DS Office</p>
                        <p>Government of Sri Lanka</p>
                    </div>
                    <div class="text-right">
                        <button onclick="flipCard()" class="text-yellow-400 hover:text-yellow-300 text-xs underline">
                            View Security Features →
                        </button>
                    </div>
                </div>
            </div>

            <!-- Card Back -->
            <div id="cardBack" class="hidden bg-gradient-to-br from-gray-800 via-gray-900 to-black rounded-2xl shadow-2xl p-8 text-white relative overflow-hidden transform transition-all duration-700">
                <!-- Security Pattern Background -->
                <div class="absolute inset-0 opacity-10">
                    <svg class="w-full h-full" viewBox="0 0 400 240" fill="none">
                        <defs>
                            <pattern id="security-pattern" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse">
                                <rect width="20" height="20" fill="none" stroke="currentColor" stroke-width="0.5" opacity="0.3"/>
                                <circle cx="10" cy="10" r="3" fill="currentColor" opacity="0.2"/>
                            </pattern>
                        </defs>
                        <rect width="100%" height="100%" fill="url(#security-pattern)"/>
                    </svg>
                </div>

                <div class="relative z-10">
                    <!-- Security Header -->
                    <div class="text-center mb-8">
                        <h3 class="text-2xl font-bold text-white mb-2">SECURITY FEATURES</h3>
                        <p class="text-gray-300">This digital ID contains advanced security measures</p>
                    </div>

                    <div class="grid grid-cols-2 gap-8">
                        <!-- QR Code -->
                        <div class="text-center">
                            <div class="bg-white p-4 rounded-lg inline-block shadow-lg">
                                <div id="qrcode" class="w-32 h-32 mx-auto bg-white flex items-center justify-center">
                                    {!! $qrCodeSvg !!}
                                </div>
                            </div>
                            <p class="text-gray-300 text-sm mt-3">Verification QR Code</p>
                            <p class="text-gray-400 text-xs">Scan to verify authenticity</p>
                        </div>

                        <!-- Security Information -->
                        <div class="space-y-4">
                            <div class="bg-gray-800 rounded-lg p-4 border border-gray-700">
                                <h4 class="text-green-400 font-semibold mb-2">🔒 Cryptographic Security</h4>
                                <p class="text-gray-300 text-sm">256-bit encryption with digital signatures</p>
                            </div>

                            <div class="bg-gray-800 rounded-lg p-4 border border-gray-700">
                                <h4 class="text-blue-400 font-semibold mb-2">🛡️ Government Verified</h4>
                                <p class="text-gray-300 text-sm">Approved by Divisional Secretariat</p>
                            </div>

                            <div class="bg-gray-800 rounded-lg p-4 border border-gray-700">
                                <h4 class="text-purple-400 font-semibold mb-2">⏰ Real-time Verification</h4>
                                <p class="text-gray-300 text-sm">Live status checking available 24/7</p>
                            </div>

                            <div class="bg-gray-800 rounded-lg p-4 border border-gray-700">
                                <h4 class="text-yellow-400 font-semibold mb-2">🔐 Tamper Proof</h4>
                                <p class="text-gray-300 text-sm">Immutable digital record</p>
                            </div>
                        </div>
                    </div>

                    <!-- Security Hash -->
                    <div class="mt-8 text-center">
                        <div class="bg-gray-800 rounded-lg p-4 border border-gray-700">
                            <h4 class="text-gray-300 text-sm mb-2">Security Hash</h4>
                            <p class="text-green-400 font-mono text-xs break-all">
                                SHA-256: {{ hash('sha256', $digitalCard->card_number . $digitalCard->application->full_name . $digitalCard->issue_date) }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Back Navigation -->
                <div class="absolute bottom-4 left-4 right-4 flex justify-between items-center">
                    <div class="text-gray-400 text-xs">
                        <p>Advanced Security Features</p>
                        <p>Government Grade Protection</p>
                    </div>
                    <div class="text-right">
                        <button onclick="flipCard()" class="text-blue-400 hover:text-blue-300 text-xs underline">
                            ← Back to Card
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Actions -->
        <div class="bg-white shadow-xl rounded-lg p-6 mb-8">
            <h3 class="text-lg font-semibold text-gray-900 mb-6">Digital Card Actions</h3>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                <!-- Download Card - WORKING DOWNLOAD -->
                <a href="{{ route('digital-card.download', $digitalCard) }}"
                   class="flex items-center justify-center px-6 py-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                    <svg class="-ml-1 mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Download PDF
                </a>

                <!-- Print Card -->
                <button onclick="printCard()"
                        class="flex items-center justify-center px-6 py-4 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                    <svg class="-ml-1 mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    Print Card
                </button>

                <!-- Verify Authenticity -->
                <a href="{{ route('card.verify.form') }}"
                   class="flex items-center justify-center px-6 py-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-200">
                    <svg class="-ml-1 mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                    Verify Card
                </a>

                <!-- Back to Dashboard -->
                <a href="javascript:history.back()"
                   class="flex items-center justify-center px-6 py-4 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                    <svg class="-ml-1 mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Go Back
                </a>
            </div>
        </div>

        <!-- Digital ID Information -->
        <div class="bg-white shadow-xl rounded-lg p-6 mb-8">
            <h3 class="text-lg font-semibold text-gray-900 mb-6">Digital ID Information</h3>
            <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                <!-- Card Details -->
                <div>
                    <h4 class="text-md font-medium text-gray-800 mb-4">Card Details</h4>
                    <dl class="space-y-3">
                        <div class="flex justify-between">
                            <dt class="text-sm text-gray-600">Card Number</dt>
                            <dd class="text-sm font-mono font-medium text-gray-900">{{ $digitalCard->card_number }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm text-gray-600">Application Number</dt>
                            <dd class="text-sm font-mono font-medium text-gray-900">{{ $digitalCard->application->application_number }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm text-gray-600">Issue Date</dt>
                            <dd class="text-sm font-medium text-gray-900">{{ $digitalCard->issue_date->format('F j, Y') }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm text-gray-600">Expiry Date</dt>
                            <dd class="text-sm font-medium text-gray-900">{{ $digitalCard->expiry_date->format('F j, Y') }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm text-gray-600">Status</dt>
                            <dd>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <div class="h-1.5 w-1.5 bg-green-400 rounded-full mr-1.5 animate-pulse"></div>
                                    Active
                                </span>
                            </dd>
                        </div>
                    </dl>
                </div>

                <!-- Security Features -->
                <div>
                    <h4 class="text-md font-medium text-gray-800 mb-4">Security Features</h4>
                    <div class="space-y-3">
                        <div class="flex items-center text-sm text-gray-600">
                            <svg class="h-4 w-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            Cryptographically signed
                        </div>
                        <div class="flex items-center text-sm text-gray-600">
                            <svg class="h-4 w-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            QR code verification
                        </div>
                        <div class="flex items-center text-sm text-gray-600">
                            <svg class="h-4 w-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            Government verified
                        </div>
                        <div class="flex items-center text-sm text-gray-600">
                            <svg class="h-4 w-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            Real-time validation
                        </div>
                        <div class="flex items-center text-sm text-gray-600">
                            <svg class="h-4 w-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            Tamper proof design
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Important Notice -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-blue-800">
                        Important Information
                    </h3>
                    <div class="mt-2 text-sm text-blue-700">
                        <ul class="list-disc pl-5 space-y-1">
                            <li>This digital ID card is legally equivalent to a physical ID card</li>
                            <li>Keep your card number confidential and report any unauthorized use immediately</li>
                            <li>Always verify the authenticity of your card before sharing with third parties</li>
                            <li>For assistance or support, contact the Digital ID helpline at +94 11 234 5678</li>
                            <li>This card expires on {{ $digitalCard->expiry_date->format('F j, Y') }} - renew before expiry</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function flipCard() {
    const front = document.getElementById('cardFront');
    const back = document.getElementById('cardBack');

    if (front.classList.contains('hidden')) {
        // Show front, hide back
        back.classList.add('hidden');
        front.classList.remove('hidden');
        setTimeout(() => {
            front.style.transform = 'rotateY(0deg)';
        }, 50);
    } else {
        // Show back, hide front
        front.style.transform = 'rotateY(180deg)';
        setTimeout(() => {
            front.classList.add('hidden');
            back.classList.remove('hidden');
            back.style.transform = 'rotateY(0deg)';
        }, 350);
    }
}

function printCard() {
    if (confirm('Print Digital ID Card\n\nThis will open a print-optimized version of your digital ID card.\n\nRecommended settings:\n• Paper: A4 or Letter\n• Quality: High\n• Color: Color printing recommended\n\nProceed with printing?')) {
        window.print();
    }
}

// Add holographic effect on mouse move
document.getElementById('cardFront').addEventListener('mousemove', function(e) {
    const card = this;
    const rect = card.getBoundingClientRect();
    const x = e.clientX - rect.left;
    const y = e.clientY - rect.top;

    const centerX = rect.width / 2;
    const centerY = rect.height / 2;

    const rotateX = (y - centerY) / 10;
    const rotateY = (centerX - x) / 10;

    card.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg)`;
});

document.getElementById('cardFront').addEventListener('mouseleave', function() {
    this.style.transform = 'perspective(1000px) rotateX(0deg) rotateY(0deg)';
});
</script>

<style>
@media print {
    body * {
        visibility: hidden;
    }
    #cardFront, #cardFront * {
        visibility: visible;
    }
    #cardFront {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        transform: none !important;
    }
}

.card-flip {
    transition: transform 0.7s;
    transform-style: preserve-3d;
}
</style>
@endsection
