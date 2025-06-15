@extends('layouts.app')

@section('title', 'Notifications - Digital ID')

@section('content')
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-4xl mx-auto px-4">
            <!-- Simple Header -->
            <div class="mb-8">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Notifications</h1>
                        <p class="text-gray-600">Stay updated with your digital ID activities</p>
                    </div>
                    <div class="space-x-3">
                        @if ($notifications->where('read_at', null)->count() > 0)
                            <button onclick="markAllAsRead()"
                                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                                Mark All Read
                            </button>
                        @endif
                        <a href="{{ route('applicant.dashboard') }}"
                            class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">
                            Back to Dashboard
                        </a>
                    </div>
                </div>
            </div>

            <!-- Simple Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Total -->
                <div class="bg-white p-6 rounded shadow">
                    <div class="flex items-center">
                        <div class="bg-blue-100 p-3 rounded">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 17h5l-5 5v-5z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-600">Total</p>
                            <p class="text-2xl font-bold">{{ $notifications->count() }}</p>
                        </div>
                    </div>
                </div>

                <!-- Unread -->
                <div class="bg-white p-6 rounded shadow">
                    <div class="flex items-center">
                        <div class="bg-red-100 p-3 rounded">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-600">Unread</p>
                            <p class="text-2xl font-bold">{{ $notifications->where('read_at', null)->count() }}</p>
                        </div>
                    </div>
                </div>

                <!-- This Week -->
                <div class="bg-white p-6 rounded shadow">
                    <div class="flex items-center">
                        <div class="bg-green-100 p-3 rounded">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-600">This Week</p>
                            <p class="text-2xl font-bold">
                                {{ $notifications->where('created_at', '>=', now()->subWeek())->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Simple Filter -->
            <div class="bg-white rounded shadow mb-6">
                <div class="px-6 py-4">
                    <div class="flex space-x-4">
                        <button onclick="filterNotifications('all')"
                            class="filter-btn active bg-blue-100 text-blue-800 px-3 py-1 rounded text-sm font-medium">
                            All
                        </button>
                        <button onclick="filterNotifications('unread')"
                            class="filter-btn bg-gray-100 text-gray-800 px-3 py-1 rounded text-sm font-medium hover:bg-gray-200">
                            Unread Only
                        </button>
                    </div>
                </div>
            </div>

            <!-- Notifications List -->
            <div class="space-y-4" id="notificationsList">
                @if ($notifications->isEmpty())
                    <!-- Empty State -->
                    <div class="bg-white rounded shadow p-12 text-center">
                        <div class="w-16 h-16 bg-gray-100 rounded-full mx-auto mb-4 flex items-center justify-center">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 17h5l-5 5v-5z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No notifications yet</h3>
                        <p class="text-gray-600">You'll see notifications about your applications and account here.</p>
                    </div>
                @else
                    @foreach ($notifications as $notification)
                        <div class="notification-item bg-white rounded shadow hover:shadow-md transition-shadow
                                {{ is_null($notification->read_at) ? 'border-l-4 border-blue-500 bg-blue-50' : '' }}"
                            data-read="{{ is_null($notification->read_at) ? 'false' : 'true' }}"
                            data-id="{{ $notification->id }}">

                            <div class="p-6">
                                <div class="flex items-start justify-between">
                                    <!-- Content -->
                                    <div class="flex-1">
                                        <div class="flex items-center mb-2">
                                            <!-- Icon based on notification type -->
                                            <div
                                                class="w-8 h-8 rounded-full mr-3 flex items-center justify-center
                                                    {{ str_contains(strtolower($notification->title), 'approved')
                                                        ? 'bg-green-100'
                                                        : (str_contains(strtolower($notification->title), 'rejected')
                                                            ? 'bg-red-100'
                                                            : 'bg-blue-100') }}">
                                                @if (str_contains(strtolower($notification->title), 'approved'))
                                                    <span class="text-green-600">✅</span>
                                                @elseif(str_contains(strtolower($notification->title), 'rejected'))
                                                    <span class="text-red-600">❌</span>
                                                @elseif(str_contains(strtolower($notification->title), 'submitted'))
                                                    <span class="text-blue-600">📝</span>
                                                @else
                                                    <span class="text-blue-600">📬</span>
                                                @endif
                                            </div>

                                            <div class="flex-1">
                                                <h3 class="font-medium text-gray-900">
                                                    {{ $notification->title }}
                                                    @if (is_null($notification->read_at))
                                                        <span
                                                            class="ml-2 inline-block bg-red-100 text-red-800 px-2 py-1 rounded-full text-xs">
                                                            New
                                                        </span>
                                                    @endif
                                                </h3>
                                                <p class="text-sm text-gray-600 mt-1">{{ $notification->message }}</p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Actions -->
                                    <div class="flex items-center space-x-2 ml-4">
                                        <span
                                            class="text-xs text-gray-500">{{ $notification->created_at->diffForHumans() }}</span>

                                        @if (is_null($notification->read_at))
                                            <button onclick="markAsRead({{ $notification->id }})"
                                                class="text-blue-600 hover:text-blue-800 text-xs font-medium">
                                                Mark Read
                                            </button>
                                        @endif

                                        <button onclick="deleteNotification({{ $notification->id }})"
                                            class="text-red-400 hover:text-red-600">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

            <!-- Pagination -->
            @if ($notifications->hasPages())
                <div class="mt-8">
                    {{ $notifications->links() }}
                </div>
            @endif

            <!-- Help -->
            <div class="mt-8 bg-blue-50 border border-blue-200 rounded p-4">
                <div class="flex">
                    <svg class="w-5 h-5 text-blue-400 mr-2 mt-0.5" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div>
                        <h3 class="text-sm font-medium text-blue-800">About Notifications</h3>
                        <div class="mt-1 text-sm text-blue-700">
                            <ul class="space-y-1">
                                <li>• You'll receive notifications when your application status changes</li>
                                <li>• Important security alerts will appear here</li>
                                <li>• Click "Mark Read" to clear unread notifications</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function markAsRead(notificationId) {
            fetch(`/notifications/${notificationId}/mark-read`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const notification = document.querySelector(`[data-id="${notificationId}"]`);
                        notification.classList.remove('border-l-4', 'border-blue-500', 'bg-blue-50');
                        notification.dataset.read = 'true';

                        const newBadge = notification.querySelector('.bg-red-100');
                        if (newBadge) newBadge.remove();

                        const markReadBtn = notification.querySelector('button[onclick*="markAsRead"]');
                        if (markReadBtn) markReadBtn.remove();

                        showToast('Notification marked as read');
                    }
                })
                .catch(error => {
                    showToast('Error marking notification as read', 'error');
                });
        }

        function markAllAsRead() {
            if (confirm('Mark all notifications as read?')) {
                fetch('/notifications/mark-all-read', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Content-Type': 'application/json',
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Reload page to show updated state
                            location.reload();
                        }
                    })
                    .catch(error => {
                        showToast('Error marking all notifications as read', 'error');
                    });
            }
        }

        function deleteNotification(notificationId) {
            if (confirm('Delete this notification?')) {
                const notification = document.querySelector(`[data-id="${notificationId}"]`);
                notification.style.opacity = '0.5';

                // In a real app, you'd make an API call here
                setTimeout(() => {
                    notification.remove();
                    showToast('Notification deleted');
                }, 300);
            }
        }

        function filterNotifications(filter) {
            // Update active button
            document.querySelectorAll('.filter-btn').forEach(btn => {
                btn.classList.remove('active', 'bg-blue-100', 'text-blue-800');
                btn.classList.add('bg-gray-100', 'text-gray-800');
            });

            event.target.classList.add('active', 'bg-blue-100', 'text-blue-800');
            event.target.classList.remove('bg-gray-100', 'text-gray-800');

            // Filter notifications
            const notifications = document.querySelectorAll('.notification-item');
            notifications.forEach(notification => {
                if (filter === 'all') {
                    notification.style.display = 'block';
                } else if (filter === 'unread') {
                    notification.style.display = notification.dataset.read === 'false' ? 'block' : 'none';
                }
            });
        }

        function showToast(message, type = 'success') {
            // Simple toast notification
            const toast = document.createElement('div');
            toast.className = `fixed top-4 right-4 z-50 p-4 rounded shadow-lg text-white transition-all duration-300 ${
        type === 'error' ? 'bg-red-500' : 'bg-green-500'
    }`;
            toast.textContent = message;

            document.body.appendChild(toast);

            setTimeout(() => {
                toast.style.opacity = '0';
                setTimeout(() => {
                    document.body.removeChild(toast);
                }, 300);
            }, 3000);
        }
    </script>

    <style>
        .notification-item {
            transition: all 0.2s ease;
        }

        .notification-item:hover {
            transform: translateY(-1px);
        }

        .filter-btn.active {
            background-color: rgb(219 234 254) !important;
            color: rgb(30 64 175) !important;
        }
    </style>
@endsection
