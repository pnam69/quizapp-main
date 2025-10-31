<x-filament-panels::page panel-id="member">
    <div class="space-y-8">

        {{-- Quiz Header --}}
        @if ($this->selectedQuiz)
            <div class="text-center">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                    {{ $this->selectedQuiz->certification->name ?? 'Untitled Test' }}
                </h1>
                <p class="text-gray-500 dark:text-gray-400">
                    Section: {{ $this->selectedQuiz->section->name ?? 'N/A' }}
                </p>

                {{-- Progress Bar --}}
                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2 mt-4">
                    <div class="bg-primary-600 h-2 rounded-full transition-all duration-500"
                        style="width: {{ ($this->currentQuestionIndex + 1) / count($this->questions) * 100 }}%">
                    </div>
                </div>
            </div>

            {{-- Current Question --}}
            <div class="p-6 bg-white dark:bg-gray-800 rounded-lg shadow-md mt-6">
                @php
                    $question = $this->questions[$this->currentQuestionIndex] ?? null;
                @endphp

                @if ($question)
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                        Question {{ $this->currentQuestionIndex + 1 }} of {{ count($this->questions) }}
                    </h2>
                    <p class="text-gray-800 dark:text-gray-300 mb-6">{{ $question->content }}</p>

                    {{-- Choices --}}
                    <div class="space-y-3">
                        @foreach (['a', 'b', 'c', 'd'] as $option)
                            <label class="flex items-center gap-3 p-3 border rounded-lg cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                                <input type="radio" wire:model="answers.{{ $question->id }}" value="{{ $option }}"
                                    class="text-primary-600 focus:ring-primary-500" />
                                <span class="text-gray-700 dark:text-gray-300">
                                    {{ $question->$option }}
                                </span>
                            </label>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Navigation Buttons --}}
            <div class="flex justify-between mt-6">
                <x-filament::button wire:click="previousQuestion" color="gray" :disabled="$this->currentQuestionIndex === 0">
                    Previous
                </x-filament::button>

                @if ($this->currentQuestionIndex < count($this->questions) - 1)
                    <x-filament::button wire:click="nextQuestion" color="primary">
                        Next
                    </x-filament::button>
                @else
                    <x-filament::button wire:click="submitTest" color="success">
                        Submit Test
                    </x-filament::button>
                @endif
            </div>
        @else
            {{-- Quiz Selection --}}
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

    </div>
</x-filament-panels::page>
