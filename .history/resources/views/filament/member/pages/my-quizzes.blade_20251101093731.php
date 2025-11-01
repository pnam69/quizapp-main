<x-filament-panels::page>
    <div class="space-y-6">
        @if (!$selectedQuiz)
        {{-- Quiz List View --}}
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <div class="flex justify-between items-center">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">
                            My Quizzes
                        </h2>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                            View and take your created quizzes
                        </p>
                    </div>
                    <x-filament::button
                        color="primary"
                        tag="a"
                        href="{{ route('filament.member.pages.create-my-quiz') }}"
                        icon="heroicon-o-plus">
                        Create New Quiz
                    </x-filament::button>
                </div>
            </div>

            <div class="p-6">
                @forelse ($quizzes as $quiz)
                <div class="mb-4 p-4 border border-gray-200 dark:border-gray-700 rounded-lg hover:shadow-md transition-shadow">
                    <div class="flex justify-between items-start">
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                {{ $quiz->title }}
                            </h3>
                            @if ($quiz->description)
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                {{ $quiz->description }}
                            </p>
                            @endif
                            <div class="flex gap-4 mt-2 text-sm text-gray-500 dark:text-gray-400">
                                <span>
                                    📊 {{ count($quiz->questions ?? []) }} question(s)
                                </span>
                                <span>
                                    📅 Created {{ $quiz->created_at->diffForHumans() }}
                                </span>
                            </div>
                        </div>
                        <div class="flex gap-2 ml-4">
                            <x-filament::button
                                color="primary"
                                wire:click="selectQuiz({{ $quiz->id }})"
                                size="sm">
                                Take Quiz
                            </x-filament::button>
                            <x-filament::button
                                color="danger"
                                wire:click="deleteQuiz({{ $quiz->id }})"
                                wire:confirm="Are you sure you want to delete this quiz?"
                                size="sm"
                                icon="heroicon-o-trash">
                            </x-filament::button>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-12">
                    <div class="text-gray-400 dark:text-gray-600 mb-4">
                        <svg class="mx-auto h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">
                        No quizzes yet
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-4">
                        Get started by creating your first quiz!
                    </p>
                    <x-filament::button
                        color="primary"
                        tag="a"
                        href="{{ route('filament.member.pages.create-my-quiz') }}">
                        Create Your First Quiz
                    </x-filament::button>
                </div>
                @endforelse
            </div>
        </div>
        @else
        {{-- Quiz Taking View --}}
        @if (!$showResults)
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <div class="flex justify-between items-center">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">
                            {{ $selectedQuiz->title }}
                        </h2>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                            Question {{ $currentQuestionIndex + 1 }} of {{ $totalQuestions }}
                        </p>
                    </div>
                    <x-filament::button
                        color="gray"
                        wire:click="resetQuiz"
                        size="sm">
                        Exit Quiz
                    </x-filament::button>
                </div>
            </div>

            @php
            $currentQuestion = $this->getCurrentQuestion();
            @endphp

            @if ($currentQuestion)
            <div class="p-6">
                {{-- Progress Bar --}}
                <div class="mb-6">
                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                        <div class="bg-primary-600 h-2 rounded-full transition-all"
                            style="width: {{ (($currentQuestionIndex + 1) / $totalQuestions) * 100 }}%">
                        </div>
                    </div>
                </div>

                {{-- Question --}}
                <div class="mb-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                        {{ $currentQuestion['question_text'] }}
                    </h3>

                    {{-- Options --}}
                    <div class="space-y-3">
                        @foreach ($currentQuestion['options'] as $optionIndex => $option)
                        @php
                        $isSelected = $this->getSelectedAnswer() === $optionIndex;
                        @endphp
                        <label class="flex items-start p-4 border-2 rounded-lg cursor-pointer transition-all
                                            {{ $isSelected 
                                                ? 'border-primary-500 bg-primary-50 dark:bg-primary-900/20' 
                                                : 'border-gray-200 dark:border-gray-700 hover:border-gray-300 dark:hover:border-gray-600' 
                                            }}">
                            <input
                                type="radio"
                                name="question_{{ $currentQuestionIndex }}"
                                wire:click="answerQuestion({{ $optionIndex }})"
                                {{ $isSelected ? 'checked' : '' }}
                                class="mt-1 mr-3 text-primary-600">
                            <span class="flex-1 text-gray-900 dark:text-gray-100">
                                {{ $option['option_text'] }}
                            </span>
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- Navigation Buttons --}}
                <div class="flex justify-between items-center pt-6 border-t border-gray-200 dark:border-gray-700">
                    <x-filament::button
                        color="gray"
                        wire:click="previousQuestion"
                        :disabled="$currentQuestionIndex === 0">
                        Previous
                    </x-filament::button>

                    <div class="text-sm text-gray-600 dark:text-gray-400">
                        {{ count($answers) }} / {{ $totalQuestions }} answered
                    </div>

                    @if ($currentQuestionIndex < $totalQuestions - 1)
                        <x-filament::button
                        color="primary"
                        wire:click="nextQuestion">
                        Next
                        </x-filament::button>
                        @else
                        <x-filament::button
                            color="success"
                            wire:click="submitQuiz">
                            Submit Quiz
                        </x-filament::button>
                        @endif
                </div>
            </div>
            @endif
        </div>
        @else
        {{-- Results View --}}
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
            <div class="p-6 text-center">
                <div class="mb-6">
                    @if ($score >= 80)
                    <div class="text-6xl mb-4">🎉</div>
                    <h2 class="text-2xl font-bold text-green-600 dark:text-green-400">
                        Excellent Work!
                    </h2>
                    @elseif ($score >= 60)
                    <div class="text-6xl mb-4">👍</div>
                    <h2 class="text-2xl font-bold text-blue-600 dark:text-blue-400">
                        Good Job!
                    </h2>
                    @else
                    <div class="text-6xl mb-4">💪</div>
                    <h2 class="text-2xl font-bold text-orange-600 dark:text-orange-400">
                        Keep Practicing!
                    </h2>
                    @endif
                </div>

                <div class="mb-8">
                    <div class="text-5xl font-bold text-gray-900 dark:text-gray-100 mb-2">
                        {{ $score }}%
                    </div>
                    <p class="text-gray-600 dark:text-gray-400">
                        You answered {{ array_sum(array_map(function($questionIndex) {
                                    $question = $this->selectedQuiz->questions[$questionIndex];
                                    $selectedOptionIndex = $this->answers[$questionIndex];
                                    return isset($question['options'][$selectedOptionIndex]) && 
                                           ($question['options'][$selectedOptionIndex]['is_correct'] ?? false) ? 1 : 0;
                                }, array_keys($this->selectedQuiz->questions))) }} out of {{ $totalQuestions }} questions correctly
                    </p>
                </div>

                {{-- Review Answers --}}
                <div class="mb-6 text-left max-w-3xl mx-auto">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                        Review Your Answers
                    </h3>
                    @foreach ($selectedQuiz->questions as $questionIndex => $question)
                    @php
                    $selectedOptionIndex = $answers[$questionIndex] ?? null;
                    $isCorrect = false;
                    if ($selectedOptionIndex !== null) {
                    $isCorrect = $question['options'][$selectedOptionIndex]['is_correct'] ?? false;
                    }
                    @endphp
                    <div class="mb-4 p-4 border rounded-lg {{ $isCorrect ? 'border-green-300 bg-green-50 dark:bg-green-900/20' : 'border-red-300 bg-red-50 dark:bg-red-900/20' }}">
                        <div class="flex items-start gap-2 mb-2">
                            <span class="text-xl">{{ $isCorrect ? '✅' : '❌' }}</span>
                            <div class="flex-1">
                                <p class="font-medium text-gray-900 dark:text-gray-100">
                                    {{ $questionIndex + 1 }}. {{ $question['question_text'] }}
                                </p>
                                @if ($selectedOptionIndex !== null)
                                <p class="text-sm mt-2">
                                    <span class="text-gray-600 dark:text-gray-400">Your answer:</span>
                                    <span class="{{ $isCorrect ? 'text-green-700 dark:text-green-300' : 'text-red-700 dark:text-red-300' }}">
                                        {{ $question['options'][$selectedOptionIndex]['option_text'] }}
                                    </span>
                                </p>
                                @endif
                                @if (!$isCorrect)
                                @foreach ($question['options'] as $option)
                                @if ($option['is_correct'])
                                <p class="text-sm mt-1">
                                    <span class="text-gray-600 dark:text-gray-400">Correct answer:</span>
                                    <span class="text-green-700 dark:text-green-300 font-medium">
                                        {{ $option['option_text'] }}
                                    </span>
                                </p>
                                @endif
                                @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="flex gap-3 justify-center">
                    <x-filament::button
                        color="primary"
                        wire:click="selectQuiz({{ $selectedQuiz->id }})">
                        Retake Quiz
                    </x-filament::button>
                    <x-filament::button
                        color="gray"
                        wire:click="resetQuiz">
                        Back to My Quizzes
                    </x-filament::button>
                </div>
            </div>
        </div>
        @endif
        @endif
    </div>
</x-filament-panels::page>