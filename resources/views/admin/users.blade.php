@extends('layouts.app')

@section('title', 'User Management - Admin')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="md:flex md:items-center md:justify-between">
                <div class="flex-1 min-w-0">
                    <h1 class="text-2xl font-bold text-gray-900">👥 User Management</h1>
                    <p class="text-gray-600">System user administration and access control</p>
                    <p class="text-sm text-gray-500">
                        Total users: {{ $users->total() ?? 0 }} • Showing: {{ $users->count() ?? 0 }} • {{ now()->format('F j, Y \a\t g:i A') }} UTC
                    </p>
                </div>
                <div class="mt-4 flex md:mt-0 md:ml-4 space-x-3">
                    <a href="{{ route('admin.users.create') }}"
                       class="bg-purple-600 text-white rounded-md px-4 py-2 text-sm font-medium hover:bg-purple-700">
                        ➕ Create New User
                    </a>
                </div>
            </div>
        </div>

        <!-- User Statistics Overview -->
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4 mb-8">
            <!-- Total Users -->
            <div class="bg-white shadow rounded-lg border-l-4 border-purple-600 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <dt class="text-sm font-medium text-gray-500">Total Users</dt>
                        <dd class="text-2xl font-bold text-purple-600">{{ $users->total() ?? 0 }}</dd>
                        <p class="text-xs text-gray-500 mt-1">All system accounts</p>
                    </div>
                </div>
            </div>

            <!-- Admin Users -->
            <div class="bg-white shadow rounded-lg border-l-4 border-red-600 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <dt class="text-sm font-medium text-gray-500">Administrators</dt>
                        <dd class="text-2xl font-bold text-red-600">{{ $users->where('role', 'admin')->count() }}</dd>
                        <p class="text-xs text-gray-500 mt-1">Supreme access</p>
                    </div>
                </div>
            </div>

            <!-- DS Officers -->
            <div class="bg-white shadow rounded-lg border-l-4 border-blue-600 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <dt class="text-sm font-medium text-gray-500">DS Officers</dt>
                        <dd class="text-2xl font-bold text-blue-600">{{ $users->where('role', 'divisional_secretariat')->count() }}</dd>
                        <p class="text-xs text-gray-500 mt-1">Final approvers</p>
                    </div>
                </div>
            </div>

            <!-- GS Officers -->
            <div class="bg-white shadow rounded-lg border-l-4 border-green-600 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <dt class="text-sm font-medium text-gray-500">GS Officers</dt>
                        <dd class="text-2xl font-bold text-green-600">{{ $users->where('role', 'grama_sevaka')->count() }}</dd>
                        <p class="text-xs text-gray-500 mt-1">Local reviewers</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- User Filtering -->
        <div class="bg-white shadow rounded-lg mb-6 p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">🔍 Filter Users</h3>
            <form method="GET" action="{{ route('admin.users') }}" class="space-y-4">
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-4">
                    <!-- Search -->
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700">Search Users</label>
                        <div class="mt-1 relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <input type="text"
                                   name="search"
                                   id="search"
                                   value="{{ request('search') }}"
                                   class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md focus:ring-purple-500 focus:border-purple-500"
                                   placeholder="Name or email...">
                        </div>
                    </div>

                    <!-- Role Filter -->
                    <div>
                        <label for="role" class="block text-sm font-medium text-gray-700">User Role</label>
                        <select name="role"
                                class="mt-1 block w-full border border-gray-300 rounded-md focus:ring-purple-500 focus:border-purple-500">
                            <option value="">All Roles</option>
                            <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Administrator</option>
                            <option value="divisional_secretariat" {{ request('role') === 'divisional_secretariat' ? 'selected' : '' }}>DS Officer</option>
                            <option value="grama_sevaka" {{ request('role') === 'grama_sevaka' ? 'selected' : '' }}>GS Officer</option>
                            <option value="applicant" {{ request('role') === 'applicant' ? 'selected' : '' }}>Applicant</option>
                        </select>
                    </div>

                    <!-- Email Verification -->
                    <div>
                        <label for="verified" class="block text-sm font-medium text-gray-700">Email Status</label>
                        <select name="verified"
                                class="mt-1 block w-full border border-gray-300 rounded-md focus:ring-purple-500 focus:border-purple-500">
                            <option value="">All Users</option>
                            <option value="verified" {{ request('verified') === 'verified' ? 'selected' : '' }}>Verified</option>
                            <option value="unverified" {{ request('verified') === 'unverified' ? 'selected' : '' }}>Unverified</option>
                        </select>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex items-end">
                        <button type="submit"
                                class="w-full bg-purple-600 text-white rounded-md px-4 py-2 text-sm font-medium hover:bg-purple-700">
                            Apply Filters
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Users Table -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900">
                    System Users
                    @if($users->total() > 0)
                        <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                            {{ $users->total() }} total
                        </span>
                    @endif
                </h2>
                <p class="text-sm text-gray-600">
                    Showing {{ $users->firstItem() ?? 0 }} to {{ $users->lastItem() ?? 0 }} of {{ $users->total() ?? 0 }} results
                </p>
            </div>

            @if($users->isNotEmpty())
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    User
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Role
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Email Status
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Office Location
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Created
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($users as $user)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <div class="h-10 w-10 bg-purple-100 rounded-full flex items-center justify-center">
                                                    <span class="text-purple-600 font-medium text-sm">
                                                        {{ substr($user->name, 0, 2) }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $user->name }}
                                                    @if($user->id === auth()->id())
                                                        <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800">
                                                            You
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    {{ $user->email }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @switch($user->role)
                                            @case('admin')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                    👑 Administrator
                                                </span>
                                                @break
                                            @case('divisional_secretariat')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    🏢 DS Officer
                                                </span>
                                                @break
                                            @case('grama_sevaka')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    🏘️ GS Officer
                                                </span>
                                                @break
                                            @case('applicant')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                    📋 Applicant
                                                </span>
                                                @break
                                            @default
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                    {{ ucfirst($user->role) }}
                                                </span>
                                        @endswitch
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($user->email_verified_at)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                <div class="h-1.5 w-1.5 bg-green-400 rounded-full mr-1.5"></div>
                                                Verified
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                <div class="h-1.5 w-1.5 bg-red-400 rounded-full mr-1.5"></div>
                                                Unverified
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $user->office_location ?? 'Not specified' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <div>{{ $user->created_at->format('M j, Y') }}</div>
                                        <div class="text-xs">{{ $user->created_at->diffForHumans() }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex items-center space-x-2">
                                            <button onclick="viewUser({{ $user->id }})"
                                                    class="text-purple-600 hover:text-purple-900 font-medium">
                                                View
                                            </button>
                                            @if($user->id !== auth()->id())
                                                <button onclick="editUser({{ $user->id }})"
                                                        class="text-blue-600 hover:text-blue-900 font-medium">
                                                    Edit
                                                </button>
                                                @if(!$user->email_verified_at)
                                                    <button onclick="verifyUser({{ $user->id }})"
                                                            class="text-green-600 hover:text-green-900 font-medium">
                                                        Verify
                                                    </button>
                                                @endif
                                            @else
                                                <span class="text-gray-400 text-xs">Current User</span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($users->hasPages())
                    <div class="bg-white px-6 py-4 border-t border-gray-200">
                        {{ $users->appends(request()->query())->links() }}
                    </div>
                @endif
            @else
                <!-- Empty State -->
                <div class="text-center py-12">
                    <div class="mx-auto h-16 w-16 bg-gray-100 rounded-full flex items-center justify-center">
                        <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <h3 class="mt-4 text-lg font-medium text-gray-900">No users found</h3>
                    <p class="mt-2 text-sm text-gray-500">
                        @if(request()->hasAny(['search', 'role', 'verified']))
                            No users match your current filters.
                        @else
                            No users have been added yet.
                        @endif
                    </p>
                    @if(request()->hasAny(['search', 'role', 'verified']))
                        <div class="mt-6">
                            <a href="{{ route('admin.users') }}"
                               class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-purple-600 bg-purple-100 hover:bg-purple-200">
                                Clear Filters
                            </a>
                        </div>
                    @endif
                </div>
            @endif
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
                    <h3 class="text-sm font-medium text-yellow-800">🔒 User Management Security</h3>
                    <div class="mt-2 text-sm text-yellow-700">
                        <ul class="list-disc pl-5 space-y-1">
                            <li>All user management actions are logged for security audit</li>
                            <li>Only administrators can create and modify user accounts</li>
                            <li>Users must verify their email addresses before system access</li>
                            <li>Role changes require additional administrator approval</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function viewUser(userId) {
    alert(`📋 Opening detailed view for user ID: ${userId}\n\nThis will show:\n• User profile details\n• Activity history\n• Permission summary\n• Security information`);
}

function editUser(userId) {
    alert(`✏️ Opening edit interface for user ID: ${userId}\n\nYou can modify:\n• Basic information\n• Role assignments\n• Office location\n• Account status`);
}

function verifyUser(userId) {
    if (confirm('✅ Are you sure you want to manually verify this user\'s email?\n\nThis will:\n• Mark email as verified\n• Grant system access\n• Send confirmation notification')) {
        alert(`User ${userId} has been manually verified by administrator.`);
    }
}
</script>
@endsection
