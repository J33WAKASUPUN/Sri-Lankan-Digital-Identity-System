@extends('layouts.app')

@section('title', 'Verify Email - Digital ID System')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 to-indigo-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <!-- Header Section -->
        <div class="text-center">
            <!-- Sri Lankan Emblem -->
            <div class="mx-auto h-20 w-20 bg-sl-maroon rounded-full flex items-center justify-center shadow-lg">
                <span class="text-sl-gold text-3xl font-bold">📧</span>
            </div>

            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                Verify your email
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                Digital Identity System - Government of Sri Lanka
            </p>
        </div>

        <!-- Verification Card -->
        <div class="bg-white rounded-xl shadow-2xl border border-gray-200 p-8">
            @if (session('status') == 'verification-link-sent')
                <!-- Success Message -->
                <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-green-800">Email sent successfully!</h3>
                            <div class="mt-2 text-sm text-green-700">
                                <p>A new verification link has been sent to your email address.</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Main Content -->
            <div class="text-center space-y-4">
                <!-- Email Icon -->
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-blue-100">
                    <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 19v-8.93a2 2 0 01.89-1.664l7-4.666a2 2 0 012.22 0l7 4.666A2 2 0 0121 10.07V19M3 19a2 2 0 002 2h14a2 2 0 002-2M3 19l6.75-4.5M21 19l-6.75-4.5M12 12l-6.75-4.5M12 12l6.75-4.5" />
                    </svg>
                </div>

                <h3 class="text-lg font-medium text-gray-900">Check your email</h3>

                <div class="space-y-3 text-sm text-gray-600">
                    <p>We've sent a verification link to:</p>
                    <p class="font-semibold text-sl-maroon bg-gray-50 py-2 px-4 rounded-lg">
                        {{ auth()->user()->email ?? 'your email address' }}
                    </p>
                    <p>Click the link in your email to verify your account and continue with your digital ID application.</p>
                </div>

                <!-- Instructions -->
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mt-6">
                    <div class="text-sm text-yellow-800">
                        <h4 class="font-medium mb-2">Can't find the email?</h4>
                        <ul class="space-y-1 text-left list-disc list-inside">
                            <li>Check your spam or junk folder</li>
                            <li>Make sure you entered the correct email address</li>
                            <li>Wait a few minutes for the email to arrive</li>
                            <li>Click the button below to resend the verification email</li>
                        </ul>
                    </div>
                </div>

                <!-- Resend Button -->
                <form method="POST" action="{{ route('verification.send') }}" class="mt-6">
                    @csrf
                    <button type="submit"
                            class="w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-sl-maroon hover:bg-red-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sl-maroon transition-all duration-200 shadow-lg hover:shadow-xl">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        Resend verification email
                    </button>
                </form>

                <!-- Back to Login -->
                <div class="mt-4">
                    <a href="{{ route('login') }}"
                       class="text-sm text-sl-maroon hover:text-red-700 font-medium">
                        ← Back to login
                    </a>
                </div>
            </div>
        </div>

        <!-- Help Section -->
        <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
            <div class="text-center">
                <h4 class="text-sm font-medium text-gray-900 mb-2">Need help?</h4>
                <p class="text-xs text-gray-600 mb-3">
                    If you continue to have issues with email verification, please contact our support team.
                </p>
                <a href="#" class="text-xs text-sl-maroon hover:text-red-700 font-medium">
                    Contact Digital ID Support →
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
