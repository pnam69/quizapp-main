<x-filament::page>
    <div class="space-y-6">
        @forelse ($this->quizzes as $quiz)
        <div class="p-4 rounded-lg shadow-sm bg-white dark:bg-gray-800">
            <h2 class="font-semibold text-gray-900 dark:text-gray-100">
                {{ $quiz->certification->name ?? 'No Certification' }}
            </h2>
            <p class="text-sm text-gray-600 dark:text-gray-400">
                Section: {{ $quiz->section->name ?? 'N/A' }} |
                Score: {{ $quiz->score ?? 'Not taken' }}%
            </p>

            <x-filament::button color="primary" wire:click="selectQuiz({{ $quiz->id }})">
                Start Test
            </x-filament::button>
        </div>
        @empty
        <p class="text-gray-500 dark:text-gray-400 text-center">
            No tests available for your assigned certifications or sections.
        </p>
        @endforelse

        @if($selectedQuiz)
        <form wire:submit.prevent="submit" class="space-y-4 mt-6">
            @foreach ($questions as $question)
            <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                <p class="font-medium">{{ $question->question_text }}</p>
                @foreach ($question->options as $option)
                <label class="flex items-center space-x-2 mt-2">
                    <input type="radio" wire:model="answers.{{ $question->id }}" value="{{ $option->id }}">
                    <span>{{ $option->option_text }}</span>
                </label>
                @endforeach
            </div>
            @endforeach

            <x-filament::button type="submit" color="success">Submit Test</x-filament::button>
        </form>
        @endif
    </div>
</x-filament::page>