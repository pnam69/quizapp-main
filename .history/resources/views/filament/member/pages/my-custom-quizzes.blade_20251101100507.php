<x-filament-panels::page>
    <div class="max-w-7xl mx-auto space-y-6">

        {{-- Quiz List View --}}
        @if (!$selectedQuiz)
            <div class="bg-gradient-to-r from-indigo-500 to-purple-600 dark:from-indigo-600 dark:to-purple-700 rounded-xl shadow-lg p-8 text-white mb-6">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="flex items-center gap-4 mb-2">
                            <div class="bg-white/20 backdrop-blur-sm rounded-lg p-3">
                                <!-- Icon SVG -->
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
                    {{-- Quiz Item --}}
                @empty
                    <div class="text-center py-20">
                        {{-- No quizzes message --}}
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
            {{-- Quiz Taking / Results View --}}
            @if (!$showResults)
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
                    {{-- Quiz Taking View content --}}
                    @php
                        $currentQuestion = $this->getCurrentQuestion();
                        $progressPercentage = $totalQuestions > 0 ? (($currentQuestionIndex + 1) / $totalQuestions) * 100 : 0;
                    @endphp

                    @if ($currentQuestion)
                        {{-- Question and Answer options --}}
                        {{-- Navigation buttons --}}
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
                    @endif
                </div>

            @else
                {{-- Results View --}}
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
                    {{-- Score, stats, and review answers --}}
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
            @endif
        @endif
    @endif

    </div>
</x-filament-panels::page>
