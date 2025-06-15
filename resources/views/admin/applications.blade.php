@extends('layouts.app')

@section('title', 'Application Management - Admin')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="md:flex md:items-center md:justify-between">
                <div class="flex-1 min-w-0">
                    <h1 class="text-2xl font-bold text-gray-900">📋 Application Management</h1>
                    <p class="text-gray-600">Manage all digital ID applications</p>
                    <p class="text-sm text-gray-500">
                        Total: {{ $applications->total() ?? 0 }} applications • Logged in as: {{ auth()->user()->name }}
                    </p>
                </div>
                <div class="mt-4 flex md:mt-0 md:ml-4">
                    <a href="{{ route('admin.dashboard') }}"
                       class="bg-purple-600 text-white rounded-md px-4 py-2 text-sm font-medium hover:bg-purple-700">
                        ← Back to Dashboard
                    </a>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white shadow rounded-lg mb-6 p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">🔍 Filter Applications</h3>
            <form method="GET" action="{{ route('admin.applications') }}" class="space-y-4">
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                    <!-- Search -->
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700">Search</label>
                        <input type="text"
                               name="search"
                               id="search"
                               value="{{ request('search') }}"
                               class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-purple-500 focus:border-purple-500"
                               placeholder="Application number, name...">
                    </div>

                    <!-- Status Filter -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                        <select name="status"
                                class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-purple-500 focus:border-purple-500">
                            <option value="">All Statuses</option>
                            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="gs_approved" {{ request('status') === 'gs_approved' ? 'selected' : '' }}>GS Approved</option>
                            <option value="ds_approved" {{ request('status') === 'ds_approved' ? 'selected' : '' }}>DS Approved</option>
                            <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
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

        <!-- Applications Table -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900">
                    System Applications
                    @if($applications->total() > 0)
                        <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                            {{ $applications->total() }} total
                        </span>
                    @endif
                </h2>
                <p class="text-sm text-gray-600">
                    Showing {{ $applications->firstItem() ?? 0 }} to {{ $applications->lastItem() ?? 0 }} of {{ $applications->total() ?? 0 }} results
                </p>
            </div>

            @if($applications->isNotEmpty())
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Application
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Applicant
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Submitted
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($applications as $application)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $application->application_number }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            {{ $application->created_at->format('M j, Y') }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $application->full_name }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            {{ $application->user->email ?? 'N/A' }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @switch($application->status)
                                            @case('pending')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                    🟡 Pending
                                                </span>
                                                @break
                                            @case('gs_approved')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    🔵 GS Approved
                                                </span>
                                                @break
                                            @case('ds_approved')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    🟢 DS Approved
                                                </span>
                                                @break
                                            @case('rejected')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                    🔴 Rejected
                                                </span>
                                                @break
                                            @default
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                    {{ ucfirst($application->status) }}
                                                </span>
                                        @endswitch
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $application->created_at->diffForHumans() }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex items-center space-x-2">
                                            <button onclick="viewApplication('{{ $application->id }}')"
                                                    class="text-purple-600 hover:text-purple-900 font-medium">
                                                View
                                            </button>
                                            <button onclick="editStatus('{{ $application->id }}')"
                                                    class="text-blue-600 hover:text-blue-900 font-medium">
                                                Admin Actions
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($applications->hasPages())
                    <div class="bg-white px-6 py-4 border-t border-gray-200">
                        {{ $applications->appends(request()->query())->links() }}
                    </div>
                @endif
            @else
                <!-- Empty State -->
                <div class="text-center py-12">
                    <div class="mx-auto h-16 w-16 bg-gray-100 rounded-full flex items-center justify-center">
                        <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <h3 class="mt-4 text-lg font-medium text-gray-900">No applications found</h3>
                    <p class="mt-2 text-sm text-gray-500">
                        @if(request()->hasAny(['search', 'status']))
                            No applications match your current filters.
                        @else
                            No applications have been submitted to the system yet.
                        @endif
                    </p>
                    @if(request()->hasAny(['search', 'status']))
                        <div class="mt-6">
                            <a href="{{ route('admin.applications') }}"
                               class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-purple-600 bg-purple-100 hover:bg-purple-200">
                                Clear Filters
                            </a>
                        </div>
                    @endif
                </div>
            @endif
        </div>

        <!-- Admin Security Notice -->
        <div class="mt-8 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-yellow-800">🔒 Administrator Access</h3>
                    <div class="mt-2 text-sm text-yellow-700">
                        <ul class="list-disc pl-5 space-y-1">
                            <li>You have full administrative access to all applications</li>
                            <li>All actions are logged for security and audit purposes</li>
                            <li>Use emergency status override only when absolutely necessary</li>
                            <li>Contact system administrators for technical issues</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function viewApplication(id) {
    alert(`📋 Opening application details for ID: ${id}\n\nThis will show:\n• Complete application information\n• Document attachments\n• Verification history\n• User details`);
}

function editStatus(id) {
    alert(`⚡ Administrator actions for application ID: ${id}\n\nAvailable actions:\n• Force status change\n• Add administrative notes\n• Override approval process\n• Generate reports`);
}
</script>
@endsection
