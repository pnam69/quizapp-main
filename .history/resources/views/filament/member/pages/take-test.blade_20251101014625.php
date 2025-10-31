<x-filament-panels::page>
    @if (!$selectedTest)
    <div class="space-y-6">
        @forelse ($tests as $test)
        <div class="p-5 rounded-xl shadow-sm border border-gray-200 bg-white dark:bg-gray-900 flex justify-between items-center hover:shadow-md transition">
            <div>
                <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                    {{ $test->name ?? 'Untitled Test' }}
                </h2>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Questions: {{ $test->questions()->count() }}
                </p>
            </div>
            <x-filament::button color="primary" wire:click="selectTest({{ $test->id }})">
                Start Test
            </x-filament::button>
        </div>
        @empty
        <p class="text-gray-500 dark:text-gray-400 text-center">
            No active tests available.
        </p>
        @endforelse
    </div>
    @else
    <div class="space-y-6">
        <div class="p-6 rounded-xl shadow-md border border-gray-200 bg-white dark:bg-gray-900">
            <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-2">
                {{ $selectedTest->name ?? 'Test' }}
            </h2>
            @if (empty($results))
            <p class="text-sm text-gray-500">
                Answer all questions carefully and click <strong>Submit</strong> when done.
            </p>
            @else
            @php
            $total = count($questions);
            $correct = collect($results)->where('isCorrect', true)->count();
            $score = $total ? round(($correct / $total) * 100, 2) : 0;
            @endphp
            <p class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                You scored <span class="text-green-600 dark:text-green-400">{{ $score }}%</span> ({{ $correct }}/{{ $total }})
            </p>
            @endif
        </div>

        <form wire:submit.prevent="submit" class="space-y-6">
            @foreach ($questions as $index => $question)
            @php
            $isAnswered = isset($results[$question->id]);
            $chosen = $results[$question->id]['chosen'] ?? null;
            $correct = $results[$question->id]['correct'] ?? null;
            @endphp
            <div class="p-5 rounded-lg border border-gray-200 bg-white dark:bg-gray-800 shadow-sm">
                <p class="font-semibold text-gray-900 dark:text-gray-100 mb-3">
                    {{ $index + 1 }}. {{ $question->question }}
                </p>
                <div class="space-y-2">
                    @foreach ($question->options as $option)
                    @php
                    $optionClass = '';
                    if ($isAnswered) {
                    if ($option->id == $correct) {
                    $optionClass = 'bg-green-100 dark:bg-green-700 border-green-400';
                    } elseif ($option->id == $chosen) {
                    $optionClass = 'bg-red-100 dark:bg-red-700 border-red-400';
                    }
                    }
                    @endphp
                    <label class="flex items-center space-x-2 cursor-pointer border px-3 py-2 rounded {{ $optionClass }}">
                        <input type="radio"
                            wire:model="answers.{{ $question->id }}"
                            value="{{ $option->id }}"
                            class="text-primary-600 focus:ring-primary-500"
                            {{ $isAnswered ? 'disabled' : '' }}>
                        <span class="text-gray-700 dark:text-gray-300">{{ $option->answer }}</span>
                    </label>
                    @endforeach
                </div>
            </div>
            @endforeach

            <div class="flex justify-between pt-4">
                <x-filament::button color="secondary" wire:click="resetTest">
                    Back
                </x-filament::button>
                @if (empty($results))
                <x-filament::button color="success" type="submit">
                    Submit Test
                </x-filament::button>
                @endif
            </div>
        </form>
    </div>
    @endif
</x-filament-panels::page>