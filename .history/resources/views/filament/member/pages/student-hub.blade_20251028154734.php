<x-filament::page>
    <div class="space-y-4">
        @forelse($this->hubs as $hub)
        <div class="p-4 rounded-xl shadow-sm bg-white dark:bg-gray-800 transition">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                {{ $hub->title }}
            </h2>
            <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">
                {{ $hub->description }}
            </p>
            <p class="text-xs text-gray-500 mb-2">
                Type: {{ strtoupper($hub->type) }}
            </p>

            @if($hub->file_path)
            @php
            $files = is_array($hub->file_path) ? $hub->file_path : json_decode($hub->file_path, true);
            $icons = [
            'pdf' => '📄',
            'doc' => '📝',
            'docx' => '📝',
            'ppt' => '📊',
            'pptx' => '📊',
            'xls' => '📈',
            'xlsx' => '📈',
            'jpg' => '🖼️',
            'png' => '🖼️',
            'mp4' => '🎬',
            'avi' => '🎬',
            'default' => '📁',
            ];
            @endphp

            @foreach($files as $file)
            @php
            $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
            $icon = $icons[$ext] ?? $icons['default'];
            @endphp

            <a href="{{ asset('storage/' . $file) }}" target="_blank"
                class="inline-block text-primary-600 dark:text-primary-400 hover:underline mr-2 mb-1">
                {{ $icon }} {{ basename($file) }}
            </a>
            @endforeach

            @elseif($hub->link_url)
            <a href="{{ $hub->link_url }}" target="_blank"
                class="inline-block text-primary-600 dark:text-primary-400 hover:underline">
                🔗 Open Link
            </a>
            @else
            <span class="text-gray-400 text-sm">No file or link available</span>
            @endif
        </div>
        @empty
        <div class="text-gray-500 dark:text-gray-400 text-center">
            No study materials yet.
        </div>
        @endforelse
    </div>
</x-filament::page>