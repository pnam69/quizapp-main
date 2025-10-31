<x-filament-panels::page panel-id="member">
    @if ($selectedQuiz)
    <div class="space-y-6">
        <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100">
            {{ $selectedQuiz->title }}
        </h2>

        <form wire:submit.prevent="submit">
            @foreach ($questions as $question)
            <div class="p-4 border rounded-lg bg-white dark:bg-gray-800 shadow-sm">
                <h3 class="font-semibold mb-2">{{ $question->question }}</h3>

                @foreach ($question->answers as $answer)
                <label class="block mb-1">
                    <input type="radio"
                        wire:model="answers.{{ $question->id }}"
                        value="{{ $answer->id }}"
                        class="mr-2">
                    {{ $answer->answer }}
                </label>
                @endforeach
            </div>
            @endforeach

            <x-filament::button type="submit" color="success">Submit</x-filament::button>
            <x-filament::button color="secondary" wire:click="$set('selectedQuiz', null)">
                Back
            </x-filament::button>
        </form>
    </div>
    @else
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
    </div>
    @endif
</x-filament-panels::page>