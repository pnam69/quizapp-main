<x-filament::page>
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Questions & Answers</h1>

        <a href="{{ route('filament.resources.questions.create') }}"
            class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded shadow">
            + Create Question
        </a>
    </div>

    <div class="space-y-6">
        @foreach($questions as $question)
        <div class="p-6 border rounded-lg shadow hover:shadow-lg transition-shadow bg-white dark:bg-gray-800 dark:border-gray-700 flex justify-between items-start">
            <div>
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

            <div class="flex flex-col space-y-2 ml-4">
                <a href="{{ route('filament.resources.questions.edit', $question->id) }}"
                    class="inline-flex items-center px-3 py-1 bg-yellow-500 hover:bg-yellow-600 text-white font-semibold rounded shadow text-sm">
                    ✎ Edit
                </a>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="flex justify-center items-center mt-6 space-x-2">
        <button wire:click="prevPage"
            class="px-4 py-2 bg-gray-300 dark:bg-gray-700 text-gray-800 dark:text-gray-200 font-semibold rounded disabled:opacity-50"
            @if($page <=1) disabled @endif>
            ← Previous
        </button>
        <span class="px-4 py-2 font-semibold text-gray-700 dark:text-gray-200">
            Page {{ $page }} of {{ $questions->lastPage() }}
        </span>
        <button wire:click="nextPage"
            class="px-4 py-2 bg-gray-300 dark:bg-gray-700 text-gray-800 dark:text-gray-200 font-semibold rounded disabled:opacity-50"
            @if($page>= $questions->lastPage()) disabled @endif>
            Next →
        </button>
    </div>
</x-filament::page>