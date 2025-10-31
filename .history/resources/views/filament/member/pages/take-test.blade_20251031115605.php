<x-filament-panels::page panel-id="member">
    @if (!$selectedTest)
    <div class="space-y-6">
        @forelse ($this->tests as $test)
        <div class="p-5 rounded-xl shadow-sm border border-gray-200 bg-white dark:bg-gray-900">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                        {{ $test->name ?? 'Untitled Test' }}
                    </h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        {{ $test->is_active ? 'Active' : 'Inactive' }}
                    </p>
                </div>
                <x-filament::button color="primary" wire:click="selectTest({{ $test->id }})">
                    Start Test
                </x-filament::button>
            </div>
        </div>
        @empty
        <p class="text-gray-500 dark:text-gray-400 text-center">
            No tests available.
        </p>
        @endforelse
    </div>
    @else
    <form wire:submit.prevent="submit">
        <div class="space-y-6">
            @foreach ($questions as $question)
            <div class="p-4 rounded-lg bg-white shadow-sm">
                <p class="font-semibold">{{ $loop->iteration }}. {{ $question->question }}</p>
                @foreach ($question->options as $option)
                <label class="block mt-2">
                    <input type="radio" wire:model="answers.{{ $question->id }}" value="{{ $option->id }}" />
                    {{ $option->text }}
                </label>
                @endforeach
            </div>
            @endforeach
        </div>

        <div class="mt-6 flex justify-between">
            <x-filament::button color="secondary" wire:click="$set('selectedTest', null)">
                Back
            </x-filament::button>
            <x-filament::button type="submit" color="primary">
                Submit Test
            </x-filament::button>
        </div>
    </form>
    @endif
</x-filament-panels::page>