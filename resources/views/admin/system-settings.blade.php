@extends('layouts.app')

@section('title', 'System Settings - Admin')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="md:flex md:items-center md:justify-between">
                <div class="flex-1 min-w-0">
                    <h1 class="text-2xl font-bold text-gray-900">⚙️ System Settings</h1>
                    <p class="text-gray-600">Configure system parameters and global settings</p>
                    <p class="text-sm text-gray-500">
                        Administrator: {{ auth()->user()->name }} • {{ now()->format('F j, Y \a\t g:i A') }} UTC
                    </p>
                </div>
                <div class="mt-4 flex md:mt-0 md:ml-4">
                    <a href="{{ route('admin.dashboard') }}"
                       class="bg-gray-600 text-white rounded-md px-4 py-2 text-sm font-medium hover:bg-gray-700 transition-colors duration-200">
                        ← Back to Dashboard
                    </a>
                </div>
            </div>
        </div>

        <!-- Settings Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Application Settings -->
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-purple-600 to-purple-700 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-white flex items-center">
                        📝 Application Settings
                    </h3>
                    <p class="text-purple-100 text-sm">Configure application processing parameters</p>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="font-medium text-gray-900">Auto-approval for verified users</p>
                            <p class="text-sm text-gray-500">Skip manual review for pre-verified applicants</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" value="" class="sr-only peer" checked>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-purple-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-purple-600"></div>
                        </label>
                    </div>
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="font-medium text-gray-900">Maximum processing time</p>
                            <p class="text-sm text-gray-500">Days allowed for application processing</p>
                        </div>
                        <select class="border border-gray-300 rounded-md px-3 py-2 text-sm">
                            <option>7 days</option>
                            <option>14 days</option>
                            <option>30 days</option>
                        </select>
                    </div>
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="font-medium text-gray-900">Email notifications</p>
                            <p class="text-sm text-gray-500">Send status updates to applicants</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" value="" class="sr-only peer" checked>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-purple-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-purple-600"></div>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Security Settings -->
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-red-600 to-red-700 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-white flex items-center">
                        🔒 Security Settings
                    </h3>
                    <p class="text-red-100 text-sm">Manage system security configurations</p>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="font-medium text-gray-900">Two-factor authentication</p>
                            <p class="text-sm text-gray-500">Require 2FA for all admin accounts</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" value="" class="sr-only peer" checked>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-red-600"></div>
                        </label>
                    </div>
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="font-medium text-gray-900">Session timeout</p>
                            <p class="text-sm text-gray-500">Auto-logout inactive users</p>
                        </div>
                        <select class="border border-gray-300 rounded-md px-3 py-2 text-sm">
                            <option>30 minutes</option>
                            <option>1 hour</option>
                            <option>2 hours</option>
                        </select>
                    </div>
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="font-medium text-gray-900">Login attempt limit</p>
                            <p class="text-sm text-gray-500">Max failed login attempts</p>
                        </div>
                        <select class="border border-gray-300 rounded-md px-3 py-2 text-sm">
                            <option>3 attempts</option>
                            <option>5 attempts</option>
                            <option>10 attempts</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Notification Settings -->
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-blue-600 to-blue-700 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-white flex items-center">
                        🔔 Notification Settings
                    </h3>
                    <p class="text-blue-100 text-sm">Configure system notifications and alerts</p>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="font-medium text-gray-900">Real-time notifications</p>
                            <p class="text-sm text-gray-500">Push notifications for urgent events</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" value="" class="sr-only peer" checked>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                        </label>
                    </div>
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="font-medium text-gray-900">Daily digest emails</p>
                            <p class="text-sm text-gray-500">Summary emails to administrators</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" value="" class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                        </label>
                    </div>
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="font-medium text-gray-900">SMS alerts</p>
                            <p class="text-sm text-gray-500">Critical system alerts via SMS</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" value="" class="sr-only peer" checked>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Backup Settings -->
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-green-600 to-green-700 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-white flex items-center">
                        💾 Backup Settings
                    </h3>
                    <p class="text-green-100 text-sm">Manage system backup configurations</p>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="font-medium text-gray-900">Automatic backups</p>
                            <p class="text-sm text-gray-500">Scheduled system backups</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" value="" class="sr-only peer" checked>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-green-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-600"></div>
                        </label>
                    </div>
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="font-medium text-gray-900">Backup frequency</p>
                            <p class="text-sm text-gray-500">How often to create backups</p>
                        </div>
                        <select class="border border-gray-300 rounded-md px-3 py-2 text-sm">
                            <option>Daily</option>
                            <option>Weekly</option>
                            <option>Monthly</option>
                        </select>
                    </div>
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="font-medium text-gray-900">Last backup</p>
                            <p class="text-sm text-gray-500">{{ now()->subHours(2)->format('M j, Y g:i A') }}</p>
                        </div>
                        <button class="bg-green-600 text-white px-4 py-2 rounded-md text-sm hover:bg-green-700 transition-colors duration-200">
                            Backup Now
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Save Settings -->
        <div class="mt-8 bg-white shadow rounded-lg p-6">
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="text-lg font-medium text-gray-900">💾 Save Configuration</h3>
                    <p class="text-sm text-gray-500">Apply changes to system settings</p>
                </div>
                <div class="space-x-3">
                    <button class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md text-sm hover:bg-gray-400 transition-colors duration-200">
                        Reset to Defaults
                    </button>
                    <button class="bg-purple-600 text-white px-4 py-2 rounded-md text-sm hover:bg-purple-700 transition-colors duration-200">
                        Save All Settings
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
