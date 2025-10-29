<!-- <div>
    <div class="container py-4">
    <h2 class="text-2xl font-semibold mb-4">📚 Study Hub</h2>

    @forelse ($materials as $item)
        <div class="bg-white shadow-md rounded-lg p-4 mb-4">
            <h3 class="font-bold text-lg">{{ $item->title }}</h3>
            <p class="text-gray-600 mb-2">{{ $item->description }}</p>
            <p class="text-sm text-gray-500 mb-2">Type: <strong>{{ strtoupper($item->type) }}</strong></p>

            @if ($item->type === 'pdf' || $item->type === 'document')
                <a href="{{ Storage::url($item->file_path) }}" target="_blank" class="text-blue-600 underline">View File</a>
            @elseif ($item->type === 'link' || $item->type === 'video')
                <a href="{{ $item->link_url }}" target="_blank" class="text-blue-600 underline">Open Link</a>
            @endif
        </div>
    @empty
        <p>No study materials available yet.</p>
    @endforelse
</div> -->
