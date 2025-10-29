<x-filament::page>
    <div class="space-y-6">
        @forelse($this->hubs as $hub)
        <div class="p-6 rounded-2xl shadow hover:shadow-lg transition bg-white dark:bg-gray-800">
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-4">
                <div>
                    <h2 class="text-xl font-bold !text-gray-900 dark:!text-gray-100">
                        {{ $hub->title }}
                    </h2>
                    <p class="mt-1 !text-gray-700 dark:!text-gray-300">
                        {{ $hub->description }}
                    </p>
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400 uppercase font-medium">
                        Type: {{ $hub->type }}
                    </p>
                </div>

                @php
                $files = $hub->file_path ? json_decode($hub->file_path) : [];
                @endphp

                <div class="flex flex-wrap items-center gap-3 mt-3 sm:mt-0">
                    @if(!empty($files))
                    @foreach($files as $file)
                    <a href="{{ asset('storage/' . $file) }}" target="_blank"
                        class="px-3 py-1 rounded-full border border-gray-300 dark:border-gray-600 bg-gray-100 dark:bg-gray-700 text-sm font-medium text-gray-800 dark:text-gray-100 hover:bg-gray-200 dark:hover:bg-gray-600 transition">
                        📄 View File
                    </a>
                    @endforeach
                    @endif

                    @if($hub->link_url)
                    <a href="{{ $hub->link_url }}" target="_blank"
                        class="px-3 py-1 rounded-full border border-blue-300 dark:border-blue-600 bg-blue-100 dark:bg-blue-800 text-sm font-medium text-blue-800 dark:text-blue-100 hover:bg-blue-200 dark:hover:bg-blue-700 transition">
                        🔗 Open Link
                    </a>
                    @endif

                    @if(empty($files) && !$hub->link_url)
                    <span class="text-gray-400 dark:text-gray-500 text-sm">No file or link available</span>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="text-gray-500 dark:text-gray-400 text-center text-lg">
            No study materials yet.
        </div>
        @endforelse
    </div>
</x-filament::page>