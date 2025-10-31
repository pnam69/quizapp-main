<x-filament-panels::page panel-id="member">
    <div class="space-y-6">
        {{-- If a quiz is selected, show the test UI --}}
        @if($selectedQuiz)
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h2 class="text-lg font-semibold">{{ $selectedQuiz->title ?? 'Untitled Quiz' }}</h2>
                    <p class="text-sm text-gray-500">
                        {{ $selectedQuiz->certification->name ?? 'No Certification' }}
                        — Section: {{ $selectedQuiz->section->name ?? 'N/A' }}
                    </p>
                </div>
                <div class="flex items-center gap-2">
                    <x-filament::button color="secondary" wire:click="resetQuiz">Cancel</x-filament::button>
                </div>
            </div>

            @if($questions->isEmpty())
            <div class="text-sm text-gray-500">No questions assigned to this quiz.</div>
            @else
            <form wire:submit.prevent="submit">
                <div class="space-y-6">
                    @foreach($questions as $idx => $question)
                    <div class="p-4 border rounded-md">
                        <div class="flex items-start justify-between">
                            <div class="font-medium">Q{{ $idx + 1 }}. {{ $question->question }}</div>
                            <div class="text-xs text-gray-400">Level: {{ $question->level ?? 'N/A' }}</div>
                        </div>

                        @if($question->answers->isEmpty())
                        <div class="text-sm text-red-500 mt-2">No answers/options available for this question.</div>
                        @else
                        <div class="mt-3 space-y-2">
                            @foreach($question->answers as $answer)
                            <label class="flex items-center gap-2">
                                <input
                                    type="radio"
                                    wire:model="answers.{{ $question->id }}"
                                    name="q_{{ $question->id }}"
                                    value="{{ $answer->id }}"
                                    class="form-radio" />
                                <span>{{ $answer->answer }}</span>
                            </label>
                            @endforeach
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>

                <div class="mt-4 flex items-center gap-3">
                    <x-filament::button type="submit" color="primary">Submit</x-filament::button>
                    <x-filament::button color="secondary" wire:click="resetQuiz">Back</x-filament::button>
                </div>
            </form>
            @endif
        </div>

        {{-- Quiz list hidden while taking a test --}}
        @else
        <div class="space-y-4">
            @forelse ($quizzes as $quiz)
            <div class="p-4 rounded-lg shadow-sm bg-white dark:bg-gray-800">
                <h2 class="font-semibold text-gray-900 dark:text-gray-100">{{ $quiz->certification->name ?? 'No Certification' }}</h2>
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
        </div>
        @endif
    </div>
</x-filament-panels::page>