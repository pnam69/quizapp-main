<x-filament::page>
    <div class="space-y-6">
        @foreach($questions as $question)
        <div class="p-6 border rounded-lg shadow hover:shadow-lg transition-shadow bg-white dark:bg-gray-800 dark:border-gray-700">
            <h2 class="text-xl font-bold mb-3 text-gray-800 dark:text-gray-100">{{ $question->question }}</h2>

            <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                @foreach($question->answers as $answer)
                <li class="flex items-center justify-between py-2 px-3 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors rounded">
                    <span class="text-gray-700 dark:text-gray-200">{{ $answer->answer }}</span>
                    @if($answer->is_checked)
                    <span class="text-green-600 font-semibold bg-green-100 dark:bg-green-900 px-2 py-1 rounded-full text-sm">Correct</span>
                    @endif
                </li>
                @endforeach
            </ul>
        </div>
        @endforeach
    </div>

    <!-- Pagination Arrows -->
    <div class="mt-6 flex items-center justify-center space-x-4">
        <button
            wire:click="previousPage"
            @if($page <=1) disabled @endif
            class="px-4 py-2 rounded border dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600 disabled:opacity-50">
            &larr; Previous
        </button>

        <span class="text-gray-700 dark:text-gray-200 font-semibold">
            Page {{ $page }} of {{ $totalPages }}
        </span>

        <button
            wire:click="nextPage"
            @if($page>= $totalPages) disabled @endif
            class="px-4 py-2 rounded border dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600 disabled:opacity-50">
            Next &rarr;
        </button>
    </div>
</x-filament::page>