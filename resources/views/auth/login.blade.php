@extends('layouts.app')

@section('title', 'Sign In - Digital ID System')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 to-indigo-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <!-- Header Section -->
        <div class="text-center">
            <!-- Sri Lankan Emblem -->
            <div class="mx-auto h-20 w-20 bg-sl-maroon rounded-full flex items-center justify-center shadow-lg">
                <span class="text-sl-gold text-3xl font-bold">🇱🇰</span>
            </div>

            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                Sign in to your account
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                Digital Identity System - Government of Sri Lanka
            </p>
            <p class="mt-1 text-center text-xs text-gray-500">
                Access your digital ID application and services
            </p>
        </div>

        <!-- Login Form -->
        <div class="bg-white rounded-xl shadow-2xl border border-gray-200 p-8">
            <form class="space-y-6" method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">
                        Email address
                    </label>
                    <div class="mt-1 relative">
                        <input id="email"
                               name="email"
                               type="email"
                               autocomplete="email"
                               required
                               value="{{ old('email') }}"
                               class="appearance-none block w-full px-3 py-3 border @error('email') border-red-300 @else border-gray-300 @enderror rounded-lg placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-sl-maroon focus:border-sl-maroon sm:text-sm"
                               placeholder="Enter your email address">

                        <!-- Email Icon -->
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                    </div>
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">
                        Password
                    </label>
                    <div class="mt-1 relative">
                        <input id="password"
                               name="password"
                               type="password"
                               autocomplete="current-password"
                               required
                               class="appearance-none block w-full px-3 py-3 border @error('password') border-red-300 @else border-gray-300 @enderror rounded-lg placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-sl-maroon focus:border-sl-maroon sm:text-sm"
                               placeholder="Enter your password">

                        <!-- Password Icon -->
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                    </div>
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember"
                               name="remember"
                               type="checkbox"
                               class="h-4 w-4 text-sl-maroon focus:ring-sl-maroon border-gray-300 rounded">
                        <label for="remember" class="ml-2 block text-sm text-gray-700">
                            Remember me
                        </label>
                    </div>

                    <div class="text-sm">
                        <a href="#" class="font-medium text-sl-maroon hover:text-red-700 transition-colors">
                            Forgot your password?
                        </a>
                    </div>
                </div>

                <!-- Submit Button -->
                <div>
                    <button type="submit"
                            class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-sl-maroon hover:bg-red-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sl-maroon transition-all duration-200 shadow-lg hover:shadow-xl">
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <svg class="h-5 w-5 text-red-300 group-hover:text-red-200" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                            </svg>
                        </span>
                        Sign in to Digital ID System
                    </button>
                </div>

                <!-- Divider -->
                {{-- <div class="mt-6">
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300" />
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 bg-white text-gray-500">Don't have an account?</span>
                        </div>
                    </div>
                </div> --}}

                <!-- Register Link -->
                <div class="text-center">
                    <a href="{{ route('register') }}"
                       class="w-full flex justify-center py-3 px-4 border border-sl-maroon text-sm font-medium rounded-lg text-sl-maroon bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sl-maroon transition-all duration-200">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                        </svg>
                        Create new account
                    </a>
                </div>
            </form>
        </div>

        <!-- Security Notice -->
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-yellow-800">
                        Security Notice
                    </h3>
                    <div class="mt-2 text-sm text-yellow-700">
                        <p>This is a secure government portal. Never share your login credentials with anyone. Always ensure you are on the official government website.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
