<div class="space-y-6">
    <h1 class="text-2xl font-bold">My Study Hub</h1>

    @forelse($hubs as $hub)
    <div class="bg-white border-2 border-gray-300 shadow sm:rounded-lg p-4">
        <h2 class="text-xl font-semibold">{{ $hub->title }}</h2>
        <p class="text-gray-700 mt-2">{{ $hub->description }}</p>

        <div class="mt-3 flex space-x-3">
            @if(in_array($hub->type, ['pdf', 'document', 'other']) && $hub->file_path)
            <a href="{{ asset('storage/' . $hub->file_path) }}" target="_blank" class="px-3 py-1 bg-blue-500 text-white rounded">Download</a>
            @endif

            @if(in_array($hub->type, ['link', 'video']) && $hub->link_url)
            <a href="{{ $hub->link_url }}" target="_blank" class="px-3 py-1 bg-green-500 text-white rounded">Open Link</a>
            @endif
        </div>

        <p class="mt-2 text-sm text-gray-500">
            Section: {{ $hub->section?->name ?? 'N/A' }} |
            Certification: {{ $hub->certification?->name ?? 'N/A' }}
        </p>
    </div>
    @empty
    <p class="text-gray-500">No study materials assigned yet.</p>
    @endforelse
</div>