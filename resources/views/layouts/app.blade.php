<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-gray-50">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Digital ID System - Sri Lanka')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="h-full font-sans antialiased">
    <div id="app" class="min-h-full">
        <!-- Government Header -->
        <header class="bg-gradient-to-r from-purple-900 to-indigo-900 shadow-lg border-b-4 border-yellow-400">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <!-- Logo and Title - Clickable Home Link -->
                    <div class="flex items-center">
                        <a href="{{ route('home') }}"
                            class="flex-shrink-0 flex items-center hover:opacity-80 transition-opacity duration-200">
                            <!-- Sri Lankan Flag Emblem -->
                            <div
                                class="w-10 h-10 bg-gradient-to-br from-yellow-400 to-yellow-500 rounded-full flex items-center justify-center shadow-lg">
                                <span class="text-purple-900 font-bold text-xl">🇱🇰</span>
                            </div>
                            <div class="ml-3">
                                <h1 class="text-white text-lg font-bold">
                                    Digital Identity System
                                </h1>
                                <p class="text-yellow-200 text-xs">
                                    Government of Sri Lanka
                                </p>
                            </div>
                        </a>
                    </div>

                    <!-- Navigation -->
                    <nav class="hidden md:flex space-x-6">
                        @auth
                            <!-- Dashboard Link - Dynamic based on role -->
                            @if (auth()->user()->role === 'applicant')
                                <a href="{{ route('applicant.dashboard') }}"
                                    class="text-yellow-200 hover:text-white px-3 py-2 text-sm font-medium transition-colors duration-200">
                                    📊 Dashboard
                                </a>
                                <a href="{{ route('applications.create') }}"
                                    class="text-yellow-200 hover:text-white px-3 py-2 text-sm font-medium transition-colors duration-200">
                                    📝 Apply for ID
                                </a>
                            @elseif(auth()->user()->role === 'grama_sevaka')
                                <a href="{{ route('gs.dashboard') }}"
                                    class="text-yellow-200 hover:text-white px-3 py-2 text-sm font-medium transition-colors duration-200">
                                    🏘️ GS Dashboard
                                </a>
                                <a href="{{ route('gs.applications') }}"
                                    class="text-yellow-200 hover:text-white px-3 py-2 text-sm font-medium transition-colors duration-200">
                                    📋 Review Applications
                                </a>
                            @elseif(auth()->user()->role === 'divisional_secretariat')
                                <a href="{{ route('ds.dashboard') }}"
                                    class="text-yellow-200 hover:text-white px-3 py-2 text-sm font-medium transition-colors duration-200">
                                    🏢 DS Dashboard
                                </a>
                                <a href="{{ route('ds.applications') }}"
                                    class="text-yellow-200 hover:text-white px-3 py-2 text-sm font-medium transition-colors duration-200">
                                    📋 Final Approval
                                </a>
                            @elseif(auth()->user()->role === 'admin')
                                <a href="{{ route('admin.dashboard') }}"
                                    class="text-yellow-200 hover:text-white px-3 py-2 text-sm font-medium transition-colors duration-200">
                                    👑 Admin Dashboard
                                </a>
                                <a href="{{ route('admin.applications') }}"
                                    class="text-yellow-200 hover:text-white px-3 py-2 text-sm font-medium transition-colors duration-200">
                                    🏢 Manage System
                                </a>
                                <a href="{{ route('admin.users') }}"
                                    class="text-yellow-200 hover:text-white px-3 py-2 text-sm font-medium transition-colors duration-200">
                                    👥 Manage Users
                                </a>
                            @endif

                            <!-- Verify Card Link (for all users) -->
                            <a href="{{ route('card.verify.form') }}"
                                class="text-yellow-200 hover:text-white px-3 py-2 text-sm font-medium transition-colors duration-200">
                                🔍 Verify ID
                            </a>

                            <!-- Notifications -->
                            <a href="{{ route('notifications.index') }}"
                                class="text-yellow-200 hover:text-white px-3 py-2 text-sm font-medium relative transition-colors duration-200">
                                🔔 Notifications
                                @if (auth()->user()->unreadNotifications->count() > 0)
                                    <span
                                        class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center animate-pulse">
                                        {{ auth()->user()->unreadNotifications->count() }}
                                    </span>
                                @endif
                            </a>
                        @else
                            <!-- Public navigation for guests -->
                            <a href="{{ route('card.verify.form') }}"
                                class="text-yellow-200 hover:text-white px-3 py-2 text-sm font-medium transition-colors duration-200">
                                🔍 Verify ID
                            </a>
                        @endauth
                    </nav>

                    <!-- User Menu -->
                    <div class="flex items-center space-x-4">
                        @auth
                            <!-- User Info & Logout -->
                            <div class="flex items-center space-x-3">
                                <!-- User Avatar -->
                                <div class="flex items-center space-x-2">
                                    <div
                                        class="h-8 w-8 rounded-full bg-gradient-to-br from-yellow-400 to-yellow-500 flex items-center justify-center shadow-lg">
                                        <span class="text-purple-900 font-bold text-sm">
                                            {{ substr(auth()->user()->name, 0, 2) }}
                                        </span>
                                    </div>
                                    <div class="hidden sm:block">
                                        <div class="text-white text-sm font-medium">{{ auth()->user()->name }}</div>
                                        <div class="text-yellow-200 text-xs">
                                            @switch(auth()->user()->role)
                                                @case('admin')
                                                    👑 Administrator
                                                @break

                                                @case('divisional_secretariat')
                                                    🏢 DS Officer
                                                @break

                                                @case('grama_sevaka')
                                                    🏘️ GS Officer
                                                @break

                                                @case('applicant')
                                                    📋 Applicant
                                                @break

                                                @default
                                                    User
                                            @endswitch
                                        </div>
                                    </div>
                                </div>

                                <!-- Logout Button -->
                                <form method="POST" action="{{ route('logout') }}" class="inline">
                                    @csrf
                                    <button type="submit"
                                        class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 flex items-center space-x-2 shadow-lg hover:shadow-xl"
                                        onclick="return confirm('Are you sure you want to logout?')">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                        </svg>
                                        <span class="hidden sm:inline">Logout</span>
                                    </button>
                                </form>
                            </div>
                        @else
                            <!-- Guest navigation -->
                            <div class="flex space-x-3">
                                <a href="{{ route('login') }}"
                                    class="text-yellow-200 hover:text-white px-4 py-2 text-sm font-medium transition-colors duration-200">
                                    🔑 Sign In
                                </a>
                                <a href="{{ route('register') }}"
                                    class="bg-gradient-to-r from-yellow-400 to-yellow-500 text-purple-900 hover:from-yellow-500 hover:to-yellow-600 px-4 py-2 rounded-lg text-sm font-bold transition-all duration-200 shadow-lg hover:shadow-xl">
                                    📝 Register
                                </a>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>

            <!-- Mobile Navigation -->
            <div class="md:hidden" id="mobile-menu" style="display: none;">
                <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3 border-t border-purple-700">
                    @auth
                        @if (auth()->user()->role === 'applicant')
                            <a href="{{ route('applicant.dashboard') }}"
                                class="text-yellow-200 hover:text-white block px-3 py-2 text-base font-medium">📊
                                Dashboard</a>
                            <a href="{{ route('applications.create') }}"
                                class="text-yellow-200 hover:text-white block px-3 py-2 text-base font-medium">📝 Apply for
                                ID</a>
                        @elseif(auth()->user()->role === 'grama_sevaka')
                            <a href="{{ route('gs.dashboard') }}"
                                class="text-yellow-200 hover:text-white block px-3 py-2 text-base font-medium">🏘️ GS
                                Dashboard</a>
                            <a href="{{ route('gs.applications') }}"
                                class="text-yellow-200 hover:text-white block px-3 py-2 text-base font-medium">📋
                                Applications</a>
                        @elseif(auth()->user()->role === 'divisional_secretariat')
                            <a href="{{ route('ds.dashboard') }}"
                                class="text-yellow-200 hover:text-white block px-3 py-2 text-base font-medium">🏢 DS
                                Dashboard</a>
                            <a href="{{ route('ds.applications') }}"
                                class="text-yellow-200 hover:text-white block px-3 py-2 text-base font-medium">📋
                                Applications</a>
                        @elseif(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}"
                                class="text-yellow-200 hover:text-white block px-3 py-2 text-base font-medium">👑 Admin
                                Dashboard</a>
                            <a href="{{ route('admin.applications') }}"
                                class="text-yellow-200 hover:text-white block px-3 py-2 text-base font-medium">🏢 System</a>
                            <a href="{{ route('admin.users') }}"
                                class="text-yellow-200 hover:text-white block px-3 py-2 text-base font-medium">👥 Users</a>
                        @endif
                        <a href="{{ route('card.verify.form') }}"
                            class="text-yellow-200 hover:text-white block px-3 py-2 text-base font-medium">🔍 Verify ID</a>
                        <a href="{{ route('notifications.index') }}"
                            class="text-yellow-200 hover:text-white block px-3 py-2 text-base font-medium">🔔
                            Notifications</a>
                    @else
                        <a href="{{ route('card.verify.form') }}"
                            class="text-yellow-200 hover:text-white block px-3 py-2 text-base font-medium">🔍 Verify ID</a>
                        <a href="{{ route('login') }}"
                            class="text-yellow-200 hover:text-white block px-3 py-2 text-base font-medium">🔑 Sign In</a>
                        <a href="{{ route('register') }}"
                            class="text-yellow-200 hover:text-white block px-3 py-2 text-base font-medium">📝 Register</a>
                    @endauth
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-1">
            <!-- Flash Messages -->
            @if (session('success'))
                <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-6 mx-4 sm:mx-6 lg:mx-8 mt-4 rounded-r-lg">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800">✅ {{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6 mx-4 sm:mx-6 lg:mx-8 mt-4 rounded-r-lg">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-red-800">❌ {{ session('error') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if (session('info'))
                <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-6 mx-4 sm:mx-6 lg:mx-8 mt-4 rounded-r-lg">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-blue-800">ℹ️ {{ session('info') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Page Content -->
            @yield('content')
        </main>

        <!-- Government Footer -->
        <footer class="bg-gray-900 text-white">
            <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div>
                        <div class="flex items-center mb-4">
                            <span class="text-2xl mr-2">🇱🇰</span>
                            <h3 class="text-lg font-bold">Digital Identity System</h3>
                        </div>
                        <p class="text-gray-300 text-sm leading-relaxed">
                            Secure and efficient digital identity management for citizens of Sri Lanka.
                            Building a digital future with trusted government services.
                        </p>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold mb-4">🔗 Quick Links</h3>
                        <ul class="space-y-2 text-sm">
                            <li><a href="{{ route('register') }}"
                                    class="text-gray-300 hover:text-white transition-colors duration-200">📝 Apply for
                                    Digital ID</a></li>
                            <li><a href="{{ route('card.verify.form') }}"
                                    class="text-gray-300 hover:text-white transition-colors duration-200">🔍 Verify ID
                                    Card</a></li>
                            <li><a href="{{ route('home') }}"
                                    class="text-gray-300 hover:text-white transition-colors duration-200">🏠 Home</a>
                            </li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold mb-4">🏛️ Government of Sri Lanka</h3>
                        <div class="text-gray-300 text-sm space-y-1">
                            <p>Ministry of Digital Technology</p>
                            <p>Colombo, Sri Lanka</p>
                            <p class="mt-4">© {{ date('Y') }} All rights reserved.</p>
                            <p class="text-xs text-gray-400 mt-2">
                                Current time: {{ now()->format('F j, Y \a\t g:i A') }} UTC
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <!-- JavaScript -->
    <script>
        // Auto-hide flash messages after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const flashMessages = document.querySelectorAll(
                '[class*="bg-green-50"], [class*="bg-red-50"], [class*="bg-blue-50"]');

            flashMessages.forEach(function(message) {
                setTimeout(function() {
                    message.style.transition = 'opacity 0.5s ease-out';
                    message.style.opacity = '0';
                    setTimeout(function() {
                        message.remove();
                    }, 500);
                }, 5000);
            });

            // Mobile menu toggle (if needed)
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');

            if (mobileMenuButton && mobileMenu) {
                mobileMenuButton.addEventListener('click', function() {
                    mobileMenu.style.display = mobileMenu.style.display === 'none' ? 'block' : 'none';
                });
            }
        });
    </script>

    <script>
        // In app.blade.php JavaScript:
        const flashMessages = document.querySelectorAll(
            '[class*="bg-green-50"], [class*="bg-red-50"], [class*="bg-blue-50"]');

        flashMessages.forEach(function(message) {
            // Skip elements with permanent-content class
            if (!message.classList.contains('permanent-content') && !message.closest('.permanent-content')) {
                setTimeout(function() {
                    message.style.transition = 'opacity 0.5s ease-out';
                    message.style.opacity = '0';
                    setTimeout(function() {
                        message.remove();
                    }, 500);
                }, 5000);
            }
        });
    </script>
</body>

</html>
