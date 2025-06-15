@extends('layouts.app')

@section('title', 'Register - Digital ID System')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 to-indigo-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-lg w-full space-y-8">
        <!-- Header Section -->
        <div class="text-center">
            <!-- Sri Lankan Emblem -->
            <div class="mx-auto h-20 w-20 bg-sl-maroon rounded-full flex items-center justify-center shadow-lg">
                <span class="text-sl-gold text-3xl font-bold">🇱🇰</span>
            </div>

            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                Create your account
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                Join the Digital Identity System
            </p>
            <p class="mt-1 text-center text-xs text-gray-500">
                Register to apply for your Sri Lankan digital ID
            </p>
        </div>

        <!-- Registration Form -->
        <div class="bg-white rounded-xl shadow-2xl border border-gray-200 p-8">
            <form class="space-y-6" method="POST" action="{{ route('register') }}">
                @csrf

                <!-- First Name & Last Name -->
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <!-- First Name -->
                    <div>
                        <label for="first_name" class="block text-sm font-medium text-gray-700">
                            First Name
                        </label>
                        <div class="mt-1">
                            <input id="first_name"
                                   name="first_name"
                                   type="text"
                                   required
                                   value="{{ old('first_name') }}"
                                   class="appearance-none block w-full px-3 py-3 border @error('first_name') border-red-300 @else border-gray-300 @enderror rounded-lg placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-sl-maroon focus:border-sl-maroon sm:text-sm"
                                   placeholder="First name">
                        </div>
                        @error('first_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Last Name -->
                    <div>
                        <label for="last_name" class="block text-sm font-medium text-gray-700">
                            Last Name
                        </label>
                        <div class="mt-1">
                            <input id="last_name"
                                   name="last_name"
                                   type="text"
                                   required
                                   value="{{ old('last_name') }}"
                                   class="appearance-none block w-full px-3 py-3 border @error('last_name') border-red-300 @else border-gray-300 @enderror rounded-lg placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-sl-maroon focus:border-sl-maroon sm:text-sm"
                                   placeholder="Last name">
                        </div>
                        @error('last_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Email Address -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">
                        Email Address
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

                <!-- Phone Number -->
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700">
                        Phone Number
                    </label>
                    <div class="mt-1 relative">
                        <input id="phone"
                               name="phone"
                               type="tel"
                               required
                               value="{{ old('phone') }}"
                               class="appearance-none block w-full px-3 py-3 border @error('phone') border-red-300 @else border-gray-300 @enderror rounded-lg placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-sl-maroon focus:border-sl-maroon sm:text-sm"
                               placeholder="+94 77 123 4567">

                        <!-- Phone Icon -->
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                        </div>
                    </div>
                    @error('phone')
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
                               autocomplete="new-password"
                               required
                               class="appearance-none block w-full px-3 py-3 border @error('password') border-red-300 @else border-gray-300 @enderror rounded-lg placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-sl-maroon focus:border-sl-maroon sm:text-sm"
                               placeholder="Create a strong password">

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

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">
                        Confirm Password
                    </label>
                    <div class="mt-1 relative">
                        <input id="password_confirmation"
                               name="password_confirmation"
                               type="password"
                               autocomplete="new-password"
                               required
                               class="appearance-none block w-full px-3 py-3 border border-gray-300 rounded-lg placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-sl-maroon focus:border-sl-maroon sm:text-sm"
                               placeholder="Confirm your password">

                        <!-- Confirm Icon -->
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Terms and Conditions -->
                <div class="flex items-start">
                    <div class="flex items-center h-5">
                        <input id="terms"
                               name="terms"
                               type="checkbox"
                               required
                               class="focus:ring-sl-maroon h-4 w-4 text-sl-maroon border-gray-300 rounded">
                    </div>
                    <div class="ml-3 text-sm">
                        <label for="terms" class="text-gray-700">
                            I agree to the
                            <a href="#" class="text-sl-maroon hover:text-red-700 font-medium">Terms and Conditions</a>
                            and
                            <a href="#" class="text-sl-maroon hover:text-red-700 font-medium">Privacy Policy</a>
                            of the Digital Identity System.
                        </label>
                    </div>
                </div>

                <!-- Submit Button -->
                <div>
                    <button type="submit"
                            class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-sl-maroon hover:bg-red-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sl-maroon transition-all duration-200 shadow-lg hover:shadow-xl">
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <svg class="h-5 w-5 text-red-300 group-hover:text-red-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                            </svg>
                        </span>
                        Create Account
                    </button>
                </div>

                <!-- Divider -->
                {{-- <div class="mt-6">
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300" />
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 bg-white text-gray-500">Already have an account?</span>
                        </div>
                    </div>
                </div> --}}

                <!-- Login Link -->
                <div class="text-center">
                    <a href="{{ route('login') }}"
                       class="w-full flex justify-center py-3 px-4 border border-sl-maroon text-sm font-medium rounded-lg text-sl-maroon bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sl-maroon transition-all duration-200">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                        </svg>
                        Sign in to existing account
                    </a>
                </div>
            </form>
        </div>

        <!-- Government Notice -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-blue-800">
                        Government Registration
                    </h3>
                    <div class="mt-2 text-sm text-blue-700">
                        <p>By registering, you are creating an account in the official Sri Lankan Digital Identity System. Ensure all information is accurate as it will be used for official government processes.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
