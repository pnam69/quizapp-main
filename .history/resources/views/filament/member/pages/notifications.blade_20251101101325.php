<x-filament-panels::page>
    <div class="max-w-7xl mx-auto space-y-6">
        {{-- Header --}}
        <div class="bg-gradient-to-r from-indigo-500 to-blue-600 dark:from-indigo-600 dark:to-blue-700 rounded-xl shadow-lg p-8 text-white mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <div class="flex items-center gap-4 mb-2">
                        <div class="bg-white/20 backdrop-blur-sm rounded-lg p-3">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold">Notifications</h1>
                            <p class="text-indigo-100 mt-1">Stay updated with your latest activities and announcements</p>
                        </div>
                    </div>
                    <div class="flex gap-4 text-sm mt-4">
                        <div class="bg-white/10 backdrop-blur-sm rounded-lg px-3 py-2">
                            🔔 {{ count($notifications) }} Notification{{ count($notifications) !== 1 ? 's' : '' }}
                        </div>
                        @if($notifications->where('read_at', null)->count() > 0)
                        <div class="bg-white/10 backdrop-blur-sm rounded-lg px-3 py-2">
                            ✨ {{ $notifications->where('read_at', null)->count() }} Unread
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Notifications List --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
            @forelse($notifications as $notification)
            @php
            $isUnread = is_null($notification->read_at);
            $notificationData = $notification->data;
            $message = $notificationData['message'] ?? 'Notification';
            $type = $notificationData['type'] ?? 'info';

            // Determine icon and color based on type
            $iconColors = [
            'success' => ['bg' => 'green', 'text' => 'text-green-700 dark:text-green-300'],
            'warning' => ['bg' => 'yellow', 'text' => 'text-yellow-700 dark:text-yellow-300'],
            'error' => ['bg' => 'red', 'text' => 'text-red-700 dark:text-red-300'],
            'info' => ['bg' => 'blue', 'text' => 'text-blue-700 dark:text-blue-300'],
            ];

            $colors = $iconColors[$type] ?? $iconColors['info'];
            @endphp
            <div class="p-6 border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-all duration-200 {{ $isUnread ? 'bg-blue-50/50 dark:bg-blue-900/10' : '' }}">
                <div class="flex items-start gap-4">
                    <div class="bg-gradient-to-br from-{{ $colors['bg'] }}-500 to-{{ $colors['bg'] }}-600 text-white rounded-lg p-3 shrink-0">
                        @if($type === 'success')
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        @elseif($type === 'warning')
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                        @elseif($type === 'error')
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        @else
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex-1">
                                <p class="text-base font-medium text-gray-900 dark:text-gray-100 {{ $isUnread ? 'font-bold' : '' }}">
                                    {{ $message }}
                                </p>
                                <div class="flex items-center gap-3 mt-2">
                                    <div class="inline-flex items-center gap-1.5 {{ $colors['text'] }} text-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ $notification->created_at->diffForHumans() }}
                                    </div>
                                    @if($isUnread)
                                    <span class="inline-flex items-center gap-1.5 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 px-2 py-0.5 rounded-full text-xs font-bold">
                                        <span class="w-2 h-2 bg-blue-500 rounded-full animate-pulse"></span>
                                        NEW
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center py-20">
                <div class="mb-6">
                    <div class="mx-auto w-24 h-24 bg-gradient-to-br from-indigo-100 to-blue-100 dark:from-indigo-900/20 dark:to-blue-900/20 rounded-full flex items-center justify-center">
                        <svg class="w-12 h-12 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>
                    </div>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-2">
                    No Notifications
                </h3>
                <p class="text-gray-600 dark:text-gray-400 mb-6 max-w-md mx-auto">
                    You're all caught up! You don't have any notifications at the moment.
                </p>
            </div>
            @endforelse
        </div>
    </div>
</x-filament-panels::page>