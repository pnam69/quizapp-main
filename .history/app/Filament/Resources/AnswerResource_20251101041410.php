<x-filament::page>
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">
            Questions & Answers
        </h1>

        {{-- Create Question (use resource url helper) --}}
        <a href="{{ \App\Filament\Resources\QuestionResource::getUrl('create') }}"
            class="inline-flex items-center px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white font-semibold rounded-lg shadow transition">
            + Create Question
        </a>
    </div>

    <div class="space-y-6">
        @foreach($questions as $question)
        <div class="p-4 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm bg-white dark:bg-gray-900 transition">
            <div class="flex justify-between items-start mb-3">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                    {{ $question->question }}
                </h2>

                {{-- Edit Question using resource helper --}}
                <a href="{{ \App\Filament\Resources\QuestionResource::getUrl('edit', ['record' => $question->id]) }}"
                    class="text-sm font-medium text-primary-600 hover:text-primary-800 dark:text-primary-400 dark:hover:text-primary-300">
                    ✎ Edit
                </a>
            </div>

            <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                @foreach($question->answers as $answer)
                <li class="flex justify-between items-center py-2">
                    <span class="text-gray-800 dark:text-gray-200">
                        {{ $answer->answer }}
                    </span>
                    <span class="text-green-600 dark:text-green-400 font-semibold">
                        @if($answer->is_checked ?? $answer->is_correct ?? false)
                        ✔
                        @endif
                    </span>
                </li>
                @endforeach
            </ul>
        </div>
        @endforeach
    </div>

    {{-- Pagination (Tailwind) --}}
    <div class="mt-6">
        {{ $questions->links('pagination::tailwind') }}
    </div>

    {{-- Scroll arrows --}}
    <div class="fixed bottom-6 right-6 flex flex-col gap-2">
        <button onclick="window.scrollTo({ top: 0, behavior: 'smooth' })"
            class="p-3 bg-primary-600 hover:bg-primary-700 text-white rounded-full shadow">
            ↑
        </button>
        <button onclick="window.scrollTo({ top: document.body.scrollHeight, behavior: 'smooth' })"
            class="p-3 bg-primary-600 hover:bg-primary-700 text-white rounded-full shadow">
            ↓
        </button>
    </div>
</x-filament::page>