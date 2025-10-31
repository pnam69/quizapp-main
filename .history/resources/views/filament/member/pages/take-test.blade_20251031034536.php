<x-filament-panels::page panel-id="member">
    <div class="space-y-6">

        {{-- If no quiz selected, show quiz list --}}
        @if (!$this->selectedQuiz)
        @forelse ($this->quizzes as $quiz)
        <div class="p-4 rounded-lg shadow-sm bg-white dark:bg-gray-800">
            <h2 class="font-semibold text-gray-900 dark:text-gray-100">
                {{ $quiz->certification->name ?? 'No Certification' }}
            </h2>
            <p class="text-sm text-gray-600 dark:text-gray-400">
                Section: {{ $quiz->section->name ?? 'N/A' }} | Score: {{ $quiz->score ?? 'Not taken' }}%
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
        @else
        {{-- Quiz selected: show questions --}}
        <div class="p-4 rounded-lg shadow-sm bg-white dark:bg-gray-800">
            <h2 class="font-semibold text-gray-900 dark:text-gray-100">
                {{ $this->selectedQuiz->title ?? 'Selected Quiz' }}
            </h2>

            <form wire:submit.prevent="submit" class="space-y-4 mt-4">
                @foreach ($this->questions as $index => $question)
                <div class="border p-3 rounded">
                    <p class="font-medium">{{ $index + 1 }}. {{ $question->text }}</p>
                    @foreach ($question->answers as $option)
                    <label class="flex items-center mt-1">
                        <input type="radio"
                            wire:model="answers.{{ $question->id }}"
                            value="{{ $option->id }}"
                            class="mr-2">
                        <span>{{ $option->text }}</span>
                    </label>
                    @endforeach
                </div>
                @endforeach

                <div class="mt-4 flex space-x-2">
                    <x-filament::button type="submit" color="success">
                        Submit
                    </x-filament::button>
                    <x-filament::button type="button" color="secondary" wire:click="$reset('selectedQuiz','questions','answers')">
                        Cancel
                    </x-filament::button>
                </div>
            </form>
        </div>
        @endif

    </div>
</x-filament-panels::page>