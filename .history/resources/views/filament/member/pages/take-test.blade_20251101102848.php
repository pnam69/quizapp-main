<x-filament-panels::page>
    <div class="max-w-7xl mx-auto space-y-6">
        @if (!$selectedTest)
        {{-- Test List View --}}
        <div class="bg-gradient-to-r from-blue-500 to-indigo-600 dark:from-blue-600 dark:to-indigo-700 rounded-xl shadow-lg p-8 text-white mb-6">
            <div class="flex items-center gap-4 mb-2">
                <div class="bg-white/20 backdrop-blur-sm rounded-lg p-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-3xl font-bold">Available Tests</h1>
                    <p class="text-blue-100 mt-1">Select a test to begin your assessment</p>
                </div>
            </div>
            <div class="flex gap-4 text-sm mt-4">
                <div class="bg-white/10 backdrop-blur-sm rounded-lg px-3 py-2">
                    📝 {{ count($tests) }} Test{{ count($tests) !== 1 ? 's' : '' }} Available
                </div>
            </div>
        </div>

        <div class="grid md:grid-cols-2 gap-6">
            @forelse ($tests as $test)
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden border-2 border-gray-200 dark:border-gray-700 hover:border-blue-400 dark:hover:border-blue-600 transition-all duration-200 group">
                <div class="p-6">
                    <div class="flex items-start gap-4">
                        <div class="bg-gradient-to-br from-blue-500 to-indigo-600 text-white rounded-lg p-3 shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                                {{ $test->name ?? 'Untitled Test' }}
                            </h3>
                            <div class="flex items-center gap-2 mt-3">
                                <div class="inline-flex items-center gap-1.5 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 px-3 py-1 rounded-full text-sm font-medium">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ is_string($test->question_ids) ? count(json_decode($test->question_ids)) : count($test->question_ids) }} Questions
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-6">
                        <x-filament::button
                            color="primary"
                            wire:click="selectTest({{ $test->id }})"
                            class="w-full"
                            size="lg"
                            icon="heroicon-o-play">
                            Start Test
                        </x-filament::button>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-2">
                <div class="text-center py-20">
                    <div class="mb-6">
                        <div class="mx-auto w-24 h-24 bg-gradient-to-br from-blue-100 to-indigo-100 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-full flex items-center justify-center">
                            <svg class="w-12 h-12 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-2">
                        No Tests Available
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400">
                        There are currently no active tests to take.
                    </p>
                </div>
            </div>
            @endforelse
        </div>
        @else
        {{-- Test Taking View --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
            <div class="bg-gradient-to-r from-blue-500 to-indigo-600 dark:from-blue-600 dark:to-indigo-700 p-6 text-white">
                <div class="flex justify-between items-center">
                    <div>
                        <h2 class="text-2xl font-bold mb-1">
                            {{ $selectedTest->name ?? 'Test' }}
                        </h2>
                        @if (empty($results))
                        <p class="text-blue-100">
                            Answer all questions carefully and click Submit when done
                        </p>
                        @else
                        @php
                        $total = count($questions);
                        $correct = collect($results)->where('isCorrect', true)->count();
                        $score = $total ? round(($correct / $total) * 100, 2) : 0;
                        @endphp
                        <p class="text-blue-100 text-lg font-semibold">
                            Score: <span class="text-green-300">{{ $score }}%</span> ({{ $correct }}/{{ $total }} correct)
                        </p>
                        @endif
                    </div>
                    <x-filament::button
                        color="white"
                        wire:click="resetTest"
                        outlined
                        icon="heroicon-o-x-mark">
                        Exit Test
                    </x-filament::button>
                </div>
            </div>

            <div class="p-8">
                @if (!empty($results))
                {{-- Results Summary --}}
                <div class="grid md:grid-cols-3 gap-4 mb-8">
                    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-xl p-6 border-2 border-blue-200 dark:border-blue-800">
                        <div class="flex items-center gap-3">
                            <div class="bg-blue-500 text-white rounded-lg p-3">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <div class="text-3xl font-bold text-blue-900 dark:text-blue-100">{{ $correct }}</div>
                                <div class="text-sm text-blue-700 dark:text-blue-300">Correct</div>
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
                                <div class="text-3xl font-bold text-red-900 dark:text-red-100">{{ $total - $correct }}</div>
                                <div class="text-sm text-red-700 dark:text-red-300">Incorrect</div>
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
                                <div class="text-sm text-purple-700 dark:text-purple-300">Score</div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <form wire:submit.prevent="submit" class="space-y-6">
                    @foreach ($questions as $index => $question)
                    @php
                    $letters = ['A', 'B', 'C', 'D', 'E', 'F'];
                    @endphp
                    <div class="border-2 rounded-xl overflow-hidden border-gray-200 dark:border-gray-700">
                        <div class="p-6 bg-white dark:bg-gray-800">
                            <div class="flex items-start gap-3 mb-4">
                                <div class="bg-blue-500 text-white rounded-full w-10 h-10 flex items-center justify-center font-bold text-lg shrink-0">
                                    {{ $index + 1 }}
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 flex-1 pt-1">
                                    {{ $question->question }}
                                </h3>
                            </div>

                            <div class="space-y-3">
                                @foreach ($question->answers as $optionIndex => $option)
                                <label class="flex items-start p-4 border-2 rounded-xl cursor-pointer transition-all duration-200
                                              border-gray-200 dark:border-gray-700 hover:border-blue-300 dark:hover:border-blue-600
                                              peer-checked:border-blue-500 peer-checked:bg-blue-50 dark:peer-checked:bg-blue-900/30 shadow-sm">
                                    <input type="radio"
                                        wire:model="answers.{{ $question->id }}"
                                        value="{{ $option->id }}"
                                        class="sr-only peer"
                                        {{ isset($results[$question->id]) ? 'disabled' : '' }}>

                                    <div class="flex items-center gap-4 w-full">
                                        <div class="shrink-0 w-10 h-10 rounded-full border-2 flex items-center justify-center font-bold text-sm
                                                    border-gray-300 dark:border-gray-600 text-gray-500 dark:text-gray-400
                                                    peer-checked:border-blue-500 peer-checked:bg-blue-500 peer-checked:text-white">
                                            {{ $letters[$optionIndex] ?? $optionIndex + 1 }}
                                        </div>
                                        <span class="flex-1 text-base
                                                     peer-checked:text-gray-900 dark:peer-checked:text-gray-100">
                                            {{ $option->answer }}
                                        </span>
                                    </div>
                                </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endforeach

                    <div class="flex justify-between items-center pt-6 border-t-2 border-gray-200 dark:border-gray-700">
                        <x-filament::button
                            color="gray"
                            wire:click="resetTest"
                            outlined
                            icon="heroicon-o-arrow-left"
                            size="lg">
                            Back to Tests
                        </x-filament::button>

                        @if (empty($results))
                        <x-filament::button
                            color="success"
                            type="submit"
                            icon="heroicon-o-check-circle"
                            size="lg">
                            Submit Test
                        </x-filament::button>
                        @else
                        <x-filament::button
                            color="primary"
                            wire:click="selectTest({{ $selectedTest->id }})"
                            icon="heroicon-o-arrow-path"
                            size="lg">
                            Retake Test
                        </x-filament::button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
        @endif
    </div>
</x-filament-panels::page>