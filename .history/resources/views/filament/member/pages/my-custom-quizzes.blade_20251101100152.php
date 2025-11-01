<x-filament-panels::page>
    <div class="max-w-7xl mx-auto space-y-6">
        @if (!$selectedQuiz)
        {{-- Quiz List View --}}
        <div class="bg-gradient-to-r from-indigo-500 to-purple-600 dark:from-indigo-600 dark:to-purple-700 rounded-xl shadow-lg p-8 text-white mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <div class="flex items-center gap-4 mb-2">
                        <div class="bg-white/20 backdrop-blur-sm rounded-lg p-3">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold">My Quiz Library</h1>
                            <p class="text-indigo-100 mt-1">Access and practice with your custom quizzes</p>
                        </div>
                    </div>
                    <div class="flex gap-4 text-sm mt-4">
                        <div class="bg-white/10 backdrop-blur-sm rounded-lg px-3 py-2">
                            📚 {{ count($quizzes) }} Quiz{{ count($quizzes) !== 1 ? 'zes' : '' }}
                        </div>
                        <div class="bg-white/10 backdrop-blur-sm rounded-lg px-3 py-2">
                            🎯 Ready to Practice
                        </div>
                    </div>
                </div>
                <x-filament::button
                    color="white"
                    tag="a"
                    href="{{ route('filament.member.pages.create-my-quiz') }}"
                    icon="heroicon-o-plus"
                    size="lg">
                    Create New Quiz
                </x-filament::button>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
            @forelse ($quizzes as $index => $quiz)
            <div class="p-6 border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-all duration-200 group">
                <div class="flex items-start justify-between gap-6">
                    <div class="flex-1 min-w-0">
                        <div class="flex items-start gap-4">
                            <div class="bg-gradient-to-br from-blue-500 to-indigo-600 text-white rounded-lg p-3 shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                                    {{ $quiz->title }}
                                </h3>
                                @if ($quiz->description)
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-2 line-clamp-2">
                                    {{ $quiz->description }}
                                </p>
                                @endif
                                <div class="flex flex-wrap gap-3 mt-3">
                                    <div class="inline-flex items-center gap-1.5 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 px-3 py-1 rounded-full text-sm font-medium">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                                        </svg>
                                        {{ count($quiz->questions ?? []) }} Questions
                                    </div>
                                    <div class="inline-flex items-center gap-1.5 bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300 px-3 py-1 rounded-full text-sm font-medium">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ $quiz->created_at->diffForHumans() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex gap-2 shrink-0">
                        <x-filament::button
                            color="primary"
                            wire:click="selectQuiz({{ $quiz->id }})"
                            size="lg"
                            icon="heroicon-o-play">
                            Start Quiz
                        </x-filament::button>
                        <x-filament::button
                            color="danger"
                            wire:click="deleteQuiz({{ $quiz->id }})"
                            wire:confirm="Are you sure you want to delete this quiz? This action cannot be undone."
                            outlined
                            size="lg"
                            icon="heroicon-o-trash"
                            tooltip="Delete Quiz">
                        </x-filament::button>
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center py-20">
                <div class="mb-6">
                    <div class="mx-auto w-24 h-24 bg-gradient-to-br from-blue-100 to-indigo-100 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-full flex items-center justify-center">
                        <svg class="w-12 h-12 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-2">
                    No Quizzes Yet
                </h3>
                <p class="text-gray-600 dark:text-gray-400 mb-6 max-w-md mx-auto">
                    Start your learning journey by creating your first custom quiz! Test your knowledge and track your progress.
                </p>
                <x-filament::button
                    color="primary"
                    tag="a"
                    href="{{ route('filament.member.pages.create-my-quiz') }}"
                    size="lg"
                    icon="heroicon-o-plus">
                    Create Your First Quiz
                </x-filament::button>
            </div>
            @endforelse
        </div>
        @else
        {{-- Quiz Taking View --}}
        @if (!$showResults)
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
            <div class="bg-gradient-to-r from-blue-500 to-indigo-600 dark:from-blue-600 dark:to-indigo-700 p-6 text-white">
                <div class="flex justify-between items-center">
                    <div>
                        <h2 class="text-2xl font-bold mb-1">
                            {{ $selectedQuiz->title }}
                        </h2>
                        <p class="text-blue-100 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            Question {{ $currentQuestionIndex + 1 }} of {{ $totalQuestions }}
                        </p>
                    </div>
                    <x-filament::button
                        color="white"
                        wire:click="resetQuiz"
                        outlined
                        icon="heroicon-o-x-mark">
                        Exit Quiz
                    </x-filament::button>
                </div>
            </div>

            @php
            $currentQuestion = $this->getCurrentQuestion();
            $progressPercentage = $totalQuestions > 0 ? (($currentQuestionIndex + 1) / $totalQuestions) * 100 : 0;
            @endphp

            @if ($currentQuestion)
            <div class="p-8">
                {{-- Progress Bar --}}
                <div class="mb-8">
                    <div class="flex justify-between text-sm text-gray-600 dark:text-gray-400 mb-2">
                        <span class="font-medium">Progress</span>
                        <span class="font-medium">{{ round($progressPercentage) }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-3 overflow-hidden">
                        <div class="bg-gradient-to-r from-blue-500 to-indigo-600 h-3 rounded-full transition-all duration-300 ease-out shadow-sm"
                            style="width: {{ $progressPercentage }}%">
                        </div>
                    </div>
                </div>

                {{-- Question Card --}}
                <div class="mb-8 bg-gradient-to-br from-gray-50 to-blue-50 dark:from-gray-700 dark:to-blue-900/20 rounded-xl p-6 border-2 border-blue-200 dark:border-blue-800">
                    <div class="flex items-start gap-3">
                        <div class="bg-blue-500 text-white rounded-full w-10 h-10 flex items-center justify-center font-bold text-lg shrink-0">
                            {{ $currentQuestionIndex + 1 }}
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100 flex-1 pt-1">
                            {{ $currentQuestion['question_text'] }}
                        </h3>
                    </div>
                </div>

                {{-- Answer Options --}}
                <div class="space-y-3 mb-8">
                    @foreach ($currentQuestion['options'] as $optionIndex => $option)
                    @php
                    $isSelected = $this->getSelectedAnswer() === $optionIndex;
                    $letters = ['A', 'B', 'C', 'D', 'E', 'F'];
                    @endphp
                    <label class="flex items-start p-5 border-2 rounded-xl cursor-pointer transition-all duration-200 group
                                        {{ $isSelected 
                                            ? 'border-blue-500 bg-blue-50 dark:bg-blue-900/30 shadow-md scale-[1.02]' 
                                            : 'border-gray-200 dark:border-gray-700 hover:border-blue-300 dark:hover:border-blue-600 hover:shadow-sm hover:scale-[1.01]' 
                                        }}">
                        <div class="flex items-center gap-4 w-full">
                            <div class="shrink-0 w-10 h-10 rounded-full border-2 flex items-center justify-center font-bold text-sm
                                                {{ $isSelected 
                                                    ? 'border-blue-500 bg-blue-500 text-white' 
                                                    : 'border-gray-300 dark:border-gray-600 text-gray-500 dark:text-gray-400 group-hover:border-blue-400 group-hover:text-blue-500' 
                                                }}">
                                {{ $letters[$optionIndex] ?? $optionIndex + 1 }}
                            </div>
                            <input
                                type="radio"
                                name="question_{{ $currentQuestionIndex }}"
                                wire:click="answerQuestion({{ $optionIndex }})"
                                {{ $isSelected ? 'checked' : '' }}
                                class="sr-only">
                            <span class="flex-1 text-base {{ $isSelected ? 'text-gray-900 dark:text-gray-100 font-medium' : 'text-gray-700 dark:text-gray-300' }}">
                                {{ $option['option_text'] }}
                            </span>
                            @if ($isSelected)
                            <svg class="w-6 h-6 text-blue-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            @endif
                        </div>
                    </label>
                    @endforeach
                </div>

                {{-- Navigation Buttons --}}
                <div class="flex justify-between items-center pt-6 border-t-2 border-gray-200 dark:border-gray-700">
                    <x-filament::button
                        color="gray"
                        wire:click="previousQuestion"
                        :disabled="$currentQuestionIndex === 0"
                        outlined
                        icon="heroicon-o-arrow-left"
                        size="lg">
                        Previous
                    </x-filament::button>

                    <div class="text-center">
                        <div class="inline-flex items-center gap-2 bg-gray-100 dark:bg-gray-700 px-4 py-2 rounded-lg">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                                {{ count($answers) }} / {{ $totalQuestions }} Answered
                            </span>
                        </div>
                    </div>

                    @if ($currentQuestionIndex < $totalQuestions - 1)
                        <x-filament::button
                        color="primary"
                        wire:click="nextQuestion"
                        icon="heroicon-o-arrow-right"
                        icon-position="after"
                        size="lg">
                        Next Question
                        </x-filament::button>
                        @else
                        <x-filament::button
                            color="success"
                            wire:click="submitQuiz"
                            icon="heroicon-o-check-circle"
                            size="lg">
                            Submit Quiz
                        </x-filament::button>
                        @endif
                </div>
            </div>
            @endif
        </div>
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
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
        <div class="bg-gradient-to-r from-green-500 to-emerald-600 dark:from-green-600 dark:to-emerald-700 p-8 text-white text-center">
            @php
            $correctCount = array_sum(array_map(function($questionIndex) {
            $question = $this->selectedQuiz->questions[$questionIndex];
            $selectedOptionIndex = $this->answers[$questionIndex];
            return isset($question['options'][$selectedOptionIndex]) &&
            ($question['options'][$selectedOptionIndex]['is_correct'] ?? false) ? 1 : 0;
            }, array_keys($this->selectedQuiz->questions)));
            @endphp

            <div class="mb-6">
                @if ($score >= 80)
                <div class="text-8xl mb-4 animate-bounce">🎉</div>
                <h2 class="text-4xl font-bold mb-2">
                    Excellent Work!
                </h2>
                <p class="text-green-100 text-lg">You've mastered this quiz!</p>
                @elseif ($score >= 60)
                <div class="text-8xl mb-4">👍</div>
                <h2 class="text-4xl font-bold mb-2">
                    Good Job!
                </h2>
                <p class="text-green-100 text-lg">You're on the right track!</p>
                @else
                <div class="text-8xl mb-4">💪</div>
                <h2 class="text-4xl font-bold mb-2">
                    Keep Practicing!
                </h2>
                <p class="text-green-100 text-lg">Every attempt makes you better!</p>
                @endif
            </div>

            <div class="inline-block bg-white/20 backdrop-blur-sm rounded-2xl px-8 py-6">
                <div class="text-7xl font-black mb-2">
                    {{ $score }}%
                </div>
                <div class="text-lg font-medium text-green-50">
                    {{ $correctCount }} out of {{ $totalQuestions }} correct
                </div>
            </div>
        </div>

        <div class="p-8">
            {{-- Stats Cards --}}
            <div class="grid md:grid-cols-3 gap-4 mb-8">
                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-xl p-6 border-2 border-blue-200 dark:border-blue-800">
                    <div class="flex items-center gap-3">
                        <div class="bg-blue-500 text-white rounded-lg p-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="text-3xl font-bold text-blue-900 dark:text-blue-100">{{ $correctCount }}</div>
                            <div class="text-sm text-blue-700 dark:text-blue-300">Correct Answers</div>
                        </div>
                    </div>
                </div>
                <div class="bg-gradient-to-br from-red-50 to-pink-50 dark:from-red-900/20 dark:to-pink-900/20 rounded-xl p-6 border-2 border-red-200 dark:border-red-800">
                    <div class="flex items-center gap-3">
                        <div class="bg-red-500 text-white rounded-lg p-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="text-3xl font-bold text-red-900 dark:text-red-100">{{ $totalQuestions - $correctCount }}</div>
                            <div class="text-sm text-red-700 dark:text-red-300">Incorrect Answers</div>
                        </div>
                    </div>
                </div>
                <div class="bg-gradient-to-br from-purple-50 to-pink-50 dark:from-purple-900/20 dark:to-pink-900/20 rounded-xl p-6 border-2 border-purple-200 dark:border-purple-800">
                    <div class="flex items-center gap-3">
                        <div class="bg-purple-500 text-white rounded-lg p-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="text-3xl font-bold text-purple-900 dark:text-purple-100">{{ $score }}%</div>
                            <div class="text-sm text-purple-700 dark:text-purple-300">Score Achieved</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Review Answers Section --}}
            <div class="mb-8">
                <div class="flex items-center gap-3 mb-6">
                    <div class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-lg p-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                        Review Your Answers
                    </h3>
                </div>

                <div class="space-y-4">
                    @foreach ($selectedQuiz->questions as $questionIndex => $question)
                    @php
                    $selectedOptionIndex = $answers[$questionIndex] ?? null;
                    $isCorrect = false;
                    if ($selectedOptionIndex !== null) {
                    $isCorrect = $question['options'][$selectedOptionIndex]['is_correct'] ?? false;
                    }
                    @endphp
                    <div class="border-2 rounded-xl overflow-hidden transition-all
                                        {{ $isCorrect ? 'border-green-300 dark:border-green-700' : 'border-red-300 dark:border-red-700' }}">
                        <div class="p-5 {{ $isCorrect ? 'bg-green-50 dark:bg-green-900/20' : 'bg-red-50 dark:bg-red-900/20' }}">
                            <div class="flex items-start gap-4">
                                <div class="shrink-0 w-12 h-12 rounded-full flex items-center justify-center font-bold text-lg
                                                    {{ $isCorrect ? 'bg-green-500 text-white' : 'bg-red-500 text-white' }}">
                                    {{ $isCorrect ? '✓' : '✗' }}
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-start justify-between gap-4 mb-3">
                                        <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                            <span class="text-gray-500 dark:text-gray-400">Q{{ $questionIndex + 1 }}.</span> {{ $question['question_text'] }}
                                        </p>
                                        <span class="shrink-0 px-3 py-1 rounded-full text-sm font-medium
                                                            {{ $isCorrect ? 'bg-green-200 dark:bg-green-800 text-green-800 dark:text-green-200' : 'bg-red-200 dark:bg-red-800 text-red-800 dark:text-red-200' }}">
                                            {{ $isCorrect ? 'Correct' : 'Incorrect' }}
                                        </span>
                                    </div>

                                    @if ($selectedOptionIndex !== null)
                                    <div class="mb-2">
                                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">Your Answer:</p>
                                        <div class="flex items-start gap-2 p-3 rounded-lg {{ $isCorrect ? 'bg-green-100 dark:bg-green-900/40' : 'bg-red-100 dark:bg-red-900/40' }}">
                                            <span class="font-semibold {{ $isCorrect ? 'text-green-700 dark:text-green-300' : 'text-red-700 dark:text-red-300' }}">
                                                {{ $question['options'][$selectedOptionIndex]['option_text'] }}
                                            </span>
                                        </div>
                                    </div>
                                    @endif

                                    @if (!$isCorrect)
                                    <div>
                                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">Correct Answer:</p>
                                        @foreach ($question['options'] as $option)
                                        @if ($option['is_correct'])
                                        <div class="flex items-start gap-2 p-3 bg-green-100 dark:bg-green-900/40 rounded-lg">
                                            <svg class="w-5 h-5 text-green-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            <span class="font-semibold text-green-700 dark:text-green-300">
                                                {{ $option['option_text'] }}
                                            </span>
                                        </div>
                                        @endif
                                        @endforeach
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="flex flex-wrap gap-4 justify-center pt-6 border-t-2 border-gray-200 dark:border-gray-700">
                <x-filament::button
                    color="primary"
                    wire:click="selectQuiz({{ $selectedQuiz->id }})"
                    size="lg"
                    icon="heroicon-o-arrow-path">
                    Retake Quiz
                </x-filament::button>
                <x-filament::button
                    color="gray"
                    wire:click="resetQuiz"
                    outlined
                    size="lg"
                    icon="heroicon-o-arrow-left">
                    Back to My Quizzes
                </x-filament::button>
            </div>
        </div>
    </div>
    @endif
    @endif
    </div>
</x-filament-panels::page>