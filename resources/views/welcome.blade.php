@extends('layouts.app')

@section('title', 'Welcome to Sri Lankan Digital Identity System')

@section('content')
<!-- Hero Section -->
<div class="relative bg-gradient-to-br from-purple-900 via-purple-800 to-indigo-900 min-h-screen flex items-center">
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0" style="background-image: radial-gradient(circle at 25% 25%, white 2px, transparent 2px), radial-gradient(circle at 75% 75%, white 2px, transparent 2px); background-size: 100px 100px;"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="text-center">
            <!-- Sri Lankan Flag Emoji -->
            <div class="flex justify-center mb-8">
                <div class="h-24 w-24 bg-gradient-to-br from-yellow-400 to-yellow-500 rounded-full flex items-center justify-center shadow-2xl animate-pulse">
                    <span class="text-4xl">🇱🇰</span>
                </div>
            </div>

            <!-- Main Title -->
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-white mb-6">
                <span class="block">Sri Lankan</span>
                <span class="block bg-gradient-to-r from-yellow-400 to-yellow-500 bg-clip-text text-transparent">
                    Digital Identity System
                </span>
            </h1>

            <!-- Subtitle -->
            <p class="text-xl sm:text-2xl text-purple-100 mb-8 max-w-3xl mx-auto leading-relaxed">
                The official digital identity platform of the Democratic Socialist Republic of Sri Lanka.
                <br class="hidden sm:block">
                <span class="text-purple-200">Secure • Efficient • Accessible</span>
            </p>

            <!-- Multilingual Text -->
            <div class="mb-12 text-sm text-purple-200 space-y-1">
                <p>🇱🇰 ශ්‍රී ලංකා ප්‍රජාතාන්ත්‍රික සමාජවාදී ජනරජයේ ඩිජිටල් හැඳුනුම්පත් පද්ධතිය</p>
                <p>🇱🇰 இலங்கை ஜனநாயக சோசலிசக் குடியரசின் டிஜிட்டல் அடையாள அமைப்பு</p>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                @guest
                    <!-- Register Button -->
                    <a href="{{ route('register') }}"
                       class="group relative inline-flex items-center px-8 py-4 bg-gradient-to-r from-yellow-400 to-yellow-500 text-purple-900 font-bold text-lg rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200">
                        <svg class="mr-3 h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                        </svg>
                        Apply for Digital ID
                        <div class="absolute inset-0 bg-white opacity-0 group-hover:opacity-20 rounded-xl transition-opacity duration-200"></div>
                    </a>

                    <!-- Login Button -->
                    <a href="{{ route('login') }}"
                       class="inline-flex items-center px-8 py-4 border-2 border-white text-white font-semibold text-lg rounded-xl hover:bg-white hover:text-purple-900 transition-all duration-200">
                        <svg class="mr-3 h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                        </svg>
                        Sign In
                    </a>
                @else
                    <!-- Dashboard Button for Logged In Users -->
                    <a href="{{ route(auth()->user()->role . '.dashboard') }}"
                       class="group relative inline-flex items-center px-8 py-4 bg-gradient-to-r from-green-400 to-green-500 text-white font-bold text-lg rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200">
                        <svg class="mr-3 h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z" />
                        </svg>
                        Go to Dashboard
                        <div class="absolute inset-0 bg-white opacity-0 group-hover:opacity-20 rounded-xl transition-opacity duration-200"></div>
                    </a>
                @endguest

                <!-- Verify ID Button -->
                <a href="{{ route('card.verify.form') }}"
                   class="inline-flex items-center px-8 py-4 border-2 border-purple-300 text-purple-100 font-semibold text-lg rounded-xl hover:bg-purple-300 hover:text-purple-900 transition-all duration-200">
                    <svg class="mr-3 h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                    Verify Digital ID
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Features Section -->
<div class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="text-center mb-16">
            <h2 class="text-sm font-semibold text-purple-600 uppercase tracking-wide">Government Services</h2>
            <h3 class="mt-2 text-3xl sm:text-4xl font-bold text-gray-900">
                Modern Digital Identity Solutions
            </h3>
            <p class="mt-4 text-xl text-gray-600 max-w-2xl mx-auto">
                Experience the future of government services with our secure, efficient digital identity platform.
            </p>
        </div>

        <!-- Feature Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Digital ID Cards -->
            <div class="group bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100 hover:border-purple-200">
                <div class="h-12 w-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                    <svg class="h-7 w-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V4a2 2 0 012-2h2a2 2 0 012 2v2m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V4a2 2 0 012-2h2a2 2 0 012 2v2"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-4">🆔 Digital ID Cards</h3>
                <p class="text-gray-600 leading-relaxed">
                    Secure, tamper-proof digital identity cards with advanced encryption and blockchain verification for ultimate security.
                </p>
            </div>

            <!-- Instant Verification -->
            <div class="group bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100 hover:border-green-200">
                <div class="h-12 w-12 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                    <svg class="h-7 w-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-4">⚡ Instant Verification</h3>
                <p class="text-gray-600 leading-relaxed">
                    Real-time identity verification using QR codes and secure government databases for immediate authentication.
                </p>
            </div>

            <!-- Mobile Access -->
            <div class="group bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100 hover:border-blue-200">
                <div class="h-12 w-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                    <svg class="h-7 w-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-4">📱 Mobile Access</h3>
                <p class="text-gray-600 leading-relaxed">
                    Access your digital ID anywhere, anytime with our responsive mobile-friendly platform and offline capabilities.
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Section -->
<div class="py-20 bg-gradient-to-br from-purple-900 to-indigo-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl sm:text-4xl font-bold text-white mb-4">
                Trusted by Sri Lankan Citizens
            </h2>
            <p class="text-xl text-purple-200">
                Building a digital future for Sri Lanka with secure, reliable government services.
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-8 text-center">
            <!-- Digital IDs Issued -->
            <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-8 border border-white/20">
                <div class="text-5xl font-bold text-yellow-400 mb-2 animate-pulse">1.2M+</div>
                <div class="text-lg font-medium text-purple-200">Digital IDs Issued</div>
                <div class="text-sm text-purple-300 mt-2">Active digital identity cards</div>
            </div>

            <!-- Verifications Daily -->
            <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-8 border border-white/20">
                <div class="text-5xl font-bold text-yellow-400 mb-2 animate-pulse">50K+</div>
                <div class="text-lg font-medium text-purple-200">Daily Verifications</div>
                <div class="text-sm text-purple-300 mt-2">Identity checks per day</div>
            </div>

            <!-- Processing Efficiency -->
            <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-8 border border-white/20">
                <div class="text-5xl font-bold text-yellow-400 mb-2 animate-pulse">99.7%</div>
                <div class="text-lg font-medium text-purple-200">System Uptime</div>
                <div class="text-sm text-purple-300 mt-2">Reliable service availability</div>
            </div>
        </div>
    </div>
