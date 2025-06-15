@extends('layouts.app')

@section('title', 'Apply for Digital ID - Digital ID System')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="mx-auto h-16 w-16 bg-red-600 rounded-full flex items-center justify-center shadow-lg">
                <span class="text-yellow-300 text-2xl font-bold">🇱🇰</span>
            </div>
            <h1 class="mt-4 text-3xl font-bold text-gray-900">Apply for Digital ID</h1>
            <p class="mt-2 text-lg text-gray-600">Government of Sri Lanka - Digital Identity System</p>
            <p class="mt-1 text-sm text-gray-500">
                Please fill out all required information accurately. All fields marked with * are mandatory.
            </p>
        </div>

        <!-- Simple Progress -->
        <div class="mb-8">
            <div class="bg-white rounded shadow p-4">
                <div class="flex justify-between text-sm mb-2">
                    <span class="font-medium text-red-600">Step 1: Personal Information</span>
                    <span class="text-gray-500">Application Form</span>
                </div>
                <div class="w-full bg-gray-200 rounded h-2">
                    <div class="bg-red-600 h-2 rounded" style="width: 100%"></div>
                </div>
            </div>
        </div>

        <!-- Application Form -->
        <div class="bg-white shadow rounded overflow-hidden">
            <div class="bg-red-600 px-6 py-4">
                <h2 class="text-xl font-bold text-white">Digital ID Application Form</h2>
                <p class="text-yellow-200 text-sm">Fill out your personal information and upload required documents</p>
            </div>

            <form method="POST" action="{{ route('applications.store') }}" enctype="multipart/form-data" class="p-6 space-y-6">
                @csrf

                <!-- Personal Information Section -->
                <div class="border-b border-gray-200 pb-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Personal Information</h3>

                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <!-- First Name -->
                        <div>
                            <label for="first_name" class="block text-sm font-medium text-gray-700">
                                First Name *
                            </label>
                            <div class="mt-1">
                                <input type="text"
                                       id="first_name"
                                       name="first_name"
                                       required
                                       value="{{ old('first_name') }}"
                                       class="block w-full border-gray-300 rounded shadow-sm focus:ring-red-500 focus:border-red-500 @error('first_name') border-red-300 @enderror"
                                       placeholder="Enter your first name">
                            </div>
                            @error('first_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Last Name -->
                        <div>
                            <label for="last_name" class="block text-sm font-medium text-gray-700">
                                Last Name *
                            </label>
                            <div class="mt-1">
                                <input type="text"
                                       id="last_name"
                                       name="last_name"
                                       required
                                       value="{{ old('last_name') }}"
                                       class="block w-full border-gray-300 rounded shadow-sm focus:ring-red-500 focus:border-red-500 @error('last_name') border-red-300 @enderror"
                                       placeholder="Enter your last name">
                            </div>
                            @error('last_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Date of Birth -->
                        <div>
                            <label for="date_of_birth" class="block text-sm font-medium text-gray-700">
                                Date of Birth *
                            </label>
                            <div class="mt-1">
                                <input type="date"
                                       id="date_of_birth"
                                       name="date_of_birth"
                                       required
                                       value="{{ old('date_of_birth') }}"
                                       max="{{ date('Y-m-d', strtotime('-18 years')) }}"
                                       class="block w-full border-gray-300 rounded shadow-sm focus:ring-red-500 focus:border-red-500 @error('date_of_birth') border-red-300 @enderror">
                            </div>
                            @error('date_of_birth')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">You must be at least 18 years old to apply</p>
                        </div>

                        <!-- Gender -->
                        <div>
                            <label for="gender" class="block text-sm font-medium text-gray-700">
                                Gender *
                            </label>
                            <div class="mt-1">
                                <select id="gender"
                                        name="gender"
                                        required
                                        class="block w-full border-gray-300 rounded shadow-sm focus:ring-red-500 focus:border-red-500 @error('gender') border-red-300 @enderror">
                                    <option value="">Select Gender</option>
                                    <option value="male" {{ old('gender') === 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ old('gender') === 'female' ? 'selected' : '' }}>Female</option>
                                </select>
                            </div>
                            @error('gender')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Nationality -->
                        <div>
                            <label for="nationality" class="block text-sm font-medium text-gray-700">
                                Nationality *
                            </label>
                            <div class="mt-1">
                                <select id="nationality"
                                        name="nationality"
                                        required
                                        class="block w-full border-gray-300 rounded shadow-sm focus:ring-red-500 focus:border-red-500 @error('nationality') border-red-300 @enderror">
                                    <option value="">Select Nationality</option>
                                    <option value="Sri Lankan" {{ old('nationality') === 'Sri Lankan' ? 'selected' : '' }}>Sri Lankan</option>
                                    <option value="Other" {{ old('nationality') === 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>
                            @error('nationality')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Phone Number -->
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700">
                                Phone Number *
                            </label>
                            <div class="mt-1">
                                <input type="tel"
                                       id="phone"
                                       name="phone"
                                       required
                                       value="{{ old('phone') }}"
                                       class="block w-full border-gray-300 rounded shadow-sm focus:ring-red-500 focus:border-red-500 @error('phone') border-red-300 @enderror"
                                       placeholder="+94 77 123 4567">
                            </div>
                            @error('phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Address -->
                    <div class="mt-6">
                        <label for="address" class="block text-sm font-medium text-gray-700">
                            Residential Address *
                        </label>
                        <div class="mt-1">
                            <textarea id="address"
                                      name="address"
                                      rows="3"
                                      required
                                      class="block w-full border-gray-300 rounded shadow-sm focus:ring-red-500 focus:border-red-500 @error('address') border-red-300 @enderror"
                                      placeholder="Enter your complete residential address">{{ old('address') }}</textarea>
                        </div>
                        @error('address')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Document Upload Section -->
                <div class="border-b border-gray-200 pb-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Required Documents</h3>

                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <!-- Birth Certificate -->
                        <div>
                            <label for="birth_certificate" class="block text-sm font-medium text-gray-700">
                                Birth Certificate *
                            </label>
                            <div class="mt-1">
                                <input type="file"
                                       id="birth_certificate"
                                       name="birth_certificate"
                                       required
                                       accept=".pdf,.jpg,.jpeg,.png"
                                       class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-medium file:bg-red-600 file:text-white hover:file:bg-red-700 @error('birth_certificate') border-red-300 @enderror">
                            </div>
                            @error('birth_certificate')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">PDF, JPG, JPEG, PNG (Max: 2MB)</p>
                        </div>

                        <!-- Photo -->
                        <div>
                            <label for="photo" class="block text-sm font-medium text-gray-700">
                                Passport Photo *
                            </label>
                            <div class="mt-1">
                                <input type="file"
                                       id="photo"
                                       name="photo"
                                       required
                                       accept=".jpg,.jpeg,.png"
                                       class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-medium file:bg-red-600 file:text-white hover:file:bg-red-700 @error('photo') border-red-300 @enderror">
                            </div>
                            @error('photo')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">JPG, JPEG, PNG (Max: 1MB)</p>
                        </div>
                    </div>

                    <!-- Document Requirements -->
                    <div class="mt-6 bg-blue-50 border border-blue-200 rounded p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h4 class="text-sm font-medium text-blue-800">Document Requirements</h4>
                                <div class="mt-2 text-sm text-blue-700">
                                    <ul class="space-y-1">
                                        <li>• Birth certificate must be issued by Government Registrar</li>
                                        <li>• Photo must be recent (taken within last 6 months)</li>
                                        <li>• Photo should be passport-size with white background</li>
                                        <li>• All documents must be clear and legible</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Terms and Conditions -->
                <div class="border-b border-gray-200 pb-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Terms and Conditions</h3>

                    <div class="bg-gray-50 border border-gray-200 rounded p-4 max-h-40 overflow-y-auto">
                        <div class="text-sm text-gray-700 space-y-3">
                            <p><strong>Digital Identity System Terms of Service</strong></p>
                            <p>By submitting this application, you agree to the following terms:</p>
                            <ul class="space-y-1 list-disc list-inside">
                                <li>All information provided is true and accurate to the best of your knowledge</li>
                                <li>You authorize verification of the information with relevant government departments</li>
                                <li>False information may result in rejection of your application</li>
                                <li>Your personal data will be processed in accordance with Sri Lankan data protection laws</li>
                                <li>The government reserves the right to request additional documentation</li>
                                <li>Processing times may vary based on verification requirements</li>
                            </ul>
                        </div>
                    </div>

                    <div class="mt-4 flex items-start">
                        <div class="flex items-center h-5">
                            <input id="terms"
                                   name="terms"
                                   type="checkbox"
                                   required
                                   value="1"
                                   class="focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300 rounded">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="terms" class="text-gray-700">
                                I have read and agree to the
                                <a href="#" class="text-red-600 hover:text-red-700 font-medium">Terms and Conditions</a>
                                and
                                <a href="#" class="text-red-600 hover:text-red-700 font-medium">Privacy Policy</a>
                                of the Digital Identity System. *
                            </label>
                        </div>
                    </div>
                    @error('terms')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Declaration -->
                <div class="bg-yellow-50 border border-yellow-200 rounded p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h4 class="text-sm font-medium text-yellow-800">Declaration</h4>
                            <div class="mt-2 text-sm text-yellow-700">
                                <p>I declare that all information provided in this application is true, complete, and accurate. I understand that providing false or misleading information is an offense and may result in legal action.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex items-center justify-between pt-6">
                    <a href="{{ url('/dashboard') }}"
                       class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded text-gray-700 bg-white hover:bg-gray-50">
                        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Back to Dashboard
                    </a>

                    <button type="submit"
                            class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded text-white bg-red-600 hover:bg-red-700 shadow hover:shadow-lg transition-all duration-200">
                        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                        </svg>
                        Submit Application
                    </button>
                </div>
            </form>
        </div>

        <!-- Help Section -->
        <div class="mt-8 bg-white rounded shadow p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Need Help?</h3>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                <div class="text-center">
                    <div class="mx-auto h-8 w-8 bg-blue-100 rounded-full flex items-center justify-center">
                        <svg class="h-5 w-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h4 class="mt-2 text-sm font-medium text-gray-900">FAQ</h4>
                    <p class="mt-1 text-sm text-gray-500">Common questions and answers</p>
                </div>
                <div class="text-center">
                    <div class="mx-auto h-8 w-8 bg-green-100 rounded-full flex items-center justify-center">
                        <svg class="h-5 w-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                    </div>
                    <h4 class="mt-2 text-sm font-medium text-gray-900">Support</h4>
                    <p class="mt-1 text-sm text-gray-500">📞 +94 11 123 4567</p>
                </div>
                <div class="text-center">
                    <div class="mx-auto h-8 w-8 bg-purple-100 rounded-full flex items-center justify-center">
                        <svg class="h-5 w-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <h4 class="mt-2 text-sm font-medium text-gray-900">Email</h4>
                    <p class="mt-1 text-sm text-gray-500">support@digitalid.gov.lk</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
