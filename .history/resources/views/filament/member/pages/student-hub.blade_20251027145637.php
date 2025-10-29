<x-filament::page>
    <div class="space-y-4">
        @if ($hubs->isEmpty())
            <div class="text-center text-gray-500">
                No study materials available for you yet.
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach ($hubs as $hub)
                    <div class="p-4 border rounded-lg shadow-sm bg-white">
                        <h3 class="font-semibold text-lg">{{ $hub->title }}</h3>
                        <p class="text-sm text-gray-600 mb-2">{{ $hub->description }}</p>
                        <p class="text-xs text-gray-500 mb-3">Type: {{ strtoupper($hub->type) }}</p>

                        @if (in_array($hub->type, ['link', 'video']) && $hub->link_url)
                            <a href="{{ $hub->link_url }}" target="_blank" class="text-blue-600 underline">Open Link</a>
                        @elseif ($hub->file_path)
                            <a href="{{ Storage::url($hub->file_path) }}" target="_blank" class="text-blue-600 underline">View File</a>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-filament::page>
