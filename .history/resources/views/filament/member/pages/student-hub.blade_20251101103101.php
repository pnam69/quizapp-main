<x-filament::page>
    <div class="max-w-7xl mx-auto space-y-6">
        {{-- Hero Section --}}
        <div class="bg-gradient-to-r from-green-500 to-teal-600 dark:from-green-600 dark:to-teal-700 rounded-xl shadow-lg p-8 text-white mb-6">
            <div class="flex items-center gap-4 mb-2">
                <div class="bg-white/20 backdrop-blur-sm rounded-lg p-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-3xl font-bold">My Study Hub</h1>
                    <p class="text-green-100 mt-1">Access all your study materials and resources</p>
                </div>
            </div>
            <div class="flex gap-4 text-sm mt-4">
                <div class="bg-white/10 backdrop-blur-sm rounded-lg px-3 py-2">
                    📚 {{ count($this->hubs) }} Resource{{ count($this->hubs) !== 1 ? 's' : '' }} Available
                </div>
            </div>
        </div>

        {{-- Study Materials Grid --}}
        @forelse($this->hubs as $hub)
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden border-2 border-gray-200 dark:border-gray-700 hover:border-green-400 dark:hover:border-green-600 transition-all duration-200 group">
            <div class="p-6">
                <div class="flex items-start gap-4">
                    @php
                    $typeIcons = [
                        'video' => '🎬',
                        'document' => '📄',
                        'link' => '🔗',
                        'presentation' => '📊',
                        'default' => '📁',
                    ];
                    $typeIcon = $typeIcons[$hub->type] ?? $typeIcons['default'];
                    @endphp
                    <div class="bg-gradient-to-br from-green-500 to-teal-600 text-white rounded-lg p-3 shrink-0">
                        <div class="text-2xl">{{ $typeIcon }}</div>
                    </div>
                    <div class="flex-1">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100 group-hover:text-green-600 dark:group-hover:text-green-400 transition-colors">
                            {{ $hub->title }}
                        </h2>
                        
                        @if($hub->description)
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-2 line-clamp-2">
                            {{ $hub->description }}
                        </p>
                        @endif

                        <div class="flex items-center gap-2 mt-3">
                            <div class="inline-flex items-center gap-1.5 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 px-3 py-1 rounded-full text-xs font-medium">
                                {{ strtoupper($hub->type) }}
                            </div>
                        </div>
                    </div>
                </div>

                @php
                $files = (array) $hub->file_path;
                $icons = [
                    'pdf' => '📄', 'doc' => '📝', 'docx' => '📝',
                    'ppt' => '📊', 'pptx' => '📊', 'xls' => '📈', 'xlsx' => '📈',
                    'jpg' => '🖼️', 'jpeg' => '🖼️', 'png' => '🖼️',
                    'mp4' => '🎬', 'avi' => '🎬', 'mov' => '🎬',
                    'zip' => '📦', 'rar' => '📦',
                    'default' => '📁',
                ];
                @endphp

                <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                    @if(!empty($files))
                    <div class="space-y-2">
                        <p class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">📎 Attachments:</p>
                        <div class="grid gap-2">
                            @foreach($files as $file)
                            @php
                            $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                            $icon = $icons[$ext] ?? $icons['default'];
                            $url = \Illuminate\Support\Facades\Storage::disk('public')->url($file);
                            $fileName = basename($file);
                            @endphp
                            <a href="{{ $url }}" target="_blank"
                                class="flex items-center gap-3 p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg hover:bg-green-50 dark:hover:bg-green-900/20 transition-colors group/file">
                                <span class="text-2xl">{{ $icon }}</span>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100 truncate group-hover/file:text-green-600 dark:group-hover/file:text-green-400">
                                        {{ $fileName }}
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ strtoupper($ext) }} File
                                    </p>
                                </div>
                                <svg class="w-5 h-5 text-gray-400 group-hover/file:text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                </svg>
                            </a>
                            @endforeach
                        </div>
                    </div>
                    @elseif($hub->link_url)
                    <a href="{{ $hub->link_url }}" target="_blank"
                        class="flex items-center gap-3 p-4 bg-gradient-to-r from-green-50 to-teal-50 dark:from-green-900/20 dark:to-teal-900/20 rounded-lg hover:from-green-100 hover:to-teal-100 dark:hover:from-green-900/30 dark:hover:to-teal-900/30 transition-all group/link">
                        <div class="bg-green-500 text-white rounded-lg p-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-900 dark:text-gray-100 group-hover/link:text-green-600 dark:group-hover/link:text-green-400">
                                Open External Link
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 truncate">
                                {{ $hub->link_url }}
                            </p>
                        </div>
                        <svg class="w-5 h-5 text-gray-400 group-hover/link:text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                        </svg>
                    </a>
                    @else
                    <div class="flex items-center gap-3 p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-sm text-gray-500 dark:text-gray-400">No file or link available</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
            <div class="text-center py-20">
                <div class="mb-6">
                    <div class="mx-auto w-24 h-24 bg-gradient-to-br from-green-100 to-teal-100 dark:from-green-900/20 dark:to-teal-900/20 rounded-full flex items-center justify-center">
                        <svg class="w-12 h-12 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-2">
                    No Study Materials Yet
                </h3>
                <p class="text-gray-600 dark:text-gray-400 max-w-md mx-auto">
                    Study materials haven't been uploaded yet. Check back later or contact your instructor for more information.
                </p>
            </div>
        </div>
        @endforelse
    </div>
</x-filament::page>