<x-filament-panels::page>
    <h2 class="text-xl font-bold mb-4">Notifications</h2>

    @if($notifications->isEmpty())
    <p>No notifications.</p>
    @else
    <ul class="list-disc pl-6">
        @foreach($notifications as $notification)
        <li>{{ $notification->data['message'] ?? 'Notification' }} — {{ $notification->created_at->diffForHumans() }}</li>
        @endforeach
    </ul>
    @endif
</x-filament-panels::page>