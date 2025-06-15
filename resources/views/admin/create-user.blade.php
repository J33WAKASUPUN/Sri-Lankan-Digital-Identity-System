@extends('layouts.app')

@section('title', 'Create New User - Admin')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="md:flex md:items-center md:justify-between">
                <div class="flex-1 min-w-0">
                    <h1 class="text-2xl font-bold text-gray-900">➕ Create New User</h1>
                    <p class="text-gray-600">Add a new user to the Digital ID system</p>
                    <p class="text-sm text-gray-500">
                        All users will receive email verification • Current time: {{ now()->format('F j, Y \a\t g:i A') }} UTC
                    </p>
                </div>
                <div class="mt-4 flex md:mt-0 md:ml-4">
                    <a href="{{ route('admin.users') }}"
                       class="bg-gray-600 text-white rounded-md px-4 py-2 text-sm font-medium hover:bg-gray-700">
                        ← Back to Users
                    </a>
                </div>
            </div>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-green-800">✅ Success!</h3>
                        <div class="mt-2 text-sm text-green-700">
                            {{ session('success') }}
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- User Creation Form -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900">User Information</h2>
                <p class="text-sm text-gray-600">Enter the details for the new user account</p>
            </div>

            <form method="POST" action="{{ route('admin.users.store') }}" class="px-6 py-6 space-y-6">
                @csrf

                <!-- Basic Information -->
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <!-- Full Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">
                            Full Name <span class="text-red-500">*</span>
                        </label>
                        <div class="mt-1">
                            <input type="text"
                                   name="name"
                                   id="name"
                                   value="{{ old('name') }}"
                                   required
                                   class="block w-full border border-gray-300 rounded-md px-3 py-2 placeholder-gray-400 focus:ring-purple-500 focus:border-purple-500 @error('name') border-red-300 @enderror"
                                   placeholder="Enter full name">
                        </div>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email Address -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">
                            Email Address <span class="text-red-500">*</span>
                        </label>
                        <div class="mt-1">
                            <input type="email"
                                   name="email"
                                   id="email"
                                   value="{{ old('email') }}"
                                   required
                                   class="block w-full border border-gray-300 rounded-md px-3 py-2 placeholder-gray-400 focus:ring-purple-500 focus:border-purple-500 @error('email') border-red-300 @enderror"
                                   placeholder="user@example.com">
                        </div>
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Password -->
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">
                            Password <span class="text-red-500">*</span>
                        </label>
                        <div class="mt-1">
                            <input type="password"
                                   name="password"
                                   id="password"
                                   required
                                   class="block w-full border border-gray-300 rounded-md px-3 py-2 placeholder-gray-400 focus:ring-purple-500 focus:border-purple-500 @error('password') border-red-300 @enderror"
                                   placeholder="Minimum 8 characters">
                        </div>
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Password must be at least 8 characters long</p>
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">
                            Confirm Password <span class="text-red-500">*</span>
                        </label>
                        <div class="mt-1">
                            <input type="password"
                                   name="password_confirmation"
                                   id="password_confirmation"
                                   required
                                   class="block w-full border border-gray-300 rounded-md px-3 py-2 placeholder-gray-400 focus:ring-purple-500 focus:border-purple-500"
                                   placeholder="Repeat password">
                        </div>
                    </div>
                </div>

                <!-- Role Selection -->
                <div>
                    <label for="role" class="block text-sm font-medium text-gray-700">
                        User Role <span class="text-red-500">*</span>
                    </label>
                    <div class="mt-1">
                        <select name="role"
                                id="role"
                                required
                                onchange="toggleOfficeLocation()"
                                class="block w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-purple-500 focus:border-purple-500 @error('role') border-red-300 @enderror">
                            <option value="">Select a role</option>
                            <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>👑 Administrator</option>
                            <option value="divisional_secretariat" {{ old('role') === 'divisional_secretariat' ? 'selected' : '' }}>🏢 DS Officer</option>
                            <option value="grama_sevaka" {{ old('role') === 'grama_sevaka' ? 'selected' : '' }}>🏘️ GS Officer</option>
                            <option value="applicant" {{ old('role') === 'applicant' ? 'selected' : '' }}>📋 Applicant</option>
                        </select>
                    </div>
                    @error('role')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Office Location (conditionally shown) -->
                <div id="office-location-section" style="display: none;">
                    <label for="office_location" class="block text-sm font-medium text-gray-700">
                        Office Location <span class="text-red-500">*</span>
                    </label>
                    <div class="mt-1">
                        <input type="text"
                               name="office_location"
                               id="office_location"
                               value="{{ old('office_location') }}"
                               class="block w-full border border-gray-300 rounded-md px-3 py-2 placeholder-gray-400 focus:ring-purple-500 focus:border-purple-500 @error('office_location') border-red-300 @enderror"
                               placeholder="e.g., Colombo DS Office, Kandy GS Division">
                    </div>
                    @error('office_location')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Required for DS and GS officers</p>
                </div>

                <!-- Role Information -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <h4 class="text-sm font-medium text-blue-800 mb-2">🔐 Role Permissions:</h4>
                    <div class="text-sm text-blue-700 space-y-1">
                        <div id="role-info">
                            <p class="text-gray-600">Select a role to see permissions</p>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                    <div class="flex items-center">
                        <input type="checkbox"
                               name="send_welcome_email"
                               id="send_welcome_email"
                               checked
                               class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                        <label for="send_welcome_email" class="ml-2 block text-sm text-gray-700">
                            Send welcome email with login instructions
                        </label>
                    </div>
                    <div class="flex space-x-3">
                        <a href="{{ route('admin.users') }}"
                           class="bg-gray-300 text-gray-700 rounded-md px-4 py-2 text-sm font-medium hover:bg-gray-400">
                            Cancel
                        </a>
                        <button type="submit"
                                class="bg-purple-600 text-white rounded-md px-4 py-2 text-sm font-medium hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                            ➕ Create User
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Security Notice -->
        <div class="mt-8 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-yellow-800">🔒 User Creation Security</h3>
                    <div class="mt-2 text-sm text-yellow-700">
                        <ul class="list-disc pl-5 space-y-1">
                            <li>All new users are automatically marked as email verified by admin</li>
                            <li>Users will receive login credentials via secure email</li>
                            <li>Passwords must be changed on first login</li>
                            <li>User creation actions are logged for audit</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function toggleOfficeLocation() {
    const roleSelect = document.getElementById('role');
    const officeSection = document.getElementById('office-location-section');
    const officeInput = document.getElementById('office_location');
    const roleInfo = document.getElementById('role-info');

    const role = roleSelect.value;

    // Show/hide office location field
    if (role === 'divisional_secretariat' || role === 'grama_sevaka') {
        officeSection.style.display = 'block';
        officeInput.setAttribute('required', 'required');
    } else {
        officeSection.style.display = 'none';
        officeInput.removeAttribute('required');
    }

    // Update role information
    let roleDescription = '';
    switch(role) {
        case 'admin':
            roleDescription = '• Full system access<br>• User management<br>• System configuration<br>• All administrative functions';
            break;
        case 'divisional_secretariat':
            roleDescription = '• Final approval authority<br>• Review GS approvals<br>• Issue digital cards<br>• Generate reports';
            break;
        case 'grama_sevaka':
            roleDescription = '• Local review authority<br>• Initial verification<br>• Document validation<br>• Forward to DS';
            break;
        case 'applicant':
            roleDescription = '• Submit applications<br>• View application status<br>• Download digital cards<br>• Basic profile management';
            break;
        default:
            roleDescription = 'Select a role to see permissions';
    }

    roleInfo.innerHTML = roleDescription;
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    toggleOfficeLocation();
});
</script>
@endsection