</div>

<!-- Call to Action Section -->
<div class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-gradient-to-r from-purple-600 to-indigo-600 rounded-3xl p-12 text-center">
            <h2 class="text-3xl sm:text-4xl font-bold text-white mb-4">
                Ready to get your Digital ID?
            </h2>
            <p class="text-xl text-purple-100 mb-8 max-w-2xl mx-auto">
                Join over 1.2 million Sri Lankans who have already embraced the future of digital identity.
                Start your application today and experience government services like never before.
            </p>

            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                <a href="{{ route('register') }}"
                   class="inline-flex items-center px-8 py-4 bg-white text-purple-600 font-bold text-lg rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200">
                    <svg class="mr-3 h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>
                    Get Started Now
                </a>

                <a href="{{ route('card.verify.form') }}"
                   class="inline-flex items-center px-8 py-4 border-2 border-white text-white font-semibold text-lg rounded-xl hover:bg-white hover:text-purple-600 transition-all duration-200">
                    <svg class="mr-3 h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                    Verify an ID
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<footer class="bg-gray-900 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <div class="flex justify-center items-center mb-4">
                <span class="text-3xl mr-3">🇱🇰</span>
                <h3 class="text-xl font-bold">Sri Lankan Digital Identity System</h3>
            </div>
            <p class="text-gray-400 mb-4">
                Democratic Socialist Republic of Sri Lanka • Ministry of Digital Technology
            </p>
            <div class="text-sm text-gray-500">
                <p>© {{ date('Y') }} Government of Sri Lanka. All rights reserved.</p>
                <p class="mt-2">
                    🔒 Secure • 🛡️ Protected • 🌐 Accessible • ⚡ Fast
                </p>
                <p class="mt-2 text-xs">
                    Current time: {{ now()->format('F j, Y \a\t g:i A') }} UTC
                </p>
            </div>
        </div>
    </div>
</footer>
@endsection
