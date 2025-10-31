<x-filament-panels::page>
    {{-- If no test selected yet --}}
    @if (!$selectedTest)
    <div class="space-y-6">
        @forelse ($tests as $test)
        <div class="p-5 rounded-xl shadow-sm border border-gray-200 bg-white dark:bg-gray-900">
            <div class="flex items-center justify-between">
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
        </div>
        @empty
        <p class="text-gray-500 dark:text-gray-400 text-center">
            No active tests available.
        </p>
        @endforelse
    </div>
    @else
    {{-- Test questions --}}
    <div class="space-y-8">
        <div class="p-6 rounded-xl shadow-md border border-gray-200 bg-white dark:bg-gray-900">
            <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-2">
                {{ $selectedTest->name ?? 'Test' }}
            </h2>
            <p class="text-sm text-gray-500">
                Answer all questions carefully and click <strong>Submit</strong> when done.
            </p>
        </div>

        <form wire:submit.prevent="submit" class="space-y-6">
            @foreach ($questions as $index => $question)
            <div class="p-5 rounded-lg border border-gray-200 bg-white dark:bg-gray-800">
                <p class="font-semibold text-gray-900 dark:text-gray-100">
                    {{ $index + 1 }}. {{ $question->question }}
                </p>

                <div class="mt-3 space-y-2">
                    @foreach ($question->options as $option)
                    <label class="flex items-center space-x-2 cursor-pointer">
                        <input type="radio"
                            wire:model="answers.{{ $question->id }}"
                            value="{{ $option->id }}"
                            class="text-primary-600 focus:ring-primary-500">
                        <span class="text-gray-700 dark:text-gray-300">{{ $option->text }}</span>
                    </label>
                    @endforeach
                </div>
            </div>
            @endforeach

            <div class="flex justify-between pt-4">
                <x-filament::button color="secondary" wire:click="$set('selectedTest', null)">
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