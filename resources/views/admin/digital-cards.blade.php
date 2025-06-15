@extends('layouts.app')

@section('title', 'Digital Cards Registry - Admin')

@section('content')
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <div class="md:flex md:items-center md:justify-between">
                    <div class="flex-1 min-w-0">
                        <h1 class="text-2xl font-bold text-gray-900">💳 Digital Cards Registry</h1>
                        <p class="text-gray-600">Manage all issued digital ID cards</p>
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

            <!-- Real Statistics Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Active Cards -->
                <div class="bg-white shadow rounded-lg p-6 border-l-4 border-green-500">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="h-12 w-12 bg-green-100 rounded-lg flex items-center justify-center">
                                <span class="text-2xl">✅</span>
                            </div>
                        </div>
                        <div class="ml-4">
                            <dt class="text-sm font-medium text-gray-500">Active Cards</dt>
                            <dd class="text-2xl font-bold text-green-600">{{ $activeCards }}</dd>
                            <p class="text-xs text-gray-500 mt-1">Currently valid</p>
                        </div>
                    </div>
                </div>

                <!-- Issued Today -->
                <div class="bg-white shadow rounded-lg p-6 border-l-4 border-blue-500">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="h-12 w-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                <span class="text-2xl">📅</span>
                            </div>
                        </div>
                        <div class="ml-4">
                            <dt class="text-sm font-medium text-gray-500">Issued Today</dt>
                            <dd class="text-2xl font-bold text-blue-600">{{ $issuedToday }}</dd>
                            <p class="text-xs text-gray-500 mt-1">New cards</p>
                        </div>
                    </div>
                </div>

                <!-- Expired -->
                <div class="bg-white shadow rounded-lg p-6 border-l-4 border-red-500">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="h-12 w-12 bg-red-100 rounded-lg flex items-center justify-center">
                                <span class="text-2xl">❌</span>
                            </div>
                        </div>
                        <div class="ml-4">
                            <dt class="text-sm font-medium text-gray-500">Expired</dt>
                            <dd class="text-2xl font-bold text-red-600">{{ $expiredCards }}</dd>
                            <p class="text-xs text-gray-500 mt-1">Need renewal</p>
                        </div>
                    </div>
                </div>

                <!-- Total Cards -->
                <div class="bg-white shadow rounded-lg p-6 border-l-4 border-purple-500">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="h-12 w-12 bg-purple-100 rounded-lg flex items-center justify-center">
                                <span class="text-2xl">💳</span>
                            </div>
                        </div>
                        <div class="ml-4">
                            <dt class="text-sm font-medium text-gray-500">Total Cards</dt>
                            <dd class="text-2xl font-bold text-purple-600">{{ $totalCards }}</dd>
                            <p class="text-xs text-gray-500 mt-1">All issued</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Cards from Database -->
            <div class="bg-white shadow rounded-lg mb-8">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">🆕 Recently Issued Cards</h3>
                    <p class="text-sm text-gray-600">Latest digital ID cards from the database</p>
                </div>
                <div class="p-6">
                    @if ($recentCards->isNotEmpty())
                        <div class="space-y-4">
                            @foreach ($recentCards as $card)
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                    <div class="flex items-center">
                                        <div
                                            class="h-10 w-10 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                                            <span class="text-purple-600 font-bold text-sm">
                                                {{ substr($card->application->full_name, 0, 2) }}
                                            </span>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">{{ $card->application->full_name }}
                                            </p>
                                            <p class="text-xs text-gray-500">{{ $card->card_number }}</p>
                                            <p class="text-xs text-gray-400">{{ $card->application->email }}</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        @if ($card->status === 'active')
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                ✅ Active
                                            </span>
                                        @elseif($card->status === 'expired')
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                ❌ Expired
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                ⏳ {{ ucfirst($card->status) }}
                                            </span>
                                        @endif
                                        <p class="text-xs text-gray-500 mt-1">{{ $card->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <div class="mx-auto h-16 w-16 bg-gray-100 rounded-full flex items-center justify-center">
                                <span class="text-gray-400 text-2xl">💳</span>
                            </div>
                            <h3 class="mt-4 text-lg font-medium text-gray-900">No cards issued yet</h3>
                            <p class="mt-2 text-sm text-gray-500">
                                Digital cards will appear here once applications are approved and cards are generated.
                            </p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Simple Status Summary -->
            @if ($totalCards > 0)
                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">📊 Card Status Summary</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="text-center p-4 bg-green-50 rounded-lg permanent-content">
                            <div class="text-2xl font-bold text-green-600">{{ $activeCards }}</div>
                            <div class="text-sm text-gray-600">Active Cards</div>
                            <div class="text-xs text-gray-500">
                                {{ $totalCards > 0 ? round(($activeCards / $totalCards) * 100, 1) : 0 }}% of total
                            </div>
                        </div>
                        <div class="text-center p-4 bg-red-50 rounded-lg">
                            <div class="text-2xl font-bold text-red-600">{{ $expiredCards }}</div>
                            <div class="text-sm text-gray-600">Expired Cards</div>
                            <div class="text-xs text-gray-500">
                                {{ $totalCards > 0 ? round(($expiredCards / $totalCards) * 100, 1) : 0 }}% of total
                            </div>
                        </div>
                        <div class="text-center p-4 bg-blue-50 rounded-lg">
                            <div class="text-2xl font-bold text-blue-600">{{ $issuedToday }}</div>
                            <div class="text-sm text-gray-600">Issued Today</div>
                            <div class="text-xs text-gray-500">
                                {{ now()->format('M j, Y') }}
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <span class="text-blue-600 text-2xl">ℹ️</span>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-lg font-medium text-blue-800">Digital Cards Registry</h3>
                            <p class="text-sm text-blue-700 mt-1">
                                No digital cards have been issued yet. Cards will appear here once applications are approved
                                by DS officers and digital cards are generated.
                            </p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
