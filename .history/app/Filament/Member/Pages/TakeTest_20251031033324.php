<x-filament-panels::page panel-id="member">
    {{-- If no quiz selected yet --}}
    @if (!$selectedQuiz)
    <div class="space-y-6">
        @forelse ($this->quizzes as $quiz)
        <div class="p-5 rounded-xl shadow-sm border border-gray-200 bg-white dark:bg-gray-900">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                        {{ $quiz->title ?? 'Untitled Quiz' }}
                    </h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Certification: <strong>{{ $quiz->certification->name ?? 'N/A' }}</strong><br>
                        Section: <strong>{{ $quiz->section->name ?? 'N/A' }}</strong><br>
                        Score: {{ $quiz->score ? $quiz->score . '%' : 'Not taken' }}
                    </p>
                </div>
                <x-filament::button color="primary" wire:click="selectQuiz({{ $quiz->id }})">
                    Start Test
                </x-filament::button>
            </div>
        </div>
        @empty
        <p class="text-gray-500 dark:text-gray-400 text-center">
            No tests available for your assigned certifications or sections.
        </p>
        @endforelse
    </div>
    @else
    {{-- Quiz questions --}}
    <div class="space-y-8">
        <div class="p-6 rounded-xl shadow-md border border-gray-200 bg-white dark:bg-gray-900">
            <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-2">
                {{ $selectedQuiz->title ?? 'Quiz' }}
            </h2>
            <p class="text-sm text-gray-500">
                Answer all questions carefully and click **Submit** when done.
            </p>
        </div>

        <form wire:submit.prevent="submit" class="space-y-6">
            @foreach ($questions as $index => $question)
            <div class="p-5 rounded-lg border border-gray-200 bg-white dark:bg-gray-800">
                <p class="font-semibold text-gray-900 dark:text-gray-100">
                    {{ $index + 1 }}. {{ $question->question }}
                </p>

                <div class="mt-3 space-y-2">
                    @foreach ($question->answers as $answer)
                    <label class="flex items-center space-x-2 cursor-pointer">
                        <input type="radio"
                            wire:model="answers.{{ $question->id }}"
                            value="{{ $answer->id }}"
                            class="text-primary-600 focus:ring-primary-500">
                        <span class="text-gray-700 dark:text-gray-300">{{ $answer->answer }}</span>
                    </label>
                    @endforeach
                </div>
            </div>
            @endforeach

            <div class="flex justify-between pt-4">
                <x-filament::button color="secondary" wire:click="$set('selectedQuiz', null)">
                    Back
                </x-filament::button>
                <x-filament::button color="success" type="submit">
                    Submit Test
                </x-filament::button>
            </div>
        </form>
    </div>
    @endif
</x-filament-panels::page>