<x-filament-panels::page panel-id="member">
    <div class="space-y-6">
        @forelse ($this->quizzes as $quiz)
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
</x-filament-panels::page>