<x-filament-panels::page panel-id="member">
    <div class="space-y-6">
        <h1 class="text-2xl font-semibold">Take Test</h1>

        {{-- Quiz list --}}
        <div>
            <h2 class="text-lg font-medium mb-2">Available quizzes</h2>

            @if($quizzes->isEmpty())
            <p class="text-gray-500">No quizzes available for your assigned sections/certifications.</p>
            @else
            <div class="grid gap-3 md:grid-cols-2">
                @foreach($quizzes as $quiz)
                <div class="p-3 rounded-lg border bg-white dark:bg-gray-800">
                    <div class="flex justify-between items-start">
                        <div>
                            <div class="font-semibold">{{ $quiz->title }}</div>
                            <div class="text-xs text-gray-500">Section: {{ $quiz->section->name ?? 'N/A' }}</div>
                        </div>
                        <div>
                            <x-filament::button size="sm" color="primary" wire:click="selectQuiz({{ $quiz->id }})">
                                Start Test
                            </x-filament::button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>

        {{-- Selected quiz --}}
        @if($selectedQuiz)
        <div class="p-4 rounded-lg border bg-white dark:bg-gray-800">
            <h3 class="text-lg font-semibold mb-2">{{ $selectedQuiz->title }}</h3>

            @if($questions->isEmpty())
            <p class="text-sm text-gray-500">No questions available for this quiz.</p>
            @else
            <form wire:submit.prevent="submit">
                @foreach($questions as $idx => $question)
                <div class="mb-4">
                    <div class="font-medium mb-1">Q{{ $loop->iteration }}. {{ $question->question }}</div>

                    @foreach($question->answers as $answer)
                    @php
                    $isSelected = isset($answers[$question->id]) && (string)$answers[$question->id] === (string)$answer->id;
                    $showResult = isset($result);
                    $correct = (bool) $answer->is_checked;
                    @endphp

                    <label class="flex items-center space-x-2 block p-2 rounded border mb-1
                                        {{ $showResult
                                            ? ($correct ? 'bg-green-50 border-green-200' : ($isSelected ? 'bg-red-50 border-red-200' : ''))
                                            : 'hover:bg-gray-50' }}">
                        <input type="radio" wire:model="answers.{{ $question->id }}" value="{{ $answer->id }}" class="form-radio" />
                        <span class="ml-2">{{ $answer->answer }}</span>
                    </label>
                    @endforeach

                    {{-- optional explanation after submit --}}
                    @if(isset($result) && $question->explanation)
                    <div class="text-sm text-gray-600 mt-1">Explanation: {{ $question->explanation }}</div>
                    @endif
                </div>
                @endforeach

                <div class="flex items-center gap-3">
                    <x-filament::button type="submit">Submit</x-filament::button>

                    @if(isset($result))
                    <div class="ml-4 text-sm">
                        Score: <span class="font-semibold">{{ $result['score'] }}%</span>
                        ({{ $result['correct'] }}/{{ $result['total'] }})
                    </div>
                    @endif
                </div>
            </form>
            @endif
        </div>
        @endif
    </div>
</x-filament-panels::page>