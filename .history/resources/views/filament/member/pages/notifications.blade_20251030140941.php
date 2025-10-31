<x-filament-panels::page>
    <h2 class="text-xl font-bold mb-4">Notifications</h2>

    @if($notifications->isEmpty())
    <p>No notifications.</p>
    @else
    <ul class="space-y-2">
        @foreach($notifications as $notification)
        <li class="p-2 border rounded">
            <p>{{ $notification->data['message'] ?? 'New notification' }}</p>
            <span class="text-sm text-gray-500">{{ $notification->created_at->diffForHumans() }}</span>
        </li>
        @endforeach
    </ul>
    @endif
</x-filament-panels::page>