<x-filament::page>

    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Questions & Answers</h1>

        {{-- Create Question --}}
        <a href="{{ route('filament.resources.questions.create') }}"
            class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded shadow">
            + Create Question
        </a>
    </div>

    <div class="space-y-6">
        @foreach($questions as $question)
        <div class="p-4 border rounded-lg shadow-sm bg-white dark:bg-gray-800">
            <div class="flex justify-between items-start mb-2">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $question->question }}</h2>

                {{-- Edit Question --}}
                <a href="{{ route('filament.resources.questions.edit', $question->id) }}"
                    class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 font-semibold">
                    Edit
                </a>
            </div>

            <ul class="space-y-1">
                @foreach($question->answers as $answer)
                <li class="flex items-center justify-between p-2 border-b last:border-b-0">
                    <span class="text-gray-800 dark:text-gray-200">{{ $answer->answer }}</span>
                    <span class="text-green-600 font-semibold">
                        @if($answer->is_checked)
                        Correct
                        @endif
                    </span>
                </li>
                @endforeach
            </ul>
        </div>
        @endforeach
    </div>

    {{-- Pagination --}}
    <div class="mt-6 flex justify-center space-x-2">
        @if($questions->onFirstPage() === false)
        <button wire:click="updatedPage({{ $questions->currentPage() - 1 }})"
            class="px-3 py-1 bg-gray-300 dark:bg-gray-700 rounded hover:bg-gray-400 dark:hover:bg-gray-600">&larr;</button>
        @endif

        <span class="px-3 py-1 bg-gray-200 dark:bg-gray-600 rounded">{{ $questions->currentPage() }}</span>

        @if($questions->hasMorePages())
        <button wire:click="updatedPage({{ $questions->currentPage() + 1 }})"
            class="px-3 py-1 bg-gray-300 dark:bg-gray-700 rounded hover:bg-gray-400 dark:hover:bg-gray-600">&rarr;</button>
        @endif
    </div>

</x-filament::page>